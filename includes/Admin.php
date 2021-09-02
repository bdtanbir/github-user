<?php
namespace App;

/**
 * Admin Pages Handler
 */
class GTUI_Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'wp_ajax_my_ajaxcall', [$this,'my_ajaxcall'] );
		add_action( 'wp_ajax_nopriv_my_ajaxcall', [$this,'my_ajaxcall'] );
    }

    /**
     * Register our menu page
     *
     * @return void
     */
    public function admin_menu() {
        $capability = 'manage_options';
        $slug       = 'github-users-info';

        $hook = add_menu_page( 
            __( 'Github Users Info', 'github-users-info' ), 
            __( 'Github Users Info', 'github-users-info' ), 
            $capability, 
            $slug, 
            [ $this, 'gtui_menu_page_template' ], 
            'dashicons-admin-users',
            50 
        );

        add_action( 'load-' . $hook, [ $this, 'init_hooks'] );
    }

    /**
     * Initialize our hooks for the admin page
     * @return void
     */
    public function init_hooks() {
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
        wp_enqueue_script( 'gtui-global-admin', GTUI_ASSETS.'/js/global-admin.js', null, GTUI_VERSION, true );
		wp_localize_script( 'gtui-global-admin', 'ajax_url', array(
			'ajaxurl'         => admin_url( 'admin-ajax.php' ),
		));
    }

    /**
     * Load scripts and styles for the app
     *
     * @return void
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'gtui-admin' );
        wp_enqueue_script( 'gtui-admin' );
    }

    /**
     * Render our admin page
     * @return void
     */
    public function gtui_menu_page_template() {
        echo '<div class="wrap"><div id="gtui-admin-app"></div></div>';
    }
    public function my_ajaxcall() {
        $searchUsername = (isset($_POST['search_username']) ? $_POST['search_username'] : '');
        $request = wp_remote_get( "https://api.github.com/search/users?q=".$searchUsername );
        if( is_wp_error( $request ) ) {
            return false;
        }
        $userData = json_decode(wp_remote_retrieve_body( $request ));
        wp_send_json_success( $userData, '200' );
        
        die();
    }
}
