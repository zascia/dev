<?php

/**
 * Template Name: Home Page
 */
get_header();
while (have_posts()) : the_post();
    get_template_part('template-parts/content', 'home');
endwhile; // End of the loop.
get_footer();
