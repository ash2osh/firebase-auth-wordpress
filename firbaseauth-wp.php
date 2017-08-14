<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://ash2osh.com
 * @since             1.0.0
 * @package           Firbaseauth_Wp
 *
 * @wordpress-plugin
 * Plugin Name:       firebase wordpress auth
 * Plugin URI:        http://ash2osh.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            ahmed sherif
 * Author URI:        http://ash2osh.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       firbaseauth-wp
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-firbaseauth-wp-activator.php
 */
function activate_firbaseauth_wp() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-firbaseauth-wp-activator.php';
    Firbaseauth_Wp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-firbaseauth-wp-deactivator.php
 */
function deactivate_firbaseauth_wp() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-firbaseauth-wp-deactivator.php';
    Firbaseauth_Wp_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_firbaseauth_wp');
register_deactivation_hook(__FILE__, 'deactivate_firbaseauth_wp');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-firbaseauth-wp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_firbaseauth_wp() {

    $plugin = new Firbaseauth_Wp();
    $plugin->run();
}

run_firbaseauth_wp();

//setting using the generator from http://wpsettingsapi.jeroensormani.com/
require_once plugin_dir_path(__FILE__) . 'includes/settings.php';




