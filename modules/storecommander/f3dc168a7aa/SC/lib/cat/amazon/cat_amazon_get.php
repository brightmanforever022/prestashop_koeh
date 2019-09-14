<?php
/**
 * Store Commander
 *
 * @category administration
 * @author Store Commander - support@storecommander.com
 * @version 2015-09-15
 * @uses Prestashop modules
 * @since 2009
 * @copyright Copyright &copy; 2009-2015, Store Commander
 * @license commercial
 * All rights reserved! Copying, duplication strictly prohibited
 *
 * *****************************************
 * *           STORE COMMANDER             *
 * *   http://www.StoreCommander.com       *
 * *            V 2015-09-15               *
 * *****************************************
 *
 * Compatibility: PS version: 1.1 to 1.6.1
 *
 **/
    $id_lang=(int)Tools::getValue('id_lang');
    $idlist=Tools::getValue('idlist',0);

    $colSettings=array();
    $grids=array();
    // SETTINGS, FILTERS AND COLONNES

    ## check alternative fields enable
    $alternate_fields = array("alternative_title","alternative_description");
    $query = Db::getInstance()->ExecuteS('SHOW COLUMNS 
                                                FROM '._DB_PREFIX_.'marketplace_product_option 
                                                WHERE Field IN ("'.implode('","',$alternate_fields).'")');
    $alternate_fields_enable = false;
    if(!empty($query) && (count($query) == count($alternate_fields))) {
        $alternate_fields_enable = true;
    }

    include("cat_amazon_data_fields.php");
    include("cat_amazon_data_views.php");
    $cols = explode(',', $grids);

	function getFooterColSettings()
	{
		global $cols,$colSettings;
	
		$footer='';
		foreach($cols AS $id => $col)
		{
			if (sc_array_key_exists($col,$colSettings) && sc_array_key_exists('footer',$colSettings[$col]))
				$footer.=$colSettings[$col]['footer'].',';
			else
				$footer.=',';
		}
		return $footer;
	}
	
	function getFilterColSettings()
	{
		global $cols,$colSettings;
	
		$filters='';
		foreach($cols AS $id => $col)
		{
			if($colSettings[$col]['filter']=="na")
				$colSettings[$col]['filter'] = "";
			$filters.=$colSettings[$col]['filter'].',';
		}
		$filters=trim($filters,',');
		return $filters;
	}

function getColSettingsAsXML()
{
    global $cols,$colSettings;

    $uiset = uisettings::getSetting('cat_amazon');
    $tmp = explode('|',$uiset);
    $tmp = explode('-',$tmp[2]);
    $sizes = array();
    foreach($tmp AS $v)
    {
        $s = explode(':',$v);
        $sizes[$s[0]] = $s[1];
    }
    $tmp = explode('|',$uiset);
    $tmp = explode('-',$tmp[0]);
    $hidden = array();
    foreach($tmp AS $v)
    {
        $s = explode(':',$v);
        $hidden[$s[0]] = $s[1];
    }
    $xml='';
    foreach($cols AS $id => $col)
    {
        $xml.='<column id="'.$col.'"'.(sc_array_key_exists('format',$colSettings[$col])?
                ' format="'.$colSettings[$col]['format'].'"':'').
            ' width="'.( sc_array_key_exists($col,$sizes) ? $sizes[$col] : $colSettings[$col]['width'] ).'"'.
            ' hidden="'.( sc_array_key_exists($col,$hidden) ? $hidden[$col] : 0 ).'"'.
            ' align="'.$colSettings[$col]['align'].'" 
					type="'.$colSettings[$col]['type'].'" 
					sort="'.$colSettings[$col]['sort'].'" 
					color="'.$colSettings[$col]['color'].'">'.$colSettings[$col]['text'];
        if (!empty($colSettings[$col]['options']))
        {
            foreach($colSettings[$col]['options'] AS $k => $v)
            {
                $xml.='<option value="'.str_replace('"','\'',$k).'"><![CDATA['.$v.']]></option>';
            }
        }
        $xml.='</column>'."\n";
    }
    return $xml;
}


    function getAmazonMatrix($id_lang, $price_rule, $currency, $price)
    {
        $price_rule_return = null;
        if(array_key_exists($id_lang,$price_rule)) {
            foreach($price_rule[$id_lang]['rule']['from'] as $k => $step) {
                $cle = (int)$k;
                if($price >= $step && $price <= $price_rule[$id_lang]['rule']['to'][$cle]) {
                    $type = $price_rule[$id_lang]['type'];
                    if(!empty($price_rule[$id_lang]['rule'][$type][$cle])) {
                        $value = $price_rule[$id_lang]['rule'][$type][$cle];

                        $reduc = null;
                        if(substr($value,0,1) == '-') {
                            $reduc = 1;
                        }
                        if($type == 'percent') {
                            if(!empty($reduc)) {
                                $value = str_replace('-','',$value);
                                $percent = (($value/100) + 1);
                                $price = $price / $percent;
                                $price_rule_return = $value.'%';
                                break;
                            } else {
                                $percent = (($value/100) + 1);
                                $price = $price * $percent;
                                $price_rule_return = "+".$value.'%';
                                break;
                            }
                        } else {
                            if(!empty($reduc)) {
                                $value = str_replace('-','',$value);
                                $price = $price - $value;
                                $price_rule_return = '-'.$value.$currency['sign'];
                                break;
                            } else {
                                $price = $price + $value;
                                $price_rule_return = "+".$value.$currency['sign'];
                                break;
                            }
                        }
                    }
                }
            }
        }

        $price_data = array(
            'price' => $price,
            'type_price_rule' => $price_rule_return
        );
        return $price_data;
    }
	
	function getAmazonOptions()
    {
		global $idlist,$cols,$id_lang,$alternate_fields_enable;
        
        $sql = "SELECT p.id_product, IFNULL(pa.id_product_attribute, 0) as id_product_attribute
                FROM `"._DB_PREFIX_."product` p
                LEFT JOIN `"._DB_PREFIX_."product_attribute` pa ON pa.id_product = p.id_product
                WHERE p.id_product IN (".pSQL($idlist).")";
        $initial_products = Db::getInstance()->executeS($sql);

        $init_cache = array();
        foreach($initial_products as $prd) {
            $init_cache[$prd['id_product']][$prd['id_product_attribute']] = $prd['id_product_attribute'];
        }
        foreach($init_cache as $id_product => $row) {
            if(!array_key_exists(0,$row)) {
                $init_cache[$id_product][0] = 0;
            }
            sort($init_cache[$id_product]);
        }

        $initial_products = array();
        foreach($init_cache as $id_product => $row) {
            foreach($row as $k => $id_product_attribute) {
                $initial_products[] = array(
                    'id_product' => (int)$id_product,
                    'id_product_attribute' => (int)$id_product_attribute
                );
            }
        }
        
        $xml = '';
        ## Clean Table
        Db::getInstance()->execute('DELETE 
                                    FROM `'._DB_PREFIX_.'marketplace_product_option` 
                                    WHERE `force` IS NULL 
                                    AND `nopexport` IS NULL 
                                    AND `noqexport` IS NULL 
                                    AND `fba` IS NULL 
                                    AND `fba_value` IS NULL 
                                    AND `latency` IS NULL 
                                    AND `disable` IS NULL 
                                    AND `price` IS NULL 
                                    AND `asin1` IS NULL 
                                    AND `asin2` IS NULL 
                                    AND `asin3` IS NULL 
                                    AND `text` IS NULL 
                                    AND `bullet_point1` IS NULL 
                                    AND `bullet_point2` IS NULL 
                                    AND `bullet_point3` IS NULL 
                                    AND `bullet_point4` IS NULL 
                                    AND `bullet_point5` IS NULL 
                                    AND `shipping` IS NULL 
                                    AND `shipping_type` IS NULL 
                                    AND `gift_wrap` IS NULL 
                                    AND `gift_message` IS NULL 
                                    AND `browsenode` IS NULL 
                                    AND `repricing_min` IS NULL 
                                    AND `repricing_max` IS NULL 
                                    AND `repricing_gap` IS NULL'
                                    .(!empty($alternate_fields_enable) ? ' AND `alternative_title` IS NULL AND `alternative_description` IS NULL': ''));

        $sql_prd_options = "SELECT * 
                            FROM `"._DB_PREFIX_."marketplace_product_option`
                            WHERE id_product IN (".pSQL($idlist).")";
        $prd_options = Db::getInstance()->executeS($sql_prd_options);
        $opt_cache = array();
        foreach($prd_options as $option) {
            $opt_cache[$option['id_product']][$option['id_product_attribute']][$option['id_lang']] = $option;
        }


        $regions = Db::getInstance()->getValue('SELECT value 
                                                    FROM '._DB_PREFIX_.'amazon_configuration 
                                                    WHERE name = "AMAZON_REGION" 
                                                    AND id_shop ='.(int)SCI::getSelectedShop());
        if(!empty($regions)) {
            $regions = unserialize($regions);
        } else {
            $regions = Db::getInstance()->getValue('SELECT value 
                                                    FROM '._DB_PREFIX_.'amazon_configuration 
                                                    WHERE name = "AMAZON_REGION" 
                                                    AND id_shop IS NULL');
            if(!empty($regions)) {
                $regions = unserialize($regions);
            } else {
                $regions = Db::getInstance()->getValue('SELECT value 
                                                        FROM '._DB_PREFIX_.'amazon_configuration 
                                                        WHERE name = "AMAZON_REGION" 
                                                        AND id_shop = 0');
                if(!empty($regions)) {
                    $regions = unserialize($regions);
                }
            }
        }

        $price_rule = Db::getInstance()->getValue('SELECT value 
                                                    FROM '._DB_PREFIX_.'amazon_configuration 
                                                    WHERE name = "AMAZON_PRICE_RULE" 
                                                    AND id_shop ='.(int)SCI::getSelectedShop());
        if(!empty($price_rule)) {
            $price_rule = unserialize($price_rule);
        } else {
            $price_rule = Db::getInstance()->getValue('SELECT value 
                                                    FROM '._DB_PREFIX_.'amazon_configuration 
                                                    WHERE name = "AMAZON_PRICE_RULE" 
                                                    AND id_shop IS NULL');
            if(!empty($price_rule)) {
                $price_rule = unserialize($price_rule);
            } else {
                $price_rule = Db::getInstance()->getValue('SELECT value 
                                                    FROM '._DB_PREFIX_.'amazon_configuration 
                                                    WHERE name = "AMAZON_PRICE_RULE" 
                                                    AND id_shop = 0');
                if(!empty($price_rule)) {
                    $price_rule = unserialize($price_rule);
                }
            }
        }

        $currencies = Db::getInstance()->getValue('SELECT value 
                                                    FROM '._DB_PREFIX_.'amazon_configuration 
                                                    WHERE name = "AMAZON_CURRENCY" 
                                                    AND id_shop ='.(int)SCI::getSelectedShop());
        if(!empty($currencies)) {
            $currencies = unserialize($currencies);
        } else {
            $currencies = Db::getInstance()->getValue('SELECT value 
                                                    FROM '._DB_PREFIX_.'amazon_configuration 
                                                    WHERE name = "AMAZON_CURRENCY" 
                                                    AND id_shop IS NULL');
            if(!empty($currencies)) {
                $currencies = unserialize($currencies);
            } else {
                $currencies = Db::getInstance()->getValue('SELECT value 
                                                    FROM '._DB_PREFIX_.'amazon_configuration 
                                                    WHERE name = "AMAZON_CURRENCY" 
                                                    AND id_shop = 0');
                if(!empty($currencies)) {
                    $currencies = unserialize($currencies);
                }
            }
        }

        foreach($initial_products as $res) {
            foreach($regions as $region_lang_id => $region) {
                $id_product = $res['id_product'];
                $id_product_attribute = $res['id_product_attribute'];
                $xml .= '<row id="'.$id_product.'_'.(int)$id_product_attribute.'_'.(int)$region_lang_id.'">';
                $prod = new Product((int)$id_product, null, (int)$region_lang_id);
                $id_currency = Currency::getIdByIsoCode($currencies[$id_lang], (version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? (int)SCI::getSelectedShop() : null));
                $currency = Currency::getCurrency($id_currency);
                $price_init = SCI::getPrice((int)$id_product, (int)$id_product_attribute,(version_compare(_PS_VERSION_, '1.5.0.0', '>=') ? (int)SCI::getSelectedShop() : 1),true);
                $price_detail = getAmazonMatrix($region_lang_id, $price_rule, $currency, $price_init['price_reduction_it']);
                foreach($cols as $col) {
                    switch($col) {
                        case 'region':
                            $xml.= '<cell>'.$region.'</cell>';
                            break;
                        case 'id_product':
                            $xml.= '<cell>'.$id_product.'</cell>';
                            break;
                        case 'id_product_attribute':
                            $xml.= '<cell>'.(int)$id_product_attribute.'</cell>';
                            break;
                        case 'name':
                            $xml.= '<cell><![CDATA['.$prod->name.']]></cell>';
                            break;
                        case 'price_inc_tax':
                            $xml.= '<cell>'.(float)$price_init['price_reduction_it'].'</cell>';
                            break;
                        case 'nopexport':case'noqexport':case'fba':case'shipping_type':case'disable':case'force':
                            $xml.= '<cell>'.(int)$opt_cache[(int)$id_product][(int)$id_product_attribute][$region_lang_id][$col].'</cell>';
                            break;
                        case 'amazon_price':
                            $amazon_price = (!empty($price_detail['price']) ? $price_detail['price'] : $price_init);
                            $xml.= '<cell>'.Tools::ps_round($amazon_price,2).'</cell>';
                            break;
                        case 'price_rule':
                            $amazon_price_rule = (!empty($price_detail['type_price_rule']) ? $price_detail['type_price_rule'] : '');
                            $xml.= '<cell>'.$amazon_price_rule.'</cell>';
                            break;
                        case 'attribute_name':
                            if(!empty($id_product_attribute)) {
                                if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
                                    $attributes = $prod->getAttributesResume((int)$region_lang_id);
                                    foreach($attributes as $attr) {
                                        if($attr['id_product_attribute'] == $id_product_attribute) {
                                            $combination_detail = $attr['attribute_designation'];
                                            break;
                                        }
                                    }
                                } else {
                                    $detail = array();
                                    $attributes = $prod->getAttributeCombinaisons((int)$region_lang_id);
                                    foreach($attributes as $attr) {
                                        if($attr['id_product_attribute'] == $id_product_attribute) {
                                            $detail[] = $attr['group_name'].' : '.$attr['attribute_name'];
                                        }
                                    }
                                    $combination_detail = implode(', ', $detail);
                                }
                            } else {
                                $combination_detail = '';
                            }
                            $xml.= '<cell><![CDATA['.$combination_detail.']]></cell>';
                            break;
                        default:
                            $xml.= '<cell><![CDATA['.$opt_cache[(int)$id_product][(int)$id_product_attribute][$region_lang_id][$col].']]></cell>';
                    }
                }
                $xml .= '</row>';
            }
        }
		return $xml;
	}

	//XML HEADER

	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
		header("Content-type: application/xhtml+xml");
	} else {
		header("Content-type: text/xml");
	}
	echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
	echo '<rows><head>';
	echo getColSettingsAsXML();
	echo '<afterInit><call command="attachHeader"><param>'.getFilterColSettings().'</param></call>
			<call command="attachFooter"><param><![CDATA['.getFooterColSettings().']]></param></call></afterInit>';
	echo '</head>'."\n";
	
	echo '<userdata name="uisettings">'.uisettings::getSetting('cat_amazon').'</userdata>'."\n";
	sc_ext::readCustomPropSpePriceGridConfigXML('gridUserData');

	echo getAmazonOptions();
?>
</rows>
