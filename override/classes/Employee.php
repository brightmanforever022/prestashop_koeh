<?php

class Employee extends EmployeeCore
{
    public $active_ws;
    
    public static $definition = array(
        'table' => 'employee',
        'primary' => 'id_employee',
        'fields' => array(
            'lastname' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
            'firstname' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isName', 'required' => true, 'size' => 32),
            'email' =>                        array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true, 'size' => 128),
            'id_lang' =>                    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
            'passwd' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isPasswdAdmin', 'required' => true, 'size' => 32),
            'last_passwd_gen' =>            array('type' => self::TYPE_STRING),
            'active' =>                    array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'optin' =>                        array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'id_profile' =>                array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
            'bo_color' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isColor', 'size' => 32),
            'default_tab' =>                array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'bo_theme' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 32),
            'bo_css' =>                    array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'size' => 64),
            'bo_width' =>                    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'bo_menu' =>                    array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'stats_date_from' =>            array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'stats_date_to' =>                array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'stats_compare_from' =>            array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'stats_compare_to' =>            array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'stats_compare_option' =>        array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'preselect_date_range' =>        array('type' => self::TYPE_STRING, 'size' => 32),
            'id_last_order' =>                array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'id_last_customer_message' =>    array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'id_last_customer' =>            array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt'),
            'active_ws' =>                    array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
        ),
    );
    
}

