<?php

/**
 * Get all faktura
 *
 * @param $args array
 *
 * @return array
 */
function Faktury_get_all_faktura( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'faktura-all';
    $items     = wp_cache_get( $cache_key, 'wedevs' );

    if ( false === $items ) {
        $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'faktury ORDER BY ' . $args['orderby'] .' ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );

        wp_cache_set( $cache_key, $items, 'wedevs' );
    }

    return $items;
}

/**
 * Fetch all faktura from database
 *
 * @return array
 */
function Faktury_get_faktura_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'faktury' );
}

/**
 * Fetch a single faktura from database
 *
 * @param int   $id
 *
 * @return array
 */
function Faktury_get_faktura( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'faktury WHERE id = %d', $id ) );
}


/**
 * Insert a new faktura
 *
 * @param array $args
 */
function faktury_insert_faktura( $args = array() ) {
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