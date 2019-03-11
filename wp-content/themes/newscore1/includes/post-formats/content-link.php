<?php /* LINK POST FORMAT */ ?>

<?php $link = get_post_meta(get_the_ID(), '_radium_link_url', true); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	     
	   
	<a href="<?php echo $link; ?>" title="<?php the_title(); ?>" target="blank">
		
		<div class="link-wrapper">
			  
			<header class="entry-header">
			
				<h2 class="entry-title"><span class="icon-link"></span><?php the_title(); ?></h2><!-- END .entry-title -->
				
			</header><!-- END .entry-header -->
		
			<article class="entry-content">	
				
				<h6><?php echo $link; ?></h6>
			
			</article><!-- END .entry-content -->
			
		</div><!-- END .link-wrapper -->
	
	</a>
	
</article><!-- END #post-<?php the_ID(); ?> -->
	
