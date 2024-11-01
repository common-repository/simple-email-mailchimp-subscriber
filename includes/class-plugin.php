<?php
if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 * @since      1.0.0
 * @package    WpmsemsPlugin
 * @subpackage WpmsemsPlugin/includes
 * @author     MagePeople team <magepeopleteam@gmail.com>
 */

class WpmsemsPlugin {


	protected $loader;

	protected $plugin_name;

	protected $version;

	public function __construct() {
		$this->load_dependencies();
		
	}

	private function load_dependencies() {
		// require_once WPMSEMS_PLUGIN_DIR . 'lib/classes/class-wc-product-data.php';
		require_once WPMSEMS_PLUGIN_DIR . 'lib/classes/class-form-fields-generator.php';
		// require_once WPMSEMS_PLUGIN_DIR . 'lib/classes/class-form-fields-wrapper.php';
		require_once WPMSEMS_PLUGIN_DIR . 'lib/classes/class-meta-box.php';
		// require_once WPMSEMS_PLUGIN_DIR . 'lib/classes/class-taxonomy-edit.php';
		require_once WPMSEMS_PLUGIN_DIR . 'lib/classes/class-theme-page.php';
		require_once WPMSEMS_PLUGIN_DIR . 'lib/classes/class-menu-page.php';
		// require_once WPMSEMS_PLUGIN_DIR . 'lib/MailChimp.php';
		require_once WPMSEMS_PLUGIN_DIR . 'includes/class-plugin-loader.php';
		require_once WPMSEMS_PLUGIN_DIR . 'includes/class-upgrade.php';
		require_once WPMSEMS_PLUGIN_DIR . 'includes/class-functions.php';
		require_once WPMSEMS_PLUGIN_DIR . 'includes/class_csv_export.php';
		require_once WPMSEMS_PLUGIN_DIR . 'admin/class-plugin-admin.php';
		require_once WPMSEMS_PLUGIN_DIR . 'public/class-plugin-public.php';
		require_once WPMSEMS_PLUGIN_DIR . 'support/elementor/elementor-support.php';
		$this->loader = new WpmsemsPluginLoader();
		
	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}
