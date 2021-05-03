<?php
/**
 * Philippines Incognita Theme Customizer
 *
 * @package Philippines_Incognita
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function themeslug_sanitize_checkbox($checked) {
    // Boolean check.
    return ( ( isset($checked) && true == $checked ) ? true : false );
}

function Philippines_Incognita_customize_register($wp_customize) {

    //Style Preset
    $wp_customize->add_section(
            'typography',
            array(
                'title' => __('Preset Styles', 'philippines-incognita'),
                //'description' => __( 'This is a section for the typography', 'philippines-incognita' ),
                'priority' => 20,
            )
    );

    //Theme Option
    $wp_customize->add_setting('theme_option_setting', array(
        'default' => 'default',
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'theme_option_setting', array(
                'label' => __('Theme Option', 'philippines-incognita'),
                'section' => 'typography',
                'settings' => 'theme_option_setting',
                'type' => 'select',
                'choices' => array(
                    'default' => 'Default',
                    'cerulean' => 'Cerulean',
                    'cosmo' => 'Cosmo',
                    'cyborg' => 'Cyborg',
                    'darkly' => 'Darkly',
                    'flatly' => 'Flatly',
                    'journal' => 'Journal',
                    'litera' => 'Litera',
                    'lumen' => 'Lumen',
                    'lux' => 'Lux',
                    'materia' => 'Materia',
                    'minty' => 'Minty',
                    'pulse' => 'Pulse',
                    'sandstone' => 'Sandstone',
                    'simplex' => 'Simplex',
                    'sketchy' => 'Sketchy',
                    'slate' => 'Slate',
                    'solar' => 'Solar',
                    'spacelab' => 'Spacelab',
                    'superhero' => 'Superhero',
                    'united' => 'United',
                    'yeti' => 'Yeti',
                    'philippines-incognita' => 'Philippines Incognita',
                )
    )));

    $wp_customize->add_setting('preset_style_setting', array(
        'default' => 'default',
        'type' => 'theme_mod',
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'preset_style_setting', array(
                'label' => __('Typography', 'philippines-incognita'),
                'section' => 'typography',
                'settings' => 'preset_style_setting',
                'type' => 'select',
                'choices' => array(
                    'default' => 'Default',
                    'arbutusslab-opensans' => 'Arbutus Slab / Opensans',
                    'montserrat-merriweather' => 'Montserrat / Merriweather',
                    'montserrat-opensans' => 'Montserrat / Opensans',
                    'oswald-muli' => 'Oswald / Muli',
                    'poppins-lora' => 'Poppins / Lora',
                    'poppins-poppins' => 'Poppins / Poppins',
                    'roboto-roboto' => 'Roboto / Roboto',
                    'robotoslab-roboto' => 'Roboto Slab / Roboto',
                    'dm-sans-dm-serif-display' => 'DM Sans / DM Serif Display',
                    'opensans-acrom-gothampro' => 'Open Sans / Acrom / GothamPro',
                )
    )));


    /* Banner */
    $wp_customize->add_section(
            'header_image',
            array(
                'title' => __('Header Banner', 'philippines-incognita'),
                'priority' => 30,
            )
    );


    $wp_customize->add_control(
            'header_img',
            array(
                'label' => __('Header Image', 'philippines-incognita'),
                'section' => 'header_images',
                'type' => 'text',
            )
    );

    $wp_customize->add_setting(
            'header_bg_color_setting',
            array(
                'default' => '#fff',
                'sanitize_callback' => 'sanitize_hex_color',
            )
    );
    $wp_customize->add_control(
            new WP_Customize_Color_Control(
                    $wp_customize,
                    'header_bg_color',
                    array(
                'label' => __('Header Banner Background Color', 'philippines-incognita'),
                'section' => 'header_image',
                'settings' => 'header_bg_color_setting',
                    ))
    );

    $wp_customize->add_setting('header_banner_title_setting', array(
        'default' => __('Welcome to Philippines Incognita Theme!', 'philippines-incognita'),
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'header_banner_title_setting', array(
                'label' => __('Banner Title', 'philippines-incognita'),
                'section' => 'header_image',
                'settings' => 'header_banner_title_setting',
                'type' => 'text'
    )));

    $wp_customize->add_setting('header_banner_tagline_setting', array(
        'default' => __('To customize the contents of this header banner and other elements of your site go to Dashboard - Appearance - Customize', 'philippines-incognita'),
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'header_banner_tagline_setting', array(
                'label' => __('Banner Tagline', 'philippines-incognita'),
                'section' => 'header_image',
                'settings' => 'header_banner_tagline_setting',
                'type' => 'text'
    )));
    $wp_customize->add_setting('header_banner_visibility', array(
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'themeslug_sanitize_checkbox',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'header_banner_visibility', array(
                'settings' => 'header_banner_visibility',
                'label' => __('Remove Header Banner', 'philippines-incognita'),
                'section' => 'header_image',
                'type' => 'checkbox',
    )));


    //Site Name Text Color
    $wp_customize->add_section(
            'site_name_text_color',
            array(
                'title' => __('Other Customizations', 'philippines-incognita'),
                //'description' => __( 'This is a section for the header banner Image.', 'philippines-incognita' ),
                'priority' => 40,
            )
    );
    $wp_customize->add_section(
            'colors',
            array(
                'title' => __('Background Color', 'philippines-incognita'),
                //'description' => __( 'This is a section for the header banner Image.', 'philippines-incognita' ),
                'priority' => 50,
                'panel' => 'styling_option_panel',
            )
    );
    $wp_customize->add_section(
            'background_image',
            array(
                'title' => __('Background Image', 'philippines-incognita'),
                //'description' => __( 'This is a section for the header banner Image.', 'philippines-incognita' ),
                'priority' => 60,
                'panel' => 'styling_option_panel',
            )
    );

    // Bootstrap and Fontawesome Option
    $wp_customize->add_setting('cdn_assets_setting', array(
        'default' => __('no', 'philippines-incognita'),
        'sanitize_callback' => 'wp_filter_nohtml_kses',
    ));
    $wp_customize->add_control(
            'cdn_assets',
            array(
                'label' => __('Use CDN for Assets', 'philippines-incognita'),
                'description' => __('All Bootstrap Assets and FontAwesome will be loaded in CDN.', 'philippines-incognita'),
                'section' => 'site_name_text_color',
                'settings' => 'cdn_assets_setting',
                'type' => 'select',
                'choices' => array(
                    'yes' => __('Yes', 'philippines-incognita'),
                    'no' => __('No', 'philippines-incognita'),
                )
            )
    );


    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'refresh';
    $wp_customize->get_control('header_textcolor')->section = 'site_name_text_color';
    $wp_customize->get_control('background_image')->section = 'site_name_text_color';
    $wp_customize->get_control('background_color')->section = 'site_name_text_color';

    // Add control for logo uploader
    $wp_customize->add_setting('Philippines_Incognita_logo', array(
        //'default' => __( '', 'philippines-incognita' ),
        'sanitize_callback' => 'esc_url',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'Philippines_Incognita_logo', array(
                'label' => __('Upload Logo (replaces text)', 'philippines-incognita'),
                'section' => 'title_tagline',
                'settings' => 'Philippines_Incognita_logo',
    )));
}

add_action('customize_register', 'Philippines_Incognita_customize_register');

add_action('wp_head', 'Philippines_Incognita_customizer_css');

function Philippines_Incognita_customizer_css() {
    $header_bg_color = get_theme_mod('header_bg_color_setting', '#fff');
    ?>
    <style type="text/css">
        #page-sub-header { background: <?php echo esc_attr($header_bg_color); ?>; }
    </style>
    <?php
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function Philippines_Incognita_customize_preview_js() {
    wp_enqueue_script('Philippines_Incognita_customizer', get_template_directory_uri() . '/inc/assets/js/customizer.js', array('customize-preview'), '20201013', true);
}

add_action('customize_preview_init', 'Philippines_Incognita_customize_preview_js');
