<?php


class Batches {

   
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

  
    public function admin_menu() {

        /** Top Menu **/
        add_menu_page( __( 'Hromadné faktury', 'faktury' ), __( 'Hromadné faktury', 'faktury' ), 'manage_options', 'batch-list', array( $this, 'plugin_page' ), 'dashicons-editor-justify', null );

    }

    
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

    public static function get_all( $args ) {
    
        global $wpdb;

        $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
        );

        $args      = wp_parse_args( $args, $defaults );
        $cache_key = 'batch-all';
        $items     = wp_cache_get( $cache_key, 'faktury' );

        if ( false === $items ) {
            $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'batches ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

            wp_cache_set( $cache_key, $items, 'faktury' );
        }

    return $items;
    }

    public static function get_count() {
    
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'batches' );
    }



    public static function delete_batch($id) {

    global $wpdb;

    $count = $wpdb->delete( $wpdb->prefix . 'faktury', array( 'id_batch' => $id ) );

    update_option( 'rada', get_option('rada')-$count);
    
    return (int) $wpdb->delete($wpdb->prefix . 'batches',array( 'id' => $id));
}


public static function get_batch( $id ) {

    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'batches WHERE id = %d', $id ) );
}


public static function insert_batch( $args) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'title' => '',
        'date' => '',
        'date_due' => '',
        'description' => '',
        'price' => '',
        'ks' => '',

    );
    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'batches';

    // some basic validation
    if ( empty( $args['title'] ) ) {
        return new WP_Error( 'no-title', __( 'No Název provided.', 'faktury' ) );
    }
    if ( empty( $args['date'] ) ) {
        return new WP_Error( 'no-date', __( 'No Datum provided.', 'faktury' ) );
    }
    if ( empty( $args['date_due'] ) ) {
        return new WP_Error( 'no-date_due', __( 'No Splatnost provided.', 'faktury' ) );
    }
    if ( empty( $args['description'] ) ) {
        return new WP_Error( 'no-description', __( 'No Podrobný popis provided.', 'faktury' ) );
    }
    if ( empty( $args['price'] ) ) {
        return new WP_Error( 'no-price', __( 'No Cena provided.', 'faktury' ) );
    }
    if ( empty( $args['ks'] ) ) {
        return new WP_Error( 'no-ks', __( 'No Konst. symbol provided.', 'faktury' ) );
    }

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

public static function insert_faktury ($batch_id,$fields,$users,$num) {

  global $wpdb;

    $table_name = $wpdb->prefix . 'faktury';
    
    $args = array(
        'id_batch' => $batch_id,
        'title' => $fields['title'],
        'date' => $fields['date'],
        'date_due' => $fields['date_due'],
        'description' => $fields['description'],
        'price' => $fields['price'],
        'vs' => '',
        'num' => '',
        'ks' => $fields['ks'],
        'id_user' => ''

    );
    
    $delete = $wpdb->query('DELETE  FROM $table_name WHERE id_batch = $batch_id');
    
    foreach ($users as $user) {

        $args['id_user'] = $user;
        $args['vs'] = $num;
        $args['num'] = $num;
        $num++;
        
        if (!$wpdb->insert( $table_name, $args )) return false;

    }
    
    update_option( 'rada', $num );
    
    }

}


class Batch {

    private $id = null;
    public $ks = null;
    public $date = null;
    public $date_due = null;
    public $users = '';
    public $price = null;
    public $title = null;
    public $description = null;
    
    public function __construct($id) {

    global $wpdb;

    $batch = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'batches WHERE id = %d', $id ) );

    $this->id = $batch->id;
    $this->price = $batch->price;
    $this->title = $batch->title;
    $this->description = $batch->description;
    $this->date = convert_date($batch->date);
    $this->date_due = convert_date($batch->date_due);
    $this->ks = $batch->ks;
    
    }

    
}