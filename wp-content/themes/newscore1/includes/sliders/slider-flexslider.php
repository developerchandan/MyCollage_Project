<div class="flexslider-wrapper">
	<!-- BEGIN #slider-->
		<div class="slider-wrapper">
			<div class="radium-slider">
				<div class="flexslider main-flexslider">
					<ul class="slides loading">
					<?php $slides = get_post_meta( get_the_ID(), '_radium_slider_slides', false );
						if( !$slides || !$slides[0] )
							return;
						foreach ( $slides[0] as $slide ) : ?>
							<li class="slide">
								
								<?php 
								
								$embed = $slide['slide-video-embed'];
								if( !empty($embed) ) {
									echo "<div class='video-frame'>";
								    	echo stripslashes(htmlspecialchars_decode($embed));
								    echo "</div>";
								} else { ?>
								
	    								<?php if( $slide['slide-link-url'] ) { ?><a href="<?php echo $slide['slide-link-url']; ?>" <?php if ($slide['slide-link-target'] == 1) { ?> target="_blank" <?php } ?>><?php } ?>
										<img src="<?php echo $slide['slide-img-src']; ?>" alt="<?php echo $post->post_title; ?>" class="slide-image" height="" width=""/> 
									<?php if( $slide['slide-link-url'] ) { ?></a><?php } ?>	
									
									<?php if( !empty( $slide['slide-content-title'] ) || !empty( $slide['slide-content'] )  ) { ?>
										<div class="slide-content-container hide-for-small">
							    	    	<article class="slide-content">
							    	    		<header>
													<?php if( !empty( $slide['slide-title'] ) ) { ?>
														<h2><?php echo $slide['slide-title']; ?></h2>
								    	    		<?php } ?>		
												<?php if( !empty( $slide['slide-content'] ) ) { ?>
							    	    			<div class="entry">
							    	    				<?php  echo do_shortcode( $slide['slide-content'] ) ; ?>
							    	    			</div>
							    	    		<?php } ?>		
							    	    		</header>
							    	    	</article>
										</div>
									<?php }
								} ?>		
							</li><!-- end .slide -->
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div><!-- END #slider -->
	</div>
	
	<script src="" type="text/javascript">
		var spinner = new Spinner().spin();
		var target = document.querySelectorAll('.flexslider-wrapper');
 		target.appendChild(spinner.el);
 	</script>