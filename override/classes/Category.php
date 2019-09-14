<?php
  // Wheelronix Ltd. development team
  // site: http://www.wheelronix.com
  // mail: info@wheelronix.com
  //


class Category extends CategoryCore
{
    const SaleCategoryId = 35;
    
    public $color_code;
    public $filter_mark_color;
    public $top_seller_sort_config;
    public $def_product_sort;
    


    public function getFields()
    {
    	$fields = parent::getFields();
    	$fields['color_code'] = pSQL($this->color_code);
    	$fields['filter_mark_color'] = pSQL($this->filter_mark_color);
        $fields['top_seller_sort_config'] = pSQL($this->top_seller_sort_config);
        $fields['def_product_sort'] = pSQL($this->def_product_sort);
    	return $fields;
    }
}