<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Philippines_Incognita
 */
get_header();
?>
<section id="primary" class="content-area col-sm-12 col-lg-8">
    <div id="main" class="site-main news-items" role="main">
        <?php if (have_posts()) : ?>
            <div class="news-items_lastnews">
                <div class="news-items_lastnews_image">
                    <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/last.png" alt="">
                </div>
                <div class="news-items_lastnews_text"><?php printf(esc_html__('Результаты поиска для: %s', 'philippines-incognita'), '<span>' . get_search_query() . '</span>'); ?></div>
            </div>
            <?php
            /* Start the Loop */
            while (have_posts()) : the_post();
                /**
                 * Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called content-search.php and that will be used instead.
                 */
                get_template_part('template-parts/content', 'search');
            endwhile;
            the_posts_navigation();
        else :
            get_template_part('template-parts/content', 'none');
        endif;
        ?>
    </div><!-- #main -->
</section><!-- #primary -->
<?php
get_sidebar();
get_footer();
