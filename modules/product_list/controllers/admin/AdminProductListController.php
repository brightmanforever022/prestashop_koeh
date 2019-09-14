<?php

require_once _PS_MODULE_DIR_ . 'sameproductvariant/SPVBase.php';
require_once _PS_TOOL_DIR_ . 'mpdf/mpdf.php';
require_once _PS_TOOL_DIR_ . 'php_excel/PHPExcel.php';


/**
 * Admin tab controller
 */
class AdminProductListController extends ModuleAdminController
{
    
    public function __construct()
    {
        
        $this->module = 'product_list';
        $this->bootstrap = true;
        $this->list_no_link = true;
        $this->explicitSelect = true;
        //$this->_where = 'and a.active=1';
        $this->imageType = 'jpg';
        $this->_defaultOrderBy = 'product_supplier_reference';
        $this->identifier = 'id_product';
        
        parent::__construct();

        // configure list 
        $this->className = 'Product';
        $this->table = 'product';

        $this->_select = '
            sta.quantity as total_qty, 
            group_concat(distinct concat_ws(\'=\', al.name, sa1.quantity, ps2.product_supplier_reference, pa.id_product_attribute, sa1.physical_quantity) order by al.name separator \',\') as stock, 
            id_image, s.name as supplier, ps.product_supplier_reference, ts.total_sales, 
            if(pa.id_product_attribute is null, sum(vds.quantity), sum(vdsa.quantity)) as total_sales_dbk, 
            group_concat(distinct concat(vso.exp_arrive_date, \'|\', vso.delivery) order by vso.exp_arrive_date separator \';\') as exp_delivery,
            a.wholesale_price, 
            khl_12s.total_sales AS khl_12m_sales,
            khl_6s.total_sales AS khl_6m_sales,
            dbk_s.total_sales AS dbk_sales,
            dbk_12s.total_sales AS dbk_12m_sales,
            dbk_6s.total_sales AS dbk_6m_sales,
            a.date_add, ( 
                SELECT MAX(o.date_add) 
                FROM '._DB_PREFIX_.'order_detail od
                INNER JOIN '._DB_PREFIX_.'orders o ON o.id_order = od.id_order
                WHERE a.id_product = od.product_id AND o.valid = 1
            ) AS date_last_order
        ';
        
        $id_shop = Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP? (int)$this->context->shop->id : 'a.id_shop_default';
        $this->_join = '
            JOIN `'._DB_PREFIX_.'product_shop` sa ON (a.`id_product` = sa.`id_product` AND sa.id_shop = '.$id_shop.')
            left join '.VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product vp on a.supplier_reference=vp.supplier_reference 
            left join '.VIPDRESS_DB_NAME.'.os_dbk_sale vds on vds.ps_attr_id=0 and vds.ps_product_id=vp.id_product 
            left join '. _DB_PREFIX_ . 'product_attribute pa on pa.id_product=a.id_product 
            left join '. VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product_attribute vpa on pa.supplier_reference=vpa.supplier_reference 
            left join '. VIPDRESS_DB_NAME.'.os_dbk_sale vdsa on vdsa.ps_attr_id=vpa.id_product_attribute 
            left join (select so.id, exp_arrive_date, soi.product_id, 
                group_concat(concat(ifnull(vpa1.supplier_reference, \'\'), \':\', soi.quantity-arrived_quantity) separator \',\') as delivery 
                from '.VIPDRESS_DB_NAME.'.os_supplier_order_item soi 
                inner join '.VIPDRESS_DB_NAME.'.os_supplier_order so on soi.order_id=so.id and so.order_arrived=0 
                left join '.VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product_attribute vpa1 on vpa1.id_product_attribute=soi.combination_id 
                where soi.quantity-arrived_quantity>0 
                group by so.id, soi.product_id) vso on vso.product_id=vp.id_product 
            left join ' . _DB_PREFIX_ .'stock_available sta on sta.id_product=a.id_product and sta.id_product_attribute=0 and sta.id_shop=' . $this->context->shop->id .' 
            left join ' . _DB_PREFIX_ . 'stock_available sa1 on sa1.id_product=a.id_product and sa1.id_product_attribute=pa.id_product_attribute and sa1.id_shop=' . $this->context->shop->id.' 
            left join ' . _DB_PREFIX_ . 'product_attribute_combination pac on pa.id_product_attribute=pac.id_product_attribute 
            left join ' . _DB_PREFIX_ . 'attribute_lang al on al.id_attribute=pac.id_attribute and al.id_lang=' . $this->context->language->id.' 
            left join ' . _DB_PREFIX_ . 'image i on i.id_product=a.id_product and cover=1 
            left join ' . _DB_PREFIX_ . 'product_supplier ps on a.id_product=ps.id_product and ps.id_product_attribute=0 
            left join ' . _DB_PREFIX_ . 'product_supplier ps2 on a.id_product=ps2.id_product and ps2.id_product_attribute=pa.id_product_attribute 
            left join ' . _DB_PREFIX_ . 'supplier s on s.id_supplier=ps.id_supplier'
        ;
        
        $invalidOrderStates = array(
            Configuration::get('PS_OS_CANCELED'),
            Configuration::get('PS_OS_ERROR')
        );
        
        // koehlert's total sales
        $this->_join .= '
            LEFT JOIN (
                SELECT od.product_id AS id_product, 
                    SUM(od.`product_quantity` - od.`product_quantity_refunded` - od.`product_quantity_return`) 
                        AS total_sales
                FROM `'._DB_PREFIX_.'order_detail` od
                INNER JOIN `'._DB_PREFIX_.'orders` o ON o.id_order = od.id_order
                WHERE o.current_state NOT IN('. implode(',', $invalidOrderStates) .')
                GROUP BY od.product_id
            ) ts ON ts.id_product = a.id_product
        ';
        // koehlert's 6 monthes sales
        $this->_join .= '
            LEFT JOIN (
                SELECT od.product_id AS id_product,
                    SUM(od.`product_quantity` - od.`product_quantity_refunded` - od.`product_quantity_return`)
                        AS total_sales
                FROM `'._DB_PREFIX_.'order_detail` od
                INNER JOIN `'._DB_PREFIX_.'orders` o ON o.id_order = od.id_order
                WHERE o.current_state NOT IN('. implode(',', $invalidOrderStates) .')
                    AND o.date_add > DATE_SUB(NOW(), INTERVAL 6 MONTH)
                GROUP BY od.product_id
            ) khl_6s ON khl_6s.id_product = a.id_product
        ';
        
        // koehlert's 12 monthes sales
        $this->_join .= '
            LEFT JOIN (
                SELECT od.product_id AS id_product,
                    SUM(od.`product_quantity` - od.`product_quantity_refunded` - od.`product_quantity_return`)
                        AS total_sales
                FROM `'._DB_PREFIX_.'order_detail` od
                INNER JOIN `'._DB_PREFIX_.'orders` o ON o.id_order = od.id_order
                WHERE o.current_state NOT IN('. implode(',', $invalidOrderStates) .')
                    AND o.date_add > DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY od.product_id
            ) khl_12s ON khl_12s.id_product = a.id_product
        ';
        
        // DBK's total sales
        $this->_join .= '
            LEFT JOIN (
                SELECT vdp.supplier_reference, SUM(vds.`quantity`) AS total_sales
                FROM '.VIPDRESS_DB_NAME.'.os_dbk_sale vds
                INNER JOIN '.VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product vdp
                    ON vdp.id_product = vds.ps_product_id
                WHERE
                    vds.`quantity` > 0
                    AND vds.`deleted` = 0
                GROUP BY vdp.id_product
            ) dbk_s ON dbk_s.supplier_reference = a.supplier_reference
        ';
        // DBK's 12 monthes sales
        $this->_join .= '
            LEFT JOIN (
                SELECT vdp.supplier_reference, SUM(vds.`quantity`) AS total_sales
                FROM '.VIPDRESS_DB_NAME.'.os_dbk_sale vds
                INNER JOIN '.VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product vdp
                    ON vdp.id_product = vds.ps_product_id
                WHERE
                    vds.`quantity` > 0
                    AND vds.`deleted` = 0
                    AND vds.sale_date > DATE_SUB(NOW(), INTERVAL 12 MONTH)
                GROUP BY vdp.id_product
            ) dbk_12s ON dbk_12s.supplier_reference = a.supplier_reference
        ';
        
        // DBK's 6 monthes sales
        $this->_join .= '
            LEFT JOIN (
                SELECT vdp.supplier_reference, SUM(vds.`quantity`) AS total_sales
                FROM '.VIPDRESS_DB_NAME.'.os_dbk_sale vds
                INNER JOIN '.VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product vdp
                    ON vdp.id_product = vds.ps_product_id
                WHERE
                    vds.`quantity` > 0
                    AND vds.`deleted` = 0
                    AND vds.sale_date > DATE_SUB(NOW(), INTERVAL 6 MONTH)
                GROUP BY vdp.id_product
            ) dbk_6s ON dbk_6s.supplier_reference = a.supplier_reference
        ';
        
        /*
        $this->_join = ' left join '. _DB_PREFIX_ .'product_sale ks on ks.id_product=a.id_product '.
                'left join '.self::VipdressDbNameAndPref.'product vp on a.supplier_reference=vp.supplier_reference left join '.
                self::VipdressDbName.'os_dbk_sale vds on vds.ps_attr_id=0 and vds.ps_product_id=vp.id_product '.
                'left join ' . _DB_PREFIX_ . 'product_attribute pa on pa.id_product=a.id_product '.
                'left join '.self::VipdressDbNameAndPref.'product_attribute vpa on pa.supplier_reference=vpa.supplier_reference left join '.
                self::VipdressDbName.'os_dbk_sale vdsa on vdsa.ps_attr_id=vpa.id_product_attribute '.
                
                '('.self::VipdressDbName.'os_supplier_order_item vsoi inner join '.self::VipdressDbName.
                'os_supplier_order vso on vsoi.order_id=vso.id and vso.order_arrived=0) vsoa'
                . ' left join '.self::VipdressDbNameAndPref.
                'product_attribute vpa1 on vpa1.id_product_attribute=soi.combination_id group by so.id, soi.product_id) vso on '.
                'vso.product_id=a.id_product'.
                
                'left join ' . _DB_PREFIX_ .
                'stock_available sa on sa.id_product=a.id_product and sa.id_product_attribute=0 and sa.id_shop=' . $this->context->shop->id .
                ' left join ' . _DB_PREFIX_ . 'stock_available sa1 on sa1.id_product=a.id_product and sa1.id_product_attribute=' .
                'pa.id_product_attribute and sa1.id_shop=' . $this->context->shop->id.' left join ' . _DB_PREFIX_ .
                'product_attribute_combination pac on pa.id_product_attribute=pac.id_product_attribute left join ' . _DB_PREFIX_ .
                'attribute_lang al on al.id_attribute=pac.id_attribute and al.id_lang=' . $this->context->language->id.
                ' left join ' . _DB_PREFIX_ . 'image i on i.id_product=a.id_product and cover=1 left join ' . _DB_PREFIX_ . 
                'product_supplier ps on a.id_product=ps.id_product and ps.id_product_attribute=0 left join ' . _DB_PREFIX_ . 
                'product_supplier ps2 on a.id_product=ps2.id_product and ps2.id_product_attribute=pa.id_product_attribute left join ' . _DB_PREFIX_ .
                'supplier s on s.id_supplier=ps.id_supplier';
         * 
         */
        
        $this->_group = 'group by a.id_product';

        $this->fields_list = array();
        $this->fields_list['id_product'] = array(
            'title' => $this->l('ID'),
            'align' => 'center',
            'class' => 'fixed-width-xs',
            'type' => 'int',
            'filter_key' => 'a!id_product'
        );
        $this->fields_list['id_image'] = array(
            'title' => $this->l('Image'),
            'align' => 'center',
            'callback' => 'showProductImage',
            //'image' => 'p',
            'orderby' => false,
            'filter' => false,
            'search' => false
        );
        $this->fields_list['product_supplier_reference'] = array(
            'title' => $this->l('Sku'),
            'align' => 'left',
            'filter_key' => 'ps!product_supplier_reference',
            'class' => 'base_prod_spl_ref'
        );
        $this->fields_list['date_add'] = array(
            'title' => $this->l('Created'),
            'align' => 'left',
            'filter_key' => 'a!date_add',
            'type' => 'date',
            //'class' => 'base_prod_spl_ref'
        );
        
        // reading suppliers
        $suppliers = Supplier::getSuppliers(false, 0 , false);
        $supplierList = array();
        foreach ($suppliers as $supplier)
        {
            $supplierList[$supplier['id_supplier']] = $supplier['name'];
        }
        $this->fields_list['supplier'] = array(
            'title' => $this->l('Supplier'),
            'type' => 'select',
            'list' => $supplierList,
            'filter_key' => 'ps!id_supplier',
            'filter_type' => 'int',
            'order_key' => 'supplier',
            'align' => 'left',
        );
        $this->fields_list['total_sales'] = array(
            'title' => $this->l('Sales'),
            'type' => 'int',
            'filter_key' => 'ts!total_sales',
            'order_key' => 'total_sales',
            'class' => 'khl_total_sales'
        );
        $this->fields_list['khl_12m_sales'] = array(
            'title' => $this->l('Sales,12m'),
            'type' => 'int',
            'filter_key' => 'khl_12s!total_sales',
            'order_key' => 'khl_12s!total_sales',
            //'class' => 'khl_total_sales'
        );
        $this->fields_list['khl_6m_sales'] = array(
            'title' => $this->l('Sales,6m'),
            'type' => 'int',
            'filter_key' => 'khl_6s!total_sales',
            'order_key' => 'khl_6s!total_sales',
            //'class' => 'khl_total_sales'
        );
        
        /*
         * looks like this stats incorrect?
        $this->fields_list['total_sales_dbk'] = array(
            'title' => $this->l('Sales DBK'),
            'type' => 'int',
            'order_key' => 'total_sales_dbk',
            'filter_key' => 'total_sales_dbk',
            'havingFilter' => true,
            'class' => 'dbk_total_sales'
        );
        */
        $this->fields_list['dbk_sales'] = array(
            'title' => $this->l('Sales DBK'),
            'type' => 'int',
            'filter_key' => 'dbk_s!total_sales',
            'order_key' => 'dbk_s!total_sales',
            //'class' => 'khl_total_sales'
        );
        
        $this->fields_list['dbk_12m_sales'] = array(
            'title' => $this->l('Sales DBK,12m'),
            'type' => 'int',
            'filter_key' => 'dbk_12s!total_sales',
            'order_key' => 'dbk_12s!total_sales',
            //'class' => 'khl_total_sales'
        );
        $this->fields_list['dbk_6m_sales'] = array(
            'title' => $this->l('Sales DBK,6m'),
            'type' => 'int',
            'filter_key' => 'dbk_6s!total_sales',
            'order_key' => 'dbk_6s!total_sales',
            //'class' => 'khl_total_sales'
        );
        // reading all sizes used in products
        $sizes = Db::getInstance()->s('select distinct al.id_attribute, al.name from '._DB_PREFIX_.'product_attribute_combination pac '
            . 'inner join '._DB_PREFIX_ .'attribute_lang al on al.id_attribute=pac.id_attribute and al.id_lang=' .
            $this->context->language->id.' order by name');
        
        $sizesList = [];
        foreach($sizes as $size)
        {
            $sizesList [$size['id_attribute']]= $size['name'];
        }
        
        //$this->context->smarty->assign('plmSizesList', $sizesList);
        
        $this->fields_list['stock'] = array(
            'title' => $this->l('Stock'),
            'align' => 'left',
            'filter_key' => 'al!id_attribute',
            'order_key' => 'sta!quantity',
            //'filter' => false,
            //'filter_type' => 'int',
            'type' => 'select',
            'filter_type' => 'multiint',
            'multiple' => true,
            'list' => $sizesList,
            'callback' => 'showStock',
            'width' => '300',
        );
        $this->fields_list['price'] = array(
            'title' => $this->l('Price'),
            'type' => 'price',
            'align' => 'text-right',
            'filter_key' => 'a!price',
            'class' => 'product_price'
        );
        $this->fields_list['active'] = array(
            'title' => $this->l('Status'),
            'active' => 'status',
            'filter_key' => 'sa!active',
            'filter_type' => 'int',
            'align' => 'text-center',
            'type' => 'bool',
            //'type' => 'select',
            //'list' => array('0' => 'No', '1' => 'Yes'),
            //'class' => 'fixed-width-sm',
            'orderby' => false
        );
        
        $this->fields_list['stock_clearance'] = array(
            'title' => $this->l('Clearance'),
            //'active' => 'stock_clearance',
            'havingFilter' => true,
            'filter_key' => 'a!stock_clearance',
            'filter_type' => 'multiint',
            'multiple' => true,
            'multipleWidth' => 100,
            'align' => 'text-center',
            'type' => 'select',
            'callback' => 'showClearance',
            'list' => array(
                Product::StockClearanceNo => $this->l('No'), 
                Product::StockClearance1 => $this->l('Clearance 1'), 
                Product::StockClearance2 => $this->l('Clearance 2'), 
                Product::StockClearance3 => $this->l('Clearance 3')
            ),
            'class' => 'clearanceFieldContainer',
            'orderby' => false,
            'width' => '200',
        );
        
        
        $this->bulk_actions['setStockClear1'] = array(
            'text' => $this->l('Set Stock Clearance 1'),
            'icon' => 'icon-power-off text-success'
        );
        $this->bulk_actions['setStockClear2'] = array(
            'text' => $this->l('Set Stock Clearance 2'),
            'icon' => 'icon-power-off text-success'
        );
        $this->bulk_actions['setStockClear3'] = array(
            'text' => $this->l('Set Stock Clearance 3'),
            'icon' => 'icon-power-off text-success'
        );
        $this->bulk_actions['unsetStockClear'] = array(
            'text' => $this->l('Unset Stock Clearance'),
            'icon' => 'icon-power-off text-danger'
        );
        
        $notSoldTimeFilterOptions = array(
            '' => $this->l('Any'),
            '3' => $this->l('3 monthes'),
            '6' => $this->l('6 monthes'),
            '12' => $this->l('12 monthes'),
        );
        
        $ageFilterOptions = array(
            '' => $this->l('Any'),
            '1' => $this->l('1 month'),
            '3' => $this->l('3 monthes'),
            '6' => $this->l('6 monthes'),
            '12' => $this->l('12 monthes'),
        );
        
        $this->context->smarty->assign(array(
            'not_sold_time_filter_options' => $notSoldTimeFilterOptions,
            'not_sold_time_selected' => null,
            'age_filter_options' => $ageFilterOptions,
            'age_selected' => null,
            'in_stock_selected' => null
        ));
    }
    
    protected function bulkStockClearance($state)
    {
        $postProductIds = $_POST['productBox'];
        if( !is_array($postProductIds) || !count($postProductIds) ){
            $this->errors[] = 'Nothing selected';
            return;
        }
        
        $remoteSendProductIds = array();
        foreach($postProductIds as $postProductId)
        {
            $product = new Product( intval($postProductId) );
            if( !Validate::isLoadedObject($product) )
            {
                continue;
            }
            $product->changeClearanceStatus($state);
        }
        
        $this->redirect_after = self::$currentIndex .'&token='.$this->token;
    }

    public function processBulkUnsetStockClear()
    {
        $this->bulkStockClearance(Product::StockClearanceNo);
    }
    
    public function processBulkSetStockClear1()
    {
        $this->bulkStockClearance(Product::StockClearance1);
    }
    public function processBulkSetStockClear2()
    {
        $this->bulkStockClearance(Product::StockClearance2);
    }
    public function processBulkSetStockClear3()
    {
        $this->bulkStockClearance(Product::StockClearance3);
    }
    
    
    public function processFilter()
    {
        parent::processFilter();
        
        // add sizes list filter
        $sizesFilter = [];
        
        $this->context->smarty->assign('plmSelectedSizes', $sizesFilter);
        
        $sizesFilterKey = 'productlistproductFilter_al!id_attribute';
        if( isset($this->context->cookie->$sizesFilterKey) ){
            $sizesFilter = unserialize($this->context->cookie->$sizesFilterKey);
            $sizesFilter = array_filter($sizesFilter, function($val){ return !empty($val);});
        }
        
        if (count($sizesFilter))
        {
            $size_comma_str = implode(',', $sizesFilter);
            $this->_filter = str_replace('AND al.`id_attribute` IN('.$size_comma_str.')', '', $this->_filter);
            
            foreach( $sizesFilter as $sizeAttrId ){
                $sizeAttrId = intval($sizeAttrId);
                $this->_select .= ', IFNULL(sz_st_sa_'.$sizeAttrId.'.quantity, 0) AS sz_qnt_'.$sizeAttrId;
                $this->_select .= ', IFNULL(sz_st_sa_'.$sizeAttrId.'.physical_quantity, 0) AS sz_qnt_ph_'.$sizeAttrId;
                $this->_join .= '
                    LEFT JOIN `'._DB_PREFIX_.'product_attribute` sz_st_pa_'.$sizeAttrId.'
                        ON sz_st_pa_'.$sizeAttrId.'.id_product = a.id_product
                    LEFT JOIN `'._DB_PREFIX_.'product_attribute_combination` sz_st_pac_'.$sizeAttrId.'
                        ON sz_st_pac_'.$sizeAttrId.'.id_product_attribute = sz_st_pa_'.$sizeAttrId.'.id_product_attribute
                            AND sz_st_pac_'.$sizeAttrId.'.id_attribute = '.$sizeAttrId.'
                    LEFT JOIN `'._DB_PREFIX_.'stock_available` sz_st_sa_'.$sizeAttrId.'
                        ON sz_st_sa_'.$sizeAttrId.'.id_product_attribute = sz_st_pac_'.$sizeAttrId.'.id_product_attribute
                ';
                $this->_where .= ' AND IFNULL(sz_st_sa_'.$sizeAttrId.'.quantity, 0) > 0';
            }
        }

        $prefix = str_replace(array('admin', 'controller'), '', Tools::strtolower(get_class($this)));
        $filters = $this->context->cookie->getFamily($prefix.$this->list_id.'Filter_');
        
        foreach ($filters as $key => $value){
            if ($value == null || strncmp($key, $prefix.$this->list_id.'Filter_', 7 + Tools::strlen($prefix.$this->list_id))){
                continue;
            }
            $key = Tools::substr($key, 7 + Tools::strlen($prefix.$this->list_id));
            
            if( $key == 'age' ){
                $value = intval($value);
                $this->_filter .= ' AND a.date_add < DATE_SUB(NOW(), INTERVAL '.$value.' MONTH) ';
                $this->context->smarty->assign(array(
                    'age_selected' => $value
                ));
            }
            if( $key == 'not_sold_time' ){
                $value = intval($value);
                $this->_filterHaving .= ' AND date_last_order < DATE_SUB(NOW(), INTERVAL '.$value.' MONTH) ';
                $this->context->smarty->assign(array(
                    'not_sold_time_selected' => $value
                ));
            }
            if( ($key == 'in_stock') && intval($value) ){
                $this->_filter .= ' AND sta.quantity > 0 ';
                $this->context->smarty->assign(array(
                    'in_stock_selected' => $value
                ));
                
            }
        }
        
    }
    
    
    function processResetFilters($list_id = null)
    {
        unset($this->context->cookie->plmSizesFilter);
        parent::processResetFilters($list_id);
    }
    
    function showStock($field, $row)
    {
        $productPrice = Tools::ps_round( Product::getPriceStatic($row['id_product']) );
        $return = '<table class="table product_sizes_stock" data-price="'. $productPrice .'">
            <tr><th>'.$this->module->l('Size').'</th>';
        $stocks = [];
        $sizeMap = [];
        if (!empty($field))
        {
            // parse field
            $sizes = explode(',', $field);
            foreach ($sizes as $size)
            {
                $stock = explode('=', $size);
                $return .= '<th data-spl_ref="'. @$stock[2] .'" data-attr_id="'. @$stock[3] .'" class="sale_stats">' . $stock[0] . '</th>';
                $stocks [] = [
                    'qty'=>$stock[1],
                    'attr_id' => $stock[3]
                ];
                if (!empty($row['exp_delivery']))
                {
                    $sizeMap[]= $stock[2];
                }
            }
        }
        $return .= '<th>'.$this->l('total').'</th>';
        $return .= '</tr><tr><td>'.$this->module->l('Stock').'</td>';
        foreach($stocks as $stock)
        {
            $return .= '<td data-attr_id="'. @$stock['attr_id'] .'" class="sale_stats">'.$stock['qty'].'</td>';
        }
        $return .= '<td>'.$row['total_qty'].'</td></tr>';
        
        if (!empty($row['exp_delivery']))
        {
            // cut by dates
            $supOrders = explode(';', $row['exp_delivery']);
            foreach($supOrders as $supOrder)
            {
                list($expDate, $delivery) = explode('|', $supOrder);
                $return .= '<tr><td>'.$this->module->l('Exp. delivery').'<br/>'.Tools::displayDate($expDate).'</td>';
                
                // parse delivery
                $deliveryMap = [];
                $delivery = explode(',', $delivery);
                foreach($delivery as $item)
                {
                    list($sku, $qty) = explode(':', $item);
                    $deliveryMap[$sku] = $qty;
                }
                if (count($sizeMap))
                {
                    // show items
                    foreach ($sizeMap as $sku)
                    {
                        $return .= '<td>'.(empty($deliveryMap[$sku])?'':$deliveryMap[$sku]).'</td>';
                    }
                    $return .= '<td></td>';
                }
                else
                {
                    // it is product without attributes
                    $return .= '<td>'.$deliveryMap[''].'</td>';
                }
                $return .= '</tr>';
            }
        }
        
        $return .= '</table>';
        return $return;
    }
    
    
    function showProductImage($field, $row)
    {
        return '<img class="prod-thumb" src="'.$this->context->link->getImageLink('aaa', $field, 'small_default').'" 
            data-srcbig="'.$this->context->link->getImageLink('aaa', $field, 'large_default').'">';
    }
    
    
    function showClearance($field, $row)
    {
        $show = '<span clearance="'.$field.'" class="clearanceField list-action-enable ';
        if ($field!=Product::StockClearanceNo)
        {
            return $show.'action-enabled" title="'.$this->l('Clearance').' '.$field.'"><i class="icon-check"></i> '.$field.'</span>';
        }
        else
        {
            return $show.'action-disabled"><i class="icon-remove"></i></span>';
        }
    }
    
    
    public function setMedia()
    {
        parent::setMedia();
        $this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/cluetip/jquery.cluetip.js');
        $this->context->controller->addCss(__PS_BASE_URI__.'js/jquery/plugins/cluetip/jquery.cluetip.css');
        $this->context->controller->addJS(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.js');
        $this->context->controller->addCss(__PS_BASE_URI__.'js/jquery/plugins/multiple-select/multiple-select.css');
        
        $this->addJS( 'https://www.gstatic.com/charts/loader.js');
        $this->addJS( $this->module->getPath() .'views/js/DYMO.Label.Framework.latest.js');
        $this->addJS( $this->module->getPath() .'views/js/PrintLabel_new_design.js');
        $this->addJS( $this->module->getPath() .'views/js/DymoLabelExhbTempl.js');
        $this->addJS( $this->module->getPath() .'views/js/product_list.js');
        
    }
    
    
    public function renderList()
    {
        $listHtml = parent::renderList();

        //echo $this->_listsql;
        
        // add variants json to html
        $productVariants = array();
        $productsSaleStats = array();
        foreach( $this->_list as $row ){
            
            
            $productsSaleStats[ ($row['id_product'].'_0') ] = $this->getProductSaleStatistics($row['id_product']);
            $productAttributesList = Db::getInstance()->executeS('
                SELECT * FROM `'._DB_PREFIX_.'product_attribute` WHERE `id_product` = '. intval($row['id_product']) .'
            ');
            if( is_array($productAttributesList) && count($productAttributesList) ){
                foreach($productAttributesList as $productAttribute){
                    $statsKey = $row['id_product'].'_'. $productAttribute['id_product_attribute'];
                    $productsSaleStats[ $statsKey ] = $this->getProductSaleStatistics(
                        $row['id_product'], $productAttribute['id_product_attribute']);
                }
            }
            
            $splRefMatches = array();
            if( !preg_match('#^(\d{4})_(.+)$#i', $row['product_supplier_reference'], $splRefMatches) ){
                continue;
            }
            $productSplRefCode = $splRefMatches[1];
            
            $variantsColors = array();
            $variantsColors[] = $splRefMatches[2];
            
            if( !isset($productVariants[ $productSplRefCode ]) ){
                $productVariants[ $productSplRefCode ] = array();
            }
            
            $relatedProducts = Db::getInstance()->executeS('
                SELECT id_product, supplier_reference
                FROM `'._DB_PREFIX_.'product`
                WHERE `supplier_reference` LIKE "'. pSQL($productSplRefCode) .'%"
            ');
            
            if( is_array($relatedProducts) && count($relatedProducts) ){
                foreach($relatedProducts as $relatedProduct){
                    $splRefMatches = array();
                    if( !preg_match('#^(\d{4})_(.+)$#i', $relatedProduct['supplier_reference'], $splRefMatches) ){
                        continue;
                    }
            
                    //$relatedVariantSplRefCode = $splRefMatches[1];
                    $variantsColors[] = $splRefMatches[2];
                }
            }
            
            $productVariants[ $productSplRefCode ] = array_values( array_unique($variantsColors) );
            
        }
        
        // sum total stock quantity
        parent::getList($this->context->language->id, null, null, 0, false, false);
        $physicalQuantityTotal = 0;
        $availableQuantityTotal = 0;
        foreach($this->_list as $row){
            $rowKeys = array_keys($row);
            $availableQuantitySizesSelected = 0;
            foreach($rowKeys as $rowKey){
                // check if selected size stock filter
                if( preg_match('#^sz_qnt_(\d+)$#', $rowKey, $szQntMatch) ){
                    // count selected sizes stock
                    if( intval($row[ $rowKey ]) > 0 ){
                        $availableQuantitySizesSelected += intval($row[ $rowKey ]);
                    }
                    
                    $physicalQuantityKeyName = 'sz_qnt_ph_'.$szQntMatch[1];
                    $physicalQuantitySizesSelected += intval( $row[$physicalQuantityKeyName] );
                }
            }
            if( $availableQuantitySizesSelected ){
                // if selected sizes found, add them and continue
                $availableQuantityTotal += $availableQuantitySizesSelected;
                $physicalQuantityTotal += $physicalQuantitySizesSelected;
                continue;
            }
            
            $sizesList = explode(',', $row['stock']);
            if( !is_array($sizesList) ){
                continue;
            }
            
            foreach($sizesList as $sizeInfo){
                $sizeValues = explode('=', $sizeInfo);
                if( is_array($sizeValues) ){
                    if( isset($sizeValues[1]) && (intval($sizeValues[1]) > 0) ){
                        $availableQuantityTotal += intval($sizeValues[1]);
                    }
                    if( isset($sizeValues[4]) && (intval($sizeValues[4]) > 0) ){
                        $physicalQuantityTotal += intval($sizeValues[4]);
                    }
                }
            }
        }
        
        //, waitImage: \'../img/loader.gif\'
        $return = '<script type="text/javascript">
        //<![CDATA[
        $(function(){
            $(\'a.plmProductImg\').cluetip({local:true, cursor: \'pointer\', showTitle: false, width: \'591px\'});
            $(\'a.supplierOrdersLink\').cluetip({cluetipClass: \'tbltip\', dropShadow: true, width: \'200px\', showTitle: false});
        });
        var variantColors = '. json_encode($productVariants) .';
        var productsSaleStats = '. json_encode($productsSaleStats) .';
        var clearanceNo = '.Product::StockClearanceNo.';
        var clearanceText = '.json_encode($this->l('Clearance')).';
        var controllerLink = '.json_encode($this->context->link->getAdminLink('AdminProductList')).';
        var clearanceEditFormTpl = ';
        $clearanceEditFormTpl = '<select name="clearance" id="clearanceSelector#id#">';
        
        foreach($this->fields_list['stock_clearance']['list'] as $val=>$txt)
        {
            $clearanceEditFormTpl .= '<option value="'.$val.'">'.$txt.'</option>';
        }
        
        $clearanceEditFormTpl .= '
        </select><button class="button" id="clearanceSaveBtn#id#">'.$this->l('Save').
                '</button> <button class="button" id="clearanceCancelBtn#id#">'.$this->l('Cancel').'</button>';
        $return .= json_encode($clearanceEditFormTpl).';
        //]]>
        
      </script>'.$listHtml 
        .'<div class="panel">
            <h2>Available for order quantity: '.$availableQuantityTotal.'</h2>
            <h2>Physical quantity: '.$physicalQuantityTotal.'</h2>
        </div>';
        
        return $return;
    }
    
    protected function getProductSaleStatistics($id_product, $id_product_attribute = null)
    {
        $dateFrom = new DateTime('-24 month');
        $dateTo = new DateTime();
        
        $statsGroupped = array();
        $khlStats = $this->getProductSaleStatisticsKhl($id_product, $id_product_attribute);
        $dbkStats = $this->getProductSaleStatisticsDbk($id_product, $id_product_attribute);

        for( $i = 0; $i < 24; $i++ ){
            $dateFrom->add( new DateInterval('P1M') );
            $currentDateMonth = $dateFrom->format('Y-m');

            $statsItem = array(
                'report_date' => $currentDateMonth,
                'report_date_formatted' => $dateFrom->format('m.Y'),
                'khl_quantity' => 0,
                'dbk_quantity' => 0
            );
            
            foreach( $khlStats as $khlStatItem ){
                if( $khlStatItem['report_date'] == $currentDateMonth ){
                    $statsItem['khl_quantity'] = intval($khlStatItem['sold_quantity']);
                }
            }
            foreach( $dbkStats as $dbkStatItem ){
                if( $dbkStatItem['report_date'] == $currentDateMonth ){
                    $statsItem['dbk_quantity'] = intval($dbkStatItem['sold_quantity']);
                }
            }
            $statsGroupped[] = $statsItem;
        }
        
        return $statsGroupped;
    }
    
    protected function getProductSaleStatisticsKhl($id_product, $id_product_attribute = null)
    {
        $dateFrom = new DateTime('-24 month');
        $dateTo = new DateTime();
        /**
         * @var DbQueryCore $dbQuery
         */
        $dbQuery = new DbQuery();
        $dbQuery
            ->select('
                SUM(od.`product_quantity` - od.`product_quantity_refunded` - od.`product_quantity_return` - od.`product_quantity_reinjected`)
                    AS sold_quantity,
                DATE_FORMAT(o.`date_add`, "%Y-%m")
                    AS report_date,
                DATE_FORMAT(o.`date_add`, "%m.%Y")
                    AS report_date_formatted
            ')
            ->from('order_detail', 'od')
            ->innerJoin('orders', 'o', 'o.id_order = od.id_order')
            ->innerJoin('product', 'p', 'p.id_product = od.product_id')
            ->where('o.current_state != '. intval(Configuration::get('PS_OS_CANCELED')) )
            ->where('o.date_add >= "'. $dateFrom->format('Y-m-01 00:00:00') .'" ')
            ->where('o.date_add <= "'. $dateTo->format('Y-m-d 23:59:59') .'" ')
            ->where('od.product_id = '. intval($id_product))
            ->groupBy('report_date')
            ->orderBy('od.id_order DESC')
        ;
        
        if( !is_null($id_product_attribute) ){
            $dbQuery->where('od.product_attribute_id = '. intval($id_product_attribute));
        }
        
        return Db::getInstance()->executeS($dbQuery);
    }
    
    protected function getProductSaleStatisticsDbk($khl_id_product, $khl_id_product_attribute = null)
    {
        $dateFrom = new DateTime('-24 month');
        $dateTo = new DateTime();
        
        if( is_null($khl_id_product_attribute) ){
            $query = '
                SELECT SUM(vds.quantity) as sold_quantity, 
                    DATE_FORMAT(vds.sale_date, "%Y-%m") AS report_date,
                    DATE_FORMAT(vds.sale_date, "%m.%Y") AS report_date_formatted
                FROM '. _DB_PREFIX_ .'product p
                LEFT JOIN '.VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product vp
                    ON p.supplier_reference = vp.supplier_reference
                LEFT JOIN '.VIPDRESS_DB_NAME.'.os_dbk_sale vds
                    ON vds.ps_product_id = vp.id_product
                WHERE
                    p.id_product = '. intval($khl_id_product) .'
                    AND vds.sale_date >= "'. $dateFrom->format('Y-m-01 00:00:00') .'"
                    AND vds.sale_date <= "'. $dateTo->format('Y-m-d 23:59:59') .'"
                    AND vds.`quantity` > 0
                    AND vds.`deleted` = 0
                GROUP BY report_date
            ';
        }
        else{
            $query = '
                SELECT SUM(vdsa.quantity) as sold_quantity,
                    DATE_FORMAT(vdsa.sale_date, "%Y-%m") AS report_date,
                    DATE_FORMAT(vdsa.sale_date, "%m.%Y") AS report_date_formatted
                FROM '. _DB_PREFIX_ .'product p
                LEFT JOIN '. _DB_PREFIX_ . 'product_attribute pa
                    ON pa.id_product = p.id_product
                LEFT JOIN '. VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product_attribute vpa
                    ON pa.supplier_reference = vpa.supplier_reference
                LEFT JOIN '. VIPDRESS_DB_NAME.'.os_dbk_sale vdsa
                    ON vdsa.ps_attr_id=vpa.id_product_attribute
                WHERE
                    p.id_product = '. intval($khl_id_product) .'
                    AND pa.id_product_attribute = '. intval($khl_id_product_attribute) .'
                    AND vdsa.sale_date >= "'. $dateFrom->format('Y-m-01 00:00:00') .'"
                    AND vdsa.sale_date <= "'. $dateTo->format('Y-m-d 23:59:59') .'"
                    AND vdsa.`quantity` > 0
                    AND vdsa.`deleted` = 0
                GROUP BY report_date
            ';
        }
        
        return Db::getInstance()->executeS($query);
    }
    
    function displayErrors()
    {
        
    }
    
    public function processStatus()
    {
        $this->loadObject(true);
        if (!Validate::isLoadedObject($this->object)) {
            return false;
        }
    
        $res = parent::processStatus();
    
        return $res;
    }
    
    public function initProcess()
    {
        parent::initProcess();
        
        if( empty($this->action) ){
            if( isset($_GET['stock_clearanceproduct']) ){
                $this->processStockClearance();
            }
        }
        
    }
    
    public function processExportExcel()
    {
        set_time_limit(0);
        ini_set('memory_limit', -1);

        if( empty($_POST['productBox']) ){
            $this->errors[] = 'Products does not selected';
            return false;
        }
        
        $exportLangId = Configuration::get('PS_LANG_DEFAULT');
        
        $xls = new PHPExcel();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Products');
        // borders around cells
        $style1 = ['borders'=>[
            'outline'=>[
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => ['rgb'=>'000000']
            ]],
            //'alignment'=>['wrap' => true]
        ];
        
        // add header
        $sheet->setCellValue('A1', 'Reference', true)->getStyle()->applyFromArray($style1);
        $sheet->getCell('A2')->getStyle()->applyFromArray($style1);
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->setCellValue('B1', 'Picture', true)->getStyle()->applyFromArray($style1);
        $sheet->getCell('B2')->getStyle()->applyFromArray($style1);
        $sheet->getColumnDimension('B')->setWidth(30);
        $nextCell = ord('B');

        $sheet->setCellValue('C1', 'Size', true)->getStyle()->applyFromArray($style1);
        $sheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $sizeNames = ['32', '34', '36', '38', '40', '42', '44', '46', '48', '50', '52'];
        
        foreach ($sizeNames as $sizeName){
            if (empty($sizeName)){
                $sheet->setCellValue(chr( ++$nextCell) . '2', '-', true)->getStyle()->applyFromArray($style1)->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            }
            else{
                $sheet->setCellValue(chr( ++$nextCell) . '2', $sizeName, true)->getStyle()->applyFromArray($style1);
            }
        }
        $sheet->mergeCells('C1:' . chr($nextCell) . '1');
        
        $sheet->setCellValue(chr(++$nextCell).'1', 'Total QTY', true)->getStyle()->applyFromArray($style1);
        $sheet->getCell(chr($nextCell).'2')->getStyle()->applyFromArray($style1);
        $sheet->setCellValue(chr(++$nextCell).'1', 'Price', true)->getStyle()->applyFromArray($style1);
        $sheet->getCell(chr($nextCell).'2')->getStyle()->applyFromArray($style1);
        
        $curRow = 3;
        foreach($_POST['productBox'] as $productId){
            
            $product = new Product(intval($productId));
        
            if( !ValidateCore::isLoadedObject($product) ){
                $this->errors[] = 'Object not loaded: '. $productId;
                continue;
            }
        
            $sheet->setCellValue('A'.$curRow, $product->supplier_reference, true)->getStyle()->applyFromArray($style1);

            $productImages = $product->getImages($exportLangId);
            $productCover = $productImages[0];
            $imagePath = _PS_PROD_IMG_DIR_.Image::getImgFolderStatic($productCover['id_image']).$productCover['id_image'].'-medium_default.jpg';

            if (file_exists($imagePath))
            {
                $logo = new PHPExcel_Worksheet_Drawing();
                $logo->setPath($imagePath);
                $logo->setCoordinates("B".$curRow);
                $logo->setOffsetX(10);
                $logo->setOffsetY(10);
                $logo->setWidth(170);
                $logo->setHeight(242);  
                $sheet->getRowDimension($curRow)->setRowHeight(190);
                $logo->setWorksheet($sheet);
            }
            $sheet->getCell('B'.$curRow)->getStyle()->applyFromArray($style1);
            $curCell = ord('B');
            
            $productCombinations = $product->getAttributeCombinations($exportLangId);
            
            $quantityTotal = 0;
            foreach ($sizeNames as $sizeName){
                foreach($productCombinations as $productCombination){
                    if( $sizeName == $productCombination['attribute_name'] ){
                        $quantityTotal += intval($productCombination['quantity']);
                        $cellAddr = chr(++$curCell).$curRow;
                        $sheet->setCellValue($cellAddr, $productCombination['quantity'], true)
                            ->getStyle()->applyFromArray($style1);
                    }
                }
            }
            
            $cellAddr = chr(++$curCell).$curRow;
            $sheet->setCellValue($cellAddr, $quantityTotal, true)
                ->getStyle()->applyFromArray($style1);
            
            $price = Product::getPriceStatic($product->id, false);
            $cellAddr = chr(++$curCell).$curRow;
            $sheet->setCellValue($cellAddr, Tools::displayPrice($price), true)
                ->getStyle()->applyFromArray($style1);
            
            
            // add empty row
            $curRow++;
            $curCol = ord('A');
            for( $eri = 0; $eri < 17; $eri++ ){
                $cell = chr( $curCol + $eri ) . $curRow;
                $sheet->setCellValue($cell, '');
            }
            
            $curRow++;
        }

        // output to browser
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=products.xls");
        
        $objWriter = new PHPExcel_Writer_Excel5($xls);
        $objWriter->save('php://output');
        
        die;
    }
    

    public function processPhotosDownload()
    {
        set_time_limit(0);
        $this->ajax = true;
        ini_set('memory_limit', -1);
        
        $downloadOptions = array('photos_download_option' => array());
        
        if( isset($_POST['photos_download_option']) ){
            $downloadOptions['photos_download_option'] = $_POST['photos_download_option'];
        }
        
        if( empty($_POST['productBox']) ){
            $this->errors[] = 'Products does not selected';
            return false;
        }
        
        $tmpDirPath = _PS_TMP_IMG_DIR_ . DIRECTORY_SEPARATOR . uniqid();
        mkdir($tmpDirPath);
        $zip = new ZipArchive();
        $zipFile = tempnam("tmp", "zip");
        
        if ($zip->open($zipFile, ZipArchive::CREATE)!==TRUE) {
            $this->errors[] = "cannot open <$zipFile>";
            return false;
        }
        
        $this->composePhotosArchive($zip, $tmpDirPath, $downloadOptions);
        // check for errors after composing
        //if( count($this->errors) ){
        //    return false;
        //}
        
        if( $zip->numFiles == 0 ){
            $this->errors[] = 'No images added to the archive';
            return false;
        }
        
        try{
            $closed = $zip->close();
        }
        catch(Exception $e){
            $this->unlinkPhotosTmpDir($tmpDirPath);
            $this->errors[] = 'ERROR: '. $e->getMessage();
            return false;
        }
        
        if( $closed !== true){
            $this->unlinkPhotosTmpDir($tmpDirPath);
            $this->errors[] = 'ERROR: Closed with status - '. $closed;
            return false;
        }
        
        if( headers_sent($filename, $linenum) ){
            $this->unlinkPhotosTmpDir($tmpDirPath);
            $this->errors[] = "Archive can not be downloaded, headers already sent in $filename on line $linenum";
            return false;
        }
        
        $archiveName = 'products_images.zip';
        header("Content-Type: application/zip");
        header("Content-Length: " . filesize($zipFile));
        header("Content-Disposition: attachment; filename=\"$archiveName\"");
        readfile($zipFile);
        
        unlink($zipFile);
        $this->unlinkPhotosTmpDir($tmpDirPath);
        die();
        //var_dump($_POST, $this->errors);die;
    }
    
    protected function unlinkPhotosTmpDir($tmpDirPath)
    {
        foreach( scandir($tmpDirPath) as $dirElem ){
            if( ($dirElem != '.') && ($dirElem != '..') && is_file($tmpDirPath . DIRECTORY_SEPARATOR . $dirElem) ){
                @unlink($tmpDirPath . DIRECTORY_SEPARATOR . $dirElem);
            }
        }
        clearstatcache($tmpDirPath);
        rmdir($tmpDirPath);
    }
    
    protected function composePhotosArchive(&$zip, $tmpDirPath, $downloadOptions)
    {
        $fontPath = _PS_FONT_DIR . 'OpenSans-Semibold.ttf';
        $fontSize = 30;
        
        foreach($_POST['productBox'] as $productId){
            $productId = intval($productId);
            $product = new Product($productId);
            
            if( !ValidateCore::isLoadedObject($product) ){
                $this->errors[] = 'Object not loaded: '. $productId;
                continue;
            }
            
            $productImages = $product->getImages($this->context->language->id);

            if( !$productImages || !is_array($productImages) ){
                continue;
            }
        
            $text = '';
            $productReference = $product->supplier_reference;
            $productPrice = Product::getPriceStatic($product->id, false);
            $productPriceFormatted = number_format($productPrice, 0) . ',-€';
        
            if( in_array('reference', $downloadOptions['photos_download_option']) && in_array('price', $downloadOptions['photos_download_option']) ){
                $text .= $productReference . "\n\r". $productPriceFormatted;
            }
            elseif( in_array('reference', $downloadOptions['photos_download_option']) ){
                $text .= $productReference;
            }
            elseif( in_array('price', $downloadOptions['photos_download_option']) ){
                $text .= $productPriceFormatted;
            }

            $productImagesCount = count($productImages);
            
            if( $productImagesCount > 1){
                $productImageLast = array_pop($productImages);
                $productImagesTmp = array();
                foreach( $productImages as $pii => $productImage ){
                    if( $pii == 1 ){
                        $productImagesTmp[] = $productImageLast;
                    }
                    $productImagesTmp[] = $productImage;
                }
                $productImages = $productImagesTmp;
                unset($productImagesTmp, $pii);
            }

            //foreach($productImages as $pii => $productImageData){
            $imagesAddedToArchive = 0;
            $pii = -1;
            do{
                $pii++;
                // need only first and last image
                //if( ($pii != 0) && ($pii != $productImagesCount-1) ){
                //    continue;
                //}
                
                $productImageData = $productImages[$pii];

                $productImage = new ImageCore($productImageData['id_image']);
                $productImagePath = _PS_PROD_IMG_DIR_ . $productImage->getExistingImgPath()
                //.'-large_default'
                .'.'.$productImage->image_format;
                $productImageNewFilename = $product->supplier_reference .'-'. ($pii+1) .'.'. $productImage->image_format;
                $productImageNewPath = $tmpDirPath . DIRECTORY_SEPARATOR . $productImageNewFilename;
                PrestaShopLoggerCore::addLog($productImagePath .' ; '. $productImageNewPath);
                if( !@copy($productImagePath, $productImageNewPath) ){
                    $this->errors[] = 'Image not copied: "'.$productImagePath.'" to "'.$productImageNewPath.'"';
                    continue;
                }
                
                if( !is_readable($productImageNewPath) ){
                    $this->errors[] = 'No image to process: "'.$productImageNewPath.'"';
                    continue;
                }
        
                try{
                    $promoImage = new PromoImageProcessor($productImageNewPath);
                    if( !empty($text) ){
                        $promoImage->placeRefPriceText($text);
                    }
                    
                    if( in_array('qr_code', $downloadOptions['photos_download_option']) ){
                        $promoImage->placeQRCode($productReference);
                    }
                    
                    $promoImage->save();
                }
                catch( Exception $e ){
                    $this->errors[] = $e->getMessage();
                    continue;
                }
                
        
                if( !$zip->addFile($productImageNewPath, $productImageNewFilename) ){
                    $this->errors[] = 'Image "'.$productImageNewPath.'" not added to archive';
                    continue;
                }
                $imagesAddedToArchive++;
            }
            while( ($imagesAddedToArchive < 2) && ( ($pii+1) < count($productImages) ) );
        }

    }

    public function processStickerPrintPdf()
    {
        
        $labelsData = array();
        
        foreach( $_POST['productBox'] as $productId ){
            $productId = intval($productId);
            $product = new Product($productId);
            
            if( !ValidateCore::isLoadedObject($product) ){
                $this->errors[] = 'Object not loaded: '. $productId;
                break;
            }
            
            $combinations = $product->getAttributeCombinations( Configuration::get('PS_LANG_DEFAULT') );
            foreach($combinations as $combination){
                $splRefPartsMatches = array();
                if( !preg_match(KOEHLERT_SPL_REF_WITHSIZE_REGEX, $combination['supplier_reference'], $splRefPartsMatches) ){
                    continue;
                }
                $labelsData[] = array(
                    'supplier_reference' => $splRefPartsMatches[1],
                    'name' => $splRefPartsMatches[2],
                    'id_product' => intval($combination['id_product']),
                    'id_product_attribute' => intval($combination['id_product_attribute']),
                    'size' => $splRefPartsMatches[3],
                    'ean13' => $combination['ean13'],
                    'quantity' => 1
                );
                
            }
        }
        
        if( !count($labelsData) ){
            $this->errors[] = 'No object loaded';
        }
        
        if( count($this->errors) ){
            return;
        }
        
        ProductLabel::generatePdf($labelsData);
        
    }

    public function processStickerExhbPrintPdf()
    {
        $this->ajax = 1;
        set_time_limit(0);
        
        require_once _PS_TOOL_DIR_ .'ashberg-barcode/php-barcode.php';
        include_once _PS_TOOL_DIR_ .'mpdf/mpdf.php';
        
        $imgUrl = 'https://www.koehlert.com/img/koehlert-logo-label.jpg';
        
        $labelsData = array();
        $productVariants = array();
        
        foreach( $_POST['productBox'] as $productId ){
            $productId = intval($productId);
            //$product = new Product($productId);
            
            $product = Db::getInstance()->getRow('
                SELECT id_product, supplier_reference
                FROM `'._DB_PREFIX_.'product`
                WHERE `id_product` = '. intval($productId) .'
            ');
            
            if( !is_array($product) || empty($product['id_product']) ){
                continue;
            }
            
            /*if( !ValidateCore::isLoadedObject($product) ){
                $this->errors[] = 'Object not loaded: '. $productId;
                break;
            }*/
            
            $splRefMatches = array();
            if( !preg_match(KOEHLERT_SPL_REF_NOSIZE_REGEX, $product['supplier_reference'], $splRefMatches) ){
                continue;
            }
            $productSplRefNoSize = $product['supplier_reference'];
            $productSplRefCode = $splRefMatches[1];

            $variantsColors = array();
            $variantsColors[] = $splRefMatches[2];
            
            if( !isset($productVariants[ $productSplRefNoSize ]) ){
                $productVariants[ $productSplRefNoSize ] = array();
            }
            
            
            $relatedProducts = Db::getInstance()->executeS('
                SELECT id_product, supplier_reference
                FROM `'._DB_PREFIX_.'product`
                WHERE `supplier_reference` LIKE "'. pSQL($productSplRefCode) .'_%"
            ');
            
            if( is_array($relatedProducts) && count($relatedProducts) ){
                foreach($relatedProducts as $relatedProduct){
                    $splRefMatches = array();
                    if( !preg_match(KOEHLERT_SPL_REF_NOSIZE_REGEX, $relatedProduct['supplier_reference'], $splRefMatches) ){
                        continue;
                    }
                    
                    //$relatedVariantSplRefCode = $splRefMatches[1];
                    $variantsColors[] = $splRefMatches[2];
                }
            }

            $productVariants[ $productSplRefNoSize ] = array(
                'supplier_reference_code_n_color' => $product['supplier_reference'],
                'supplier_reference_code' => $productSplRefCode,
                'colors' => array_unique($variantsColors),
                'price' => Tools::ps_round(Product::getPriceStatic($product['id_product'], false))
            );
            
        }

        $html = '';
        $li = -1;
        foreach($productVariants as $productSplRefNoSize => $prodVariants){
            $li++;
            if($li){
                $html .= "<pagebreak>";
            }
            
            $colorsFontSize = 12;
            $qrCodeSize = 60;
            
            if( count($prodVariants['colors']) > 8 ){
                $colorsFontSize = 10;
                $qrCodeSize = 45;
            }
            if( count($prodVariants['colors']) > 10 ){
                $colorsFontSize = 9;
                $qrCodeSize = 45;
            }
            
            $colors = '<b>'. array_shift($prodVariants['colors']) .'</b>';
            $colors .= '<br>'. implode('<br>', $prodVariants['colors']);
            
            $qrCodeImageUri = $this->context->shop->getBaseURL() .'/modules/qrcode/generate.php'
                .'?text='. urlencode($prodVariants['supplier_reference_code_n_color']) .'&size=2';
            
            $html .= "<div>";
            $html .= "<div style='padding-top:5px;'><img src='$imgUrl' alt='' ></div>";

            $html .= "<div style='height:5%;font-family: Arial; font-size: 12px; text-align: center; font-weight: bold; margin-top: 7px'>Artikelnr. / Style:</div>";
            $html .= "<div style='height:5%;font-family: Arial; font-size: 12px; text-align: center;'>".$prodVariants['supplier_reference_code']."</div>";
            $html .= "<div style='height:5%;font-family: Arial; font-size: 12px; text-align: center; font-weight: bold; margin-top: 0px'>Farbe / Color:</div>";
            $html .= "<div style='height:43%;font-family: Arial; font-size: ".$colorsFontSize."px; text-align: center; padding: 0px'>".$colors. "</div>";
            $html .= "<hr style='color:black;margin:2px 0;padding:0;'>";
            $html .= "<div style='height:5%;font-family: Arial; font-size: 12px; text-align: center; font-weight: bold; margin-top: 0px'>Preis / Price:</div>";
            $html .= "<div style='height:5%;font-family: Arial; font-size: 12px; text-align: center; padding: 0px'>".$prodVariants['price']. ",-€</div>";
            $html .= "<div style='margin-top:0px;text-align:center;'>
                <img src='". $qrCodeImageUri ."' height='".$qrCodeSize."'>
            </div>";
            $html .= "</div>";
        }
        
        $mpdf = new mPDF('utf-8', array(41,89), 0, '', 2, 2, 3, 3, 0, 0);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        //echo $html;
        die;
        
        //
    }

    public function processProdimgPdf()
    {
        set_time_limit(0);
        
        $html = '';
        $itemsOnPage = 9;
        $imagesToPrint = array();
        $imageTemplate = 'home_default';
        
        foreach( $_POST['productBox'] as $productId ){
            $productId = intval($productId);
            $product = new Product($productId);
        
            if( !ValidateCore::isLoadedObject($product) ){
                $this->errors[] = 'Object not loaded: '. $productId;
                continue;
            }
        
            $coverImage = null;
            $productImages = $product->getImages($this->context->language->id);
            if( !is_array($productImages) || !count($productImages) ){
                $this->errors[] = 'Images not found: '. $productId;
                continue;
            }
            
            foreach($productImages as $prodImage){
                if( $prodImage['cover'] == 1 ){
                    $coverImage = $prodImage;
                }
            }
            if( is_null($coverImage) ){
                $coverImage = array_shift($productImages);
            }
            
            $itemToPrint = array(
                'image_url' => $this->context->link->getImageLink('no-matter', $coverImage['id_image'], $imageTemplate)
            );
            
            $productReference = $product->supplier_reference;
            $productPrice = Product::getPriceStatic($product->id, false);
            $productPriceFormatted = number_format($productPrice, 0) . ',-€';
            
            $attributes_groups = $product->getAttributesGroups($this->context->language->id);
            $productStockRows = array(
                '<td>Size</td>',
                '<td style="border:1px solid #b7b3b4;">Stock</td>'
            );
            $quantityTotal = 0;
            foreach($attributes_groups as $attribute){
                $productStockRows[0] .= '<td style="text-align:right">'. $attribute['attribute_name'] .'</td>';
                $productStockRows[1] .= '<td style="text-align:right;border:1px solid #b7b3b4;">'. $attribute['quantity'] .'</td>';
                $quantityTotal += $attribute['quantity'];
            }
            
            $productStockHtml =
                '<table style="border:1px solid #b7b3b4;border-collapse:collapse;width:100%;margin:0 auto;">'
                .'<tr style="background-color:#b7b3b4">'
                . implode('</tr><tr>', $productStockRows) 
                .'</tr></table>';
            
            
            $photos_download_options = is_array($_POST['photos_download_option']) 
                ? $_POST['photos_download_option'] : array();
            foreach($photos_download_options as $photos_download_option){
                switch($photos_download_option){
                    case 'reference':
                        $itemToPrint['reference'] = $productReference;
                        break;
                    case 'price':
                        $itemToPrint['price'] = $productPriceFormatted;
                        break;
                    case 'stock':
                        $itemToPrint['stock'] = $productStockHtml;
                        break;
                    default:
                        break;
                }
            }

            $imagesToPrint[] = $itemToPrint;
        }
        
        $imagesCount = floor( count($imagesToPrint) / $itemsOnPage );

        $ii = -1;
        do{
            $ii++;
            if( $ii > 0 ){
                //$html .= '<pagebreak>';
            }
            
            $itemsForPage = array_slice($imagesToPrint, ($ii*$itemsOnPage), $itemsOnPage );
            $html .= $this->prodimgPdfMarkupPage($itemsForPage);
            
            
        }
        while( $ii < $imagesCount );
        //echo $html;
        $mpdf = new mPDF('UTF-8', 'A4', 50, 'Helvetica', 5, 5, 3, 3);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        
        die;
    }
    
    protected function prodimgPdfMarkupPage($items)
    {
        $itemsInRow = 3;
        if( count($items) == 0 || count($items) > 9 ){
            return '';
        }

        while( count($items) % $itemsInRow != 0 ){
            $items[] = array();
        }
        
        $logoUrl = $this->context->shop->getBaseURL() .'modules/product_list/views/img/pdf-catalog-logo.jpg';
        
        $html = '';
        
        $html .= '<div style="text-align:center;"><img src="'.$logoUrl.'" style="width:90mm;"></div>';
        
        $html .= '<table style="height:240mm;border-collapse:collapse;" >';
        
        foreach($items as $i => $item){
            $im = $i + 1;
            if( ($im == 1) || ($im % $itemsInRow == 1) ){
                $html .= '<tr>';
            }
            
            $image_height = 79;
            if( !empty($item['reference']) || !empty($item['price']) ){
                $image_height -= 1;
            }
            if( !empty($item['stock']) ){
                $image_height -= 2;
            }
            
            $html .= '<td style="padding:1mm 4mm;font-size:3mm; text-align:center;">';
            if( !empty($item['image_url']) ){
                $html .= '<img src="'. $item['image_url'] .'" style="height:'.$image_height.'mm;border:1px solid #b7b3b4;display:block;">';
                
                $html .= '<table style="font-size:3mm;">';
                if( !empty($item['reference']) || !empty($item['price']) ){
                    
                    $html .= '<tr style="">';
                    if( !empty($item['reference']) ){
                        $html .= '<td style="text-align:left">'. $item['reference'] .'</td>';
                    }
                    if( !empty($item['price']) ){
                        $html .= '<td style="text-align:right">'. $item['price'] .'</td>';
                    }
                    $html .= '</tr>';
                }
                
                if( !empty($item['stock']) ){
                    $html .= '<tr style=""><td colspan="2" style="padding:0;">'. $item['stock'] .'</td></tr>';
                }
                $html .= '</table>';
            }
            else{
                $html .= '&nbsp;';
            }
            $html .= '</td>';
            
            if( $im % $itemsInRow == 0 ){
                $html .= '</tr>';
            }
            
        }
        $html .= '<tr><td colspan="5" style="text-align:center;">
            <a href="https://www.koehlert.com" style="color:#94908F;font-size:4mm;text-decoration:none;">www.koehlert.com</a>
            </td></td>';
        $html .= '</table>';
        return $html;
    }
    
    
    function ajaxProcessChangeClearanceMode()
    {
        try
        {
            $product = new Product(intval($_REQUEST['id']));
            if (!Validate::isLoadedObject($product))
            {
                throw new Exception('Product not found');
            }
            $clearance = intval($_REQUEST['clearance']);
            $product->changeClearanceStatus($clearance);
            echo json_encode(['error'=>false, 'price'=>Tools::displayPrice($product->price), 'clearance'=>$clearance]);
        }
        catch(Exception $e)
        {
            echo json_encode(['error'=>$e->getMessage()]);
        }
    }
}
