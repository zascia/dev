<?php
global $pagenow;
if ( isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
    wp_redirect( admin_url( 'themes.php?page=wyzi_server_status' ) );
    exit;
}

add_action('admin_menu', 'wyzi_add_server_status_menu');

function wyzi_add_server_status_menu() {
add_submenu_page( 'themes.php', 'Server Compatibility Status', 'Server Status', 'manage_options', 'wyzi_server_status', 'wyzi_server_status' );
}

function wyzi_server_status() {

	// Get PHP Memory Limit
	$memory_limit = ini_get('memory_limit');
	if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
	    if ($matches[2] == 'M') {
	        $memory_limit = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
	    } else if ($matches[2] == 'K') {
	        $memory_limit = $matches[1] * 1024; // nnnK -> nnn KB
	    }
	}
	
	$memory_limit_ok = ($memory_limit >= 512 * 1024 * 1024); // at least 512M?
	
	
	
	
	// Get Maximum Upload File Size
		function wyzi_return_bytes($val) {
            if ( empty( $val ) )
                $val = '2M';
		    $val = trim($val);
		    $last = strtolower($val[strlen($val)-1]);
            $val = preg_replace('/[^0-9]/', '', $val); 
		    switch($last) 
		    {
		        case 'g':
		        $val *= 1024;
		        case 'm':
		        $val *= 1024;
		        case 'k':
		        $val *= 1024;
		    }
		    return $val; 
		}
		
		function wyzi_max_file_upload_in_bytes() {
		    //select maximum upload size
		    $max_upload = wyzi_return_bytes(ini_get('upload_max_filesize'));
		    //select post limit
		    $max_post = wyzi_return_bytes(ini_get('post_max_size'));
		      
		    //select memory limit
		    $memory_limit = wyzi_return_bytes(ini_get('memory_limit'));
		    // return the smallest of them, this defines the real limit
		    return min($max_upload, $max_post, $memory_limit);
		}
		
		function wyzi_formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
	$max_upload_in_bytes = wyzi_max_file_upload_in_bytes();
	
	$max_upload_filesize_ok = ($max_upload_in_bytes >= 32 * 1024 * 1024); // at least 32M?
	
	?>

	
    <table class="widefat fixed" cellspacing="0">
    <thead>
    <tr>

           
            <th colspan="3" id="columnname" class="manage-column column-columnname" scope="col"><h3>Wyzi Theme Server Status</h3><br>Please make sure to meet with the following server requirements for demo import and other theme and plugins features to work properly.</th>
          

    </tr>
    </thead>

    <tbody>
        <tr class="alternate">
        
            <td class="column-columnname">PHP version</td>
            <td class="column-columnname"><?php echo PHP_VERSION; ?></td>
           <?php echo version_compare(PHP_VERSION, '5.6.24', '>') ? '
            <td class="column-columnname" style="color:#7ad03a;">Good</td>'
            : '<td class="column-columnname" style="color:#d03a4c;">Minimum Required is PHP version 5.6.24 </td>' ; ?>
            
        </tr>
        <tr>
            
        <td class="column-columnname">PHP Memory Limit</td>
            <td class="column-columnname"><?php echo ini_get('memory_limit'); ?> </td>
            <?php if ( $memory_limit_ok ) { ?>
            <td class="column-columnname" style="color:#7ad03a;">Good</td>
            <?php } else { ?><td class="column-columnname" style="color:#d03a4c;">Recommended 512 MB </td> <?php } ?>
            
        </tr>
        
        <tr class="alternate">
            
       <td class="column-columnname">PHP Upload Max File Size</td>
            <td class="column-columnname"><?php echo wyzi_formatSizeUnits($max_upload_in_bytes); ?></td>
            <?php if ( $max_upload_filesize_ok ) { ?> 
            <td class="column-columnname" style="color:#7ad03a;">Good</td>
            <?php } else { ?><td class="column-columnname" style="color:#d03a4c;">Minimum Required is 32 MB </td><?php } ?>
            
        </tr>
        
        <tr>
            
        <td class="column-columnname">Maximum Execution Time</td>
            <td class="column-columnname"><?php echo ini_get("max_execution_time");?> seconds</td>
            <?php echo ini_get("max_execution_time") >= 600 ? '
            <td class="column-columnname" style="color:#7ad03a;">Good</td>'
            : '<td class="column-columnname" style="color:#d03a4c;">Minimum Required 600 seconds. If your Host is Siteground, 120 seconds is enough </td>' ; ?>
            
        </tr>

        <td class="column-columnname">PHP allow_url_fopen</td><?php
            echo (ini_get("allow_url_fopen") == true ? 
            '<td class="column-columnname">Enabled </td>':
            '<td class="column-columnname">Disabled </td>');
            echo (ini_get("allow_url_fopen") == true ? '
            <td class="column-columnname" style="color:#7ad03a;">Good</td>'
            : '<td class="column-columnname" style="color:#d03a4c;">Contact your Host to Enable this Option </td>' ) ; ?>
            
        </tr>

          <td class="column-columnname">WYZI Theme Version</td><?php
          $wyzi_theme = wp_get_theme(get_template());
          $wyzi_version = $wyzi_theme->get( 'Version' );?> 
            <td class="column-columnname"><?php echo esc_html($wyzi_version); ?> </td>
           
            <td class="column-columnname" style="color:#7ad03a;">Always Check if you have the latest version on <a target="_blank" href="https://documentation.wyzi.net/docs/updates-change-log/change-log/">Wyzi Change Log</a>. Also you can configure for one click update following this <a target="_blank" href="https://documentation.wyzi.net/docs/getting-started/how-to-update-wyzi-theme-automatically/">article</a>.</td>     
        </tr>

        <td class="column-columnname">WYZI Toolkit Plugin Version</td><?php

            $wyzi_toolkit_plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/wyz-toolkit/wyz-toolkit.php' );
            $wyzi_toolkit_version = $wyzi_toolkit_plugin_data['Version'];
            echo (!empty($wyzi_toolkit_version) ? 
            '<td class="column-columnname">'. $wyzi_toolkit_version .' </td>':
            '<td class="column-columnname">Not Available </td>');

             if ($wyzi_toolkit_version ==  $wyzi_version )
            echo '<td class="column-columnname" style="color:#7ad03a;">Good. Matches Theme Version</td>';
            else
            echo '<td class="column-columnname" style="color:#d03a4c;">Does not Match Theme Version. Please visit Appearance > Install Plugins then install & update all plugins</td>'; ?>
             
        </tr>


     
    </tbody>
</table>


<?php } ?>