<?php
namespace Virtual_Fitting_Room\Core\Manage\Util;

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
			//Dashboard JS
            wp_enqueue_script(
                'profile/js',
                plugins_url( 'assets/js/profile.js', dirname( __FILE__ ) ),
                null,
                filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'assets/js/profile.js' ),
                TRUE
            );

            //Dashboard JS
            wp_enqueue_script(
                'dress-library/js',
                plugins_url( 'assets/js/dress-library.js', dirname( __FILE__ ) ),
                null,
                filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'assets/js/dress-library.js' ),
                TRUE
            );

            // LOCALIZE
            wp_localize_script( 'dress-library/js', 'VIRTUAL_FITTING_ROOM', array(
                    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
                    'nonce'         => wp_create_nonce( 'virtual_fitting_room' )
                )
            );

            // LOCALIZE
            wp_localize_script( 'profile/js', 'PROFILE', array(
                    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
                    'nonce'         => wp_create_nonce( 'virtual_fitting_room' ),
                    'dress_images_dir' => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/img/',
                    'uploads_dir'   => wp_upload_dir()['baseurl']
                )
            );
		}

	}
}