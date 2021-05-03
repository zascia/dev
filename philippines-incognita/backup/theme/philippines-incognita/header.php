<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Philippines_Incognita
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <?php
        // WordPress 5.2 wp_body_open implementation
        if (function_exists('wp_body_open')) {
            wp_body_open();
        } else {
            do_action('wp_body_open');
        }
        $social_menu = '';
        $social_menu_mob = '';
                        $social = get_field('social', 'option');
                        if (!empty($social)) {
                            foreach ($social as $soc) {
                                if ($soc['social_name'] == 'facebook') {
                                    $social_menu .= '<div class="header-icons_facebook">';
                                    $social_menu_mob .= '<div class="header-iconsmob_facebook">';
                                    $social_menu .= '<a href="' . $soc['social_link'] . '">';
                                    $social_menu_mob .= '<a href="' . $soc['social_link'] . '">';
                                    if (!empty($soc['social_img'])) {
                                        $social_menu .= '<img src="' . $soc['social_img'] . '" alt="' . $soc['social_name'] . '">';
                                        $social_menu_mob .= '<img src="' . $soc['social_img'] . '" alt="' . $soc['social_name'] . '">';
                                    } else {
                                        $social_menu .= '<img src="' . get_template_directory_uri() . '/inc/assets/img/icons/facebook.png" alt="' . $soc['social_name'] . '">';
                                        $social_menu_mob .= '<img src="' . get_template_directory_uri() . '/inc/assets/img/icons/facebook.png" alt="' . $soc['social_name'] . '">';
                                    }
                                    $social_menu .= '</a></div>';
                                    $social_menu_mob .= '</a></div>';
                                } elseif ($soc['social_name'] == 'instagram') {
                                    $social_menu .= '<div class="header-icons_insta">';
                                    $social_menu_mob .= '<div class="header-iconsmob_insta">';
                                    $social_menu .= '<a href="' . $soc['social_link'] . '">';
                                    $social_menu_mob .= '<a href="' . $soc['social_link'] . '">';
                                    if (!empty($soc['social_img'])) {
                                        $social_menu .= '<img src="' . $soc['social_img'] . '" alt="' . $soc['social_name'] . '">';
                                        $social_menu_mob .= '<img src="' . $soc['social_img'] . '" alt="' . $soc['social_name'] . '">';
                                    } else {
                                        $social_menu .= '<img src="' . get_template_directory_uri() . '/inc/assets/img/icons/instagram.png" alt="' . $soc['social_name'] . '">';
                                        $social_menu_mob .= '<img src="' . get_template_directory_uri() . '/inc/assets/img/icons/instagram.png" alt="' . $soc['social_name'] . '">';
                                    }
                                    $social_menu .= '</a></div>';
                                    $social_menu_mob .= '</a></div>';
                                } else {
                                    $social_menu .= '<div class="header-icons_social">';
                                    $social_menu_mob .= '<div class="header-iconsmob_social">';
                                    $social_menu .= '<a href="' . $soc['social_link'] . '">';
                                    $social_menu_mob .= '<a href="' . $soc['social_link'] . '">';
                                    if (!empty($soc['social_img'])) {
                                        $social_menu .= '<img src="' . $soc['social_img'] . '" alt="' . $soc['social_name'] . '">';
                                        $social_menu_mob .= '<img src="' . $soc['social_img'] . '" alt="' . $soc['social_name'] . '">';
                                    } else {
                                        $social_menu .= $soc['social_name'];
                                        $social_menu_mob .= $soc['social_name'];
                                    }
                                    $social_menu .= '</a></div>';
                                    $social_menu_mob .= '</a></div>';
                                }
                            }
                        }
        ?>

        <div id="page" class="wrapper">
            <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'philippines-incognita'); ?></a>
            <?php if (!is_page_template('blank-page.php') && !is_page_template('blank-page-with-container.php')): ?>
                <!--header-->
                <header class="header <?php echo Philippines_Incognita_bg_class(); ?>">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 im">
                                <div class="header-iconsmob">
                                    <?php echo $social_menu_mob;?>
                                    <?php if (false) { ?>
                                        <div class="header-iconsmob_language">
                                            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/icons/language.png" alt=""></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="header-logo">
                                    <a href="<?php echo esc_url(home_url('/')); ?>">
                                        <?php if (get_theme_mod('Philippines_Incognita_logo')): ?>

                                            <div class="header-logo_image">
                                                <img src="<?php echo esc_url(get_theme_mod('Philippines_Incognita_logo')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
                                            </div>
                                        <?php endif; ?>
                                        <div class="header-logo_text">
                                            <?php esc_url(bloginfo('name')); ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="header-heading">
                                    <div class="header-heading_title">
                                        <span><?php esc_url(bloginfo('description')); ?></span>
                                    </div>
                                    <?php
                                    $heading_subtitle = get_field('heading_subtitle', 'option');
                                    if (!empty($heading_subtitle)) {
                                        echo '<div class="header-heading_subtitle">' . $heading_subtitle . '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="header-icons">
                                    <?php echo $social_menu;?>
                                    <?php if (false) { ?>
                                        <div class="header-icons_language">
                                            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/icons/language.png" alt=""></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <!--header end-->
                <?php if (is_front_page() && !get_theme_mod('header_banner_visibility')): ?>
                    <div id="page-sub-header" <?php if (has_header_image()) { ?>style="background-image: url('<?php header_image(); ?>');" <?php } ?>>
                        <div class="container">
                            <h1>
                                <?php
                                if (get_theme_mod('header_banner_title_setting')) {
                                    echo esc_attr(get_theme_mod('header_banner_title_setting'));
                                } else {
                                    echo 'Philippines Incognita Inc.';
                                }
                                ?>
                            </h1>
                            <p>
                                <?php
                                if (get_theme_mod('header_banner_tagline_setting')) {
                                    echo esc_attr(get_theme_mod('header_banner_tagline_setting'));
                                } else {
                                    echo esc_html__('To customize the contents of this header banner and other elements of your site, go to Dashboard > Appearance > Customize', 'philippines-incognita');
                                }
                                ?>
                            </p>
                            <a href="#content" class="page-scroller"><i class="fa fa-fw fa-angle-down"></i></a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (is_front_page() && !is_home() && !is_archive()) { ?>
                    <div class="content">
                    <?php } else { ?>
                        <div id="content" class="site-content">
                            <div class="container">
                                <div class="row">
                                <?php } ?>
                            <?php endif; ?>