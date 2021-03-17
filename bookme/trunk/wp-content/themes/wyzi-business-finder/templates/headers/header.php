<?php 

/*
 * Parent header template
 */
// Block direct requests
if ( ! defined( 'ABSPATH' ) ) {
	wp_die('No cheating');
}

if ( ! class_exists( 'WYZIHeaderParent' ) ) { 

	abstract class WYZIHeaderParent {

		protected $WYZ_USER_ACCOUNT;
		protected $is_seethrough = false;
		protected $bg_color = '';
		protected $mobile_bg_color = '';
		protected $shadow = '';
		protected $border_color = '';
		protected $font_color ='';
		protected $mobile_font_color ='';
		protected $submenu_font_color ='';
		protected $submenu_bg_color ='';
		protected $font_hover_color ='';
		protected $font_active_color ='';
		protected $mobile_font_active_color ='';
		protected $logo =  '';
		protected $header_template = '';

		protected $the_header;

		protected $mobile_menu_factory;


		public function __construct( $WUA ) {
			$this->WYZ_USER_ACCOUNT = $WUA;
			$id = get_the_ID();
			$this->is_seethrough = 'on' == get_post_meta( $id, 'wyz_seethrough_menu', true );
			if ( $this->is_seethrough ) {
				$this->bg_color = get_post_meta( $id, 'wyz_seethrough_bg_color', true );
				$this->mobile_bg_color = get_post_meta( $id, 'wyz_seethrough_mobile_bg_color', true );
				$this->shadow = get_post_meta( $id, 'wyz_seethrough_shadow', true );
				if ( '' == $this->bg_color ) $this->bg_color = 'transparent';
				$this->font_color =  get_post_meta( $id, 'wyz_seethrough_font_color', true );
				$this->mobile_font_color =  get_post_meta( $id, 'wyz_seethrough_mobile_font_color', true );
				$this->submenu_font_color =  get_post_meta( $id, 'wyz_seethrough_submenu_font_color', true );
				$this->submenu_bg_color =  get_post_meta( $id, 'wyz_seethrough_submenu_bg_color', true );
				$this->font_hover_color =  get_post_meta( $id, 'wyz_seethrough_font_hover_color', true );
				$this->font_active_color =  get_post_meta( $id, 'wyz_seethrough_font_active_color', true );
				$this->mobile_font_active_color =  get_post_meta( $id, 'wyz_seethrough_mobile_font_active_color', true );
				$this->logo =  get_post_meta( $id, 'wyz_seethrough_logo', true );
				if ( $this->logo == '' )
					$this->logo = wyz_get_option( 'header-logo-upload' );
			} else
				$this->logo = wyz_get_option( 'header-logo-upload' );

			$this->mobile_menu_factory = new WYZIMobileMenuFactory();
		}


		/*---------------------------------
		/*  	Abstract functions
		/* To be overriden by child clases
		/*--------------------------------*/
		public abstract function start();
		public abstract function close();
		public abstract function the_subheader();
		protected abstract function the_main_menu();
		public abstract function the_utility_bar();
		public abstract function the_main_header();



		protected function can_have_subheader() {
			if ( 'off' == wyz_get_option( 'wyz-hide-sub-header-in-bus-arch' ))
				return ! is_singular( 'wyz_business' ) && ! is_singular( 'wyz_offers' ) && ! is_404() &&  ( ! is_page() || is_page( 'user-account' ) || filter_input( INPUT_GET, 'location' ) );
			else 
				return !is_post_type_archive( 'wyz_business' ) && ! is_singular( 'wyz_business' ) && ! is_singular( 'wyz_offers' ) && ! is_404() &&  ( ! is_page() || is_page( 'user-account' ) || filter_input( INPUT_GET, 'location' ) );
		}

		protected function the_page_title() {
			$title = '';
			if ( is_front_page() && 0 == get_option( 'page_on_front' ) ) {
				$blog_ttl = esc_html( wyz_get_option( 'blog-title' ) );
				$title = '' != $blog_ttl ? $blog_ttl : esc_html__( 'Blog', 'wyzi-business-finder' );
			} elseif ( is_category() ) {
				$title = sprintf( esc_html__( 'Categories Archives: %s', 'wyzi-business-finder' ), esc_html( single_cat_title( '', false ) ) );
			} elseif ( is_tag() ) {
				$title = sprintf( esc_html__( 'Tag: %s', 'wyzi-business-finder' ), esc_html( single_tag_title( '', false ) ) );
			} elseif ( is_author() ) {
				$title = sprintf( esc_html__( 'All Posts by %s', 'wyzi-business-finder' ), esc_html( get_the_author() ) );
			} elseif ( is_day() ) {
				$title = sprintf( esc_html__( 'Day: %s', 'wyzi-business-finder' ), get_the_date( get_option( 'date_format' ) ) );
			} elseif ( is_month() ) {
				$title = sprintf( esc_html__( 'Month: %s', 'wyzi-business-finder' ), get_the_date( 'M, Y' ) );
			} elseif ( is_year() ) {
				$title = sprintf( esc_html__( 'Year: %s', 'wyzi-business-finder' ), get_the_date( 'Y' ) );
			} elseif ( is_tax( 'wyz_business_category' ) ) {
				global $wp_query;
				$term = $wp_query->queried_object;
				$title = sprintf( esc_html__( "Business Category: %s", 'wyzi-business-finder' ), esc_html( $term->name ) );
				if ( '' !== $term->description ) {
					$title .= '<div class="wyz-subscript">' . esc_html( $term->description ) . '</div>';
				}
			} elseif( is_tax( 'offer-categories' ) ) {
			    global $wp_query;
				$term = $wp_query->queried_object;
				$title = sprintf( esc_html__( "%s Category: %s", 'wyzi-business-finder' ), WYZ_OFFERS_CPT, esc_html( $term->name ) );
				if ( '' !== $term->description ) {
					$title .= '<div class="wyz-subscript">' . esc_html( $term->description ) . '</div>';
				}
			} elseif ( is_tax( 'wyz_business_tag' ) ) {
				$title = esc_html__( 'Business Tag', 'wyzi-business-finder' );
			} elseif ( is_tax( 'wyz_offers_tag' ) ) {
				$title = sprintf( esc_html__( '%s Tag', 'wyzi-business-finder' ), WYZ_OFFERS_CPT );
			} elseif ( is_post_type_archive( 'wyz_business' ) ) {
				$title = sprintf( esc_html__( 'All %s', 'wyzi-business-finder' ), get_option( 'wyz_business_plural_name', 'Businesses' ) );
			} elseif ( is_post_type_archive( 'wyz_offers' ) ) {
				$title = sprintf( esc_html__( 'All %s', 'wyzi-business-finder' ), get_option( 'wyz_offer_plural_name', 'Offers' ) );
			} elseif ( is_search() ) {
				$title = esc_html__( 'SEARCH RESULTS FOR: ', 'wyzi-business-finder' ) . esc_html( get_search_query( false ) );
			} elseif (  isset( $_GET['location'] ) ) {
				$title = esc_html( get_the_title( $_GET['location'] ) );
			} elseif ( isset( $_GET['reset-pass'] ) ) {
				$title = esc_html__( 'Reset Password', 'wyzi-business-finder' );
			} elseif( is_home() ) {
				$title = esc_html( get_the_title( get_option( 'page_for_posts' ) ) );
			} elseif( class_exists( 'WooCommerce' ) && is_shop() ) {
				$title = woocommerce_page_title( false );
			} elseif ( is_tax('dc_vendor_shop') ) {
				echo '';
			} elseif( $this->WYZ_USER_ACCOUNT ) {
				$title = $this->WYZ_USER_ACCOUNT->the_page_title();
			} else {
				$title = esc_html( get_the_title( '', '' ) );
			}
			echo apply_filters( 'wyz_page_title', $title );
		}
	}
}