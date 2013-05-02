<?php
// Start the clock for the page parse time log
define('PAGE_PARSE_START_TIME', microtime());

define("SITE_SUB_URL", "admin/");
define('DIR_FS_DOCUMENT_ROOT', dirname(dirname(__FILE__))."/");

// Set the level of error reporting
error_reporting(E_ALL & ~E_NOTICE);

// check support for register_globals
if (function_exists('ini_get') && (ini_get('register_globals') == false) && (PHP_VERSION < 4.3) ) {
	exit('Server Requirement Error: register_globals is disabled in your PHP configuration. This can be enabled in your php.ini configuration file or in the .htaccess file in your catalog directory. Please use PHP 4.3+ if register_globals cannot be enabled on the server.');
}

// Include application configuration parameters
require(DIR_FS_DOCUMENT_ROOT.'/includes/configure.php');
require(DIR_FS_DOCUMENT_ROOT.'/includes/filename.php');

// Define the project version
define('PROJECT_VERSION', TITLE.' V1.0');

// some code to solve compatibility issues
require(DIR_WS_FUNCTIONS . 'compatibility.php');

// set the type of request (secure or not)
$request_type = (getenv('HTTPS') == 'on') ? 'SSL' : 'NONSSL';

// set php_self in the local scope
if (!isset($PHP_SELF)) $PHP_SELF = $HTTP_SERVER_VARS['PHP_SELF'];

// set php_self in the local scope
$PHP_SELF = (isset($HTTP_SERVER_VARS['PHP_SELF']) ? $HTTP_SERVER_VARS['PHP_SELF'] : $HTTP_SERVER_VARS['SCRIPT_NAME']);

// message
require(DIR_WS_CLASSES . 'message.php');
$message_cls = new Message();

// include the database functions
require(DIR_WS_FUNCTIONS . 'database.php');

// include the list of project database tables
require(DIR_WS_INCLUDES . 'database_tables.php');
// make a connection to the database... now
tep_db_connect() or die('Unable to connect to database server!');

require(DIR_WS_INCLUDES . 'set_configurations.php');

// Define how do we update currency exchange rates
// Possible values are 'oanda' 'xe' or ''
define('CURRENCY_SERVER_PRIMARY', 'oanda');
define('CURRENCY_SERVER_BACKUP', 'xe');

// set application wide parameters
//$configuration_query = tep_db_query('select configuration_key as cfgKey, configuration_value as cfgValue from ' . TABLE_CONFIGURATION);
//while ($configuration = tep_db_fetch_array($configuration_query)) {
//	define($configuration['cfgKey'], $configuration['cfgValue']);
//}

require(DIR_WS_INCLUDES . 'english.php');

require(DIR_WS_FUNCTIONS . 'validations.php');
require(DIR_WS_FUNCTIONS . 'general.php');
require(DIR_WS_FUNCTIONS . 'html_output.php');

// define how the session functions will be used
require(DIR_WS_FUNCTIONS . 'sessions.php');

// set the session name and save path
tep_session_name('appevolution_service');
tep_session_save_path(SESSION_WRITE_DIRECTORY);

// lets start our session
tep_session_start();

if ( (PHP_VERSION >= 4.3) && function_exists('ini_get') && (ini_get('register_globals') == false) ) {
	extract($_SESSION, EXTR_OVERWRITE+EXTR_REFS);
}

$current_page = basename($PHP_SELF);
if (!tep_session_is_registered('appevolution_admin_userid')) {
	if ($current_page != 'login.php') {
		tep_redirect('login.php');
	}

	unset($redirect);
}

// split-page-results
require(DIR_WS_CLASSES . 'split_page_results.php');

// image manager
require DIR_WS_INCLUDES.'media/media.php';


$g_current_url = explode("/", curPageURL());
$g_Tmpurl = $g_current_url[sizeof($g_current_url) - 1];

// temp
$session_update_role = "on";
?>