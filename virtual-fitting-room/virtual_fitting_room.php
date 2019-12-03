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
 * Author URI:        	
 * License:           	GPL-2.0+
 * License URI:       	http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use Virtual_Fitting_Room\Core\Front;
use Virtual_Fitting_Room\Core\Manage;

class Virtual_Fitting_Room {

	public function __construct() {
		add_action( 'init', [ $this, 'add_rewrite_rules' ], 10, 0 );
		add_filter( 'query_vars', [ $this, 'add_query_vars' ] );

		$this->autoloader();
		$this->init_classes();
	}

	function autoloader() {
		// Include the autoloader so we can dynamically include the rest of the classes.
		require_once( trailingslashit( dirname( __FILE__ ) ) . 'inc/autoloader.php' );
	}

	// Load dependencies
	private function init_classes() {
		$front = new Front\Virtual_Fitting_Room_Front();
		$front_css = new Front\Util\CSS_Loader();
		$front_js = new Front\Util\JS_Loader();

		$manage = new Manage\Virtual_Fitting_Room_Manage();
		$manage_css = new Manage\Util\CSS_Loader();
		$manage_js = new Manage\Util\JS_Loader();
	}

	public function add_query_vars( $vars ) {
		$vars[] = 'save';
		return $vars;
	}

	public function add_rewrite_rules() {
        add_rewrite_rule(
            '^virtual-fitting-room/profile/([^/]+)/?',
            'index.php?save=$matches[1]',
            'top'
        );
        add_rewrite_tag( '%save%', '([^/]+)');
    }
}

// Initialize the plugin
$vfr_plugin = new Virtual_Fitting_Room;
