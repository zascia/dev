<?php

/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Philippines_Incognita
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function Philippines_Incognita_body_classes($classes) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if (is_multi_author()) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }

    if (get_theme_mod('theme_option_setting') && get_theme_mod('theme_option_setting') !== 'default') {
        $classes[] = 'theme-preset-active';
    }

    return $classes;
}

add_filter('body_class', 'Philippines_Incognita_body_classes');

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function Philippines_Incognita_pingback_header() {
    echo '<link rel="pingback" href="', esc_url(get_bloginfo('pingback_url')), '">';
}

add_action('wp_head', 'Philippines_Incognita_pingback_header');

/**
 * Return the header class
 */
function Philippines_Incognita_bg_class() {
    switch (get_theme_mod('theme_option_setting')) {
        case "cerulean":
            return 'navbar-dark bg-primary';
            break;
        case "cosmo":
            return 'navbar-dark bg-primary';
            break;
        case "cyborg":
            return 'navbar-dark bg-dark';
            break;
        case "darkly":
            return 'navbar-dark bg-primary';
            break;
        case "flatly":
            return 'navbar-dark bg-primary';
            break;
        case "journal":
            return 'navbar-light bg-light';
            break;
        case "litera":
            return 'navbar-light bg-light';
            break;
        case "lumen":
            return 'navbar-light bg-light';
            break;
        case "lux":
            return 'navbar-light bg-light';
            break;
        case "materia":
            return 'navbar-dark bg-primary';
            break;
        case "minty":
            return 'navbar-dark bg-primary';
            break;
        case "pulse":
            return 'navbar-dark bg-primary';
            break;
        case "sandstone":
            return 'navbar-dark bg-primary';
            break;
        case "simplex":
            return 'navbar-light bg-light';
            break;
        case "sketchy":
            return 'navbar-light bg-light';
            break;
        case "slate":
            return 'navbar-dark bg-primary';
            break;
        case "solar":
            return 'navbar-dark bg-dark';
            break;
        case "spacelab":
            return 'navbar-light bg-light';
            break;
        case "superhero":
            return 'navbar-dark bg-dark';
            break;
        case "united":
            return 'navbar-dark bg-primary';
            break;
        case "yeti":
            return 'navbar-dark bg-primary';
            break;
        case "philippines-incognita":
            return '';
            break;
        default:
            return 'navbar-light';
    }
}

function is_theme_preset_active() {
    if (get_theme_mod('theme_option_setting') && get_theme_mod('theme_option_setting') !== 'default') {
        return true;
    }
}

function getPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Remove issues with prefetching adding extra views
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Add to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views', 5, 2);

function posts_column_views($defaults) {
    $defaults['post_views'] = __('Views');
    return $defaults;
}

function posts_custom_column_views($column_name, $id) {
    if ($column_name === 'post_views') {
        echo getPostViews(get_the_ID());
    }
}

// custom excerpt length
function philippines_incognita_excerpt_length($length) {
    return 15;
}

add_filter('excerpt_length', 'philippines_incognita_excerpt_length');

// add more link to excerpt
function philippines_incognita_excerpt_more($more) {
    global $post;
    return '...';
}

add_filter('excerpt_more', 'philippines_incognita_excerpt_more');

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Настройки Сайта',
        'menu_title' => 'Philippines Incognita',
        'menu_slug' => 'philippines-incognita-general-settings',
        'icon_url' => 'dashicons-code-standards',
        'position' => 3.6,
        'redirect' => false
    ));


//    acf_add_options_sub_page(array(
//        'page_title' => 'Настройки Рекламы',
//        'menu_title' => 'Реклама',
//        'parent_slug' => 'philippines-incognita-general-settings',
//        'menu_slug' => 'reklama-general-settings',
////        'icon_url' => 'dashicons-smiley',
////        'position' => 3.6,
////        'redirect' => false,
//    ));
}

function philippines_incognita_get_sub_title() {
    global $post;
    $sub_title = get_field('sub_title', $post->ID);
    if (!empty($sub_title)) {
        return '<div class="greeting-left_subtitle">' . $sub_title . '</div>';
    }
}

if (!function_exists('register_news')) :

    function register_news() {
        $labels = array(
            'name' => 'Обзоры от блоггеров',
            'singular_name' => 'Новость',
            'add_new' => 'Добавить новую',
            'add_new_item' => 'Редактировать запись',
            'edit_item' => 'Редактировать запись',
            'new_item' => 'Новая запись',
            'all_items' => 'Все записи',
            'view_item' => 'Посмотреть запись',
            'search_items' => 'Поиск записи',
            'not_found' => 'Не найдено не одной записи',
            'not_found_in_trash' => 'В корзине нет записей',
            'menu_name' => 'Обзоры от блоггеров'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => true,
//            'rewrite' => array('slug' => 'news', 'with_front' => true),
//            'rewrite' => array('slug' => '/', 'with_front' => false),
            'hierarchical' => false,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
            'menu_icon' => 'dashicons-admin-site',
            'menu_position' => 5,
            'taxonomies' => array('news_category')
        );

        register_post_type('news', $args);
    }

endif;

add_action('init', 'register_news');

function custom_tax_news_category() {
    register_taxonomy(
            'news_category',
            'news',
            array(
                'labels' => array(
                    'name' => 'Категории новостей',
                    'singular_name' => 'Категория новостей',
                    'search_items' => 'Категории поиска',
                    'all_items' => 'Все категории',
                    'edit_item' => 'Изменить категорию',
                    'update_item' => 'Обновить категорию',
                    'add_new_item' => 'Добавить новую категорию',
                    'new_item_name' => 'Название новой категории',
                    'menu_name' => 'Категории новостей',
                ),
                'rewrite' => array('slug' => 'news-category'),
                'hierarchical' => true,
                'show_ui' => true,
                'show_admin_column' => true,
            )
    );
}

add_action('init', 'custom_tax_news_category');

function news_remove_slug($post_link, $post, $leavename) {

    if ('news' != $post->post_type || 'publish' != $post->post_status) {
        return $post_link;
    }

    $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);

    return $post_link;
}

add_filter('post_type_link', 'news_remove_slug', 10, 3);

function pi_parse_request($query) {

    if (!$query->is_main_query() || 2 != count($query->query) || !isset($query->query['page'])) {
        return;
    }

    if (!empty($query->query['name'])) {
        $query->set('post_type', array('post', 'news', 'page'));
    }
}

add_action('pre_get_posts', 'pi_parse_request');

add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif (is_tax()) { //for custom post types
        $title = sprintf(__('%1$s'), single_term_title('', false));
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }
    return $title;
});
if (!function_exists('print_a')) {

    function print_a($expression) {
        if (!empty($expression)) {
            echo '<pre>';
            print_r($expression);
            echo '</pre>';
        } else {
            echo 'empty value';
        }
    }

}

add_filter( 'pre_comment_content', 'wp_specialchars' );