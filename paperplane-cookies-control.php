<?php
/*
Plugin Name: Paperplane Cookies Control
Plugin URI: https://github.com/paperplanefactory/paperplane-cookies-control
description: A plugin to handle cookies and cookies notice banner, GDPR compliant. You need to activate <strong><a href="https://www.advancedcustomfields.com/pro/">ACF PRO</a></strong> to make Paperplane Cookie Control.
Version: 1.1.5
Author: Paperplane
Author URI: https://www.paperplanefactory.com
Copyright: Paperplane
GitHub Plugin URI: https://github.com/paperplanefactory/paperplane-cookies-control
*/

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
			 $load_css = get_field('use_own_css', 'option');
			 function paperplanecookies_load_styles() {
				 wp_enqueue_style( 'paperplanecookies-css', plugins_url( '/css/paperplanecookies.min.css', __FILE__ ) );
			 }
			 if ( $load_css == 1 ) {
				 add_action( 'wp_enqueue_scripts', 'paperplanecookies_load_styles' );
			 }


       // Registro il menu gestione cookies
       function paperplanecookies_register_menu() {
         // verifico che sia attivo Polylang
         if ( function_exists( 'PLL' ) ) {
           $langs_parameters = array(
             'hide_empty' => 0,
             'fields' => 'slug'
           );
           $languages = pll_languages_list($langs_parameters);
         }
         else {
           $languages = array('any-lang');
         }
				 $parent = acf_add_options_page( array (
					'page_title' => 'Plugin gestione cookie GDPR',
					'menu_title' => 'GDPR cookie options',
					'menu_slug'  => "plugin-gestione-cookie-gdpr",
					'capability'	=> 'edit_posts',
					'icon_url' => 'dashicons-lock'
				) );
				acf_add_options_sub_page( array (
					'page_title' => 'Opzioni di funzionamento',
					'menu_title' => 'Opzioni di funzionamento',
					'parent_slug' 	=> $parent['menu_slug'],
				) );


				 if ( $languages === 'any-lang' ) {
					 $setlang_nolang = $languages[0];
					 acf_add_options_sub_page( array (
						 'page_title' => 'Testi',
						 'menu_title' => 'Testi',
						 'menu_slug'  => "plugin-gestione-cookie-gdpr-testi-${$setlang_nolang}",
						 'post_id'    => $setlang_nolang,
						 'parent_slug' 	=> $parent['menu_slug'],
	 				) );
				 }
				 else {
						foreach ( $languages as $lang ) {
							acf_add_options_sub_page( array (
								'page_title' => 'Testi (' . strtoupper( $lang ) . ')',
								'menu_title' => __('Testi (' . strtoupper( $lang ) . ')', 'text-domain'),
								'menu_slug'  => "plugin-gestione-cookie-gdpr-testi-${lang}",
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
			 // Carico ACF JSON
				add_filter('acf/settings/load_json', function() {
					$paths[] = dirname(__FILE__) . '/acf-json-cookies';
					return $paths;
				});

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
