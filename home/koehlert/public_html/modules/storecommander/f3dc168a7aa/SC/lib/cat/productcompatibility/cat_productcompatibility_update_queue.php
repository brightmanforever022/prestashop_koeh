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
## Update from cat_product_compatibility_grid
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
                    $id_compat = $_POST['id_compat'];
                    $filter_col = $_POST['id_filter'];
                    $id_filter = str_replace('filter_','',$filter_col);
                    $criterion = $_POST['criterion'];
                    $id_lang = Tools::getValue('id_lang');

                    $sql = "SELECT ct.*
                        FROM "._DB_PREFIX_."ukoocompat_criterion_lang ctl
                        LEFT JOIN "._DB_PREFIX_."ukoocompat_criterion ct ON ct.id_ukoocompat_criterion = ctl.id_ukoocompat_criterion
                        WHERE ctl.value = '".pSQL($criterion)."' 
                        AND ctl.id_lang = ".(int)$id_lang." 
                        AND ct.id_ukoocompat_filter = ".(int)$id_filter;
                    if($id_criterion = Db::getInstance()->getValue($sql)) {
                        $sql = "SELECT value
                                FROM "._DB_PREFIX_."ukoocompat_criterion_lang
                                WHERE id_ukoocompat_criterion = ".(int)$id_criterion." 
                                AND id_lang = ".(int)$id_lang;


                        if($name = Db::getInstance()->getValue($sql)) {
                            $callbacks = str_replace('{criterionName}',$name,$callbacks);
                        }

                        if(!empty($id_compat) && !empty($id_filter) && !empty($id_criterion)) {
                            $sql = 'UPDATE '._DB_PREFIX_.'ukoocompat_compat_criterion 
                                    SET id_ukoocompat_criterion = '.(int)$id_criterion.' 
                                    WHERE id_ukoocompat_compat = '.(int)$id_compat.' 
                                    AND id_ukoocompat_filter = '.(int)$id_filter;
                            if(!DB::getInstance()->execute($sql)) {
                                die(json_encode(array('message' => _l('Error updating data'))));
                            }
                        }
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

## Copy/Past from cat_product_grid
if (isset($_POST['compatibilities']) && substr($_POST['compatibilities'],0,16)=='compatibilities_') {
    $prefixlen=strlen('compatibilities_');
    $id_productsource=substr($_POST['compatibilities'],$prefixlen,strlen($_POST['compatibilities']));

    if ($id_productsource!=$id_product)
    {
        $sql = 'SELECT ucc.*
                    FROM '._DB_PREFIX_.'ukoocompat_compat uc
                    RIGHT JOIN '._DB_PREFIX_.'ukoocompat_compat_criterion ucc
                    ON (ucc.id_ukoocompat_compat = uc.id_ukoocompat_compat)
                    WHERE uc.id_product = '.(int)$id_productsource;
        $res = Db::getInstance()->ExecuteS($sql);
        if(!empty($res)) {
            $compat_array_to_DB = array();
            foreach($res as $data) {
                $compat_array_to_DB[$data['id_ukoocompat_compat']][] = $data;
            }
            foreach($compat_array_to_DB as $compat) {
                if(Db::getInstance()->insert('ukoocompat_compat', array('id_product' => (int)$id_product))) {
                    $id_compat = (int)Db::getInstance()->Insert_ID();
                    $sql = '';
                    foreach($compat as $in_data){
                        $sql .= 'INSERT INTO '._DB_PREFIX_.'ukoocompat_compat_criterion (id_ukoocompat_compat, id_ukoocompat_filter, id_ukoocompat_criterion)
                        VALUES ('.(int)$id_compat.', '.(int)$in_data['id_ukoocompat_filter'].', '.(int)$in_data['id_ukoocompat_criterion'].');';
                    }
                    Db::getInstance()->execute($sql);
                }
            }
        }
    }
}