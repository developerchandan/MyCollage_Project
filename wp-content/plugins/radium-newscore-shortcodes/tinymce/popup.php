<?php
$wp_root_path = trim( $_GET['wp_root_path'] );
$popup = trim( $_GET['popup'] );

// Access WordPress
require_once( $wp_root_path . '/wp-load.php' );
if ( !defined( 'ABSPATH' ) ) { echo "Error loading Wordpress."; exit; }
require_once( 'shortcodes.class.php' );

// get popup type
$shortcode = new Radium_Shortcodes_Manager( $popup );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head></head>
<body>
<div id="radium-popup">
	<div id="radium-shortcode-wrap">
		<div id="radium-sc-form-wrap">
			<div id="radium-sc-form-head">
				<?php echo $shortcode->popup_title; ?>
			</div>
			<form method="post" id="radium-sc-form">
				<table id="radium-sc-form-table">
					<?php echo $shortcode->output; ?>
					<tbody>
						<tr class="form-row">
							<?php if( ! $shortcode->has_child ) : ?><td class="label">&nbsp;</td><?php endif; ?>
							<td class="field"><a href="#" class="button-primary radium-insert">Insert Shortcode</a></td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>
</body>
</html>