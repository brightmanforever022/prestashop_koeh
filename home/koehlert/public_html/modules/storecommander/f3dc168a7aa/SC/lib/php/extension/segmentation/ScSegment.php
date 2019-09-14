<?php

/* ScSegmentation */

class ScSegment extends ObjectModel
{
	public		$id;
	public 		$name;
	public 		$type;
	public 		$auto_file;
	public 		$auto_params;
	public 		$access;
	public 		$description;
	public 		$id_parent;
	
	protected $tables = array ('sc_segment');
	
	protected 	$table = 'sc_segment';
	protected 	$identifier = 'id_segment';

	public function getFields()
	{
		parent::validateFields();
		$fields['name'] = ($this->name);
		$fields['type'] = ($this->type);
		$fields['auto_file'] = ($this->auto_file);
		$fields['auto_params'] = ($this->auto_params);
		$fields['access'] = ($this->access);
		$fields['description'] = ($this->description);
		$fields['id_parent'] = intval($this->id_parent);
		return $fields;
	}
}

