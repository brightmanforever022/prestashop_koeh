<?php
	function updateOrderState(){
		global $conn;
		
		if(!empty($_POST['id_order']) && !empty($_POST['id_order_state'])){
		$sql = 'insert into '._DB_PREFIX_.'order_history (id_employee,id_order,id_order_state,date_add) values('.intval($_POST['id_employee']).','.intval($_POST['id_order']).','.intval($_POST['id_order_state']).',\''.date('Y-m-d H:i:s').'\')';

		if ($conn->query($sql) === TRUE) {
			$message = "Order state update successfully.";
			$status = true;
		}
		else {
			$message = 'Order state could not be updated, please try again.';
			$status = false;
		}
		} else {
			$message = 'Order state could not be updated, please try again.';
			$status = false;
		}
		$data['status'] = $status;
		$data['message'] = $message;
		
		return $data;
}