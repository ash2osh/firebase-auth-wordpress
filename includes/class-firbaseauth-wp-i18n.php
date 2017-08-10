<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://ash2osh.com
 * @since      1.0.0
 *
 * @package    Firbaseauth_Wp
 * @subpackage Firbaseauth_Wp/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Firbaseauth_Wp
 * @subpackage Firbaseauth_Wp/includes
 * @author     ahmed sherif <ash2oshapps@gmail.om>
 */
class Firbaseauth_Wp_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'firbaseauth-wp',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
