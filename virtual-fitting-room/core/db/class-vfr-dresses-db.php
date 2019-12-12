<?php
namespace Virtual_Fitting_Room\Core\DB;

class VFR_Dresses_DB extends Abstract_DB {

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   1.0
	**/
	public function __construct() {

		global $wpdb;

		$this->table_name 	= $wpdb->prefix . 'virtual_fitting_room_dresses';
		$this->primary_key 	= 'id';
		$this->version 		= '1.0';

	}

	/**
	 * Create the table
	 *
	 * @access  public
	 * @since   1.0
	**/
	public function create_table() {

		global $wpdb;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		$sql = "CREATE TABLE " . $this->table_name . " (
		id BIGINT (20) NOT NULL AUTO_INCREMENT,
		dress_obfuscated VARCHAR(64) NOT NULL,
		dress_name VARCHAR(255) NOT NULL,
		dress_location VARCHAR(90) NOT NULL,
		name VARCHAR (255) NOT NULL,
		description MEDIUMTEXT,
		PRIMARY KEY(id)
		) CHARACTER SET utf8 COLLATE utf8_general_ci;";

		dbDelta( $sql );

		update_option( $this->table_name, '_db_version', $this->version );
	}

	/**
	 * Get columns and formats
	 *
	 * @access  public
	 * @since   1.0
	**/
	public function get_columns() {
		return [
			'id'    			=> '%d',
			'dress_obfuscated' 	=> '%s',
			'dress_name' 		=> '%s',
			'dress_location' 	=> '%s',
			'name' 				=> '%s',
			'description' 		=> '%s'
		];
	}

	/**
	 * Get default column values
	 *
	 * @access  public
	 * @since   1.0
	**/
	public function get_column_defaults() {
		return [
			'dress_obfuscated' 	=> '',
			'dress_name' 		=> '',
			'dress_location' 	=> '',
			'name' 				=> '',
			'description' 		=> ''
		];
	}

	/**
	 * Return the number of results found for a given query
	 *
	 * @param  array  $args
	 * @return int
	**/
	public function count( $args = array() ) {
		return $this->get_dresses( $args, true );
	}

	/**
	 * Retrieve dresses from the database
	 *
	 * @access  public
	 * @since   1.0
	 * @param   array $args
	 * @param   bool  $count  Return only the total number of results found (optional)
	**/
	public function get_dresses( $args = array(), $count = false ) {

		global $wpdb;

		$defaults = array(
			'number'     		=> 20,
			'offset'       		=> 0,
			'id' 				=> 0,
			'orderby'      		=> 'id',
			'order'        		=> 'DESC',
		);

		$args = wp_parse_args( $args, $defaults );

		if( $args['number'] < 1 ) {
			$args['number'] = 999999999999;
		}
		$where = '';

		// Specific Where Parameters

		// ID
		if( ! empty( $args['id'] ) ) {
			if( is_array( $args['id'] ) ) {
				$ids = implode( ',', $args['id'] );
			} else {
				$ids = intval( $args['id'] );
			}
			$where .= "WHERE 'id' IN( {$ids} ) ";
		}

		$args['orderby'] = ! array_key_exists( $args['orderby'], $this->get_columns() ) ? $this->primary_key : $args['orderby'];
		
		$cache_key = ( true === $count ) ? md5( 'virtual_fitting_room_dresses_count' . serialize( $args ) ) : md5( 'virtual_fitting_room_dresses_' . serialize( $args ) );
		$results = wp_cache_get( $cache_key, 'virtual_fitting_room_dresses' );
		
		if ( false === $results ) {
			if ( true === $count ) {
				$results = absint( $wpdb->get_var( "SELECT COUNT({$this->primary_key}) FROM {$this->table_name} {$where};" ) );
			} else {
				$results = $wpdb->get_results(
					$wpdb->prepare(
						"SELECT * FROM {$this->table_name} {$where} ORDER BY {$args['orderby']} {$args['order']} LIMIT %d, %d;",
						absint( $args['offset'] ),
						absint( $args['number'] )
					)
				);
			}
			wp_cache_set( $cache_key, $results, 'virtual_fitting_room_dresses', 3600 );
		}
		
		return $results;

	}

}