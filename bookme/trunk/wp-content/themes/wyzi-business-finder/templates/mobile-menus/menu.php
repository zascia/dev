<?php

// Block direct requests
if ( ! defined( 'ABSPATH' ) ) {
	wp_die('No cheating');
}


if( ! class_exists( 'WYZIMobileMenuParent' ) ) {

	class WYZIMobileMenuParent {

		protected $menu_id;

		public function __construct() {

		}

		protected function set_menu_id() {
			$this->menu_id = '';
			if ( 'on' == wyz_get_option( 'wyz-sep-mobile-menu' ) && has_nav_menu( 'mobile' ) && wyz_is_mobile() )
				$this->menu_id = 'mobile';
			elseif ( has_nav_menu( 'primary' ) )
				$this->menu_id = 'primary';
		}
	}
}