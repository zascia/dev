<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Philippines_Incognita
 */
?>
<?php if (!is_page_template('blank-page.php') && !is_page_template('blank-page-with-container.php')): ?>
    <?php if (!is_front_page() && !is_home() && !is_archive()) { ?>
        </div><!-- .content -->
    <?php } else { ?>
        </div><!-- .row -->
        </div><!-- .container -->
        </div><!-- #content -->
    <?php } ?>
    <?php
    if (is_active_sidebar('sidebar-2')) {
        dynamic_sidebar('sidebar-2');
    }
    get_template_part('footer-widget');
    ?>
    <!--footer-->
    <footer class="site-footer <?php echo Philippines_Incognita_bg_class(); ?>" role="contentinfo">
        <div class="container">
            <div class="row foot justify-content-center">
                <?php
                $primaryMenu = array(
                    'theme_location' => 'primary',
                    'menu' => '',
                    'container' => '',
                    'container_class' => false,
                    'container_id' => '',
                    'menu_class' => 'menu',
                    'menu_id' => 'primary-menu',
                    'echo' => false,
                    'fallback_cb' => 'wp_page_menu',
                    'before' => '<div class="col-md-2 mb">',
                    'after' => '</div>',
                    'link_before' => '',
                    'link_after' => '',
                    'depth' => 0,
                    'walker' => ''
                );
                echo strip_tags(wp_nav_menu($primaryMenu), '<a><div>');
                ?>
                <div class="col-md-4 mb">
                    <?php get_template_part('searchform'); ?>
                </div>
                <div class="col-md-2 mb">
                    <div class="iconsmob">
                        <?php
                        $social = get_field('social', 'option');
                        if (!empty($social)) {
                            foreach ($social as $soc) {
                                if ($soc['social_name'] == 'facebook') {
                                    echo '<div class="iconsmob_facebook"><a href="' . $soc['social_link'] . '">';
                                    if (!empty($soc['social_img'])) {
                                        echo '<img src="' . $soc['social_img'] . '" alt="' . $soc['social_name'] . '">';
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/inc/assets/img/icons/facebook.png" alt="' . $soc['social_name'] . '">';
                                    }
                                    echo '</a></div>';
                                } elseif ($soc['social_name'] == 'instagram') {
                                    echo '<div class="iconsmob_insta"><a href="' . $soc['social_link'] . '">';
                                    if (!empty($soc['social_img'])) {
                                        echo '<img src="' . $soc['social_img'] . '" alt="' . $soc['social_name'] . '">';
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/inc/assets/img/icons/instagram.png" alt="' . $soc['social_name'] . '">';
                                    }
                                    echo '</a></div>';
                                } else {
                                    echo '<div class="iconsmob_social"><a href="' . $soc['social_link'] . '">';
                                    if (!empty($soc['social_img'])) {
                                        echo '<img src="' . $soc['social_img'] . '" alt="' . $soc['social_name'] . '">';
                                    } else {
                                        echo $soc['social_name'];
                                    }
                                    echo '</a></div>';
                                }
                            }
                        }
                        ?>
                        <div class="iconsmob_language">
                            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/inc/assets/img/footer/strelka.png" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $footer_subtitle = get_field('footer_subtitle', 'option');
            if (!empty($footer_subtitle)) {
                ?>
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <span><?php echo $footer_subtitle; ?></span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </footer>
    <!--footer end-->
<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
<script>
    new WOW().init();
</script>
</body>
</html>