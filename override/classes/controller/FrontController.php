<?php

class FrontController extends FrontControllerCore
{
    public function init()
    {
        parent::init();
        
        Hook::exec('actionFrontControllerInit', array(
            'controller' => $this
        ));
    }
    
    protected function recoverCart()
    {
        return false;
    }
}

