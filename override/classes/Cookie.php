<?php
  /**
   * Rewritten on database sessions
   */

class Cookie extends CookieCore
{
    //! time to live of short cookie in seconds
    const ShortCookieTTL = 300;
    //! long cookie ttl in seconds
    const LongCookieTTL = 1728000;
    
	/** @var array Contain cookie content in a key => value format */
	protected $_content;

	/** @var array Crypted cookie name for setcookie() */
	protected $_name;

	/** @var array expiration date for setcookie() */
	protected $_expire;

	/** @var array Website domain for setcookie() */
	protected $_domain;

	/** @var array Path for setcookie() */
	protected $_path;

	/** @var array cipher tool instance */
	protected $_cipherTool;

	/** @var array cipher tool initialization key */
	protected $_key;

	/** @var array cipher tool initilization vector */
	protected $_iv;
	
	protected $_modified = false;

    protected $cookieId;
    protected $short;
    protected $cookieSent = false;
    protected $stopCookie = false;

	/**
	  * Get data if the cookie exists and else initialize an new one
	  *
	  * @param $name Cookie name before encrypting
	  * @param $path
	  */
	public function __construct($name, $path = '', $expire = NULL)
	{
		$this->_content = array();
		$this->_expire = isset($expire) ? (int)($expire) : (time() + 1728000);
		$this->_name = md5($name);
		$this->_path = trim(__PS_BASE_URI__.$path, '/\\').'/';
		if ($this->_path{0} != '/') $this->_path = '/'.$this->_path;
		$this->_path = rawurlencode($this->_path);
		$this->_path = str_replace('%2F', '/', $this->_path);
		$this->_path = str_replace('%7E', '~', $this->_path);
		$this->_key = _COOKIE_KEY_;
		$this->_iv = _COOKIE_IV_;
		$this->_domain = $this->getDomain();

        register_shutdown_function(array(&$this, "shutdown"));
        ob_start();
		$this->update();
	}
	

	/**
	  * Magic method wich add data into _content array
	  *
	  * @param $key key desired
	  * @param $value value corresponding to the key
	  */
	public function __set($key, $value)
	{
		if (!$this->_modified AND (!isset($this->_content[$key]) OR (isset($this->_content[$key]) AND $this->_content[$key] != $value)))
			$this->_modified = true;
		$this->_content[$key] = $value;
//		$this->write();
	}

	/**
	  * Magic method wich delete data into _content array
	  *
	  * @param $key key wanted
	  */
	public function __unset($key)
	{
		if (isset($this->_content[$key]))
			$this->_modified = true;
		unset($this->_content[$key]);
//		$this->write();
	}


	/**
	  * Get cookie content
	  */
	function update($nullValues = false)
	{
            if ($this->stopCookie)
            {
                return;
            }
            
		if (isset($_COOKIE[$this->_name]))
		{
            $this->cookieId = $_COOKIE[$this->_name];
            // reading cookie from database
            $row = Db::getInstance()->getRow('select data, short from '._DB_PREFIX_.'session where id=\''.pSQL($this->cookieId).'\'');
            
            if (!$row)
            {
                // cookie expired, set new one
                unset($_COOKIE[$this->_name]);
                return $this->update();
            }

            $this->short = $row['short'];
            $this->_content = unserialize($row['data']);
            if ($this->short)
            {
                // if it is short cookie, make it long
                $expires = time()+self::LongCookieTTL;
                $this->_setcookie($this->cookieId, $expires);

                // update in database
                Db::getInstance()->Execute('update '._DB_PREFIX_.'session set expires=\''.pSQL(date('Y-m-d H:i:s', $expires)).'\', short=0 where id=\''.
                                            pSQL($this->cookieId).'\'');
                $this->short = false;
            }
		}
		else
        {
            // generate new cookie id
            $this->cookieId = self::genCookieId();
            // first set short cookie
            $this->short = true;
            $expires = time()+self::ShortCookieTTL;
            $this->_setcookie($this->cookieId, $expires);
            Db::getInstance()->Execute('insert into '._DB_PREFIX_.'session (id, data, short, expires) values(\''.pSQL($this->cookieId).'\', \''.
                                        pSQL(serialize($this->_content)).'\', 1, \''.pSQL(date('Y-m-d H:i:s', $expires)).'\')');
            
            // remove old cookies
            $this->clearOld();
        }

        if (!isset($this->_content['date_add']))
            $this->_content['date_add'] = date('Y-m-d H:i:s');
			
		
		//checks if the language exists, if not choose the default language
		if (!Language::getLanguage((int)$this->id_lang))
			$this->id_lang = Configuration::get('PS_LANG_DEFAULT');
		
	}

	/**
	  * Setcookie according to php version
	  */
	protected function _setcookie($content=null, $time=null)
	{
            if ($this->stopCookie)
            {
                return;
            }
        // if cookie was already sent in this session do nothing
        if ($this->cookieSent)
        {
            return;
        }

        $this->cookieSent = true;

		if (PHP_VERSION_ID <= 50200) /* PHP version > 5.2.0 */
			return setcookie($this->_name, $content, $time, $this->_path, $this->_domain, 0);
		else
			return setcookie($this->_name, $content, $time, $this->_path, $this->_domain, 0, true);
	}

    
        /**
         * Stops all cookie related action after this function call cookie will not be saved and headers will not be sent.
         */
        function stopCookie()
        {
            $this->stopCookie = true;
        }
        
	/**
     * Save cookie content in database
     */
	public function write($shutdown=false)
	{
        if (!$shutdown || $this->stopCookie)
        {
            return;
        }
        
        if ($this->short)
        {
            $expires = time()+self::ShortCookieTTL;
        }
        else
        {
            $expires = time()+self::LongCookieTTL;
        }
                                    
        Db::getInstance()->Execute('replace '._DB_PREFIX_.
                  'session (id, data, expires, short) values(\''.pSQL($this->cookieId).'\',\''
                  .addslashes(serialize($this->_content)).'\', \''.date('Y-m-d H:i:s', $expires).'\', '.($this->short?1:0).')');
        $this->_setcookie($this->cookieId, $expires);
	}


    /**
     * Generates unique id for new cookie
     */
    static function genCookieId()
    {
        do{
            $id = self::randomString(32);
            $exists = Db::getInstance()->getValue('select count(id) from '._DB_PREFIX_.'session where id=\''.pSQL($id).'\'');
        }
        while($exists);

        return $id;
    }


    /**
     * generates random string with given length
     */
    static function randomString($len)
    {
        $result = '';
        while(strlen($result)<$len)
        {
            $char = chr(rand(0,128));
            if (preg_match('/\d|\w/', $char))
            {
                $result .= $char;
            }
        }
        return $result;
    }


    /**
     * Deletes all expired records in db
     */
    static function clearOld()
    {
        Db::getInstance()->Execute('delete from '._DB_PREFIX_.'session where expires<\''.pSQL(date('Y-m-d H:i:s', time())).'\'');
    }


    /**
     * Write cookie data on object destroy
     */    
    function shutdown()
    {
        $this->write(1);
        ob_end_flush();
    }
 
    
    /**
     * Delete cookie
     */
	public function logout()
	{
		$this->_content = array();
	}

	/**
	  * Soft logout, delete everything links to the customer
	  * but leave there affiliate's informations
	  */
	public function mylogout()
	{
		unset($this->_content['id_compare']);
		unset($this->_content['id_customer']);
		unset($this->_content['id_guest']);
		unset($this->_content['is_guest']);
		unset($this->_content['id_connections']);
		unset($this->_content['customer_lastname']);
		unset($this->_content['customer_firstname']);
		unset($this->_content['passwd']);
		unset($this->_content['logged']);
		unset($this->_content['email']);
		unset($this->_content['id_cart']);
		unset($this->_content['id_address_invoice']);
		unset($this->_content['id_address_delivery']);
	}
	
	
	function getCookieId()
	{
	    return $this->cookieId;
	}
}
