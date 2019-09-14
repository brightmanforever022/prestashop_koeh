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

error_reporting(E_ALL);
ini_set("display_errors", 1);

$action = Tools::getValue('action','');

## Update from cat_feedbiz_grid
if(!empty($_POST["rows"]) || $action=="insert")
{
    $return = "ERROR: Try again later";

    if($action!="insert")
    {
        if(_PS_MAGIC_QUOTES_GPC_)
            $_POST["rows"] = stripslashes($_POST["rows"]);
        $rows = json_decode($_POST["rows"]);
    }
    else
    {
        $rows = array();
        $rows[0] = new stdClass();
        $rows[0]->name = Tools::getValue('act','');
        $rows[0]->action = Tools::getValue('action','');
        $rows[0]->row = Tools::getValue('gr_id','');
        $rows[0]->callback = Tools::getValue('callback','');
        $rows[0]->params = $_POST;
    }

    if(is_array($rows) && count($rows)>0)
    {
        $callbacks = '';

        // Première boucle pour remplir la table sc_queue_log
        // avec toutes ces modifications
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

                    $id_product =$row->row;
                    $fields = explode(',','force,disable,price,shipping_delay,clogistique,valueadded,text');
                    $insert_field = array();
                    $insert_value = array();
                    $update_combo = array();
                    $id_lang = (int)Language::getIdByIso('fr');
                    $insert_field[] = '`id_lang`';
                    $insert_value[] = $id_lang;
                    foreach($fields as $field) {
                        if(isset($_POST[$field])) {
                            $insert_field[] = '`'.pSQL($field).'`';
                            $insert_value[] = '"'.pSQL($_POST[$field]).'"';
                            $update_combo[] = '`'.pSQL($field).'` = '.(empty($_POST[$field]) ? 'NULL' : '"'.pSQL($_POST[$field]).'"');
                        }
                    }
                    $find = Db::getInstance()->getValue("SELECT COUNT(*) FROM "._DB_PREFIX_."cdiscount_product_option WHERE id_product=".(int)$id_product);
                    if(!empty($find) && !empty($update_combo)){
                        $sql = "UPDATE "._DB_PREFIX_."cdiscount_product_option SET ".implode(', ',$update_combo)." WHERE id_product=".(int)$id_product;
                        Db::getInstance()->Execute($sql);
                    } else if (!empty($insert_field) && !empty($insert_value)){
                        $sql = "INSERT INTO "._DB_PREFIX_."cdiscount_product_option (`id_product`, ".implode(',', $insert_field).") 
                        VALUES (".(int)$id_product.", ".implode(', ', $insert_value).")";
                        Db::getInstance()->Execute($sql);
                    }
                }


                QueueLog::delete(($log_ids[$num]));
            }
        }

        // RETURN
        $return = json_encode(array("callback"=>$callbacks));
    }
    die($return);
}