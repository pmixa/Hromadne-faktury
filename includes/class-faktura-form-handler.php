<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Faktura_Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the faktura new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['submit'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Are you cheating?', 'wedevs' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'wedevs' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=faktury' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $title = isset( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
        $num = isset( $_POST['num'] ) ? sanitize_text_field( $_POST['num'] ) : '';
        $date = isset( $_POST['date'] ) ? sanitize_text_field( $_POST['date'] ) : '';
        $date_due = isset( $_POST['date_due'] ) ? sanitize_text_field( $_POST['date_due'] ) : '';
        $ks = isset( $_POST['ks'] ) ? sanitize_text_field( $_POST['ks'] ) : '';
        $vs = isset( $_POST['vs'] ) ? sanitize_text_field( $_POST['vs'] ) : '';
        $description = isset( $_POST['description'] ) ? sanitize_text_field( $_POST['description'] ) : '';
        $price = isset( $_POST['price'] ) ? intval( $_POST['price'] ) : 0;

        // some basic validation
        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'title' => $title,
            'num' => $num,
            'date' => $date,
            'date_due' => $date_due,
            'ks' => $ks,
            'vs' => $vs,
            'description' => $description,
            'price' => $price,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = faktury_insert_faktura( $fields );

        } else {

            $fields['id'] = $field_id;

            $insert_id = faktury_insert_faktura( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}

if ($_GET['page'] == 'faktura') new Faktura_Form_Handler();