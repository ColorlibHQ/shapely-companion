<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<div id="demo_content">

		<?php if ( ! Shapely_Notify_System::shapely_has_plugin( 'shapely-companion' ) || ! Shapely_Notify_System::shapely_has_plugin( 'jetpack' ) || ! Shapely_Notify_System::shapely_has_plugin( 'kali-forms' ) ) : ?>
			<div>
				<p><?php esc_html_e( 'In order to import the demo content you need to complete all the recommended actions from above.', 'shapely-companion' ); ?></p>
			</div>
		<?php else : ?>
			<div class="import-full-content">
				<p>
					<a href="#" class="button button-primary"
					   data-action="import-all"><?php esc_html_e( 'I want my site to look like your demo', 'shapely-companion' ); ?></a>
					<span class="spinner"></span>
				</p>
				<div class="updated-message"><p><?php esc_html_e( 'Content Imported', 'shapely-companion' ); ?></p></div>
			</div>
			<div>
				<p><?php esc_html_e( 'I want only to import demo widgets', 'shapely-companion' ); ?></p>
				<p>
					<a href="#" class="button button-secondary"
					   data-action="import-widgets"><?php esc_html_e( 'Import Widgets', 'shapely-companion' ); ?></a>
					<span class="spinner"></span>
				</p>
				<div class="updated-message"><p><?php esc_html_e( 'Content Imported', 'shapely-companion' ); ?></p></div>
			</div>
		<?php endif ?>

</div>
