<?php

/**
 * Admin Menu
 */
class Faktury {

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
        add_menu_page( __( 'Faktury', 'wedevs' ), __( 'Faktury', 'wedevs' ), 'manage_options', 'faktury-list', array( $this, 'plugin_page' ), 'dashicons-groups', null );

        add_submenu_page( 'batches', __( 'Faktury', 'wedevs' ), __( 'Faktury', 'wedevs' ), 'manage_options', 'faktury-list', array( $this, 'plugin_page' ) );
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

                $template = dirname( __FILE__ ) . '/views/faktury-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/faktury-edit.php';
                break;
             case 'new':
                $template = dirname( __FILE__ ) . '/views/faktury-new.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/faktury-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}

class Faktura {

	public $num = '';
	private $id = null;
	public $vs = null;
	public $ks = null;
	public $date = null;
	public $date_due = null;
	private $user = null;
	public $price = null;
	public $title = null;
	public $description = null;
	public $id_batch = null;

	public function __construct($id) {

    global $wpdb;

    $fa = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'faktury WHERE id = %d', $id ) );

    $this->id = $fa->id;
    $this->price = $fa->price;
    $this->title = $fa->title;
    $this->description = $fa->description;
    $this->id_batch = $fa->id_batch;
    $this->vs = $fa->vs;
    $this->date = convert_date($fa->date);
    $this->date_due = convert_date($fa->date_due);
    $this->ks = $fa->ks;
    $this->num = $fa->num;
    $this->user = $fa->id_user;

	}


	public function get_user() {
 	
 	$meta = array_map( function( $a ){ return $a[0]; }, get_user_meta(  $this->user ) );
 	$user = get_userdata( $this->user);

	return array (	'jmeno' => $meta['first_name'],
					'id' => $this->user,
 					'zus' => $meta['firma'],
 					'ulice' => $meta['ulice'],
 					'psc' => $meta['psc'],
 					'mesto' => $meta['mesto'],
 					'ic' => $meta['ic'],
 					'telefon' => $meta['phone'],
 					'email' => $user->user_email);    
    }

}
