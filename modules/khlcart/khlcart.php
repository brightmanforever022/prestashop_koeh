<?php

if (!defined('_PS_VERSION_')){
    exit;
}

class Khlcart extends Module
{
    public function __construct()
    {
        $this->name = 'khlcart';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Vitaliy';
        $this->need_instance = 0;
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->displayName = $this->l('Koehlert shop cart and order functions');
    }
    
    public function getPath()
    {
        return $this->_path;
    }
    
    
    public function install()
    {
        if( !parent::install() ){
            return false;
        }
        
        $this->registerHook('actionDispatcher');
        $this->registerHook('displayShoppingCart');
        
        Configuration::updateValue('KHLCART_ITEM_PRDC_MIN', 3);
        
        return true;
    }
    
    public function hookActionDispatcher($params)
    {
        if( ($params['controller_type'] == DispatcherCore::FC_FRONT)
            && ($params['controller_class'] == 'OrderController')
            && ( isset($_GET['step']) || isset($_POST['step']) ) 
        ){
            $productsToWarn = $this->getCartProductsNoStockAndNoSupply();
            if( count($productsToWarn) ){
                Tools::redirect('index.php?controller=order');
            }

            if( empty($this->context->cart) && !empty($this->context->cookie->id_cart)){
                $cart = new Cart( intval( $this->context->cookie->id_cart ) );
            }
            else{
                $cart = Context::getContext()->cart;
            }
            
            $firstOrderAllowed = $this->customerFirstOrderAllowed(
                $this->context->customer, $cart);
            
            if( !$firstOrderAllowed ){
                Tools::redirect('index.php?controller=order');
            }

        }
    }
    
    public function hookDisplayShoppingCart($params)
    {
        $productsToWarn = $this->getCartProductsNoStockAndNoSupply();

        $productAndCombinationIds = array();
        if( count($productsToWarn) ){
            $this->context->smarty->assign(array(
                'nostock_nosupply_products_to_warn' => $productsToWarn,
            ));
            
            foreach( $productsToWarn as $product ){
                foreach( $product['combinations'] as $combination ){
                    $productAndCombinationIds[] = array(
                        'id_product' => $product['product']->id,
                        'id_product_combination' => $combination->id
                    );
                }
            }
        }
        $this->context->smarty->assign( array(
            'nostock_nosupply_message' => Configuration::get('KHLCART_ITEM_PRDC_WARN', $this->context->language->id),
            'nostock_nosupply_cart_line_message' => Configuration::get('KHLCART_CART_LINE_WARN', $this->context->language->id),
            'nostock_nosupply_ids' => Tools::jsonEncode($productAndCombinationIds),
            'first_order_allowed' => $this->customerFirstOrderAllowed(
                $this->context->customer, $this->context->cart),
            'first_order_disallowed_message' => Configuration::get('KHLCART_ORDER_1_MIN_QNT_WARN', $this->context->language->id),
        ) );
        return ($this->display(__FILE__, '/shopping-cart.tpl'));
    }
    
    public function getContent()
    {
        $errors = array();
    
        $this->html = '';
        
        $form1 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Ordering of out of stock and no supplied products')
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Minimum order items to produce'),
                        'name' => 'KHLCART_ITEM_PRDC_MIN',
                    ),
                    array(
                        'type' => 'textarea',
                        'lang' => true,
                        'name' => 'KHLCART_ITEM_PRDC_WARN',
                    ),
                    array(
                        'type' => 'textarea',
                        'lang' => true,
                        'name' => 'KHLCART_CART_LINE_WARN',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                    'name' => 'submit'. $this->name,
                )
            ),
            
        );
        $form2 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Customer first order')
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Minimum quantity to buy'),
                        'name' => 'KHLCART_ORDER_1_MIN_QNT',
                    ),
                    array(
                        'type' => 'textarea',
                        'label' => $this->l('Warning'),
                        'lang' => true,
                        'name' => 'KHLCART_ORDER_1_MIN_QNT_WARN',
                    ),
                    
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right',
                    'name' => 'submit'. $this->name,
                )
            ),
        );
        $forms = array($form1, $form2);
    
        if (Tools::isSubmit('submit'.$this->name)){
            foreach($forms as $form){
                foreach($form['form']['input'] as $formInput){
                    $key = $formInput['name'];
                    if( !empty($formInput['lang']) && $formInput['lang'] ){
                        $value = array();
                        foreach( Language::getLanguages(false) as $language ){
                            $value[ $language['id_lang'] ] = Tools::getValue( $key.'_'.$language['id_lang'] );
                        }
                        if (!Configuration::updateValue($key, $value)){
                            $errors[] = $this->l('Cannot update settings');
                        }
                    }
                    else{
                        if (!Configuration::updateValue($key, Tools::getValue($key))){
                            $errors[] = $this->l('Cannot update settings');
                        }
                        
                    }
                }
            }
        }
    
        if (count($errors) > 0)
            $this->html .= $this->displayError(implode('<br />', $errors));
    
    
            $helper = new HelperForm();
            $helper->show_toolbar = false;
            $helper->table = $this->table;
            $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
            $helper->default_form_language = $lang->id;
            $helper->module = $this;
            $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
            $helper->identifier = $this->identifier;
            $helper->submit_action = 'submit'.$this->name.'Configuration';
            $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name .'&tab_module='.$this->tab .'&module_name='.$this->name;
            $helper->token = Tools::getAdminTokenLite('AdminModules');
    
            $form_fields_value = array();
            foreach($forms as $form){
                foreach($form['form']['input'] as $formInput){
                    if( !empty($formInput['lang']) && $formInput['lang'] ){
                        foreach( Language::getLanguages(false) as $language ){
                            $form_fields_value[ $formInput['name'] ][ $language['id_lang'] ] = 
                                Configuration::get( $formInput['name'], $language['id_lang'] );
                        }
                    }
                    else{
                        $form_fields_value[ $formInput['name'] ] = Configuration::get( $formInput['name'] );
                    }
                }
            }
    
            $helper->tpl_vars = array(
                'fields_value' => $form_fields_value,
                'languages' => $this->context->controller->getLanguages(),
                'id_language' => $this->context->language->id
            );
    
            $this->html .= $helper->generateForm($forms);
    
            return $this->html;
    }
    
    public function getCartProductsNoStockAndNoSupply()
    {
        if( empty($this->context->cart) && !empty($this->context->cookie->id_cart)){
            $cart = new Cart( intval( $this->context->cookie->id_cart ) );
        }
        else{
            $cart = Context::getContext()->cart;
        }
        
        $noStockNoSupplyProducts = array();
        $noStockNoSupplyProductMinOrder = intval( Configuration::get('KHLCART_ITEM_PRDC_MIN') );
        $noStockNoSupplyWarnings = array();
        
        foreach( $cart->getProducts() as $cartProduct ){
            $product = new Product( $cartProduct['id_product'], false, Context::getContext()->language->id );
            if( StockAvailable::getQuantityAvailableByProduct($cartProduct['id_product'], $cartProduct['id_product_attribute']) > 0 ){
                // product in stock, not counted
                continue;
            }
            
            if( $product->stock_clearance ){
                // not counted
                continue;
            }
            
            $productDateAdd = new DateTime($product->date_add);
            $productDateAddDiffNow = $productDateAdd->diff(new DateTime(), true);
            if( $productDateAddDiffNow->days < 150 ){
                // if dress's add date is less then 5 monthes
                continue;
            }
            
            $productSales4Month = $product->getSales(null, new DateTime('-180 day'));
            if( $productSales4Month >= 10 ){
                // if sold 10 and more items in last 6 monthes
                continue;
            }
            
            $productExpectedDeliveryList = $product->getExpectedDelivery();
            
            foreach( $productExpectedDeliveryList as $productExpectedDelivery ){
                if( $cartProduct['id_product_attribute'] == $productExpectedDelivery['id_product_attribute'] ){
                    // product to be supplied, not counted
                    continue 2;
                }
            }
            
            if( !isset($noStockNoSupplyProducts[ $product->id ]) ){
                $noStockNoSupplyProducts[ $product->id ] = array(
                    'product' => $product,
                    'combinations' => array()
                );
            }
            
            $noStockNoSupplyProducts[ $product->id ]['combinations'][] = array(
                'quantity' => $cartProduct['cart_quantity'],
                'id_product_attribute' => $cartProduct['id_product_attribute']
            );
        }
        
        foreach( $noStockNoSupplyProducts as $noStockNoSupplyProduct ){
            $productCartQuantity = 0;
            foreach( $noStockNoSupplyProduct['combinations'] as $noStockNoSupplyProductCombination ){
                $productCartQuantity += $noStockNoSupplyProductCombination['quantity'];
            }
            
            if( $productCartQuantity < $noStockNoSupplyProductMinOrder){
                // if quantity ordered not enough, prepare data to warn user
                $productCombinationsText = '';
                $productCombinationsList = array();
                foreach( $noStockNoSupplyProduct['combinations'] as $pci => $productCombinationInfo ){
                    $productCombinationsList[] = new Combination($productCombinationInfo['id_product_attribute']);
                    $productCombinationAttributes = $noStockNoSupplyProduct['product']
                        ->getAttributeCombinationsById(
                            $productCombinationInfo['id_product_attribute'], 
                            Context::getContext()->language->id
                        );

                    $combinationText = '';
                    foreach( $productCombinationAttributes as $productCombinationAttribute ){
                        $combinationText .= $productCombinationAttribute['group_name'] .':'. $productCombinationAttribute['attribute_name'] .', ';
                    }
                    $combinationText = trim($combinationText, " ,");

                    if($pci){
                        $productCombinationsText .= ' / ';
                    }
                    
                    $productCombinationsText .= $combinationText;
                }
                
                $noStockNoSupplyWarnings[] = array(
                    'product' => clone $noStockNoSupplyProduct['product'],
                    'combinations' => $productCombinationsList,
                    'combinations_text' => $productCombinationsText
                );
            }
        }
        
        return $noStockNoSupplyWarnings;
    }

    public function hookActionCartSummary(&$params)
    {
        $moduleSummary = array('checkout_allowed' => true);
        $moduleSummary['checkout_allowed'] = $this->customerFirstOrderAllowed(
            $this->context->customer, $this->context->cart);
        return $moduleSummary;
    }
    
    /**
     * 
     * @param Customer $customer
     * @param Cart $cart
     * @return boolean
     */
    public function customerFirstOrderAllowed(&$customer, &$cart)
    {
        $ordersCount = Order::getCustomerNbOrders($customer->id);
        
        if( $ordersCount > 0 ){
            return true;
        }
        
        $firstOrderMinQuantity = (int)Configuration::get('KHLCART_ORDER_1_MIN_QNT');
        $cartTotalQuantity = 0;
        foreach( $cart->getProducts() as $cartProduct ){
            $cartTotalQuantity += $cartProduct['quantity'];
        }
        
        return $cartTotalQuantity >= $firstOrderMinQuantity;
    }
}