<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SinticBolivia\SBFramework\Classes;
use SinticBolivia\SBFramework\Classes\SB_Attachment;
class SB_AttachmentImage extends SB_Attachment
{
	protected $thumbnails;
	public function GetDbThumbnails()
	{
		$this->thumbnails = array();
		if( !(int)$this->attachment_id )
			return false;
			
		$query = "SELECT * FROM attachments WHERE parent = {$this->attachment_id} AND type = 'image'";
		foreach($this->dbh->FetchResults($query) as $row)
		{
			$thumb = new SB_AttachmentImage();
			$thumb->SetDbData($row);
			$this->thumbnails[] = $thumb;
		}
	}
	/**
	 * Get image thumbnail
	 * 
	 * Size example: 55x55|150x150|330x330|500x500
	 * @param string $size 
	 * @return  SB_AttachmentImage
	 */
	public function GetThumbnail($size)
	{
		$thumb = null;
		if( !$this->thumbnails || !count($this->thumbnails) )
			$this->GetDbThumbnails();
		if( !count($this->thumbnails) )
			return $this;
		foreach($this->thumbnails as $_thumb)
		{
			if( stristr($_thumb->file, $size) )
			{
				$thumb = $_thumb;
				break;
			}
		}
		//##if thumbnail not found full size exists, return full size
		if( !$thumb && is_file(UPLOADS_DIR . SB_DS . $this->file) )
		{
			$thumb = $this;
		}
		return $thumb != null ? $thumb : new SB_AttachmentImage();
	}
	/**
	 * Get image url
	 * 
	 * @return string 
	 */
	public function GetUrl()
	{
		return UPLOADS_URL . '/' . $this->file;
	}
}