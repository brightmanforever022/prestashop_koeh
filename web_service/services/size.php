<?php

function getAllSizes() {
    global $conn;
    $sql = 'select distinct al.id_attribute, al.name from ' . _DB_PREFIX_ . 'product_attribute_combination pac '
            . 'inner join ' . _DB_PREFIX_ . 'attribute_lang al on al.id_attribute=pac.id_attribute and al.id_lang='.$_POST['lang_id'].' order by name';

    $result = $conn->query($sql);

    $shops = array();
    if ($result->num_rows > 0) {
        // output data of each row
        $message = $result->num_rows . ' product_attribute_combination';
        $status = true;
        $num = 0;
        while ($row = $result->fetch_assoc()) {
            $shops[$num]['id'] = $row['id_attribute'];
            $shops[$num]['name'] = $row['name'];
            $num++;
        }
    } else {
        $message = 'No Size Found.';
        $status = false;
    }

    $data['status'] = $status;
    $data['message'] = $message;
    $data['data'] = $shops;

    return $data;
}
