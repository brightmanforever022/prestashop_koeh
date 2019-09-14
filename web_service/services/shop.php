<?php

function getAllShops() {
    global $conn;
    $sql = 'select * from os_dbk_shop';

    $result = $conn->query($sql);

    $shops = array();
    if ($result->num_rows > 0) {
        // output data of each row
        $message = $result->num_rows . ' shops';
        $status = true;
        $num = 0;
        while ($row = $result->fetch_assoc()) {
            $shops[$num]['id'] = $row['id'];
            $shops[$num]['name'] = $row['name'];
            $num++;
        }
    } else {
        $message = 'No Shop Found.';
        $status = false;
    }

    $data['status'] = $status;
    $data['message'] = $message;
    $data['data'] = $shops;

    return $data;
}
