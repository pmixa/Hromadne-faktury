<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class BatchList extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'batch',
            'plural'   => 'batches',
            'ajax'     => false
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        _e( 'Nic nenalezeno', 'faktury' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'title':
                return $item->title;

            case 'date':
                return convert_date ($item->date);

            case 'date_due':
            	 return convert_date ($item->date_due);

            case 'description':
                return $item->description;

            case 'price':
                return $item->price;

            case 'users':
                return get_users($item->id);

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'           => '<input type="checkbox" />',
            'title'      => __( 'Název', 'faktury' ),
            'date'      => __( 'Datum', 'faktury' ),
            'date_due'      => __( 'Datum plnění', 'faktury' ),
            'description'      => __( 'Popis', 'faktury' ),
            'price'      => __( 'Cena', 'faktury' ),
            'users'      => __( 'Odběratelé', 'faktury' ),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_title( $item ) {

        $actions           = array();
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=batch-list&action=edit&id=' . $item->id ), $item->id, __( 'Edit this item', 'faktury' ), __( 'Edit', 'faktury' ) );
       $actions['send']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=batch-list&action=send&id=' . $item->id ), $item->id, __( 'Send this item', 'faktury' ), __( 'Send', 'faktury' ) );
        
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=batch-list&action=delete&id=' . $item->id ), $item->id, __( 'Delete this item', 'faktury' ), __( 'Delete', 'faktury' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=batch-list&action=view&id=' . $item->id ), $item->title, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'date' => array( 'date', true ),
            'price' => array( 'price', true ),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'trash'  => __( 'Move to Trash', 'faktury' ),
        );
        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="batch_id[]" value="%d" />', $item->id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=sample-page' );

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {

        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        $this->items  = Batches::get_all( $args );

        $this->set_pagination_args( array(
            'total_items' => Batches::get_count(),
            'per_page'    => $per_page
        ) );
    }

    public function get_users() {

    global $wpdb;

    $table_name = $wpdb->prefix . 'faktury';
   
    $fa =  $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $table_name . ' WHERE id_batch = %d', $this->id ) );
    
    $users = '';

    foreach ($fa as $faktura) {
    
    $item = new Faktura($faktura->id);

    $user = $item->get_user();  
    $users.=$user['jmeno'].", ";
      }    

      return $users;
    }

}