<?php /* QUOTE POST FORMAT */ ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>	        
  
  <header class="entry-header">
	  		
	<h2 class="entry-title">
		
		<span class="icon-quote-left"></span>
		
		<?php the_title(); ?>
	
	</h2><!-- END .entry-title -->
					
    </header><!-- END .entry-header -->
  	
	<div class="entry-content">	
			
		<h6> 
			<?php the_content( __( '<span>Read More</span><span class="right comments-count">'.get_radium_comment_count().'</span>', 'radium' ) ); ?>
		</h6>
	 
	</div><!-- END .entry-content -->

</article><!-- END #post-<?php the_ID(); ?> -->