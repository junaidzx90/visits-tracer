<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.fiverr.com/junaidzx90
 * @since             1.0.0
 * @package           Visits_Tracer
 *
 * @wordpress-plugin
 * Plugin Name:       Visits Tracer
 * Plugin URI:        https://www.fiverr.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.1
 * Author:            Developer Junayed
 * Author URI:        https://www.fiverr.com/junaidzx90
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       visits-tracer
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
header("Cache-Control: no-cache");
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'VISITS_TRACER_VERSION', '1.0.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-visits-tracer-activator.php
 */
function activate_visits_tracer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-visits-tracer-activator.php';
	Visits_Tracer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-visits-tracer-deactivator.php
 */
function deactivate_visits_tracer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-visits-tracer-deactivator.php';
	Visits_Tracer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_visits_tracer' );
register_deactivation_hook( __FILE__, 'deactivate_visits_tracer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-visits-tracer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_visits_tracer() {

	$plugin = new Visits_Tracer();
	$plugin->run();

}
run_visits_tracer();
