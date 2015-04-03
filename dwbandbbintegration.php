<?php
/*
 * Plugin Name: Dynamik Website Builder and Beaver Builder Integration
 * Plugin URI: http://www.jumptoweb.com
 * Description: This plugin integrates Beaver Builder plugin with the theme Dynamik Website Builder, and create two page templates, one full width and a landing page.
 * Version: 1.0
 * Author: Manuel Costales
 * Author URI: http://www.manuelcostales.com
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); //check for plugin
$theme = wp_get_theme(); // gets the current theme

//Admin Notice to show if the requirements doesn't met
function my_admin_notice() {
    echo '<div class="error"><p>Sorry, but this plugin required the theme 
    [Dynamik Website Builder](http://cobaltapps.com/downloads/dynamik-website-builder)
     and the plugin 
    [Beaver Builder](https://www.wpbeaverbuilder.com) 
    to be installed and active. | <a href="'.admin_url('plugins.php').'">Hide Notice</a></p></div>';
}

if ( is_plugin_active('bb-plugin/fl-builder.php') && ('Dynamik-Gen' == $theme->name && 'Genesis' == $theme->parent_theme) ) {
//Plugin start...    
class PageTemplater {
        /*
         * A Unique Identifier
         */
	       protected $plugin_slug;
        /*
         * A reference to an instance of this class.
         */
                private static $instance;
        /*
         * The array of templates that this plugin tracks.
         */
                protected $templates;
        /*
         * Returns an instance of this class. 
         */
                public static function get_instance() {
                        if( null == self::$instance ) {
                                self::$instance = new PageTemplater();
                        } 
                        return self::$instance;
                } 
        /*
         * Initializes the plugin by setting filters and administration functions.
         */
                private function __construct() {
                        $this->templates = array();
                        // Add a filter to the attributes metabox to inject template into the cache.
                        add_filter(
        					'page_attributes_dropdown_pages_args',
        					 array( $this, 'register_project_templates' ) 
        				);
                        // Add a filter to the save post to inject out template into the page cache
                        add_filter(
        					'wp_insert_post_data', 
        					array( $this, 'register_project_templates' ) 
        				);
                        // Add a filter to the template include to determine if the page has our 
        				// template assigned and return it's path
                        add_filter(
        					'template_include', 
        					array( $this, 'view_project_template') 
        				);
                        // Add your templates to this array.
                        $this->templates = array(
                                'beaver-builder.php'     => 'Beaver Builder',
                                'beaver-builder-landing.php'     => 'Beaver Builder Landing Page',
                        );
        				
                } 
        /*
         * Adds our template to the pages cache in order to trick WordPress
         * into thinking the template file exists where it doens't really exist.
         *
         */
                public function register_project_templates( $atts ) {
                        // Create the key used for the themes cache
                        $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
                        // Retrieve the cache list. 
        				// If it doesn't exist, or it's empty prepare an array
        				$templates = wp_get_theme()->get_page_templates();
                        if ( empty( $templates ) ) {
                                $templates = array();
                        } 
                        // New cache, therefore remove the old one
                        wp_cache_delete( $cache_key , 'themes');
                        // Now add our template to the list of templates by merging our templates
                        // with the existing templates array from the cache.
                        $templates = array_merge( $templates, $this->templates );
                        // Add the modified cache to allow WordPress to pick it up for listing
                        // available templates
                        wp_cache_add( $cache_key, $templates, 'themes', 1800 );
                        return $atts;
                } 
        /*
         * Checks if the template is assigned to the page
         */
                public function view_project_template( $template ) {
                        global $post;
                        if (!isset($this->templates[get_post_meta( 
        					$post->ID, '_wp_page_template', true 
        				)] ) ) {
        					
                                return $template;
        						
                        } 
                        $file = plugin_dir_path(__FILE__). get_post_meta( 
        					$post->ID, '_wp_page_template', true 
        				);
        				
                        // Just to be safe, we check if the file exist first
                        if( file_exists( $file ) ) {
                                return $file;
                        } 
        				else { echo $file; }
                        return $template;
                } 
} 
add_action( 'plugins_loaded', array( 'PageTemplater', 'get_instance' ) );

/*
 * Load css styles
 */
function add_dwbanddd_styles_mc() {
	wp_enqueue_style( 'beaver-builder-css',  plugins_url( 'style.css', __FILE__ ) );
}
add_action('wp_head', 'add_dwbanddd_styles_mc');
}
//if the conditions aren't met
else{
    deactivate_plugins( plugin_basename( __FILE__ ) );
    unset( $_GET['activate'] );
    add_action( 'admin_notices', 'my_admin_notice' );
}
?>