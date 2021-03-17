<?php
global $WCMp;

$vendors = apply_filters( 'wyz_vendor_list_widget_vendors', $vendors );
$vendor_count = count($vendors);
if($vendor_count > 5 )	{ ?>
	<div id="wcmp_widget_vendor_list" style="height: 308px; overflow-y: scroll; width: 226px;" >
<?php } else {?>
<div id="wcmp_widget_vendor_list" style=" height: auto; width: 226px;" >
<?php }
if($vendors) {
	foreach($vendors as $vendors_key => $vendor) {
		$link = array(
			'link' => esc_attr( $vendor->permalink ),
			'is_business' => false
		);

		if (class_exists('WyzHelpers')) {
			$businesses = WyzHelpers::get_user_businesses( $vendor->id );
			if ( ! empty( $businesses['published'] ) )
				foreach ($businesses['published'] as $key => $value) {
					$link['link'] = get_the_permalink( $key );
					$link['is_business'] = true;
					break;
				}
		}
		$link = apply_filters( 'wyz_vendor_list_widget_link', $link, $vendor );
		if (empty($link['link'])) continue;

		$vendor->image = $vendor->get_image() ? $vendor->get_image() : $WCMp->plugin_url . 'assets/images/WP-stdavatar.png';
		?>
		<div style=" width: 100%; margin-bottom: 5px; clear: both; display: block;">
			<div style=" width: 25%;  display: inline;">		
			<img width="50" height="50" class="vendor_img" style="display: inline;" src=<?php echo esc_url($vendor->image); ?> id="vendor_image_display">
			</div>
			<div style=" width: 75%;  display: inline;  padding: 10px;">
					<a href="<?php echo esc_url($link['link']); ?>">
						<?php echo esc_html($vendor->page_title); ?>
					</a>
			</div>
		</div>
	<?php } 
}?>
</div>