<?php
/**
 * Virtual Fitting Room (VFR)
 *
 * @wordpress-plugin
 * Plugin Name:       	Virtual Fitting Room
 * Plugin URI:        	http://www.cpp.edu/
 * Description:       	Allows a user to view what a dress could look like on themselves
 *                      based on manual input of body measurements.
 * Version:           	0.1.0
 * Author:            	Alex Vargas, Andrew Kim, Aaron T.
 * Author URI:        	http://www.cpp.edu
 * License:           	GPL-2.0+
 * License URI:       	http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use Virtual_Fitting_Room\Core\DB;
use Virtual_Fitting_Room\Core\Front;
use Virtual_Fitting_Room\Core\Manage;

class Virtual_Fitting_Room {

	public function __construct() {
		
		$this->autoloader();
		$this->init_db();
		$this->init_classes();

	}

	function autoloader() {
		// Include the autoloader so we can dynamically include the rest of the classes.
		require_once( trailingslashit( dirname( __FILE__ ) ) . 'inc/autoloader.php' );
	}

	private function init_db() {
 		$dresses_db = new DB\VFR_Dresses_DB();
 		$main_db = new DB\VFR_Main_DB();

		// Register table into DB on plugin activation
		register_activation_hook( __FILE__, [ $dresses_db, 'create_table' ] );
		register_activation_hook( __FILE__, [ $main_db, 'create_table' ] );
    }

	// Load dependencies
	private function init_classes() {
		$front = new Front\Virtual_Fitting_Room_Front();
		$front_css = new Front\Util\CSS_Loader();
		$front_js = new Front\Util\JS_Loader();

		$manage = new Manage\Virtual_Fitting_Room_Manage();
		$manage_css = new Manage\Util\CSS_Loader();
		$manage_js = new Manage\Util\JS_Loader();

		//Create required pages on plugin activation
		register_activation_hook( __FILE__, [ $front, 'create_pages' ] );
		register_activation_hook( __FILE__, [ $manage, 'create_pages' ] );
	}
}

// Initialize the plugin
$vfr_plugin = new Virtual_Fitting_Room;
