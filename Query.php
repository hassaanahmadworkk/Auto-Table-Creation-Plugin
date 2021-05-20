<?php
	global $jlss_twilio_messages_db_version;
		   $jlss_twilio_messages_db_version = '1.1'; // version changed from 1.0 to 1.1
		   register_activation_hook(__FILE__, 'jlss_twilio_messages_plugin_install');
		   register_deactivation_hook( __FILE__, 'jlss_twilio_messages_deactivate' );
		   add_action('plugins_loaded', 'jlss_twilio_messages_update_check');
	if (!function_exists('jlss_twilio_messages_plugin_install')) {
			function jlss_twilio_messages_plugin_install()
			{
			    global $wpdb;
			    global $jlss_twilio_messages_db_version;
			    $jlss_twilio_messages_table = $wpdb->prefix . 'jlss_twilio_messages';
			     $sql = "CREATE TABLE " . $jlss_twilio_messages_table . " (
			     MessageSid VARCHAR(34) NOT NULL UNIQUE,
			     SmsSid VARCHAR(34) NOT NULL,
			     AccountSid VARCHAR(34) NOT NULL,
			     MessagingServiceSid VARCHAR(34) NOT NULL,
			     MessageFrom VARCHAR(15) NOT NULL,
			     MessageTo VARCHAR(15) NOT NULL,
			     Body VARCHAR(255) NULL ,
			     NumMedia int(25) NULL,
			     MediaContentType varchar(255) NULL,
			     MediaUrl varchar(255) NULL,
			     PRIMARY KEY  (MessageSid)
			     );
			     ENGINE = INNODB
			     DEFAULT CHARACTER SET = utf8
			     COLLATE = utf8_general_ci" ;
			     require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			     dbDelta($sql);
			     add_option('jlss_twilio_messages_db_version', $jlss_twilio_messages_db_version);
			 }
	}
	if (!function_exists('jlss_twilio_messages_update_check')) {
		function jlss_twilio_messages_update_check()
		{
			global $jlss_twilio_messages_db_version;
			if (get_site_option('jlss_twilio_messages_db_version') != $jlss_twilio_messages_db_version) {
				es_manage_record_plugin_install();
			}
		}
	}
	if (!function_exists('jlss_twilio_messages_deactivate')) {
		function jlss_twilio_messages_deactivate(){
			global $wpdb;
			$jlss_twilio_messages_table = $wpdb->prefix . 'jlss_twilio_messages';
			$wpdb->query( "DROP TABLE IF EXISTS $jlss_twilio_messages_table" );
		}
	}
