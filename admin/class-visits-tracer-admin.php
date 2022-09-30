<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Visits_Tracer
 * @subpackage Visits_Tracer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Visits_Tracer
 * @subpackage Visits_Tracer/admin
 * @author     Developer Junayed <admin@easeare.com>
 */
class Visits_Tracer_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/visits-tracer-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/visits-tracer-admin.js', array( 'jquery' ), $this->version, false );

	}

	function admin_menu_pages(){
		add_menu_page("Visits Tracer", "Visits Tracer", "manage_options", "visits-tracer", [$this, "visits_tracer_callback"], "dashicons-hidden", 45 );
		add_submenu_page("visits-tracer", "Settings", "Settings", "manage_options", "vt-settings",[$this, "vt_settings"], null );

		add_settings_section( 'vt_setting_section', '', '', 'vt_setting_page' );
		add_settings_field( 'vt_times', 'Times', [$this, 'vt_times_cb'], 'vt_setting_page','vt_setting_section' );
		register_setting( 'vt_setting_section', 'vt_times' );
		add_settings_field( 'vt_page_limit', 'Page Limits', [$this, 'vt_page_limit_cb'], 'vt_setting_page','vt_setting_section' );
		register_setting( 'vt_setting_section', 'vt_page_limit' );
	}

	function vt_times_cb(){
		echo '<input type="number" placeholder="12" value="'.get_option('vt_times').'" name="vt_times">';
	}

	function vt_page_limit_cb(){
		echo '<input type="number" placeholder="5" value="'.get_option('vt_page_limit').'" name="vt_page_limit">';
	}

	function visits_tracer_callback(){
		require_once plugin_dir_path(__FILE__ )."partials/visits-tracer-admin-display.php";
	}

	function vt_settings(){
		?>
		<h3>Settings</h3>
		<hr>
		<div class="vt_settings">
			<form style="width: 75%;" method="post" action="options.php">
				<?php
				settings_fields( 'vt_setting_section' );
				do_settings_sections('vt_setting_page');
				echo get_submit_button( 'Save Changes', 'secondary', 'save-news-setting' );
				?>
			</form>
		</div>
		<?php
	}

}
