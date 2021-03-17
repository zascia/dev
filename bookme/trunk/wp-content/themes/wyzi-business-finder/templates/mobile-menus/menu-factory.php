<?php

// Block direct requests
if ( ! defined( 'ABSPATH' ) ) {
	wp_die('No cheating');
}

if( ! class_exists( 'WYZIMobileMenuFactory' ) ) {

	class WYZIMobileMenuFactory {

		private $menu_layout;
		protected $mobile_menu;

		public function __construct() {
			$this->menu_layout = wyz_get_option( 'mobile-menu-layout' );


			$this->menu_layout = wyz_get_option( 'mobile-menu-layout' );
			if(''==$this->menu_layout)$this->menu_layout='menu-1';
			$menu_file_name = $this->menu_layout . '.php';
			require_once( WYZ_TEMPLATES_DIR . '/mobile-menus/' . $menu_file_name );

			$this->mobile_menu = new WYZIMobileMenu();
		}

		public function the_mobile_menu() {
			$this->mobile_menu->the_mobile_menu();
		}
	}
}