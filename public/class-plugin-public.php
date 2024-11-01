<?php
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 * @package    WP Monkeys
 */
class WpmsemsPublic {

	private $plugin_name;

	private $version;

	public function __construct() {
		$this->load_public_dependencies();
		add_action( 'wp_enqueue_scripts', array($this,'enqueue_styles'));
		add_action( 'wp_enqueue_scripts', array($this,'enqueue_styles'));
		add_action('admin_enqueue_scripts',array($this,'wpmsems_ajax_call_url'));
		add_action('wp_enqueue_scripts',array($this,'wpmsems_ajax_call_url'));
	}

	private function load_public_dependencies() {
		require_once WPMSEMS_PLUGIN_DIR . 'public/shortcode/shortcode-default.php';
	}

	public function enqueue_styles() {
		wp_enqueue_style( 'mage-public-css', WPMSEMS_PLUGIN_URL . 'public/css/style.css', array(), time(), 'all' );

	}


	public function enqueue_scripts() {
		wp_enqueue_script( 'mage-public-js', WPMSEMS_PLUGIN_URL . 'public/js/mage-plugin-public.js', array( 'jquery' ), time(), false );

	}

	function wpmsems_ajax_call_url(){
    wp_localize_script('jquery', 'wpmsems_ajax', array( 'wpmsems_ajaxurl' => admin_url( 'admin-ajax.php')));
	}

}
new WpmsemsPublic();