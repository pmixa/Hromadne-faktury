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
        add_menu_page( __( 'Faktury', 'faktury' ), __( 'Faktury', 'faktury' ), 'manage_options', 'faktury', array( $this, 'plugin_page' ), 'dashicons-groups', null );

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

    public static function get_all ( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'faktura-all';
    $items     = wp_cache_get( $cache_key, 'faktury' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'faktury ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'faktury' );
    }

    return $items;
}

/**
 * Fetch all faktura from database
 *
 * @return array
 */
public static function get_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'faktury' );
}

public static function get_faktura( $id ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'faktury WHERE id = %d', $id ) );
}

public static function get_faktury( $id ) {
    
    global $wpdb;

    $table_name = $wpdb->prefix . 'faktury';

    return $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $table_name . ' WHERE id_batch = %d', $id ) );
}


/**
 * Insert a new faktura
 *
 * @param array $args
 */
public static function insert_faktura( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'title' => '',
        'num' => '',
        'date' => '',
        'date_due' => '',
        'ks' => '',
        'vs' => '',
        'description' => '',
        'price' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'faktury';

    // some basic validation

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {

        
        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}


}

class Faktura {

	public $num = '';
	public $id = null;
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
    $this->date = $fa->date;
    $this->date_due = $fa->date_due;
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
