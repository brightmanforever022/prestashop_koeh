<?php
$id_lang=intval(Tools::getValue('id_lang'));
$action = Tools::getValue('action',"");

/*
 * ACTION
*/
if(!empty($action) && $action=="delete")
{
    $ids=(Tools::getValue('ids',0));

    if(!empty($ids))
    {
        $sql = "DELETE FROM "._DB_PREFIX_."sc_segment_element
				WHERE id_segment_element IN (".pSQL($ids).")";
        Db::getInstance()->Execute($sql);
    }
}
if(!empty($action) && $action=="empty")
{
    $ids=(Tools::getValue('ids',0));

    if(!empty($ids))
    {
        $sql = "DELETE FROM "._DB_PREFIX_."sc_segment_element
				WHERE id_segment IN (".pSQL($ids).")";
        Db::getInstance()->Execute($sql);
    }
}