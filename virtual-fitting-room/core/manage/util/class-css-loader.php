<?php
namespace Virtual_Fitting_Room\Core\Manage\Util;
 
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
class CSS_Loader implements Assets_Interface {
 
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
            // wp_enqueue_style(
            //     'home/css', 
            //     plugins_url( 'assets/css/home.css', dirname( __FILE__ ) ),
            //     array(),
            //     filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'assets/css/home.css' ),
            //     'all'
            // );

            // wp_enqueue_style(
            //     'rise-application-form/css',
            //     plugins_url( 'assets/styles/rise-application-form.css', dirname( __FILE__ ) ),
            //     [],
            //     filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'assets/styles/rise-application-form.css' )
            // );
        }
 
    }
}