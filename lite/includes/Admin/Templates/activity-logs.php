<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use KaizenCoders\Logify\Helper;

/* @var $object \KaizenCoders\Logify\Admin\Activity_Logs_Table */
$object = Helper::get_data( $template_data, 'object', array() );

$title = Helper::get_data( $template_data, 'title', '' );

?>

<div class="wrap">
	<h1 class="wp-heading-inline">
		<span class="text-2xl font-bold leading-7 text-gray-900 sm:text-2xl sm:leading-9 sm:truncate">
			<?php echo esc_html($title); ?>
		</span>
	</h1>
	<div id="poststuff" class="kc-us-items-lists">
		<div id="post-body" class="metabox-holder column-1">
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					<form method="get">
						<input type="hidden" name="page" value="us_links">
						<?php
						$object->prepare_items();
						?>
					</form>
					<form method="post">
						<?php
						$object->prepare_groups_dropdown();
						$object->prepare_expiry_datepicker();
						$object->display();
						?>
					</form>
				</div>
			</div>
		</div>
		<br class="clear">
	</div>
</div>
