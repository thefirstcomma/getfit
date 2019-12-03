<?php
namespace Virtual_Fitting_Room\Core\DB;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * DB base class | https://pippinsplugins.com/custom-database-api-the-basic-api-class/
 *
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.1
**/
abstract class Abstract_DB {

	/**
	 * The name of our database table
	 *
	 * @access  public
	 * @since   2.1
	**/
	public $table_name;
	
	/**
	 * The version of our database table
	 *
	 * @access  public
	 * @since   2.1
	**/
	public $version;

	/**
	 * The name of the primary column
	 *
	 * @access  public
	 * @since   2.1
	**/
	public $primary_key;
	
	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   2.1
	**/
	public function __construct() {}
	
	/**
	 * Whitelist of columns
	 *
	 * @access  public
	 * @since   2.1
	 * @return  array
	**/
	public function get_columns() {
		return array();
	}
	
	/**
	 * Default column values
	 *
	 * @access  public
	 * @since   2.1
	 * @return  array
	**/
	public function get_column_defaults() {
		return array();
	}
	
	/**
	 * Retrieve a row by the primary key
	 *
	 * @access  public
	 * @since   2.1
	 * @return  object
	**/
	public function get( $row_id ) {

		global $wpdb;

		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->table_name WHERE $this->primary_key = %s LIMIT 1;", $row_id ) );

	}
	
	/**
	 * Retrieve a row by a specific column / value
	 *
	 * @access  public
	 * @since   2.1
	 * @return  object
	**/
	public function get_by( $column, $row_id ) {

		global $wpdb;

		$column = esc_sql( $column );

		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $this->table_name WHERE $column = %s LIMIT 1;", $row_id ) );

	}
	
	/**
	 * Retrieve a specific column's value by the primary key
	 *
	 * @access  public
	 * @since   2.1
	 * @return  string
	**/
	public function get_column( $column, $row_id ) {

		global $wpdb;

		$column = esc_sql( $column );

		return $wpdb->get_var( $wpdb->prepare( "SELECT $column FROM $this->table_name WHERE $this->primary_key = %s LIMIT 1;", $row_id ) );

	}
	
	/**
	 * Retrieve a specific column's value by the the specified column / value
	 *
	 * @access  public
	 * @since   2.1
	 * @return  string
	**/
	public function get_column_by( $column, $column_where, $column_value ) {
		
		global $wpdb;

		$column_where = esc_sql( $column_where );

		$column 	  = esc_sql( $column );

		return $wpdb->get_var( $wpdb->prepare( "SELECT $column FROM $this->table_name WHERE $column_where = %s LIMIT 1;", $column_value ) );

	}

	/**
	 * Insert a new row
	 *
	 * @access  public
	 * @since   2.1
	 * @return  int
	**/
	public function insert( $args, $type = '' ) {
		
		global $wpdb;

		// Set default v alues
		$args = wp_parse_args( $args, $this->get_column_defaults() );

		do_action( 'base_pre_insert_' . $type, $args );
	
		// Initialize column format array
		$column_formats = $this->get_columns();

		// Force fields to lower case
		$args = array_change_key_case( $args );
		
		// White list columns
		$args = array_intersect_key( $args, $column_formats );

		// Reorder $column_formats to match t h e order of columsn given in $args
		$args_keys = array_keys( $args );
		$column_formats = array_merge( array_flip( $args_keys ), $column_formats );

		$wpdb->insert( $this->table_name, $args, $column_formats );

		do_action( 'base_post_insert_' . $type, $wpdb->insert_id, $args );

		return $wpdb->insert_id;

	}
	/**
	 * Update a row
	 *
	 * @access  public
	 * @since   2.1
	 * @return  bool
	**/
	public function update( $row_id, $args = [], $where = '' ) {

		global $wpdb;

		// Row ID must be positive integer
		$row_id = absint( $row_id );

		if( empty( $row_id ) ) return false;

		if( empty( $where ) ) {
			$where = $this->primary_key;
		}

		// Initialize column format array
		$column_formats = $this->get_columns();

		// Force fields to lower case
		$args = array_change_key_case( $args );

		// White list columns
		$args = array_intersect_key( $args, $column_formats );

		// Reorder $column_formats to match t h e order of columsn given in $args
		$args_keys = array_keys( $args );
		$column_formats = array_merge( array_flip( $args_keys ), $column_formats );

		if( false === $wpdb->update( $this->table_name, $args, [ $where => $row_id ], $column_formats ) ) return false;

		return true;

	}
	
	/**
	 * Delete a row identified by the primary key
	 *
	 * @access  public
	 * @since   2.1
	 * @return  bool
	**/
	public function delete( $row_id = 0 ) {

		global $wpdb;

		// Row ID must be positive integer
		$row_id = absint( $row_id );

		if( empty( $row_id ) ) return false;

		if( false === $wpdb->query( $wpdb->prepare( "DELETE FROM $this->table_name WHERE $this->primary_key = %d", $row_id ) ) ) return false;

		return true;

	}
	
	/**
	 * Check if the given table exists
	 *
	 * @since  2.4
	 * @param  string $table The table name
	 * @return bool          If the table name exists
	**/
	public function table_exists( $table ) {

		global $wpdb;
		$table = sanitize_text_field( $table );

		return $wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE '%s'", $table ) ) === $table;

	}

}