<?php
require SERENITY_EXTENSIONS_PATH . 'widgets/feature_widget.php';
require SERENITY_EXTENSIONS_PATH . 'widgets/service_widget.php';
require SERENITY_EXTENSIONS_PATH . 'widgets/testimonial_widget.php';
require SERENITY_EXTENSIONS_PATH . 'widgets/team_widget.php';
/*
*	Check for Pro Version
*/
$theme = wp_get_theme(); // gets the current theme
if ( 'Serenity Pro' == $theme->name || 'Serenity Pro' == $theme->parent_theme ) {
    require SERENITY_EXTENSIONS_PATH . 'widgets/hero_widget.php';
    require SERENITY_EXTENSIONS_PATH . 'widgets/bar_widget.php';
    require SERENITY_EXTENSIONS_PATH . 'widgets/counter_widget.php';
    require SERENITY_EXTENSIONS_PATH . 'widgets/pricing_widget.php';
    require SERENITY_EXTENSIONS_PATH . 'widgets/showcase_widget.php';
}
add_action( 'admin_enqueue_scripts', 'serenity_extensions_upload_script' );
add_action( 'admin_enqueue_scripts', 'serenity_extensions_color_picker' );
add_action( 'wp_head', 'serenity_extensions_image_styles' );
/*
* Script for media uploader
*/
function serenity_extensions_upload_script($hook){
    if ( 'widgets.php' != $hook ) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script('serenity-wcp-uploader', SERENITY_EXTENSIONS_URL . 'js/admin.js', array('jquery') );
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('jquery-ui-core');
}
/*
* Styles for image previews
*/
function serenity_extensions_image_styles() {
	wp_register_style('serenity-wcp-image-styles', SERENITY_EXTENSIONS_URL . 'css/widgets.css' );
}
/**
 * Script and styles for color picker.
*/
function serenity_extensions_color_picker() {    
    wp_enqueue_style( 'wp-color-picker' );        
    wp_enqueue_script( 'wp-color-picker' );    
}