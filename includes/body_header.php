<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?=SITE_TITLE?></title>
	<meta content="utf8" http-equiv="Content-Language" />

	<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/jquery_ui/jquery-ui-1.8.16.custom.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/jquery_ui/jquery-ui-timepicker-addon.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/jquery_ui/validationEngine.jquery.css' type='text/css'/>
	
	<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/wp-admin.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/colors-fresh.css' type='text/css' media='all' />
	<link rel='stylesheet' href='<?=HTTP_CATALOG_SERVER?>static/css/global.css' type='text/css' />
	
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/jquery/jquery-1.6.2.min.js'></script>
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/jquery/jquery-ui-1.8.16.custom.min.js'></script>
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/jquery/jquery-ui-timepicker-addon.js'></script>
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/jquery/jscript_jquery.validationEngine-en.js'></script>
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/jquery/jscript_jquery.validationEngine.js'></script>
	<!-- <script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/jquery/check_lib.js'></script> -->
	<!-- <script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/hoverIntent.js'></script> -->
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/general.js'></script>
	<script type='text/javascript'>
	/* <![CDATA[ */
		userSettings = {
			url: "/",
			uid: "1",
			time: "1235955367"
		}

		base_url = "<?=HTTP_CATALOG_SERVER?>";
	/* ]]> */
	</script>
	<script type='text/javascript' src='<?=HTTP_CATALOG_SERVER?>static/js/common.js'></script>
</head>
<body class="wp-admin ">

<div id="wpwrap">
	<div id="wpcontent">
	<?php
		$store_name = STORE_OWNER;
	?>
		<div id="wphead">
			<h1 >
				<font color=#ffffff>
					<?=SITE_TITLE?> Dashboard
				<?php if ($appevolution_admin_usertype == 'venue' && !isset($selected_venue)) {
					$selected_venue = teb_one_query(TABLE_ADS, array("ad_id"=>$appevolution_venueid));
					echo " : @".$selected_venue['ad_name'];	
				} 
				?>
				</font>
			</h1>
			<div id="wphead-info">
				<div id="user_info">
			    	<span></span>
			    	<p>
			    	<?php if ($appevolution_admin_usertype == 'venue' && teb_query("select count(*) as data_count from ".TABLE_ADS_USERS." where user_id='".$appevolution_admin_userid."'", "data_count") > 1):?>
			    		<a href="#" title="Select Venue" onclick="show_my_venues()">Venues</a> |&nbsp; 
			    	<?php endif;?>
			    		<a href="edit_profile.php" title="Edit Profile"><?=$appevolution_admin_username?></a> | <a href="logout.php" title="Log Out">Logout</a>
			    	</p>
			    </div>
			</div>
		</div>
		
		<div id="wpbody">
			<?php require(DIR_WS_INCLUDES . 'left_menu_administrator.php'); ?>
			
			<div id="wpbody-content" >
				<div class="wrap">
					<span style="font-size: 31px; line-height: 31px;"><?= $titlex?></span>
				</div>
				<div class="clear" style="padding-left:10px;">