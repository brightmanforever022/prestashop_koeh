<?php

// Wheelronix Ltd. development team
// site: http://www.wheelronix.com
// mail: info@wheelronix.com


class TopSellerSortTools
{

    const cookieName = 'AjaxFilterCustSortCache';
    const cacheTTL = 900;  //!< time to live for cache in seconds 

    /**
     * Calculates hash of query, used to check if query is already in cache
     * @param unknown $categoryId
     * @param unknown $id_lang
     * @param unknown $selectedFilters
     * @return string
     */
    static function getHash($categoryId, $id_lang, $selectedFilters)
    {
        return $categoryId . '_' . $id_lang . '_' . md5(serialize($selectedFilters));
    }

    /**
     * Checks if query is already in cache
     * @param unknown $categoryId
     * @param unknown $context
     * @param unknown $selectedFilters
     * @returns true if query is in cache, false otherwise
     */
    static function checkCache($categoryId, $context, $selectedFilters)
    {
        //return false;
        if (isset($context->cookie->{self::cookieName}) )
        {
            $cookieValue = unserialize($context->cookie->{self::cookieName});
            if ($cookieValue['hash'] == self::getHash($categoryId, $context->cookie->id_lang,
                $selectedFilters) && $cookieValue['time'] + self::cacheTTL >= time())
            {
                return true;
            }
        }
        return false;
    }

    /**
     * Excecutes, query, reading minimal required data, sorts results (all products without pagination),
     * put sorted query results in cache 
     * @param unknown $sql category products select query, without select part, so we can read only minimal required data
     * @param unknown $category
     * @param unknown $context
     * @param unknown $selectedFilters necessary to put query in cache
     */
    static function putQueryInCache($sql, &$category, $context, $selectedFilters, $numOfProductsPerPage)
    {
        $resultProducts = array();
        
        // add common things in query
        $sql = str_ireplace('where', ' LEFT JOIN `'._DB_PREFIX_.'category_product` main_cat ON p.`id_product` = main_cat.`id_product` and '.
                'main_cat.id_category='.$category->id.' where', $sql);
        $sql .= ' fromMainCategory desc ';
        // check if we need to skip some pages
        if ($category->top_seller_sort_config > 0)
        {
            // we need to skip pages, read products by position order 
            $sql2 = 'select p.id_product, (main_cat.id_product>0) as fromMainCategory ' . $sql.
            ', cp.position limit ' . $numOfProductsPerPage * $category->top_seller_sort_config;
            
            $resultProducts = Db::getInstance()->ExecuteS($sql2);

            // prepare skipProductIds 
            $skipProductIds = array();
            foreach ($resultProducts as $product)
            {
                $skipProductIds [] = $product['id_product'];
            }
        }
        
        $sql .= ', p.custom_sort';

        // read all products (that were not skipped)
        // remove not necessary fields, add base id
        $sql = 'select p.id_product, spv.base_id, (main_cat.id_product>0) as fromMainCategory, DATEDIFF(p.`date_add`, 
				DATE_SUB(NOW(), INTERVAL ' .
                (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) .
                ' DAY)) > 0 AS new ' . $sql;

        $pos = strrpos($sql, 'where');
        $sql = substr_replace($sql, 'left join ' . _DB_PREFIX_ . 'spv_variant spv on spv.product_id=p.id_product where ' .
                ($category->top_seller_sort_config > 0 ? 'p.id_product not in (' . implode(',', $skipProductIds) . ') and ' : ''), $pos, 5);
        
        $products = Db::getInstance()->ExecuteS($sql);

        // apply separation algorithm
        $requiredDistance = Configuration::get('SORT_SEPARATION_DISTANCE');

        // add base id in product and divide them on new and usual
        $newProducts = array();
        $usualProducts = array();
        foreach ($products as $index => $product)
        {
            if ($product ['new'])
            {
                $newProducts [] = array('id_product' => $product['id_product'], 'base_id' => $product['base_id']);
            }
            else
            {
                $usualProducts [] = array('id_product' => $product['id_product'], 'base_id' => $product['base_id']);
            }
        }

        // separate products
        for ($i = count($products); $i > 0; $i --)
        {
            // determine work set of products
            if ($i % 2 == 0)
            {
                if (count($usualProducts))
                {
                    $workSet = &$usualProducts;
                }
                else
                {
                    $workSet = &$newProducts;
                }
            }
            else
            {
                if (count($newProducts))
                {
                    $workSet = &$newProducts;
                }
                else
                {
                    $workSet = &$usualProducts;
                }
            }

            // insert product with biggest distance or -1, that means no same product in list yet
            $biggestDistance = - 1;
            foreach ($workSet as $index => $product)
            {
                $distance = Tools::sepCheckPreviousBases($resultProducts, $product ['base_id'], $requiredDistance);
                if ($distance == - 1)
                {
                    $selectedIndex = $index;
                    break;
                }
                elseif ($distance > $biggestDistance)
                {
                    $selectedIndex = $index;
                }
            }
            $resultProducts [] = $workSet [$selectedIndex];
            unset($workSet [$selectedIndex]);
        }
        $context->cookie->{self::cookieName} = serialize(array('result' => $resultProducts, 'time' => time(),
            'hash' => self::getHash($category->id, $context->cookie->id_lang, $selectedFilters)));
    }

    /**
     * 
     * @global type $cookie
     * @param type $context
     * @param type $p
     * @param type $n
     * @return array with product record or false, if there is no products
     */
    static function getProducts($context, $p, $n)
    {
        $cookieValue = unserialize($context->cookie->{self::cookieName});
        //unset($context->cookie->{self::cookieName});
        $result = array_slice($cookieValue['result'], ($p - 1) * $n, $n);
        if (count($result) == 0)
        {
            return false;
        }
        /*
          $notPresent = true;
          foreach($cookie->{self::cookieName}['result'] as $product)
          {
          if ($product['id_product']=='1656')
          {
          $notPresent = false;
          }
          }
          if ($notPresent) echo 'not present';
          else echo 'present';
         */
        // repack products
        $products = array();
        foreach ($result as $product)
        {
            $products[$product['id_product']] = $product;
        }

        $nb_day_new_product = (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20);
        // reading all necessary fields
        $sql = 'SELECT	p.*, product_shop.*, product_shop.id_category_default,	pl.*,
					image_shop.`id_image` id_image,
					il.legend,
					m.name manufacturer_name, '.
		(Combination::isFeatureActive() ? 'product_attribute_shop.id_product_attribute id_product_attribute,' : '') . '
		DATEDIFF(product_shop.`date_add`, DATE_SUB("' . date('Y-m-d') . ' 00:00:00", INTERVAL ' . (int) $nb_day_new_product.
                ' DAY)) > 0 AS new, stock.out_of_stock, IFNULL(stock.quantity, 0) as quantity' . 
                (Combination::isFeatureActive() ? ', product_attribute_shop.minimal_quantity AS product_attribute_minimal_quantity' : '').
                ' FROM ' . _DB_PREFIX_ . 'cat_filter_restriction cp
				LEFT JOIN `' . _DB_PREFIX_ . 'product` p ON p.`id_product` = cp.`id_product`
				' . Shop::addSqlAssociation('product', 'p') .
                (Combination::isFeatureActive() ?
                ' LEFT JOIN `' . _DB_PREFIX_ . 'product_attribute_shop` product_attribute_shop
		ON (p.`id_product` = product_attribute_shop.`id_product` AND product_attribute_shop.`default_on` = 1 AND '.
                'product_attribute_shop.id_shop=' . (int) $context->shop->id . ')' : '') . '
		LEFT JOIN ' . _DB_PREFIX_ . 'product_lang pl ON (pl.id_product = p.id_product' . Shop::addSqlRestrictionOnLang('pl') . 
                ' AND pl.id_lang = ' . (int) $context->cookie->id_lang . ')
		LEFT JOIN `' . _DB_PREFIX_ . 'image_shop` image_shop
		ON (image_shop.`id_product` = p.`id_product` AND image_shop.cover=1 AND image_shop.id_shop=' . (int) $context->shop->id . ')
		LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (image_shop.`id_image` = il.`id_image` AND il.`id_lang` = '.$context->cookie->id_lang . ')
		LEFT JOIN ' . _DB_PREFIX_ . 'manufacturer m ON (m.id_manufacturer = p.id_manufacturer) ' . Product::sqlStock('p', 0) . 
                ' where p.id_product in (' . implode(',', array_keys($products)) . ') group by p.id_product';

        /*
        $sql = 'SELECT p.*, pa.`id_product_attribute`, pl.`available_now`, pl.`available_later`, pl.`link_rewrite`, pl.`name`, ' .
                'i.`id_image`, il.`legend`, DATEDIFF(p.`date_add`, 
				DATE_SUB(NOW(), INTERVAL ' .
                (Validate::isUnsignedInt(Configuration::get('PS_NB_DAYS_NEW_PRODUCT')) ? Configuration::get('PS_NB_DAYS_NEW_PRODUCT') : 20) .
                ' DAY)) > 0 AS new, ' .
                '(p.`price` * IF(t.`rate`,((100 + (t.`rate`))/100),1)) AS orderprice from ' . _DB_PREFIX_ . 'product p ' .
                'left join ' . _DB_PREFIX_ . 'product_attribute pa on p.id_product=pa.id_product left join ' . _DB_PREFIX_ . 'product_lang pl on ' .
                'pl.id_product=p.id_product and pl.id_lang=' . $id_lang .
                ' LEFT JOIN `' . _DB_PREFIX_ . 'tax_rule` tr ON (p.`id_tax_rules_group` = tr.`id_tax_rules_group` AND tr.`id_country` = ' .
                (int) Country::getDefaultCountryId() . ' AND tr.`id_state` = 0)
		 LEFT JOIN `' . _DB_PREFIX_ . 'tax` t ON (t.`id_tax` = tr.`id_tax`) ' .
                'LEFT JOIN `' . _DB_PREFIX_ . 'image` i ON (i.`id_product` = p.`id_product` AND i.`cover` = 1)
		 LEFT JOIN `' . _DB_PREFIX_ . 'image_lang` il ON (i.`id_image` = il.`id_image` AND il.`id_lang` = ' . intval($id_lang) . ') ' .
                 
                'where p.id_product in (' . implode(',', array_keys($products)) . ') group by p.id_product';*/
        $productDetails = Db::getInstance()->ExecuteS($sql);

        foreach ($productDetails as $product)
        {
            $products[$product['id_product']] = array_merge($products[$product['id_product']], $product);
        }

        /* Modify SQL result */
        return $products;
    }

}
