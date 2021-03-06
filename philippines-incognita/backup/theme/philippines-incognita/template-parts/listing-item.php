<div class="listing-item">
    <?php if (has_post_thumbnail()) { ?>                    
        <div class="listing-item_image">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php } ?>
    <?php the_title('<div class="listing-item_title">', '</div>'); ?>
    <div class="listing-item_text">
        <p>
            <?php the_excerpt(); ?>
        </p>
    </div>
    <div class="listing-item_readmore">
        <a href="<?php echo esc_url(get_permalink()); ?>">Читать полностью</a>
    </div>
</div>