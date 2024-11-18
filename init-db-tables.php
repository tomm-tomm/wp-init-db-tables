<?php
/**
 * Create default database tables for a WordPress theme after loading WordPress.
 *
 * @package WordPress
 * @subpackage Random Theme
 * @since Random Theme 1.0.0
 */

/*
 * Create default db tables
 */

// @return: new db tables
function create_default_tables() {

    // List of tables
    // @params in subarray:
    // table name => string
    // creating default row indicator => int [0 or 1] (for tables with one row only / f.e. site with form)
    $table_names_array = array (
        array( 'random_table_1', 0 ),
        array( 'random_table_2', 1 )
    );

    // Table column arrays
    $table_columns_array = array(
        /* Table #1 with random columns  */
        'id int(7) UNSIGNED NOT NULL AUTO_INCREMENT,
         name varchar(64) NOT NULL,
         surname varchar(64) NOT NULL,
         institute varchar(128) NOT NULL,
         mail varchar(64) NOT NULL,
         created_at datetime NOT NULL,
         changed_at datetime NOT NULL,
         PRIMARY KEY  (id)',
        /* Table #2 with random columns  */
        'id int(7) UNSIGNED NOT NULL AUTO_INCREMENT,
         custom_css text NOT NULL,
         created_at datetime NOT NULL,
         changed_at datetime NOT NULL,
         PRIMARY KEY  (id)' );

    // Initialize WP database functions
    global $wpdb;

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    // Create tables
    $charset = 'utf8';

    // Number of tables
    $tables_count = count( $table_names_array );

    // Date of creation
    $now = date( 'Y-m-d H:i:s' );

    // For each table do create query
    for ( $i = 0; $i < $tables_count; $i++ ) {

        // Get names from arrays above
        $table_name = $wpdb->prefix . $table_names_array[ $i ][ 0 ];
        $table_column = $table_columns_array[ $i ];

        // Create table query
        $sql = "
        CREATE TABLE IF NOT EXISTS $table_name (
        $table_column
        ) DEFAULT CHARSET=$charset;";

        // Execute create table query
        dbDelta( $sql );

        // Insert default row if required
        if ( $table_names_array[ $i ][ 1 ] == 1 ) {

            $wpdb->insert( $table_name,
                        array( 'id' => 1,
                               'created_at' => $now ),
                        array( '%d', '%s' ) );

        }

        // Check for MySQL error
        // If error
        if ( $wpdb->last_error ) {
            _e( 'Error:', 'random-theme' ) . $wpdb->last_error;
        } else {
            // No error
            _e( 'Database tables were successfully created.', 'random-theme' );
        }

    }

}