<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Philippines_Incognita
 */
if ('post' === get_post_type() || 'news' === get_post_type()) {
    ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('row bord'); ?>>
        <?php if (has_post_thumbnail()) { ?>                    
            <div class="col-md-5">
                <div class="news-items_item">
                    <div class="news-items_item_image">
                        <?php the_post_thumbnail(); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="<?php echo (has_post_thumbnail()) ? 'col-md-7' : 'col-md-12'; ?>">
            <?php the_title('<div class="news-items_item_title">', '</div>'); ?>
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
<?php } else { ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>

            <?php if ('post' === get_post_type()) : ?>
                <div class="entry-meta">
                    <?php Philippines_Incognita_posted_on(); ?>
                </div><!-- .entry-meta -->
            <?php endif; ?>
        </header><!-- .entry-header -->

        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->

        <footer class="entry-footer">
            <?php Philippines_Incognita_entry_footer(); ?>
        </footer><!-- .entry-footer -->
    </article><!-- #post-## -->
<?php } ?>
