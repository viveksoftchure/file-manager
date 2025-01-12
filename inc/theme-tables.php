<?php

/**
 * Theme support functions
 *
 * @package file-manager
 */

function create_theme_tables() {
    global $wpdb;
    $table_name1 = $wpdb->prefix . 'fm_file';
    $table_name2 = $wpdb->prefix . 'fm_folder';

    $charset_collate = $wpdb->get_charset_collate();

    $sql1 = "CREATE TABLE $table_name1 (
        id_file int(11) NOT NULL AUTO_INCREMENT,
        id_user int(11) NOT NULL,
        id_folder int(11) NOT NULL,
        status varchar(255) NULL DEFAULT NULL,
        trash tinyint(1) NOT NULL,
        title text NULL DEFAULT NULL,
        ext text NULL DEFAULT NULL,
        description text NULL DEFAULT NULL,
        note text NULL DEFAULT NULL,
        created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime NULL DEFAULT NULL,
        PRIMARY KEY  (id_file)
    ) $charset_collate;";

    $sql2 = "CREATE TABLE $table_name2 (
        id_folder int(11) NOT NULL AUTO_INCREMENT,
        id_user int(11) NOT NULL,
        id_parent int(11) NOT NULL,
        unique_key varchar(26) NOT NULL,
        status varchar(255) NULL DEFAULT NULL,
        trash tinyint(1) NOT NULL,
        title varchar(255) NULL DEFAULT NULL,
        description text NULL DEFAULT NULL,
        image varchar(255) NULL DEFAULT NULL,
        bg_color varchar(11) NULL DEFAULT NULL,
        back_color varchar(11) NULL DEFAULT NULL,
        created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime NULL DEFAULT NULL,
        PRIMARY KEY  (id_folder)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql1);
    dbDelta($sql2);
}
add_action("after_switch_theme", "create_theme_tables");