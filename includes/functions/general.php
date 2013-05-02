<?php
/*
 $Id: general.php v 1.0 2012/07/10 $

-----------------------------------------------
Copyright (c) 2012 ChengTong-Yilin
http://www.chengtong-yilin.com
-----------------------------------------------
*/

include dirname(__FILE__).'/extends.php';


function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return "" . $pageURL;
}

function tep_sanitize_string($string) {
	//$string = ereg_replace(' +', ' ', $string);

	return preg_replace("/[<>]/", '_', $string);
}

function tep_redirect($url) {
	global $logger;

	if ( (strstr($url, "\n") != false) || (strstr($url, "\r") != false) ) {
		tep_redirect(tep_href_link(FILENAME_DEFAULT, '', 'NONSSL', false));
	}

	header('Location: ' . $url);

	if (STORE_PAGE_PARSE_TIME == 'true') {
		if (!is_object($logger)) $logger = new logger;
		$logger->timer_stop();
	}

	exit;
}

function tep_rand($min = null, $max = null) {
	static $seeded;

	if (!$seeded) {
		mt_srand((double)microtime()*1000000);
		$seeded = true;
	}

	if (isset($min) && isset($max)) {
		if ($min >= $max) {
			return $min;
		} else {
			return mt_rand($min, $max);
		}
	} else {
		return mt_rand();
	}
}

function tep_now_datetime() {
    
	return date('Y-m-d H:i:s');
}

function tep_get_mktime($date) {
	if (strlen($date) < 19) $date = tep_now_datetime();

	$year	= substr($date, 0, 4);
	$month	= substr($date, 5, 2);
	$day	= substr($date, 8, 2);
	$hour	= substr($date, 11, 2);
	$minute = substr($date, 14, 2);
	$second = substr($date, 17, 2);

	return mktime($hour, $minute, $second, $month, $day, $year);
}

function tep_format_time($date, $show_time = false) {
	$date = tep_get_mktime($date);

	$str = date('jS', $date) . " of " . date('F, Y', $date);

	if ($show_time) {
		return date('F j, Y', $date) . " at " . date('H:i', $date);
	} else {
		return date('jS', $date) . " of " . date('F, Y', $date);
	}
}

function tep_cut_str($str, $len, $suffix="...") {
	$s = substr($str, 0, $len);
	$cnt = 0;
	for ($i=0; $i<strlen($s); $i++)
	if (ord($s[$i]) > 127)
	$cnt++;

	$s = substr($s, 0, $len - ($cnt % 3));

	if (strlen($s) >= strlen($str))
	$suffix = "";
	return $s . $suffix;
}

function tep_get_html_data_from_dbdata($str) {
	$result = str_replace("\"", '"', $str);
	$result = str_replace("\'", "'", $result);
	$result = str_replace("\n", "<br/>", $result);
	return $result;
}

function tep_get_htmlstr_to_dbstr($str) {
	return strip_tags(tep_get_html_data_from_dbdata($str));
}

function tep_get_all_get_params($exclude_array = '') {
	global $HTTP_GET_VARS;

	if ($exclude_array == '') $exclude_array = array();

	$get_url = '';
                        
	reset($HTTP_GET_VARS);
	while (list($key, $value) = each($HTTP_GET_VARS)) {
		if (($key != tep_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array))) $get_url .= $key . '=' . $value . '&';
	}

	return $get_url;
}

function tep_format_path($path) {
	$path = str_replace(' ', '-', $path);

	$path = urlencode($path);

	$chars = "abcdefghigjklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_.@";
	$result = "";
	for ($c = 0; $c < strlen($path); $c ++) {
		$temp_c = substr($path, $c, 1);
		if (strpos($chars, $temp_c) === false) {
			continue;
		} else {
			$result .= $temp_c;
		}
	}

	return strtolower($result);
}

function tep_success_redirect($msg = "Success process!", $href = "") {
	echo '<div class="success_process success">'.$msg.'</div>';

	if ($href != "") {
		echo '<div style="padding-left: 30px;">please wait while your changes are saved<br/><br/><br/></div></div></div><div class="clear"></div>';
		echo '<script language="javascript">setTimeout("document.location.href=\''.$href.'\'", 1500)</script>';

		exit(0);
	}

	echo '</div></div><div class="clear"></div>';
}

function tep_error_redirect($msg = "Access denifined!", $href = "index.php") {
	echo '<div class="error_process">'.$msg.'</div>';

	if ($href != "") {
		echo '<div style="padding-left: 30px;">please wait while your changes are saved</div></div></div><div class="clear"></div>';
		echo '<script language="javascript">setTimeout("document.location.href=\''.$href.'\'", 1500)</script>';

		exit(0);
	}

	echo '</div></div><div class="clear"></div>';
}

function tep_generator_password($pw_length = 8, $use_caps = true, $use_numeric = true, $use_specials = true) {
	$caps = array();
	$numbers = array();
	$num_specials = 0;
	$reg_length = $pw_length;
	$pws = array();
	for ($ch = 97; $ch <= 122; $ch++) $chars[] = $ch; // create a-z
	if ($use_caps) for ($ca = 65; $ca <= 90; $ca++) $caps[] = $ca; // create A-Z
	if ($use_numeric) for ($nu = 48; $nu <= 57; $nu++) $numbers[] = $nu; // create 0-9
	$all = array_merge($chars, $caps, $numbers);
	if ($use_specials) {
		$reg_length =  ceil($pw_length*0.75);
		$num_specials = $pw_length - $reg_length;
		if ($num_specials > 5) $num_specials = 5;
		for ($si = 33; $si <= 47; $si++) $signs[] = $si;
		$rs_keys = array_rand($signs, $num_specials);
		foreach ($rs_keys as $rs) {
			$pws[] = chr($signs[$rs]);
		}
	}
	$rand_keys = array_rand($all, $reg_length);
	foreach ($rand_keys as $rand) {
		$pw[] = chr($all[$rand]);
	}
	$compl = array_merge($pw, $pws);
	shuffle($compl);
	return implode('', $compl);
}

function tep_parse_input_field_data($data, $parse) {
	return strtr(trim($data), $parse);
}

function tep_output_string($string, $translate = false, $protected = false) {
	if ($protected == true) {
		return htmlspecialchars($string);
	} else {
		if ($translate == false) {
			return tep_parse_input_field_data($string, array('"' => '&quot;'));
		} else {
			return tep_parse_input_field_data($string, $translate);
		}
	}
}

function tep_phpmail($toname, $to, $subject, $body, $froname = EMAIL_ADMIN_NAME, $from = EMAIL_ADMIN_ADRESS, $chaset = 'UTF-8') {
	require_once(DIR_WS_CLASSES.'class.phpmailer.php');

	$body.= "<br /><br />";
	$body.= "Thanks.<br />";
	$body.= "From ".SITE_TITLE."<br/>";
	$body.= "Sended ".date('H:i d/m/Y')."<br/>";
	
	$mail             = new PHPMailer();
	$mail->From       = $from;
	$mail->FromName   = $froname;

	if (is_array($to)) {
		for ($i = 0; $i < count($to); $i ++) {
			$mail->AddAddress($to[$i],  $toname[$i]);
		}
	} else {
		$mail->AddAddress($to,  $toname);
	}

	$mail->Subject    = $subject;
	$mail->Body       = $body;
	$mail->IsHTML(true);
	$mail->CharSet    = $chaset;

	if (!$mail->Send()) {
		$err = $mail->ErrorInfo;
		
		if ($err == '') {
			return true;
		}
		
		$err = str_replace("\"", "", $err);
		$err = str_replace("'", "", $err);

		return false; //"An error occurred while sending email!<br>$err";
	} else {
		
		return true;;
	}
}

function tep_remove_all( $path )
{
	if( is_file($path) )
	{
		@unlink($path);
	}
	elseif( is_dir($path) )
	{
		$dir = opendir($path);
		while ($file = readdir($dir))
		{
			if( $file!="." && $file!=".." )
			{
				/* remove all recursively */
				tep_remove_all($path."/".$file);
			}
		}
		closedir($dir);
		@rmdir($path);
	}
	else
	{
		return FALSE;
	}
}



/**
 * Check value to find if it was serialized.
 *
 * If $data is not an string, then returned value will always be false.
 * Serialized data is always a string.
 *
 * @since 2.0.5
 *
 * @param mixed $data Value to check to see if was serialized.
 * @return bool False if not serialized and true if it was.
 */
function is_serialized( $data ) {
	// if it isn't a string, it isn't serialized
	if ( ! is_string( $data ) )
	return false;
	$data = trim( $data );
	if ( 'N;' == $data )
	return true;
	$length = strlen( $data );
	if ( $length < 4 )
	return false;
	if ( ':' !== $data[1] )
	return false;
	$lastc = $data[$length-1];
	if ( ';' !== $lastc && '}' !== $lastc )
	return false;
	$token = $data[0];
	switch ( $token ) {
		case 's' :
			if ( '"' !== $data[$length-2] )
			return false;
		case 'a' :
		case 'O' :
			return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
		case 'b' :
		case 'i' :
		case 'd' :
			return (bool) preg_match( "/^{$token}:[0-9.E-]+;\$/", $data );
	}
	return false;
}

/**
 * Serialize data, if needed.
 *
 * @since 2.0.5
 *
 * @param mixed $data Data that might be serialized.
 * @return mixed A scalar data
 */
function maybe_serialize( $data ) {
	if ( is_array( $data ) || is_object( $data ) )
	return serialize( $data );

	// Double serialization is required for backward compatibility.
	// See http://core.trac.wordpress.org/ticket/12930
	if ( is_serialized( $data ) )
	return serialize( $data );

	return $data;
}

/**
 * Unserialize value only if it was serialized.
 *
 * @since 2.0.0
 *
 * @param string $original Maybe unserialized original, if is needed.
 * @return mixed Unserialized data can be any type.
 */
function maybe_unserialize( $original ) {
	if ( is_serialized( $original ) ) // don't attempt to unserialize data that wasn't serialized going in
	return @unserialize( $original );
	return $original;
}

function tep_trim($value) {
	return trim($value, " \t\r\n");
}

function tep_get_message($msg, $value1 = "", $value2 = "", $value3 = "", $value4 = "", $value5 = "") {
	global $SYSTEM_MESSAGE;
	if (isset($SYSTEM_MESSAGE[$msg])) {
		$msg = $SYSTEM_MESSAGE[$msg];
	}
	return sprintf ($msg, $value1, $value2, $value3, $value4, $value5);
}

function tep_get_value_post($key, $name = "", $validations = '', $prepare = true) {
	global $HTTP_POST_VARS;

	$value = "";

	if (isset($HTTP_POST_VARS[$key])) {
		if ($prepare) {
			$value = tep_db_prepare_input($HTTP_POST_VARS[$key]);

			if (!is_array($value)) {
				$value = tep_trim($value);
			}
		} else {
			$value = $HTTP_POST_VARS[$key];
		}
	}
	
	tep_validations($key, $value, $validations, $name);

	return $value;
}

function tep_get_value_get($key, $name = "", $validations = '', $prepare = true) {
	global $HTTP_GET_VARS;

	$value = "";
	if (isset($HTTP_GET_VARS[$key])) {
		if ($prepare) {
			$value = tep_db_prepare_input($HTTP_GET_VARS[$key]);

			if (!is_array($value)) {
				$value = tep_trim($value);
			}
		} else {
			$value = $HTTP_GET_VARS[$key];
		}
	}

	tep_validations($key, $value, $validations, $name);

	return mysql_real_escape_string($value);
}

function tep_get_value_require($key, $name = "", $validations = '', $prepare = true) {
	global $_REQUEST;

	$value = "";
	if (isset($_REQUEST[$key])) {
		if ($prepare) {
			$value = tep_db_prepare_input($_REQUEST[$key]);
				
			$value = tep_trim($value);
		} else {
			$value = $_REQUEST[$key];
		}
	}

	tep_validations($key, $value, $validations, $name);

	return str_replace("'", "''", $value);
}

function tep_get_countries($type = 2) {
	$temp = tep_db_query("select sql_cache * from " . TABLE_COUNTRIES . " order by countries_name");

	$countries = array();

	while ($country = tep_db_fetch_array($temp)) {
		if ($type == 1) {
			$countries[$country['countries_id']]=$country['countries_name'];
		} elseif ($type == 2) {
			$countries[$country['countries_iso_code_2']]=$country['countries_name'];
		} elseif ($type == 3) {
			$countries[$country['countries_iso_code_3']]=$country['countries_name'];
		}
	}

	return $countries;
}

function tep_get_after_date_time($regdate) {
	$diff = strtotime("now") - strtotime($regdate) + 1; //Find the number of seconds
	$day_difference = ceil($diff / (60*60*24)) ;  //Find how many days that is
	$hour_difference = ceil($diff / (60*60)) ;
	$minute_difference = ceil($diff / 60) ;
	
	$after_date = "";
	if($day_difference <= 1) {
		if ($hour_difference <= 1) {
			$after_date = "about ". $minute_difference." minutes ago";
		} else {
			$after_date = "about ". $hour_difference." hours ago";
		}
	} elseif($day_difference <= 4) {
		$after_date = substr($regdate, 11, 5)." Yesterday";
	} else {
		$after_date = tep_get_format_datetime($regdate);
	}
	
	return $after_date;
}

function tep_get_after_date($regdate) {
	$diff = strtotime("now") - strtotime($regdate) + 1; //Find the number of seconds
	$day_difference = ceil($diff / (60*60*24)) ;  //Find how many days that is
	$hour_difference = ceil($diff / (60*60)) ;
	$minute_difference = ceil($diff / 60) ;

	$after_date = "";
	if($day_difference <= 1) {
		$after_date = "Today";
	} elseif($day_difference <= 2) {
		$after_date = "Yesterday";
	} elseif($day_difference <= 7) {
		$after_date = $day_difference." days ago";
	} else {
		$after_date = tep_get_format_datetime($regdate);
	}

	return $after_date;
}

function tep_get_format_date($date) {
	$date = new DateTime($date);

	return $date->format("l F jS, Y / H:i");
}

function tep_get_format_datetime($date) {
	$date = new DateTime(substr($date, 0,19));
	//return $date->format("F j, Y h:i A");
	
	return $date->format("h:i m/d/Y");
}

function tep_get_startdate_of_week($totime, $format = 'Y-m-d')
{
	$Time = explode(" ", $totime);
	$s = mktime(0,0,0, date("m",$Time[1]), date("d",$Time[1]) - date("w",$Time[1]) +1, date("Y",$Time[1]));
	$e = mktime(0,0,0, date("m",$Time[1]), date("d",$Time[1]) - date("w",$Time[1]) +7, date("Y",$Time[1]));
	$begin = date($format, $s);
	$end = date($format, $e);

	return $begin;
}

function tep_get_enddate_of_week($totime, $format = 'Y-m-d')
{
	$Time = explode(" ", $totime);
	$s = mktime(0,0,0, date("m",$Time[1]), date("d",$Time[1]) - date("w",$Time[1]) +1, date("Y",$Time[1]));
	$e = mktime(0,0,0, date("m",$Time[1]), date("d",$Time[1]) - date("w",$Time[1]) +7, date("Y",$Time[1]));
	$begin = date($format, $s);
	$end = date($format, $e);

	return $end;
}

function tep_is_ie() {
	$brower =  strtolower($_SERVER['HTTP_USER_AGENT']);
	
	$strpos = strpos($brower, 'msie');
	if ($strpos === false) {
		return false;
	} else {
		return true;
	}
}

function iphone_push_notification($deviceToken, $alert, $badge=0, $sound = "default")
{
	if ($deviceToken == '') return FALSE;
	if (strlen($alert) == 0) {
		return FALSE;
	}
	
	$deviceToken = pack('H*', $deviceToken);
	
	$tmp = array();
	if($alert)
	{
		$tmp['alert'] = $alert;
	}
	if($badge > 0)
	{
		$tmp['badge'] = $badge;
	}
	if($sound != '')
	{
		$tmp['sound'] = $sound;
	}
	$body['aps'] = $tmp;
	//$body[$custom_key] = $custom_value;
	
	$push_method = PUSH_NOTIFICATION;
	if (PUSH_NOTIFICATION == "develop") {
		$certFile=PUSH_NOTIFICATION_DEVELOP_PEM_FILE;
		$certPass=PUSH_NOTIFICATION_DEVELOP_PEM_PASS;
	} else {
		$certFile=PUSH_NOTIFICATION_PRODUCT_PEM_FILE;
		$certPass=PUSH_NOTIFICATION_PRODUCT_PEM_PASS;
	}
	
	$ctx = stream_context_create();
	stream_context_set_option($ctx, 'ssl', 'local_cert', $certFile);
	stream_context_set_option($ctx, 'ssl', 'passphrase', $certPass);

	if ( $push_method == 'develop' )
		$ssl_gateway_url = 'ssl://gateway.sandbox.push.apple.com: 2195';
	else if ( $push_method == 'live' )
		$ssl_gateway_url = 'ssl://gateway.push.apple.com: 2195';

	if(isset($certFile) && isset($ssl_gateway_url))
	{
		$fp = stream_socket_client($ssl_gateway_url, $err, $errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
	}
	if(!$fp)
	{
		//print "Connection failed $err $errstr\n";
		return FALSE;
	}
	$payload = json_encode($body);
	$msg = chr(0).chr(0).chr(32).$deviceToken.chr(0).chr(strlen($payload)).$payload;
	fwrite($fp, $msg);
	fclose($fp);

	return TRUE;
}

function android_push_notification($a) {
	// 아래는 기본 폼이지만 몇가지 개발자에게 맞춰야 하는 것이 있다.
	$accountType = "HOSTED_OR_GOOGLE";
	// 앱에서 Registration ID를 얻기 위해 기입했던 개발자의 구글 계정
	$Email = "ID@gmail.com";
	// 그 계정의 비밀번호
	$Passwd = "password";
	$source = "test-1.0";
	$service = "ac2dm";
	// 앱에서 서버로 전송할 때 사용했던 Registration ID
	$registration_id = RegistrationIDFromDB();
	
	$ch = curl_init();
	// 아래 부분은 Sender Auth Token을 얻는 부분이다.
	curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$account_info = array("accountType" => $accountType, "Email" => $Email, "Passwd" => $Passwd, "source" => $source, "service" => $service);
	
	curl_setopt($ch, CURLOPT_POSTFIELDS, $account_info);
	
	$response = curl_exec($ch);
	$auth_tmp = substr(strstr($response, "Auth="), 5);
	$auth = substr($auth_tmp, 0, strlen($auth_tmp)-1);
	// collapse_key 는 메세지를 식별하기 위해 쓰이는 것 같으나 정확한 것은 아직 알지 못했다.
	$collapse_key = 2;
	// 사용자 기기로 전달할 메세지와 기타 데이터를 나열한다. registration_id와 collapse_key는 필수이나 data에 해당하는 부분은 선택사항이다.
	$data = "registration_id=".$registration_id."&collapse_key=".$collapse_key."&data.answerer=$answerer&data.no=$no";
	// 만약 data로 한글을 전달하고 싶은데 막상 단말에서 받았을 때 값이 없거나 알 수 없는 문자가 입력된다면 다음과 같이 해보라.
	// "&data.answerer='관리자'"
	// "&data.answerer=".urlencode("관리자")."
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	
	$headers = array(
			"Content-Type: application/x-www-form-urlencoded",
			"Content-Length: ".strlen($data),
			"Authorization: GoogleLogin auth=".$auth
	);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://android.apis.google.com/c2dm/send");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$result = curl_exec($ch);
	curl_close($ch);
}
?>