<div class="listing-item">
    <?php if (has_post_thumbnail()) { ?>                    
        <div class="listing-item_image">
            <?php the_post_thumbnail(); ?></a>
        </div>
    <?php } ?>
    <div class="listing-item_title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></div>
    <div class="listing-item_text">
        <p>
            <?php the_excerpt(); ?>
        </p>
    </div>
    <div class="listing-item_readmore">
        <a href="<?php echo esc_url(get_permalink()); ?>">Читать полностью</a>
    </div>
</div>