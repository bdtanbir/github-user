<?php
/*
Plugin Name: Github Users Info
Plugin URI: 
Description: Search Github User Name
Version: 0.1
Author: Tanbir Ahmed
Author URI: http://tanbirahmed.unaux.com/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: github-users-info
Domain Path: /languages
*/

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Github_Users_Info class
 * @class Github_Users_Info The class that holds the entire Github_Users_Info plugin
 */
final class Github_Users_Info {

    /**
     * Plugin version
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Holds various class instances
     * @var array
     */
    private $container = array();

    /**
     * Constructor for the Github_Users_Info class
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {

        $this->define_constants();

        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
    }

    /**
     * Initializes the Github_Users_Info() class
     *
     * Checks for an existing Github_Users_Info() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new Github_Users_Info();
        }

        return $instance;
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset( $prop ) {
        return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
    }

    /**
     * Define the constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'GTUI_VERSION', $this->version );
        define( 'GTUI_FILE', __FILE__ );
        define( 'GTUI_PATH', dirname( GTUI_FILE ) );
        define( 'GTUI_INCLUDES', GTUI_PATH . '/includes' );
        define( 'GTUI_URL', plugins_url( '', GTUI_FILE ) );
        define( 'GTUI_ASSETS', GTUI_URL . '/assets' );
    }

    /**
     * Load the plugin after all plugins are loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {

        $installed = get_option( 'gtui_installed' );

        if ( ! $installed ) {
            update_option( 'gtui_installed', time() );
        }

        update_option( 'gtui_version', GTUI_VERSION );
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {

    }

    /**
     * Include the required files
     *
     * @return void
     */
    public function includes() {

        require_once GTUI_INCLUDES . '/Assets.php';

        if ( $this->is_request( 'admin' ) ) {
            require_once GTUI_INCLUDES . '/Admin.php';
        }

        if ( $this->is_request( 'ajax' ) ) {
            // require_once GTUI_INCLUDES . '/class-ajax.php';
        }
    }

    /**
     * Initialize the hooks
     *
     * @return void
     */
    public function init_hooks() {

        add_action( 'init', array( $this, 'init_classes' ) );

        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );
    }

    /**
     * Instantiate the required classes
     *
     * @return void
     */
    public function init_classes() {

        if ( $this->is_request( 'admin' ) ) {
            $this->container['admin'] = new App\GTUI_Admin();
        }

        if ( $this->is_request( 'ajax' ) ) {
            // $this->container['ajax'] =  new App\Ajax();
        }

        $this->container['assets'] = new App\GTUI_Assets();
    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'github-users-info', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();

            case 'ajax' :
                return defined( 'DOING_AJAX' );

            case 'rest' :
                return defined( 'REST_REQUEST' );

            case 'cron' :
                return defined( 'DOING_CRON' );

        }
    }

} // Github_Users_Info

$github_users_info = Github_Users_Info::init();
