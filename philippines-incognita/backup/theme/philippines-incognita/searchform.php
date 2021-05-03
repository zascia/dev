<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label>
        <input type="search" class="" placeholder="<?php echo esc_attr_x('Поиск по сайту', 'placeholder', 'philippines-incognita'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s" title="<?php _ex('Search for:', 'label', 'philippines-incognita'); ?>">
    </label>
    <input type="submit" class="search-submit btn btn-default d-none" value="<?php echo esc_attr_x('Поиск', 'submit button', 'philippines-incognita'); ?>">
</form>