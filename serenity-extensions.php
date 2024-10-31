<?php
/*
Plugin Name: Serenity Theme Extensions
Plugin URI: https://www.themely.com/themes/serenity/
Description: This plugin adds custom widgets required by the Serenity WordPress theme developed by Themely.
Version: 1.1.2
Author: Themely
Author URI: https://www.themely.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! function_exists( 'add_action' ) ) {
	die( 'Nothing to do...' );
}

// Path/URL to root of this plugin, with trailing slash.
define( 'SERENITY_EXTENSIONS_PATH', plugin_dir_path( __FILE__ ) );
define( 'SERENITY_EXTENSIONS_URL', plugin_dir_url( __FILE__ ) );

// Require main plugin file.
require SERENITY_EXTENSIONS_PATH . 'inc/widgets.php';