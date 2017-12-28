<?php

/**
 * Admin Menu
 */
class Batch {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /** Top Menu **/
        add_menu_page( __( 'Hromadné faktury', 'wedevs' ), __( 'Hromadné faktury', 'wedevs' ), 'manage_options', 'batch-list', array( $this, 'plugin_page' ), 'dashicons-editor-justify', null );

        add_submenu_page( 'batches', __( 'Hromadné faktury', 'wedevs' ), __( 'Hromadné faktury', 'wedevs' ), 'manage_options', 'batch-list', array( $this, 'plugin_page' ) );
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':

                $template = dirname( __FILE__ ) . '/views/batch-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/batch-edit.php';
                break;
             case 'send':
                $template = dirname( __FILE__ ) . '/views/batch-send.php';
                break;
           
            case 'new':
                $template = dirname( __FILE__ ) . '/views/batch-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/batch-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}