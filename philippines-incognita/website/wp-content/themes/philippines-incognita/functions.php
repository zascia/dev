<?php

/**
 * Philippines Incognita functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Philippines_Incognita
 */
if (!function_exists('Philippines_Incognita_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function Philippines_Incognita_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Philippines Incognita, use a find and replace
         * to change 'philippines-incognita' to the name of your theme in all the template files.
         */
        load_theme_textdomain('philippines-incognita', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'philippines-incognita'),
            'social' => esc_html__('Social', 'philippines-incognita'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'comment-form',
            'comment-list',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('Philippines_Incognita_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        function philippines_incognita_add_editor_styles() {
            add_editor_style('custom-editor-style.css');
        }

        add_action('admin_init', 'philippines_incognita_add_editor_styles');
    }

endif;
add_action('after_setup_theme', 'Philippines_Incognita_setup');

/**
 * Add Welcome message to dashboard
 */
function Philippines_Incognita_reminder() {
    $theme_page_url = 'https://philippines-incognita.com/';

    if (!get_option('triggered_welcomet')) {
        $message = sprintf(__('Welcome to Philippines Incognita Theme! Before diving in to your new theme, please visit the <a style="color: #fff; font-weight: bold;" href="%1$s" target="_blank">theme\'s</a> page for access to dozens of tips and in-depth tutorials.', 'philippines-incognita'),
                esc_url($theme_page_url)
        );

        printf(
                '<div class="notice is-dismissible" style="background-color: #1e1e1e; color: #fff; border-left: none;">
                        <p>%1$s</p>
                    </div>',
                $message
        );
        add_option('triggered_welcomet', '1', '', 'yes');
    }
}

add_action('admin_notices', 'Philippines_Incognita_reminder');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function Philippines_Incognita_content_width() {
    $GLOBALS['content_width'] = apply_filters('Philippines_Incognita_content_width', 1170);
}

add_action('after_setup_theme', 'Philippines_Incognita_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function Philippines_Incognita_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Sidebar', 'philippines-incognita'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'philippines-incognita'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Sidebar bootom', 'philippines-incognita'),
        'id' => 'sidebar-2',
        'description' => esc_html__('Add widgets here.', 'philippines-incognita'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Sidebar weather', 'philippines-incognita'),
        'id' => 'sidebar-weather',
        'description' => esc_html__('Add widgets here.', 'philippines-incognita'),
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 1', 'philippines-incognita'),
        'id' => 'footer-1',
        'description' => esc_html__('Add widgets here.', 'philippines-incognita'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 2', 'philippines-incognita'),
        'id' => 'footer-2',
        'description' => esc_html__('Add widgets here.', 'philippines-incognita'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 3', 'philippines-incognita'),
        'id' => 'footer-3',
        'description' => esc_html__('Add widgets here.', 'philippines-incognita'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 4', 'philippines-incognita'),
        'id' => 'footer-4',
        'description' => esc_html__('Add widgets here.', 'philippines-incognita'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'Philippines_Incognita_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function Philippines_Incognita_scripts() {
    // load bootstrap css
    if (get_theme_mod('cdn_assets_setting') === 'yes') {
        wp_enqueue_style('philippines-incognita-bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css');
        wp_enqueue_style('philippines-incognita-fontawesome-cdn', 'https://use.fontawesome.com/releases/v5.15.1/css/all.css');
    } else {
        wp_enqueue_style('philippines-incognita-bootstrap-css', get_template_directory_uri() . '/inc/assets/css/bootstrap.min.css');
        wp_enqueue_style('philippines-incognita-fontawesome-cdn', get_template_directory_uri() . '/inc/assets/css/fontawesome.min.css');
    }

    //wp_enqueue_style('philippines-incognita-carousel-css', get_template_directory_uri() . '/inc/assets/libs/owlcarousel/assets/owl.carousel.min.css');
    //wp_enqueue_style('philippines-incognita-owl-theme-css', get_template_directory_uri() . '/inc/assets/libs/owlcarousel/assets/owl.theme.default.min.css');
    // load bootstrap css
    // load Philippines Incognita styles
    wp_enqueue_style('philippines-incognita-style', get_stylesheet_uri());
    if (get_theme_mod('theme_option_setting') && get_theme_mod('theme_option_setting') !== 'default') {
        wp_enqueue_style('philippines-incognita-' . get_theme_mod('theme_option_setting'), get_template_directory_uri() . '/inc/assets/css/presets/theme-option/' . get_theme_mod('theme_option_setting') . '.css', false, '');
    }
    if (get_theme_mod('preset_style_setting') === 'poppins-lora') {
        wp_enqueue_style('philippines-incognita-poppins-lora-font', 'https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i|Poppins:300,400,500,600,700');
    }
    if (get_theme_mod('preset_style_setting') === 'montserrat-merriweather') {
        wp_enqueue_style('philippines-incognita-montserrat-merriweather-font', 'https://fonts.googleapis.com/css?family=Merriweather:300,400,400i,700,900|Montserrat:300,400,400i,500,700,800');
    }
    if (get_theme_mod('preset_style_setting') === 'poppins-poppins') {
        wp_enqueue_style('philippines-incognita-poppins-font', 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700');
    }
    if (get_theme_mod('preset_style_setting') === 'roboto-roboto') {
        wp_enqueue_style('philippines-incognita-roboto-font', 'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i');
    }
    if (get_theme_mod('preset_style_setting') === 'arbutusslab-opensans') {
        wp_enqueue_style('philippines-incognita-arbutusslab-opensans-font', 'https://fonts.googleapis.com/css?family=Arbutus+Slab|Open+Sans:300,300i,400,400i,600,600i,700,800');
    }
    if (get_theme_mod('preset_style_setting') === 'oswald-muli') {
        wp_enqueue_style('philippines-incognita-oswald-muli-font', 'https://fonts.googleapis.com/css?family=Muli:300,400,600,700,800|Oswald:300,400,500,600,700');
    }
    if (get_theme_mod('preset_style_setting') === 'montserrat-opensans') {
        wp_enqueue_style('philippines-incognita-montserrat-opensans-font', 'https://fonts.googleapis.com/css?family=Montserrat|Open+Sans:300,300i,400,400i,600,600i,700,800');
    }
    if (get_theme_mod('preset_style_setting') === 'robotoslab-roboto') {
        wp_enqueue_style('philippines-incognita-robotoslab-roboto', 'https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Roboto:300,300i,400,400i,500,700,700i');
    }
    if (get_theme_mod('preset_style_setting') === 'dm-sans-dm-serif-display') {
        wp_enqueue_style('philippines-incognita-dm-sans-dm-serif-display', 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&family=DM+Serif+Display:ital@0;1&display=swap');
    }
    if (get_theme_mod('preset_style_setting') === 'opensans-acrom-gothampro') {
        wp_enqueue_style('philippines-incognita-opensans-display', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap');
        wp_enqueue_style('philippines-incognita-acrom-display', get_template_directory_uri() . '/inc/assets/css/presets/typography/acrom.css', false, '');
        wp_enqueue_style('philippines-incognita-gothampro-display', get_template_directory_uri() . '/inc/assets/css/presets/typography/gothampro.css', false, '');
    }
    if (get_theme_mod('preset_style_setting') && get_theme_mod('preset_style_setting') !== 'default') {
        wp_enqueue_style('philippines-incognita-' . get_theme_mod('preset_style_setting'), get_template_directory_uri() . '/inc/assets/css/presets/typography/' . get_theme_mod('preset_style_setting') . '.css', false, '');
    }
    //Color Scheme
    /* if(get_theme_mod( 'preset_color_scheme_setting' ) && get_theme_mod( 'preset_color_scheme_setting' ) !== 'default') {
      wp_enqueue_style( 'philippines-incognita-'.get_theme_mod( 'preset_color_scheme_setting' ), get_template_directory_uri() . '/inc/assets/css/presets/color-scheme/'.get_theme_mod( 'preset_color_scheme_setting' ).'.css', false, '' );
      }else {
      wp_enqueue_style( 'philippines-incognita-default', get_template_directory_uri() . '/inc/assets/css/presets/color-scheme/blue.css', false, '' );
      } */

    wp_enqueue_script('jquery');

    // Internet Explorer HTML5 support
    wp_enqueue_script('html5hiv', get_template_directory_uri() . '/inc/assets/js/html5.js', array(), '3.7.0', false);
    wp_script_add_data('html5hiv', 'conditional', 'lt IE 9');

    // load bootstrap js
    if (get_theme_mod('cdn_assets_setting') === 'yes') {
        wp_enqueue_script('philippines-incognita-popper', 'https://cdn.jsdelivr.net/npm/popper.js@1/dist/umd/popper.min.js', array(), '', true);
        wp_enqueue_script('philippines-incognita-bootstrapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js', array(), '', true);
    } else {
        wp_enqueue_script('philippines-incognita-popper', get_template_directory_uri() . '/inc/assets/js/popper.min.js', array(), '', true);
        wp_enqueue_script('philippines-incognita-bootstrapjs', get_template_directory_uri() . '/inc/assets/js/bootstrap.min.js', array(), '', true);
    }
    //wp_enqueue_script('philippines-incognita-owlcarousel-js', get_template_directory_uri() . '/inc/assets/libs/owlcarousel/owl.carousel.min.js', array(), '', true);
    wp_enqueue_script('philippines-incognita-wow-js', get_template_directory_uri() . '/inc/assets/js/wow.min.js', array(), '', true);
    wp_enqueue_script('philippines-incognita-themejs', get_template_directory_uri() . '/inc/assets/js/theme-script.js', array(), '', true);
    wp_enqueue_script('philippines-incognita-skip-link-focus-fix', get_template_directory_uri() . '/inc/assets/js/skip-link-focus-fix.min.js', array(), '20151215', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'Philippines_Incognita_scripts');

/**
 * Add Preload for CDN scripts and stylesheet
 */
function Philippines_Incognita_preload($hints, $relation_type) {
    if ('preconnect' === $relation_type && get_theme_mod('cdn_assets_setting') === 'yes') {
        $hints[] = [
            'href' => 'https://cdn.jsdelivr.net/',
            'crossorigin' => 'anonymous',
        ];
        $hints[] = [
            'href' => 'https://use.fontawesome.com/',
            'crossorigin' => 'anonymous',
        ];
    }
    return $hints;
}

add_filter('wp_resource_hints', 'Philippines_Incognita_preload', 10, 2);

function Philippines_Incognita_password_form() {
    global $post;
    $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
    $o = '<form action="' . esc_url(home_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">
    <div class="d-block mb-3">' . __("To view this protected post, enter the password below:", "philippines-incognita") . '</div>
    <div class="form-group form-inline"><label for="' . $label . '" class="mr-2">' . __("Password:", "philippines-incognita") . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" class="form-control mr-2" /> <input type="submit" name="Submit" value="' . esc_attr__("Submit", "philippines-incognita") . '" class="btn btn-primary"/></div>
    </form>';
    return $o;
}

add_filter('the_password_form', 'Philippines_Incognita_password_form');


// comment fields
//remove not necessary comment fields
function remove_comment_fields($fields) {
    unset($fields['url']); // Удаляем URL
    unset($fields['email']); // Удаляем E-mail
    return $fields;
}
add_filter('comment_form_default_fields', 'remove_comment_fields');

// remove "your email will not be visible"
function my_comments_form($default) {
     $default['comment_notes_before'] = '';
     return $default;
}
add_filter('comment_form_defaults','my_comments_form',999);
// eo comment fields


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load plugin compatibility file.
 */
require get_template_directory() . '/inc/plugin-compatibility/plugin-compatibility.php';

/**
 * Load custom WordPress nav walker.
 */
if (!class_exists('wp_bootstrap_navwalker')) {
    require_once(get_template_directory() . '/inc/wp_bootstrap_navwalker.php');
}