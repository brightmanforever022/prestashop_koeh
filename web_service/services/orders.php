<?php

function getOrders() {
    global $conn;
    $sql = 'select od.*,Concat(c.firstname,c.lastname) as CsName,c.firstname,c.lastname,c.company from ' . _DB_PREFIX_ . 'orders as od left join ' . _DB_PREFIX_ . 'customer c on c.id_customer=od.id_customer where 1';

    if (!empty($_POST['order_id'])) {
        $sql .= ' and od.id_order = ' . intval($_POST['order_id']);
    }

    if (!empty($_POST['company'])) {
        $sql .= " and c.company Like '%" . $_POST['company'] . "%'";
    }

    if (!empty($_POST['sale_date_from'])) {
        $sql .= ' and od.date_add >= \'' . addslashes(date('Y-m-d H:i:s', strtotime($_POST['sale_date_from']))) . '\'';
    }

    if (!empty($_POST['sale_date_to'])) {
        $sql .= ' and od.date_add <= \'' . addslashes(date('Y-m-d H:i:s', strtotime($_POST['sale_date_to']))) . '\'';
    }
    if (!empty($_POST['customer'])) {
        $sql .= " and concat_ws(' ',c.firstname,c.lastname) Like '%" . $_POST['customer'] . "%'";
    }
    $sql .= ' order by od.id_order desc';

    if (!empty($_POST['perPage']) && $_POST['perPage'] != -1) {
        if (!empty($_POST['page']) && $_POST['page'] > 1) {
            // add pagination
            $sql .= ' limit ' . ($_POST['page'] - 1) * $_POST['perPage'] . ',' . $_POST['perPage'];
        } else {
            $sql .= ' limit ' . $_POST['perPage'];
        }
    } else {
       // $sql .= ' limit 500';
    }
      $completeSql = $sql;
    $result = $conn->query($completeSql);


    $orders = array();
    if ($result->num_rows > 0) {
        // output data of each row
        $message = $result->num_rows . ' orders';
        $status = true;
        $num = 0;
        $total_result= $result->num_rows;
		setlocale(LC_MONETARY, 'de_DE.UTF-8');
        while ($row = $result->fetch_assoc()) {
            $orders[$num]['id'] = $row['id_order'];
            $orders[$num]['customer'] = utf8_encode($row['firstname']) . ' ' . utf8_encode( $row['lastname']);
            $orders[$num]['company'] = utf8_encode( $row['company']);
            $orders[$num]['date_add'] = $row['date_add'];
            $orders[$num]['total'] = money_format('%.2n', $row['total_paid']);


            $num++;
        }
    } else {
        $message = 'No Order Found.';
        $status = false;
    }

    $conn->close();
//$data = array();
    $output1['status'] = $status;
    $output1['message'] = $message;
    $output1['data'] = $orders;
    $output1['total_result'] = $total_result;
    return $output1;
}
