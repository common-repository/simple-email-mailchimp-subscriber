<?php
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class WpmsemsAdmin {

	private $plugin_name;

	private $version;

	public function __construct() {

		// $this->plugin_name = $plugin_name;
		// $this->version = $version;
		$this->load_admin_dependencies();
		add_action( 'admin_enqueue_scripts', array($this,'enqueue_styles' ));
		add_action( 'admin_enqueue_scripts', array($this,'enqueue_scripts' ));
	}

	public function enqueue_styles() {
		wp_enqueue_style('mage-jquery-ui-style',WPMSEMS_PLUGIN_URL.'admin/css/jquery-ui.css',array());	
        wp_enqueue_style('pickplugins-options-framework', WPMSEMS_PLUGIN_URL.'admin/assets/css/pickplugins-options-framework.css');
		wp_enqueue_style('jquery-ui', WPMSEMS_PLUGIN_URL.'admin/assets/css/jquery-ui.css');
		wp_enqueue_style('select2.min', WPMSEMS_PLUGIN_URL.'admin/assets/css/select2.min.css');
		wp_enqueue_style('codemirror', WPMSEMS_PLUGIN_URL.'admin/assets/css/codemirror.css');
		wp_enqueue_style('fontawesome', WPMSEMS_PLUGIN_URL.'admin/assets/css/fontawesome.min.css');
		wp_enqueue_style( 'mage-admin-css', WPMSEMS_PLUGIN_URL . 'admin/css/mage-plugin-admin.css', array(), time(), 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core'); 
		wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script('magepeople-options-framework', plugins_url( 'assets/js/pickplugins-options-framework.js' , __FILE__ ) , array( 'jquery' ));		
        wp_localize_script( 'PickpluginsOptionsFramework', 'PickpluginsOptionsFramework_ajax', array( 'PickpluginsOptionsFramework_ajaxurl' => admin_url( 'admin-ajax.php')));
        wp_enqueue_script('select2.min', plugins_url( 'assets/js/select2.min.js' , __FILE__ ) , array( 'jquery' ));
        wp_enqueue_script('codemirror', WPMSEMS_PLUGIN_URL.'admin/assets/js/codemirror.min.js', array( 'jquery' ),null, false);
        wp_enqueue_script('form-field-dependency', plugins_url( 'assets/js/form-field-dependency.js' , __FILE__ ) , array( 'jquery' ),null, false);
		wp_enqueue_script( 'mage-plugin-js', WPMSEMS_PLUGIN_URL . 'admin/js/mage-plugin-admin.js', array( 'jquery','jquery-ui-core','jquery-ui-datepicker' ), time(), true );		
	}



	private function load_admin_dependencies() {
		require_once WPMSEMS_PLUGIN_DIR . 'admin/class/class-create-cpt.php';
		// require_once WPMSEMS_PLUGIN_DIR . 'admin/class/class-create-tax.php';
		require_once WPMSEMS_PLUGIN_DIR . 'admin/class/class-meta-box.php';
		// require_once WPMSEMS_PLUGIN_DIR . 'admin/class/class-tax-meta.php';
		require_once WPMSEMS_PLUGIN_DIR . 'admin/class/class-setting-page.php';
		// require_once MAGE_PLUGIN_DIR . 'admin/class/class-menu-page.php';
	}
}
new WpmsemsAdmin();