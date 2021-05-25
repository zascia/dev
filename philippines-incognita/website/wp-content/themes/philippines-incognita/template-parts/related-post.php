<?php

// необязательно, но в некоторых случаях без этого не обойтись
global $post;

// тут можно указать post_tag (подборка постов по схожим меткам) или даже массив array('category', 'post_tag') - подборка и по меткам и по категориям
$related_tax = 'post_tag';

// получаем ID всех элементов (категорий, меток или таксономий), к которым принадлежит текущий пост
$cats_tags_or_taxes = wp_get_object_terms($post->ID, $related_tax, array('fields' => 'ids'));

// массив параметров для WP_Query
$args = array(
    'post__not_in' => array($post->ID),
    'caller_get_posts' => 1, // отменяем повторение одинаковых статей;
    'posts_per_page' => 4, // сколько похожих постов нужно вывести,
    'tax_query' => array(
        array(
            'taxonomy' => $related_tax,
            'field' => 'id',
            'include_children' => false, // нужно ли включать посты дочерних рубрик
            'terms' => $cats_tags_or_taxes,
            'operator' => 'IN' // если пост принадлежит хотя бы одной рубрике текущего поста, он будет отображаться в похожих записях, укажите значение AND и тогда похожие посты будут только те, которые принадлежат каждой рубрике текущего поста
        )
    )
);
$related_query = new WP_Query($args);

// если посты, удовлетворяющие нашим условиям, найдены
if ($related_query->have_posts()) :

    echo '<div class="related-art-container">';

    // выводим заголовок блока похожих постов
    echo '<h3 class="comment-title related-title">Рекомендуемые материалы</h3><ul class="list-group list-group-flush">';

    // запускаем цикл
    while ($related_query->have_posts()) : $related_query->the_post();
        // в данном случае посты выводятся просто в виде ссылок

        echo '<li class="list-group-item related-article-item"><div><img
        class="related-article-image" src="'.get_the_post_thumbnail_url() . '"/></div><a class="related-article-link" href="' . get_permalink($related_query->post->ID) . '">' . $related_query->post->post_title . '</a></li>';
    endwhile;
    echo '<ul>';
    echo '</div>';
endif;

// не забудьте про эту функцию, её отсутствие может повлиять на другие циклы на странице
wp_reset_postdata();

