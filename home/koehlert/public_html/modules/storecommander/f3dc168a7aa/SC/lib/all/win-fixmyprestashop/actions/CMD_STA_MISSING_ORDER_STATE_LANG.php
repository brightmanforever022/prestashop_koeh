<?php
$post_action = Tools::getValue("action");
if(!empty($post_action) && $post_action=="do_check")
{
	/*$sql = "select p.* from "._DB_PREFIX_."order_state p where p.id_order_state not in (select pl.id_order_state from "._DB_PREFIX_."order_state_lang pl)";
	$res=Db::getInstance()->ExecuteS($sql);*/
	$res=missingLangGet("order_state");
	
	$content = "";
	$content_js = "";
	$results = "OK";
	if(!empty($res) && count($res)>0)
	{
		$results = "KO";
		ob_start();
		?>
		<script type="text/javascript">
	
			var tbMissingOrderStateLang = dhxlSCExtCheck.tabbar.cells("table_CMD_STA_MISSING_ORDER_STATE_LANG").attachToolbar();
			tbMissingOrderStateLang.addButton("selectall", 0, "", "lib/img/application_lightning.png", "lib/img/application_lightning.png");
			tbMissingOrderStateLang.setItemToolTip('selectall','<?php echo _l('Select all')?>');
			tbMissingOrderStateLang.addButton("delete", 0, "", "lib/img/delete.gif", "lib/img/delete.gif");
			tbMissingOrderStateLang.setItemToolTip('delete','<?php echo _l('Delete incomplete order states')?>');
			tbMissingOrderStateLang.addButton("add", 0, "", "lib/img/add.png", "lib/img/add.png");
			tbMissingOrderStateLang.setItemToolTip('add','<?php echo _l('Recover incomplete order states')?>');
			tbMissingOrderStateLang.attachEvent("onClick",
				function(id){
					if (id=='selectall')
					{
						gridMissingOrderStateLang.selectAll();
					}
					if (id=='delete')
					{
						deleteMissingOrderStateLang();
					}
					if (id=='add')
					{
						addMissingOrderStateLang()
					}
				});
		
			var gridMissingOrderStateLang = dhxlSCExtCheck.tabbar.cells("table_CMD_STA_MISSING_ORDER_STATE_LANG").attachGrid();
			gridMissingOrderStateLang.setImagePath("lib/js/imgs/");
			gridMissingOrderStateLang.enableSmartRendering(true);
			gridMissingOrderStateLang.enableMultiselect(true);
	
			gridMissingOrderStateLang.setHeader("ID,<?php echo _l('Used?')?>");
			gridMissingOrderStateLang.setInitWidths("100,50");
			gridMissingOrderStateLang.setColAlign("left,left");
			gridMissingOrderStateLang.init();
	
			var xml = '<rows>';
			<?php foreach ($res as $order_state) {
				$sql = "SELECT * FROM `"._DB_PREFIX_."order_history` WHERE id_order_state = '".(int)$order_state["id_order_state"]."' LIMIT 1500";
				$is_used=Db::getInstance()->ExecuteS($sql);
			?>
			xml = xml+'   <row id="<?php echo $order_state["id_order_state"] ?>">';
			xml = xml+'  	<cell><![CDATA[<?php echo $order_state["id_order_state"] ?>]]></cell>';
			xml = xml+'  	<cell><![CDATA[<?php if(!empty($is_used) && count($is_used)>0) echo _l('Yes'); else echo _l('No'); ?>]]></cell>';
			xml = xml+'   </row>';
			<?php } ?>
			xml = xml+'</rows>';
			gridMissingOrderStateLang.parse(xml);

			dhxlSCExtCheck.tabbar.cells("table_CMD_STA_MISSING_ORDER_STATE_LANG").attachStatusBar({text: '<?php echo _l('Count rows:')." ".count($res) ; ?>', height: 25 });

			function deleteMissingOrderStateLang()
			{
				var selectedMissingOrderStateLangs = gridMissingOrderStateLang.getSelectedRowId();
				if(selectedMissingOrderStateLangs==null || selectedMissingOrderStateLangs=="")
					selectedMissingOrderStateLangs = 0;
				if(selectedMissingOrderStateLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CMD_STA_MISSING_ORDER_STATE_LANG&id_lang="+SC_ID_LANG, { "action": "delete_order_states", "ids": selectedMissingOrderStateLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CMD_STA_MISSING_ORDER_STATE_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CMD_STA_MISSING_ORDER_STATE_LANG');
						 doCheck(false);
					});
				}
			}

			function addMissingOrderStateLang()
			{
				var selectedMissingOrderStateLangs = gridMissingOrderStateLang.getSelectedRowId();
				if(selectedMissingOrderStateLangs==null || selectedMissingOrderStateLangs=="")
					selectedMissingOrderStateLangs = 0;
				if(selectedMissingOrderStateLangs!="0")
				{
					$.post("index.php?ajax=1&act=all_win-fixmyprestashop_actions&check=CMD_STA_MISSING_ORDER_STATE_LANG&id_lang="+SC_ID_LANG, { "action": "add_order_states", "ids": selectedMissingOrderStateLangs}, function(data){
						dhxlSCExtCheck.tabbar.tabs("table_CMD_STA_MISSING_ORDER_STATE_LANG").close();

						 dhxlSCExtCheck.gridChecks.selectRowById('CMD_STA_MISSING_ORDER_STATE_LANG');
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
			"title"=>_l('Ord. stat. lang'),
			"contentJs"=>$content_js
	));
}
elseif(!empty($post_action) && $post_action=="delete_order_states")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$order_state = new OrderState((int)$id);
			$order_state->delete();
			if(version_compare(_PS_VERSION_, '1.5.0.0', '>='))
			{
				$sql = "DELETE FROM "._DB_PREFIX_."order_state WHERE id_order_state = ".(int)$id."";
				dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
elseif(!empty($post_action) && $post_action=="add_order_states")
{
	$post_ids = Tools::getValue("ids");
	if(!empty($post_ids))
	{
		//$languages = Language::getLanguages(false);
		$ids = explode(",",$post_ids);
		foreach($ids as $id)
		{
			$sql = "SELECT  l.*
					FROM "._DB_PREFIX_."lang l
					WHERE l.id_lang not in (SELECT pl.id_lang FROM "._DB_PREFIX_."order_state_lang pl WHERE pl.id_order_state='".(int)$id."')";
			$languages=Db::getInstance()->ExecuteS($sql);
			
			foreach($languages as $language)
			{
				$sql = "INSERT INTO "._DB_PREFIX_."order_state_lang (id_order_state, id_lang, name)
						VALUES (".(int)$id.",".(int)$language["id_lang"].",'Order State')";
				$res=dbExecuteForeignKeyOff($sql);
			}
		}
	}
}
