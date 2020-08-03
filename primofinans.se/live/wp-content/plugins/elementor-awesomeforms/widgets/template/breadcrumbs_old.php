<?php
$breadcrumbs_forms = get_field('breadcrumbs_forms', 'option');
if (!empty($breadcrumbs_forms)) {
    if (empty($breadcrumbs_forms['hide_breadcrumbs']) || $breadcrumbs_forms['hide_breadcrumbs'] != 1) {
        $breadcrumb_active = plugins_url('/elementor-awesomeforms/assets/images/breadcrumb-active.png');
        $breadcrumb_inactive = plugins_url('/elementor-awesomeforms/assets/images/breadcrumb-inactive.png');
        $style = plugins_url('/elementor-awesomeforms/assets/css/style.css');
        $app = plugins_url('/elementor-awesomeforms/assets/js/app.js');
        $url = $_SERVER['REQUEST_URI'];
        if (substr($url, -6) == "/step2" || substr($url, -7) == "/step2/") {
            $step2 = true;
        } else {
            $step2 = false;
        }
        ?>
        <ul class="breadcrumbs-top">
            <li class="breadcrumb-item <?php echo (!$step2) ? 'breadcrumb-active' : ''; ?>">
                <img class="breadcrumb-inactive-img" src="<?php echo $breadcrumb_inactive; ?>" alt=""><img class="breadcrumb-active-img" src="<?php echo $breadcrumb_active; ?>" alt="">1) <span><?php echo $breadcrumbs_forms['breadcrumb_1']; ?></span>
            </li>
            <li class="breadcrumb-item <?php echo ($step2) ? 'breadcrumb-active' : ''; ?>">
                <img class="breadcrumb-inactive-img" src="<?php echo $breadcrumb_inactive; ?>" alt=""><img class="breadcrumb-active-img" src="<?php echo $breadcrumb_active; ?>" alt="">2) <span><?php echo $breadcrumbs_forms['breadcrumb_2']; ?></span>
            </li>
            <li class="breadcrumb-item">
                <img class="breadcrumb-inactive-img" src="<?php echo $breadcrumb_inactive; ?>" alt=""><img class="breadcrumb-active-img" src="<?php echo $breadcrumb_active; ?>" alt="">3) <span><?php echo $breadcrumbs_forms['breadcrumb_3']; ?></span>
            </li>
        </ul>
        <?php
    }
}
?>