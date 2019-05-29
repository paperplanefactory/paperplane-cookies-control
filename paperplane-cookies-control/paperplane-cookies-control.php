<?php
/*
Plugin Name: Paperplane Cookies Control
Plugin URI: https://www.paperplanefactory.com
description: A plugin to handle cookies and cookies notice banner, GDPR compliant. You need to activate <strong><a href="https://www.advancedcustomfields.com/pro/">ACF PRO</a></strong> to make Paperplane Cookie Control.
Version: 1.1.0
Author: Paperplane
Author URI: https://www.paperplanefactory.com
Copyright: Paperplane
*/

require plugin_dir_path( __FILE__ ) . '/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://plugins.paperplanefactory.com/cookies/paperplane-cookie-check.json',
	__FILE__, //Full path to the main plugin file or functions.php.
	'paperplane-cookie'
);

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register our text domain.
 *
 * @since 0.8.0
 *
 * @internal
 */

 function paperplaneCookies_init() {
	 if( class_exists( 'ACF' ) ) {
		 add_action( 'wp_enqueue_scripts', 'paperplanecookies_scripts' );
     function paperplanecookies_scripts() {
			 if (!is_admin()) {
				 $handle_jquerylib = 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js';
			   $list_jquerylib = 'enqueued';
				 if ( wp_script_is( $handle_jquerylib, $list_jquerylib ) ) {
		       return;
		     }
         else {
					 wp_deregister_script('jquery');
					 wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', '', '3.2.1', false);
					 wp_enqueue_script('jquery');
		     }
			 }
			 // Cookies library
			 $handle = 'https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js';
		   $list = 'enqueued';
		     if ( wp_script_is( $handle, $list ) ) {
		       return;
		     }
         else {
					 wp_register_script( 'js-cookie', 'https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js', '', '2.2.0', false);
					 wp_enqueue_script( 'js-cookie' );
		     }
       }
			 function paperplanecookies_load_styles() {
				 wp_enqueue_style( 'paperplanecookies-css', plugins_url( '/css/paperplanecookies.min.css', __FILE__ ) );
			 }
			 add_action( 'wp_enqueue_scripts', 'paperplanecookies_load_styles' );

       // Registro il menu gestione cookies
       function paperplanecookies_register_menu() {
         // verifico che sia attivo Polylang
         if ( function_exists( 'PLL' ) ) {
           $langs_parameters = array(
             'hide_empty' => 0,
             'fields' => 'slug'
           );
           $languages = pll_languages_list($args);
         }
         else {
           $languages = array('any-lang');
         }
				 if ( $languages === 'any-lang' ) {
					 acf_add_options_page( array (
						 'page_title' => 'Plugin gestione cookie GDPR (' . strtoupper( $lang ) . ')',
						 'menu_title' => __('GDPR cookie options (' . strtoupper( $lang ) . ')', 'text-domain'),
						 'menu_slug'  => "plugin-gestione-cookie-gdpr-${lang}",
						 'post_id'    => $lang,
						 'parent_slug' 	=> $parent['menu_slug'],
						 'icon_url' => 'dashicons-lock'
					 ) );
				 }
				 else {
					 $parent = acf_add_options_page(array(
							'page_title' 	=> 'GDPR cookie options',
							'menu_title'	=> 'GDPR cookie options',
							'capability'	=> 'edit_posts',
							'icon_url' => 'dashicons-lock'
						));
						foreach ( $languages as $lang ) {
							acf_add_options_sub_page( array (
								'page_title' => 'Plugin gestione cookie GDPR (' . strtoupper( $lang ) . ')',
								'menu_title' => __('GDPR cookie options (' . strtoupper( $lang ) . ')', 'text-domain'),
								'menu_slug'  => "plugin-gestione-cookie-gdpr-${lang}",
								'post_id'    => $lang,
								'parent_slug' 	=> $parent['menu_slug'],
							) );
						}
					}
       }
       add_action( 'init', 'paperplanecookies_register_menu' );
			 // aggiungo gli stivli ai campi ACF
			 add_action('admin_head', 'paperplanecookies_custom_acf');
			 function paperplanecookies_custom_acf() {
				 echo '<style>
				 #acf-group_5c9a313521c0c .acf-accordion-title {
					 background-color: #D8D8D8;
				 }
				 </style>';
			 }
			 // Salvo ACF JSON
	     add_filter('acf/settings/save_json', 'paperplanecookies_json_save_point');
	     function paperplanecookies_json_save_point( $path ) {
	       $path = plugin_dir_path( __FILE__ ) . 'acf-json-cookies';
	       return $path;
	     }

	     // Carico ACF JSON
	     add_filter('acf/settings/load_json', 'paperplanecookies_json_load_point');
	     function paperplanecookies_json_load_point( $paths ) {
	       $paths[] = plugin_dir_path( __FILE__ ) . 'acf-json-cookies';
	       return $paths;
	     }
       // Genero i campi necessari alle impostazioni
       require_once(plugin_dir_path( __FILE__ ) . '/inc/generate_fields.php');
			 require_once(plugin_dir_path( __FILE__ ) . '/inc/paperplane-cookies-code.php');
     }
		 else {
	 		add_action( 'admin_notices', 'paperplane_cookies_plugin_error_notice' );
	 	}
	 	function paperplane_cookies_plugin_error_notice() {
	 		?>
	 		<div class="error">
	 			<p>Error: you need to activate <strong><a href="https://www.advancedcustomfields.com/pro/">ACF PRO</a> to make Paperplane Cookies Control work.</p>
	 		</div>
	 		<?php }

   }

 	add_action( 'plugins_loaded', 'paperplaneCookies_init' );
