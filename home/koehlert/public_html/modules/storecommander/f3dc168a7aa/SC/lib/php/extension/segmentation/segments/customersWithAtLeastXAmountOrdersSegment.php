<?php

class customersWithAtLeastXAmountOrdersSegment extends SegmentCustom
{
    public $name = "Customers who ordered at least X (store default currency)";
    public $liste_hooks = array("segmentAutoConfig", "segmentAutoSqlQuery", "segmentAutoSqlQueryGrid");

    public function _executeHook_segmentAutoConfig($name, $params=array())
    {
        $values = array();
        if(!empty($params["values"]))
            $values = unserialize($params["values"]);

        $html='<strong>'._l("Amount (format: 0.00):").'</strong><br/>
		<input type="x_amount" id="x_amount" name="x_amount" style="width: 100%;" value="'.(!empty($values['x_amount'])?$values['x_amount']:'').'" />';

        return $html;
    }

    public function _executeHook_segmentAutoSqlQueryGrid($name, $params=array())
    {
        $array = array();

        if (!empty($params["auto_params"]))
        {
            $auto_params = unserialize($params["auto_params"]);
            if (!empty($auto_params["x_amount"]) && is_numeric($auto_params["x_amount"]))
            {
                $sql = 'SELECT c.id_customer, SUM(o.total_paid) AS amount_orders
                    FROM '._DB_PREFIX_.'customer c
                    INNER JOIN '._DB_PREFIX_.'orders o ON (c.id_customer=o.id_customer AND o.valid=1)
                    GROUP BY c.id_customer
                    HAVING amount_orders >= '.pSQL($auto_params["x_amount"]).';';

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
            if(!empty($auto_params["x_amount"]) && is_numeric($auto_params["x_amount"]))
            {
                $where = " AND  (SELECT SUM(o2.total_paid) AS amount_orders
                            FROM "._DB_PREFIX_."orders o2
                            WHERE o2.id_customer = c.id_customer AND o2.valid=1
                            GROUP BY o2.id_customer
                            ) >= '".pSQL($auto_params["x_amount"])."'";
            }
        }
        return $where;
    }
}