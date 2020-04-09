<?php
/**
 * Plugin Name: Paperplane Cookies Control
 * Plugin URI: https://github.com/paperplanefactory/paperplane-cookies-control
 * Description: A plugin to handle cookies and cookies notice banner, GDPR compliant. You need to activate <strong><a href="https://www.advancedcustomfields.com/pro/">ACF PRO</a></strong> to make Paperplane Cookie Control.
 * Version: 1.2.6
 * Author: Paperplane
 * License: GNU General Public License v2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * GitHub Plugin URI: https://github.com/paperplanefactory/paperplane-cookies-control
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
		 require_once(plugin_dir_path( __FILE__ ) . '/inc/paperplane-cookies-code-localstorage.php');
		 require_once(plugin_dir_path( __FILE__ ) . '/inc/generate_fields.php');
		 // Salvo ACF JSON
		 // add_filter('acf/settings/save_json', 'my_acf_json_save_point', 20);
		 function my_acf_json_save_point( $path ) {
			 $path = plugin_dir_path( __FILE__ ).'/acf-json';
			 return $path;
		 }

		 // Carico ACF JSON
		 // add_filter('acf/settings/load_json', 'my_acf_json_load_point', 20);
		 function my_acf_json_load_point( $paths ) {
			 unset($paths[0]);
			 $paths[] = plugin_dir_path( __FILE__ ).'/acf-json';
			 return $paths;
			 var_dump($paths);
		 }

		 // Gestione caricamento CSS
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
			 $parent = acf_add_options_page(
				 array (
					 'page_title' => 'Plugin gestione cookie GDPR',
					 'menu_title' => 'GDPR cookie options',
					 'menu_slug'  => "plugin-gestione-cookie-gdpr",
					 'capability'	=> 'edit_posts',
					 'icon_url' => 'dashicons-lock'
				 )
			 );
			 acf_add_options_sub_page(
				 array (
					 'page_title' => 'Opzioni di funzionamento',
					 'menu_title' => 'Opzioni di funzionamento',
					 'parent_slug' 	=> $parent['menu_slug'],
				 )
			 );
			 if ( $languages === 'any-lang' ) {
				 $setlang_nolang = $languages[0];
				 acf_add_options_sub_page(
					 array (
						 'page_title' => 'Testi',
						 'menu_title' => 'Testi',
						 'menu_slug'  => "plugin-gestione-cookie-gdpr-testi-${$setlang_nolang}",
						 'post_id'    => $setlang_nolang,
						 'parent_slug' 	=> $parent['menu_slug'],
					 )
				 );
			 }
			 else {
				 foreach ( $languages as $lang ) {
					 acf_add_options_sub_page( array (
						 'page_title' => 'Testi (' . strtoupper( $lang ) . ')',
						 'menu_title' => __('Testi (' . strtoupper( $lang ) . ')', 'text-domain'),
						 'menu_slug'  => "plugin-gestione-cookie-gdpr-testi-${lang}",
						 'post_id'    => $lang,
						 'parent_slug' 	=> $parent['menu_slug'],
					 )
				 );
			 }
		 }
	 }
	 add_action( 'init', 'paperplanecookies_register_menu' );
	 // aggiungo gli stili ai campi ACF
	 add_action('admin_head', 'paperplanecookies_custom_acf');
	 function paperplanecookies_custom_acf() {
		 echo '<style>
		 #acf-group_5c9a313521c0c .acf-accordion-title {
			 background-color: #D8D8D8;
		 }
		 </style>';
	 }
 }
 else {
	 add_action( 'admin_notices', 'paperplane_cookies_plugin_error_notice' );
 }
 function paperplane_cookies_plugin_error_notice() {
	 ?>
	 <div class="error">
		 <p>Error: you need to activate <strong><a href="https://www.advancedcustomfields.com/pro/">ACF PRO</a> to make Paperplane Cookies Control work.</p>
		 </div>
	 <?php
 }
}
add_action( 'plugins_loaded', 'paperplaneCookies_init' );
