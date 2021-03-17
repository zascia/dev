<?php

// Block direct requests
if ( ! defined( 'ABSPATH' ) ) {
	wp_die('No cheating');
}

require_once( plugin_dir_path( __FILE__ ) . '/menu.php' );

if( ! class_exists( 'WYZIMobileMenu' ) ) {

	class WYZIMobileMenu extends WYZIMobileMenuParent {

		public function __construct() {

		}

		public function the_mobile_menu() { 

			$this->set_menu_id(); ?>
			<!-- Mobile Menu -->
			<div class="mobile-menu hidden-lg hidden-md hidden-sm">
				<nav id="mobile-navigation">
					<?php if ( '' != $this->menu_id ) {
						wp_nav_menu( array(
							'menu_id' => 'mobile-main-menu',
							'container' => false,
							'theme_location' => $this->menu_id,
						) );
					}?>
				</nav>
			</div>
			<?php
		}
	}
}