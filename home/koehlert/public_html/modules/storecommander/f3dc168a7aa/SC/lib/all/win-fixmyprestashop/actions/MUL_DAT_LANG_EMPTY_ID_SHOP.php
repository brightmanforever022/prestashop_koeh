<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*
	 * TABLES
	 */
	
	$sql = "SHOW TABLES";
	$res=Db::getInstance()->ExecuteS($sql);
	$tables = array();
	foreach($res as $table)
	{
		$name_table = reset($table);
		if(strpos($name_table, '_lang')!==false && $name_table!=_DB_PREFIX_."lang")
		{
			$sql_columns = "SHOW COLUMNS FROM ".pSQL($name_table);
			$res_columns=Db::getInstance()->ExecuteS($sql_columns);
			foreach($res_columns as $res_column)
			{
				if($res_column["Field"]=="id_shop")
					$tables[] = $name_table;
			}
		}
	}
	
	/*
	 * REQUETES
	 */
	$content = "";
	$content_js = "";
	$results = "OK";
	$elements = array();
	
	foreach($tables as $table)
	{
		$sql = "SELECT * FROM ".psql($table)."  WHERE id_shop IS NULL OR id_shop='' OR id_shop=0 LIMIT 1500";
		//echo $sql."\n";
		$res=Db::getInstance()->ExecuteS($sql);
		if(!empty($res) && count($res)>0)
		{
			foreach($res as $row)
			{
				$name_element = str_replace(_DB_PREFIX_, "", $table);
				$name_element = str_replace("_lang", "", $name_element);
				
				$elements[] = array(
					"id_lang"=> $row["id_lang"],
					"id_element"=> $row["id_".$name_element],
					"table"=> $table
				);
			}
		}
	}
	//die();
	
	if(!empty($elements) && count($elements)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbEmptyIdShop = dhxlSCExtCheck.tabbar.cells("table_MUL_DAT_LANG_EMPTY_ID_SHOP").attachToolbar();
			tbEmptyIdShop.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbEmptyIdShop.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbEmptyIdShop.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbEmptyIdShop.setItemToolTip('delete','<?php echo _l('Delete incomplete rows')?>');
			tbEmptyIdShop.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridEmptyIdShop.selectAll();
					}
					if (id=='delete')
					{
						removeEmptyLangIdShop()
					}
				});
		
			var gridEmptyIdShop = dhxlSCExtCheck.tabbar.cells("table_MUL_DAT_LANG_EMPTY_ID_SHOP").attachGrid();
			gridEmptyIdShop.setImagePath("lib/js/imgs/");
			gridEmptyIdShop.enableSmartRendering(true);
			gridEmptyIdShop.enableMultiselect(true);
	
			gridEmptyIdShop.setHeader("<?php echo _l('Table')?>,ID_lang, ID_element");
			gridEmptyIdShop.setInitWidths("100,100,100");
			gridEmptyIdShop.setColAlign("left,right,right");
			gridEmptyIdShop.init();

			var xml = '<rows>';
			<?php foreach ($elements as $element) { ?>
			xml = xml+'   <row id="<?php echo $element["table"]."-".$element["id_lang"]."-".$element["id_element"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $element["table"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo $element["id_lang"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php echo $element["id_element"] ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridEmptyIdShop.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_MUL_DAT_LANG_EMPTY_ID_SHOP").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($elements) ; ?>', height: 25 });

			function removeEmptyLangIdShop()
			{
				var selectedEmptyLangIdShops = gridEmptyIdShop.getSelectedRowId();
				if(selectedEmptyLangIdShops==null || selectedEmptyLangIdShops=="")
					selectedEmptyLangIdShops = 0;
				if(selectedEmptyLangIdShops!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=MUL_DAT_LANG_EMPTY_ID_SHOP&id_lang="+SC_ID_LANG, { "action": "remove_rows", "ids": selectedEmptyLangIdShops}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_MUL_DAT_LANG_EMPTY_ID_SHOP").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('MUL_DAT_LANG_EMPTY_ID_SHOP');
						 doCheck(false);
					});
				}
			}
		</script>
		<?php 
		$content_js = ob_get_clean();
	}
	echo Tools::jsonEncode(array(
			"results"=>$results,
			"contentType"=>"grid", 
			"content"=>$content,
			"title"=>_l('Empty id_shop'), 
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="remove_rows")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $table_id)
		{
			list($table, $id_lang, $id_element) = explode("-", $table_id);

			$name_element = str_replace(_DB_PREFIX_, "", $table);
			$name_element = str_replace("_lang", "", $name_element);
			
			$sql = "DELETE FROM ".pSQL($table)." 
					WHERE
						(id_shop IS NULL OR id_shop='' OR id_shop=0)
						AND id_".pSQL($name_element)."='".(int)$id_element."'
						AND id_lang='".(int)$id_lang."'";
//			echo $sql."\n\n";
			$res=dbExecuteForeignKeyOff($sql);
		}
	}
}
