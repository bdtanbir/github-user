<?php
namespace App;

/**
 * Admin Pages Handler
 */
class GTUI_Admin {

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
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
     *
     * @return void
     */
    public function gtui_menu_page_template() {
        echo '<div class="wrap"><div id="gtui-admin-app"></div></div>';
    }
}
