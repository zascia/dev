<?php 
    $settings =& $this->a_panel_settings;
    
    if ($settings['show_customdescription'] != 'false') {
        
        echo $settings['customdescription'];
        
        if (!empty($settings['customdescription'])) {
            
            echo '<br><br>';
        }
    }
?>

<?php if ($settings['show_description'] == 'true') { ?>
    <table border=0 cellspacing=0 cellpadding=0 width="780">
    <tr><td><?php echo $this->a_description?><br><br></td></tr>
    </table>
<?php } ?>