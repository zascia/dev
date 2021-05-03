<?php

if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) {?>
        <div id="footer-widget" class="cities row m-0 <?php if(!is_theme_preset_active()){ echo 'bg-light'; } ?>">
            <div class="container">
                <div class="row br">
                    <?php if ( is_active_sidebar( 'footer-1' )) : ?>
                        <div class="col-md-3"><?php dynamic_sidebar( 'footer-1' ); ?></div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-2' )) : ?>
                        <div class="col-md-3"><?php dynamic_sidebar( 'footer-2' ); ?></div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-3' )) : ?>
                        <div class="col-md-3"><?php dynamic_sidebar( 'footer-3' ); ?></div>
                    <?php endif; ?>
                    <?php if ( is_active_sidebar( 'footer-4' )) : ?>
                        <div class="col-md-3"><?php dynamic_sidebar( 'footer-4' ); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

<?php }