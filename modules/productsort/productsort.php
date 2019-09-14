<?php
/*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 8783 $
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class ProductSort extends Module
{
	function __construct()
	{
		$this->name = 'productsort';
		$this->tab = 'front_office_features';
		$this->version = 1.0;
		$this->author = 'Wheelronix';
		$this->need_instance = 0;

		parent::__construct();

		$this->displayName = $this->l('Custom sort for products');
		$this->description = $this->l('Custom sort algorithm for products');
	}
	
	public function install()
	{
        $result = Db::getInstance()->ExecuteS('SHOW COLUMNS FROM '._DB_PREFIX_.'product LIKE \'custom_sort\'');
        if(!$result || count($result)==0)
        {
            Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'product` ADD `custom_sort` INT NOT NULL , ADD INDEX (`custom_sort`)');
        }
        $this->sortProducts();
		return parent::install();
    }


    public function uninstall()
    {
        Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'product` DROP `custom_sort`');
        return parent::uninstall();
    }


    public function sortProducts()
    {
	$newProductDays = intval(Configuration::get('PS_NB_DAYS_NEW_PRODUCT'));
	if ($newProductDays<=0)
	{
	    $newProductDays = 30;
	}
	
        $newProductThreshold = date('Y-m-d H:i:s', time()-$newProductDays*24*3600);
        // reading all new products
        $newProducts = Db::getInstance()->ExecuteS('select id_product from '._DB_PREFIX_.'product where date_add>=\''.$newProductThreshold.'\' order by date_add desc');

        // reading all products that were sold except new  -product_quantity_refunded-product_quantity_return
        $soldProducts = Db::getInstance()->ExecuteS('select p.id_product, sum(product_quantity) as sold_qty from '._DB_PREFIX_.
                                                   'product p, '._DB_PREFIX_.'order_detail od, '._DB_PREFIX_.'orders o where p.id_product=od.product_id and '.
                                                   'od.id_order=o.id_order and p.date_add<\''.$newProductThreshold.'\' group by p.id_product'.
                                                   ' having sold_qty>0 order by sold_qty desc');
        //       var_dump($soldProducts);
        if (!is_array($soldProducts))
        {
            $soldProducts = array();
        }

        // reading all products that were not sold
        $sql = 'select p.id_product, sum(counter) as clicks_num, sum(ifnull(product_quantity, 0)) as sold_qty from '._DB_PREFIX_.
                                                       'product p left join ('._DB_PREFIX_.'order_detail od inner join '._DB_PREFIX_.'orders o on '.
                                                       'od.id_order=o.id_order) on od.product_id=p.id_product left join '._DB_PREFIX_.
                                                       'page pg on p.id_product=pg.id_object and id_page_type=1 left join '._DB_PREFIX_.'page_viewed pv on pv.id_page=pg.id_page'.
                                                       ' where p.date_add<\''.$newProductThreshold.'\' group by p.id_product having sold_qty=0 order by clicks_num desc';
        
        $notSoldProducts = Db::getInstance()->ExecuteS($sql);
        // var_dump($notSoldProducts);
       
        // record order of sold and new products
        $productOrder = 1;
        if ($newProducts && is_array($newProducts))
        {
            foreach($newProducts as $newProduct)
            {
                $soldProduct = array_shift($soldProducts);
                if ($soldProduct)
                {
                    $this->setProductOrder($soldProduct['id_product'], $productOrder++);
                }
                $this->setProductOrder($newProduct['id_product'], $productOrder++);
            }
        }

        if (count($soldProducts))
        {
            foreach($soldProducts as $soldProduct)
            {
                $this->setProductOrder($soldProduct['id_product'], $productOrder++);
            }
        }

        // record not sold products order
        if ($notSoldProducts && count($notSoldProducts))
        {
            foreach($notSoldProducts as $notSoldProduct)
            {
                $this->setProductOrder($notSoldProduct['id_product'], $productOrder++);
            }
        }
    }

    
    protected function setProductOrder($productId, $sortOrder)
    {
        Db::getInstance()->Execute('update '._DB_PREFIX_.'product set custom_sort='.$sortOrder.' where id_product='.$productId);
    }
}
