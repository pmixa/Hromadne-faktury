<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Batches_Form_Handler {

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

         Batches::delete_batch($_GET['id']);

        }
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Are you cheating?', 'faktury' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'faktury' ) );
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
            $errors[] = __( 'Error: Název is required', 'faktury' );
        }

        if ( ! $date ) {
            $errors[] = __( 'Error: Datum is required', 'faktury' );
        }

        if ( ! $date_due ) {
            $errors[] = __( 'Error: Splatnost is required', 'faktury' );
        }

        if ( ! $description ) {
            $errors[] = __( 'Error: Podrobný popis is required', 'faktury' );
        }

        if ( ! $price ) {
            $errors[] = __( 'Error: Cena is required', 'faktury' );
        }

        if ( ! $ks ) {
            $errors[] = __( 'Error: Konst. symbol is required', 'faktury' );
        }

        if ( ! $users ) {
            $errors[] = __( 'Error: Odběratelé is required', 'faktury' );
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

            $insert_id = Batches::insert_batch( $fields );
            $faktury_id = Batches::insert_faktury ($insert_id,$fields,$users,get_option('rada'));

        } else {

            
            $insert_id = Batches::insert_batch( $fields );
            $faktury_id = Batches::insert_faktury ($insert_id,$fields,$users,get_option('rada'));
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
            die( __( 'Are you cheating?', 'faktury' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', 'faktury' ) );
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

            $insert_id = Faktury::insert_faktura( $fields );

        } else {

            $fields['id'] = $field_id;

            $insert_id = Faktury::insert_faktura( $fields );
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

if ($_GET['page'] == 'faktury') new Faktura_Form_Handler();
if ($_GET['page'] == 'batch-list') New Batches_Form_handler();
