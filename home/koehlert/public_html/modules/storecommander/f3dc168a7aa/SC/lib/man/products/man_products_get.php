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
    $id_shop=(int)Tools::getValue('id_shop');
    $without_man=(int)Tools::getValue('products_without_man', 0);
    $manufacturer_ids=Tools::getValue('id_manufacturer');
	$manufacturer_ids = explode(',',$manufacturer_ids);
	$products_by_man = array();

	if($without_man) {
	    $sql = 'SELECT p.id_product,p.id_category_default,p.reference,pl.name, "0" as id_manufacturer
                    FROM '._DB_PREFIX_.'product p '.
                    (SCMS ? 'RIGHT JOIN '._DB_PREFIX_.'product_shop ps ON (ps.id_shop='.(int)$id_shop.' AND ps.id_product = p.id_product)' : '')
                    .'LEFT JOIN '._DB_PREFIX_.'product_lang pl
                    ON (pl.id_product = p.id_product '.(SCMS ? 'AND pl.id_shop = '.(int)$id_shop : '').' AND pl.id_lang='.(int)$id_lang.')
                    WHERE p.id_manufacturer = 0';
	    $product_list = Db::getInstance()->executeS($sql);
        if(!empty($product_list)){
            $products_by_man[0] = $product_list;
        }
    } else {
        foreach($manufacturer_ids as $id_manufacturer)
        {
            $sql = 'SELECT p.id_product,p.id_category_default,p.id_manufacturer,p.reference,pl.name,m.name as manufacturer_name
                        FROM '._DB_PREFIX_.'product p '.
                    (SCMS ? 'RIGHT JOIN '._DB_PREFIX_.'product_shop ps ON (ps.id_shop='.(int)$id_shop.' AND ps.id_product = p.id_product)' : '')
                    .'LEFT JOIN '._DB_PREFIX_.'product_lang pl
                        ON (pl.id_product = p.id_product '.(SCMS ? 'AND pl.id_shop = '.(int)$id_shop : '').' AND pl.id_lang='.(int)$id_lang.')
                        LEFT JOIN '._DB_PREFIX_.'manufacturer m ON m.id_manufacturer = '.(int)$id_manufacturer.'
                        WHERE p.id_manufacturer = '.(int)$id_manufacturer;
            $product_list = Db::getInstance()->executeS($sql);

            if(!empty($product_list)){
                $products_by_man[$id_manufacturer] = $product_list;
            }
        }
    }

    function manufacturerOptions()
    {
        global $id_shop;
        $arrManufacturers=array();
        $where = "";
        if (SCMS) {
            $where = ' INNER JOIN ' . _DB_PREFIX_ . 'manufacturer_shop ms ON ms.id_manufacturer = m.id_manufacturer WHERE ms.id_shop = ' . (int)$id_shop;
        }

        $sql = "SELECT m.id_manufacturer,m.name FROM "._DB_PREFIX_."manufacturer m ".$where." ORDER BY m.name";
        $res=Db::getInstance()->ExecuteS($sql);
        foreach($res as $row){
            if ($row['name']=='') $row['name']=' ';
            $arrManufacturers[$row['id_manufacturer']]=$row['name'];
        }
        $arrManufacturers[0]='-';
        return $arrManufacturers;
    }

	function generateValue()
	{
		global $products_by_man;

		$xml='';
		foreach($products_by_man as $id_manufacturer => $product_list) {
		    foreach($product_list as $product) {
                $xml .= '<row id="'.$product['id_product'].'">';
                $xml .= '    <userdata name="id_product">'.(int)$product['id_product'].'</userdata>';
                $xml.=  '    <userdata name="open_cat_grid">'.$product['id_category_default'].'-'.$product['id_product'].'</userdata>';
                $cols = ['id_product','reference','id_manufacturer','product_name'];
                foreach($cols as $col) {
                    switch($col){
                        case 'id_product':
                            $xml .= "<cell>".$product['id_product']."</cell>";
                            break;
                        case 'id_manufacturer':
                            $xml .= "<cell>".(int)$product['id_manufacturer']."</cell>";
                            break;
                        case 'reference':
                            $xml .= "<cell><![CDATA[".$product['reference']."]]></cell>";
                            break;
                        case 'product_name':
                            $xml .= "<cell><![CDATA[".$product['name']."]]></cell>";
                            break;
                    }
                }
                $xml .= '</row>';
		    }
		}
		return $xml;
	}



//XML HEADER
if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	header("Content-type: application/xhtml+xml"); } else {
	header("Content-type: text/xml");
}
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
?>
<rows id="0">
	<head>
		<beforeInit>
			<call command="attachHeader"><param><![CDATA[#numeric_filter,#text_filter,#select_filter,#text_filter]]></param></call>
		</beforeInit>
		<column id="id_product" width="80" type="ro" align="left" sort="str"><?php echo _l('ID Product')?></column>
		<column id="reference" width="100" type="ro" align="left" sort="str"><?php echo _l('Reference')?></column>
        <column id="id_manufacturer" width="100" type="coro" align="left" sort="int"><?php echo _l('Manufacturer')?>
            <?php
            $options = manufacturerOptions();
            foreach($options as $id_man => $name) {
            ?>
            <option value="<?php echo $id_man;?>"><![CDATA[<?php echo $name;?>]]></option>
            <?php } ?>
        </column>
		<column id="product_name" width="200" type="ro" align="left" sort="str" color=""><?php echo _l('Product name')?></column>
		<afterInit>
			<call command="enableMultiselect"><param>1</param></call>
		</afterInit>
	</head>
	<?php
	echo '<userdata name="uisettings">'.uisettings::getSetting('man_products').'</userdata>'."\n";
	echo generateValue();
	?>
</rows>

