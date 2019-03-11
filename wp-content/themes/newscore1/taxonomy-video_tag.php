<?php /* Default Template *

/**
* The template for displaying all pages.
*/

get_header();

	get_template_part( 'includes/content/content', 'header' );

	do_action('radium_before_page');

	?>
    <div class="row">

        <div class="large-9 columns">

        	<?php do_action( 'video_central_before_main_content' ); ?>

        	<?php do_action( 'video_central_template_notices' ); ?>

        	<div id="video-central-tax-front" class="video-central-tax-front">

        		<div class="video-central-entry-content">

        			<?php video_central_get_template_part( 'content', 'archive-video' ); ?>

        		</div>

        	</div><!-- #video-central-front -->

        	<?php do_action( 'video_central_after_main_content' ); ?>

        </div><!-- .large-9 -->

        <div class="large-3 columns">
            <div class="sidebar">
            
			<?php
				/**
				 * video_central_sidebar hook
				 *
				 * @hooked video_central_get_sidebar - 10
				 */
				do_action( 'video_central_sidebar' );
			?>
			
			</div>
			
        </div><!-- .large-3  -->

    </div><!-- .row -->

<?php

do_action('radium_after_page');

get_footer();

?>