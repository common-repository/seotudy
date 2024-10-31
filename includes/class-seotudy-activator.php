<?php

/**
 * Fired during plugin activation
 *
 * @link       www.webtures.com.tr
 * @since      1.0.0
 *
 * @package    Seotudy
 * @subpackage Seotudy/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Seotudy
 * @subpackage Seotudy/includes
 * @author     Webtures A.Ş <hasan.yuksektepe@webtures.com>
 */
class Seotudy_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		/*
		global $wpdb;
		
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		
		//404 SQL INSTALL
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "DROP TABLE IF EXISTS `seotudy_404`;
        CREATE TABLE IF NOT EXISTS `seotudy_404` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `link` varchar(255) NOT NULL,
          `new_link` varchar(255) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
        COMMIT;";
        dbDelta( $sql );
		//404 SQL INSTALL
		
		
		//REDIRECTS SQL INSTALL
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "DROP TABLE IF EXISTS `seotudy_redirects`;
        CREATE TABLE IF NOT EXISTS `seotudy_404` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `link` varchar(255) NOT NULL,
          `new_link` varchar(255) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
        COMMIT;";
        dbDelta( $sql );
		//REDIRECTS SQL INSTALL
		*/
	}

}
