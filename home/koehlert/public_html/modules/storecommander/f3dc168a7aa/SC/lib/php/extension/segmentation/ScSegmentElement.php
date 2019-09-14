<?php

/* ScSegmentation */

class ScSegmentElement extends ObjectModel
{
	public		$id;
	public 		$id_segment;
	public 		$id_element;
	public 		$type_element;
	
	protected $tables = array ('sc_segment_element');
	
	protected 	$table = 'sc_segment_element';
	protected 	$identifier = 'id_segment_element';

	public function getFields()
	{
		parent::validateFields();
		$fields['id_segment'] = intval($this->id_segment);
		$fields['id_element'] = intval($this->id_element);
		$fields['type_element'] = ($this->type_element);
		return $fields;
	}
	
	static function checkInSegment($id_segment, $id_element, $type)
	{
		$return = false;
		
		$sql = "SELECT id_segment_element 
				FROM "._DB_PREFIX_."sc_segment_element 
				WHERE id_segment='".intval($id_segment)."'
					AND id_element='".intval($id_element)."'
					AND type_element='".pSQL($type)."'
				LIMIT 1";
		$res=Db::getInstance()->executeS($sql);
		if (!empty($res[0]['id_segment_element']))
			$return = true;
		
		return $return;
	}
}

