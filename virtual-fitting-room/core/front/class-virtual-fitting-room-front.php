<?php
namespace Virtual_Fitting_Room\Core\Front;
use Virtual_Fitting_Room\Core\DB;

class Virtual_Fitting_Room_Front {

	public function __construct() {
		// POST
		add_action( 'admin_post_vfr_insert_form', [$this, 'vfr_insert_form'] );
		add_action( 'admin_post_nopriv_vfr_insert_form', [$this, 'vfr_insert_form'] );

		// SHORTCODES
		add_shortcode( 'vfr_home', [ $this, 'vfr_home' ] );
		add_shortcode( 'vfr_body_visualizer', [ $this, 'vfr_body_visualizer' ] );
		add_shortcode( 'vfr_submission_confirmation', [ $this, 'vfr_submission_confirmation' ] );
	}

	public function create_pages() {
		$form_page = array(
			'post_title'    => 'Virtual Fitting Room',
			'post_content'  => '[vfr_form]',
			'post_status'   => 'publish',
			'post_author'   => get_current_user_id(),
			'post_type'     => 'page',
			// 'page_template' => 'template-blank.php',
		);
		$id = wp_insert_post( $form_page );

		$confirmation_page = array(
			'post_title'    => 'Submission Confirmation',
			'post_parent'	  => $id,
			'post_content'  => '[vfr_submission_confirmation]',
			'post_status'   => 'publish',
			'post_author'   => get_current_user_id(),
			'post_type'     => 'page',
			// 'page_template' => 'template-blank.php',
		);
		wp_insert_post( $confirmation_page );
	}

//*
//**
//***------------------------------------------------ POST ------------------------------------------------***//
//**
//*

	public function vfr_insert_form() {
		if( isset( $_POST['token'] ) && wp_verify_nonce($_POST['token'], 'virtual_fitting_room') ) {
			
			$response = $this->insert_form();

			if($response)
				$this->redirect($response);
		}
	}

	public function redirect($id) {
		//Redirect to confirmation page w/ query arguments
		$url = get_permalink(get_page_by_title( 'Submission Confirmation' ));
		$url = add_query_arg( [
			'save_id' => urlencode($id)
		], $url);
		wp_redirect( $url );
	}

	public function insert_form() {
		$form_fields = array(
			'height' 		=> filter_var( $_POST['height'], FILTER_SANITIZE_NUMBER_INT ),
			'chest' 		=> filter_var( $_POST['chest'],  FILTER_SANITIZE_NUMBER_INT ),
			'waist' 		=> filter_var( $_POST['waist'],  FILTER_SANITIZE_NUMBER_INT ),
			'hips' 			=> filter_var( $_POST['hips'],   FILTER_SANITIZE_NUMBER_INT ),
			'inseam' 		=> filter_var( $_POST['inseam'], FILTER_SANITIZE_NUMBER_INT ),
			'dress' 		=> filter_var( $_POST['dress'],  FILTER_SANITIZE_NUMBER_INT )
		);

		return (new DB\VFR_Main_DB)->insert([
			'title' 		=> sanitize_text_field( $_POST['title'] ),
			'user_id' 		=> get_current_user_id(),
			'height' 		=> $form_fields['height'],
			'chest' 		=> $form_fields['chest'],
			'waist' 		=> $form_fields['waist'],
			'hips' 			=> $form_fields['hips'],
			'seam' 			=> $form_fields['inseam'],
			'dress_id' 		=> $form_fields['dress'], 
			'dress_size' 	=> $this->calculate_dress_size($form_fields),
			'date' 			=> date('Y-m-d H:i:s')
		]);
	}

	public function calculate_dress_size( $args = array() ) {
		$defaults = array(
			'height'     		=> 66,
			'chest'       		=> 37,
			'waist' 			=> 30,
			'hips'      		=> 40,
			'inseam'        	=> 30
		);

		$args = wp_parse_args( $args, $defaults );

		$height = $args['height'];
		$chest = $args['chest'];
		$waist = $args['waist'];
		$hips = $args['hips'];
		$inseam = $args['inseam'];

		$score = 0;
		$size = "";

		/**
		 * Scale
		 *
		 * Height: 50 - 80
		 * Chest: 21 - 56
		 * waist: 15 - 50
		 * hips: 28 - 58
		 * inseam: 20 - 40
		 */

		/**
		 * Sizes
		 *
		 * XS
		 * S
		 * M
		 * L
		 * XL
		 */

		if( $height <= 55 ) { // 50 - 55
			$score += 1;
		} elseif( $height >= 56 && $height <= 61 ) { // 56 - 61
			$score += 2;
		} elseif( $height >= 62 && $height <= 68 ) { // 62 - 68
			$score += 3;
		} elseif( $height >= 69 && $height <= 74 ) { // 69 - 74
			$score += 4;
		} elseif( $height >= 75 ) { // 75 - 80
			$score += 5;
		}

		if( $chest <= 27 ) { // 21 - 27
			$score += 1;
		} elseif( $chest >= 28 && $chest <= 35 ) { // 28 - 35
			$score += 2;
		} elseif( $chest >= 36 && $chest <= 42 ) { // 36 - 42
			$score += 3;
		} elseif( $chest >= 43 && $chest <= 49 ) { // 43 - 49
			$score += 4;
		} elseif( $chest >= 50 ) { // 50 - 56
			$score += 5;
		}

		if( $waist <= 22 ) { // 15 - 22
			$score += 1;
		} elseif( $waist >= 23 && $waist <= 29 ) { // 23 - 29
			$score += 2;
		} elseif( $waist >= 30 && $waist <= 36 ) { // 30 - 36
			$score += 3;
		} elseif( $waist >= 37 && $waist <= 43 ) { // 37 - 43
			$score += 4;
		} elseif( $waist >= 44 ) { // 44 - 50
			$score += 5;
		}

		if( $hips <= 33 ) { // 28 - 33
			$score += 1;
		} elseif( $hips >= 34 && $hips <= 40 ) { // 34 - 40
			$score += 2;
		} elseif( $hips >= 41 && $hips <= 46 ) { // 41 - 46
			$score += 3;
		} elseif( $hips >= 47 && $hips <= 52 ) { // 47 - 52
			$score += 4;
		} elseif( $hips >= 53 ) { // 53 - 58
			$score += 5;
		}

		if( $inseam <= 24 ) { // 20 - 24
			$score += 1;
		} elseif( $inseam >= 25 && $inseam <= 28 ) { // 25 - 28
			$score += 2;
		} elseif( $inseam >= 29 && $inseam <= 32 ) { // 29 - 32
			$score += 3;
		} elseif( $inseam >= 33 && $inseam <= 36 ) { // 33 - 36
			$score += 4;
		} elseif( $inseam >= 37 ) { // 37 - 40
			$score += 5;
		}

		// 
		if( $score <= 5 ) { // 28 - 33
			$size = "XS";
		} elseif( $score >= 6 && $score <= 10 ) { // 34 - 40
			$size = "S";
		} elseif( $score >= 11 && $score <= 15 ) { // 41 - 46
			$size = "M";
		} elseif( $score >= 16 && $score <= 20 ) { // 47 - 52
			$size = "L";
		} elseif( $score >= 21 ) { // 53 - 58
			$size = "XL";
		}

		return $size;

	}

//*
//**
//***------------------------------------------------ SHORTCODES ------------------------------------------------***//
//**
//*

	// [vfr_home]
	public function vfr_home( $atts ) {
		include_once( plugin_dir_path( __FILE__ ) . 'views/home.php');
	}

	// [vfr_body_visualizer]
	public function vfr_body_visualizer( $atts ) {
		include_once( plugin_dir_path( __FILE__ ) . 'views/body_visualizer.php');
	}

	// [vfr_submission_confirmation]
	public function vfr_submission_confirmation( $atts ) {
		include_once( plugin_dir_path( __FILE__ ) . 'views/submission-confirmation.php');
	}
 
}