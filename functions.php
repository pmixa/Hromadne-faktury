<?php

/*
Plugin Name: Faktury
Description: Hromadné rozesílání faktur uživatelům.
Version: 1.0
Author: Premysl Mixa
Author URI: http://studiopm.cz
License: GPL2
Text Domain: faktury
*/


  
class Faktury_plugin {

	

	private static $instance = null;
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	private function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	
  	if( ! defined( 'FAKTURY_PLUGIN_DIR' ) )
			define( 'FAKTURY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		
	
    }
	/** 
	 * Check that the plugin can work.
	 * @since 1.0
	 */
	public function plugins_loaded() {

		
		$this->activate();
	
	}

	/** 
	 * Register the enqueue
	 * @since 1.0
	 */
   	public function enqueue() {
	wp_register_style('faktury', plugins_url('faktury.css', __FILE__));
   if ( ! wp_script_is( 'jquery', 'enqueued' )) wp_enqueue_script( 'jquery' );
    wp_enqueue_style('faktury');
    //wp_enqueue_script('faktury');
	}

 	private function activate() {

         global $wpdb;
         
         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');


         $this->tables = array(
            'faktury' => $wpdb->prefix.'faktury',
            'batches' => $wpdb->prefix.'batches'
        );

        $sql = '
            CREATE TABLE '.$this->tables['faktury'].' (
              id int(11) NOT NULL auto_increment,
              id_batch int(11) default NULL,
              num varchar(10) default NULL,
              title varchar(100) default NULL,
              date date default NULL,
              date_due date default NULL,
              description text,
              price numeric(7,2) default NULL,
              ks varchar(5) default NULL,
              vs varchar(10) default NULL,
              id_user bigint(20) default NULL,
              PRIMARY KEY  (id)
            )';
        dbDelta($sql);
       
       $sql = '
            CREATE TABLE '.$this->tables['batches'].' (
              id int(11) NOT NULL auto_increment,
              title varchar(100) default NULL,
              date date default NULL,
              date_due date default NULL,
              description text,
              price numeric(7,2) default NULL,
              ks varchar(5) default NULL,
              PRIMARY KEY  (id)
            )';
        dbDelta($sql);


    }


}
$plugin = Faktury_plugin::get_instance();



// Include files

add_action ('init', function() {

include dirname(__FILE__) . '/includes/settings.php';
include dirname(__FILE__) . '/includes/user_extraprofiles.php';

include dirname(__FILE__) . '/includes/class-batch.php';
include dirname(__FILE__) . '/includes/class-batch-list-table.php';
include dirname(__FILE__) . '/includes/class-form-handler.php';
include dirname(__FILE__) . '/includes/batch-functions.php';

include dirname(__FILE__) . '/includes/class-faktury.php';
include dirname(__FILE__) . '/includes/class-faktura-list-table.php';
include dirname(__FILE__) . '/includes/class-faktura-form-handler.php';
include dirname(__FILE__) . '/includes/faktura-functions.php';

require_once dirname(__FILE__).'/vendor/autoload.php';
include dirname(__FILE__) . '/shortcodes.php';


new Batch();
new Faktury();

add_filter( 'template_include', 'page_template', 99 );

function page_template( $template ) {
    
    if ( is_page( 'faktura' ) ) {
     
       $template = plugin_dir_path( __FILE__ ) . 'templates/faktura-pdf.php';
        }
        
    return $template;
}

});