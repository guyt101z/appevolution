<?php
require('../includes/application_top.php');

tep_session_unregister('appevolution_admin_userid');
tep_session_unregister('appevolution_admin_username');
?>

<p></p>
<p></p>
<p></p>
<p></p>
<p></p>

<CENTER>Please wait .......</CENTER>

<script type="text/javascript">
<!--
setTimeout("document.location.href='<?php echo tep_href_link("admin/login	.php")?>'", 500);
//-->
</script>
