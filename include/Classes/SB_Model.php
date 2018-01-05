<?php
namespace SinticBolivia\SBFramework\Classes;
use SinticBolivia\SBFramework\Classes\SB_Factory;
/**
 * The Model base class
 * 
 * @author J. Marcelo Aviles Paco
 * @copyright Sintic Bolivia
 * @namespace
 */
class SB_Model 
{
	protected	$dbh;
	public      $mod;
    
	public function __construct($dbh = null)
	{
		$this->dbh = $dbh ? $dbh : SB_Factory::getDbh();
	}
    /**
     * Get a translated text from po files
     * 
     * @param string $str
     * @param string $domain
     * @return string The translated text
     */
    public function __($str, $domain = null)
    {
        return SBText::_($str, $domain ? $domain : $this->mod);
    }
}