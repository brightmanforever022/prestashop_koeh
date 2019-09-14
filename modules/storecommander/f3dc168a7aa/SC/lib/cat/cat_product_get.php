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
/*
**
** Infos ecotaxe :
**	PS 1.1 : champ fixe servant uniquement à l'affichage utilisant la taxe du produit, enregistré en TTC dans la BDD
**	PS 1.2 : champ fixe servant uniquement à l'affichage utilisant la taxe du produit, enregistré en TTC dans la BDD
**	PS 1.3 : champ calculé avec PS_ECOTAX_TAX_ID, enregistré en HT (prod base) et TTC (décli) dans la BDD
**	PS 1.4 : champ calculé avec PS_ECOTAX_TAX_RULES_GROUP_ID, enregistré en HT dans la BDD
**	PS 1.5 : champ calculé avec PS_ECOTAX_TAX_RULES_GROUP_ID, enregistré en HT dans la BDD
**
*/


	$id_lang=intval(Tools::getValue('id_lang'));
	
	$view=Tools::getValue('view','grid_light');
	$grids=SCI::getGridViews("product");
	sc_ext::readCustomGridsConfigXML('gridConfig');
	
	$exportedProducts = array();
	$cdata=(isset($_COOKIE['cg_cat_treegrid_col_'.$view])?$_COOKIE['cg_cat_treegrid_col_'.$view]:'');
	//check validity
	$check=explode(',',$cdata);
	foreach($check as $c)
		if ($c=='undefined')
		{
			$cdata='';
			break;
		}
	if ($cdata!='') $grids[$view]=$cdata;
	
	if (_s('CAT_PROD_GRID_DISABLE_IMAGE'))
		$grids[$view]=str_replace('image,','',$grids[$view]);
	
	if (!_r('GRI_CAT_PROPERTIES_GRID_COMBI'))
		$grids[$view]=str_replace('combinations,','',$grids[$view]);
	
	if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && (int)SCI::getConfigurationValue('PS_USE_ECOTAX', null, 0, SCI::getSelectedShop())==0)
		$grids[$view]=str_replace(',ecotax','',$grids[$view]);
	elseif ((version_compare(_PS_VERSION_, '1.4.0.0', '>=') && version_compare(_PS_VERSION_, '1.5.0.0', '<')) && (int)SCI::getConfigurationValue('PS_USE_ECOTAX')==0)
		$grids[$view]=str_replace(',ecotax','',$grids[$view]);

	$cols=explode(',',$grids[$view]);
/*
	function getColIndex($col)
	{
		global $cols;
		$tmp=array_flip($cols);
		return (sc_array_key_exists($col,$tmp) ? $tmp[$col] : -1 );
	}*/

	// Tax
	$arrTax=array(0 => '-');
	$tax=array(0 => 0);
	if (sc_in_array('id_tax',$cols,'cols') || sc_in_array('id_tax_rules_group',$cols,'cols') || sc_in_array('price_inc_tax',$cols,'cols'))
	{
		if (version_compare(_PS_VERSION_, '1.6.0.10', '>='))
		{
			$inner = "";

			if (SCMS && SCI::getSelectedShop()>0)
				$inner = " INNER JOIN "._DB_PREFIX_."tax_rules_group_shop trgs ON (trgs.id_tax_rules_group = trg.id_tax_rules_group AND trgs.id_shop = '".(int)SCI::getSelectedShop()."')";

			$sql='SELECT trg.name, trg.id_tax_rules_group,t.rate, trg.deleted
			FROM `'._DB_PREFIX_.'tax_rules_group` trg
			LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (trg.`id_tax_rules_group` = tr.`id_tax_rules_group` AND tr.`id_country` = '.(int)SCI::getDefaultCountryId().' AND tr.`id_state` = 0)
  	  			LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
  	  		'.$inner.'
	    	WHERE 1
  	  		ORDER BY trg.deleted ASC, trg.name ASC';
			$res=Db::getInstance()->ExecuteS($sql);
			foreach($res as $row){
				if ($row['name']=='') $row['name']=' ';
				
				if($row['deleted']=="1")
					$row['name'] = _l("(deleted)")." ".$row['name'];
				
				$arrTax[$row['id_tax_rules_group']]=$row['name'];
				$tax[$row['id_tax_rules_group']]=$row['rate'];
			}
		}
		elseif (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
		{
			$inner = "";

			if (version_compare(_PS_VERSION_, '1.6.0.0', '>=') && SCMS && SCI::getSelectedShop()>0)
				$inner = " INNER JOIN "._DB_PREFIX_."tax_rules_group_shop trgs ON (trgs.id_tax_rules_group = trg.id_tax_rules_group AND trgs.id_shop = '".(int)SCI::getSelectedShop()."')";

			$sql='SELECT trg.name, trg.id_tax_rules_group,t.rate
			FROM `'._DB_PREFIX_.'tax_rules_group` trg
			LEFT JOIN `'._DB_PREFIX_.'tax_rule` tr ON (trg.`id_tax_rules_group` = tr.`id_tax_rules_group` AND tr.`id_country` = '.(int)SCI::getDefaultCountryId().' AND tr.`id_state` = 0)
  	  			LEFT JOIN `'._DB_PREFIX_.'tax` t ON (t.`id_tax` = tr.`id_tax`)
  	  		'.$inner.'
	    	WHERE trg.active=1';
			$res=Db::getInstance()->ExecuteS($sql);
			foreach($res as $row){
				if ($row['name']=='') $row['name']=' ';
				$arrTax[$row['id_tax_rules_group']]=$row['name'];
				$tax[$row['id_tax_rules_group']]=$row['rate'];
			}
		}else{
			$sql = "SELECT id_tax,rate FROM "._DB_PREFIX_."tax";
			$res=Db::getInstance()->ExecuteS($sql);
			foreach($res as $row){
				$arrTax[$row['id_tax']]=$row['rate'];
				$tax[$row['id_tax']]=$row['rate'];
			}
		}
	}
	
	// Color groups
	$arrColorGroups=array(0 => _l('Do not display'));
	if (sc_in_array('id_color_default',$cols,'cols'))
	{
		$sql = "SELECT ag.id_attribute_group,agl.name 
				FROM "._DB_PREFIX_."attribute_group ag
					LEFT JOIN "._DB_PREFIX_."attribute_group_lang agl ON(agl.id_attribute_group=ag.id_attribute_group AND agl.id_lang=".intval($id_lang).")
				WHERE ag.is_color_group=1
				ORDER BY name";
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $row){
			if ($row['name']=='') $row['name']=' ';
			$arrColorGroups[$row['id_attribute_group']]=$row['name'];
		}
	}

	// Manufacturers
	$arrManufacturers=array();
	if (sc_in_array('id_manufacturer',$cols,'cols'))
	{
		$where = "";
		if (SCMS && SCI::getSelectedShop()>0)
			$where = " INNER JOIN "._DB_PREFIX_."manufacturer_shop ms ON ms.id_manufacturer = m.id_manufacturer WHERE ms.id_shop = '".(int)SCI::getSelectedShop()."'";
		
		$sql = "SELECT m.id_manufacturer,m.name FROM "._DB_PREFIX_."manufacturer m ".$where." ORDER BY m.name";
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $row){
			if ($row['name']=='') $row['name']=' ';
			$arrManufacturers[$row['id_manufacturer']]=$row['name'];
		}
		$arrManufacturers[0]='-';
	}
	// Suppliers
	$arrSuppliers=array();
	if (sc_in_array('id_supplier',$cols,'cols'))
	{
		$where = "";
		if (SCMS && SCI::getSelectedShop()>0)
			$where = " INNER JOIN "._DB_PREFIX_."supplier_shop ss ON ss.id_supplier = s.id_supplier WHERE ss.id_shop = '".(int)SCI::getSelectedShop()."'";
		
		$sql = "SELECT s.id_supplier,s.name FROM "._DB_PREFIX_."supplier s ".$where." ORDER BY s.name";
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $row){
			if ($row['name']=='') $row['name']=' ';
			$arrSuppliers[$row['id_supplier']]=$row['name'];
		}
		$arrSuppliers[0]='-';
	}

	// ReductionPrice
	$arrReductionPrice=array('0.00'=>'0.00');
	if (sc_in_array('reduction_price',$cols,'cols'))
	{
		if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
		{
			$sql = "SELECT DISTINCT reduction AS reduction_price FROM "._DB_PREFIX_."specific_price WHERE reduction_type='amount' ORDER BY reduction";
		}else{
			$sql = "SELECT DISTINCT reduction_price FROM "._DB_PREFIX_."product ORDER BY reduction_price";
		}
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $row){
			$arrReductionPrice[$row['reduction_price']]=number_format($row['reduction_price'], 2, '.', '');
		}
	}
	// ReductionPercent
	$arrReductionPercent=array('0.00'=>'0.00');
	if (sc_in_array('reduction_percent',$cols,'cols'))
	{
		if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
		{
			$sql = "SELECT DISTINCT reduction*100 AS reduction_percent FROM "._DB_PREFIX_."specific_price WHERE reduction_type='percentage' ORDER BY reduction";
		}else{
			$sql = "SELECT DISTINCT reduction_percent FROM "._DB_PREFIX_."product ORDER BY reduction_percent";
		}
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $row){
			$arrReductionPercent[$row['reduction_percent']]=number_format($row['reduction_percent'], 2, '.', '');
		}
	}
	// MsgAvailableNow
	$arrMsgAvailableNow=array(''=>'');
	if (sc_in_array('available_now',$cols,'cols'))
	{
		$sql = "SELECT DISTINCT available_now FROM "._DB_PREFIX_."product_lang WHERE id_lang=".intval($id_lang)." ORDER BY available_now";
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $row){
			$arrMsgAvailableNow[htmlspecialchars($row['available_now'])]=$row['available_now'];
		}
	}
	// MsgAvailableLater
	$arrMsgAvailableLater=array(''=>'');
	if (sc_in_array('available_later',$cols,'cols'))
	{
		$sql = "SELECT DISTINCT available_later FROM "._DB_PREFIX_."product_lang WHERE id_lang=".intval($id_lang)." ORDER BY available_later";
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $row){
			$arrMsgAvailableLater[htmlspecialchars($row['available_later'])]=$row['available_later'];
		}
		if(SCI::getConfigurationValue("SC_DELIVERYDATE_INSTALLED")=="1")
		{
			$sql = "SELECT DISTINCT available_later FROM "._DB_PREFIX_."sc_available_later WHERE id_lang=".intval($id_lang)." ORDER BY available_later";
			$res=Db::getInstance()->ExecuteS($sql);
			foreach($res as $row){
				$arrMsgAvailableLater[htmlspecialchars($row['available_later'])]=$row['available_later'];
			}
		}
		ksort($arrMsgAvailableLater);
	}
	// RatioPrice
	$arrRatioPrice=array();
	$arrRatioPriceUnity=array();
	if (sc_in_array('unit_price_ratio',$cols,'cols'))
	{
		$sql = "SELECT unit_price_ratio,unity FROM "._DB_PREFIX_."product";
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $row){
			$arrRatioPrice[$row['unit_price_ratio']]=number_format($row['unit_price_ratio'], 2, '.', '');
			$arrRatioPriceUnity[$row['unity']]=$row['unity'];
		}
	}

	/*
	0: coef = PV HT - PV HT
	1: coef = (PV HT - PA HT)*100 / PA HT
	2: coef = PV HT / PA HT
	3: coef = PV TTC / PA HT
	4: coef = (PV TTC - PA HT)*100 / PA HT
	5: coef = (PV HT - PA HT)*100 / PV HT
	*/
	/*$marginMatrix=array(
				0=>'[=c'.getColIndex('price').'-c'.getColIndex('wholesale_price').']',
				1=>'[=(c'.getColIndex('price').'-c'.getColIndex('wholesale_price').')*100/c'.getColIndex('wholesale_price').']',
				2=>'[=c'.getColIndex('price').'/c'.getColIndex('wholesale_price').']',
				3=>'[=c'.getColIndex('price_inc_tax').'/c'.getColIndex('wholesale_price').']',
				4=>'[=(c'.getColIndex('price_inc_tax').'-c'.getColIndex('wholesale_price').')*100/c'.getColIndex('wholesale_price').']',
				5=>'[=(c'.getColIndex('price').'-c'.getColIndex('wholesale_price').')*100/c'.getColIndex('price').']'
				);*/
	$marginMatrix_form=array(
			0=>'{price}-{wholesale_price}',
			1=>'({price}-{wholesale_price})*100/{wholesale_price}',
			2=>'{price}/{wholesale_price}',
			3=>'{price_inc_tax}/{wholesale_price}',
			4=>'({price_inc_tax}-{wholesale_price})*100/{wholesale_price}',
			5=>'({price}-{wholesale_price})*100/{price}'
	);

	$colSettings=array();
	$colSettings=SCI::getGridFields("product");
	sc_ext::readCustomGridsConfigXML('colSettings');

	function getColSettingsAsXML()
	{
		global $cols,$colSettings,$view;
		
		$uiset = uisettings::getSetting('cat_grid_'.$view);
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
					' width="'.( sc_array_key_exists($col,$sizes) && !empty($sizes[$col]) ? $sizes[$col] : ($view=='grid_combination_price'&&$col=='id' ? $colSettings[$col]['width']+50:$colSettings[$col]['width'])).'"'.
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

	// Products with combinations
	$prodWithAttributes=array();
	$countAttributes=array();
	if (sc_in_array('quantity',$cols,'cols'))
	{
		$res=Db::getInstance()->ExecuteS("SELECT id_product,SUM(quantity) AS ct FROM "._DB_PREFIX_."product_attribute GROUP BY id_product");
		foreach($res as $row){
			$prodWithAttributes[]=$row['id_product'];
			$countAttributes[$row['id_product']]=$row['ct'];
		}
	}

	// Products with compatibilites  #id_product/nbCompats
    $prodWithCompatibilities = array();
    if(defined('SC_UkooProductCompat_ACTIVE') && SC_UkooProductCompat_ACTIVE == 1 && SCI::moduleIsInstalled('ukoocompat')) {
        $sql ='SELECT id_product, COUNT(id_ukoocompat_compat) as nb_compat
                FROM '._DB_PREFIX_.'ukoocompat_compat
                GROUP BY id_product';
        $res = Db::getInstance()->ExecuteS($sql);
        if(!empty($res)) {
            foreach($res as $data) {
                $prodWithCompatibilities[(int)$data['id_product']] = (int)$data['nb_compat'];
            }
        }
    }

	function getProducts($id_category)
	{
		global $sql,$col,$tax,$arrManufacturers,$arrSuppliers,$prodWithAttributes,$countAttributes,$id_lang,$cols,$view,$colSettings,$user_lang_iso,$fields,$fields_lang,$forceUpdateCombinations,$fieldsWithHTML,$prodrow,$exportedProducts,$prodWithCompatibilities;
		$link=new Link();
		$col = "";
		$defaultimg='lib/img/i.gif';
		
		$is_segment = false;
		$segment=null;
		$id_segment = 0;
		if(substr($id_category, 0, 4)=="seg_" && SCSG)
		{
			$is_segment = true;
			$id_segment = intval(str_replace("seg_", "", $id_category));
			$segment = new ScSegment($id_segment);
			$id_category = 0;
		}
		else
			$id_category = intval($id_category);
		
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
		{
			if (file_exists(SC_PS_PATH_DIR."img/p/".$user_lang_iso."-default-"._s('CAT_PROD_GRID_IMAGE_SIZE')."_default.jpg"))
				$defaultimg=SC_PS_PATH_REL."img/p/".$user_lang_iso."-default-"._s('CAT_PROD_GRID_IMAGE_SIZE')."_default.jpg";
		}else{
			if (file_exists(SC_PS_PATH_DIR."img/p/".$user_lang_iso."-default-"._s('CAT_PROD_GRID_IMAGE_SIZE').".jpg"))
				$defaultimg=SC_PS_PATH_REL."img/p/".$user_lang_iso."-default-"._s('CAT_PROD_GRID_IMAGE_SIZE').".jpg";
		}

		$fields=array('reference','wholesale_price','price','unity','unit_price_ratio','ecotax','weight','supplier_reference','id_manufacturer','id_supplier',
									'id_tax','id_tax_rules_group','ean13','location','reduction_price','reduction_percent','reduction_from','reduction_to','on_sale',
									'out_of_stock','active','date_add','date_upd','id_color_default','minimal_quantity','quantity','upc','width','height','depth',
									'available_for_order','show_price','online_only','condition','additional_shipping_cost','available_date','visibility','is_virtual');
        if (version_compare(_PS_VERSION_, '1.7.0.0', '>='))
        {
            $fields[] = "show_condition";
            $fields[] = "isbn";
        }
        $fields_lang=array('name','available_now','available_later','link_rewrite','meta_title','meta_description','meta_keywords','description_short','description');
        if (version_compare(_PS_VERSION_, '1.7.3.0', '>='))
        {
            $fields[] = "additional_delivery_times";
            $fields_lang[] = "delivery_in_stock";
            $fields_lang[] = "delivery_out_stock";
            $fields[] = "low_stock_alert";
            $fields[] = "low_stock_threshold";
        }

        /*
         * FOR EXTENSIONS
         */
        ## extensions array
        $extension_fields = array();
        $extension_sql_SELECT = array();
        $extension_sql_JOIN = array();
        $extension_sql_WHERE = array();

        ## Select ALL id from categories
        $categories_selected = array();
        if (version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
            $sql = 'SELECT id_category 
                        FROM '._DB_PREFIX_.'category_shop 
                        WHERE id_shop = '.(int)SCI::getSelectedShop().' 
                        ORDER BY id_category ASC';
        } else {
            $sql = 'SELECT id_category 
                        FROM '._DB_PREFIX_.'category 
                        ORDER BY id_category ASC';
        }
        $cats = Db::getInstance()->executeS($sql);
        if(!empty($cats)) {
            foreach($cats as $r) {
                $categories_selected[] = (int)$r['id_category'];
            }
        }

        ## extensions
        if(defined('SC_FeedBiz_ACTIVE') && SC_FeedBiz_ACTIVE == 1 && SCI::moduleIsInstalled('feedbiz')) {
            $market_place_allowed = SCI::getFeedBizAllowedMarketPlace();

            if($view == 'grid_feedbiz_option') {
                $extension_fields[] = "(SELECT IF(COUNT(fpo.id_product),'"._l('Yes')."','"._l('No')."') FROM "._DB_PREFIX_."feedbiz_product_option fpo WHERE fpo.id_product = p.id_product) as fpo_enable_on_product";
                $extension_fields[] = "(SELECT COUNT(fpo.id_product_attribute) FROM "._DB_PREFIX_."feedbiz_product_option fpo WHERE fpo.id_product = p.id_product AND fpo.id_product_attribute != 0) as fpo_enable_on_attribute";
                $extension_fields[] = "fpo.id_product_attribute as fpo_id_product_attribute";
                $extension_fields[] = "fpo.force as fpo_force";
                $extension_fields[] = "fpo.disable as fpo_disable";
                $extension_fields[] = "fpo.price as fpo_price";
                $extension_fields[] = "fpo.shipping as fpo_shipping";
                $extension_fields[] = "fpo.text as fpo_text";
                $extension_sql_JOIN[] = " LEFT JOIN "._DB_PREFIX_."feedbiz_product_option fpo ON (fpo.id_product= p.id_product AND fpo.id_lang = ".(int)$id_lang.")";
            }
            if($market_place_allowed['amazon'] && $view == 'grid_feedbiz_amazon_option') {
                $extension_fields[] = "(SELECT IF(COUNT(fpao.id_product),'"._l('Yes')."','"._l('No')."') FROM "._DB_PREFIX_."feedbiz_amazon_options fpao WHERE fpao.id_product = p.id_product) as fpao_enable_on_product";
                $extension_fields[] = "(SELECT COUNT(fpao.id_product_attribute) FROM "._DB_PREFIX_."feedbiz_amazon_options fpao WHERE fpao.id_product = p.id_product AND fpao.id_product_attribute != 0) as fpao_enable_on_attribute";
                $iso = Language::getIsoById($id_lang);
                $extension_fields[] = "fpao.id_product_attribute as fpao_id_product_attribute";
                $extension_fields[] = "fpao.force as fpao_force";
                $extension_fields[] = "fpao.disable as fpao_disable";
                $extension_fields[] = "fpao.price as fpao_price";
                $extension_fields[] = "fpao.shipping as fpao_shipping";
                $extension_fields[] = "fpao.text as fpao_text";
                $extension_fields[] = "fpao.nopexport as fpao_nopexport";
                $extension_fields[] = "fpao.noqexport as fpao_noqexport";
                $extension_fields[] = "fpao.fba as fpao_fba";
                $extension_fields[] = "fpao.fba_value as fpao_fba_value";
                $extension_fields[] = "fpao.asin1 as fpao_asin1";
                $extension_fields[] = "fpao.asin2 as fpao_asin2";
                $extension_fields[] = "fpao.asin3 as fpao_asin3";
                $extension_fields[] = "fpao.bullet_point1 as fpao_bullet_point1";
                $extension_fields[] = "fpao.bullet_point2 as fpao_bullet_point2";
                $extension_fields[] = "fpao.bullet_point3 as fpao_bullet_point3";
                $extension_fields[] = "fpao.bullet_point4 as fpao_bullet_point4";
                $extension_fields[] = "fpao.bullet_point5 as fpao_bullet_point5";
                $extension_fields[] = "fpao.shipping_type as fpao_shipping_type";
                $extension_fields[] = "fpao.gift_wrap as fpao_gift_wrap";
                $extension_fields[] = "fpao.gift_message as fpao_gift_message";
                $extension_fields[] = "fpao.browsenode as fpao_browsenode";
                $extension_fields[] = "fpao.repricing_min as fpao_repricing_min";
                $extension_fields[] = "fpao.repricing_max as fpao_repricing_max";
                $extension_fields[] = "fpao.repricing_gap as fpao_repricing_gap";
                $extension_fields[] = "fpao.shipping_group as fpao_shipping_group";
                $extension_sql_JOIN[] = " LEFT JOIN "._DB_PREFIX_."feedbiz_amazon_options fpao ON (fpao.id_product= p.id_product AND fpao.region = '".$iso."')";
            }
            if($market_place_allowed['cdiscount'] && $view == 'grid_feedbiz_cdiscount_option') {
                $extension_fields[] = "(SELECT IF(COUNT(fpco.id_product),'"._l('Yes')."','"._l('No')."') FROM "._DB_PREFIX_."feedbiz_cdiscount_options fpco WHERE fpco.id_product = p.id_product) as fpco_enable_on_product";
                $extension_fields[] = "(SELECT COUNT(fpco.id_product_attribute) FROM "._DB_PREFIX_."feedbiz_cdiscount_options fpco WHERE fpco.id_product = p.id_product AND fpco.id_product_attribute != 0) as fpco_enable_on_attribute";
                $iso = Language::getIsoById($id_lang);
                $extension_fields[] = "fpco.id_product_attribute as fpco_id_product_attribute";
                $extension_fields[] = "fpco.force as fpco_force";
                $extension_fields[] = "fpco.disable as fpco_disable";
                $extension_fields[] = "fpco.price as fpco_price";
                $extension_fields[] = "fpco.price_up as fpco_price_up";
                $extension_fields[] = "fpco.price_down as fpco_price_down";
                $extension_fields[] = "fpco.shipping as fpco_shipping";
                $extension_fields[] = "fpco.shipping_delay as fpco_shipping_delay";
                $extension_fields[] = "fpco.clogistique as fpco_clogistique";
                $extension_fields[] = "fpco.valueadded as fpco_valueadded";
                $extension_fields[] = "fpco.text as fpco_text";
                $extension_sql_JOIN[] = " LEFT JOIN "._DB_PREFIX_."feedbiz_cdiscount_options fpco ON (fpco.id_product= p.id_product AND fpco.region = '".$iso."')";
            }
        }

        if (version_compare(_PS_VERSION_, '1.7.5.0', '>=')) {
            $extension_fields[] = 'sa.`physical_quantity` as soft_qty_physical';
            $extension_fields[] = 'sa.`reserved_quantity` as soft_qty_reserved';
        }

        ## extensions array modification
        if (!empty($extension_fields)) {
            $extension_without_alias = array();
            foreach($extension_fields as $ext_field) {
                list($table_field,$alias) = explode(" as ", $ext_field);
                if(!empty($alias)) {
                    $extension_without_alias[$alias] = $ext_field;
                } else {
                    $extension_without_alias[$ext_field] = $ext_field;
                }
            }
        }
        $extension_sql_SELECT = (!empty($extension_sql_SELECT) ? implode(',',$extension_sql_SELECT) : '');
        $extension_sql_JOIN = (!empty($extension_sql_JOIN) ? implode(' ',$extension_sql_JOIN) : '');
        $extension_sql_WHERE = (!empty($extension_sql_WHERE) ? implode(' AND ',$extension_sql_WHERE) : '');

		$forceUpdateCombinations=array('price_inc_tax','price','id_tax','id_tax_rules_group');
		$fieldsWithHTML=array('description','description_short');
		sc_ext::readCustomGridsConfigXML('updateSettings');
		$sqlProduct='p.id_product';
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			$sqlProduct.=',p.`id_shop_default`';
		$sqlProductLang=',pl.link_rewrite';
		if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
		{
			$blacklistfields=array('margin','reduction_price','reduction_percent','reduction_from','reduction_to');
		}else{
			$blacklistfields=array('margin');
		}
		if ($_GET['tree_mode']=='all')
			$blacklistfields[]='position';
		foreach($cols as $col)
		{
			if (sc_in_array($col,$blacklistfields,'blacklistfields')) // calculated fields
				continue;
			if (sc_in_array($col,$fields,'fields'))
				$sqlProduct.=',p.`'.$col.'`';
			if (sc_in_array($col,$fields_lang,'fields_lang'))
				$sqlProductLang.=',pl.`'.$col.'`';
            if (!empty($extension_fields) && array_key_exists($col,$extension_without_alias))
                $sqlProduct.=','.$extension_without_alias[$col];
		}
		$sqlProduct=trim($sqlProduct,',').',';
		$sqlProductLang=trim($sqlProductLang,',');
		
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
		{
			$shop_id = SCI::getSelectedShop();
			if(!empty($shop_id))
			{
				$shop = new Shop((int)$shop_id);
				$shop_group = $shop->getGroup();
			}
			else
			{
				$shop = new Shop((int)Configuration::get("PS_SHOP_DEFAULT"));
				$shop_group = $shop->getGroup();
			}
		}

        $left_join_image = null;
        if(version_compare(_PS_VERSION_, '1.5.0.0', '>=')) {
            if(SCI::getSelectedShop()>0)
            {
               $left_join_image = " LEFT JOIN "._DB_PREFIX_."image i ON (i.id_product= p.id_product) 
                                LEFT JOIN "._DB_PREFIX_."image_shop imgs ON (imgs.id_image = i.id_image  AND imgs.id_shop = ".(int)SCI::getSelectedShop()." AND imgs.cover=1)";
                $select_image = " ,(SELECT i.id_image FROM "._DB_PREFIX_."image i INNER JOIN "._DB_PREFIX_."image_shop imgs ON (imgs.id_image = i.id_image  AND imgs.id_shop = ".(int)SCI::getSelectedShop()." AND imgs.cover=1) WHERE i.id_product= p.id_product LIMIT 1) AS id_image";
            }
            else
            {
                $select_image = " ,(SELECT i.id_image FROM "._DB_PREFIX_."image i WHERE i.id_product= p.id_product AND i.cover=1 LIMIT 1) AS id_image";
            }
        } else if(version_compare(_PS_VERSION_, '1.6.1.0', '>=')) {
            if(SCI::getSelectedShop()>0)
            {
                $left_join_image = " LEFT JOIN "._DB_PREFIX_."image_shop i ON (i.id_product= p.id_product AND i.id_shop = ".(int)SCI::getSelectedShop()." AND i.cover=1)";
                $select_image = " ,(SELECT i.id_image FROM "._DB_PREFIX_."image_shop i WHERE i.id_product= p.id_product AND i.id_shop = ".(int)SCI::getSelectedShop()." AND i.cover=1 LIMIT 1) AS id_image";
            }
            else
            {
                $select_image = " ,(SELECT i.id_image FROM "._DB_PREFIX_."image i WHERE i.id_product= p.id_product AND i.cover=1 LIMIT 1) AS id_image";
            }
        } else {
            $left_join_image = " LEFT JOIN "._DB_PREFIX_."image i ON (i.id_product= p.id_product AND i.cover=1)";
            $select_image = " ,(SELECT i.id_image FROM "._DB_PREFIX_."image i WHERE i.id_product= p.id_product AND i.cover=1 LIMIT 1) AS id_image";
        }
		
		if (version_compare(_PS_VERSION_, '1.5.0.0', '<') && $_GET['tree_mode']=='all' && $id_category=="1" && !$is_segment)
		{
			$sql="SELECT ".$sqlProduct.$sqlProductLang.",'-' AS position".
						(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0?$select_image:'').
						',"" as last_order';
            $sql.= $extension_sql_SELECT;
			sc_ext::readCustomGridsConfigXML('SQLSelectDataSelect');
			$sql.=" FROM "._DB_PREFIX_."product p
						LEFT JOIN "._DB_PREFIX_."product_lang pl ON (pl.id_product= p.id_product AND pl.id_lang=".intval($id_lang).") ".
                //(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0 ? $left_join_image : '').
            $sql.= $extension_sql_JOIN;
			sc_ext::readCustomGridsConfigXML('SQLSelectDataLeftJoin');
			$sql.= " WHERE 1=1 ";
            $sql.= $extension_sql_WHERE;
			sc_ext::readCustomGridsConfigXML('SQLSelectDataWhere');
			$sql.= " GROUP BY p.id_product ORDER BY p.id_product DESC";
		}else{
			if(SCSG && $is_segment && !empty($id_segment))
			{
				$query_segment = "";
				if($segment->type=="manual")
					$query_segment = " AND p.id_product IN (SELECT id_element FROM "._DB_PREFIX_."sc_segment_element WHERE type_element='product' AND id_segment='".intval($id_segment)."')";
				elseif($segment->type=="auto")
				{
					$params = array("id_lang"=>$id_lang, "id_segment"=>$id_segment, "access"=>"catalog");
					for($i=1;$i<=15;$i++)
					{
						$param=Tools::getValue('segment_params_'.$i);
						if(!empty($param))
							$params['segment_params_'.$i]=$param;
					}
					if(SCMS)
						$params['id_shop']=(int)SCI::getSelectedShop();
					$query_segment = SegmentHook::hookByIdSegment("segmentAutoSqlQuery", $segment, $params);
				}
				
				$sql="SELECT ".$sqlProduct.$sqlProductLang.
							(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0?$select_image:'').
							(version_compare(_PS_VERSION_, '1.5.0.0', '>=')?",sa.quantity, sa.out_of_stock":'').
						',"" as last_order';
                $sql.= $extension_sql_SELECT;
				sc_ext::readCustomGridsConfigXML('SQLSelectDataSelect');
				$sql.=		" FROM "._DB_PREFIX_."product p
							LEFT JOIN "._DB_PREFIX_."product_lang pl ON (pl.id_product= p.id_product AND pl.id_lang=".intval($id_lang).(SCMS?(SCI::getSelectedShop()>0?' AND pl.id_shop='.(int)SCI::getSelectedShop():' AND pl.id_shop=p.id_shop_default '):'').") ".
                            //(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0 ? $left_join_image : '').
							(version_compare(_PS_VERSION_, '1.5.0.0', '>=')?"LEFT JOIN "._DB_PREFIX_."product_supplier ps ON (ps.id_product=p.id_product AND ps.id_product_attribute=0 AND ps.id_supplier=p.id_supplier) 
									LEFT JOIN "._DB_PREFIX_."stock_available sa ON (sa.id_product=p.id_product AND sa.id_product_attribute=0 ".($shop_group->share_stock ? "AND sa.id_shop_group=".(int)$shop_group->id." AND sa.id_shop=0":"AND sa.id_shop=".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():'p.id_shop_default')).") 
								".(SCMS?"	LEFT JOIN "._DB_PREFIX_."supplier_shop ss ON (ss.id_supplier = ps.id_supplier AND ss.id_shop=".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():'p.id_shop_default').")":"")."":'');
					$sql.=
								(SCMS? "INNER JOIN "._DB_PREFIX_."product_shop prs ON (prs.id_product=p.id_product AND prs.id_shop = (".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():'p.id_shop_default')."))":'').
								((!SCMS && version_compare(_PS_VERSION_, '1.5.0.0', '>='))?"INNER JOIN "._DB_PREFIX_."product_shop prs ON (prs.id_product=p.id_product AND prs.id_shop = p.id_shop_default)":'');
                    $sql.= $extension_sql_JOIN;
					sc_ext::readCustomGridsConfigXML('SQLSelectDataLeftJoin');
					$sql.="WHERE 1=1 ".
								$query_segment." ";
                    $sql.= $extension_sql_WHERE;
					sc_ext::readCustomGridsConfigXML('SQLSelectDataWhere');
					$sql.= " GROUP BY p.id_product ORDER BY p.id_product";
			}
			else
			{
				if ($_GET['productsfrom']=='default') // by id_category_default
				{
					$sql="SELECT ".$sqlProduct."'-' AS position,".$sqlProductLang.
								(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0?$select_image:'').
								(version_compare(_PS_VERSION_, '1.5.0.0', '>=')?",sa.quantity, sa.out_of_stock":'').
							',"" as last_order';
                    $sql.= $extension_sql_SELECT;
					sc_ext::readCustomGridsConfigXML('SQLSelectDataSelect');
					$sql.=		" FROM "._DB_PREFIX_."product p
								LEFT JOIN "._DB_PREFIX_."product_lang pl ON (pl.id_product= p.id_product AND pl.id_lang=".intval($id_lang).(SCMS?(SCI::getSelectedShop()>0?' AND pl.id_shop='.(int)SCI::getSelectedShop():' AND pl.id_shop=p.id_shop_default '):'').")".
								//(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0 ? $left_join_image : '').
								(version_compare(_PS_VERSION_, '1.5.0.0', '>=')?"LEFT JOIN "._DB_PREFIX_."product_supplier ps ON (ps.id_product=p.id_product AND ps.id_product_attribute=0 AND ps.id_supplier=p.id_supplier) 
																					LEFT JOIN "._DB_PREFIX_."stock_available sa ON (sa.id_product=p.id_product AND sa.id_product_attribute=0 ".($shop_group->share_stock ? "AND sa.id_shop_group=".(int)$shop_group->id." AND sa.id_shop=0":"AND sa.id_shop=".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():'p.id_shop_default')).") 
									".(SCMS?"	LEFT JOIN "._DB_PREFIX_."supplier_shop ss ON (ss.id_supplier = ps.id_supplier AND ss.id_shop=".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():'p.id_shop_default').")":"")."":'');
					$sql.=
					(SCMS? "INNER JOIN "._DB_PREFIX_."product_shop prs ON (prs.id_product=p.id_product AND prs.id_shop = (".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():'p.id_shop_default')."))":'').
					((!SCMS && version_compare(_PS_VERSION_, '1.5.0.0', '>='))?"INNER JOIN "._DB_PREFIX_."product_shop prs ON (prs.id_product=p.id_product AND prs.id_shop = p.id_shop_default)":'');
                    $sql.= $extension_sql_JOIN;
					sc_ext::readCustomGridsConfigXML('SQLSelectDataLeftJoin');
					$sql.=" WHERE 1=1 ".
					(!empty($id_category)?" AND ".((SCMS && $selected_shops_id > 0) || (!SCMS && version_compare(_PS_VERSION_, '1.5.0.0', '>='))?"prs.":"p.")."id_category_default=".intval($id_category):"")." ";
                    $sql.= $extension_sql_WHERE;
					sc_ext::readCustomGridsConfigXML('SQLSelectDataWhere');
					$sql.= " GROUP BY p.id_product ";
				}else{
					$sql="SELECT ".$sqlProduct."cp.position,".$sqlProductLang.
								(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0?$select_image:'').
								(version_compare(_PS_VERSION_, '1.5.0.0', '>=')?",sa.quantity, sa.out_of_stock":'').
							',"" as last_order';
                    $sql.= $extension_sql_SELECT;
					sc_ext::readCustomGridsConfigXML('SQLSelectDataSelect');
					$sql.=		" FROM "._DB_PREFIX_."category_product cp
								LEFT JOIN "._DB_PREFIX_."product p ON (cp.id_product= p.id_product)
								LEFT JOIN "._DB_PREFIX_."category c ON (cp.id_category= c.id_category)
								LEFT JOIN "._DB_PREFIX_."product_lang pl ON (pl.id_product= p.id_product AND pl.id_lang=".intval($id_lang).(SCMS?(SCI::getSelectedShop()>0?' AND pl.id_shop='.(int)SCI::getSelectedShop():' AND pl.id_shop=p.id_shop_default '):'').") ".
                                //(_s('CAT_PROD_GRID_DISABLE_IMAGE')==0 ? $left_join_image : '').
								(version_compare(_PS_VERSION_, '1.5.0.0', '>=')?"LEFT JOIN "._DB_PREFIX_."product_supplier ps ON (ps.id_product=p.id_product AND ps.id_product_attribute=0 AND ps.id_supplier=p.id_supplier) 
																																 LEFT JOIN "._DB_PREFIX_."stock_available sa ON (sa.id_product=p.id_product AND sa.id_product_attribute=0 ".($shop_group->share_stock ? "AND sa.id_shop_group=".(int)$shop_group->id." AND sa.id_shop=0":"AND sa.id_shop=".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():'p.id_shop_default')).") 
									".(SCMS?"	LEFT JOIN "._DB_PREFIX_."supplier_shop ss ON (ss.id_supplier = ps.id_supplier AND ss.id_shop=".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():'p.id_shop_default').")":"")."":'');
					
					if (version_compare(_PS_VERSION_, '1.4.0.0', '>=') && !empty($id_category) && $_GET['tree_mode']=='all' && !$is_segment)
					{
						$cat = new Category($id_category); 
						$cat_selection = " AND c.nleft >= ".(int)$cat->nleft." AND c.nright <= ".(int)$cat->nright." ";
					}else{
						$cat_selection = " AND cp.id_category=".intval($id_category);
					}
					$sql.=
									(SCMS? "INNER JOIN "._DB_PREFIX_."product_shop prs ON (prs.id_product=p.id_product AND prs.id_shop = ".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():'p.id_shop_default').")":'').
									((!SCMS && version_compare(_PS_VERSION_, '1.5.0.0', '>='))?"INNER JOIN "._DB_PREFIX_."product_shop prs ON (prs.id_product=p.id_product AND prs.id_shop = p.id_shop_default)":'');
                    $sql.= $extension_sql_JOIN;
					sc_ext::readCustomGridsConfigXML('SQLSelectDataLeftJoin');
					$sql.="WHERE 1=1 ".
							(!empty($id_category) ? $cat_selection : '')." ";
                    $sql.= $extension_sql_WHERE;
					sc_ext::readCustomGridsConfigXML('SQLSelectDataWhere');
					$sql.= " GROUP BY p.id_product ORDER BY cp.position";
				}
			}
		}
		global $dd;
		$dd=$sql;
//echo "\n\n\n\n".$sql."\n\n\n\n";die();
		$res=Db::getInstance()->ExecuteS($sql);

		if(!empty($res) && defined('SC_FeedBiz_ACTIVE') && SC_FeedBiz_ACTIVE == 1 && SCI::moduleIsInstalled('feedbiz'))
		{
            $iso_langs = Language::getIsoIds();
            $count_langs = count($iso_langs);
		    $id_product_list = array();
		    foreach($res as $r) {
		        $id_product_list[] = (int)$r['id_product'];
            }
		    $categories = unserialize(Db::getInstance()->getValue('SELECT value 
                                                                          FROM '._DB_PREFIX_.'feedbiz_configuration 
                                                                          WHERE configuration = "feedbiz_categories" 
                                                                          AND id_shop ='.(int)SCI::getSelectedShop()));
            ##feedbiz
            $sql = 'SELECT `id_product`,`id_lang`,`id_product_attribute`,`disable` 
                    FROM '._DB_PREFIX_.'feedbiz_product_option
                    WHERE id_product IN ('.pSQL(implode(',',$id_product_list)).')';
		    $fb_data = Db::getInstance()->ExecuteS($sql);
		    $cache_feedbiz_present = checkMarketPlacePresence($id_product_list,$categories_selected,$fb_data,$categories,$count_langs);

            ##feedbiz_amazon
            if($market_place_allowed['amazon'] == 1) {
                $sql = 'SELECT `id_product`,`region`,`id_product_attribute`,`disable` 
                    FROM ' . _DB_PREFIX_ . 'feedbiz_amazon_options
                    WHERE id_product IN (' . pSQL(implode(',', $id_product_list)) . ')';
                $fba_data = Db::getInstance()->ExecuteS($sql);
                $cache_feedbiz_amazon_present = checkMarketPlacePresence($id_product_list, $categories_selected, $fba_data, $categories, $count_langs);
            }
            if($market_place_allowed['cdiscount'] == 1){
                $sql = 'SELECT `id_product`,`region`,`id_product_attribute`,`disable` 
                    FROM ' . _DB_PREFIX_ . 'feedbiz_cdiscount_options
                    WHERE id_product IN (' . pSQL(implode(',', $id_product_list)) . ')';
                $fba_data = Db::getInstance()->ExecuteS($sql);
                $cache_feedbiz_cdiscount_present = checkMarketPlacePresence($id_product_list, $categories_selected, $fba_data, $categories, $count_langs);
            }
        }

		if(!empty($res) && defined('SC_Amazon_ACTIVE') && SC_Amazon_ACTIVE == 1  && SCI::moduleIsInstalled('amazon'))
		{
		    $id_product_list = array();
		    foreach($res as $r) {
		        $id_product_list[] = (int)$r['id_product'];
            }

            $categories = unserialize(Db::getInstance()->getValue('SELECT value FROM '._DB_PREFIX_.'amazon_configuration WHERE id_shop = '.(int)SCI::getSelectedShop().' AND name = "AMAZON_CATEGORIES"'));
            if(empty($categories)) {
                $categories = unserialize(Db::getInstance()->getValue('SELECT value FROM '._DB_PREFIX_.'amazon_configuration WHERE id_shop IS NULL AND name = "AMAZON_CATEGORIES"'));
                if(empty($categories)) {
                    $categories = unserialize(base64_decode(Db::getInstance()->getValue('SELECT value FROM '._DB_PREFIX_.'marketplace_configuration WHERE marketplace = "amazon" AND configuration = "categories"')));
                }
            }

            $sql = 'SELECT `id_product`,`id_lang`,`id_product_attribute`,`disable`
                    FROM '._DB_PREFIX_.'marketplace_product_option
                    WHERE id_product IN ('.pSQL(implode(',',$id_product_list)).')';
            $amazon_data = Db::getInstance()->ExecuteS($sql);
            $regions = unserialize(base64_decode(Configuration::get('AMAZON_REGION')));
            if(empty($regions)) {
                $regions = Db::getInstance()->getValue('SELECT value FROM '._DB_PREFIX_.'amazon_configuration WHERE name = "AMAZON_REGION"');
                $regions = unserialize($regions);
            }
            $count_regions = count($regions);
            $cache_amazon_present = checkMarketPlacePresence($id_product_list,$categories_selected,$amazon_data,$categories,$count_regions);
        }
        if(!empty($res) && defined('SC_Cdiscount_ACTIVE') && SC_Cdiscount_ACTIVE == 1  && SCI::moduleIsInstalled('cdiscount'))
        {
            $id_product_list = array();
		    foreach($res as $r) {
		        $id_product_list[] = (int)$r['id_product'];
            }

            $categories = unserialize(base64_decode(Db::getInstance()->getValue('SELECT value FROM '._DB_PREFIX_.'marketplace_configuration WHERE marketplace = "cdiscount" AND configuration = "categories"')));

            $sql = 'SELECT `id_product`,`id_lang`,`disable`
                    FROM '._DB_PREFIX_.'cdiscount_product_option
                    WHERE id_product IN ('.pSQL(implode(',',$id_product_list)).')';
		    $cdiscount_data = Db::getInstance()->ExecuteS($sql);
            $cache_cdiscount_present = checkMarketPlacePresence($id_product_list,$categories_selected,$cdiscount_data,$categories);
        }
		
		$multiStoresFields=array();
		foreach($cols as $field)
		{
			if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') 
				&& ($def = ObjectModel::getDefinition('Product'))
				&& isset($def['fields'][$field]['shop'])
				&& $def['fields'][$field]['shop']
				&& $field!="quantity")
			{
				$multiStoresFields[]=$field;
			}
		}
		
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
		{
			$sql2="SELECT ps.`id_product`".(count($multiStoresFields)?",ps.`".join('`,ps.`',$multiStoresFields)."`":"")." FROM "._DB_PREFIX_."category_product cp
							LEFT JOIN "._DB_PREFIX_."product p ON (cp.id_product= p.id_product)
								LEFT JOIN "._DB_PREFIX_."product_shop ps ON (p.id_product= ps.id_product AND ps.id_shop=".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():'p.id_shop_default').")
							WHERE 1=1 ".
							( $_GET['tree_mode']!='all' && (!SCSG || !$is_segment) && !empty($id_category) ? " AND cp.id_category=".intval($id_category)." ":'').
							(SCSG && $is_segment && !empty($id_segment) ? " AND ps.id_product IN (SELECT id_element FROM "._DB_PREFIX_."sc_segment_element WHERE type_element='product' AND id_segment='".intval($id_segment)."')":'').
							" GROUP BY ps.`id_product` ORDER BY cp.position";
			$res2=Db::getInstance()->ExecuteS($sql2);
			$arrayP=array();
			foreach($res2 AS $r)
			{
				$arrayP[$r['id_product']]=$r;
			}
			foreach($res as $k => $prodrow){
				foreach($multiStoresFields as $field)
				{
					if(isset($arrayP[$prodrow['id_product']][$field]))
						$res[$k][$field]=$arrayP[$prodrow['id_product']][$field];
				}
			}
		}		
		
		foreach($res as $prodrow){
			if (sc_array_key_exists($prodrow['id_product'], $exportedProducts))
				continue;
			$exportedProducts[$prodrow['id_product']] = 1;
			// tax compatibility for PS 1.4
			if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
				$prodrow['id_tax']=$prodrow['id_tax_rules_group'];
			// reduction period process
			$reductionColor='';
			$reductionNameColor='';
			$user_data = array("id_specific_price");
			if (sc_in_array('reduction_from',$cols,'cols'))
			{
				$prodrow['price_with_reduction']=0;
				$prodrow['price_with_reduction_percent']=0;
				
				$prodrow['margin_wt_amount_after_reduction']=0;
				$prodrow['margin_wt_percent_after_reduction']=0;
				$prodrow['margin_after_reduction']=0;
				$prodrow['price_wt_with_reduction']=0;
				$prodrow['price_it_with_reduction']=0;
				$prodrow['reduction_tax']=_s('CAT_PROD_SPECIFIC_PRICES_DEFAULT_TAX');
				if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
				{
					$sql_specific_price = "SELECT * 
									FROM `"._DB_PREFIX_."specific_price`
									WHERE id_product = '".$prodrow['id_product']."'
										 AND (`from` <= '".date("Y-m-d H:i:s")."' OR `from`='0000-00-00 00:00:00')
										 AND (`to` >= '".date("Y-m-d H:i:s")."' OR `to`='0000-00-00 00:00:00')
										 ".(SCMS?" AND ( id_shop = '".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():$prodrow['id_shop_default'])."' OR id_shop = '0' ) ":"")."
										 ".(version_compare(_PS_VERSION_, '1.5.0.0', '>=')?"AND id_product_attribute = 0":"")."
									 ORDER BY `id_shop` DESC,`to` DESC, id_specific_price ASC
									 LIMIT 1";
					$res_specific_price=Db::getInstance()->executeS($sql_specific_price);
					if(!empty($res_specific_price[0]["id_specific_price"]))
					{
						
						$res_specific_price = $res_specific_price[0];
						
						$user_data["id_specific_price"] = $res_specific_price["id_specific_price"];
						
						$prodrow['reduction_from']=$res_specific_price['from'];
						$prodrow['reduction_to']=$res_specific_price['to'];
						if ($res_specific_price['reduction_type']=='percentage')
						{
							$prodrow['reduction_percent']=$res_specific_price['reduction']*100;
							$prodrow['reduction_price']=0;
						}else{
							$prodrow['reduction_percent']=0;
							$prodrow['reduction_price']=$res_specific_price['reduction'];
						}
						if ($prodrow['reduction_price'] > 0)
						{
							$prodrow['price_with_reduction']=(($prodrow['price'] * ($tax[intval($prodrow['id_tax'])]/100+1)))-$prodrow['reduction_price'] + ((_s('CAT_PROD_ECOTAXINCLUDED') ? $prodrow['ecotax']*SCI::getEcotaxTaxRate() : 0 ));
							$prodrow['price_it_with_reduction']=$prodrow['price_with_reduction'];
							$prodrow['price_wt_with_reduction']=(($prodrow['price']))-($prodrow['reduction_price']/($tax[intval($prodrow['id_tax'])]/100+1));
						}
						//$prodrow['price_with_reduction']=$res_specific_price['price']*($tax[intval($res_specific_price['id_tax'])]/100+1)-$res_specific_price['reduction_price'];
						if ($prodrow['reduction_percent'] > 0)
						{
							$prodrow['price_with_reduction_percent'] = (($prodrow['price'] * ($tax[intval($prodrow['id_tax'])]/100+1))) * (1-$res_specific_price['reduction']) + ((_s('CAT_PROD_ECOTAXINCLUDED') ? $prodrow['ecotax']*SCI::getEcotaxTaxRate() : 0 ));
							$prodrow['price_it_with_reduction']=$prodrow['price_with_reduction_percent'];
							$prodrow['price_wt_with_reduction']=(($prodrow['price'])) * (1-$res_specific_price['reduction']);
						}
						//$prodrow['price_with_reduction_percent']=$res_specific_price['price']*($tax[intval($res_specific_price['id_tax'])]/100+1)*(1-$res_specific_price['reduction_percent']/100);
						;
						$reductionColor='#FFAAFF';
						if ($prodrow['reduction_from']==$prodrow['reduction_to'])
						{
							$prodrow['reduction_from']=date('Y-01-01 00:00:00');
							$prodrow['reduction_to']=(date('Y')+1).date('-m-d 00:00:00');
						}
						if ($prodrow['reduction_from']=='0000-00-00 00:00:00') $prodrow['reduction_from']=date('Y-01-01 00:00:00');
						if ($prodrow['reduction_to']=='0000-00-00 00:00:00') $prodrow['reduction_to']=(date('Y')+1).date('-m-d 00:00:00'); 
					
						if(version_compare(_PS_VERSION_, '1.6.0.11', '>='))
							$prodrow['reduction_tax']=$res_specific_price['reduction_tax'];						
					}
					
					// COULEUR DU CHAMPS "NOM" POUR LES PROMOTIONS
						// PROMOTIONS ACTIVES
						$sql_reduc = "SELECT id_specific_price 
									FROM `"._DB_PREFIX_."specific_price`
									WHERE id_product = '".$prodrow['id_product']."'
										 AND `from` <= '".date("Y-m-d H:i:s")."'
										 AND (`to` >= '".date("Y-m-d H:i:s")."' OR `to`='0000-00-00 00:00:00')
										 AND (
										 		`reduction` > 0
										 		OR `price` > 0
										 	)
									 ORDER BY id_specific_price
									 LIMIT 1";
						$res_reduc=Db::getInstance()->executeS($sql_reduc);
						if(!empty($res_reduc[0]["id_specific_price"]))
							$reductionNameColor='#FFAAFF';

						// PROMOTIONS A VENIR
						if(empty($reductionNameColor))
						{
							$sql_reduc = "SELECT id_specific_price 
									FROM `"._DB_PREFIX_."specific_price`
									WHERE id_product = '".$prodrow['id_product']."'
										 AND `from` > '".date("Y-m-d H:i:s")."'
										 AND (
										 		`reduction` > 0
										 		OR `price` > 0
										 	)
									 ORDER BY id_specific_price
									 LIMIT 1";
							$res_reduc=Db::getInstance()->executeS($sql_reduc);
							if(!empty($res_reduc[0]["id_specific_price"]))
								$reductionNameColor='#eed9ee';
						}
				}
				/*elseif (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
				{
					$prodrow['reduction_from']=$prodrow['from'];
					$prodrow['reduction_to']=$prodrow['to'];
					if(
						(!empty($prodrow['reduction_from']) || $prodrow['reduction_from']=="0000-00-00 00:00:00")
						&& 
						(!empty($prodrow['reduction_to']) || $prodrow['reduction_to']=="0000-00-00 00:00:00")
					)
					{
						if ($prodrow['reduction_type']=='percentage')
						{
							$prodrow['reduction_percent']=$prodrow['reduction']*100;
							$prodrow['reduction_price']=0;
						}else{
							$prodrow['reduction_percent']=0;
							$prodrow['reduction_price']=$prodrow['reduction'];
						}
						$dstart=str_replace(array(':',' ','-'),'',$prodrow['reduction_from']);
						$dend=str_replace(array(':',' ','-'),'',$prodrow['reduction_to']);
						$now=date('YmdHis');
						if (($now >= $dstart 
									&& $now <= $dend 
									&& ($prodrow['reduction_price'] > 0 || $prodrow['reduction_percent'] > 0))
							|| ($dstart==$dend && $dstart=='00000000000000'
									&& ($prodrow['reduction_price'] > 0 || $prodrow['reduction_percent'] > 0))
							|| ($now >= $dstart && $dend=='00000000000000'
									&& ($prodrow['reduction_price'] > 0 || $prodrow['reduction_percent'] > 0))
								) 
						{
							if ($prodrow['reduction_price'] > 0)
								$prodrow['price_with_reduction']=$prodrow['price']*($tax[intval($prodrow['id_tax'])]/100+1)-$prodrow['reduction_price'];
							if ($prodrow['reduction_percent'] > 0)
								$prodrow['price_with_reduction_percent']=$prodrow['price']*($tax[intval($prodrow['id_tax'])]/100+1)*(1-$prodrow['reduction_percent']/100);
							$reductionColor='#FFAAFF';
						}
						if ($prodrow['reduction_from']==$prodrow['reduction_to'])
						{
							$prodrow['reduction_from']=date('Y-01-01 00:00:00');
							$prodrow['reduction_to']=(date('Y')+1).date('-m-d 00:00:00');
						}
					}
					if ($prodrow['reduction_from']=='0000-00-00 00:00:00') $prodrow['reduction_from']=date('Y-01-01 00:00:00');
					if ($prodrow['reduction_to']=='0000-00-00 00:00:00') $prodrow['reduction_to']=(date('Y')+1).date('-m-d 00:00:00'); 
				}*/
				elseif (version_compare(_PS_VERSION_, '1.3.0.4', '>=')) // DATE => DATETIME field format
				{
					$prodrow['reduction_from']=($prodrow['reduction_from']=='0000-00-00 00:00:00' || $prodrow['reduction_from']=='1970-01-01 00:00:00' || $prodrow['reduction_from']==NULL ? '2012-01-01 00:00:00':$prodrow['reduction_from']);
					$prodrow['reduction_to']=($prodrow['reduction_to']=='0000-00-00 00:00:00' || $prodrow['reduction_to']=='1970-01-01 00:00:00' || $prodrow['reduction_to']==NULL ? '2012-01-01 00:00:00':$prodrow['reduction_to']);
					$dstart=str_replace(':','',str_replace(' ','',str_replace('-','',$prodrow['reduction_from'])));
					$dend=str_replace(':','',str_replace(' ','',str_replace('-','',$prodrow['reduction_to'])));
					$now=date('YmdHis');
					if (($now >= $dstart 
								&& $now <= $dend 
								&& ($prodrow['reduction_price'] > 0 || $prodrow['reduction_percent'] > 0)) 
						|| ($dstart==$dend 
								&& ($prodrow['reduction_price'] > 0 || $prodrow['reduction_percent'] > 0))) 
								{
									if ($prodrow['reduction_price'] > 0)
									{
										$prodrow['price_with_reduction']=$prodrow['price']*($tax[intval($prodrow['id_tax'])]/100+1)-$prodrow['reduction_price'];
										$prodrow['price_it_with_reduction']=$prodrow['price_with_reduction'];
										$prodrow['price_wt_with_reduction']=$prodrow['price']-($prodrow['reduction_price']/($tax[intval($prodrow['id_tax'])]/100+1));
									}
									if ($prodrow['reduction_percent'] > 0)
									{
										$prodrow['price_with_reduction_percent']=$prodrow['price']*($tax[intval($prodrow['id_tax'])]/100+1)*(1-$prodrow['reduction_percent']/100);
										$prodrow['price_it_with_reduction']=$prodrow['price_with_reduction_percent'];
										$prodrow['price_wt_with_reduction']=$prodrow['price']*(1-$prodrow['reduction_percent']/100);
									}
									$reductionColor='#FFAAFF';
								}
					if ($prodrow['reduction_from']==$prodrow['reduction_to'])
					{
						$prodrow['reduction_from']=date('Y-m-d H:00:00');
						$prodrow['reduction_to']=date('Y-m-d H:00:00');
					}
				}else{ // old versions
					$prodrow['reduction_from']=($prodrow['reduction_from']=='0000-00-00' || $prodrow['reduction_from']==NULL ? '2012-01-01':$prodrow['reduction_from']);
					$prodrow['reduction_to']=($prodrow['reduction_to']=='0000-00-00' || $prodrow['reduction_to']==NULL ? '2012-01-01':$prodrow['reduction_to']);
					$dstart=join('',explode('-',$prodrow['reduction_from']));
					$dend=join('',explode('-',$prodrow['reduction_to']));
					$now=date('Ymd');
					if (($now >= $dstart 
								&& $now <= $dend 
								&& ($prodrow['reduction_price'] > 0 || $prodrow['reduction_percent'] > 0)) 
						|| ($dstart==$dend 
								&& ($prodrow['reduction_price'] > 0 || $prodrow['reduction_percent'] > 0)))
								{
									if ($prodrow['reduction_price'] > 0)
									{
										$prodrow['price_with_reduction']=$prodrow['price']*($tax[intval($prodrow['id_tax'])]/100+1)-$prodrow['reduction_price'];
										$prodrow['price_it_with_reduction']=$prodrow['price_with_reduction'];
										$prodrow['price_wt_with_reduction']=$prodrow['price']-($prodrow['reduction_price']/($tax[intval($prodrow['id_tax'])]/100+1));
									}
									if ($prodrow['reduction_percent'] > 0)
									{
										$prodrow['price_with_reduction_percent']=$prodrow['price']*($tax[intval($prodrow['id_tax'])]/100+1)*(1-$prodrow['reduction_percent']/100);
										$prodrow['price_it_with_reduction']=$prodrow['price_with_reduction_percent'];
										$prodrow['price_wt_with_reduction']=$prodrow['price']*(1-$prodrow['reduction_percent']/100);
									}
									$reductionColor='#FFAAFF';
								}
					if ($prodrow['reduction_from']==$prodrow['reduction_to'])
					{
						$prodrow['reduction_from']=date('Y-m-d');
						$prodrow['reduction_to']=date('Y-m-d');
					}
				}
			}
			if (sc_in_array('discountprice',$cols,'cols'))
			{
				if (version_compare(_PS_VERSION_, '1.4.0.0', '<'))
				{
					$sql = 'SELECT * FROM '._DB_PREFIX_.'discount_quantity WHERE id_product = '.intval($prodrow['id_product']).' ORDER BY quantity';
					$res=Db::getInstance()->ExecuteS($sql);
					$discountprice='';
					foreach ($res AS $dp)
					{
						$discountprice.=$dp['quantity'].":".number_format($dp['value'],2).($dp['id_discount_type']==1?'%':'')."_";
					}
					$discountprice=trim($discountprice,'_');
				}elseif(version_compare(_PS_VERSION_, '1.4.0.0', '>=') && version_compare(_PS_VERSION_, '1.5.0.0', '<'))
				{
					$sql = 'SELECT from_quantity,reduction_type,reduction,price,`from`,`to`,id_group,id_country,id_currency FROM '._DB_PREFIX_.'specific_price WHERE id_product = '.intval($prodrow['id_product']).' ORDER BY from_quantity';
					$res=Db::getInstance()->ExecuteS($sql);
					$discountprice='';
					foreach ($res AS $dp)
					{
						$discountprice.=$dp['from_quantity']."|".
														number_format(($dp['reduction_type']=='percentage' ? $dp['reduction']*100:$dp['reduction']),2).($dp['reduction_type']=='percentage'?'%':'')."|".
														number_format($dp['price'],2)."|".
														$dp['from']."|".
														$dp['to']."|".
														$dp['id_group']."|".
														$dp['id_country']."|".
														$dp['id_currency'].
														"_";
					}
					$discountprice=trim($discountprice,'_');
				}else{ // for PS >= 1.5 ; we take only id_product_attribute = 0
					$sql = 'SELECT from_quantity,reduction_type,reduction,price,`from`,`to`,id_group,id_country,id_currency,id_shop_group,id_shop FROM '._DB_PREFIX_.'specific_price WHERE id_product = '.intval($prodrow['id_product']).' AND id_specific_price_rule = 0 AND id_cart = 0 AND id_product_attribute = 0 ORDER BY from_quantity,id_shop_group,id_shop';
					$res=Db::getInstance()->ExecuteS($sql);
					$discountprice='';
					foreach ($res AS $dp)
					{
						$discountprice.=$dp['from_quantity']."|".
														number_format(($dp['reduction_type']=='percentage' ? $dp['reduction']*100:$dp['reduction']),2).($dp['reduction_type']=='percentage'?'%':'')."|".
														number_format($dp['price'],2)."|".
														$dp['from']."|".
														$dp['to']."|".
														$dp['id_group']."|".
														$dp['id_country']."|".
														$dp['id_currency']."|".
														$dp['id_shop_group']."|".
														$dp['id_shop'].
														"_";
					}
					$discountprice=trim($discountprice,'_');
				}
			}
			// build xml
			echo "<row id=\"".$prodrow['id_product']."\">";
//			echo 		"<userdata name=\"id_category_default\">".intval($prodrow['id_category_default'])."</userdata>";
				$temp_id = 0;
				if(!empty($user_data["id_specific_price"]))
					$temp_id = $user_data["id_specific_price"];
			echo 		"<userdata name=\"id_specific_price\">".intval($temp_id)."</userdata>";
			sc_ext::readCustomGridsConfigXML('rowUserData',$prodrow);

			$type_advanced_stock_management = 1;// Not Advanced Stock Management
			$is_advanced_stock_management = false;
			$has_combination = false;
			$not_in_warehouse = true;
			$without_warehouse = true;
			if(SCAS)
			{
				// Produit utilise la gestion avancée
				if($prodrow['advanced_stock_management']==1)
				{
					$is_advanced_stock_management = true;
					$type_advanced_stock_management = 2;// With Advanced Stock Management
					
					// Produit est lié à l'entrepôt
					$temp_check_in_warehouse = WarehouseProductLocation::getIdByProductAndWarehouse((int)$prodrow['id_product'], 0, (int)SCI::getSelectedWarehouse());
					if(!empty($temp_check_in_warehouse))
					{
						$not_in_warehouse = false;
						$without_warehouse = false;
					}
					
					// Produit lié à au moins un entrepôt
					if($not_in_warehouse)
					{
						$query = new DbQuery();
						$query->select('wpl.id_warehouse_product_location');
						$query->from('warehouse_product_location', 'wpl');
						$query->where('wpl.id_product = '.(int)$prodrow['id_product'].'
							AND wpl.id_product_attribute = 0
							AND wpl.id_warehouse != 0'
						);
						$rslt = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($query);
						if(count($rslt)>0)
							$without_warehouse = false;
					}
					
					if(!StockAvailable::dependsOnStock((int)$prodrow['id_product'], (SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():$prodrow['id_shop_default'])))
						$type_advanced_stock_management = 3;// With Advanced Stock Management + Manual management
					
				}

				echo 		"<userdata name=\"type_advanced_stock_management\">".intval($type_advanced_stock_management)."</userdata>";
			}
			if (sc_in_array($prodrow['id_product'],$prodWithAttributes,'prodWithAttributes'))
				$has_combination = true;
			$avanced_quantities = array("physical_quantity"=>0,"usable_quantity"=>0);
			if($has_combination && SCAS)
			{
				$query = new DbQuery();
				$query->select('SUM(st.physical_quantity) as physical_quantity');
				$query->select('SUM(st.usable_quantity) as usable_quantity');
				//$query->select('SUM(price_te * physical_quantity) as valuation');
				$query->from('stock', "st");
				$query->innerJoin("warehouse_product_location", "wpl", "(wpl.id_product = st.id_product AND wpl.id_product_attribute = st.id_product_attribute AND wpl.id_warehouse = ".(int)SCI::getSelectedWarehouse().")");
				$query->where('st.id_product = '.(int)$prodrow['id_product'].'');
				$query->where('st.id_warehouse = '.(int)SCI::getSelectedWarehouse().'');
				$query->where('st.id_product_attribute != 0');
				$avanced_quantities = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($query);
			}
			elseif(!$not_in_warehouse && SCAS)
			{
				$query = new DbQuery();
				$query->select('SUM(physical_quantity) as physical_quantity');
				$query->select('SUM(usable_quantity) as usable_quantity');
				//$query->select('SUM(price_te * physical_quantity) as valuation');
				$query->from('stock');
				$query->where('id_product = '.(int)$prodrow['id_product'].'');
				$query->where('id_warehouse = '.(int)SCI::getSelectedWarehouse().'');
				$avanced_quantities = Db::getInstance(_PS_USE_SQL_SLAVE_)->getRow($query);
			}
			foreach($cols AS $key => $col)
			{
				switch($col){
					case'id':
						echo 	"<cell>".$prodrow['id_product']."</cell>"; //  style=\"color:tan\"
						break;
					case'name':
						$color = ($prodrow['active']==0?'#D7D7D7':($reductionColor!=''?$reductionColor:''));
						if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
						{
							if(!empty($reductionNameColor) || (($view=="grid_discount" || $view=="grid_discount_2") && $prodrow['active']!=0))
								$color = $reductionNameColor;
						}
						echo "<cell".(!empty($color)?' bgColor="'.$color.'"':"")."><![CDATA[".$prodrow['name']."]]></cell>";
						break;
					case'reduction_price':case'reduction_percent':case'price_with_reduction':case'price_with_reduction_percent':
						case'margin_wt_amount_after_reduction':case'margin_wt_percent_after_reduction':case'margin_after_reduction':
						case'price_wt_with_reduction':case'price_it_with_reduction':
						echo "<cell".($reductionColor!=''?' bgColor="'.$reductionColor.'"':'').">".number_format($prodrow[$col], 2, '.', '')."</cell>";
						break;
					case 'last_order':
						$val = "";
						$last_order=Db::getInstance()->ExecuteS("SELECT MAX(o.id_order) as id_order
								FROM "._DB_PREFIX_."orders o
									INNER JOIN "._DB_PREFIX_."order_detail od ON (o.id_order = od.id_order AND od.product_id='".(int)$prodrow['id_product']."')
								WHERE o.valid = '1'
								LIMIT 1");
						if(!empty($last_order[0]["id_order"]))
						{
							$date=Db::getInstance()->ExecuteS("SELECT date_add FROM "._DB_PREFIX_."order_history WHERE id_order='".(int)$last_order[0]["id_order"]."' ORDER BY date_add ASC LIMIT 1");
							if(!empty($date[0]["date_add"]))
								$val = $date[0]["date_add"];
						}
						echo "<cell><![CDATA[".$val."]]></cell>";
						break;
					case'supplier_reference':
						if (version_compare(_PS_VERSION_, '1.5.0.0', '>='))
						{
							$resRefSup=Db::getInstance()->ExecuteS("SELECT product_supplier_reference FROM "._DB_PREFIX_."product_supplier WHERE id_product='".(int)$prodrow['id_product']."' AND id_product_attribute=0 AND id_supplier='".(int)$prodrow['id_supplier']."'");
							echo "<cell><![CDATA[".(!empty($resRefSup[0]["product_supplier_reference"])?$resRefSup[0]["product_supplier_reference"]:"")."]]></cell>";
						}	
						else
							echo "<cell><![CDATA[".$prodrow[$col]."]]></cell>";
						break;
					case'ean13':case'location':case'out_of_stock':case'reference':case'meta_description':case'meta_keywords':
						echo "<cell><![CDATA[".$prodrow[$col]."]]></cell>";
						break;
                    case'location_new':
                        $location_new=Db::getInstance()->getValue("SELECT location FROM "._DB_PREFIX_."stock_available WHERE id_product='".(int)$prodrow['id_product']."' AND id_product_attribute=0 AND id_shop=".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():$prodrow['id_shop_default']));
					    echo "<cell><![CDATA[".$location_new."]]></cell>";
					    break;
                    case'meta_title':
						if (strlen($prodrow[$col]) >= _s("CAT_SEO_META_TITLE_COLOR")){
						echo "<cell style='background-color: #FE9730'><![CDATA[".$prodrow[$col]."]]></cell>";
						}
						else {
							echo "<cell><![CDATA[".$prodrow[$col]."]]></cell>";
						}
						break;
					case'quantity':
							if($has_combination && $type_advanced_stock_management==2)
							{
								echo 		"<cell bgColor=\"#D7D7D7\" type=\"ro\"></cell>";
							}elseif($type_advanced_stock_management==2)
							{
								echo 		"<cell type=\"ro\"></cell>";
							}elseif($has_combination)
							{
								/*$qty = $countAttributes[$prodrow['id_product']];
								if(version_compare(_PS_VERSION_, '1.5.0.0', '>='))
								{
									$qty = 0;
									$sql_qty = "SELECT quantity FROM "._DB_PREFIX_."stock_available WHERE id_product='".(int)$prodrow['id_product']."' AND id_product_attribute>0 AND quantity>0";
									if(SCMS)
										$sql_qty .= " AND (id_shop = '".(SCI::getSelectedShop()>0?(int)SCI::getSelectedShop():$prodrow['id_shop_default'])."' OR id_shop = '0')";
									$res=Db::getInstance()->ExecuteS($sql_qty);
									foreach($res as $row){
										$qty += $row["quantity"];
									}
								}*/
								$qty = SCI::getProductQty((int)$prodrow['id_product']);
								
								echo 		"<cell bgColor=\"#D7D7D7\" type=\"ro\">".$qty."</cell>";
							}else{
								echo 		"<cell>".$prodrow['quantity']."</cell>";
							}
						break;
					case'quantityupdate':
						$editable='';
						
						if ($has_combination/* && $type_advanced_stock_management==2*/)
							$editable=' bgColor="#D7D7D7" type="ro"';
						elseif ($without_warehouse && $type_advanced_stock_management==2)
							$editable=' bgColor="#e7ab70" type="ro"';
						elseif ($not_in_warehouse && $type_advanced_stock_management==2)
							$editable=' bgColor="#f7e4bf" type="ro"';
						elseif ($type_advanced_stock_management==2)
							$editable=' bgColor="#d7f7bf"';
						echo 		"<cell".$editable."></cell>";
						break;
					case'quantity_usable':						
						$editable='';
						
						$value = $avanced_quantities['usable_quantity'];
						if($type_advanced_stock_management!=2)
							$value = "";
						
						if ($has_combination && $type_advanced_stock_management==2)
							$editable=' bgColor="#D7D7D7" type="ro"';
						elseif ($without_warehouse && $type_advanced_stock_management==2)
							$editable=' bgColor="#e7ab70" type="ro"';
						elseif ($not_in_warehouse && $type_advanced_stock_management==2)
							$editable=' bgColor="#f7e4bf" type="ro"';
						elseif ($type_advanced_stock_management==2)
							$editable=' bgColor="#d7f7bf" type="ro"';
						echo 		"<cell".$editable.">".$value."</cell>";
						break;
					case'quantity_physical':
						$editable='';
						$value = $avanced_quantities['physical_quantity'];
						if($type_advanced_stock_management!=2)
							$value = "";
						
						if ($has_combination && $type_advanced_stock_management==2)
							$editable=' bgColor="#D7D7D7" type="ro"';
						elseif ($without_warehouse && $type_advanced_stock_management==2)
							$editable=' bgColor="#e7ab70" type="ro"';
						elseif ($not_in_warehouse && $type_advanced_stock_management==2)
							$editable=' bgColor="#f7e4bf" type="ro"';
						elseif ($type_advanced_stock_management==2)
							$editable=' bgColor="#d7f7bf" type="ro"';
						echo 		"<cell".$editable.">".$value."</cell>";
						break;
					case'quantity_real':
						$editable='';
						
						$value = SCI::getProductRealQuantities($prodrow['id_product'],
								null,
								(int)SCI::getSelectedWarehouse(),
								true,
								$has_combination);
						if($type_advanced_stock_management!=2)
							$value = "";

						if ($has_combination && $type_advanced_stock_management==2)
							$editable=' bgColor="#D7D7D7" type="ro"';
						elseif ($without_warehouse && $type_advanced_stock_management==2)
							$editable=' bgColor="#e7ab70" type="ro"';
						elseif ($not_in_warehouse && $type_advanced_stock_management==2)
							$editable=' bgColor="#f7e4bf" type="ro"';
						elseif ($type_advanced_stock_management==2)
							$editable=' bgColor="#d7f7bf" type="ro"';
						echo 		"<cell".$editable.">".$value."</cell>";
						break;
                    case'soft_qty_physical':
                        $editable='';
                        if ($has_combination) {
                            $editable = ' bgColor="#D7D7D7"';
                        }
                        echo "<cell".$editable.">".(int)$prodrow[$col]."</cell>";
                        break;
                    case'soft_qty_reserved':
                        $editable='';
                        if ($has_combination) {
                            $editable = ' bgColor="#D7D7D7"';
                        }
                        echo "<cell".$editable.">".(int)$prodrow[$col]."</cell>";
                        break;
					case'location_warehouse':
						$editable='';
						$value = "";
						if ($has_combination && $type_advanced_stock_management!=1)
							$editable=' bgColor="#D7D7D7"';
						elseif ($without_warehouse && $type_advanced_stock_management!=1)
							$editable=' bgColor="#e7ab70"';
						elseif ($not_in_warehouse && $type_advanced_stock_management!=1)
							$editable=' bgColor="#f7e4bf"';
						elseif ($type_advanced_stock_management!=1)
						{
							$editable=' bgColor="#d7f7bf"';
							$value = WarehouseProductLocation::getProductLocation((int)$prodrow['id_product'], 0, (int)SCI::getSelectedWarehouse());
						}		
						echo 		"<cell".$editable.">".$value."</cell>";
						break;
					case'advanced_stock_management':
						$editable='';
						if ($has_combination && $type_advanced_stock_management!=1)
							$editable=' bgColor="#D7D7D7"';
						elseif ($without_warehouse && $type_advanced_stock_management!=1)
							$editable=' bgColor="#e7ab70"';
						elseif ($not_in_warehouse && $type_advanced_stock_management!=1)
							$editable=' bgColor="#f7e4bf"';
						elseif ($type_advanced_stock_management!=1)
							$editable=' bgColor="#d7f7bf"';
						echo 		"<cell".$editable.">".$type_advanced_stock_management."</cell>";
						break;
					case'wholesale_price':
						echo "<cell".($prodrow['wholesale_price'] > $prodrow['price']?' bgColor="#FF0000"  style="color:#FFFFFF"':'').">".number_format($prodrow['wholesale_price'], (_s('CAT_PROD_WHOLESALEPRICE4DEC')?4:2), '.', '')."</cell>";
						break;
					case'ecotax':
						if(empty($prodrow['ecotax']))
							$prodrow['ecotax'] = 0;
						echo "<cell>".number_format( (version_compare(_PS_VERSION_, '1.3.0.0', '>=') ? $prodrow['ecotax'] * SCI::getEcotaxTaxRate() : $prodrow['ecotax'] ) , 6, '.', '')."</cell>";
						break;
					case'price':
						echo "<cell".(sc_array_key_exists('wholesale_price',$prodrow) && $prodrow['wholesale_price'] > $prodrow['price']?' bgColor="#FF0000"  style="color:#FFFFFF"':'').">".number_format($prodrow['price'], 6, '.', '')."</cell>";
						break;
					case'price_inc_tax':
						$ecotax = (_s('CAT_PROD_ECOTAXINCLUDED') ? ( version_compare(_PS_VERSION_, '1.3.0.0', '>=') ? $prodrow['ecotax']*SCI::getEcotaxTaxRate() : $prodrow['ecotax'] ) : 0);
						echo "<cell>".number_format($prodrow['price']*($tax[intval($prodrow['id_tax'])]/100+1)+$ecotax, 6, '.', '')."</cell>";
						break;
					case'unit_price_ratio':
						$temp_val = 0;
						if(!empty($prodrow['price']) && $prodrow['price'] > 0)
							if(!empty($prodrow[$col]) && $prodrow[$col]>0)
								$temp_val = number_format($prodrow['price']/ $prodrow[$col], 6, '.', '');
							else
								$temp_val = 1;
						echo "<cell>".$temp_val."</cell>";
						break;
					case'unit_price_inc_tax':
						$temp_val = 0;
						$unit_price_ratio = $prodrow['unit_price_ratio'];
						if(!empty($prodrow['price']) && $prodrow['price'] > 0)
							if(!empty($unit_price_ratio) && $unit_price_ratio>0) {
								$temp_val = number_format($prodrow['price']/ $unit_price_ratio, 6, '.', '');
							} else {
								$temp_val = 1;
							}
							$temp_val = number_format($temp_val*($tax[intval($prodrow['id_tax'])]/100+1), 6, '.', '');
						echo "<cell>".$temp_val."</cell>";
						break;
					case'date_add':
						$date_add=explode(' ',$prodrow['date_add']);
						echo "<cell>".($date_add[0]=='0000-00-00'?(date('Y')-1).'-01-01 '.$date_add[1]:$prodrow['date_add'])."</cell>";
						break;
					case'available_now':case'available_later':
						echo "<cell".(sc_array_key_exists($col,$prodrow) ? '><![CDATA['.$prodrow[$col].']]>' : ' type="ro">NA')."</cell>";
						break;
					case'discountprice':
						echo "<cell>".$discountprice."</cell>";
						break;
					case'link_rewrite':
						echo '<cell><![CDATA['.$prodrow[$col].']]></cell>';
						break;
					case'description_short':
						echo '<cell><![CDATA['.$prodrow[$col].']]></cell>';
						break;
					case'combinations':
						echo '<cell><![CDATA[combinations_'.$prodrow['id_product'].']]></cell>';
						break;
					case'redirect_type':
						echo '<cell><![CDATA['.($prodrow[$col]==''?'-':$prodrow[$col]).']]></cell>';
						break;
					case'description':
						echo '<cell><![CDATA['.$prodrow[$col].']]></cell>';
						break;
					case'image':
						if ($prodrow['id_image']=='')
						{
							echo "<cell><![CDATA[<img src='".$defaultimg."'/>--]]></cell>";
						}else{
							if (file_exists(SC_PS_PATH_REL."img/p/".getImgPath(intval($prodrow['id_product']),intval($prodrow['id_image']),_s('CAT_PROD_GRID_IMAGE_SIZE')))) {
								echo "<cell><![CDATA[<img src='".SC_PS_PATH_REL."img/p/".getImgPath(intval($prodrow['id_product']),intval($prodrow['id_image']),_s('CAT_PROD_GRID_IMAGE_SIZE'))."'/>]]></cell>";
							} else {
								echo "<cell><![CDATA[<img src='".$defaultimg."'/>--]]></cell>";
							}
						}
						break;
					case'id_supplier':
						if(!empty($prodrow[$col]) && !empty($arrSuppliers[$prodrow[$col]]))
							echo "<cell>".$prodrow[$col]."</cell>";
						else
							echo "<cell>0</cell>";
						break;
					case'id_manufacturer':
						if(!empty($prodrow[$col]) && !empty($arrManufacturers[$prodrow[$col]]))
							echo "<cell>".$prodrow[$col]."</cell>";
						else
							echo "<cell>0</cell>";
						break;
					// extra
					case'price_public':
						echo "<cell>".number_format($prodrow[$col], 2, '.', '')."</cell>";
						break;
					case'margin':
						echo '<cell></cell>';
						break;
					case'nb_compatibilities':
						echo '<cell>'.(!empty($prodWithCompatibilities[(int)$prodrow['id_product']]) ? $prodWithCompatibilities[(int)$prodrow['id_product']] : '0').'</cell>';
						break;
					case'compatibilities':
						echo '<cell><![CDATA[compatibilities_'.(int)$prodrow['id_product'].']]></cell>';
						break;
					case'amazon':
					    $value = presentMarketPlaceValue($prodrow['id_product'],$cache_amazon_present);
                        echo '<cell><![CDATA['.$value.']]></cell>';
						break;
					case'cdiscount':
						$value = presentMarketPlaceValue($prodrow['id_product'],$cache_cdiscount_present);
                        echo '<cell><![CDATA['.$value.']]></cell>';
						break;
					case'feedbiz':
					    $value = presentMarketPlaceValue($prodrow['id_product'],$cache_feedbiz_present);
                        echo '<cell><![CDATA['.$value.']]></cell>';
						break;
					case'feedbiz_amazon':
					    $value = presentMarketPlaceValue($prodrow['id_product'],$cache_feedbiz_amazon_present);
                        echo '<cell><![CDATA['.$value.']]></cell>';
						break;
					case'feedbiz_cdiscount':
					    $value = presentMarketPlaceValue($prodrow['id_product'],$cache_feedbiz_cdiscount_present);
                        echo '<cell><![CDATA['.$value.']]></cell>';
						break;
					default:
						sc_ext::readCustomGridsConfigXML('rowData');
						if (sc_array_key_exists('buildDefaultValue',$colSettings[$col]) && $colSettings[$col]['buildDefaultValue']!='')
						{
							if ($colSettings[$col]['buildDefaultValue']=='ID')
								echo "<cell>ID".$prodrow['id_product']."</cell>";
						}else{
							if ($prodrow[$col]=='' || $prodrow[$col]===0 || $prodrow[$col]===1) // opti perf is_numeric($prodrow[$col]) || 
							{
								echo "<cell>".$prodrow[$col]."</cell>";
							}else{
								echo "<cell><![CDATA[".$prodrow[$col]."]]></cell>";
							}
						}
				}
			}
			// COMBINATIONS
			/*if ($view=='grid_combination_price')
			{
				$sql="SELECT * FROM "._DB_PREFIX_."product_attribute pa ";
				$sql.=" WHERE pa.id_product=".intval($prodrow['id_product']);
				$rescombi=Db::getInstance()->ExecuteS($sql);
				foreach($rescombi as $combirow){
					// build xml
					echo "<row id=\"".$prodrow['id_product']."_".$combirow['id_product_attribute']."\">";
					foreach($cols AS $key => $col)
					{
						switch($col){
							case'id':
								echo 	"<cell style=\"color:#999999\">".$combirow['id_product_attribute']."</cell>";
								break;
							case'name':
								echo "<cell><![CDATA["."]]>Attributes...</cell>";
								break;
							case'supplier_reference':case'ean13':case'location':case'reference':
								echo "<cell><![CDATA[".$combirow[$col]."]]></cell>";
								break;
							case'quantity':
								echo "<cell>".$combirow['quantity']."</cell>";
								break;
							case'quantityupdate': // handled by quantity
								break;
							case'wholesale_price':
								echo "<cell".($combirow['wholesale_price'] > $combirow['price']?' bgColor="#FF0000"  style="color:#FFFFFF"':'').">".number_format($combirow['wholesale_price'], 2, '.', '')."</cell>";
								break;
							case'price':
								echo "<cell".($combirow['wholesale_price'] > $combirow['price']?' bgColor="#FF0000"  style="color:#FFFFFF"':'').">".number_format($combirow['price'], 2, '.', '')."</cell>";
								break;
							case'price_inc_tax':
								echo "<cell>".number_format($combirow['price']*($tax[$prodrow['id_tax']]/100+1), 2, '.', '')."</cell>";
								break;
							// extra
							case'price_public':
								echo "<cell>".number_format($combirow[$col], 2, '.', '')."</cell>";
								break;
							default:
								echo (sc_array_key_exists($col,$combirow)?"<cell>".$combirow[$col]."</cell>":"<cell></cell>");
						}
					}
					echo "</row>\n";
				}
			}*/
			echo "</row>\n";
		}
		if (version_compare(_PS_VERSION_, '1.5.0.0', '<') && $_GET['tree_mode']=='all' && $id_category!="1" && !$is_segment)
			getSubCategoriesProducts($id_category);
	}

	function checkMarketPlacePresence($init_products,$categories_selected,$product_option,$categories,$count_langs = null)
    {
        $return = array();
        if(!empty($product_option))
        {
            foreach($init_products as $id_product)
            {
                $return_value = array();
                foreach($product_option as $row) {
                    if($row['id_product'] == $id_product) {
                        if(array_key_exists('disable', $row)){
                            $return_value[] = $row['disable'];
                        } else {
                            $return_value[] = 0;
                        }
                    }
                }

                if($count_langs) {
                    $count_values = count($return_value);
                    if($count_values > 1) {
                        if($count_values == $count_langs) {
                            $return_unique = array_unique($return_value);
                            if(count($return_unique) > 1) {
                                $return[$id_product] = 2;
                            } else {
                                $return[$id_product] = $return_unique[0];
                            }
                        } else {
                            $return_unique = array_unique($return_value);
                            if(count($return_unique) > 1) {
                                $return[$id_product] = 2;
                            } else {
                                $return[$id_product] = $return_unique[0];
                                if($return[$id_product] == 1) {
                                    $return[$id_product] = 2;
                                }
                            }
                        }
                    } else {
                        $return[$id_product] = (!empty($return_value[0]) ? 1 : 0);
                        if($return[$id_product] == 1 && $count_langs > 1) {
                            $return[$id_product] = 2;
                        }
                    }
                } else {
                    $return_unique = array_unique($return_value);
                    if(count($return_unique) > 1) {
                        $return[$id_product] = 2;
                    } else {
                        $return[$id_product] = $return_unique[0];
                    }
                }
            }
        } else {
            foreach($init_products as $id_product) {
                $return[$id_product] = 0;
            }
        }

        $category_filters = array();
        foreach($categories_selected as $cat) {
			if(!empty($cat) && !empty($categories)) {
				if(in_array($cat,$categories)) {
					$category_filters[] = $cat;
				}
			}
        }
        if($category_filters) {
            $sql = 'SELECT DISTINCT(id_product)
                FROM ' . _DB_PREFIX_ . 'category_product
                WHERE id_category IN (' . pSQL(implode(',', $category_filters)) . ')';
            $rows = Db::getInstance()->executeS($sql);
        }
        if(!empty($rows)) {
            foreach($rows as $row) {
                if(!array_key_exists($row['id_product'], $return)) {
                    $return[$row['id_product']] = 0;
                }
            }
        }
        return $return;
    }

	function presentMarketPlaceValue($id_product,$cache_item)
    {
        if(array_key_exists($id_product,$cache_item)) {
            switch($cache_item[$id_product]) {
                case 0:
                    return _l('Yes');
                    break;
                case 1:
                    return _l('No');
                    break;
                case 2:
                    return _l('Mixed');
                    break;
            }
        } else {
            return _l('No');
        }
    }

	function getSubCategoriesProducts($parent_id)
	{
		$sql = "SELECT c.id_category FROM "._DB_PREFIX_."category c WHERE c.id_parent=".intval($parent_id);
		$res=Db::getInstance()->ExecuteS($sql);
		foreach($res as $row){
			getProducts($row['id_category']);
			getSubCategoriesProducts($row['id_category']);
		}
	}

	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	 		header("Content-type: application/xhtml+xml"); 
	} else {
	 		header("Content-type: text/xml");
	}
	echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"); 
	echo '<rows><head>';
	echo getColSettingsAsXML();
	if (sc_in_array('description',$cols,'cols'))
		echo '<beforeInit><call command="enableMultiline"><param>1</param></call></beforeInit>';
	echo '<afterInit><call command="attachHeader"><param>'.getFilterColSettings().'</param></call>
			<call command="attachFooter"><param><![CDATA['.getFooterColSettings().']]></param></call></afterInit>';
	echo '</head>'."\n";
	
	$uiset = uisettings::getSetting('cat_grid_'.$view);
	$tmp = explode('|',$uiset);
	$uiset = "|".$tmp[1]."||".$tmp[3];
	echo '<userdata name="uisettings">'.$uiset.'</userdata>'."\n";
	
	echo '<userdata name="marginMatrix_form">'.$marginMatrix_form[_s('CAT_PROD_GRID_MARGIN_OPERATION')].'</userdata>'."\n";
	echo '<userdata name="LIMIT_SMARTRENDERING">'.intval(_s("CAT_PROD_LIMIT_SMARTRENDERING")).'</userdata>'."\n";
	sc_ext::readCustomGridsConfigXML('gridUserData');
	echo "\n";
	getProducts($_GET['idc']);
/*	if ($_GET['tree_mode']=='all' && intval($_GET['idc'])!=1 && !(substr($_GET['idc'], 0, 4)=="seg_" && SCSG)) // sql optimised in function getProducts for category 1
	{
		getSubCategoriesProducts(intval($_GET['idc']));
	}*/
	if (isset($_GET['DEBUG'])) echo '<az><![CDATA['.$dd.']]></az>';
	echo '</rows>';
