<?php

function getSupplier() {
    global $conn;
    $sql = 'select * from ' . _DB_PREFIX_ . 'supplier';

    $result = $conn->query($sql);

    $suppliers = array();
    if ($result->num_rows > 0) {
        // output data of each row
        $message = $result->num_rows . ' suppliers';
        $status = true;
        $num = 0;
        while ($row = $result->fetch_assoc()) {
            $suppliers[$num]['id'] = $row['id_supplier'];
            $suppliers[$num]['name'] = utf8_encode($row['name']);
            $num++;
        }
    } else {
        $message = 'No Supplier Found.';
        $status = false;
    }

    $data['status'] = $status;
    $data['message'] = $message;
    $data['data'] = $suppliers;

    return $data;
}
