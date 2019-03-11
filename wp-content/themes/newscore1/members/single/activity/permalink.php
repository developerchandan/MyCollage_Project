<?php

get_header( 'buddypress' );

get_template_part( 'includes/content/content', 'header' ); 

?>

<div class="row">

    <main class="content large-12"  role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Article">

        <?php do_action( 'template_notices' ); ?>

        <div class="activity no-ajax" role="main">
        	<?php if ( bp_has_activities( 'display_comments=threaded&show_hidden=true&include=' . bp_current_action() ) ) : ?>

        		<ul id="activity-stream" class="activity-list item-list">
        		<?php while ( bp_activities() ) : bp_the_activity(); ?>

        			<?php locate_template( array( 'activity/entry.php' ), true ); ?>

        		<?php endwhile; ?>
        		</ul>

        	<?php endif; ?>
        </div>

    </main>

</div>

<?php get_footer( 'buddypress' ); ?>