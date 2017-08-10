<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ash2osh.com
 * @since      1.0.0
 *
 * @package    Firbaseauth_Wp
 * @subpackage Firbaseauth_Wp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Firbaseauth_Wp
 * @subpackage Firbaseauth_Wp/public
 * @author     ahmed sherif <ash2oshapps@gmail.om>
 */
class Firbaseauth_Wp_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Firbaseauth_Wp_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Firbaseauth_Wp_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/firbaseauth-wp-public.css', array(), $this->version, 'all');
        wp_enqueue_style('firebaseui-css', 'https://cdn.firebase.com/libs/firebaseui/2.3.0/firebaseui.css');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Firbaseauth_Wp_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Firbaseauth_Wp_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/firbaseauth-wp-public.js', array('jquery'), $this->version, false);
        wp_enqueue_script('firebasejs', 'https://www.gstatic.com/firebasejs/4.2.0/firebase.js');
        wp_enqueue_script('firebaseui-js', 'https://cdn.firebase.com/libs/firebaseui/2.3.0/firebaseui.js');



        /*
         * var url = WPURLS.siteurl;
         * https://stackoverflow.com/questions/5221630/wordpress-path-url-in-js-script-file
         */
        wp_localize_script($this->plugin_name, 'WPURLS', array('siteurl' => get_option('siteurl')));
    }

}
