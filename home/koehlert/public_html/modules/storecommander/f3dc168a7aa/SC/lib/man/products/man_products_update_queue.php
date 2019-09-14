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

$action = Tools::getValue('action','');
$return = "ERROR: Try again later";


// Récupération de toutes les modifications à effectuer
if(!empty($_POST["rows"]))
{
    if(_PS_MAGIC_QUOTES_GPC_) {
        $_POST["rows"] = stripslashes($_POST["rows"]);
    }
    $rows = json_decode($_POST["rows"]);

	if(is_array($rows) && count($rows)>0)
	{
		$callbacks = '';
		$log_ids = array();
		$date = date("Y-m-d H:i:s");
		foreach($rows as $num => $row)
		{
			$id = QueueLog::add($row->name, $row->row, $row->action, (!empty($row->params)?$row->params:array()), (!empty($row->callback)?$row->callback:null), $date);
			$log_ids[$num] = $id;
		}

		foreach($rows as $num => $row)
		{
			if(!empty($log_ids[$num]))
			{
				$gr_id = intval($row->row);
				$action = $row->action;

				if(!empty($row->callback))
					$callbacks .= $row->callback.";";

				if($action!="insert")
				{
					$_POST=array();
					$_POST = (array) json_decode($row->params);
				}

				if(!empty($action) && $action=="update")
				{
					$id_product=$gr_id;
					$id_manufacturer=(int)$_POST['id_manufacturer'];

					$sql = "UPDATE "._DB_PREFIX_."product SET id_manufacturer = ".(int)$id_manufacturer.", date_upd = '".pSQL(date("Y-m-d H:i:s"))."' WHERE id_product = ".(int)$id_product.";";
					if(SCMS) {
						$sql .= "UPDATE "._DB_PREFIX_."product_shop SET date_upd = '".pSQL(date("Y-m-d H:i:s"))."' WHERE id_product = ".(int)$id_product." AND id_shop IN (".pSQL(SCI::getSelectedShopActionList(true)).")";
					}
					Db::getInstance()->Execute($sql);
				}

				QueueLog::delete(($log_ids[$num]));
			}
		}

		// RETURN
		$return = json_encode(array("callback"=>$callbacks));
	}
}
echo $return;