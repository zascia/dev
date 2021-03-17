<?php 

// Block direct requests
if ( ! defined( 'ABSPATH' ) ) {
	wp_die('No cheating');
}

require_once(WYZ_TEMPLATES_DIR . '/headers/header.php' );

if ( ! class_exists( 'WYZIHeader' ) ) { 

	class WYZIHeader extends WYZIHeaderParent {

		public function __construct( $WUA ) {
			parent::__construct( $WUA );
			if ( $this->is_seethrough ) {
				$this->header_template = 'header1';
			} else {
				$this->header_template = wyz_get_option( 'header-layout' );
				if ( '' == $this->header_template )
					$this->header_template = 'header1';
			}
			
		}

		public function start() {
			if ( $this->is_seethrough ) {
				$has_mobile_style = '' != $this->mobile_bg_color || '' != $this->mobile_font_color || '' != $this->mobile_font_active_color;

				wp_register_style( 'header1-see-through-menu-css', false );
				wp_enqueue_style( 'header1-see-through-menu-css' );

				if ( '' != $this->bg_color )
					 wp_add_inline_style( 'header1-see-through-menu-css', '.header-bottom, .main-menu ul.sub-menu { background-color: ' . $this->bg_color . ';}' );

				if ( '' != $this->submenu_bg_color )  
					wp_add_inline_style( 'header1-see-through-menu-css', '.main-menu ul.sub-menu { background-color: ' . $this->submenu_bg_color . ';}' );

				if ( 'on' != $this->shadow )
					wp_add_inline_style( 'header1-see-through-menu-css', '.header-bottom, .main-menu li:hover > ul.sub-menu { box-shadow: none;}' );

				if ( $this->font_color != '' )
					wp_add_inline_style( 'header1-see-through-menu-css', '.main-menu nav > ul > li:hover > a, .main-menu ul > li > a, #main-menu > li.menu-item-has-children .fa,
				 	 .main-menu > ul > li .fa, .header-links a,.mean-nav > ul > li ul li a,.mean-nav > ul > li ul li a, .mean-nav > ul > li > a, .mean-nav ul li li a, .mean-nav ul li li li a, .meanmenu-reveal .fa,.main-menu nav > ul > li > a, .login-menu > ul > li > a { color: ' . $this->font_color . ';}' );

				if ( $this->submenu_font_color != '' )
					wp_add_inline_style( 'header1-see-through-menu-css', '.sub-menu li a, .sub-menu li i{ color: ' . $this->submenu_font_color . ';}' );

				if ( $this->font_hover_color != '' )
					wp_add_inline_style( 'header1-see-through-menu-css', '.main-menu nav > ul > li.current-menu-item > a, .main-menu nav > ul > li:hover > a,.main-menu nav > ul > li:hover> .fa, .login-menu nav > ul > li.current-menu-item > a, .login-menu nav > ul > li:hover > a, .sub-menu li:hover > a, .sub-menu li:hover>a i { color: ' . $this->font_hover_color . ';}' );

				if ( $this->font_active_color != '' )
					wp_add_inline_style( 'header1-see-through-menu-css', '.main-menu nav ul li.current-menu-item > a, .main-menu nav ul li.current-menu-item:hover > a,
					.main-menu nav ul li.current-menu-parent > a, .main-menu nav ul li.current-menu-parent:hover > a,
					.mean-nav ul li.current-menu-item > a, .mean-nav ul li.current-menu-item:hover > a,
					.mean-nav ul li.current-menu-parent > a, .mean-nav ul li.current-menu-parent:hover > a,
					 .login-menu nav > ul > li.current-menu-item > a, .login-menu nav > ul > li.current-menu-item:hover > a { color: ' . $this->font_active_color . ';}' );

				if ( $has_mobile_style ) {
					$has_mobile_style_css = '@media only screen and (max-width: 767px){';
					
					if ( '' != $this->mobile_font_color ) 
						$has_mobile_style_css .= '.mean-nav > ul > li > a,.mean-nav > ul > li ul li a,.sub-menu li i, .mean-nav ul li li a, .mean-nav ul li li li a, .meanmenu-reveal .fa { color: ' . $this->mobile_font_color . ';}';
					
					if ( '' != $this->mobile_font_active_color ) 
						$has_mobile_style_css .= '.mean-nav ul li.current-menu-item > a, .mean-nav ul li.current-menu-item:hover > a,
					.mean-nav ul li.current-menu-parent > a, .mean-nav ul li.current-menu-parent:hover > a{ color: ' . $this->mobile_font_active_color . ';}';
					
					if ( '' != $this->mobile_bg_color ) 
						$has_mobile_style_css .= '.mean-nav,.header-bottom,.mean-nav > ul > li > a, .sub-menu { background-color: ' . $this->mobile_bg_color . ';}';

					$has_mobile_style_css .= '}';

					wp_add_inline_style( 'header1-see-through-menu-css', $has_mobile_style_css );
				}
			}
			echo '<header class="header static';
			if ( $this->is_seethrough ) {
				echo ' header-seethrough';
				if ( is_admin_bar_showing() )
					echo ' header-admin-bar';
			}
			echo '">';
		}

		public function close() {
			echo '</header>';
		}


		public function the_subheader() {

			?><!-- page subheader
			============================================ -->
			<?php if ( $this->can_have_subheader() ) { ?>
				<div class="page-title-social margin-0">
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<?php if ( 'on' != get_post_meta( get_the_ID(), 'wyz_page_title', true ) ) {?>
								<div class="page-title float-left">
									<h2><?php $this->the_page_title();?></h2>
								</div>
								<?php }

								if ( ! is_search() ) {
									echo wyz_breadcrumbs();
								}
								if ( class_exists( 'WyzUserAccount' ) ) {
									$this->WYZ_USER_ACCOUNT->the_points_status( false );
								}
								?>
							</div>
						</div>
					</div>
				</div>

				<?php
				/* User account and my business tabs. */
				if ( class_exists( 'WyzUserAccount' ) ) {
					$this->WYZ_USER_ACCOUNT->the_account_tabs();
				}
			}
			elseif ( is_page() && 'on' != get_post_meta( get_the_ID(), 'wyz_page_title', true ) ) { ?>
				<div class="page-title-social margin-0">
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								<div class="page-title float-left">
									<h2><?php if ( is_page( 'signup' ) && isset( $_GET['action'] ) && 'login' == $_GET['action'] ) {
											echo esc_html__( 'Sign In', 'wyzi-business-finder' );
										} else {
										esc_html( the_title( '', '' ) );
									}?></h2>
								</div>
								<?php echo wyz_breadcrumbs();?>
							</div>
						</div>
					</div>
				</div>
			<?php }
		}


		private function the_login_menu( $position ) {

			switch( $position ) {
				case '':
				?>
				<!-- Login Menu -->
				<div class="login-menu header-link float-right<?php echo 'header2' == $this->header_template ? ' login-menu2' : '' ; ?> hidden-xs">
					<?php if ( has_nav_menu( 'login' ) ) {
						wp_nav_menu( array(
							'menu_id' => 'login-menu',
							'container' => false,
							'theme_location' => 'login',
							'link_before'    => '<span>',
							'link_after'     => '</span>',
						) );
					}?>
				</div>
				<?php
				break;
				case 'top-left':
				?>
				<!-- Login Menu -->
				<div class="login-menu float-left hidden-xs header-top-left col-sm-6">
					<?php if ( has_nav_menu( 'login' ) ) {
						wp_nav_menu( array(
							'menu_id' => 'login-menu',
							'container' => false,
							'theme_location' => 'login',
							'link_before'    => '<span>',
							'link_after'     => '</span>',
						) );
					}?>
				</div>
				<?php
				break;
				case 'top-right':?>
				<div class="header-top-right text-right col-sm-6">
					<div class="row">
				<?php if ( ! is_user_logged_in() ) {
					echo '<a href="' . home_url( '/signup/?action=login' ) . '" title="' . esc_attr__( 'Sign in', 'wyzi-business-finder' ) . '">' . esc_html__( 'sign in', 'wyzi-business-finder' ) . '</a> | <a href="' . home_url( '/signup/' ) . '" title="' . esc_attr__( 'Signup', 'wyzi-business-finder' ) . '">' . esc_html__( 'Sign Up', 'wyzi-business-finder' ) . '</a>';
				} else { 
					$user_id = get_current_user_id();
					$macc_title =  esc_html__( 'my account', 'wyzi-business-finder' );
					$cur_mnu_itm = ( is_page( 'user-account' ) ? ' current-menu-item' : '' );
					$macc_select = wyz_get_option( 'login-btn-content-type' );
					$current_user = get_userdata($user_id);
					switch ( $macc_select ) {
						case 'firstname':
							$macc_title = $current_user->first_name;
							break;
						case 'lastname':
							$macc_title = $current_user->last_name;
							break;
						case 'username':
							$macc_title = $current_user->user_login;
							break;
						case 'custom-text':
							$macc_title = esc_html( wyz_get_option( 'login-btn-custom-text' ) );
							break;
					}

					echo '<a href="' . esc_url( home_url( '/user-account/' ) ) . '" title="' . esc_attr__( 'My Account', 'wyzi-business-finder' ) . '">' . $macc_title . '</a> | <a href="' . wp_logout_url( home_url() ) . '" title="' . esc_attr__( 'Logout', 'wyzi-business-finder' ) . '">' . esc_html__( 'logout', 'wyzi-business-finder' ) . '</a>';
            	} ?>
					</div>
				</div>
				<?php
				break;
			}
			
		}


		protected function the_main_menu() {
			?>
			<!-- Main Menu -->
			<div class="main-menu<?php echo 'header2' == $this->header_template ? ' main-menu2 float-right' : ('header3' == $this->header_template || 'header4' == $this->header_template ? ' float-left' : ' float-right' ) ; ?><?php if ( 'off' != wyz_get_option( 'resp' ) ) {?> hidden-xs<?php }?>">
				<?php if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array(
						'menu_id' => 'main-menu',
						'container' => 'nav',
						'theme_location' => 'primary',
					) );
				}?>
			</div>
			<?php
		}

		private function the_mobile_menu() {
			if ( 'off' != wyz_get_option( 'resp' ) ) {
				$this->mobile_menu_factory->the_mobile_menu();
			}
		}

		public function the_utility_bar() {
			if ( 'on' != wyz_get_option( 'utility-bar-onoff' ) ) {
				return;
			}
			?>
			<!-- Header Top -->
			<div class="header-top">
				<div class="container">
					<div class="row">
						<!-- Header Top Left -->
						<div class="header-top-left <?php echo 'off' == wyz_get_option( 'resp' ) ? 'col-xs-8' : 'col-lg-8 col-md-7 col-xs-12';?>">
							<?php
							$num = wyz_get_option( 'contact-number' );
							$sup_txt = wyz_get_option( 'support-text' );
							$sup_link = wyz_get_option( 'support-link' );
							if ( '' !== $num ) {
								echo '<p><i class="fa fa-phone"></i>' . esc_html( $num ) . '</p>';
							}
							if ( '' !== $sup_txt ) {
								echo '<p><i class="fa fa-caret-right"></i><a href="' . esc_url( $sup_link ) . '">' . esc_html( $sup_txt ) . '</a></p>';
							}
							if ( 'off' != wyz_get_option( 'header_search_form' ) ) {?>
							<div class="header-search float-left">
								<?php get_search_form( true );?>
							</div>
							<?php }?>
						</div>
						<!-- Header Top Right Social -->
						<div class="header-right <?php echo 'off' == wyz_get_option( 'resp' ) ? 'col-xs-4' : 'col-lg-4 col-md-5 col-xs-12';?> fix">
							<div class="header-social float-right">
								<?php wyz_social_links();?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

		private function the_logo() {?>
			<!-- Header Logo -->
			<?php if ( 'header3' == $this->header_template || 'header4' == $this->header_template )
				echo '<div class="text-left col-md-3 col-sm-6 col-xs-12"><div class="row">';
			?>
			<div class="header-logo float-left<?php echo 'header2' == $this->header_template ? ' header-2-logo' : '' ; ?>">
				<a href="<?php echo esc_url( home_url( '/' ) );?>">
				<?php if ( '' !== $this->logo ) { ?>
					<img src="<?php echo esc_url( $this->logo );?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
				<?php } else {?>
					<div id="logo-ttl-cont">
						<h3><?php echo esc_html( get_bloginfo( 'name' ) ); ?></h3>
					</div>
				<?php } ?>
				</a>
			</div>
			<?php if ( 'header3' == $this->header_template || 'header4' == $this->header_template ) {
				echo '</div></div>';
				if ( 'header4' == $this->header_template ){?>
					<div class="col-md-6 col-xs-12 text-center section">
						<div class="container-fluid">
							<div class="row">
								<div class="acgbtb">
									<div class="acgbtb-content float-right text-right col-sm-6 col-xs-12">
									<?php echo do_shortcode( wyz_get_option( 'acgbtb_right_content' ) );?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php
				}
			}
		}

		private function submit_place_btn() {
			if ( 'header4' != $this->header_template )return;
			$pref = is_user_logged_in() ? '' :'non-';
			if ( 'on' !== wyz_get_option( $pref.'logged-menu-right-link'))return;
			$link_to = wyz_get_option($pref.'logged-menu-right-link-to');
			$link = '';
			if ( 'page' == $link_to ){
				$link = get_permalink( wyz_get_option($pref.'logged-menu-right-link-page'));
				if (!$link)$link='#';
			}elseif('link'==$link_to)
				$link = esc_url(wyz_get_option($pref.'logged-menu-right-link-link'));
			elseif(is_user_logged_in()&&'add-business'==$link_to && class_exists('WyzQueryVars'))
				$link = add_query_arg( WyzQueryVars::AddNewBusiness, true, home_url( '/user-account') );
			$link_label = wyz_get_option($pref.'logged-menu-right-link-label');?>
			
			<div class="text-right float-right hidden-xs">
				<div class="header-links">
					<a href="<?php echo esc_url($link); ?>"><i class="fa fa-paper-plane-o"></i><span><?php echo esc_html($link_label); ?></span></a>
				</div>
			</div>
			<?php
		}


		public function the_main_header() {
			if ( 'header3' == $this->header_template ) { ?>
			<div class="container">
				<div class="header-top-login-menu section hidden-xs">
					<?php $this->the_login_menu( 'top-left' ); ?>
					<?php $this->the_login_menu( 'top-right' ); ?>
					<div class="clear"></div>
				</div>
				<div class="header-acgbtb text-center section">
					<div class="container-fluid">
						<div class="row">
							<div class="acgbtb">
								<div class="acgbtb-content float-right text-right col-sm-6 col-xs-12">
								<?php echo do_shortcode( wyz_get_option( 'acgbtb_right_content' ) );?>
								<div class="clear"></div>
								</div>
								<?php $this->the_logo();?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } elseif ( 'header4' == $this->header_template ) {?>
				<div class="header-acgbtb text-center section">
					<div class="container">
						<div class="row">
							<div class="acgbtb">
								<div class="float-right text-right col-md-3 col-sm-6 col-xs-12">
								<?php $this->submit_place_btn();?>
								<div class="clear"></div>
								</div>
								<?php $this->the_logo();?>
							</div>
						</div>
					</div>
				</div
			<?php }?>
			<!-- navigation -->
			<div class="header-bottom<?php if ( 'header3' == $this->header_template || 'header4' == $this->header_template ) echo ' header-bottom-acgbtb';?>">
				<div class="container">
					<div class="col-xs-12">
						<div class="row">
							<div class="header-bottom-wrap<?php if ( 'header3' == $this->header_template || 'header4' == $this->header_template ) echo ' acgbtb-m';?>">
								<!-- Logo -->
								<?php if ( 'header3' != $this->header_template && 'header4' != $this->header_template )
									$this->the_logo();
								if ( 'header3' != $this->header_template )
									$this->the_login_menu( '' );
								?>
								<?php $this->the_main_menu();?>
								<?php $this->the_mobile_menu();?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}

	}
}