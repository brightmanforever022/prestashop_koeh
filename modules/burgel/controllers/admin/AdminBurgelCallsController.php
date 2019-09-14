<?php

// Wheelronix Ltd. development team
// site: http://www.wheelronix.com
// mail: info@wheelronix.com

require_once dirname(__FILE__) . '/../../BurgelCall.php';

class AdminBurgelCallsController extends ModuleAdminController
{
    public function __construct()
    {
        $this->module = 'burgel';
        $this->bootstrap = true;
        $this->className = 'BurgelCall';
        $this->table = 'burgel_call';
        $this->list_no_link = true;
        $this->lang = false;
        $this->delete = false;
        $this->identifier = 'id';
        $this->position_identifier = 'id';
        $this->_select = 'a.cache_used as name'; // necessary to don't show details button for cached actions

        $this->fields_list = array(
            'id' => array('title' => $this->l('ID'), 'align' => 'center', 'width' => 25),
            'call_date' => array('title' => $this->l('Call date'), 'width' => 60, 'type' => 'datetime', 'filter_key' => 'a!call_date'),
            'customer_id' => array('title' => $this->l('Customer id'), 'width' => 25, 'callback' => 'showCustomerIdColumn'),
            'resp_firstname' => array('title' => $this->l('First name'), 'width' => 60),
            'resp_lastname' => array('title' => $this->l('Last name'), 'width' => 60),
            'resp_street' => array('title' => $this->l('Street'), 'width' => 60),
            'resp_house_number' => array('title' => $this->l('House number'), 'width' => 60),
            'resp_city' => array('title' => $this->l('City'), 'width' => 60),
            'resp_score' => array('title' => $this->l('Score'), 'width' => 60),
            'resp_decision_text' => array('title' => $this->l('Decision text'), 'width' => 120),
            'order_id' => array('title' => $this->l('Order id'), 'width' => 25, 'callback' => 'showOrderIdColumn'),
            'cache_used' => array('title' => $this->l('Cache used'), 'width' => 50, 'type' => 'select', 'select' => 
                array(1 => $this->l('Yes'), 2 => $this->l('No')),
                'filter_type' => 'notZero', 'filter_key' => 'a!order_accepted', 'callback' => 'showCacheUsedColumn'),
            );
        // configure list 

        parent::__construct();
    }
    
    
    function postProcess()
    {
        $cookie = Context::getContext()->cookie;

        if (Tools::isSubmit('submitFilter') OR ( count($_POST) == 0 && $cookie->{'submitFilter' . $this->table} !== false))
        {
            $_POST = array_merge($cookie->getFamily($this->table . 'Filter_'), (isset($_POST) ? $_POST : array()));
            foreach ($_POST AS $key => $value)
            {
                /* Extracting filters from $_POST on key filter_ */
                if ($value != NULL AND ! strncmp($key, $this->table . 'Filter_', 7 + Tools::strlen($this->table)))
                {
                    $key = Tools::substr($key, 7 + Tools::strlen($this->table));
                    /* Table alias could be specified using a ! eg. alias!field */
                    $tmpTab = explode('!', $key);
                    $filter = count($tmpTab) > 1 ? $tmpTab[1] : $tmpTab[0];
                    if ($field = $this->filterToField($key, $filter))
                    {
                        $type = (array_key_exists('filter_type', $field) ? $field['filter_type'] : (array_key_exists('type', $field) ? $field['type'] : false));
                        if (($type == 'date' OR $type == 'datetime') AND is_string($value))
                            $value = unserialize($value);
                        $key = isset($tmpTab[1]) ? $tmpTab[0] . '.`' . bqSQL($tmpTab[1]) . '`' : '`' . bqSQL($tmpTab[0]) . '`';
                        if (array_key_exists('tmpTableFilter', $field))
                            $sqlFilter = & $this->_tmpTableFilter;
                        elseif (array_key_exists('havingFilter', $field))
                            $sqlFilter = & $this->_filterHaving;
                        else
                            $sqlFilter = & $this->_filter;

                        /* Only for date filtering (from, to) */
                        if (is_array($value))
                        {
                            if (isset($value[0]) AND ! empty($value[0]))
                            {
                                if (!Validate::isDate($value[0]))
                                    $this->_errors[] = Tools::displayError('\'from:\' date format is invalid (YYYY-MM-DD)');
                                else
                                    $sqlFilter .= ' AND ' . $key . ' >= \'' . pSQL(Tools::dateFrom($value[0])) . '\'';
                            }

                            if (isset($value[1]) AND ! empty($value[1]))
                            {
                                if (!Validate::isDate($value[1]))
                                    $this->_errors[] = Tools::displayError('\'to:\' date format is invalid (YYYY-MM-DD)');
                                else
                                    $sqlFilter .= ' AND ' . $key . ' <= \'' . pSQL(Tools::dateTo($value[1])) . '\'';
                            }
                        }
                        else
                        {
                            $sqlFilter .= ' AND ';

                            // special logic for order accepted column
                            if ($type == 'notZero')
                            {
                                switch ($value)
                                {
                                    case '':
                                        $sqlFilter .= '1 ';
                                        break;
                                    case 1:
                                        $sqlFilter .= (($key == $this->identifier OR $key == '`' . $this->identifier . '`') ? 'a.' : '') . 'order_id > 0 ';
                                        break;
                                    case 2:
                                        $sqlFilter .= (($key == $this->identifier OR $key == '`' . $this->identifier . '`') ? 'a.' : '') . 'order_id = 0 ';
                                }
                            }
                            elseif ($type == 'int' OR $type == 'bool')
                                $sqlFilter .= (($key == $this->identifier OR $key == '`' . $this->identifier . '`' OR $key == '`active`') ? 'a.' : '') . pSQL($key) . ' = ' . (int) ($value) . ' ';
                            elseif ($type == 'decimal')
                                $sqlFilter .= (($key == $this->identifier OR $key == '`' . $this->identifier . '`') ? 'a.' : '') . pSQL($key) . ' = ' . (float) ($value) . ' ';
                            elseif ($type == 'select')
                                $sqlFilter .= (($key == $this->identifier OR $key == '`' . $this->identifier . '`') ? 'a.' : '') . pSQL($key) . ' = \'' . pSQL($value) . '\' ';
                            else
                                $sqlFilter .= (($key == $this->identifier OR $key == '`' . $this->identifier . '`') ? 'a.' : '') . pSQL($key) . ' LIKE \'%' . pSQL($value) . '%\' ';
                        }
                    }
                }
            }
        }
        else
        {
            parent::postProcess();
        }
    }

    public function showCacheUsedColumn($cacheUsed, $row)
    {
        if ($cacheUsed)
        {
            return $this->l('Yes');
        }

        return $this->l('No');
    }

    public function getOrderPageLink($orderId, $text)
    {
        return '<a href="' . Context::getContext()->link->getAdminLink('AdminOrders').'&id_order=' . $orderId . '&vieworder' .
                '" target="_blank">' . $text . '</a>';
    }

    public function showOrderIdColumn($orderId, $row)
    {
        if ($orderId)
        {
            return $this->getOrderPageLink($orderId, $orderId);
        }
        else
        {
            // reading customer order nearest to call time
            $sql = 'select id_order, payment from ' . _DB_PREFIX_ . 'orders where date_add>\'' . $row['call_date'] . '\' and id_customer=' .
                    $row['customer_id'] . ' order by id_order asc';
            $nextOrder = Db::getInstance()->getRow($sql);
            if ($nextOrder)
            {
                return $this->l('further order:') . ' ' . $this->getOrderPageLink($nextOrder['id_order'], $nextOrder['id_order']) . ' (' . 
                        $nextOrder['payment'] . ')';
            }
            else
            {
                return $this->l('No further order');
            }
        }
    }

    public function showCustomerIdColumn($customerId, $row)
    {
        if ($customerId)
        {
            return '<a href="' . Context::getContext()->link->getAdminLink('AdminCustomers').'&id_customer='.$customerId.'&updatecustomer' .
                '" target="_blank">' . $customerId . '</a>';
        }
    }
    
    
    public function renderList()
    {
        $this->addRowAction('details');
        return parent::renderList();
    }
    
    
    public function displayDetailsLink($token, $id, $isCachedRow)
    {
        if ($isCachedRow)
        {
            return '';
        }
        $tpl = $this->createTemplate('helpers/list/list_action_details.tpl');
        if (!array_key_exists('Details', self::$cache_lang))
            self::$cache_lang['Details'] = $this->l('Details', 'Helper');

        $tpl->assign(array(
            'href' => '#',
            'onClick'  => '$(\'#details' . $id . '\').toggle(); return false;',
            'action' => self::$cache_lang['Details'],
            'id' => $id
        ));

        return $tpl->fetch();
    }
}
