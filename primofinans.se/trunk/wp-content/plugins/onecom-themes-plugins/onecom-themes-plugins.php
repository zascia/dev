<?php
/**
 * Plugin Name: 	one.com themes and plugins
 * Plugin URI:  https://help.one.com/hc/en-us/articles/115005593945
 * Plugin Info:  https://one.com
 * Version: 		0.6.0
 * Text Domain: 	onecom-wp
 * Domain Path: 	/languages
 * Description: 	Personalize your website with custom made themes and plugins exclusive to one.com customers. You can also find a curated list of plugins that we recommend.
 * Network: true
 * Author: 		one.com
 * Author URI: 	https://one.com/
 * License:     	GPL v2 or later
 * 
 * 	Copyright 2017 one.com
 * 
 * 	This program is free software; you can redistribute it and/or modify
 * 	it under the terms of the GNU General Public License as published by
 * 	the Free Software Foundation; either version 2 of the License, or
 * 	(at your option) any later version.
 * 
 * 	This program is distributed in the hope that it will be useful,
 * 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 * 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * 	GNU General Public License for more details.
 */
defined( 'ABSPATH' ) or die( 'Cheating Huh!' ); // Security

if( ! defined( 'ONECOM_WP_VERSION' ) ) {
	define( 'ONECOM_WP_VERSION', '0.6.0' );
}

if( ! defined( 'ONECOM_WP_PATH' ) ) {
	define( 'ONECOM_WP_PATH', plugin_dir_path( __FILE__ ) );
}
if( ! defined( 'ONECOM_WP_URL' ) ) {
	define( 'ONECOM_WP_URL', plugin_dir_url( __FILE__ ) );
}
if( !defined( 'MIDDLEWARE_URL' ) ) {
	$api_version = 'v1.0';
	if( isset( $_SERVER[ 'ONECOM_WP_ADDONS_API' ] ) && $_SERVER[ 'ONECOM_WP_ADDONS_API' ] != '' ) {
		$ONECOM_WP_ADDONS_API = $_SERVER[ 'ONECOM_WP_ADDONS_API' ];
	} elseif( defined( 'ONECOM_WP_ADDONS_API' ) && ONECOM_WP_ADDONS_API != '' && ONECOM_WP_ADDONS_API != false ) {
		$ONECOM_WP_ADDONS_API = ONECOM_WP_ADDONS_API;
	} else {
		$ONECOM_WP_ADDONS_API = 'http://wpapi.one.com/';
	}
	$ONECOM_WP_ADDONS_API = rtrim( $ONECOM_WP_ADDONS_API, '/' );
	define( 'MIDDLEWARE_URL', $ONECOM_WP_ADDONS_API.'/api/'.$api_version );
}
if( !defined( 'WP_API_URL' ) ) {
	$api_version = '1.0';
	define( 'WP_API_URL', 'https://api.wordpress.org/plugins/info/'.$api_version.'/' );
}
if( !defined( 'ONECOM_WP_CORE_VERSION' ) ) {
	global $wp_version;
	define( 'ONECOM_WP_CORE_VERSION' , $wp_version );
}
if( !defined( 'ONECOM_PHP_VERSION' ) ) {
	define( 'ONECOM_PHP_VERSION' , phpversion() );
}
if(!defined('OC_PLUGIN_DOMAIN')){
    define('OC_PLUGIN_DOMAIN', 'onecom-wp');
}
if(!defined('OC_INLINE_LOGO')){
    define('OC_INLINE_LOGO', sprintf('<img src="%s" alt="%s" />', ONECOM_WP_URL.'assets/images/one.com.black.svg', __( 'One.com', OC_PLUGIN_DOMAIN )));
}
/**
 * Include API hook file
 **/
include_once ONECOM_WP_PATH.'/inc/api-hooks.php';

/** s
 * Plugin activation hook
 **/
if( ! function_exists( 'onecom_plugin_activation' ) ) {
	function onecom_plugin_activation() {
		onecom_trigger_log( $request = 'plugins', $slug = dirname( plugin_basename( __FILE__ ) ), $action = 'activate' );
		
	}
}
register_activation_hook( __FILE__, 'onecom_plugin_activation' );
/**
 * Plugin deactivation hook
 **/
if( ! function_exists( 'onecom_plugin_deactivation' ) ) {
	function onecom_plugin_deactivation() {
		onecom_trigger_log( $request = 'plugins', $slug = dirname( plugin_basename( __FILE__ ) ), $action = 'deactivate' );
	}
}
register_deactivation_hook( __FILE__, 'onecom_plugin_deactivation' );
/**
 * Plugin upgradation hook
 */
if( ! function_exists( 'onecom_plugin_upgradation' ) ) {
	function onecom_plugin_upgradation($upgrader_object, $options) {
		if('onecom-themes-plugins.php' !== plugin_basename( __FILE__)){
			return ;
		}
		update_site_option('oc_tp_version', ONECOM_WP_VERSION);
	}
}
add_action( 'upgrader_process_complete', 'onecom_plugin_upgradation',10, 2);
add_action( 'admin_init', 'onecom_check_for_get_request', -1 );
if( ! function_exists( 'onecom_check_for_get_request' ) ) {
	function onecom_check_for_get_request() {
		/**
		 * Deactivate plugin
		 **/
		if( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'deactivate_plugin' ) {
			if( isset( $_POST[ 'plugin' ] ) && trim( $_POST[ 'plugin' ] ) != '' ) {
				$network_wide = false;
				$silent = false;
				if( is_multisite() && is_network_admin() ) {
					$network_wide = true;
				}
				$is = deactivate_plugins( $_POST[ 'plugin' ], $silent, $network_wide );
				wp_safe_redirect( wp_get_referer() );
			}
		}

		/**
		 * Delete site transient
		 **/
		if( isset( $_GET[ 'request' ] ) && $_GET[ 'request' ] != '' ) {
			delete_site_transient( 'onecom_'.$_GET[ 'request' ] );
			$url = ( is_network_admin() && is_multisite() ) ? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' );
			$url = add_query_arg( array(
				'page' => 'onecom-wp-themes'
			), $url );
			wp_safe_redirect( $url );
			die();
		}
		return;
	}
}

add_action( 'plugins_loaded', 'onecom_wp_load_textdomain', -1);
if( ! function_exists( 'onecom_wp_load_textdomain' ) ) {
	function onecom_wp_load_textdomain() {
		
		// load english tranlsations [as] if any unsupported language is selected in WP-Admin
		if(strpos(get_locale(), 'en_') === 0){
			load_textdomain( OC_PLUGIN_DOMAIN, dirname( __FILE__ ) . '/languages/onecom-wp-en_US.mo' );
		}
		else{
			load_plugin_textdomain( OC_PLUGIN_DOMAIN, false, basename( dirname( __FILE__ ) ) . '/languages' );
		}
	}
}

/**
 * Limit load of resources on only specific admin pages to optimize loading time
 */
/* Add hook to following array where you want to enquque your resources */
global $load_onecom_wp_resources_slugs;
$load_onecom_wp_resources_slugs = array(
	'_page_onecom-wp-themes',
	'toplevel_page_onecom-wp',
	'_page_onecom-wp-themes',
	'_page_onecom-wp-plugins',
	'_page_onecom-wp-recommended-plugins',
	'admin_page_onecom-wp-recommended-plugins',
	'admin_page_onecom-wp-discouraged-plugins',
	'_page_onecom-wp-staging',
	'_page_onecom-wp-staging-blocked',
	'_page_onecom-wp-cookie-banner'
	//'one-com_page_onecom-wp-images',
);
$load_onecom_wp_resources_slugs = apply_filters( 'load_onecom_wp_resources_slugs', $load_onecom_wp_resources_slugs );

add_action( 'limit_enqueue_resources', 'limit_enqueue_resources_callback', 10, 3 );
if( ! function_exists( 'limit_enqueue_resources_callback' ) ) {
	function limit_enqueue_resources_callback( $handle, $hook, $type ) {
		global $load_onecom_wp_resources_slugs;
		if( in_array( $hook, $load_onecom_wp_resources_slugs) ) { // checking hook with provided array to be allowed
			if( $type == 'style' ) {
				wp_enqueue_style( $handle ); // if allowed, enqueue the style
			} else if( $type == 'script' ) {
				wp_enqueue_script( $handle ); // if allowed, enqueue the script
			}
		}
	}
}

add_action('wp_enqueue_scripts', 'register_one_frontend_resources');
if(!function_exists('register_one_frontend_resources')){
    function register_one_frontend_resources(){
        wp_register_style(
            'one-font-icon',
            ONECOM_WP_URL.'assets/fonts/onecom/style.css',
            null,
            ONECOM_WP_VERSION,
            'all'
        );
        wp_enqueue_style( 'one-font-icon' );
    }
}

add_action( 'admin_enqueue_scripts', 'register_one_core_resources' );
if( ! function_exists( 'register_one_core_resources' ) ) {
	function register_one_core_resources( $hook ) {
		$resource_extension = ( SCRIPT_DEBUG || SCRIPT_DEBUG == 'true') ? '' : '.min'; // Adding .min extension if SCRIPT_DEBUG is enabled
		$resource_min_dir = ( SCRIPT_DEBUG || SCRIPT_DEBUG == 'true') ? '' : 'min-'; // Adding min- as a minified directory of resources if SCRIPT_DEBUG is enabled

		wp_register_style(
			'one-font-icon',
			ONECOM_WP_URL.'assets/fonts/onecom/style.css',
			null,
			ONECOM_WP_VERSION,
			'all'
		);
		wp_enqueue_style( 'one-font-icon' );
		wp_register_style(
			OC_PLUGIN_DOMAIN,
			ONECOM_WP_URL.'assets/'.$resource_min_dir.'css/style'.$resource_extension.'.css',
			null,
			ONECOM_WP_VERSION,
			'all'
		);

		wp_register_script(
			OC_PLUGIN_DOMAIN,
			ONECOM_WP_URL.'assets/'.$resource_min_dir.'js/script'.$resource_extension.'.js',
			array( 'jquery', 'thickbox', 'jquery-ui-dialog' ),
			ONECOM_WP_VERSION,
			true
		);
		wp_localize_script( OC_PLUGIN_DOMAIN, 'onecom_vars',
			array(
				'network' => ( is_network_admin() && is_multisite() ) ? true : false
			)
		);

		wp_register_style(
			'onecom-promo',
			ONECOM_WP_URL.'assets/'.$resource_min_dir.'css/promo'.$resource_extension.'.css',
			null,
			ONECOM_WP_VERSION,
			'all'
		);

		wp_register_script(
			'onecom-promo',
			ONECOM_WP_URL.'assets/'.$resource_min_dir.'js/promo'.$resource_extension.'.js',
			array( 'jquery' ),
			ONECOM_WP_VERSION
		);

		/**
		 * Hooking resource into limit utilization
		 **/
		do_action( 'limit_enqueue_resources', OC_PLUGIN_DOMAIN, $hook, 'style' );
		do_action( 'limit_enqueue_resources', OC_PLUGIN_DOMAIN, $hook, 'script' );

		/* Google fonts */
		wp_register_style(
			'onecom-wp-google-fonts',
			'//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800',
			null,
			null,
			'all'
		);
		do_action( 'limit_enqueue_resources', 'onecom-wp-google-fonts', $hook, 'style' );
	}
}

add_action( 'admin_menu', 'one_core_admin', -1 );
add_action( 'network_admin_menu', 'one_core_admin', -1 );
if( ! function_exists( 'one_core_admin' ) ) {
	function one_core_admin() {
		if( ! is_network_admin() && is_multisite() ) {
			return false;
		}
		$position = onecom_get_free_menu_position( '2.1' );

		// save for other one.com plugins and themes
		global $onecom_generic_menu_position;
		$onecom_generic_menu_position = $position;

		add_menu_page(
			$page_title = __( 'One.com', OC_PLUGIN_DOMAIN ),
			$menu_title = OC_INLINE_LOGO,
			$capability = 'manage_options',
			$menu_slug = OC_PLUGIN_DOMAIN,
			$function = 'one_core_admin_callback',
			$icon_url = 'dashicons-admin-generic',
			$position
		);
		add_submenu_page(
			$parent_slug = OC_PLUGIN_DOMAIN,
			$page_title = __( 'Themes', OC_PLUGIN_DOMAIN ),
			$menu_title = __( 'Themes', OC_PLUGIN_DOMAIN ),
			$capability = 'manage_options',
			$menu_slug = 'onecom-wp-themes',
			$function = 'one_core_theme_listing_callback'
		);
		add_submenu_page(
			$parent_slug = OC_PLUGIN_DOMAIN,
			$page_title = __( 'Plugins', OC_PLUGIN_DOMAIN ),
			$menu_title = __( 'Plugins', OC_PLUGIN_DOMAIN ),
			$capability = 'manage_options',
			$menu_slug = 'onecom-wp-plugins',
			$function = 'one_core_plugin_listing_callback'
		);
		add_submenu_page(
			$parent_slug = null, // adding null to hide from submenu
			$page_title = __( 'Plugins', OC_PLUGIN_DOMAIN ),
			$menu_title = __( 'Plugins', OC_PLUGIN_DOMAIN ),
			$capability = 'manage_options',
			$menu_slug = 'onecom-wp-recommended-plugins',
			$function = 'one_core_recommended_plugin_listing_callback'
		);
		add_submenu_page(
			$parent_slug = null, // adding null to hide from submenu
			$page_title = __( 'Plugins', OC_PLUGIN_DOMAIN ),
			$menu_title = __( 'Plugins', OC_PLUGIN_DOMAIN ),
			$capability = 'manage_options',
			$menu_slug = 'onecom-wp-discouraged-plugins',
			$function = 'one_core_discouraged_plugin_listing_callback'
		);
		remove_submenu_page(OC_PLUGIN_DOMAIN,OC_PLUGIN_DOMAIN); // remove admin duplicate menu item
	}
}

add_action( 'admin_bar_menu', 'add_one_bar_items', 100, 100 );
if( ! function_exists( 'add_one_bar_items' ) ) {
	function add_one_bar_items( $admin_bar ) {
		if( ! is_network_admin() && is_multisite() ) {
			return false;
		}
		if( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$args = array(
			'id'    => OC_PLUGIN_DOMAIN,
			//'parent' => 'top-secondary',
			'title' => OC_INLINE_LOGO,
			'href'  => ( is_multisite() && is_network_admin() ) ?  network_admin_url( 'admin.php?page=onecom-wp' ) : admin_url( 'admin.php?page=onecom-wp' ),
			'meta'  => array(
				'title' => __( 'One.com', OC_PLUGIN_DOMAIN ),
				'class' => 'onecom-wp-admin-bar-item'
			),
		);
		$admin_bar->add_menu( $args );

		$args = array(
			'id'    => 'onecom-wp-themes',
			'parent' => OC_PLUGIN_DOMAIN,
			'title' => __( 'Themes', OC_PLUGIN_DOMAIN ),
			'href'  => ( is_multisite() && is_network_admin() ) ? network_admin_url( 'admin.php?page=onecom-wp-themes' ) : admin_url( 'admin.php?page=onecom-wp-themes' ),
			'meta'  => array(
				'title' => __( 'Themes', OC_PLUGIN_DOMAIN ),
			),
		);
		$admin_bar->add_menu( $args );

		$args = array(
			'id'    => 'onecom-wp-plugins',
			'parent' => OC_PLUGIN_DOMAIN,
			'title' => __( 'Plugins', OC_PLUGIN_DOMAIN ),
			'href'  => ( is_multisite() && is_network_admin() ) ? network_admin_url( 'admin.php?page=onecom-wp-plugins' ) : admin_url( 'admin.php?page=onecom-wp-plugins' ),
			'meta'  => array(
				'title' => __( 'Plugins', OC_PLUGIN_DOMAIN ),
			),
		);
		$admin_bar->add_menu( $args );

		$args = array(
			'id'    => 'onecom-wp-staging',
			'parent' => OC_PLUGIN_DOMAIN,
			'title' => __( 'Staging', OC_PLUGIN_DOMAIN ),
			'href'  => ( is_multisite() && is_network_admin() ) ? network_admin_url( 'admin.php?page=onecom-wp-staging' ) : admin_url( 'admin.php?page=onecom-wp-staging' ),
			'meta'  => array(
				'title' => __( 'Plugins', OC_PLUGIN_DOMAIN ),
			),
		);
		$admin_bar->add_menu( $args );

		/*
		* Account link to Control Panel
		*/
		$args = array(
			'id'    => 'one-cp',
			'parent' => OC_PLUGIN_DOMAIN,
			'title' => __( 'One.com Control Panel', OC_PLUGIN_DOMAIN ),
			'href'  => 'https://www.one.com/admin/wp-overview.do',
			'meta'  => array(
				'title' => __( 'Go to Control Panel at One.com', OC_PLUGIN_DOMAIN ),
				'target' => '_blank'
			),
		);
		$admin_bar->add_menu( $args );

		/*
		* WordPress support
		*/
		$locale = get_locale();

		$args = array(
			'id'    => 'one-wp-support',
			'parent' => OC_PLUGIN_DOMAIN,
			'title' => __( 'One.com Guides & FAQ', OC_PLUGIN_DOMAIN ),
			'href'  => onecom_generic_locale_link( $request = 'main_guide', $locale ),
			'meta'  => array(
				'title' => __( 'Go to Guides & FAQ at One.com', OC_PLUGIN_DOMAIN ),
				'target' => '_blank'
			),
		);
		$admin_bar->add_menu( $args );
	}
}

if( ! function_exists( 'one_core_admin_callback' ) ) {
	function one_core_admin_callback() {
		$network = ( is_network_admin() && is_multisite() ) ? 'network/' : '';
		include_once 'templates/'.$network.'theme-listing.php';
	}
}

if( ! function_exists( 'one_core_theme_listing_callback' ) ) {
	function one_core_theme_listing_callback() {
		$network = ( is_network_admin() && is_multisite() ) ? 'network/' : '';
		include_once 'templates/'.$network.'theme-listing.php';
	}
}

if( ! function_exists( 'one_core_plugin_listing_callback' ) ) {
	function one_core_plugin_listing_callback() {
		$network = ( is_network_admin() && is_multisite() ) ? 'network/' : '';
		include_once 'templates/'.$network.'plugin-listing.php';
	}
}

if( ! function_exists( 'one_core_recommended_plugin_listing_callback' ) ) {
	function one_core_recommended_plugin_listing_callback() {
		$network = ( is_network_admin() && is_multisite() ) ? 'network/' : '';
		include_once 'templates/'.$network.'recommended-plugin-listing.php';
	}
}

if( ! function_exists( 'one_core_discouraged_plugin_listing_callback' ) ) {
	function one_core_discouraged_plugin_listing_callback() {
		$network = (is_network_admin() && is_multisite() ) ? 'network/' : '';
		include_once 'templates/'.$network.'discouraged-plugin-listing.php';
	}
}
/**
 * Function to get free position for menu
 **/
if( ! function_exists( 'onecom_get_free_menu_position' ) ) {
	function onecom_get_free_menu_position($start, $increment = 0.3) {
		foreach ($GLOBALS['menu'] as $key => $menu) {
			$menus_positions[] = $key;
		}

		if (!in_array($start, $menus_positions)) return $start;

		/* the position is already reserved find the closet one */
		while (in_array($start, $menus_positions)) {
			$start += $increment;
		}

		return (string) $start;
	}
}

/**
 * one.com updater
 **/
if( ! class_exists( 'ONECOMUPDATER' ) ) {
	require_once ONECOM_WP_PATH.'/inc/update.php';
}

/**
 * General functions
 **/	
if(! (class_exists('OTPHP\TOTP') && class_exists('ParagonIE\ConstantTime\Base32'))){
	require_once ( ONECOM_WP_PATH.'/inc/lib/validator.php' );
}
add_action( 'admin_init', 'onecom_admin_init_callback' );
if( ! function_exists( 'onecom_admin_init_callback' ) ) {
	function onecom_admin_init_callback() {
		require_once ONECOM_WP_PATH.'/inc/functions.php';
	}
}

/**
 * one.com staging
 **/
if(!class_exists('OneStaging\\OneStaging') && is_admin()){
	include_once 'staging/one_staging.php';
	\OneStaging\OneStaging::getInstance()->run();
}

if(file_exists(ONECOM_WP_PATH.'/modules/health-monitor/health-monitor.php')){
	require_once ONECOM_WP_PATH.'/modules/health-monitor/health-monitor.php';
}

if(file_exists(ONECOM_WP_PATH.'/modules/cookie-banner/cookie-banner.php')){
	require_once ONECOM_WP_PATH.'/modules/cookie-banner/cookie-banner.php';
}
  
/* Add "View Details" link for all one.com plugins, if not already exist */
add_filter( 'plugin_row_meta', 'onecom_generic_plugin_row_meta', 20, 2 );
function onecom_generic_plugin_row_meta( $links, $file ) {

	// skip all non-one.com plugin entries
	if($file != plugin_basename( __FILE__ )){
		return $links;
	}

	$health_url = ( is_multisite() && is_network_admin() ) ? network_admin_url( 'admin.php?page=onecom-wp-health-monitor' ) : admin_url( 'admin.php?page=onecom-wp-health-monitor' );

	$stg_url = ( is_multisite() && is_network_admin() ) ? network_admin_url( 'admin.php?page=onecom-wp-staging' ) : admin_url( 'admin.php?page=onecom-wp-staging' );

	$themes_url = ( is_multisite() && is_network_admin() ) ? network_admin_url( 'admin.php?page=onecom-wp-themes' ) : admin_url( 'admin.php?page=onecom-wp-themes' );

	$plugin_url = ( is_multisite() && is_network_admin() ) ? network_admin_url( 'admin.php?page=onecom-wp-plugins' ) : admin_url( 'admin.php?page=onecom-wp-plugins' );

	// add new link - "View Details"
	$anchor = '<a href="%s">%s</a>';

	$new_links = array(
		'oc-health' => sprintf($anchor,$health_url, __('Health Monitor', OC_PLUGIN_DOMAIN)),
		'oc-staging' => sprintf($anchor,$stg_url, __('Staging', OC_PLUGIN_DOMAIN)),
		'oc-themes' => sprintf($anchor,$themes_url, __('Themes')),
		'oc-plugins' => sprintf($anchor,$plugin_url, __('Plugins'))
	);
	
	// club the new link with existing links
	return array_merge( $links, $new_links );
}

/**
 * Switch to GD Image editor as default.
 */
add_filter( 'wp_image_editors', 'oc_default_to_gd' );
if (!function_exists('oc_default_to_gd')){
	function oc_default_to_gd( $editors ) {
		$gd = 'WP_Image_Editor_GD';
		$editors_array = array_diff( $editors, array( $gd ) );
		array_unshift( $editors_array, $gd );
		return $editors_array;
	}
}