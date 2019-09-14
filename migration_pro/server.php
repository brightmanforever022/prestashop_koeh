<?php
define('MP_TOKEN', '3125233');

error_reporting(1);

if (!isset($_SERVER)) {
    $_GET = &$HTTP_GET_VARS;
    $_POST = &$HTTP_POST_VARS;
    $_ENV = &$HTTP_ENV_VARS;
    $_SERVER = &$HTTP_SERVER_VARS;
    $_COOKIE = &$HTTP_COOKIE_VARS;
    $_REQUEST = array_merge($_GET, $_POST, $_COOKIE);
}

define('MPROOT_BASE_NAME', basename(getcwd()));
define('MPCONNECTOR_BASE_DIR', dirname(__FILE__));
define('MPSTORE_BASE_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

class MPServer {

    var $action = null;
    var $adapter = null;
    var $response = null;

    function __construct() {
        $this->action = $this->_getAction();
        $this->adapter = $this->_getAdapter();
        $this->response = $this->_getResponse();
    }

    function run() {
        if(empty($_GET)){
            echo "MigrationPro: PrestaShop To PrestaShop Connector File Ready to Work!";
            return ;
        }
        if (!$this->_checkToken()) {
            $this->response->error('Token is false !', null);
            return;
        }

        $this->action->setConnector($this);
        $this->action->run();
    }

    function _getAdapter() {
        $adapter = new MPServerAdapter();
        return $adapter;
    }

    function _getResponse() {
        $response = new MPServerResponse();
        return $response;
    }

    function _getAction() {
        $action = new MPServerAction();
        return $action;
    }

    function _checkToken() {
        if (isset($_GET['token']) && $_GET['token'] == MP_TOKEN) {
            return true;
        } else {
            return false;
        }
    }

}

class MPServerAction {

    var $type = null;
    var $connector = null;

    function __construct() {

    }

    function setConnector($connector) {
        $this->connector = $connector;
    }

    function _getActionType($action_type) {
        $action = null;
        $action_type = strtolower($action_type);
        $class_name = __CLASS__ . ucfirst($action_type);
        if (class_exists($class_name)) {
            $action = new $class_name();
        }
        return $action;
    }

    function run() {
        if (isset($_GET['action']) && $action = $this->_getActionType($_GET['action'])) {
            $action->setConnector($this->connector);
            $action->run();
        } else {
            $response = $this->connector->response;
            $response->createResponse('error', 'Action not found !', null);
            return;
        }
    }

    function _getResponse() {
        return $this->connector->response;
    }

    function _getAdapter() {
        return $this->connector->adapter;
    }

    function _getCart() {
        $adapter = $this->_getAdapter();
        $cart = $adapter->getCart();
        return $cart;
    }

}

class MPServerActionCheck extends MPServerAction {

    function __construct() {
        parent::__construct();
    }

    function run() {
        $response = $this->_getResponse();
        $adapter = $this->_getAdapter();
        $cart = $this->_getCart();
        $obj['cms'] = $adapter->detectCartType();
        if ($cart) {
            $obj['image_category'] = $cart->imageDirCategory;
            $obj['image_product'] = $cart->imageDirProduct;
            $obj['image_manufacturer'] = $cart->imageDirManufacturer;
            $obj['image_supplier'] = $cart->imageDirSupplier;
            $obj['table_prefix'] = $cart->tablePrefix;
            $obj['version'] = $cart->version;
            $obj['charset'] = $cart->char_set;
            $obj['blowfish_key'] = $cart->blowfish_key;
            $obj['cookie_key'] = $cart->cookie_key;
            $connect = $cart->connect();
            if ($connect && $char_set = $this->_checkDatabaseExist($connect)) {
                if($obj['charset'] == ''){
                    $obj['charset'] = $char_set;
                }
                $obj['connect'] = array(
                    'result' => 'success',
                    'msg' => 'Successful connect to database !'
                );
            } else {
                $obj['connect'] = array(
                    'result' => 'error',
                    'msg' => 'Not connect to database !'
                );
            }
        }
        $response->success('Successful check CMS !', $obj);
        return;
    }

    function _checkDatabaseExist($connect){
        $query = "SHOW VARIABLES LIKE \"ch%\"";
        $rows = array();
        $char = null;
        $result = @mysql_query($query,$connect);
        while ($row = @mysql_fetch_array($result)) {
            $rows[] = $row;
        }
        foreach($rows as $row){
            if($row['Variable_name'] == 'character_set_database'){
                $char_set = $row['Value'];
            }
            if(strpos($row['Value'], 'utf8') !== false){
                $char = 'utf8';
                break ;
            }
        }
        if(!$char){ $char = $char_set;}
        return $char;
    }

}

class MPServerActionFile extends MPServerAction {

    function __construct() {
        parent::__construct();
    }

    function run() {
        $obj = array();
        $response = $this->_getResponse();

        if(isset($_REQUEST['files'])){
            $files = base64_decode($_REQUEST['files']);

            if(is_string($files)){
                $path = MPSTORE_BASE_DIR.$files;
                if(file_exists($path)){
                    $content = @file_get_contents($path);
                    echo $content;
                    return ;
                    $obj[] = $content;
                }
            }
            if(is_array($files)){
                foreach ($files as $key => $file){
                    $path = MPSTORE_BASE_DIR.$file;
                    if(file_exists($path)){
                        $content = @file_get_contents($path);
                        echo $content;
                        return ;
                        $obj[$key] = $content;
                    }
                }
            }
        }
        $response->success(null, $obj);
        return ;
    }

}

class MPServerActionQuery extends MPServerAction {

    function __construct() {
        parent::__construct();
    }

    function run() {
        $obj = array();
        $response = $this->_getResponse();
        $cart = $this->_getCart();
        if ($cart) {
            $connect = $cart->connect();
            if ($connect && isset($_REQUEST['query'])) {
                if(isset($_REQUEST['char_set'])){
                    $char_set = base64_decode($_REQUEST['char_set']);
                    @mysql_query("SET NAMES " . @mysql_real_escape_string($char_set), $connect);
                    @mysql_query("SET CHARACTER SET " . @mysql_real_escape_string($char_set), $connect);
                    @mysql_query("SET CHARACTER_SET_CONNECTION=" . @mysql_real_escape_string($char_set), $connect);
                }

//                $log_file = fopen(__DIR__ . "/log_file.txt", "a+") or die("Unable to open file!");
//                fwrite($log_file, " ============================= " . "\n\r");

                $query = base64_decode($_REQUEST['query']);

                if(isset($_REQUEST['serialize']) && $_REQUEST['serialize']){
                    $query = unserialize($query);
                    foreach($query as $key => $string){
//                        fwrite($log_file, $key . ": " . $string . "\n\r");
                        $obj[$key] = $this->_getData($string, $connect);
                    }
                } else {
//                    fwrite($log_file, $query . "\n\r");
                    $obj = $this->_getData($query, $connect);
                }
//                fclose($log_file);
                $response->success(null, $obj);

                return;
            } else {
                $response->error('Can\'t connect to database or not run query !', null);
                return;
            }
        } else {
            $response->error('CMS Cart not found !', null);
            return;
        }
    }

    function _getData($query, $connect){
        $rows = array();
        $res = @mysql_query($query, $connect);
        while($row = @mysql_fetch_array($res, MYSQL_ASSOC)){
            $rows[] = $row;
        }
        return $rows;
    }
}

class MPServerAdapter {

    var $cart = null;
    var $Host = 'localhost';
    var $Port = '3306';
    var $Username = 'root';
    var $Password = '';
    var $Dbname = '';
    var $tablePrefix = '';
    var $imageDir = '';
    var $imageDirCategory = '';
    var $imageDirProduct = '';
    var $imageDirManufacturer = '';
    var $imageDirSupplier = '';
    var $version = '';
    var $char_set = '';
    var $blowfish_key = '';
    var $cookie_key = '';

    function __construct() {

    }

    function getCart() {
        $cart_type = $this->detectCartType();
        $this->cart = $this->_getCartType($cart_type);
        return $this->cart;
    }

    function _getCartType($cart_type) {
        $cart = null;
        $cart_type = strtolower($cart_type);
        $class_name = __CLASS__ . ucfirst($cart_type);
        if (class_exists($class_name)) {
            $cart = new $class_name();
        }
        return $cart;
    }

    function detectCartType() {

        if (file_exists(MPSTORE_BASE_DIR . 'config/settings.inc.php')) {
            return 'prestashop';
        }

        return 'Not detect cart !';
    }

    function setHostPort($source) {
        $source = trim($source);

        if ($source == '') {
            $this->Host = 'localhost';
            return;
        }

        $conf = explode(':', $source);
        if (isset($conf[0]) && isset($conf[1])) {
            $this->Host = $conf[0];
            $this->Port = $conf[1];
        } elseif ($source[0] == '/') {
            $this->Host = 'localhost';
            $this->Port = $source;
        } else {
            $this->Host = $source;
        }
    }

    function connect() {
        $triesCount = 10;
        $link = null;
        $host = $this->Host . ($this->Port ? ':' . $this->Port : '');
        while (!$link) {
            if (!$triesCount--) {
                break;
            }
            $link = @mysql_connect($host, $this->Username, $this->Password);
            if (!$link) {
                sleep(2);
            }
        }

        if ($link) {
            @mysql_select_db($this->Dbname, $link);
        }
        return $link;
    }

    function getCartVersionFromDb($field, $tableName, $where)
    {
        $_link = null;
        $version = '';

        $_link = $this->connect();
        if (!$_link) {
            return $version;
        }

        $sql = 'SELECT ' . $field . ' AS version FROM ' . $this->tablePrefix . $tableName . ' WHERE ' . $where;

        $query = mysql_query($sql, $_link);

        if ($query !== false) {
            $row = mysql_fetch_assoc($query);

            $version = $row['version'];
        }

        return $version;
    }

}

class MPServerAdapterPrestashop extends MPServerAdapter {

    function __construct() {
        parent::__construct();
        @require_once MPSTORE_BASE_DIR . '/config/settings.inc.php';

        if (defined('_DB_SERVER_')) {
            $this->setHostPort(_DB_SERVER_);
        } else {
            $this->setHostPort(DB_HOSTNAME);
        }

        if (defined('_DB_USER_')) {
            $this->Username = _DB_USER_;
        } else {
            $this->Username = DB_USERNAME;
        }

        $this->Password = _DB_PASSWD_;

        if (defined('_DB_NAME_')) {
            $this->Dbname = _DB_NAME_;
        } else {
            $this->Dbname = DB_DATABASE;
        }
        $this->tablePrefix = _DB_PREFIX_;
        $this->imageDir = '/img/';
        $this->imageDirCategory = $this->imageDir . 'c/';
        $this->imageDirProduct = $this->imageDir . 'p/';
        $this->imageDirManufacturer = $this->imageDir . 'm/';
        $this->imageDirSupplier = $this->imageDir . 'su/';
        $this->version = _PS_VERSION_;
        $this->cookie_key = _COOKIE_KEY_;
    }

}

class MPServerResponse {

    function __construct() {

    }

    function createResponse($result, $msg, $obj) {
        $response = array();
        $response['status'] = $result;
        $response['message'] = $msg;
        $response['content'] = $obj;
        echo base64_encode(serialize($response));
        return;
    }

    function error($msg = null, $obj = null) {
        $this->createResponse('error', $msg, $obj);
    }

    function success($msg = null, $obj = null) {
        $this->createResponse('success', $msg, $obj);
    }

}
$connector = new MPServer();
$connector->run();
