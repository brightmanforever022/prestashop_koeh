<?php

class Product extends ProductCore
{
    const StockClearanceNo = 0;
    const StockClearance1 = 1;
    const StockClearance2 = 2;
    const StockClearance3 = 3;
    
    /**
     * Sale out mark. If set, product can not be ordered in common way.
     * @var bool
     */
    public $stock_clearance;
    public $original_price;
    
    public function __construct($id_product = null, $full = false, $id_lang = null, $id_shop = null, Context $context = null)
    {
        parent::__construct($id_product, $full, $id_lang, $id_shop, $context);
        
        $this->def['fields']['stock_clearance'] = array(
            'type' => self::TYPE_INT
        );
        $this->def['fields']['original_price'] = array(
            'type' => self::TYPE_FLOAT
        );
    }
    
    public static function getCMSContent($id_cms, $id_lang)
    {
        $cms = new CMS($id_cms, $id_lang);
        return $cms->content;
    }
    
    
    /**
    * Get all available products. Extended so it can read products from several categories at once
    *
    * @param int $id_lang Language id
    * @param int $start Start number
    * @param int $limit Number of products to return
    * @param string $order_by Field for ordering
    * @param string $order_way Way for ordering (ASC or DESC)
    * @return array Products details
    */
    public static function getProducts($id_lang, $start, $limit, $order_by, $order_way, $id_category = false,
        $only_active = false, Context $context = null)
    {
        if (!$context) {
            $context = Context::getContext();
        }

        $front = true;
        if (!in_array($context->controller->controller_type, array('front', 'modulefront'))) {
            $front = false;
        }

        if (!Validate::isOrderBy($order_by) || !Validate::isOrderWay($order_way)) {
            die(Tools::displayError());
        }
        if ($order_by == 'id_product' || $order_by == 'price' || $order_by == 'date_add' || $order_by == 'date_upd') {
            $order_by_prefix = 'p';
        } elseif ($order_by == 'name') {
            $order_by_prefix = 'pl';
        } elseif ($order_by == 'position') {
            $order_by_prefix = 'c';
        }

        if (strpos($order_by, '.') > 0) {
            $order_by = explode('.', $order_by);
            $order_by_prefix = $order_by[0];
            $order_by = $order_by[1];
        }
        
        
        $sql = 'SELECT p.*, product_shop.*, pl.* , m.`name` AS manufacturer_name, s.`name` AS supplier_name
				FROM `'._DB_PREFIX_.'product` p
				'.Shop::addSqlAssociation('product', 'p').'
				LEFT JOIN `'._DB_PREFIX_.'product_lang` pl ON (p.`id_product` = pl.`id_product` '.Shop::addSqlRestrictionOnLang('pl').')
				LEFT JOIN `'._DB_PREFIX_.'manufacturer` m ON (m.`id_manufacturer` = p.`id_manufacturer`)
				LEFT JOIN `'._DB_PREFIX_.'supplier` s ON (s.`id_supplier` = p.`id_supplier`)'.
                ($id_category ? 'LEFT JOIN `'._DB_PREFIX_.'category_product` c ON (c.`id_product` = p.`id_product`)' : '').'
				WHERE pl.`id_lang` = '.(int)$id_lang;
        
        if (is_array($id_category))
        {
            $sql .= ' AND c.`id_category` in ('.implode(',', $id_category).')';
        }
        else
        {
            $sql .= ($id_category ? ' AND c.`id_category` = '.(int)$id_category : '');
        }
        $sql .= ($front ? ' AND product_shop.`visibility` IN ("both", "catalog")' : '').
                    ($only_active ? ' AND product_shop.`active` = 1' : '').
                ' group by p.id_product '.
                ' ORDER BY '.(isset($order_by_prefix) ? pSQL($order_by_prefix).'.' : '').'`'.pSQL($order_by).'` '.pSQL($order_way).
                ($limit > 0 ? ' LIMIT '.(int)$start.','.(int)$limit : '');
        /*echo $sql;
        exit;*/
        $rq = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
        if ($order_by == 'price') {
            Tools::orderbyPrice($rq, $order_way);
        }

        foreach ($rq as &$row) {
            $row = Product::getTaxesInformations($row);
        }

        return ($rq);
    }

    
    /**
     * Get all available attribute groups
     *
     * @param int $id_lang Language id
     * @param int $addSku flag that tells to add sku in result, should be equal to supplier id
     * @return array Attribute groups
     */
    public function getAttributesGroups($id_lang, $addSku=0)
    {
        if (!Combination::isFeatureActive()) {
            return array();
        }

        $sql = 'SELECT ag.`id_attribute_group`, ag.`is_color_group`, agl.`name` AS group_name, agl.`public_name` AS public_group_name,
					a.`id_attribute`, al.`name` AS attribute_name, a.`color` AS attribute_color, product_attribute_shop.`id_product_attribute`,
					IFNULL(stock.quantity, 0) as quantity, product_attribute_shop.`price`, product_attribute_shop.`ecotax`, product_attribute_shop.`weight`,
					product_attribute_shop.`default_on`, pa.`reference`, product_attribute_shop.`unit_price_impact`,
					product_attribute_shop.`minimal_quantity`, product_attribute_shop.`available_date`, ag.`group_type`'.
                                        ($addSku?', ps.product_supplier_reference ':'').
				'FROM `'._DB_PREFIX_.'product_attribute` pa
				'.Shop::addSqlAssociation('product_attribute', 'pa').'
				'.Product::sqlStock('pa', 'pa').
                                ($addSku?' left join '._DB_PREFIX_.'product_supplier ps on pa.id_product=ps.id_product and
                                    pa.id_product_attribute=ps.id_product_attribute and ps.id_supplier='.intval($addSku):'').
				' LEFT JOIN `'._DB_PREFIX_.'product_attribute_combination` pac ON (pac.`id_product_attribute` = pa.`id_product_attribute`)
				LEFT JOIN `'._DB_PREFIX_.'attribute` a ON (a.`id_attribute` = pac.`id_attribute`)
				LEFT JOIN `'._DB_PREFIX_.'attribute_group` ag ON (ag.`id_attribute_group` = a.`id_attribute_group`)
				LEFT JOIN `'._DB_PREFIX_.'attribute_lang` al ON (a.`id_attribute` = al.`id_attribute`)
				LEFT JOIN `'._DB_PREFIX_.'attribute_group_lang` agl ON (ag.`id_attribute_group` = agl.`id_attribute_group`)
				'.Shop::addSqlAssociation('attribute', 'a').'
				WHERE pa.`id_product` = '.(int)$this->id.'
					AND al.`id_lang` = '.(int)$id_lang.'
					AND agl.`id_lang` = '.(int)$id_lang.'
				GROUP BY id_attribute_group, id_product_attribute
				ORDER BY ag.`position` ASC, a.`position` ASC, agl.`name` ASC';
        return Db::getInstance()->executeS($sql);
    }

    
    /**
     * Gets expected delivery data from vipdress database
     * @return false|NULL|mysqli_result|PDOStatement|resource
     */
    public function getExpectedDelivery()
    {
        $query = '
            SELECT vd_soi.quantity-vd_soi.arrived_quantity AS expected_quantity, vd_so.exp_arrive_date, 
                vd_pa.supplier_reference, pa.id_product_attribute,
                vd_pa.id_product_attribute as vd_id_product_attribute
            FROM '.VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product vd_p
            INNER JOIN '.VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product_attribute vd_pa 
                ON vd_p.id_product = vd_pa.id_product
            INNER JOIN '.VIPDRESS_DB_NAME.'.os_supplier_order_item vd_soi
                ON vd_soi.combination_id = vd_pa.id_product_attribute
            INNER JOIN '.VIPDRESS_DB_NAME.'.os_supplier_order vd_so
                ON vd_so.id = vd_soi.order_id
            INNER JOIN '._DB_PREFIX_.'product_attribute pa 
                ON pa.supplier_reference = vd_pa.supplier_reference
            WHERE vd_p.supplier_reference = "'. pSQL($this->supplier_reference) .'"
                AND vd_so.order_arrived = 0
                AND UNIX_TIMESTAMP(vd_so.exp_arrive_date) > 0
                AND vd_soi.quantity-vd_soi.arrived_quantity > 0
            ORDER BY vd_so.exp_arrive_date ASC
        ';
        //GROUP BY pa.id_product_attribute
        return Db::getInstance()->executeS($query);
    }
    
    
    /**
     * Gets dbk stock from vipdress database
     * @return [id_product_attribute => dbk_quantity]
     */
    public function getDbkStock()
    {
        $query = '
            SELECT vd_pa.supplier_reference, pa.id_product_attribute,
                vd_pa.id_product_attribute as vd_id_product_attribute, sum(if(ds.quantity>0, ds.quantity, 0)) as dbk_quantity
            FROM ('.VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product vd_p
            inner JOIN '.VIPDRESS_DB_NAME .'.'. VIPDRESS_DB_PREFIX.'product_attribute vd_pa 
                ON vd_p.id_product = vd_pa.id_product)
            INNER JOIN '._DB_PREFIX_.'product_attribute pa 
                ON pa.supplier_reference = vd_pa.supplier_reference
            inner join ('.VIPDRESS_DB_NAME.'.os_dbk_product dp inner join '.VIPDRESS_DB_NAME.'.os_dbk_stock ds on dp.id=ds.dbk_product_id)
                on dp.ps_product_id=vd_p.id_product and vd_pa.id_product_attribute=dp.ps_attr_id
            WHERE pa.id_product = "'. pSQL($this->id) .'"
                group by pa.id_product_attribute
        ';
        $products = Db::getInstance()->executeS($query);
        $result = [];
        foreach($products as $product)
        {
            $result[$product['id_product_attribute']] = $product['dbk_quantity'];
        }
        return $result;
    }
    

    /**
     * Returns sold quantity of the product 
     * @param int $id_product_attribute
     * @param DateTime $periodFrom
     * @param DateTime $periodTo
     * @return number
     */
    public function getSales($id_product_attribute = null, $periodFrom = null, $periodTo = null)
    {
        /**
         * @var DbQueryCore $dbQuery
         */
        $dbQuery = new DbQuery();
        $dbQuery
            ->select('
                SUM(od.`product_quantity` - od.`product_quantity_refunded` - od.`product_quantity_return` - od.`product_quantity_reinjected`)
                    AS sold_quantity
            ')
            ->from('order_detail', 'od')
            ->innerJoin('orders', 'o', 'o.id_order = od.id_order')
            ->where('o.current_state != '. intval(Configuration::get('PS_OS_CANCELED')) )
            ->where('od.product_id = '. intval($this->id))
        ;

        if( !is_null($id_product_attribute) ){
            $dbQuery->where('od.product_attribute_id = '. intval($id_product_attribute));
        }
        if( !is_null($periodFrom) && ($periodFrom instanceof DateTime) ){
            $dbQuery->where('o.date_add >= "'. $periodFrom->format('Y-m-d 00:00:00') .'" ');
        }
        if( !is_null($periodTo) && ($periodTo instanceof DateTime) ){
            $dbQuery->where('o.date_add <= "'. $periodTo->format('Y-m-d 00:00:00') .'" ');
        }
        
        return (int) Db::getInstance()->getValue($dbQuery);
        
    }

    public static function getProductProperties($id_lang, $row, Context $context = null)
    {
        $productProperties = parent::getProductProperties($id_lang, $row, $context);
        
        if( $productProperties === false ){
            return false;
        }
        
        if( !empty($row['supplier_reference']) ){
            $supplierReferenceParts = null;
            if( preg_match(KOEHLERT_SPL_REF_NOSIZE_REGEX, $row['supplier_reference'], $supplierReferenceParts) ){
                $productProperties['supplier_reference_code'] = $supplierReferenceParts[1];
            }
        }
        
        return $productProperties;
    }
    
    public function getSupplierReferenceNumber()
    {
        if( !empty($this->supplier_reference) 
            && preg_match(KOEHLERT_SPL_REF_NOSIZE_REGEX, $this->supplier_reference, $supplierReferenceParts)
        ){
            return $supplierReferenceParts[1];
        }
        else{
            return null;
        }
    }
    
    public function getSupplierReferenceColor()
    {
        if( !empty($this->supplier_reference)
            && preg_match(KOEHLERT_SPL_REF_NOSIZE_REGEX, $this->supplier_reference, $supplierReferenceParts)
            ){
                return $supplierReferenceParts[2];
        }
        else{
            return null;
        }
    }
    
    
    /**
     * Sets new clerance status for product, recalculates price
     * @param type $clearance new clearance status
     */
    public function changeClearanceStatus($clearance, $sendToCentralStore=true)
    {
        if ($clearance == $this->stock_clearance)
        {
            return;
        }
        // save original price
        if ($this->stock_clearance==self::StockClearanceNo)
        {
            $this->original_price = $this->price;
        }
        
        // we have no record about original price
        if ($this->original_price == 0)
        {
            switch ($this->stock_clearance)
            {
                case Product::StockClearance1:
                    $this->original_price = $product->price / (1 - Configuration::get('PL_CLEARANCE1_PRCNT') / 100);
                    break;
                case Product::StockClearance2:
                    $this->original_price = $product->price / (1 - Configuration::get('PL_CLEARANCE2_PRCNT') / 100);
                    break;
                case Product::StockClearance3:
                    $this->original_price = $product->price / (1 - Configuration::get('PL_CLEARANCE3_PRCNT') / 100);
                    break;
            }
        }

        // relaculate price
        switch($clearance)
        {
            case self::StockClearance1:
                $this->price = $this->original_price - $this->original_price*Configuration::get('PL_CLEARANCE1_PRCNT')/100;
                //attach product to Sale category
                $this->addToCategories(Category::SaleCategoryId);
                break;
            case self::StockClearance2:
                $this->price = $this->original_price - $this->original_price*Configuration::get('PL_CLEARANCE2_PRCNT')/100;
                //attach product to Sale category
                $this->addToCategories(Category::SaleCategoryId);
                break;
            case self::StockClearance3:
                $this->price = $this->original_price - $this->original_price*Configuration::get('PL_CLEARANCE3_PRCNT')/100;
                //attach product to Sale category
                $this->addToCategories(Category::SaleCategoryId);
                break;
            default:
                $clearance = self::StockClearanceNo;
                $this->price = $this->original_price;
                // remove product from sale category
                $this->deleteCategory(Category::SaleCategoryId);
                break;
        }
        
        $this->stock_clearance = $clearance;
        $this->save();
        
        if ($sendToCentralStore)
        {
            $msss_client = ModuleCore::getInstanceByName('msss_client');
            $msss_client->scheduleClearanceModeChange($this->supplier_reference, $clearance);
            $msss_client->sendMessagesToServerParallel();
        }
    }
}

/**
ALTER TABLE `prs_product` ADD `stock_clearance` BOOLEAN NOT NULL DEFAULT FALSE AFTER `default_text_hash`;
 */