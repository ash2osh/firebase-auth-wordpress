<?php

require __DIR__ . '/../vendor/autoload.php';

use Firebase\Auth\Token\Verifier;

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
        wp_enqueue_script('firebasejs', 'https://www.gstatic.com/firebasejs/4.2.0/firebase.js');
        wp_enqueue_script('firebaseui-js', 'https://cdn.firebase.com/libs/firebaseui/2.3.0/firebaseui.js');


        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/firbaseauth-wp-public.js', array('jquery'), $this->version, false);

        /*
         * var url = PHPVAR.siteurl;
         * https://stackoverflow.com/questions/5221630/wordpress-path-url-in-js-script-file
         */
        $options = get_option('fawp_settings');
        $php_vars = array(
            'siteurl' => get_option('siteurl'),
            'islogged' => is_user_logged_in(),
            'fireconfig' => json_decode($this->fix_json($options['fawp_textarea_field_0'])),
            'authurl' => $options['fawp_select_field_5'],
            'authproviders' => array(
                isset($options['fawp_checkbox_field_1']) ? $options['fawp_checkbox_field_1'] : 0,
                 isset($options['fawp_checkbox_field_2']) ? $options['fawp_checkbox_field_2'] : 0,
                isset($options['fawp_checkbox_field_3']) ? $options['fawp_checkbox_field_3'] : 0,
                isset($options['fawp_checkbox_field_4']) ? $options['fawp_checkbox_field_4'] : 0,
                )
        );
        wp_localize_script($this->plugin_name, 'PHPVAR', $php_vars);
    }

    private function fix_json($j) {
        $j = trim($j);
        $j = ltrim($j, '(');
        $j = rtrim($j, ')');
        $a = preg_split('#(?<!\\\\)\"#', $j);
        for ($i = 0; $i < count($a); $i += 2) {
            $s = $a[$i];
            $s = preg_replace('#([^\s\[\]\{\}\:\,]+):#', '"\1":', $s);
            $a[$i] = $s;
        }
        //var_dump($a);
        $j = implode('"', $a);
        //var_dump( $j );
        return $j;
    }

    public function fireauth_signin_short() {
        $HTML = file_get_contents('partials/fireauth_login.php', TRUE);
        return $HTML;
    }

    public function parse_signin_page_request() {
        $options = get_option('fawp_settings');
        $authurl = $options['fawp_select_field_5'];
        if (is_page($authurl)) {
            if (!is_user_logged_in()) {
                if (isset($_GET['tokken']) && $_GET['tokken']) {
                    $projectId = 'testing-efcb1';
                    $verifier = new Verifier($projectId);
                    $idTokenString = $_GET['tokken'];
                    $uid = '';
                    try {
                        $verifiedIdToken = $verifier->verifyIdToken($idTokenString);

                        $uid = $verifiedIdToken->getClaim('sub'); // "a-uid"
                        $email = $verifiedIdToken->getClaim('email');
                        $uname = $verifiedIdToken->getClaim('name');
                    } catch (\Firebase\Auth\Token\Exception\ExpiredToken $e) {
                        echo $e->getMessage();
                    } catch (\Firebase\Auth\Token\Exception\IssuedInTheFuture $e) {
                        echo $e->getMessage();
                    } catch (\Firebase\Auth\Token\Exception\InvalidToken $e) {
                        echo $e->getMessage();
                    }

                    if ($uid) {
                        global $wpdb;
                        $user_id = $wpdb->get_var("SELECT user_id FROM " . $wpdb->prefix . "fireauth_users where uid=" . $uid);
                        if ($user_id) { //user exists sign him in
                            wp_set_auth_cookie($user_id, TRUE);
                        } else {//create user and add him fireath users
                            $user = get_user_by('email', $email);
                            if ($user) {//if user email already registered
                                $user_id = $user->ID;
                            } else {
                                $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                                $userdata = array(
                                    'user_login' => $email,
                                    'display_name' => $uname,
                                    'user_email' => $email,
                                    'user_pass' => $random_password  // when not passing one it creates it automatically
                                );
                                //insert the user
                                $user_id = wp_insert_user($userdata);
                            }

                            //check for errors
                            if (!is_wp_error($user_id)) {
                                $wpdb->insert(
                                        $wpdb->prefix . 'fireauth_users', array(
                                    'user_id' => $user_id,
                                    'uid' => $uid
                                        )
                                );
                                wp_set_auth_cookie($user_id, TRUE);
                            }
                        }
                        wp_redirect(home_url());
                    }
                }
            } else {
                wp_redirect(home_url());
            }
        }
    }

    public function logout_redirect() {
        wp_redirect(site_url());
        exit;
    }

    public function login_redirect($login_url, $redirect, $force_reauth) {
        $options = get_option('fawp_settings');
        $authurl = $options['fawp_select_field_5'];
        $override = isset($options['fawp_checkbox_field_6']) ? $options['fawp_checkbox_field_6'] : 0;
        if ($override && $override == 1) {
            return site_url($authurl);
        }
        return $login_url;
    }

    public function figure_current_user($user) {
        // is_user_logged_in() causes an ininite loop here :(

        $headers = apache_request_headers();
        if (isset($headers['Authorization']) && !empty($headers['Authorization'])) {
            $tokken = $headers['Authorization'];

            $projectId = 'testing-efcb1';
            $verifier = new Verifier($projectId);
            $idTokenString = $tokken;
            $uid = '';
            try {
                $verifiedIdToken = $verifier->verifyIdToken($idTokenString);

                $uid = $verifiedIdToken->getClaim('sub'); // "a-uid"
                $email = $verifiedIdToken->getClaim('email');
                $uname = $verifiedIdToken->getClaim('name');
            } catch (\Firebase\Auth\Token\Exception\ExpiredToken $e) {
                echo $e->getMessage();
            } catch (\Firebase\Auth\Token\Exception\IssuedInTheFuture $e) {
                echo $e->getMessage();
            } catch (\Firebase\Auth\Token\Exception\InvalidToken $e) {
                echo $e->getMessage();
            }
            if ($uid) {
                global $wpdb;
                $user_id = $wpdb->get_var("SELECT user_id FROM " . $wpdb->prefix . "fireauth_users where uid='" . $uid . "'");
                if ($user_id) {
                    return $user_id;
                }
            }
        }

        return $user;
    }

    public function fawp_rest_api_init() {
        register_rest_route('fireauthwp', '/test', array(
            'methods' => 'GET',
            'callback' => array($this, 'testCallback'),
        ));
    }

    public function add_cors_support() {
        $options = get_option('fawp_settings');
        $enable_cors = isset($options['fawp_checkbox_field_7']) ? $options['fawp_checkbox_field_7'] :0 ;
        if ($enable_cors && $enable_cors == 1) {
            $headers = apply_filters('fawp_auth_cors_allow_headers', 'Access-Control-Allow-Headers, Content-Type, Authorization');
            header(sprintf('Access-Control-Allow-Headers: %s', $headers));
        }
    }

    public function testCallback() { //must be public
        return 'test ok';
    }

}
