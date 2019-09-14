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

	$id_objet=intval(Tools::getValue('gr_id',0));
	$type_objet=Tools::getValue('type',"customer");

	if(isset($_POST["!nativeeditor_status"]) && trim($_POST["!nativeeditor_status"])=="updated"){
        $id_customer = (!empty($_POST["id_customer"])?$_POST["id_customer"]:$id_objet);
        $id_address = (!empty($_POST["id_address"])?$_POST["id_address"]:"");

		$fields=array('id_gender','company','siret','ape','firstname','lastname','email','active','newsletter','optin','birthday','id_default_group','note','id_lang');
        if(version_compare(_PS_VERSION_, '1.5.0.0', '>=')){
            $fields[] = 'website';
        }
		$fields_address=array('firstname','lastname','address1','address2','postcode','city','id_state','id_country','phone','phone_mobile','vat_number');
		sc_ext::readCustomCustomersGridsConfigXML('updateSettings');
		sc_ext::readCustomCustomersGridsConfigXML('onBeforeUpdateSQL');
        $todo=array();
        $todo_address=array();

        foreach($fields AS $field)
        {
            if (isset($_POST[$field]))
            {
                $todo[]=$field."='".psql($_POST[$field])."'";
                addToHistory("customer",'modification',$field,intval($id_customer),0,_DB_PREFIX_."customer",psql(Tools::getValue($field)));
            }
        }
        foreach($fields_address AS $field)
        {
            if (isset($_POST[$field]))
            {
                $todo_address[]=$field."='".psql($_POST[$field])."'";
                addToHistory("address",'modification',$field,intval($id_address),0,_DB_PREFIX_."address",psql(Tools::getValue($field)));
            }
        }

        if (count($todo))
        {
            $sql = "UPDATE "._DB_PREFIX_."customer SET ".join(' , ',$todo)." WHERE id_customer=".intval($id_customer);
            Db::getInstance()->Execute($sql);
        }
        if (count($todo_address))
        {
            $sql = "UPDATE "._DB_PREFIX_."address SET ".join(' , ',$todo_address)." WHERE id_address=".intval($id_address);
            Db::getInstance()->Execute($sql);
        }
		
		sc_ext::readCustomCustomersGridsConfigXML('onAfterUpdateSQL');
		$newId = $_POST["gr_id"];
		$action = "update";
	}

	sc_ext::readCustomCustomersGridsConfigXML('extraVars');
	
	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	 		header("Content-type: application/xhtml+xml"); } else {
	 		header("Content-type: text/xml");
	}
	echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n"); 
	echo '<data>';
	echo "<action type='".$action."' sid='".$_POST["gr_id"]."' tid='".$newId."'/>";
	echo '</data>';
