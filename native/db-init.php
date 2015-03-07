<?php
//init model
//WP
global $wpdb;
//User define
//define('QD_TABLE_PREFIX', 'qd_');
//define('QD_STUDENT_TABLE', $wpdb->prefix . QD_TABLE_PREFIX . 'hocsinh');
//define('QD_LOP_TABLE', $wpdb->prefix . QD_TABLE_PREFIX . 'lop');
//define('QD_OPTION_TABLE', $wpdb->prefix . QD_TABLE_PREFIX . 'option');
//register_activation_hook(QD_FILE, 'qd_create_plugin_tables' );
function qd_create_plugin_tables()
{
	global $wpdb;
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	/*
	$table_name = QD_STUDENT_TABLE;
	
	//student
    $sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      name varchar(255) DEFAULT NULL,
	  lop_id int(11) DEFAULT NULL,
      date_create datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      date_modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
      UNIQUE KEY id (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
	dbDelta( $sql );
	//class
	$table_name = QD_LOP_TABLE;
	$sql = "CREATE TABLE $table_name (
      id int(11) NOT NULL AUTO_INCREMENT,
      name varchar(255) DEFAULT NULL,
	  parent_id int(11) DEFAULT NULL,
      UNIQUE KEY id (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
	dbDelta( $sql );
    //option
	$table_name = QD_OPTION_TABLE;
	$sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
      `id` int(11) NOT NULL,
      `key` varchar(100) NOT NULL,
      `value` text,
      PRIMARY KEY (`id`),
      UNIQUE KEY `key` (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
	dbDelta( $sql );
	*/
}