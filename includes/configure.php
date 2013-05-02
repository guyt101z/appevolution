<?php
define('HTTP_SERVER', "http://".$_SERVER["SERVER_NAME"]);
define('HTTP_CATALOG_SERVER', HTTP_SERVER."/appevolution/");
//define('HTTP_CATALOG_SERVER', HTTP_SERVER."/");

define('DIR_WS_INCLUDES', DIR_FS_DOCUMENT_ROOT . 'includes/');
define('DIR_WS_FUNCTIONS', DIR_FS_DOCUMENT_ROOT  . 'includes/functions/');
define('DIR_WS_CLASSES',  DIR_FS_DOCUMENT_ROOT .  'includes/classes/');
define('DIR_WS_BOX',  DIR_FS_DOCUMENT_ROOT .  'includes/box/');
define('CACHE_DIR', DIR_WS_INCLUDES . 'cache/');

define('HTTP_WS_STATIC',  HTTP_CATALOG_SERVER .  'static/');
define('HTTP_WS_VIDEOS',  HTTP_WS_STATIC .  'videos/');
define('HTTP_WS_IMAGES',  HTTP_WS_STATIC .  'images/');

//Database Setting
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'root');
define('DB_SERVER_PASSWORD', '');
define('DB_DATABASE', 'appevolution');

/*
define('DB_SERVER', 'db434123670.db.1and1.com');
define('DB_SERVER_USERNAME', 'dbo434123670');
define('DB_SERVER_PASSWORD', 'djajsl123');
define('DB_DATABASE', 'db434123670');
*/

define('USE_PCONNECT', 'false');
define('STORE_SESSIONS', 'mysql');
define('CHARSET','utf8');

define('EMAIL_TYPE', 'sendmail'); // "mail", "sendmail", or "smtp"
//define('SNED_EMAIL_PATH', 'D:/xampp/htdocs/appevolution/test/sendmail/sendmail -t');
define('SNED_EMAIL_PATH', 'usr/sbin/sendmail -t -i');
define('EMAIL_ADMIN_NAME', 'Admin');
define('EMAIL_ADMIN_ADDRESS', 'info@appevolution.com/'); // cy8Hdrzv$Qu]

/* upload file */
define('DIR_WS_UPLOAD',  DIR_FS_DOCUMENT_ROOT .  'upload/');
define('HTTP_WS_UPLOAD',  HTTP_CATALOG_SERVER .  'upload/');

/* template screensort */
define('SESSION_WRITE_DIRECTORY', DIR_WS_INCLUDES . 'cache/');

// Password Min, Max Length

define('USER_PASSWORD_MIN_LENGTH', 8);
define('USER_PASSWORD_MAX_LENGTH', 30);

define("VENUE_QRCODE_BASIC_URL", HTTP_CATALOG_SERVER."qr/");

define('DEFAULT_MALE_AVATAR', HTTP_WS_UPLOAD."avatar/male_avatar.png");
define('DEFAULT_FEMALE_AVATAR', HTTP_WS_UPLOAD."avatar/female_avatar.png");
?>