This file contains one function which creates default database tables for a WordPress (WP) theme after loading WP. The function uses "wpdb class" to create the required table if it doesn't exist. Function is fired by "init hook".

The function provides an option to add one preset row to the table. This is useful for tables where multiple rows are not needed (e.g. when editing settings, etc.).