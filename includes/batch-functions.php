<?php

/**
 * Get all batch
 *
 * @param $args array
 *
 * @return array
 */
function batch_get_all_batch( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'batch-all';
    $items     = wp_cache_get( $cache_key, 'wedevs' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'batches ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'wedevs' );
    }

    return $items;
}

/**
 * Fetch all batch from database
 *
 * @return array
 */
function batch_get_batch_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'batches' );
}

/**
 * Fetch all batch from database
 *
 * @return array
 */
function batch_delete($id) {
    global $wpdb;
    $wpdb->delete( $wpdb->prefix . 'faktury', array( 'id_batch' => $id ) );
    return (int) $wpdb->delete($wpdb->prefix . 'batches',array( 'id' => $id));
}

/**
 * Fetch a single batch from database
 *
 * @param int   $id
 *
 * @return array
 */
function batch_get_batch( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'batches WHERE id = %d', $id ) );
}

/**
 * Insert a new batch
 *
 * @param array $args
 */
function batch_insert_batch( $args = array() ) {
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
        return new WP_Error( 'no-title', __( 'No Název provided.', 'wedevs' ) );
    }
    if ( empty( $args['date'] ) ) {
        return new WP_Error( 'no-date', __( 'No Datum provided.', 'wedevs' ) );
    }
    if ( empty( $args['date_due'] ) ) {
        return new WP_Error( 'no-date_due', __( 'No Splatnost provided.', 'wedevs' ) );
    }
    if ( empty( $args['description'] ) ) {
        return new WP_Error( 'no-description', __( 'No Podrobný popis provided.', 'wedevs' ) );
    }
    if ( empty( $args['price'] ) ) {
        return new WP_Error( 'no-price', __( 'No Cena provided.', 'wedevs' ) );
    }
    if ( empty( $args['ks'] ) ) {
        return new WP_Error( 'no-ks', __( 'No Konst. symbol provided.', 'wedevs' ) );
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

/**
 * Insert a new faktury
 *
 * @param array $args
 */
function faktury_insert ($batch_id,$fields,$users,$num) {

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

/**
 * Get faktury from batch id
 *
 * @param array $args
 */
function get_faktury ($batch_id) {

  global $wpdb;

	$table_name = $wpdb->prefix . 'faktury';
    
   
	return $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM ' . $table_name . ' WHERE id_batch = %d', $batch_id ) );
    

}

function convert_date ($date) {

	$item = DateTime::createFromFormat('Y-m-d', $date);
                return $item->format('d.m.Y');
}