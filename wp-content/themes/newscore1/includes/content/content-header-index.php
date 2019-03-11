<header id="page-header">

    <div class="row">

        <div class="large-6 columns">
  			
  			<?php $all_posts_page_title = radium_get_option( 'all_posts_page_title') ? radium_get_option( 'all_posts_page_title') : __('All Posts', 'radium');
  			?>
            <h1 class="header"><?php echo $all_posts_page_title; ?></h1>

        </div>

        <div class="large-6 columns">
            <?php do_action('radium_header_breadcrumb'); ?>
        </div>

    </div>

</header>