<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Visits_Tracer
 * @subpackage Visits_Tracer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Visits_Tracer
 * @subpackage Visits_Tracer/public
 * @author     Developer Junayed <admin@easeare.com>
 */
class Visits_Tracer_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/visits-tracer-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/visits-tracer-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name, "vt_ajax", array(
			'ajaxurl' => admin_url("admin-ajax.php"),
			'visit_times' => ((get_option('vt_times')) ? get_option('vt_times'): 12),
			'visit_pages' => ((get_option('vt_page_limit')) ? get_option('vt_page_limit'): 5)
		) );
	}

	function vt_view_callback(){
		require_once plugin_dir_path(__FILE__ )."partials/visits-tracer-public-display.php";
	}

	function is_page_visits($post_id){
		if(isset($_COOKIE["vt_page_trace_$post_id"])){
			return true;
		}else{
			return false;
		}
	}

	function get_visits_counts(){
		if(isset($_COOKIE['vt_visits_counts'])){
			return intval($_COOKIE['vt_visits_counts']);
		}else{
			return 0;
		}
	}

	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function save_visits(){
		if(isset($_POST['post'])){
			$defaultZone = wp_timezone_string();
			if($defaultZone){
				date_default_timezone_set($defaultZone);
			}
			
			$tomorrow = strtotime("tomorrow");

			$post_id = $_POST['post'];
			setcookie("vt_page_trace_$post_id", $post_id, $tomorrow, "/");

			$allpages = '';
			if(isset($_COOKIE['vt_all_pages'])){
				$allpages = $_COOKIE['vt_all_pages'];
			}
			$allpages .= "$post_id,";
			setcookie("vt_all_pages", $allpages, $tomorrow, "/");

			$myvisits = intval($this->get_visits_counts());
			$myvisits += 1;
			setcookie("vt_visits_counts", $myvisits, $tomorrow, "/");
			
			$page_limit = ((get_option('vt_page_limit')) ? get_option('vt_page_limit'): 5);
			$total = $this->get_visits_counts() + 1;
			$visits_results = get_option("vt_results_$tomorrow");
			if(!is_array($visits_results)){
				$visits_results = [];
			}

			$code = '';
			if($total === $page_limit){
				$code = $this->generateRandomString(6);
				setcookie("vt_unique_code", $code, $tomorrow, "/");
				$visits_results[] = $code;
				
				update_option("vt_results_$tomorrow", $visits_results);
			}

			echo json_encode(array("success" => $total));
			die;
		}
		echo json_encode(array("error" => "Error"));
		die;
	}

	function get_unique_code(){
		if(isset($_COOKIE['vt_unique_code'])){
			echo json_encode(array("success" => $_COOKIE['vt_unique_code']));
			die;
		}
	}
}
