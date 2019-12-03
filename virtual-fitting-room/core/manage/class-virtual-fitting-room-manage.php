<?php
namespace Virtual_Fitting_Room\Core\Manage;
use Virtual_Fitting_Room\Core\DB;

class Virtual_Fitting_Room_Manage {

	public function __construct() {
		// POST
		add_action( 'admin_post_vfr_add_dress', [$this, 'vfr_add_dress'] );

		// SHORTCODES
		add_shortcode( 'vfr_profile', [ $this, 'vfr_profile' ] );
		add_shortcode( 'vfr_dress_library', [ $this, 'vfr_dress_library' ] );

		add_action( 'wp_ajax_vfr_delete_dress', [ $this, 'vfr_delete_dress' ] );
		add_action( 'wp_ajax_vfr_delete_save', [ $this, 'vfr_delete_save' ] );
		add_action( 'wp_ajax_vfr_get_dress_location_by_id', [ $this, 'vfr_get_dress_location_by_id' ] );
	}

//*
//**
//***------------------------------------------------ AJAX ------------------------------------------------***//
//**
//*

	public function vfr_get_dress_location_by_id() {
		check_ajax_referer('virtual_fitting_room', 'nonce', false);

		$response = $this->get_dress_location_by_id();

		wp_die(json_encode($response));
	}

	public function get_dress_location_by_id() {
		$id = filter_var( $_POST['dress_id'], FILTER_SANITIZE_NUMBER_INT );
		return (new DB\VFR_Dresses_DB)->get($id)->dress_location;
	}

//*
//**
//***------------------------------------------------ POST ------------------------------------------------***//
//**
//*

	public function vfr_add_dress() {
		if( isset( $_POST['token'] ) && wp_verify_nonce($_POST['token'], 'virtual_fitting_room') ) {
			//FILE
			$dress_file = $this->upload_dress_file();

			$response = $this->add_dress( $dress_file );

			wp_redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function add_dress( $dress_file ) {
		return (new DB\VFR_Dresses_DB)->insert([
			'name' 						=> sanitize_text_field( $_POST['dress_name'] ),
			'description' 				=> sanitize_textarea_field( $_POST['dress_description'] ),
			'dress_obfuscated'      	=> $dress_file[0],
			'dress_name'      			=> $dress_file[1],
			'dress_location'      		=> $dress_file[2],
		]);
	}

	public function upload_dress_file() {
    	//UPLOAD FILE
		if ( ( ! empty( $_FILES ) ) && isset( $_FILES[ 'dress_file' ] ) ) {
			$filename = explode('.', strrev($_FILES['dress_file']['name']), 2);
			$name = strrev($filename[1]);
			$ext = strrev($filename[0]);
			$obfuscated = hash("gost", $name . mt_rand(1,10000));
	
			$file = wp_upload_bits( $obfuscated . '.' . $ext, null, @file_get_contents( $_FILES['dress_file']['tmp_name'] ) );
			$filelocation = explode( 'uploads', $file['file'])[1];
			// var_dump($filelocation);

			if ( FALSE === $file['error'] ) {
				// TODO	
				$error = true;	      			
			}
			return [$obfuscated, $name, $filelocation, $error];
		}
		return ['','',''];
    }

    public function vfr_delete_dress() {
		check_ajax_referer( 'virtual_fitting_room', 'nonce', false );

		$response = $this->delete_dress();

		wp_die(json_encode($response));
	}

	public function delete_dress() {
		return (new DB\VFR_Dresses_DB)->delete( filter_var( $_POST['dress_id'], FILTER_SANITIZE_NUMBER_INT ) );
	}

	public function vfr_delete_save() {
		check_ajax_referer( 'virtual_fitting_room', 'nonce', false );

		$response = $this->delete_save();

		wp_die(json_encode($response));
	}

	public function delete_save() {
		return (new DB\VFR_Main_DB)->delete( filter_var( $_POST['dress_id'], FILTER_SANITIZE_NUMBER_INT ) );
	}

//*
//**
//***------------------------------------------------ SHORTCODES ------------------------------------------------***//
//**
//*

	// [vfr_profile]
	public function vfr_profile( $atts ) {
		include_once( plugin_dir_path( __FILE__ ) . 'views/profile.php');
	}

	// [vfr_dress_library]
	public function vfr_dress_library( $atts ) {
		include_once( plugin_dir_path( __FILE__ ) . 'views/dress-library.php');
	}
 
}