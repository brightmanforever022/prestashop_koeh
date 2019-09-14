<?php

class BaTemplateCategory //extends ObjectModel
{
    /*
    var $definition = array(
        'table' => 'invoice_tpl_category',
        'primary' => 'id',
        'fields' => array(
            'secure_key' =>                array('type' => self::TYPE_STRING, 'validate' => 'isMd5', 'copy_post' => false),
            ));
    */
    
    /**
     * @return array with list of all categories ordered by id: ['id'=>'name']
     */
    static function getList()
    {
        $db = Db::getInstance();
        $sqlRes = $db->executeS('select id, name from '._DB_PREFIX_.'ba_invoice_tpl_category order by id', false);
        $result = [];
        
        while($row = $db->nextRow($sqlRes))
        {
            $result[$row['id']] = $row['name'];
        }
        
        return $result;
    }
    
    
    /**
     * 
     * @param type $templateId
     * @return returns array with ids of categories, there template is attached
     */
    static function getTemplateCategoryIds($templateId)
    {
        $db = Db::getInstance();
        $sqlRes = $db->executeS('select category_id from '._DB_PREFIX_.'ba_invoice_tpl_to_category where template_id='.$templateId, false);
        $result = [];
        while($row = $db->nextRow($sqlRes))
        {
            $result []= $row['category_id'];
        }
        
        return $result;
    }
    
    
    /**
     * @return array(categoryId=>, categoryName=> templates=>['id'=>, 'name'=>])
     */
    static function getTemplatesGroupedByCategory()
    {
        $db = Db::getInstance();
        $sqlRes = $db->executeS('select c.id as cat_id, c.name as cat_name, t.id as tpl_id, t.name as tpl_name from '._DB_PREFIX_.
                'ba_invoice_tpl_category c inner join '._DB_PREFIX_.'ba_invoice_tpl_to_category tc on c.id=tc.category_id inner join '.
                _DB_PREFIX_.'ba_prestashop_invoice t on t.id=tc.template_id order by c.name, t.name', false);
        $result = [];
        $curCatId = 0;
        $curCatIndex = -1;
        while($row = $db->nextRow($sqlRes))
        {
            if ($curCatId != $row['cat_id'])
            {
                $curCatId = $row['cat_id'];
                $curCatIndex++;
                $result[] = ['categoryId'=>$row['cat_id'], 'categoryName'=>$row['cat_name'], 'templates'=>[]];
            }
            
            $result[$curCatIndex]['templates'] []= ['id'=>$row['tpl_id'], 'name'=>$row['tpl_name']];
        }
        
        return $result;
    }
    
    
    /**
     * Saves template categories, ovewriting exiting
     * @param type $templateId
     * @param type $categoryIds
     */
    static function saveTemplateCats($templateId, $categoryIds)
    {
        $db = Db::getInstance();
        // delete old cats
        $db->execute('delete from '._DB_PREFIX_.'ba_invoice_tpl_to_category where template_id='.$templateId);
        
        // insert new
        $sqlTail = '';
        foreach($categoryIds as $categoryId)
        {
            $sqlTail .= (empty($sqlTail)?'':', ').'('.$templateId.','.$categoryId.')';
        }
        
        return $db->execute('insert into '._DB_PREFIX_.'ba_invoice_tpl_to_category(template_id, category_id) values '.$sqlTail);
    }

    /**
     * 
     * @param unknown $countryId
     * @param int $invoiceRequireVat 0 - any, 1 - vat not required, 2 - only vat required
     * @return array
     */
    static function getTemplatesByCountry($countryId, $excludeInvoiceRequireVat = 0)
    {
        $excludeInvoiceRequireVat = intval($excludeInvoiceRequireVat);
        $templateSelectOptions = array();
        // if country in one of this categories, parameter $excludeInvoiceRequireVat regarded, otherwise ignored
        $invoiceCategoriesRequiresVatId = array(1,2,4);
        
        $country = new Country($countryId, Context::getContext()->language->id);
        
        $countryToCategory = Db::getInstance()->getRow('
            SELECT *
            FROM `'._DB_PREFIX_.'ba_invoice_category_to_country`
            WHERE country_id = '. intval($country->id) .'
        ');
        
        $templateSelectOptions[0] = array(
            'categoryName' => $country->name,
            'templates' => array()
        );
        
        $query = '
            SELECT bai.id, bai.name, bai.description, bai.require_vat
            FROM prs_ba_prestashop_invoice bai
            INNER JOIN `prs_ba_invoice_tpl_to_category` bai2c 
                ON bai2c.template_id = bai.id
            INNER JOIN `prs_ba_invoice_category_to_country` baicat2cnt 
                ON baicat2cnt.category_id = bai2c.category_id
            WHERE
                baicat2cnt.country_id = '. $countryId .'
        ';
        
        if( in_array($countryToCategory['category_id'], $invoiceCategoriesRequiresVatId) 
            && $excludeInvoiceRequireVat
        ){
            $query .= ' AND bai.require_vat = '. ($excludeInvoiceRequireVat == 1 ? '0' : '1') ;
        }
        
        $templates = Db::getInstance()->executeS($query);
        
        foreach($templates as $template){
            $templateSelectOptions[0]['templates'][] = array(
                'id' => $template['id'],
                'name' => $template['name'],
                'require_vat' => $template['require_vat']
            );
        }
        
        return $templateSelectOptions;
    }
}

