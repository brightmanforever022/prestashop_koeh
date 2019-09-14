<?php
	function getCurrency(){
		global $conn;
		 $sql = 'select * from '._DB_PREFIX_.'currency where active=1 and conversion_rate=1.000000';

		$result = $conn->query($sql);
		
		$languages = array();
		if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
			// output data of each row
			$message = $result->num_rows.' lang';
			$status = true;
                        $data['data'] = $row['iso_code'];
			
		} else {
			$message = 'No Languages Found.';
			$status = false;
                         $data['data'] = '';
		}
		
		$data['status'] = $status;
		$data['message'] = $message;
		
		
		return $data;
}