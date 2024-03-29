<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Philippines_Incognita
 */
get_header();
?>

<section id="primary" class="content-area col-sm-12 col-md-12 <?php echo ( is_active_sidebar('sidebar-1') ) ? 'col-lg-8' : 'col-lg-12'; ?> news">
    <div id="main" class="site-main news-items" role="main">

        <?php
        if (have_posts()) :

            if (is_home() && !is_front_page()) :
                ?>
                <div class="news-items_lastnews">
                    <div class="news-items_lastnews_image">
                        <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/last.png" alt="">
                    </div>
                    <div class="news-items_lastnews_text">Архив новостей</div>
                </div>
                <?php
            endif;

            /* Start the Loop */
            while (have_posts()) : the_post();

                /*
                 * Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                get_template_part('template-parts/content', get_post_format());

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
