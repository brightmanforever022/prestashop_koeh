<?php

class MassmailTemplate extends ObjectModel
{
    public $date_add;
    
    public $subject;
    
    public $content;
    
    public static $definition = array(
        'table' => 'massmail_template',
        'primary' => 'id_template',
        'multilang' => true,
        'fields' => array(
            'date_add' => array('type' => self::TYPE_DATE),
            
            /* Lang fields */
            'subject' => array(
                'type' => self::TYPE_STRING, 
                'lang' => true, 
                'validate' => 'isGenericName', 
                'required' => true, 
                'size' => 128
            ),
            'content' => array(
                'type' => self::TYPE_HTML, 
                'lang' => true, 
                'required' => true, 
            ),
        ),
    );
    
    public static $template_placeholders = array(
        array(
            'placeholder' => '[$customer_first_name]',
            'description' => 'customers first name',
            'var_name' => 'customer_first_name'
        ),
        array(
            'placeholder' => '[$customer_last_name]',
            'description' => 'customers last name',
            'var_name' => 'customer_last_name'
        )
        
    );
}

