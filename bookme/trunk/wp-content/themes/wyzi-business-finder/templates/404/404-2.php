
<?php 
$ttl = wyz_get_option( '404_title' );
if ( '' == $ttl ) {
	$ttl = esc_html__( 'Error 404 - Page Not Found.', 'wyzi-business-finder' );
}
?>
<div class="page-area page-404 section pt-120 pb-120">
	<div class="container">
		<div class="row">
			<div class="wrapper-404 col-xs-12 text-center">
				<img src="<?php echo WYZ_THEME_URI . '/images/404.png';?>" alt="404">
				<div class="content text-left fix">
					<div class="float-right">
						<h2><?php echo esc_html($ttl);?></h2>
						<h4><?php if ( '' == wyz_get_option( '404_textarea' ) ) {
									echo sprintf( __( 'Don’t Worry,   Back to the %sHome%s Page.', 'wyzi-business-finder' ), '<a href="' . home_url() . '">', '</a>' );
								  } else {
								  	echo wyz_get_option( '404_textarea' );

								  } ?> 
						</h4>
					</div>
				</div>
					<?php wyz_no_content_search_form();?>
			</div>
		</div>
	</div>
</div>
