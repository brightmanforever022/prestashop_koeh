<?php

class KoehlertSpladminIndexController
{

    public function __construct()
    {
        
    }
    
    public function dispatch()
    {
        $action = isset($_POST['action']) ? $_POST['action'] : 'list';
        
        $action = ToolsCore::toCamelCase($action, true);
        
        $methodName = 'action'.$action;
        if( method_exists($this, $methodName) ){
            return call_user_func_array(array($this, $methodName), array());
        }
        else{
            return array('errors' => array('Unknown action'));
        }
    }
    
    public function actionList()
    {
        $query = '
            SELECT SQL_CALC_FOUND_ROWS 
                pa.id_product_attribute, pa.supplier_reference, i.id_image
            FROM `prs_product_attribute` pa
            INNER JOIN `prs_image` i ON i.id_product = pa.id_product
            WHERE i.cover = 1 
        ';

        $perPage = intval(@$_POST['per_page']) ? intval($_POST['per_page']) : 50;
        $page = intval(@$_POST['page']) ? intval($_POST['page']) : 1;
        $searchReference = '';
        
        if( !empty($_POST['reference']) ){
            if( isset($_POST['subact']) && ($_POST['subact'] == 'search') ){
                $page = 1;
            }
            if( isset($_POST['subact']) && ($_POST['subact'] == 'reset') ){
                $page = 1;
            }
            else{
                $searchReference = preg_replace('#^[^a-z0-9_\-\=\+\&\#\*]$#', '', $_POST['reference']);
                $query .= ' AND pa.`supplier_reference` LIKE "%'. $searchReference .'%"';
            }
        }
        
        $query .= ' ORDER BY pa.`supplier_reference` ASC ';
        
        if( $perPage ) {
            if( !empty($page) && ($page > 1) ) {
                $query .= ' LIMIT ' . ($page - 1) * $perPage . ',' . $perPage;
            } else {
                $query .= ' LIMIT ' . $perPage;
            }
        }
        else{
            $query .= ' LIMIT 50';
        }
        
        $attributesList = Db::getInstance()->executeS($query);
        
        $attributesListTotalCount = Db::getInstance()->getValue('
            SELECT FOUND_ROWS() AS `total_count`
        ');
        
        return array(
            'attributesList' => $attributesList,
            'attributesListTotalCount' => $attributesListTotalCount,
            'paginationPage' => $page,
            'paginationPerPage' => $perPage,
            'paginationPagesCount' => ceil( $attributesListTotalCount / $perPage ),
            'searchReference' => $searchReference,
            'supplierOrdersNotDeliveredList' => $this->getSupplierOrders(false)
        );
    }

    public function actionDownloadPhotos()
    {
        //var_dump($_POST['attribute']);die;
        
        $actionData = array(
            'errors' => array()
        );
        
        if( empty($_POST['id_product_attribute']) ){
            $actionData['errors'][] = 'Products does not selected';
            return $actionData;
        }
        
        $productIdList = array();
        
        foreach( $_POST['id_product_attribute'] as $id_product_attribute ){
            $postProductId = (int) Db::getInstance()->getValue('
                SELECT id_product
                FROM `prs_product_attribute`
                WHERE `id_product_attribute` = '. intval($id_product_attribute) .'
            ');
            
            if( !array_search($postProductId, $productIdList) ){
                $productIdList[] = $postProductId;
            }
        }
        
        $zip = new ZipArchive();
        $zipFile = tempnam("tmp", "zip");
        
        if ($zip->open($zipFile, ZipArchive::CREATE)!==TRUE) {
            $actionData['errors'][] = "cannot open <$zipFile>";
            return $actionData;
        }
        
        foreach($productIdList as $productId){
            $product = new Product($productId);
            $productImageRow = ProductCore::getCover($productId);
            if( !is_array($productImageRow) || !count($productImageRow) ){
                continue;
            }
            
            $image = new Image($productImageRow['id_image']);
            
            $productImagePath = _PS_IMG_DIR_ . 'p/'. $image->getExistingImgPath() .'.jpg';
            $productImageZipFilename = $product->supplier_reference .'.jpg';
            
            if( !$zip->addFile($productImagePath, $productImageZipFilename) ){
                $actionData['errors'][] = 'Image "'.$productImagePath.'" not added to archive';
                continue;
            }
            
        }
        
        if( $zip->numFiles == 0 ){
            $actionData['errors'][] = 'No images added to the archive';
            return $actionData;
        }
        
        try{
            $closed = $zip->close();
        }
        catch(Exception $e){
            $actionData['errors'][] = 'ERROR: '. $e->getMessage();
            return $actionData;
        }
        
        if( $closed !== true){
            $actionData[] = 'ERROR: Closed with status - '. $closed;
            return $actionData;
        }
        
        if( headers_sent($filename, $linenum) ){
            $actionData['errors'][] = "Archive can not be downloaded, headers already sent in $filename on line $linenum";
            return $actionData;
        }
        
        $archiveName = 'products_images.zip';
        header("Content-Type: application/zip");
        header("Content-Length: " . filesize($zipFile));
        header("Content-Disposition: attachment; filename=\"$archiveName\"");
        readfile($zipFile);
        
        unlink($zipFile);
    }
    
    public function actionPdfLabels()
    {
        $actionData = array(
            'errors' => array()
        );
        
        if( empty($_POST['id_product_attribute']) ){
            $actionData['errors'][] = 'Products does not selected';
            return $actionData;
        }
        
        set_time_limit(0);
        
        $labelsData = array();
        
        foreach($_POST['id_product_attribute'] as $id_product_attribute){
            $combination = Db::getInstance()->getRow('
                SELECT *
                FROM `prs_product_attribute`
                WHERE `id_product_attribute` = '. intval($id_product_attribute) .'
            ');
            
            if(!is_array($combination) || !count($combination)){
                continue;
            }
            
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
        
        if( !count($labelsData) ){
            $this->errors[] = 'No object loaded';
        }
        
        if( count($this->errors) ){
            return;
        }
        
        ProductLabel::generatePdf($labelsData);
    }

    protected function getSupplierOrders($delivered = null)
    {
        $query = '
            SELECT so.*, sum(soi.quantity) as total_quantity, sum(soi.arrived_quantity) as total_arrived
            FROM `'.VIPDRESS_DB_NAME.'`.`os_supplier_order` so
            LEFT JOIN `'.VIPDRESS_DB_NAME.'`.`os_supplier_order_item` soi ON soi.order_id = so.id
            WHERE 1
        ';
        if( !is_null($delivered) ){
            if( $delivered == true ){
                $query .= ' AND so.order_arrived = 1';
            }
            else{
                $query .= ' AND so.order_arrived = 0';
            }
        }
        $query .= ' GROUP BY so.id';
        
        return Db::getInstance()->executeS($query);
    }

    public function actionSupplierOrderPdfLabels()
    {
        $labelsData = array();
        $supplierOrderId = intval($_POST['supplier_order_id']);
        
        $query = '
            SELECT so.order_name, soi.quantity, p.id_product, pa.id_product_attribute, pa.ean13,
                pa.supplier_reference
            FROM `'.VIPDRESS_DB_NAME.'`.`os_supplier_order_item` soi 
            LEFT JOIN `'.VIPDRESS_DB_NAME.'`.`os_supplier_order` so ON soi.order_id = so.id
            LEFT JOIN `'.VIPDRESS_DB_NAME.'`.`'.VIPDRESS_DB_PREFIX.'product` p ON  soi.product_id = p.id_product
            LEFT JOIN `'.VIPDRESS_DB_NAME.'`.`'.VIPDRESS_DB_PREFIX.'product_attribute` pa ON soi.combination_id=pa.id_product_attribute
            WHERE soi.order_id = '. $supplierOrderId .'
                AND soi.quantity > 0
            ORDER BY pa.supplier_reference
        ';

        $supplierOrderProducts = Db::getInstance()->executeS($query);
        
        foreach($supplierOrderProducts as $item){
            $splRefPartsMatches = array();
            if( !preg_match(KOEHLERT_SPL_REF_WITHSIZE_REGEX, $item['supplier_reference'], $splRefPartsMatches) ){
                continue;
            }
            $labelsData[] = array(
                'supplier_reference' => $splRefPartsMatches[1],
                'name' => $splRefPartsMatches[2],
                'id_product' => intval($item['id_product']),
                'id_product_attribute' => intval($item['id_product_attribute']),
                'size' => $splRefPartsMatches[3],
                'quantity' => $item['quantity'],
                'ean13' => $item['ean13']
            );
        }
        
        ProductLabel::generatePdf($labelsData);
    }
    
}

