<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the batch new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['Submit'] ) ) {

        if (isset($_GET['action']) && $_GET['action'] == 'delete') {

         batch_delete($_GET['id']);

        }
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Are you cheating?', 'wedevs' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'wedevs' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=batch-list' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $title = isset( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
        $date = isset( $_POST['date'] ) ? sanitize_text_field( $_POST['date'] ) : '';
        $date_due = isset( $_POST['date_due'] ) ? sanitize_text_field( $_POST['date_due'] ) : '';
        $description = isset( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ) : '';
        $price = isset( $_POST['price'] ) ? intval( $_POST['price'] ) : 0;
        $ks = isset( $_POST['ks'] ) ? sanitize_text_field( $_POST['ks'] ) : '';
        $users = isset( $_POST['odberatel'] ) ? $_POST['odberatel'] : '';
        // some basic validation
        if ( ! $title ) {
            $errors[] = __( 'Error: Název is required', 'wedevs' );
        }

        if ( ! $date ) {
            $errors[] = __( 'Error: Datum is required', 'wedevs' );
        }

        if ( ! $date_due ) {
            $errors[] = __( 'Error: Splatnost is required', 'wedevs' );
        }

        if ( ! $description ) {
            $errors[] = __( 'Error: Podrobný popis is required', 'wedevs' );
        }

        if ( ! $price ) {
            $errors[] = __( 'Error: Cena is required', 'wedevs' );
        }

        if ( ! $ks ) {
            $errors[] = __( 'Error: Konst. symbol is required', 'wedevs' );
        }

        if ( ! $users ) {
            $errors[] = __( 'Error: Odběratelé is required', 'wedevs' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'title' => $title,
            'date' => $date,
            'date_due' => $date_due,
            'description' => $description,
            'price' => $price,
            'ks' => $ks,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = batch_insert_batch( $fields );
            $faktury_id = faktury_insert ($insert_id,$fields,$users,get_option('rada'));

        } else {

            
            $insert_id = batch_insert_batch( $fields );
            $faktury_id = faktury_insert ($insert_id,$fields,$users,get_option('rada'));
        }

        if ( is_wp_error( $insert_id || $faktury_id) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }


}

if ($_GET['page'] == 'batch-list') New Form_handler();
