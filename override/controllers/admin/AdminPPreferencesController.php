<?php

// Wheelronix Ltd. development team
  // site: http://www.wheelronix.com
  // mail: info@wheelronix.com

class AdminPPreferencesController extends AdminPPreferencesControllerCore
{
    public function __construct()
    {
        parent::__construct();
        $this->fields_options['products']['fields']['PL_CLEARANCE1_PRCNT'] = array(
            'title' => $this->l('Discount percent for clearance1'),
            'hint' => $this->l('Products price will be decreased on this percent if products get clearance 1 status'),
            'validation' => 'isUnsignedId',
            'cast' => 'intval',
            'type' => 'text',
            'suffix' => '%'
        );
        
        $this->fields_options['products']['fields']['PL_CLEARANCE2_PRCNT'] = array(
            'title' => $this->l('Discount percent for clearance2'),
            'hint' => $this->l('Products price will be decreased on this percent if products get clearance 2 status'),
            'validation' => 'isUnsignedId',
            'cast' => 'intval',
            'type' => 'text',
            'suffix' => '%'
        );
        
        $this->fields_options['products']['fields']['PL_CLEARANCE3_PRCNT'] = array(
            'title' => $this->l('Discount percent for clearance3'),
            'hint' => $this->l('Products price will be decreased on this percent if products get clearance 3 status'),
            'validation' => 'isUnsignedId',
            'cast' => 'intval',
            'type' => 'text',
            'suffix' => '%'
        );
    }
}
