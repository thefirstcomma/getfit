<?php
namespace Virtual_Fitting_Room\Core\DB;

class VFR_Main_DB extends Abstract_DB {

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since   1.0
	**/
	public function __construct() {

		global $wpdb;

		$this->table_name 	= $wpdb->prefix . 'virtual_fitting_room';
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
		user_id BIGINT (20) NOT NULL,
		height MEDIUMINT NOT NULL,
		chest MEDIUMINT NOT NULL,
		waist MEDIUMINT NOT NULL,
		hips MEDIUMINT NOT NULL,
		seam MEDIUMINT NOT NULL,
		dress_id BIGINT (20),
		dress_size TINYTEXT,
		title MEDIUMTEXT NOT NULL,
		date DATETIME NOT NULL,
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
			'id'    		=> '%d',
			'user_id'    	=> '%d',
			'height'    	=> '%d',
			'chest' 		=> '%d',
			'waist' 		=> '%d',
			'hips' 			=> '%d',
			'seam' 			=> '%d',
			'dress_id' 		=> '%d',
			'dress_size' 	=> '%s',
			'title' 		=> '%s',
			'date'			=> '%s'
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
			'user_id'    	=> 0,
			'height'    	=> 0,
			'chest' 		=> 0,
			'waist' 		=> 0,
			'hips' 			=> 0,
			'seam' 			=> 0,
			'dress_id' 		=> 0,
			'dress_size' 	=> '',
			'title' 		=> '',
			'date' 			=> date( 'Y-m-d H:i:s' )
		];
	}

	/**
	 * Return the number of results found for a given query
	 *
	 * @param  array  $args
	 * @return int
	**/
	public function count( $args = array() ) {
		return $this->get_records( $args, true );
	}

	/**
	 * Retrieve applications from the database
	 *
	 * @access  public
	 * @since   1.0
	 * @param   array $args
	 * @param   bool  $count  Return only the total number of results found (optional)
	**/
	public function get_records( $args = array(), $count = false ) {

		global $wpdb;

		$defaults = array(
			'number'     		=> 20,
			'offset'       		=> 0,
			'id' 				=> 0,
			'user_id' 			=> 0,
			'title' 			=> '',
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
			$where .= "WHERE id IN( {$ids} ) ";
		}

		if( ! empty( $args['user_id'] ) ) {
			if( is_array( $args['user_id'] ) ) {
				$user_ids = implode( ',', $args['user_id'] );
			} else {
				$user_ids = intval( $args['user_id'] );
			}
			$where .= "WHERE user_id IN( {$user_ids} ) ";
		}

		// dress ID
		if( ! empty( $args['dress_id'] ) ) {
			if( is_array( $args['dress_id'] ) ) {
				$dress_ids = implode( ',', $args['dress_id'] );
			} else {
				$dress_ids = intval( $args['dress_id'] );
			}
			$where .= "WHERE dress_id IN( {$dress_ids} ) ";
		}

		if( ! empty( $args['title'] ) ) {
			if( empty( $where ) ) {
				$where .= " WHERE";
			} else {
				$where .= " AND";
			}
			if( is_array( $args['title'] ) ) {
				$where .= " 'title' IN(" . implode( ',', $args['title'] ) . ") ";
			} else {
				if( ! empty( $args['search'] ) ) {
					$where .= " title LIKE '%%" . $args['title'] . "%%' ";
				} else {
					$where .= " title = '" . $args['title'] . "' ";
				}
			}
		}

		if( ! empty( $args['date'] ) ) {
			if( is_array( $args['date'] ) ) {
				if( ! empty( $args['date']['start'] ) ) {
					if( false !== strpos( $args['date']['start'], ':' ) ) {
						$format = 'Y-m-d H:i:s';
					} else {
						$format = 'Y-m-d 00:00:00';
					}
					$start = date( $format, strtotime( $args['date']['start'] ) );
					if( ! empty( $where ) ) {
						$where .= " AND date >= '{$start}'";
					} else {
						$where .= " WHERE date >= '{$start}'";
					}
				}
				if( ! empty( $args['date']['end'] ) ) {
					if( false !== strpos( $args['date']['end'], ':' ) ) {
						$format = 'Y-m-d H:i:s';
					} else {
						$format = 'Y-m-d 23:59:59';
					}
					$end = date( $format, strtotime( $args['date']['end'] ) );
					if( ! empty( $where ) ) {
						$where .= " AND 'date' <= '{$end}'";
					} else {
						$where .= " WHERE 'date' <= '{$end}'";
					}
				}
			} else {
				$year  = date( 'Y', strtotime( $args['date'] ) );
				$month = date( 'm', strtotime( $args['date'] ) );
				$day   = date( 'd', strtotime( $args['date'] ) );
				if( empty( $where ) ) {
					$where .= " WHERE";
				} else {
					$where .= " AND";
				}
				$where .= " $year = YEAR ( date ) AND $month = MONTH ( date ) AND $day = DAY ( date )";
			}
		}

		$args['orderby'] = ! array_key_exists( $args['orderby'], $this->get_columns() ) ? $this->primary_key : $args['orderby'];
		
		$cache_key = ( true === $count ) ? md5( 'virtual_fitting_room_records_count' . serialize( $args ) ) : md5( 'virtual_fitting_room_records_' . serialize( $args ) );
		$results = wp_cache_get( $cache_key, 'virtual_fitting_room_records' );
		
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
			wp_cache_set( $cache_key, $results, 'virtual_fitting_room_records', 3600 );
		}
		
		return $results;

	}

}