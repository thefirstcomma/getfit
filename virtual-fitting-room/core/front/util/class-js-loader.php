<?php
namespace Virtual_Fitting_Room\Core\Front\Util;

/**
 * Provides a consistent way to enqueue all administrative-related stylesheets.
 */
 
/**
 * Provides a consistent way to enqueue all administrative-related stylesheets.
 *
 * Implements the Assets_Interface by defining the init function and the
 * enqueue function.
 *
 * The first is responsible for hooking up the enqueue
 * callback to the proper WordPress hook. The second is responsible for
 * actually registering and enqueuing the file.
 *
 * @implements Assets_Interface
 * @since      0.2.0
 */
class JS_Loader implements Assets_Interface {

	/**
	 * Registers the 'enqueue' function with the proper WordPress hook for
	 * registering stylesheets.
	 */
	public function __construct() {
 
		add_action(
			'wp_enqueue_scripts',
			[ $this, 'enqueue' ]
		);
 
	}

	/**
	 * Defines the functionality responsible for loading the file.
	 */
	public function enqueue() {
		global $post;
		
		if( 1 ) {
			// wp_enqueue_script( 
			// 	'jQuery/js', 
			// 	'//code.jquery.com/jquery-3.2.1.slim.min.js', 
			// 	array(), 
			// 	NULL, 
			// 	true
			// );
			// wp_enqueue_script( 
			// 	'popper/js', 
			// 	'//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', 
			// 	['jQuery'], 
			// 	NULL, 
			// 	false
			// );
			// wp_enqueue_script( 
			// 	'bootstrap/js', 
			// 	'//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', 
			// 	['jQuery'], 
			// 	NULL, 
			// 	false
			// );
		}

	}
}