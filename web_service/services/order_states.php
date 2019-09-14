<?php
	function getAllStates(){
		global $conn;
		$sql = 'select * from '._DB_PREFIX_.'order_state_lang where id_lang = '.$_POST['lang_id'].' order by name asc';

		$result = $conn->query($sql);
		
		$states = array();
		if ($result->num_rows > 0) {
			// output data of each row
			$message = $result->num_rows.' states';
			$status = true;
			$num = 0;
			while($row = $result->fetch_assoc()) {
				$shops[$num]['id'] = $row['id_order_state'];
				$shops[$num]['name'] = utf8_encode($row['name']);
				$num++;
			}
		} else {
			$message = 'No State Found.';
			$status = false;
		}
		
		$data['status'] = $status;
		$data['message'] = $message;
		$data['data'] = $shops;
		
		return $data;
}