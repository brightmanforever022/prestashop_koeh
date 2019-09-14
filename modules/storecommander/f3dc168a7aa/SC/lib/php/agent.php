<?php
/**
 * Store Commander
 *
 * @category administration
 * @author Store Commander - support@storecommander.com
 * @version 2015-09-15
 * @uses Prestashop modules
 * @since 2009
 * @copyright Copyright &copy; 2009-2015, Store Commander
 * @license commercial
 * All rights reserved! Copying, duplication strictly prohibited
 *
 * *****************************************
 * *           STORE COMMANDER             *
 * *   http://www.StoreCommander.com       *
 * *            V 2015-09-15               *
 * *****************************************
 *
 * Compatibility: PS version: 1.1 to 1.6.1
 *
 **/

class SC_Agent
{
	public 		$id_employee;
	
	/** @var int Determine employee profile */
	public 		$id_profile;
	
	/** @var int PS BO id_lang */
	public 		$ps_id_lang;
	
	/** @var int id_lang to use in application */
	public 		$id_lang;
	
	/** @var string Lastname */
	public 		$lastname;
	
	/** @var string Firstname */
	public 		$firstname;
	
	/** @var string e-mail */
	public 		$email;
	
	/** @var datetime Password */
	public 		$last_passwd_gen;
	
	/** @var boolean Status */
	public 		$active = 1;

	public function __construct()
	{
		if (!defined('SC_INSTALL_MODE')) return false;
		if (SC_INSTALL_MODE==0)
		{
			global $cookie;
			$this->id_employee=$cookie->id_employee;
			$this->id_lang=$cookie->id_lang;
			$result = Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'employee` WHERE `id_employee` = '.(int)$this->id_employee);
			$this->id_profile=(int)$result['id_profile'];
			$this->lastname=psql($result ['lastname']);
			$this->firstname=psql($result['firstname']);
			$this->email=psql($result['email']);
			$this->last_passwd_gen=psql($result['last_passwd_gen']);
			$this->ps_id_lang=(int)$result['id_lang'];
			$this->active=(int)$result['active'];
		}else{
			global $sc_cookie;
            if(empty($sc_cookie)) {
                $sc_cookie = new Cookie('scAdmin');
                $result = (array)Context::getContext()->employee;
                $result['id_employee'] = $sc_cookie->ide = (int)$result['id'];
            } else {
                $result = Db::getInstance()->getRow('SELECT * FROM `' . _DB_PREFIX_ . 'employee` WHERE `id_employee` = '.(int)$sc_cookie->ide);
            }
			$this->id_employee=(int)$result['id_employee'];
			$this->id_profile=(int)$result['id_profile'];
			$this->lastname=psql($result['lastname']);
			$this->firstname=psql($result['firstname']);
			$this->email=psql($result['email']);
			$this->last_passwd_gen=psql($result['last_passwd_gen']);
			$this->ps_id_lang=(int)$result['id_lang'];
			$this->active=(int)$result['active'];

			$sc_cookie->id_employee=(int)$result['id_employee'];
			$sc_cookie->passwd=$result['passwd'];

			if (version_compare(_PS_VERSION_, '1.4.0.0', '>='))
			{
				$this->id_lang=(int)$result['id_lang'];
			}else{
				$this->id_lang=(int)$sc_cookie->id_lang;
			}
		}
	}
	
	public function isAdmin()
	{
		return ($this->id_profile == intval(_PS_ADMIN_PROFILE_)			
				   && $this->active);
	}
	
	public function getPSToken($tab)
	{
		if (version_compare(_PS_VERSION_, '1.5.0.0', '>=') && $tab=='AdminCatalog') $tab='AdminProducts'; 
		return Tools::getAdminToken($tab.intval(Tab::getIdFromClassName($tab)).intval($this->id_employee));
	}

	public function isLoggedBack()
	{
		global $cookie, $sc_cookie;
		if (version_compare(_PS_VERSION_, '1.5.0.0', '<'))
		{
			if (SC_INSTALL_MODE==0)
				return $cookie->isLoggedBack();
			else
				return $sc_cookie->isLoggedBack();
		}else{
			return Context::getContext()->employee->isLoggedBack();
		}
	}

}
