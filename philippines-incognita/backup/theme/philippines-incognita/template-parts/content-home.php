<?php
/**
 * Template part for displaying page content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Philippines_Incognita
 */
$ads_code_for_recommended = get_field('ads_code_for_recommended');
$ads_code_for_news = get_field('ads_code_for_news');
$number_ads_in_recommended = get_field('number_ads_in_recommended');
$number_ads_in_news = get_field('number_ads_in_news');
$greeting = get_field('greeting');
if (!empty($greeting)) {
    $bg_weather = (!empty($greeting['bg_weather'])) ? $greeting['bg_weather'] : get_template_directory_uri() . '/inc/assets/img/bg/bg.png';
    ?>
    <section class="bg" style="background-image: url(<?php echo $bg_weather; ?>);">
        <div class="container">
            <div class="row justify-content-end">
                <?php if (is_active_sidebar('sidebar-weather')) { ?>
                    <div class="col-md-5">
                        <div class="bg-weather">
                            <div class="bg-weather_city">
                                Манила
                            </div>
                            <?php dynamic_sidebar('sidebar-weather'); ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="col-md-5">
                        <div class="bg-weather">
                            <div class="bg-weather_city">
                                Манила
                            </div>
                            <div class="bg-weather_icon">
                                <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/icons/weat.png" alt="">
                            </div>
                            <div class="bg-weather_value">
                                25
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <section class="greeting">
        <div class="container">
            <div class="row greeting-neset">
                <div class="<?php echo (!empty($greeting)) ? 'col-md-7 col-lg-8' : 'col-md-12 col-lg-12'; ?>">
                    <div class="greeting-left">
                        <div class="greeting-left_title">
                            <?php the_title(); ?>
                        </div>
                        <?php echo philippines_incognita_get_sub_title(); ?>
                        <div class="greeting-left_text">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
                <?php if (!empty($greeting)) { ?>
                    <div class="col-md-5 col-lg-4">
                        <div class="greeting-right">
                            <?php
                            if (!empty($greeting['img'])) {
                                echo '<div class="greeting-right_image"><img src="' . $greeting['img'] . '"></div>';
                            }
                            if (!empty($greeting['title'])) {
                                echo '<div class="greeting-right_title">' . $greeting['title'] . '</div>';
                            }
                            if (!empty($greeting['subtitle'])) {
                                echo '<div class="greeting-right_subtitle">' . $greeting['subtitle'] . '</div>';
                            }
                            if (!empty($greeting['about'])) {
                                echo '<div class="greeting-right_about">' . $greeting['about'] . '</div>';
                            }
                            if (!empty($greeting['text'])) {
                                echo '<div class="greeting-right_line"></div>';
                                echo '<div class="greeting-right_line1"></div>';
                                echo '<div class="greeting-right_line2"></div>';
                                echo '<div class="greeting-right_text">' . $greeting['text'] . '</div>';
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <?php
}
$count_last_posts = get_field('count_last_posts');
$count_last_posts = (!empty($count_last_posts))?$count_last_posts:4;
if (!empty($count_last_posts) && $count_last_posts > 0) {
    ?>
    <section class="listing">
        <div class="container">
            <div class="listing-items owl-carousel">
                <?php
                $args = array(
                    'posts_per_page' => $count_last_posts,
                );

                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        get_template_part('template-parts/listing', 'item');
                    }
                } else {
                    get_template_part('template-parts/content', 'none');
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
    <?php
}
$title_recommended = get_field('title_recommended');
$recommended_entries = get_field('recommended_entries');
if (!empty($recommended_entries) && count($recommended_entries) > 0) {
    ?>
    <section class="news">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="news-items">
                        <?php if (!empty($title_recommended)) { ?>
                            <div class="news-items_lastnews">
                                <div class="news-items_lastnews_image">
                                    <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/last.png" alt="">
                                </div>
                                <div class="news-items_lastnews_text"><?php echo $title_recommended; ?></div>
                            </div>
                            <?php
                        }
                        $args = array(
                            'post__in' => $recommended_entries
                        );

                        $query = new WP_Query($args);

                        if ($query->have_posts()) {
                            $i = 0;
                            while ($query->have_posts()) {
                                $query->the_post();
                                get_template_part('template-parts/content', get_post_format());
                                if (!empty($ads_code_for_recommended)) {
                                    $i++;
                                    if ($i == $number_ads_in_recommended - 1) {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $ads_code_for_recommended; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                        } else {
                            get_template_part('template-parts/content', 'none');
                        }
                        wp_reset_postdata();
                        ?>
                        <div class="news-items_moreb">
                            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">Архив статей</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
$top_sategories = get_field('top_sategories');
if (!empty($top_sategories)) {
    ?>
    <section class="tile">
        <div class="container">
            <div class="row">
                <?php
                foreach ($top_sategories as $term_id) {
                    $bg_category = '';
                    $img_cat = get_field('img_cat', 'category_' . $term_id);
                    if (!empty($img_cat)) {
                        $bg_category = 'style="background-image:url(' . $img_cat . ');"';
                    }
                    $term = get_term($term_id, 'category');
                    ?>
                    <div class="col-md-4">
                        <a href="<?php echo get_category_link($term_id);?>" class="tile-item">
                            <div class="tile-item_cont">
                                <div class="tile-item_image" <?php echo $bg_category; ?>><img src="" alt=""></div>
                                <div class="tile-item_title">
                                    <div class="tile-item_title_txt"><?php echo $term->name; ?></div>
                                </div>
                                <div class="tile-item_subtitle"><?php echo $term->description; ?></div>
                                <div class="tile-item_imagebottom"><img src="" alt=""></div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
<section class="news">
    <div class="container">
        <div class="row">
            <div class="<?php echo ( is_active_sidebar('sidebar-1') ) ? 'col-md-8' : 'col-md-12'; ?>">
                <div class="news-items">
                    <div class="news-items_lastnews">
                        <div class="news-items_lastnews_image">
                            <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/last.png" alt="">
                        </div>
                        <div class="news-items_lastnews_text">
                            Последние новости
                        </div>
                    </div>
                    <?php
                    $args = array(
                        'posts_per_page' => 4,
                        'post_type' => 'news'
                    );

                    $query = new WP_Query($args);

                    if ($query->have_posts()) {
                        $i = 0;
                        while ($query->have_posts()) {
                            $query->the_post();
                            get_template_part('template-parts/content', get_post_format());
                            if (!empty($ads_code_for_news)) {
                                $i++;
                                if ($i == $number_ads_in_news - 1) {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php echo $ads_code_for_news; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                    } else {
                        get_template_part('template-parts/content', 'none');
                    }
                    wp_reset_postdata();
                    ?>
                    <div class="news-items_moreb">
                        <a href="/news">Архив новостей</a>
                    </div>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>
