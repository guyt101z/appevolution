<?php
$configurations = tep_db_query("select * from " . TABLE_CONFIGURATIONS);
while($config = tep_db_fetch_array($configurations)) {
	define($config['config_name'], $config['config_value']);
}
?>