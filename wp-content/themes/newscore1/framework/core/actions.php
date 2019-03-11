<?php
$framework = radium_framework();

add_action('admin_bar_menu', 'radium_add_toolbar_items', 100);

add_action('do_feed_radiumopts-'. $framework->theme_option_name,  'radium_download_options', 1, 1);
