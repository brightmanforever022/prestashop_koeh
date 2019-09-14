<?php

class Tools extends ToolsCore
{
    // List of sort order options
    static $ProductSortOrderList = array(0 => 'name', 1 => 'price', 2 => 'date_add', 3 => 'date_upd', 4 => 'position', 5 => 'manufacturer_name', 
                    6 => 'quantity', 7 => 'reference', 8=>'top_seller');
    
    /**
    * Return price with currency sign for a given product
    *
    * @param float $price Product price
    * @param object|array $currency Current currency (object, id_currency, NULL => context currency)
    * @return string Price correctly formated (sign, decimal separator...)
    */
    public static function displayPrice($price, $currency = null, $no_utf8 = false, Context $context = null)
    {
        if (!is_numeric($price)) {
            return $price;
        }
        if (!$context) {
            $context = Context::getContext();
        }
        if ($currency === null) {
            $currency = $context->currency;
        }
        // if you modified this function, don't forget to modify the Javascript function formatCurrency (in tools.js)
        elseif (is_int($currency)) {
            $currency = Currency::getCurrencyInstance((int)$currency);
        }

        if (is_array($currency)) {
            $c_char = $currency['sign'];
            $c_format = $currency['format'];
            $c_decimals = (int)$currency['decimals'] * _PS_PRICE_DISPLAY_PRECISION_;
            $c_blank = $currency['blank'];
        } elseif (is_object($currency)) {
            $c_char = $currency->sign;
            $c_format = $currency->format;
            $c_decimals = (int)$currency->decimals * _PS_PRICE_DISPLAY_PRECISION_;
            $c_blank = $currency->blank;
        } else {
            return false;
        }

        $blank = ($c_blank ? ' ' : '');
        $ret = 0;
        if (($is_negative = ($price < 0))) {
            $price *= -1;
        }
        $price = Tools::ps_round($price, $c_decimals);

        /*
        * If the language is RTL and the selected currency format contains spaces as thousands separator
        * then the number will be printed in reverse since the space is interpreted as separating words.
        * To avoid this we replace the currency format containing a space with the one containing a comma (,) as thousand
        * separator when the language is RTL.
        *
        * TODO: This is not ideal, a currency format should probably be tied to a language, not to a currency.
        */
        if (($c_format == 2) && ($context->language->is_rtl == 1)) {
            $c_format = 4;
        }

        switch ($c_format) {
            /* X 0,000.00 */
            case 1:
                $ret = $c_char.$blank.number_format($price, $c_decimals, '.', ',');
                break;
            /* 0 000,00 X*/
            case 2:
                $ret = number_format($price, $c_decimals, ',', ' ').$blank.$c_char;
                break;
            /* X 0.000,00 */
            case 3:
                $ret = $c_char.$blank.number_format($price, $c_decimals, ',', '.');
                break;
            /* 0,000.00 X */
            case 4:
                $ret = number_format($price, $c_decimals, '.', ',').$blank.$c_char;
                break;
            /* X 0'000.00  Added for the switzerland currency */
            case 5:
                $ret = number_format($price, $c_decimals, '.', "'").$blank.$c_char;
                break;
            /* 0.000,00 X*/
            case 6:
                $ret = number_format($price, $c_decimals, ',', '.').$blank.$c_char;
                break;
        }
        if ($is_negative) {
            $ret = '-'.$ret;
        }
        if ($no_utf8) {
            return str_replace('€', chr(128), $ret);
        }
        return $ret;
    }
    
    
    /**
    * Display date regarding to language preferences
    *
    * @param string $date Date to display format UNIX
    * @param int $id_lang Language id DEPRECATED
    * @param bool $full With time or not (optional)
    * @param string $separator DEPRECATED
    * @return string Date
    */
    public static function displayDateLang($date, $id_lang, $full = false)
    {
        if (!$date || !($time = strtotime($date))) {
            return $date;
        }

        if ($date == '0000-00-00 00:00:00' || $date == '0000-00-00') {
            return '';
        }

        if (!Validate::isDate($date) || !Validate::isBool($full)) {
            throw new PrestaShopException('Invalid date');
        }

        $language = Language::getLanguage($id_lang);
        $date_format = ($full ? $language['date_format_full'] : $language['date_format_lite']);
        return date($date_format, $time);
    }
    
    
    /**
     * Get products order field name for queries.
     *
     * @param string $type by|way
     * @param string $value If no index given, use default order from admin -> pref -> products
     * @param bool|\bool(false)|string $prefix
     * @param int $categoryId id of category for that sort order should be returned
     *
     * @return string Order by sql clause
     */
    public static function getProductsOrder($type, $value = null, $prefix = false, $categoryId=0)
    {
        switch ($type) {
            case 'by' :
                $list = array(0 => 'name', 1 => 'price', 2 => 'date_add', 3 => 'date_upd', 4 => 'position', 5 => 'manufacturer_name', 
                    6 => 'quantity', 7 => 'reference', 8=>'top_seller', 9=>'best_seller');
                if (is_null($value) || $value === false || $value === '')
                {
                    $value = $list[(int)Configuration::get('PS_PRODUCTS_ORDER_BY')];
                    if ($categoryId)
                    {
                        // reading sort order saved in category
                        $category = new Category($categoryId);
                        if (!empty($category->def_product_sort))
                        {
                            $value = $category->def_product_sort;
                        }
                    }
                }
                else
                {
                    $value = (isset($list[$value])) ? $list[$value] : ((in_array($value, $list)) ? $value : 'position');
                }
                $order_by_prefix = '';
                if ($prefix) {
                    if ($value == 'id_product' || $value == 'date_add' || $value == 'date_upd' || $value == 'price') {
                        $order_by_prefix = 'p.';
                    } elseif ($value == 'name') {
                        $order_by_prefix = 'pl.';
                    } elseif ($value == 'manufacturer_name' && $prefix) {
                        $order_by_prefix = 'm.';
                        $value = 'name';
                    } elseif ($value == 'position' || empty($value)) {
                        $order_by_prefix = 'cp.';
                    }
                }

                return $order_by_prefix.$value;
            break;

            case 'way' :
                $value = (is_null($value) || $value === false || $value === '') ? (int)Configuration::get('PS_PRODUCTS_ORDER_WAY') : $value;
                $list = array(0 => 'asc', 1 => 'desc');
                return ((isset($list[$value])) ? $list[$value] : ((in_array($value, $list)) ? $value : 'asc'));
            break;
        }
    }
    
    
    /**
     * Helper function purposed to determine if distance between new adding product
     * and previous products in list is enough
     * 
     * @return -1 if distance is enough, otherwise -- distance 
     */
    static function sepCheckPreviousBases(&$result, $baseId, $distance)
    {
        $lastIndex = count($result) - 1;
        for ($i = $lastIndex; $i >= 0; $i --)
        {
            if ($lastIndex - $i >= $distance)
                break;

            if ($result [$i] ['base_id'] == $baseId)
            {
                return $lastIndex - $i;
            }
        }

        return -1;
    }

    
    /**
     * @return assoc array [serverUrl=>, fgcOptions=> -- options to pass in file_get_contents function during central server call]
     */
    function getCentralServerUrl()
    {
        // reading delivery requests info
        if ($_SERVER["HTTP_HOST"] == 'dmitri.wheel')
        {
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            $serverUrl = 'https://dmitri.wheel/vipdress.de1/';
        }
        elseif ($_SERVER["HTTP_HOST"] == 'nsweb.server')
        {
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            $serverUrl = 'http://nsweb.server/vipdress/';
        }
        else
        {
            $arrContextOptions = [];
            $serverUrl = 'https://www.vipdress.de/';
        }
        return ['serverUrl'=>$serverUrl, 'fgcOptions'=>$arrContextOptions];
    }
    
    /**
    * Change language in cookie while clicking on a flag
    *
    * @return string iso code
    */
//    public static function setCookieLanguage($cookie = null)
//    {
//        if (!$cookie) {
//            $cookie = Context::getContext()->cookie;
//        }
//        /* If language does not exist or is disabled, erase it */
//        if ($cookie->id_lang) {
//            $lang = new Language((int)$cookie->id_lang);
//            if (!Validate::isLoadedObject($lang) || !$lang->active || !$lang->isAssociatedToShop()) {
//                $cookie->id_lang = null;
//            }
//        }
//
//        if (!Configuration::get('PS_DETECT_LANG')) {
//            unset($cookie->detect_language);
//        }
//
//        /* Automatically detect language if not already defined, detect_language is set in Cookie::update */
//        if (!Tools::getValue('isolang') && !Tools::getValue('id_lang') && (!$cookie->id_lang || isset($cookie->detect_language))
//            && isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
//            $array  = explode(',', Tools::strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']));
//            $string = $array[0];
//
//            if (Validate::isLanguageCode($string)) {
//                $lang = Language::getLanguageByIETFCode($string);
//                if (Validate::isLoadedObject($lang) && $lang->active && $lang->isAssociatedToShop()) {
//                    Context::getContext()->language = $lang;
//                    $cookie->id_lang = (int)$lang->id;
//                }
//                else
//                {
//                    $lang = new Language(Language::getIdByIso('en'));
//                    Context::getContext()->language = $lang;
//                    $cookie->id_lang = (int)$lang->id;
//                }
//            }
//        }
//
//        if (isset($cookie->detect_language)) {
//            unset($cookie->detect_language);
//        }
//
//        /* If language file not present, you must use default language file */
//        if (!$cookie->id_lang || !Validate::isUnsignedId($cookie->id_lang)) {
//            $cookie->id_lang = (int) Language::getIdByIso('en');
//        }
//
//        $iso = Language::getIsoById((int)$cookie->id_lang);
//        @include_once(_PS_THEME_DIR_.'lang/'.$iso.'.php');
//
//        return $iso;
//    }
}