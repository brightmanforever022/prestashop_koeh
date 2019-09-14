<?php

function getAllLanguages() {
    global $conn;
    $sql = 'select id_lang,name from ' . _DB_PREFIX_ . 'lang order by id_lang';

    $result = $conn->query($sql);

    $languages = array();
    if ($result->num_rows > 0) {
        // output data of each row
        $message = $result->num_rows . ' lang';
        $status = true;
        $num = 0;
        while ($row = $result->fetch_assoc()) {
            $languages[$num]['id'] = $row['id_lang'];
            $languages[$num]['name'] = $row['name'];
            $num++;
        }
    } else {
        $message = 'No Languages Found.';
        $status = false;
    }

    $data['status'] = $status;
    $data['message'] = $message;
    $data['data'] = $languages;

    return $data;
}
