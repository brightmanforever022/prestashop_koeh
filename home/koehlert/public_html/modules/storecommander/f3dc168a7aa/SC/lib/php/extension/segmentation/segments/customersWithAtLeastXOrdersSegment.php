<?php

class customersWithAtLeastXOrdersSegment extends SegmentCustom
{
    public $name = "Customers with at least X orders";
    public $liste_hooks = array("segmentAutoConfig", "segmentAutoSqlQuery", "segmentAutoSqlQueryGrid");

    public function _executeHook_segmentAutoConfig($name, $params=array())
    {
        $values = array();
        if(!empty($params["values"]))
            $values = unserialize($params["values"]);

        $html='<strong>'._l("At least X orders:").'</strong><br/>
		<input type="text" id="x_orders" name="x_orders" style="width: 100%;" value="'.(!empty($values['x_orders'])?$values['x_orders']:'').'" />';

        return $html;
    }

    public function _executeHook_segmentAutoSqlQueryGrid($name, $params=array())
    {
        $array = array();

        if (!empty($params["auto_params"]))
        {
            $auto_params = unserialize($params["auto_params"]);
            if (!empty($auto_params["x_orders"]) && is_numeric($auto_params["x_orders"]))
            {
                $sql = 'SELECT c.id_customer, COUNT(o.id_order) AS nb_orders
                    FROM '._DB_PREFIX_.'customer c
                    INNER JOIN '._DB_PREFIX_.'orders o ON (c.id_customer=o.id_customer AND o.valid=1)
                    GROUP BY c.id_customer
                    HAVING nb_orders >= '.intval($auto_params["x_orders"]).';';

                $res=Db::getInstance()->ExecuteS($sql);
                //echo $sql;
                foreach($res AS $row)
                {
                    $type = _l('Customer');
                    $element = new Customer($row['id_customer']);
                    $name = $element->firstname." ".$element->lastname;
                    $infos = "#".$row['id_customer']." / ".$element->email;
                    $array[] = array($type, $name, $infos, "id"=>"customer_".$row['id_customer']);
                }
            }
        }
        return $array;
    }

    public function _executeHook_segmentAutoSqlQuery($name, $params=array())
    {
        $where = "";

        if(!empty($params["auto_params"]))
        {
            $auto_params = unserialize($params["auto_params"]);
            if(!empty($auto_params["x_orders"]) && is_numeric($auto_params["x_orders"]))
            {
                $where = " AND  (SELECT COUNT(o2.id_order) AS nb_orders
                            FROM "._DB_PREFIX_."orders o2
                            WHERE o2.id_customer = c.id_customer AND o2.valid=1
                            GROUP BY o2.id_customer
                            ) >= '".intval($auto_params["x_orders"])."'";
            }
        }
        return $where;
    }
}