<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.seotudy.com
 * @since             1.0.0
 * @package           Seotudy
 *
 * @wordpress-plugin
 * Plugin Name:       Seotudy
 * Plugin URI:        www.seotudy.com/seotudy-download/
 * Description:       All SEO Settings Tool
 * Version:           2.0.2
 * Author:            Seotudy
 * Author URI:        www.seotudy.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       seotudy
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SEOTUDY_PLUGIN_NAME_VERSION', '2.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-seotudy-activator.php
 */
function activate_seotudy() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-seotudy-activator.php';
	Seotudy_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-seotudy-deactivator.php
 */
function deactivate_seotudy() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-seotudy-deactivator.php';
	Seotudy_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_seotudy' );
register_deactivation_hook( __FILE__, 'deactivate_seotudy' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-seotudy.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_seotudy() {

	$plugin = new Seotudy();
	$plugin->run();

}
run_seotudy();
