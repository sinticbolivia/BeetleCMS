<?php
namespace SinticBolivia\SBFramework\Classes;
use SinticBolivia\SBFramework\Classes\SB_ORMObject;
/**
 * 
 * @author marcelo
 *
 * @property int attachment_id
 * @property string title
 * @property string description
 * @property string mime
 * @property string file
 * @property int size
 * @property int parent
 * @property datetime last_modification_date
 * @property datetime creation_date
 */
class SB_Attachment extends SB_ORMObject
{
	public function __construct($id = null)
	{
		parent::__construct();
		if( $id )
			$this->GetDbData($id);
	}
	public function GetDbData($id)
	{
		$query = "SELECT * FROM attachments WHERE attachment_id = $id";
		if( !$this->dbh->Query($query) )
		{
			return null;
		}
		$this->_dbData = $this->dbh->FetchRow();
	}
	public function SetDbData($data)
	{
		$this->_dbData = $data;
	}
	public function Delete()
	{
		$query = "SELECT * FROM attachments WHERE parent = $this->attachment_id ";
		foreach($this->dbh->FetchResults($query) as $row)
		{
			$file = UPLOADS_DIR . SB_DS . $row->file;
			if( is_file($file) )
			{
				unlink($file);
			}
		}
		//##delete the main attachment
		if( is_file(UPLOADS_DIR. SB_DS . $this->file) )
			unlink(UPLOADS_DIR. SB_DS . $this->file);
		$this->dbh->Delete('attachments', array('parent' => $this->attachment_id));
		$this->dbh->Delete('attachments', array('attachment_id' => $this->attachment_id));
	}
	public function __get($var)
	{
		if( $var == 'id' )
			return $this->attachment_id;
		return parent::__get($var);
	}
}