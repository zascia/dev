<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Philippines_Incognita
 */
if (!function_exists('Philippines_Incognita_posted_on')) :

    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function Philippines_Incognita_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
        }

        $time_string = sprintf($time_string,
                esc_attr(get_the_date('c')),
                esc_html(get_the_date())
        );

        $posted_on = sprintf(
                esc_html_x('Posted on %s', 'post date', 'philippines-incognita'),
                '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        $byline = sprintf(
                esc_html_x('by %s', 'post author', 'philippines-incognita'),
                '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        echo '<span class="posted-on">' . $posted_on . '</span> | <span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

        if (!is_single() && !post_password_required() && ( comments_open() || get_comments_number() )) {
            echo ' | <span class="comments-link"><i class="fa fa-comments" aria-hidden="true"></i> ';
            /* translators: %s: post title */
            comments_popup_link(sprintf(wp_kses(__('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'philippines-incognita'), array('span' => array('class' => array()))), get_the_title()));
            echo '</span>';
        }
    }

endif;

if (!function_exists('Philippines_Incognita_entry_footer')) :

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function Philippines_Incognita_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'philippines-incognita'));
            if ($categories_list && Philippines_Incognita_categorized_blog()) {
                printf('<span class="cat-links">' . esc_html__('Опубликовано в %1$s', 'philippines-incognita') . '</span>', $categories_list); // WPCS: XSS OK.
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html__(', ', 'philippines-incognita'));
            if ($tags_list) {
                printf(' <br><span class="tags-links">' . esc_html__('Теги: %1$s', 'philippines-incognita') . '</span>',
                 $tags_list); // WPCS: XSS OK.
            }
        }


        edit_post_link(
                sprintf(
                        /* translators: %s: Name of current post */
                        esc_html__('Edit %s', 'philippines-incognita'),
                        the_title('<span class="screen-reader-text">"', '"</span>', false)
                ),
                ' | <span class="edit-link">',
                '</span>'
        );
    }

endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function Philippines_Incognita_categorized_blog() {
    if (false === ( $all_the_cool_cats = get_transient('Philippines_Incognita_categories') )) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories(array(
            'fields' => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number' => 2,
        ));

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count($all_the_cool_cats);

        set_transient('Philippines_Incognita_categories', $all_the_cool_cats);
    }

    if ($all_the_cool_cats > 1) {
        // This blog has more than 1 category so Philippines_Incognita_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so Philippines_Incognita_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in Philippines_Incognita_categorized_blog.
 */
function Philippines_Incognita_category_transient_flusher() {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('Philippines_Incognita_categories');
}

add_action('edit_category', 'Philippines_Incognita_category_transient_flusher');
add_action('save_post', 'Philippines_Incognita_category_transient_flusher');


if (!function_exists('Philippines_Incognita_comment')) :

    /**
     * Template for comments and pingbacks.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     */
    function Philippines_Incognita_comment($comment, $args, $depth) {
        // $GLOBALS['comment'] = $comment;

        if ('pingback' == $comment->comment_type || 'trackback' == $comment->comment_type) :
            ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class('media'); ?>>
                <div class="comment-body">
                    <?php _e('Pingback:', 'philippines-incognita'); ?> <?php comment_author_link(); ?> <?php edit_comment_link(__('Edit', 'philippines-incognita'), '<span class="edit-link">', '</span>'); ?>
                </div>

            <?php else : ?>

            <li id="comment-<?php comment_ID(); ?>" <?php comment_class(empty($args['has_children']) ? '' : 'parent' ); ?>>
                <article id="div-comment-<?php comment_ID(); ?>" class="comment-body media mb-4">
                    <a class="pull-left" href="#">
                        <?php if (0 != $args['avatar_size']) echo get_avatar($comment, $args['avatar_size']); ?>
                    </a>

                    <div class="media-body">
                        <div class="media-body-wrap card">

                            <div class="card-header">
                                <h5 class="mt-0"><?php printf(__('%s <span class="says">говорит:</span>', 'philippines-incognita'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?></h5>
                                <div class="comment-meta">
                                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                        <time datetime="<?php comment_time('c'); ?>">
                                            <?php printf(_x('%1$s в %2$s', '1: date, 2: time', 'philippines-incognita'), get_comment_date(), get_comment_time()); ?>
                                        </time>
                                    </a>
                                    <?php edit_comment_link(__('<span style="margin-left: 5px;" class="glyphicon glyphicon-edit"></span> Edit', 'philippines-incognita'), '<span class="edit-link">', '</span>'); ?>
                                </div>
                            </div>

                            <?php if ('0' == $comment->comment_approved) : ?>
                                <p class="comment-awaiting-moderation"><?php _e('Ваш комментарий ожидает проверки.', 'philippines-incognita'); ?></p>
                            <?php endif; ?>

                            <div class="comment-content card-block">
                                <?php comment_text(); ?>
                            </div><!-- .comment-content -->

                            <?php
                            comment_reply_link(
                                    array_merge(
                                            $args, array(
                                'add_below' => 'div-comment',
                                'depth' => $depth,
                                'max_depth' => $args['max_depth'],
                                'before' => '<footer class="reply comment-reply card-footer">',
                                'after' => '</footer><!-- .reply -->'
                                            )
                                    )
                            );
                            ?>

                        </div>
                    </div><!-- .media-body -->

                </article><!-- .comment-body -->

            <?php
            endif;
        }








endif; // ends check for Philippines_Incognita_comment()
