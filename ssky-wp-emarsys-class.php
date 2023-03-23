<?php
/**
 * sSky WP Emarsys Main Class.
 * @author: Sasky Samonte
 */
 

class sSKY_WP_Emarsys {

	public $version; //string
	public $php; //string

	/**
	 * Constructor.
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->version = SSKY_WP_EMARSYS_VERSION;
		$this->php = SSKY_PHP_VERSION;
		add_action( 'init', array($this,'ssky_wp_emarsys_main_init') );
	}
	

	/**
	 * Loads any class that needs to check.
	 * @since 1.0.0
	 */
	public function ssky_wp_emarsys_main_init() {
        /**
		 * Register Custom General Fields
		 */
        $add_option = [
		    'ssky_wp_emarsys_api_username' => 'emarsys_username_here',
		    'ssky_wp_emarsys_api_password' => 'emarsys_password_here',
		    'ssky_wp_emarsys_success_message' => 'Form Sent successfully',
		    'ssky_wp_emarsys_terms_conditions' => 'Terms & Conditions',
		];
		add_option( 'ssky_wp_emarsys_options', $add_option );

		require_once('ssky-wp-emarsys-settings.php');
		new sSKY_WP_Emarsys_Settings();
	}
	
	/**
	 * Frontend WP Head 
	 * @since 1.0.0
	 */
	public function ssky_wp_emarsys_front_end_wp_head() {
	   
	}
	

	/**
	 * Frontend Scripts 
	 * @since 1.0.0
	 */
	public function ssky_wp_emarsys_front_end_enqueue_script() {
        
	}


}