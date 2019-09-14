<?php
opcache_reset();
require_once _PS_ROOT_DIR_ . '/modules/khleans/EanManager.php';

class KhleansCronModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        set_time_limit(600);
        switch( Tools::getValue('action') ){
            case 'exp_mob':
                $this->exportForMobileApp();
                break;
            default:
                $this->checkNUpdate();
                $this->exportToVDAll();
                $this->exportForMobileApp();
                break;
        }
    }
    
    public function fillProducts()
    {
        set_time_limit(0);
        $this->ajax = 1;
        
        if($this->context->shop->domain == 'www.koehlert.com'){
            $remoteExportUrl = 'https://www.vipdress.de/modules/khleans/service.php';
        }
        else{
            $remoteExportUrl = 'http://nsweb.server/vipdress/modules/khleans/service.php';
        }
        die;
        $eansManager = new EanManager();
        
        Db::getInstance()->query('
            UPDATE `'._DB_PREFIX_.'product_attribute` SET `ean13` = ""
        ');
        Db::getInstance()->query('
            UPDATE `'._DB_PREFIX_.'ean` SET `used` = 0
        ');
        
        
        $productsResource = Db::getInstance()->query('
            SELECT id_product
            FROM `'._DB_PREFIX_.'product`
            
        ');
        
        while( $productRow = Db::getInstance()->nextRow($productsResource) ){
            //var_dump($productRow);
            //die;
            $productAttrs = Db::getInstance()->executeS('
                SELECT id_product_attribute
                FROM `'._DB_PREFIX_.'product_attribute`
                WHERE id_product = '. intval($productRow['id_product']) .'
            ');
            if( !is_array($productAttrs) || !count($productAttrs) ){
                echo 'ATTRIBUTES NOT FOUND: '. $productRow['id_product'].'<br>';
                continue;
            }
            
            $prodAttrsCount = count($productAttrs);
            
            $eansFree = Db::getInstance()->executeS('
                SELECT * FROM `'._DB_PREFIX_.'ean` WHERE `used` = 0 LIMIT '. $prodAttrsCount .'
            ');
            
            foreach($productAttrs as $productAttr){
                $freeEanKey = null;
                foreach( $eansFree as $fek => $freeEan ){
                    if($freeEan['used'] == '0'){
                        $freeEanKey = $fek;
                        break;
                    }
                }
                if(is_null($freeEanKey)){
                    echo 'FREE EAN NOT FOUND = P: '. $productRow['id_product']. ', A: '. $productAttr['id_product_attribute'].'<br>';
                    continue;
                }
                
                Db::getInstance()->update('product_attribute', array(
                    'ean13' => $eansFree[$freeEanKey]['code']
                ), 'id_product_attribute = '. intval($productAttr['id_product_attribute']) );
                
                $eansFree[$freeEanKey]['used'] = 1;
                
                Db::getInstance()->update('ean', array(
                    'used' => 1
                ), 'id = '. intval($eansFree[$freeEanKey]['id']) );
                
            }
            echo 'EANs filled: '. $productRow['id_product'].'. ATTRS count: '. $prodAttrsCount .'<br>';
            
            $productAttrs = Db::getInstance()->executeS('
                SELECT supplier_reference, ean13
                FROM `'._DB_PREFIX_.'product_attribute`
                WHERE id_product = '. intval($productRow['id_product']) .'
            ');
            if( !is_array($productAttrs) || !count($productAttrs) ){
                echo 'ATTRIBUTES NOT FOUND: '. $productRow['id_product'].'<br>';
                continue;
            }
            
            /*$remoteExportData = array();
            foreach($productAttrs as $productAttr){
                $remoteExportData[] = array(
                    'supplier_reference' => $productAttr['supplier_reference'],
                    'ean13' => $productAttr['ean13']
                );
            }*/
            
            try{
                $exportResult = $eansManager->exportToRemote($remoteExportUrl, $productAttrs);
            }
            catch(Exception $e){
                echo 'EXPORT ERROR: '. $e->getMessage().'<br>';
                continue;
            }
            
            if(!$exportResult['success']){
                echo 'EXPORT FAILED: '. $exportResult['message'].'<br>';
                continue;
            }
            echo 'EXPORT : '. $exportResult['message'].'<br>';
        }
        
        $duplicates = EanManager::getDuplicatedEans();
        echo 'DUPLICATES:<br>';
        var_dump($duplicates);
    }
    
    public function exportToVDAll()
    {
        $this->ajax = true;
        $report = array();
        
        if($this->context->shop->domain == 'www.koehlert.com'){
            $remoteExportUrl = 'https://www.vipdress.de/modules/khleans/service.php';
        }
        else{
            $remoteExportUrl = 'http://nsweb.server/vipdress/modules/khleans/service.php';
        }
        
        $eansManager = new EanManager();
        
        $productsResource = Db::getInstance()->query('
            SELECT id_product
            FROM `'._DB_PREFIX_.'product`
        ');

        while( $productRow = Db::getInstance()->nextRow($productsResource) ){
            $result = $this->module->exportToVD($productRow['id_product']);
            if(is_array($result)){
                $report[] = implode(' - ', $result);
            }
        }
        //var_dump( implode("\n", $report) );
    }
    
    /**
     * Generates files to use in warehouse applications
     */
    public function exportForMobileApp()
    {
        $this->ajax = true;
        $folder = 'shared';
        
        $productCombinationsList = Db::getInstance()->executeS('
            SELECT id_product_attribute, id_product, supplier_reference, ean13
            FROM `'._DB_PREFIX_.'product_attribute`
        ');
        
        if( !is_array($productCombinationsList) || !count($productCombinationsList)){
            PrestaShopLogger::addLog(__CLASS__ .'::'.__FUNCTION__ .': no eans to export', 4);
            return;
        }
        
        $productsRefEan = array();
        $productsCombinationsComplete = array();
        
        if($this->context->shop->domain == 'www.koehlert.com'){
            $exportPath = $exportPath2 = DIRECTORY_SEPARATOR . $folder;
        }
        else{
            $exportPath = $exportPath2 = _PS_ROOT_DIR_ .DIRECTORY_SEPARATOR. $folder;
        }
        
        if( !is_writable($exportPath) ){
            //echo __CLASS__ .'::'.__FUNCTION__ .': export path error';
            PrestaShopLogger::addLog(__CLASS__ .'::'.__FUNCTION__ .': export path error', 4);
            return;
        }
        
        foreach($productCombinationsList as $i => $productCombination){
            $productsRefEan[] = array(
                'supplier_reference' => $productCombination['supplier_reference'],
                'ean13' => $productCombination['ean13']
            );
            
            $productCombinationsList[$i]['price'] = Product::getPriceStatic(
                $productCombination['id_product'], false, $productCombination['id_product_attribute']
            );
            
            $productsCombinationsComplete[] = $productCombinationsList[$i];
        }
        
        $productsRefEanJson = json_encode($productsRefEan);
        if( $productsRefEanJson === false){
            PrestaShopLogger::addLog(__CLASS__ .'::'.__FUNCTION__ .': json error', 4);
            return;
        }
        
        $exportPath .= '/refs_eans.json';
        $written = file_put_contents($exportPath, $productsRefEanJson);
        
        if( $written === false ){
            PrestaShopLogger::addLog(__CLASS__ .'::'.__FUNCTION__ .': file write error', 4);
            return;
        }

        // generate second file
        $productsCombinationsCompleteJson = json_encode($productsCombinationsComplete);
        if( $productsCombinationsCompleteJson === false){
            PrestaShopLogger::addLog(__CLASS__ .'::'.__FUNCTION__ .': json error', 4);
            return;
        }
        
        $exportPath2 .= '/refs_eans_prices.json';
        $written = file_put_contents($exportPath2, $productsCombinationsCompleteJson);
        
        if( $written === false ){
            PrestaShopLogger::addLog(__CLASS__ .'::'.__FUNCTION__ .': file write error', 4);
            return;
        }
        
        $jsonResult = json_decode(file_get_contents($exportPath), true);
        
        $report = 'N/A';
        if( is_null($jsonResult) ){
            $report = 'ERROR';
        }
        elseif( is_array($jsonResult) ){
            $report = 'OK';
        }

    }
    
    public function checkNUpdate()
    {
        $this->ajax = true;
        $report = array(); 
        
        if($this->context->shop->domain == 'www.koehlert.com'){
            $remoteExportUrl = 'https://www.vipdress.de/modules/khleans/service.php';
        }
        else{
            $remoteExportUrl = 'http://nsweb.server/vipdress/modules/khleans/service.php';
        }
        $eansManager = new EanManager();
        
        // check if attribute with issued ean was deleted. mark ean free if so
        $notUsedEansQuery = '
            SELECT e.id, e.code, e.supplier_reference, pa.id_product_attribute
            FROM `'._DB_PREFIX_.'ean` e
            LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa
                ON pa.supplier_reference = e.supplier_reference
            WHERE 
                e.used = 1
                AND e.keeper = '. Ean::KEEPER_KOEHLERT .'
            HAVING ISNULL(pa.`id_product_attribute`)
        ';
        $notUsedEans = Db::getInstance()->executeS($notUsedEansQuery);
        if( is_array($notUsedEans) && count($notUsedEans) ){
            foreach($notUsedEans as $notUsedEan){
                if( !empty($notUsedEan['id_product_attribute']) ){
                    // nothing to do
                    continue;
                }
                // ean must be marked free
                Db::getInstance()->update('ean', array(
                    'used' => 0,
                    'supplier_reference' => '',
                    'keeper' => 0
                ), 'id = '. intval($notUsedEan['id']) );
                $report[] = 'EAN marked as free: "'. $notUsedEan['code'] .'", not linked anymore to "'. $notUsedEan['supplier_reference'] .'"';
            }
        }
        
        try{
            $duplicates = EanManager::getDuplicatedEans();
        }
        catch(Exception $e){
            $report[] = $e->getMessage();
        }
        
        if( is_array($duplicates) && count($duplicates) ){
            
            foreach($duplicates as $doubledEan){
                $message = 'DUPLICATED EAN: '. $doubledEan['ean13'] .'.';
                $duplQuery = '
                    SELECT ps.`product_supplier_reference` AS supplier_reference
                    FROM `'._DB_PREFIX_.'product_attribute` pa
                    INNER JOIN `'._DB_PREFIX_.'product_supplier` ps 
                        ON ps.id_product_attribute = pa.id_product_attribute
                        AND ps.id_product = pa.id_product
                    INNER JOIN `'._DB_PREFIX_.'product` p on p.id_product = pa.id_product
                    WHERE pa.`ean13` = "'. pSQL($doubledEan['ean13']) .'"
                ';
                $duplicatedProducts = Db::getInstance()->executeS($duplQuery);
                $message .= ' References: ';
                foreach($duplicatedProducts as $doubledProds){
                    $message .= '"'. $doubledProds['supplier_reference'] .'"; ';
                }
                $report[] = $message;
            }
        }
        
        //////////////////////
        $productNoEanAttrs = Db::getInstance()->executeS('
            SELECT pa.id_product_attribute, pa.supplier_reference
            FROM `'._DB_PREFIX_.'product_attribute` pa
            INNER JOIN `'._DB_PREFIX_.'product_supplier` ps ON ps.id_product_attribute = pa.id_product_attribute
            WHERE `ean13` = ""
                AND ps.id_supplier = '. intval(EanManager::$supplierIdManage) .'
                AND pa.`supplier_reference` != ""
        ');
        
        $exportData = array();
        
        if(is_array($productNoEanAttrs) && count($productNoEanAttrs)){
            foreach($productNoEanAttrs as $prodAttrNoEan){
                // check is ean was previously assigned
                $eanWasAssigned = Db::getInstance()->getRow('
                    SELECT * FROM `'._DB_PREFIX_.'ean` 
                    WHERE `supplier_reference` = "'. pSQL($prodAttrNoEan['supplier_reference']) .'"
                        AND `used` = 1
                ');
                if( is_array($eanWasAssigned) && !empty($eanWasAssigned['id']) ){
                    Db::getInstance()->update('product_attribute', array(
                        'ean13' => $eanWasAssigned['code']
                    ), 'id_product_attribute = '. intval($prodAttrNoEan['id_product_attribute']) );
                    
                    $report[] = 'Warning! Set back AGAIN EAN "'. $eanFree['code'] .'" for "'. $prodAttrNoEan['supplier_reference'] .'". '.
                        'Attribute or EAN of attribute was deleted?';
                    // ean set back for attribute, nothing more to do, continue
                    continue;
                }
                
                $eanFree = Db::getInstance()->getRow('
                    SELECT * FROM `'._DB_PREFIX_.'ean` WHERE `used` = 0
                ');
                if(!is_array($eanFree) || !count($eanFree)){
                    $report[] = 'NO FREE EAN FOUND FOR "'.$prodAttrNoEan['supplier_reference'].'"';
                    continue;
                }
                
                Db::getInstance()->update('product_attribute', array(
                    'ean13' => $eanFree['code']
                ), 'id_product_attribute = '. intval($prodAttrNoEan['id_product_attribute']) );
                
                $exportData[] = array(
                    'supplier_reference' => $prodAttrNoEan['supplier_reference'],
                    'ean13' => $eanFree['code']
                );
                
                Db::getInstance()->update('ean', array(
                    'used' => 1,
                    'supplier_reference' => $prodAttrNoEan['supplier_reference'],
                    'keeper' => Ean::KEEPER_KOEHLERT
                ), 'id = '. intval($eanFree['id']) );
                
                $report[] = 'Set EAN "'. $eanFree['code'] .'" for "'. $prodAttrNoEan['supplier_reference'] .'"';
            }
            
            if( is_array($exportData) && count($exportData) ){
                try{
                    $exportResult = $eansManager->exportToRemote($remoteExportUrl, $exportData);
                }
                catch(Exception $e){
                    $report[] = 'EXPORT ERROR: '. $e->getMessage();
                }
                
                if(!$exportResult['success']){
                    $report[] = 'EXPORT FAILED : '. $exportResult['message'];
                }
            }
        }
        
        //////////////////////
        $eansSyncQuery = '
            SELECT ean.*, pa.id_product_attribute, pa.ean13,
                ps.`product_supplier_reference` AS supplier_reference
            FROM `'._DB_PREFIX_.'ean` ean 
            LEFT JOIN `'._DB_PREFIX_.'product_attribute` pa ON pa.`ean13` = ean.`code`
            INNER JOIN `'._DB_PREFIX_.'product_supplier` ps 
                ON ps.id_product_attribute = pa.id_product_attribute
                AND ps.id_product = pa.id_product
            WHERE ps.id_supplier = '. intval(EanManager::$supplierIdManage) .'
        ';
        $eansToSyncRes = Db::getInstance()->query($eansSyncQuery);
        while( $eansToSync = Db::getInstance()->nextRow($eansToSyncRes) ){
            /*if( empty($eansToSync['ean13']) && ($eansToSync['used'] == '1') ){
                Db::getInstance()->update('ean', array(
                    'used' => 0
                ), 'id = '. intval($eansToSync['id']) );
            }*/
            if( !empty($eansToSync['ean13']) && ($eansToSync['used'] == '0') ){
                Db::getInstance()->update('ean', array(
                    'used' => 1,
                    'supplier_reference' => $eansToSync['supplier_reference'],
                    'keeper' => Ean::KEEPER_KOEHLERT
                ), 'id = '. intval($eansToSync['id']) );
            }
        }
        
        // find order details with empty eans, fill it if possible
        $orderDetailNoEanQuery = '
            SELECT od.id_order_detail, pa.ean13 AS pa_ean13
            FROM `'._DB_PREFIX_.'order_detail` od
            INNER JOIN `'._DB_PREFIX_.'product_attribute` pa 
                ON pa.id_product_attribute = od.product_attribute_id
            WHERE od.product_ean13 = ""
                AND pa.ean13 != ""
        ';
        $orderDetailNoEans = Db::getInstance()->executeS($orderDetailNoEanQuery);
        if( is_array($orderDetailNoEans) && count($orderDetailNoEans) ){
            foreach($orderDetailNoEans as $orderDetailNoEan ){
                Db::getInstance()->update('order_detail', array(
                    'product_ean13' => $orderDetailNoEan['pa_ean13']
                ), 'id_order_detail = '. $orderDetailNoEan['id_order_detail']);
            }
        }
        
        // check for differences between koehlert and vipdress shops
        $shopsEanDiffList = EanManager::getKoehlertToVipdressEanDiff();
        if( is_array($shopsEanDiffList) ){
            if( count($shopsEanDiffList) ){
                $report[] = 'FOUND EANS DIFFS BETWEEN KOEHLERT AND VIPDRESS';
            }
            foreach($shopsEanDiffList as $shopsEanDiff){
                $report[] = $shopsEanDiff['supplier_reference'] . ' = '.
                    ' koehlert: '. $shopsEanDiff['k_ean13'].', '.
                    ' vipdress: '. $shopsEanDiff['v_ean13']
                ;
            }
        }
        else{
            $report[] = 'FAILED TO CHECK DIFFERENCE KOEHLERT AND VIPDRESS';
        }
        
        if( count($report) ){
            $mailText = implode("\n\r", $report);
            $mailReceiver = 'info@koehlert.com,vitaliy@newstyleweb.net';
            mail($mailReceiver, 'EAN module report', $mailText);
        }
    }
    
    /*public function setEansToOrderDetails()
    {
        $orders = Db::getInstance()->executeS('
            select id_order from prs_orders
        ');
        
        foreach($orders as $orderData){
            $order = new Order($orderData['id_order']);
            
            if(empty($order->id)){
                continue;
            }
            
            $orderDetails = $order->getProductsDetail();
            if( !is_array($orderDetails) ){
                continue;
            }
            
            foreach($orderDetails as $orderDetailData){
                //if( !empty($orderDetailData['product_ean13']) ){
                //    continue;
                //}
                
                $combination = new Combination($orderDetailData['product_attribute_id']);
                
                Db::getInstance()->update('order_detail', array(
                    'product_ean13' => $combination->ean13
                ), 'id_order_detail = '. intval($orderDetailData['id_order_detail']) );
                echo 'SET "'.$combination->ean13.'" for "'. $orderDetailData['product_supplier_reference'] .'"<br>'; 
            }
        }
    }*/
    
    /*
    public function processFixWrongEans()
    {
        
        // get eans which are used, but does not have ref in prod_attrs
        $eansCurrentToAttrs = Db::getInstance()->executeS('
            SELECT e.*, pa.id_product_attribute, pa.supplier_reference 
            FROM `prs_ean` e 
            LEFT JOIN prs_product_attribute pa ON pa.ean13 = e.code 
            WHERE e.used = 1 
            ORDER BY `pa`.`supplier_reference` ASC 
        ');
        //var_dump($eansCurrentToAttrs);
        foreach($eansCurrentToAttrs as $eanCurrToAttr){
            if( !empty($eanCurrToAttr['id_product_attribute']) ){
                continue;
            }
            echo 'Searching: '. $eanCurrToAttr['code'] .'. ';
            // search ean in old table
            $eanOld = Db::getInstance()->getRow('
               SELECT * FROM prs_product_attribute_old
               WHERE ean13 = "'. pSQL($eanCurrToAttr['code']) .'"
            ');
            
            if(!is_array($eanOld) || empty($eanOld['id_product_attribute'])){
                
                Db::getInstance()->update('ean', array(
                    'used' => 0,
                    'supplier_reference' => ''
                ), 'id = '. $eanCurrToAttr['id']);
                
                echo 'NOT Found<br>';
                continue;
            }
            echo 'Found old EAN: '. $eanOld['ean13'] .'. ';
            
            // store incorrect ean
            
            // overwrite incorrect ean
            Db::getInstance()->update('product_attribute', array(
                'ean13' => $eanOld['ean13']
            ), 'id_product_attribute = '. $eanOld['id_product_attribute']);
            // set incorrect ean as not used
            Db::getInstance()->update('ean', array(
                'used' => 0,
                'supplier_reference' => ''
            ), 'id = '. $eanCurrToAttr['id']);
            
            echo '<br>';
        }
    }
    
    public function processSetRefs()
    {
        $eansCurrentToAttrs = Db::getInstance()->executeS('
            SELECT e.*, pa.id_product_attribute, pa.supplier_reference
            FROM `prs_ean` e
            LEFT JOIN prs_product_attribute pa ON pa.ean13 = e.code
        ');
        foreach($eansCurrentToAttrs as $eanCurrToAttr){
            if( !empty($eanCurrToAttr['supplier_reference']) ){
                Db::getInstance()->update('ean', array(
                    'used' => 1,
                    'supplier_reference' => $eanCurrToAttr['supplier_reference']
                ), 'id = '. $eanCurrToAttr['id']);
            }
            else{
                Db::getInstance()->update('ean', array(
                    'used' => 0,
                    'supplier_reference' => ''
                ), 'id = '. $eanCurrToAttr['id']);
                
            }
        }
    }
    */
}