<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Philippines_Incognita
 */
if (is_single()) {
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="post-thumbnail">
            <?php the_post_thumbnail(); ?>
        </div>
        <header class="entry-header">
            <?php
            if (is_single()) :
                the_title('<h1 class="entry-title">', '</h1>');
            else :
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif;
            echo philippines_incognita_get_sub_title();
            ?>
            <div class="news-items_item_icons publush_date_time_row">
                <div class="news-items_item_icons_icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/user.svg" alt="">
                    <span><?php echo get_the_author(); ?></span>
                </div>
                <div class="news-items_item_icons_icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/clock.svg" alt="">
                    <span><?php echo human_time_diff(get_post_time('U'), current_time('timestamp')) . ' ' . __('назад', 'worpress'); ?></span>
                </div>
                <div class="news-items_item_icons_icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/chat.svg" alt="">
                    <span><?php echo get_comments_number(); ?></span>
                </div>
                <div class="news-items_item_icons_icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/fire.svg" alt="">
                    <span><?php echo getPostViews(get_the_ID()); ?></span>
                </div>
            </div>
        </header><!-- .entry-header -->
        <div class="entry-content">
            <?php
            if (is_single()) :
                the_content();
            else :
                the_content(__('Continue reading <span class="meta-nav">&rarr;</span>', 'philippines-incognita'));
            endif;

            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'philippines-incognita'),
                'after' => '</div>',
            ));
            ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
            <?php Philippines_Incognita_entry_footer(); ?>
        </footer><!-- .entry-footer -->
    </article><!-- #post-## -->
<?php } else { ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('row bord'); ?>>
        <?php if (has_post_thumbnail()) { ?>                    
            <div class="col-md-5">
                <div class="news-items_item">
                    <div class="news-items_item_image">
                        <a href="<?php echo esc_url(get_permalink()); ?>"><?php the_post_thumbnail(); ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="<?php echo (has_post_thumbnail()) ? 'col-md-7' : 'col-md-12'; ?>">
            <div class="news-items_item_title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></div>
            <div class="news-items_item_subtitle">
                <?php the_excerpt(); ?>
            </div>
            <div class="news-items_item_more">
                <a href="<?php echo esc_url(get_permalink()); ?>">Читать полностью</a>
            </div>
            <div class="news-items_item_icons">
                <div class="news-items_item_icons_icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/user.svg" alt="">
                    <span><?php echo get_the_author(); ?></span>
                </div>
                <div class="news-items_item_icons_icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/clock.svg" alt="">
                    <span><?php echo human_time_diff(get_post_time('U'), current_time('timestamp')) . ' ' . __('назад', 'worpress'); ?></span>
                </div>
                <div class="news-items_item_icons_icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/chat.svg" alt="">
                    <span><?php echo get_comments_number(); ?></span>
                </div>
                <div class="news-items_item_icons_icon">
                    <img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/news/fire.svg" alt="">
                    <span><?php echo getPostViews(get_the_ID()); ?></span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
