<?php

if (!defined('_CAN_LOAD_FILES_'))
    exit;

class BlockCartOverride extends BlockCart
{
    
    public function hookAjaxCall($params)
    {
        if (Configuration::get('PS_CATALOG_MODE'))
            return;
    
            $this->assignContentVars($params);
            $res = Tools::jsonDecode($this->display(__FILE__, 'blockcart-json.tpl'), true);
    
            if (is_array($res) && ($id_product = Tools::getValue('id_product')) && Configuration::get('PS_BLOCK_CART_SHOW_CROSSSELLING'))
            {
                $this->smarty->assign('orderProducts', OrderDetail::getCrossSells($id_product, $this->context->language->id,
                    Configuration::get('PS_BLOCK_CART_XSELL_LIMIT')));
                $res['crossSelling'] = $this->display(__FILE__, 'crossselling.tpl');
            }
            
            $khlcartModule = Module::getInstanceByName('khlcart');
            if( is_object($khlcartModule) && $khlcartModule->active ){
                $noStockSupplyProductsToWarn = $khlcartModule->getCartProductsNoStockAndNoSupply();
                if( count($noStockSupplyProductsToWarn) ){
                    $nostockNosupplyMessage = Configuration::get('KHLCART_ITEM_PRDC_WARN', $this->context->language->id);
                    $res['nostock_nosupply_products_warnings'] = array();
                    foreach( $noStockSupplyProductsToWarn as $noStockSupplyProduct ){
                        $res['nostock_nosupply_products_warnings'][] = 
                            '"'. $noStockSupplyProduct['product']->supplier_reference 
                            . ' ' . $noStockSupplyProduct['combinations_text'] .'" : '
                            . $nostockNosupplyMessage
                        ;
                    }
                }
            }
            
    
            $res = Tools::jsonEncode($res);
            return $res;
    }
    
}