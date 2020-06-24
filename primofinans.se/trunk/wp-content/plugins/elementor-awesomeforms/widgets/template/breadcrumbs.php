<?php
$breadcrumb_active = plugins_url( '/elementor-awesomeforms/assets/images/breadcrumb-active.png');
$breadcrumb_inactive = plugins_url( '/elementor-awesomeforms/assets/images/breadcrumb-inactive.png');
$style = plugins_url( '/elementor-awesomeforms/assets/css/style.css');
$app = plugins_url( '/elementor-awesomeforms/assets/js/app.js');
?>
<ul class="breadcrumbs-top">
    <li class="breadcrumb-item breadcrumb-active">
        <img class="breadcrumb-inactive-img" src="<?php echo $breadcrumb_inactive;?>" alt=""><img class="breadcrumb-active-img" src="<?php echo $breadcrumb_active;?>" alt="">1) <span>Välj lånebelopp och återbetalningstid</span>
    </li>
    <li class="breadcrumb-item">
        <img class="breadcrumb-inactive-img" src="<?php echo $breadcrumb_inactive;?>" alt=""><img class="breadcrumb-active-img" src="<?php echo $breadcrumb_active;?>" alt="">2) <span>Få erbjudanden <strong>om lån</strong></span>
    </li>
    <li class="breadcrumb-item">
        <img class="breadcrumb-inactive-img" src="<?php echo $breadcrumb_inactive;?>" alt=""><img class="breadcrumb-active-img" src="<?php echo $breadcrumb_active;?>" alt="">3) <span>Du får det <strong>bästa erbjudandet</strong></span>
    </li>
</ul>