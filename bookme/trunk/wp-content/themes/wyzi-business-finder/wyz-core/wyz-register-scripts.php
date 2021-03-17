<?php

/*
 * Create custom css from wyzi settings.
 */

global $template_type;
function wyz_custom_styles() {
	$template = wyz_get_theme_template();
	// WYZI style sheet.
	wp_enqueue_style( 'wyz-style', get_stylesheet_uri() );
	//include template css
	wp_enqueue_style( 'wyz-template-style', WYZ_CSS_URI . "/style-$template.css" );
	// Responsive css.
	if ( 'off' == wyz_get_option( 'resp' ) ) {
		wp_enqueue_style( 'wyz-non-responsive-style', WYZ_CSS_URI . '/non-responsive.css' );
	} else {
		wp_enqueue_style( 'wyz-responsive-style', WYZ_CSS_URI . "/css-$template/responsive.css" );
	}

	if ( is_rtl() ) {
		wp_enqueue_style( 'wyz-rtl-style', WYZ_CSS_URI . "/css-$template/rtl.css" );	
	}
	

	ob_start();
	if ( 2 == $template )
		wyz_template2_colors();
	else
		wyz_template1_colors();

	if ( 'on' == wyz_get_option( 'footer-sticky-menu' ) && wyz_is_mobile() ) {?>
footer {
	margin-bottom: 56px;
}
footer .footer-bottom {
	bottom: 0;
	height: 56px;
	position: fixed;;
	width: 100%;
	z-index: 999999;
}
	<?php } ?>
	/* Custom CSS Codes */
	
body {
	<?php
    $arr = wyz_get_option( 'wyz-background' );

    if ( isset( $arr['background-color'] ) && '' != $arr['background-color'] ) {
    	echo 'background-color: ' . esc_attr( $arr['background-color'] ) . ';';
    }
    if ( isset( $arr['background-attachment'] ) && '' != $arr['background-attachment'] ) {
    	echo 'background-attachment: ' . esc_attr( $arr['background-attachment'] ) . ';';
    }
    if ( isset( $arr['background-repeat'] ) && '' != $arr['background-repeat'] ) {
    	echo 'background-repeat: ' . esc_attr( $arr['background-repeat'] ) . ';';
    }
    if ( isset( $arr['background-image'] ) && '' != $arr['background-image'] ) {
        echo 'background-image: url(' . esc_attr( $arr['background-image'] ) . ');';
    }
    if ( isset( $arr['background-size'] ) && '' != $arr['background-size'] ) {
        echo 'background-size: ' . esc_attr( $arr['background-size'] ) . ';';
    }
    if ( isset( $arr['background-position'] ) && '' != $arr['background-position'] ) {
        echo 'background-position: ' . esc_attr( $arr['background-position'] ) . ';';
    } ?>
}

/*Page loader spinner*/
<?php if ( '' != wyz_get_option( 'page-loader-color' ) ) {?>
.spinner > div {
	background-color: <?php echo esc_attr( wyz_get_option( 'page-loader-color' ) );?>;
}
<?php }?>
<?php if ( '' != wyz_get_option( 'footer-color' ) ) {?>
/*footer=============================================================================*/
.footer-top, .footer-bottom, .footer-menu, #copyrights {
    background-color:<?php echo esc_attr( wyz_get_option( 'footer-color' ) );?>;
}
<?php }

$typography = wyz_get_option( 'wyz-typography' );
if ( ! empty( $typography ) ) {?>
/*typography==========================================================================*/
p, b, a, span, li, .input-box label, .input-box input, .wyz-button, .entry-footer .entry-meta {
	<?php if ( isset( $typography['font-size'] ) && $typography['font-size'] != '' ) { 
		echo 'font-size: ' . esc_attr( $typography['font-size'] ) . ' !important;';
	}
	if ( isset( $typography['font-family'] ) && $typography['font-family'] != '' ) {
		echo 'font-family: ' . esc_attr( $typography['font-family'] ) . ' !important;';
	}
	if ( isset( $typography['font-style'] ) && $typography['font-style'] != '' ) {
		echo 'font-style: ' . esc_attr( $typography['font-style'] ) . ';';
	}
	if ( isset( $typography['font-color'] ) && $typography['font-color'] != '' ) {
		echo 'color: ' . esc_attr( $typography['font-color'] ) . ' !important;';
	}
	if ( isset( $typography['letter-spacing'] ) && $typography['letter-spacing'] != '' ) {
		echo 'letter-spacing: ' . esc_attr( $typography['letter-spacing'] ) . ' !important;';
	}?>
}
<?php }
$h1_typography = wyz_get_option( 'h1-typography' );
if ( ! empty( $h1_typography ) ) { ?>
h1 {
	<?php if ( isset( $h1_typography['font-size'] ) && $h1_typography['font-size'] != '' ) { 
		echo 'font-size: ' . esc_attr( $h1_typography['font-size'] ) . ' !important;';
	}
	if ( isset( $h1_typography['font-family'] ) && $h1_typography['font-family'] != '' ) {
		echo 'font-family: ' . esc_attr( $h1_typography['font-family'] ) . ' !important;';
	}
	if ( isset( $h1_typography['font-style'] ) && $h1_typography['font-style'] != '' ) {
		echo 'font-style: ' . esc_attr( $h1_typography['font-style'] ) . ';';
	}
	if ( isset( $h1_typography['font-color'] ) && $h1_typography['font-color'] != '' ) {
		echo 'color: ' . esc_attr( $h1_typography['font-color'] ) . ' !important;';
	}
	if ( isset( $h1_typography['letter-spacing'] ) && $h1_typography['letter-spacing'] != '' ) {
		echo 'letter-spacing: ' . esc_attr( $h1_typography['letter-spacing'] ) . ' !important;';
	}?>
}

<?php }
$h2_typography = wyz_get_option( 'h2-typography' );
if ( ! empty( $h2_typography ) ) { ?>
h2 {
	<?php if ( isset( $h2_typography['font-size'] ) && $h2_typography['font-size'] != '' ) { 
		echo 'font-size: ' . esc_attr( $h2_typography['font-size'] ) . ' !important;';
	}
	if ( isset( $h2_typography['font-family'] ) && $h2_typography['font-family'] != '' ) {
		echo 'font-family: ' . esc_attr( $h2_typography['font-family'] ) . ' !important;';
	}
	if ( isset( $h2_typography['font-style'] ) && $h2_typography['font-style'] != '' ) {
		echo 'font-style: ' . esc_attr( $h2_typography['font-style'] ) . ';';
	}
	if ( isset( $h2_typography['font-color'] ) && $h2_typography['font-color'] != '' ) {
		echo 'color: ' . esc_attr( $h2_typography['font-color'] ) . ' !important;';
	}
	if ( isset( $h2_typography['letter-spacing'] ) && $h2_typography['letter-spacing'] != '' ) {
		echo 'letter-spacing: ' . esc_attr( $h2_typography['letter-spacing'] ) . ' !important;';
	}?>
}

<?php }
$h3_typography = wyz_get_option( 'h3-typography' );
if ( ! empty( $h3_typography ) ) { ?>
h3 {
	<?php if ( isset( $h3_typography['font-size'] ) && $h3_typography['font-size'] != '' ) { 
		echo 'font-size: ' . esc_attr( $h3_typography['font-size'] ) . ' !important;';
	}
	if ( isset( $h3_typography['font-family'] ) && $h3_typography['font-family'] != '' ) {
		echo 'font-family: ' . esc_attr( $h3_typography['font-family'] ) . ' !important;';
	}
	if ( isset( $h3_typography['font-style'] ) && $h3_typography['font-style'] != '' ) {
		echo 'font-style: ' . esc_attr( $h3_typography['font-style'] ) . ';';
	}
	if ( isset( $h3_typography['font-color'] ) && $h3_typography['font-color'] != '' ) {
		echo 'color: ' . esc_attr( $h3_typography['font-color'] ) . ' !important;';
	}
	if ( isset( $h3_typography['letter-spacing'] ) && $h3_typography['letter-spacing'] != '' ) {
		echo 'letter-spacing: ' . esc_attr( $h3_typography['letter-spacing'] ) . ' !important;';
	}?>
}

<?php }
$h4_typography = wyz_get_option( 'h4-typography' );
if ( ! empty( $h1_typography ) ) { ?>
h4 {
	<?php if ( isset( $h4_typography['font-size'] ) && $h4_typography['font-size'] != '' ) { 
		echo 'font-size: ' . esc_attr( $h4_typography['font-size'] ) . ' !important;';
	}
	if ( isset( $h4_typography['font-family'] ) && $h4_typography['font-family'] != '' ) {
		echo 'font-family: ' . esc_attr( $h4_typography['font-family'] ) . ' !important;';
	}
	if ( isset( $h4_typography['font-style'] ) && $h4_typography['font-style'] != '' ) {
		echo 'font-style: ' . esc_attr( $h4_typography['font-style'] ) . ';';
	}
	if ( isset( $h4_typography['font-color'] ) && $h4_typography['font-color'] != '' ) {
		echo 'color: ' . esc_attr( $h4_typography['font-color'] ) . ' !important;';
	}
	if ( isset( $h4_typography['letter-spacing'] ) && $h4_typography['letter-spacing'] != '' ) {
		echo 'letter-spacing: ' . esc_attr( $h4_typography['letter-spacing'] ) . ' !important;';
	}?>
}

<?php }
$h5_typography = wyz_get_option( 'h5-typography' );
if ( ! empty( $h5_typography ) ) { ?>
h5 {
	<?php if ( isset( $h5_typography['font-size'] ) && $h5_typography['font-size'] != '' ) { 
		echo 'font-size: ' . esc_attr( $h5_typography['font-size'] ) . ' !important;';
	}
	if ( isset( $h5_typography['font-family'] ) && $h5_typography['font-family'] != '' ) {
		echo 'font-family: ' . esc_attr( $h5_typography['font-family'] ) . ' !important;';
	}
	if ( isset( $h5_typography['font-style'] ) && $h5_typography['font-style'] != '' ) {
		echo 'font-style: ' . esc_attr( $h5_typography['font-style'] ) . ';';
	}
	if ( isset( $h5_typography['font-color'] ) && $h5_typography['font-color'] != '' ) {
		echo 'color: ' . esc_attr( $h5_typography['font-color'] ) . ' !important;';
	}
	if ( isset( $h5_typography['letter-spacing'] ) && $h5_typography['letter-spacing'] != '' ) {
		echo 'letter-spacing: ' . esc_attr( $h5_typography['letter-spacing'] ) . ' !important;';
	}?>
}
<?php }
$h6_typography = wyz_get_option( 'h6-typography' );
if ( ! empty( $h6_typography ) ) { ?>
h6 {
	<?php if ( isset( $h6_typography['font-size'] ) && $h6_typography['font-size'] != '' ) { 
		echo 'font-size: ' . esc_attr( $h6_typography['font-size'] ) . ' !important;';
	}
	if ( isset( $h6_typography['font-family'] ) && $h6_typography['font-family'] != '' ) {
		echo 'font-family: ' . esc_attr( $h6_typography['font-family'] ) . ' !important;';
	}
	if ( isset( $h6_typography['font-style'] ) && $h6_typography['font-style'] != '' ) {
		echo 'font-style: ' . esc_attr( $h6_typography['font-style'] ) . ';';
	}
	if ( isset( $h6_typography['font-color'] ) && $h6_typography['font-color'] != '' ) {
		echo 'color: ' . esc_attr( $h6_typography['font-color'] ) . ' !important;';
	}
	if ( isset( $h6_typography['letter-spacing'] ) && $h6_typography['letter-spacing'] != '' ) {
		echo 'letter-spacing: ' . esc_attr( $h6_typography['letter-spacing'] ) . ' !important;';
	}?>
}
<?php }
$font_style = wyz_get_option( 'menu-font' );?>
/*font options*/
.main-menu ul > li > a,#main-menu > li.menu-item-has-children .fa, .main-menu >ul> li.menu-item-has-children .fa , .main-menu .sub-menu li a, .mean-nav > ul > li a, #main-menu > li a {
	<?php if ( wyz_get_option( 'menu-link-default-color' ) ) {
		echo 'color: ' . esc_attr( wyz_get_option( 'menu-link-default-color' ) ) . ' !important;';
	}
	if ( isset( $font_style['font-size'] ) && $font_style['font-size'] != '' ) {
		echo 'font-size: ' . esc_attr( $font_style['font-size'] ) . ' !important;';
	}
	if ( isset( $font_style['font-style'] ) && $font_style['font-style'] != '' ) {
		echo 'font-style: ' . esc_attr( $font_style['font-style'] ) . ' !important;';
	}
	if ( isset( $font_style['font-weight'] ) && $font_style['font-weight'] != '' ) {
		echo 'font-weight: ' . esc_attr( $font_style['font-weight'] ) . ' !important;';
	}?>
}
/*Utility bar=======================================================================================*/
<?php
$ubgc = wyz_get_option( 'utility-bar-bg-color' );
$utc = wyz_get_option( 'utility-bar-txt-color' );
$ubo = wyz_get_option( 'utility-bar-onoff' );
if ( 'on' === $ubo ) {
	if ( '' !== $ubgc ) {?>
.header-top, .header-top-right .logout-link {
    <?php echo 'background-color: ' . esc_attr( $ubgc ) . ';';?>
}
<?php }?>
<?php if ( '' !== $utc ) {?>
.header-top-left .call-us, .header-top-left .call-us i, .header-top-left p a, .header-top-left p i, .header-search button i, .header-search input,
.header-top-right a,.header-top-right .row>span,.header-top-right span, .header-top-center .login-register li{
	<?php echo 'color: ' . esc_attr( $utc ) . ';';?>
}
<?php }
}?>
/*Logo options======================================================================================*/
.header-logo img {
	<?php
	$logo_dim = wyz_get_option('header-logo-dimensions');
	$dim_unit = is_array( $logo_dim ) && isset( $logo_dim['unit'] ) ? esc_attr( $logo_dim['unit'] ) : 'px';
	$logo_pad = wyz_get_option('header-logo-spacing');
	$pad_unit = is_array( $logo_pad ) && isset( $logo_pad['unit'] ) ? esc_attr( $logo_pad['unit'] ) : 'px';
	
	if ( isset( $logo_dim['width'] ) ) {
		echo 'width: ' . esc_attr( $logo_dim['width'] ) . $dim_unit . ';';
	}
	if ( isset( $logo_dim['height'] ) ) {
		echo 'height: ' . esc_attr( $logo_dim['height'] ) . $dim_unit . ';';
	}
	if ( isset( $logo_pad['top'] ) ) {
		echo 'margin-top:' . esc_attr( $logo_pad['top'] ) . $pad_unit . ';';
	}
	if ( isset( $logo_pad['bottom'] ) ) {
		echo 'margin-bottom:' . esc_attr( $logo_pad['bottom'] ) . $pad_unit . ';';
	}
	if ( isset( $logo_pad['left'] ) ) {
		echo 'margin-left:' . esc_attr( $logo_pad['left'] ) . $pad_unit . ';';
	}
	if ( isset( $logo_pad['right'] ) ) {
		echo 'margin-right:' . esc_attr( $logo_pad['right'] ) . $pad_unit . ';';
	}?>
}

#logo-ttl-cont h3 {
	<?php
	$ttl_logo = wyz_get_option( 'logo-font' );
	if ( isset( $ttl_logo['font-size'] ) ) {
		echo 'font-size: ' . esc_attr( $ttl_logo['font-size'] ) . ' !important;';
	}
	if ( isset( $ttl_logo['font-style'] ) ) {
		echo 'font-style: ' . esc_attr( $ttl_logo['font-style'] ) . ' !important;';
	}
	if ( isset( $ttl_logo['font-weight'] ) ) {
		echo 'font-weight: ' . esc_attr( $ttl_logo['font-weight'] ) . ' !important;';
	}
	if ( isset( $ttl_logo['font-color'] ) ) {
		echo 'color: ' . esc_attr( $ttl_logo['font-color'] ) . ' !important;';
	}
	?>
}
/*Main Menu options======================================================================================*/

/*menu background*/
<?php if ( wyz_get_option( 'menu-bg-color' ) != '' ) { ?>
.header-bottom, .main-menu ul.sub-menu, .mean-nav > ul > li > a {
	<?php echo 'background-color: ' . esc_attr( wyz_get_option( 'menu-bg-color' ) ) . ';';?>
}
<?php }

if ( wyz_get_option( "menu-item-current-color" ) != '' ) {?>
/*menu item active state*/
.main-menu nav > ul > li.current-menu-item > a,
.main-menu nav > ul > li.current-menu-item:hover > a {
 	<?php echo 'color: ' . esc_attr( wyz_get_option( 'menu-item-current-color' ) ) . ';';?>
}
<?php }
if ( wyz_get_option( 'menu-item-current-bg-color' ) != '' ) { ?>
.main-menu nav > ul > li.current-menu-item {
	<?php echo 'background-color: ' . esc_attr( wyz_get_option( 'menu-item-current-bg-color' ) ) . ';';?>
}
<?php }
if ( wyz_get_option( 'menu-item-hover-color' ) != '' ) { ?>
/*menu item hover*/
.main-menu ul li:hover > a,
.main-menu .sub-menu li a:hover > i,
.mean-nav > ul > li a:hover,
.mean-nav > ul > li a:hover > i {
	<?php echo 'color: ' . esc_attr( wyz_get_option( 'menu-item-hover-color' ) ) . ' !important;';?>
}
<?php }
if ( wyz_get_option( "menu-item-bg-hover-color" ) != '' ) {?>
.main-menu ul li:hover, .mean-nav > ul > li a:hover {
	<?php echo 'background-color: ' . esc_attr( wyz_get_option( 'menu-item-bg-hover-color' ) ) . ';';?>
}
<?php }?>
/*scroll to top=========================================================================*/
.back-to-top {
<?php
	if ( wyz_get_option( 'scroll-to-top-float' ) == 'left' ) {
		echo 'left: 20px;';
	}
	if( wyz_get_option( 'scroll-to-top-bg-color' ) != '' ) {
		echo 'background-color: ' . esc_attr(  wyz_get_option( 'scroll-to-top-bg-color' ) ) . ';';
	}?>
}
<?php if( wyz_get_option( 'scroll-to-top-color' ) != '' ) { ?>
.back-to-top i {
	<?php echo 'color: ' .  esc_attr( wyz_get_option( 'scroll-to-top-color' ) ) . ';';?>
}
<?php }
if( 'on' == wyz_get_option( 'footer-sticky-menu' ) && wyz_is_mobile() ) {
	echo '.back-to-top {bottom: 80px;}';
}
?>


/*get custom manualy added css*/
<?php

if( wyz_get_option( 'custom-css' ) != '' ) {
	echo wyz_get_option( 'custom-css' );
}

if ( 'on' != wyz_get_option( 'resp' ) ) {
	$width = esc_attr( wyz_get_option( 'content-width' ) );
	if ( '' != $width ) {?>
.container {
	<?php echo 'width: ' . $width . 'px !important;';?>
}
.header {
	<?php echo 'min-width: ' . $width . 'px !important;';?>
}
.main-html {
	<?php echo 'min-width: ' . $width . 'px !important;';?>
}
<?php }
}
do_action( 'wyz_after_custom_styles' );
wp_add_inline_style( 'wyz-template-style', ob_get_clean() );
}


function wyz_template1_colors() {
	$wyz_primary_color = wyz_get_option( 'primary-color' );
	$wyz_secondary_color = wyz_get_option( 'secondary-color' );

	if ( '' == $wyz_primary_color ) {
		$wyz_primary_color = '#00aeff';
	}

	if ( '' == $wyz_secondary_color ) {
		$wyz_secondary_color = '#ff6d1e';
	}?>
	.wyz-secondary-color,
	input.wyz-secondary-color,
	.hovereffect:hover .loc-count span,
	.sin-footer .widget-title::before,
	.wyz-secondary-color-hover:hover,
	.wyz-button:hover,
	.wyz-button:focus,
	.page-links>.page-links-before,
	.page-links a:hover,
	.page-links a:hover,
	.page-links>.page-links-before,
	.own-slider-field .ui-state-hover,
	#business-progressbar li:after,
	#business-progressbar li:before,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.rangeslider .range_handle,
	.rangeslider .range_fill {
		background-color: <?php echo sanitize_hex_color($wyz_secondary_color);?> !important;
	}
	a:hover,
	.wyz-secondary-color-text,
	.wyz-secondary-color-text-hover:hover,
	.category-item a:hover,
	.comment-list .comment-meta.commentmetadata a:hover,
	.sin-footer.widget-area .widget a:hover,
	.comment-list .reply a,
	#login-menu .wcmenucart-contents:hover,
	#login-menu .wcmenucart-contents:hover .fa-shopping-cart,
	.blog-pagination a.active,
	.blog-pagination a:hover,
	.comment-navigation a:hover,
	.sin-blog .content .blog-meta span a:hover,
	.sin-blog .content .blog-meta:hover>.fa,
	.contact-info-sidebar .phone:before,
	.contact-info-sidebar .address:before,
	.contact-info-sidebar .email:before,
	.contact-info-sidebar .website:before,
	.tags-sidebar:before,
	.contact-info-sidebar p a:hover /*,
	.business-tab-list ul li.products a:hover:before*/ {
		color: <?php echo sanitize_hex_color($wyz_secondary_color);?>;
	}

	.wyz-primary-color-text,
	.sin-busi-post .footer .post-comment a:hover,
	a.wyz-primary-color-text:focus{
		color: <?php echo sanitize_hex_color($wyz_primary_color);?>;
	}


	.wyz-primary-color,
	.wyz-primary-color-hover:hover,
	input.wyz-primary-color,
	.wyz-button.wyz-primary-color,
	button.wyz-primary-color,
	.owl-carousel .owl-nav button.owl-next:hover,
	.owl-carousel .owl-nav button.owl-prev:hover,
	.owl-carousel button.owl-dot :hover,
	#subscription .pmpro_btn.pmpro_btn-select,
	.blogs .product.type-product .add_to_cart_button,
	.btn-square,
	.ui-datepicker .ui-widget-header, .ui-datepicker .ui-datepicker-header,
	.wp-picker-clear,
	.ui-datepicker-buttonpane button,
	.post-password-form input[type="submit"],
	.open-close-days .cmb-remove-field-row button.cmb-remove-group-row,
	.open-close-days .cmb-row .cmb-add-row button.cmb-add-group-row,
	#wp-calendar #today,
	.page-links a:link, .page-links>.page-links-before,
	.blue .rangeslider .range_fill,
	.blue .rangeslider .range_handle,
	.sticky>span,
	.selectize-control.multi .selectize-input [data-value],
	.cmb2-element .ui-datepicker .ui-datepicker-header, .cmb2-element .ui-datepicker .ui-widget-header, .cmb2-element.ui-datepicker .ui-datepicker-header, .cmb2-element.ui-datepicker .ui-widget-header,
	.cmb2-element.ui-datepicker .ui-timepicker-div+.ui-datepicker-buttonpane .button-primary,
	.cmb2-element.ui-datepicker .ui-timepicker-div+.ui-datepicker-buttonpane .button-secondary,
	.job-manager-form input[type="submit"],
	.job-manager-form fieldset .account-sign-in .button,
	.single_job_listing .application .application_button,
	.load_more_jobs strong,
	.job-manager-form input[type="submit"],
	.subscribe-form form input[type="submit"],
	.wpcf7 .wpcf7-submit,
	#business-progressbar li.active:before,
	#business-progressbar li.active:after,
	.job_filters .search_jobs,
	.cmb-row .cmb-td input.cmb2-upload-button,
	.cmb-td .ui-widget-header,
	.own-slider-field .cmb-td .ui-slider .ui-slider-handle,
	.woocommerce #respond input#submit,
	.woocommerce a.button,
	.woocommerce input.button,
	.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt,
	.woocommerce button.button.alt,
	.woocommerce input.button.alt,
	.tribe-events-event-cost form button.tribe-button,
	.wcmp_regi_main .button,
	.cmb-repeatable-group .cmb-add-group-row.button-secondary,
	.cmb-repeatable-group .cmb-remove-group-row.button-secondary,
	.pmpro_btn.pmpro_btn-submit-checkout,
	.progress-bar-video-post,
	#busi-comment-btn.busi_post_submit-dis:hover{
		background-color: <?php echo sanitize_hex_color($wyz_primary_color);?> !important;
	}
	.wyz_claim_form_main input[type="file"]::-webkit-file-upload-button,
	.wcmp_regi_main input[type="file"]::-webkit-file-upload-button{
		background-color: <?php echo sanitize_hex_color($wyz_primary_color);?>;
		background: <?php echo sanitize_hex_color($wyz_primary_color);?>;
	}
	.wyz-primary-color-txt,
	.sub-menu li a:hover,
	.sub-menu li a:hover > i,
	.megamenu ul li a:hover,
	.delete-dropdown a:hover {
		color: <?php echo sanitize_hex_color($wyz_primary_color);?>;
	}
	.sidebar-tab-list li.active,
	.woocommerce-tabs .wc-tabs li.active,
	.woocommerce-info {
		border-top-color: <?php echo sanitize_hex_color($wyz_primary_color);?>;
	}
	.wyz-info {
    border-left: 3px solid <?php echo sanitize_hex_color($wyz_primary_color);?>;
	}
	.selectize-control.plugin-remove_button [data-value] .remove,
	.business-tab-list ul li.active,
	.profile-tab-list ul li.active,
	.business-tab-list ul li .tab-overlay,
	.profile-tab-list ul li .tab-overlay{
	border-color: <?php echo sanitize_hex_color($wyz_primary_color);?> !important;
	}
	.wyz-menu-sidebar {
		box-shadow: 0.5em 0 0 0 <?php echo sanitize_hex_color($wyz_primary_color);?> !important;
		-webkit-box-shadow: 0.5em 0 0 0 <?php echo sanitize_hex_color($wyz_primary_color);?> !important;
	}
	<?php 
}

function wyz_template2_colors() {
	$wyz_primary_color = wyz_get_option( 'primary-color' );
	$wyz_secondary_color = wyz_get_option( 'secondary-color' );

	if ( '' == $wyz_primary_color ) {
		$wyz_primary_color = '#4285f4';
	}

	if ( '' == $wyz_secondary_color ) {
		$wyz_secondary_color = '#34a853';
	}
	?>
	.wyz-prim-color-txt-hover:hover,
	.page-map-right-content .map-info-links li a:hover,
	.wyz-prim-color-txt,
	
	input.star:checked ~ label.star:before,
	.main-menu > ul > li:hover > a,
	.main-menu > ul > li.current-menu-item > a,
	#login-menu > li:hover > a,
	#login-menu > li.current-menu-item > a,
	.sub-menu li:hover > a,
	.sub-menu li.active a,
	.sub-menu li:hover i,
	.login-reg-form label,
	.login-form label,
	.profile-form label,
	.wall-tab-list ul li a:hover i,
	a:active, a:hover,
	.offer-banner-text a:hover,
	.busi_post_submit-dis:hover,
	.busi_post_submit-dis{
	  color: <?php echo sanitize_hex_color($wyz_primary_color);?>;
	}
	.wyz-prim-color,
	.selectize-control.multi .selectize-input [data-value],
	.wyz-prim-color-hover:hover,
	.search-wrapper:hover>.close-button,
	#wall-message-form input[type="submit"]:hover,
	.tag-widget a:hover,
	.btn-bg-blue,
	.single-place .link::before,
	.job_filters .search_jobs,
	.location-slide-item .location-image a::before,
	.pmpro_btn, .pmpro_btn:link,
	.job-manager-form fieldset .account-sign-in .button,
	.single_job_listing .application .application_button,
	.ui-datepicker .ui-widget-header, .ui-datepicker .ui-datepicker-header,
	.pmpro_content_message a,
	.pmpro_content_message a:link,
	.cmb2-element .ui-datepicker .ui-datepicker-header, .cmb2-element .ui-datepicker .ui-widget-header, .cmb2-element.ui-datepicker .ui-datepicker-header, .cmb2-element.ui-datepicker .ui-widget-header,
	.cmb2-element.ui-datepicker .ui-timepicker-div+.ui-datepicker-buttonpane .button-primary,
	.cmb2-element.ui-datepicker .ui-timepicker-div+.ui-datepicker-buttonpane .button-secondary,
	.rangeslider .range_fill, .rangeslider .range_handle,
	.pmpro_btn .pmpro_btn-submit-checkout,
	.login-reg-tab-list li.active a:hover,
	.login-reg-tab-list li.active a,
	#business-progressbar li.active:before, #business-progressbar li.active:after,
	.cmb-row .cmb-td input.cmb2-upload-button, .wp-picker-clear, .cmb2-wrap .insert-media.add_media, .open-close-days .cmb-remove-field-row button.cmb-remove-group-row, .open-close-days .cmb-row .cmb-add-row button.cmb-add-group-row, #wyz-no-content-search #searchsubmit,
	.location-search .input-box.input-days .selectize-control.multi .selectize-input [data-value],
	.location-search .input-box.input-days .selectize-control.multi .selectize-input [data-value].active,
	.header-top-right .user-logged-in:hover i,
	.cmb-repeatable-group .cmb-add-group-row.button-secondary,
	.cmb-repeatable-group .cmb-remove-group-row.button-secondary,
	.tribe-events-event-cost form button.tribe-button,
	.pmpro_btn.pmpro_btn-submit-checkout,
	.progress-bar-video-post{
	  background-color: <?php echo sanitize_hex_color($wyz_primary_color);?> !important;
	}
	@media only screen and (max-width: 767px) {
	.search-wrapper>.close-button {
	    background-color: <?php echo sanitize_hex_color($wyz_primary_color);?> !important;
	  }
	}
	.btn-square:hover, #my-business .wyz-button.blue:hover,
	.btn-square, #my-business .wyz-button.blue {
	border: 1px solid <?php echo sanitize_hex_color($wyz_primary_color);?> !important;
	}

	.wyz-info {
    	border-left: 3px solid <?php echo sanitize_hex_color($wyz_primary_color);?> !important;
	}
	
	.wyz-secon-color,
	.wyz-secon-color-hover:hover {
		background-color: <?php echo sanitize_hex_color($wyz_secondary_color);?> !important;
	}
	.selectize-control.plugin-remove_button [data-value] .remove {
	border-color: <?php echo sanitize_hex_color($wyz_primary_color);?> !important;
	}

	.wyz-secon-color-txt,
	.wyz-secon-color-txt-hover:hover {
		color: <?php echo sanitize_hex_color($wyz_secondary_color);?> !important;
	}
	<?php 
}

/**
 * Writes the site's custom java.
 */
function wyz_custom_java() {
	global $page_user_dashboard;
	if('is_set'==$page_user_dashboard){
		ob_start();?>

		//<![CDATA[
		<?php
		$custom_js = wyz_get_option( 'custom-script' );
		if ( '' != $custom_js ) {
			wp_add_inline_script( 'booked-spin-js', $custom_js );
		}
		?>
		//]]>
		<?php
		wp_add_inline_script( 'wyz_placeholder', ob_get_clean(), 'after' );
		return;
	}
	global $template_type;
	$template_type = wyz_get_theme_template();

	ob_start();?>

	//<![CDATA[
		<?php 
			$bg_color ='';
			$logo = '';
			$w = wyz_get_option( 'nice-scroll-scrollbar-width' );
			if ( 'on' == wyz_get_option( 'page-loader' ) ) {
			$bg_color = wyz_get_option( 'page-loader-bg' );
			if ( '' == $bg_color ) {
				$bg_color = '#00aeff';
			}
			$logo = wyz_get_option( 'header-logo-upload' ); ?>

		<?php }

		wp_enqueue_script( 'wyz-options-scripts', WYZ_THEME_URI . '/js/options-scripts.js', array( 'jquery' ), false, false );
		wp_localize_script( 'wyz-options-scripts', 'options_scripts_vars', array(

            'page_loader' => wyz_get_option( 'page-loader' ),
            'page_loader_logo' => trim(wp_json_encode( esc_url( $logo ) ),'"'),
            'page_loader_bg' =>  trim(wp_json_encode( esc_attr( $bg_color ) ),'"'),
            'sticky_menu_option' => wyz_get_option( 'sticky-menu' ),
            'admin_bar_showing' => is_admin_bar_showing(),
            'template_type' => $template_type,
            'is_mobile' => wyz_is_mobile(),
            'resp' => wyz_get_option( 'resp' ),
            'mobile_menu_layout' => wyz_get_option( 'mobile-menu-layout' ),
            'nice_scroll' => wyz_get_option( 'nice-scroll' ),
            'nice_width' => (isset( $w['width'] ) && '' != $w['width'] ) ? trim($w['width'],'"') . 'px' : '5px',
            'nice_scroll_color' => '' != wyz_get_option( 'nice-scroll-scrollbar-color' ) ? trim(wyz_get_option( 'nice-scroll-scrollbar-color' ),'"') : '#000000',
            'isrtl' => is_rtl()

        ));

	
	$custom_js = wyz_get_option( 'custom-script' );
	if ( '' != $custom_js ) {
		wp_add_inline_script( 'jquery-migrate', $custom_js );
	}
	?>
	//]]>
	<?php
	wp_add_inline_script( 'wyz_placeholder', ob_get_clean(), 'after' );
}

/**
 * Resister theme styles.
 */
function wyz_theme_styles() {

	$template_type = wyz_get_theme_template();

	/* Styles */

	wp_enqueue_style( 'wyz-font-montserrat', WYZ_THEME_URI . "/fonts/montserrat/font-style.css", false );

	//WYZI features css
	wp_enqueue_style( 'wyz-candy-plugin-style', WYZ_CSS_URI . '/wyz-features.min.css' );

	// WP default css.
	wp_enqueue_style( 'wyz-wp-default-style', WYZ_CSS_URI . "/css-$template_type/wp-default.css" );
	// Default css.
	wp_enqueue_style( 'wyz-default-style', WYZ_CSS_URI . "/css-$template_type/default.css" );


	//Page loader
	if ( 'on' == wyz_get_option( 'page-loader' ) ) {
		wp_enqueue_style( 'wyz-page-loader-css', WYZ_CSS_URI . '/please-wait.css' );
		wp_enqueue_script( 'wyz-page-loader-js', WYZ_THEME_URI . '/js/please-wait.min.js', array(), false, false );
	}

	// IE 7 Compatibility
	wp_enqueue_style( 'wyz-compatibity-ie7', WYZ_CSS_URI . '/ie7.css' );
	wp_style_add_data( 'wyz-compatibity-ie7', 'conditional', 'IE 7' );
	/* Scripts */

	// Bootsrap js.
	// Mean Menu js.
	// Magnific popup js.
	wp_enqueue_script( 'wyz-bootstrap-meanmenu-magnificpopup-js', WYZ_THEME_URI . '/js/bootstrap-meanmenu.min.js', array( 'jquery' ), false, false );
	
	$resp = wp_json_encode( 'off' == wyz_get_option( 'resp' ) ? false : true );
	
	// Sticky Menu js.
	if ( 'on' === wyz_get_option( 'sticky-menu' ) ) {
		wp_enqueue_script( 'wyz-stickymenu-js', WYZ_THEME_URI . '/js/jquery.sticky.min.js', array( 'jquery' ), false, false );
	}

	// Mobile Menu 2 Js
	if ( 'menu-2' === wyz_get_option( 'mobile-menu-layout' ) ) {
		wp_enqueue_script( 'wyz-menumobile2', WYZ_THEME_URI . '/js/menumobile2.js', array(), false, false );
		 wp_add_inline_style( 'wyz-default-style', "a.meanmenu-reveal{display:none !important;}" );
	}

	if ( 'on' === wyz_get_option( 'nice-scroll' ) ) {
		wp_enqueue_script( 'wyz-jquery-nicescroll-js', WYZ_THEME_URI . '/js/jquery.nicescroll.min.js', array( 'jquery' ), false, false );
	}
	wp_enqueue_script( 'wyz_placeholder', WYZ_THEME_URI . '/js/placeholder.js', '', false, false );
	wyz_custom_java();

	if ( is_singular() && comments_open() ) {
		wp_enqueue_script( 'comment-reply', false, false, false, true );
	}
}
add_action( 'wp_enqueue_scripts', 'wyz_theme_styles', 4 );

function wyz_footer_scripts() {
	/*footer sticky menu*/
	if ( 'on' == wyz_get_option( 'footer-sticky-menu' ) && wyz_is_mobile() ) {

	wp_enqueue_script( 'wyz-footer-sticky-menu', WYZ_THEME_URI . '/js/footer-sticky-menu.js', array( 'jquery' ), false, false );
	wp_localize_script( 'wyz-footer-sticky-menu', 'footer_seach_form', array(
            'search' => trim( get_search_form(array('echo' => false)) ),
        ));
	wp_enqueue_style( 'wyz-footer-sticky-menu-css', WYZ_CSS_URI . '/footer-sticky-menu.css' );
 }
}
add_action( 'wp_footer', 'wyz_footer_scripts' );

function wyz_woocommerce_styles() {
	global $template_type;
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'wyz-woocommerce-style-overrides', WYZ_CSS_URI . '/woocommerce.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'wyz_woocommerce_styles', 99 );
add_action( 'wp_enqueue_scripts', 'wyz_custom_styles', 100 );



?>
