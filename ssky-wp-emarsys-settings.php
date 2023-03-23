<?php
/**
 * sSky WP Emarsys Setting Class
 * @author: Sasky Samonte
 */


 class sSKY_WP_Emarsys_Settings {
    private $ssky_wp_emarsys_options;

    /**
	 * Constructor.
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'ssky_wp_emarsys_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'ssky_wp_emarsys_page_init' ) );
	}

    /**
	 * Loads any class that needs to check.
	 * @since 1.0.0
	 */
    
    public function ssky_wp_emarsys_plugin_page() {
		add_menu_page(
			'sSky WP Emarsys', // page_title
			'sSky WP Emarsys', // menu_title
			'manage_options', // capability
			'ssky-wp-emarsys', // menu_slug
			array( $this, 'ssky_wp_emarsys_admin_page' ), // function
			'dashicons-admin-generic', // icon_url
			2 // position
		);
	}

    public function ssky_wp_emarsys_admin_page() {
		$this->ssky_wp_emarsys_options = get_option( 'ssky_wp_emarsys_options' ); ?>

		<div class="wrap">
			<h2>sSky WP Emarsys</h2>
			<?php settings_errors(); ?>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'ssky_wp_emarsys_group' );
					do_settings_sections( 'ssky-wp-emarsys-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }
    
    public function ssky_wp_emarsys_page_init() {
		register_setting(
			'ssky_wp_emarsys_group', // option_group
			'ssky_wp_emarsys_options', // option_name
			array( $this, 'ssky_wp_emarsys_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'ssky_wp_emarsys_setting_section', // id
			'Settings', // title
			array( $this, 'ssky_wp_emarsys_section_info' ), // callback
			'ssky-wp-emarsys-admin' // page
		);
		
		add_settings_field(
			'ssky_wp_emarsys_api_username', // id
			'Emarsys API Username', // title
			array( $this, 'ssky_wp_emarsys_api_username_callback' ), // callback
			'ssky-wp-emarsys-admin', // page
			'ssky_wp_emarsys_setting_section' // section
		);
		
		add_settings_field(
			'ssky_wp_emarsys_api_password', // id
			'Emarsys API Password', // title
			array( $this, 'ssky_wp_emarsys_api_password_callback' ), // callback
			'ssky-wp-emarsys-admin', // page
			'ssky_wp_emarsys_setting_section' // section
		);

		add_settings_field(
			'ssky_wp_emarsys_success_message', // id
			'Success Message', // title
			array( $this, 'ssky_wp_emarsys_success_message_callback' ), // callback
			'ssky-wp-emarsys-admin', // page
			'ssky_wp_emarsys_setting_section' // section
		);
		
		add_settings_field(
			'ssky_wp_emarsys_terms_conditions', // id
			'Terms & Conditions', // title
			array( $this, 'ssky_wp_emarsys_terms_conditions_callback' ), // callback
			'ssky-wp-emarsys-admin', // page
			'ssky_wp_emarsys_setting_section' // section
		);
		
		
	}

	public function ssky_wp_emarsys_sanitize($input) {
		$sanitary_values = array();
		
		if ( isset( $input['ssky_wp_emarsys_api_username'] ) ) {
			$sanitary_values['ssky_wp_emarsys_api_username'] = sanitize_text_field( $input['ssky_wp_emarsys_api_username'] );
		}
		
		if ( isset( $input['ssky_wp_emarsys_api_password'] ) ) {
			$sanitary_values['ssky_wp_emarsys_api_password'] = sanitize_text_field( $input['ssky_wp_emarsys_api_password'] );
		}

		if ( isset( $input['ssky_wp_emarsys_success_message'] ) ) {
			$sanitary_values['ssky_wp_emarsys_success_message'] = sanitize_text_field( $input['ssky_wp_emarsys_success_message'] );
		}
		
		if ( isset( $input['ssky_wp_emarsys_terms_conditions'] ) ) {
			$sanitary_values['ssky_wp_emarsys_terms_conditions'] = sanitize_text_field( $input['ssky_wp_emarsys_terms_conditions'] );
		}

		return $sanitary_values;
	}

	public function ssky_wp_emarsys_section_info() {
		
	}
	
    public function ssky_wp_emarsys_api_username_callback() {
		printf(
			'<input class="regular-text" type="text" name="ssky_wp_emarsys_options[ssky_wp_emarsys_api_username]" id="ssky_wp_emarsys_api_username" value="%s">',
			isset( $this->ssky_wp_emarsys_options['ssky_wp_emarsys_api_username'] ) ? esc_attr( $this->ssky_wp_emarsys_options['ssky_wp_emarsys_api_username']) : ''
		);
	}
	
	public function ssky_wp_emarsys_api_password_callback() {
		printf(
			'<input class="regular-text" type="text" name="ssky_wp_emarsys_options[ssky_wp_emarsys_api_password]" id="ssky_wp_emarsys_api_password" value="%s">',
			isset( $this->ssky_wp_emarsys_options['ssky_wp_emarsys_api_password'] ) ? esc_attr( $this->ssky_wp_emarsys_options['ssky_wp_emarsys_api_password']) : ''
		);
	}

	public function ssky_wp_emarsys_success_message_callback() {
		printf(
			'<textarea class="regular-text" rows="5" name="ssky_wp_emarsys_options[ssky_wp_emarsys_success_message]" id="ssky_wp_emarsys_success_message">%s</textarea>',
			isset( $this->ssky_wp_emarsys_options['ssky_wp_emarsys_success_message'] ) ? esc_attr( $this->ssky_wp_emarsys_options['ssky_wp_emarsys_success_message']) : ''
		);
	}
	
	public function ssky_wp_emarsys_terms_conditions_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="ssky_wp_emarsys_options[ssky_wp_emarsys_terms_conditions]" id="ssky_wp_emarsys_terms_conditions">%s</textarea>',
			isset( $this->ssky_wp_emarsys_options['ssky_wp_emarsys_terms_conditions'] ) ? esc_attr( $this->ssky_wp_emarsys_options['ssky_wp_emarsys_terms_conditions']) : ''
		);
	}

 }