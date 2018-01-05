<?php
class LT_FormFields extends SB_Object
{
	protected $baseFields;
	protected $fields;
	
	public function __construct($filled_fields)
	{
		if( $filled_fields )
		{
			$this->baseFields = $filled_fields;
			$this->ParseFields();
		}
	}
	/**
	 * Index fields by array key
	 * 
	 * @return  
	 */
	public function ParseFields()
	{
		if( !$this->baseFields )
			return null;
		foreach($this->baseFields as $f)
		{
			$key = strtolower(trim($f->label));
			$key = preg_replace('/\s+/', '_', $key);
			$key = preg_replace('/\[^a-z]/', '-', $key);
			$this->fields[$key] = $f;
		}
		
		return true;
	}
	public function GetName()
	{
		if( !$this->fields )
			return null;
		$name = '';
		if( isset($this->fields['name']) || isset($this->fields['fullname']) || isset($this->fields['full_name']) )
			return $this->fields['name'];
		if( isset($this->fields['firstname']) )
			$name .= $this->fields['firstname'];
		if( isset($this->fields['first_name']) )
			$name .= $this->fields['firstname'];
			
	}
	public function GetEmail()
	{
		if( !$this->fields || !isset($this->fields['email']) )
			return null;
		return $this->fields['email']->value;
	}
	public function GetAddress()
	{
	}
	public function GetField($name, $default = null)
	{
		if( !$this->fields || !isset($this->fields[$name]) )
			return $default;
		$this->fields[$name];
	}
}