<?php

/**
 * Fired during plugin deactivation
 *
 * @link       www.webtures.com.tr
 * @since      1.0.0
 *
 * @package    Seotudy
 * @subpackage Seotudy/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Seotudy
 * @subpackage Seotudy/includes
 * @author     Webtures A.Ş <hasan.yuksektepe@webtures.com>
 */
class Seotudy_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		delete_option('seotudy_googleAnalyticCode');
		delete_option('seotudy_googleSCCode');
		delete_option('seotudy_yandexMetrica');
		delete_option('seotudy_wordpressSsl');
		delete_option('seotudy_titleAndDescActive');
		delete_option('seotudy_autoSefName');
		delete_option('seotudy_autoAlt');
		delete_option('seotudy_wpjson');
		delete_option('seotudy_post_title');
		delete_option('post_desc');
		
	}

}
