<?php

require_once _PS_TOOL_DIR_ . 'CurlWrapper/CurlWrapper.php';

class EanManager
{
    /**
     * 
     * @var CurlWrapper
     */
    protected $curl;
    
    /**
     * Supplier to which assign EANs
     * @var integer
     */
    public static $supplierIdManage = 4;
    
    public function __construct()
    {
        
    }
    
    public function exportToRemote($remoteUrl, $data)
    {
        if(empty($this->curl)){
            $this->curl = new CurlWrapper();
        }
        
        $response = $this->curl->post($remoteUrl, array('data' => json_encode($data)) );
        $this->curl->reset();
        //var_dump($response);
        return json_decode($response, true);
    }
    
    public static function getDuplicatedEans()
    {
        $query = '
            SELECT ean13, count(ean13) as count 
            FROM '._DB_PREFIX_.'product_attribute 
            WHERE `ean13` != "" 
            GROUP BY ean13 
            HAVING count > 1
        ';
        
        return Db::getInstance()->executeS($query);
    }
    
    public static function getKoehlertToVipdressEanDiff()
    {
        $query = '
            SELECT k_pa.supplier_reference, k_pa.ean13 AS k_ean13, v_pa.ean13 AS v_ean13 
            FROM `prs_product_attribute` k_pa 
            INNER JOIN `'.VIPDRESS_DB_NAME.'`.`ps_product_attribute` v_pa 
                ON v_pa.supplier_reference = k_pa.supplier_reference 
            WHERE k_pa.supplier_reference != "" 
            HAVING k_pa.ean13 != v_pa.ean13
        ';
        return Db::getInstance()->executeS($query);
    }
}