<?php

/**
 * Display bg_video.
 *
 * @since 2.1.0
 *
 * @param array $options all options for bg_video
 * @return string $output HTML output for bg_video
 */

if( ! function_exists( 'radium_builder_radium_video_element' ) ) {
	function radium_builder_radium_video_element( $id, $settings, $location ) { 
		
		if( !function_exists('video_central_has_videos') ) return;
		
		$popular_tab_title = isset( $settings['popular_tab_title'] ) ? $settings['popular_tab_title'] : __('Popular Videos', 'radium');
		$latest_tab_title = isset( $settings['latest_tab_title'] ) ? $settings['latest_tab_title'] : __('Recent Videos', 'radium');
	?>

        <section class="videos-tab">

            <ul class="nav nav-tabs clearfix">
                <li class="active"><a href="#video_central_featured_videos-<?php echo $id; ?>" data-toggle="tab"><?php echo $latest_tab_title; ?></a></li>
                <li class=""><a href="#video_central_popular_videos-<?php echo $id; ?>" data-toggle="tab"><?php echo $popular_tab_title; ?></a></li>
            </ul>

            <div class="ribbon"></div>
            <div class="tab-content">

                <div class="tab-pane active latest" id="video_central_featured_videos-<?php echo $id; ?>">

                <?php if ( video_central_has_videos( array('posts_per_page' => 8 ) ) ) : ?>

                    <div class="video-central-carousel">

                        <div class="horizontal-carousel-container">

                            <div class="control prev"></div>

                            <div class="horizontal-carousel">

                                <?php echo do_shortcode('[video-central-view id="latest"]'); ?>

                            </div><!-- .horizontal-carousel -->

                            <div class="control next"></div>

                        </div><!-- .horizontal-carousel-container -->

                    </div><!-- .video-central-carousel -->

                    <?php endif; ?>

                </div><!-- .tab-pane -->

                <div class="tab-pane popular" id="video_central_popular_videos-<?php echo $id; ?>">

                <?php if ( video_central_has_videos( array('posts_per_page' => 8 ) ) ) : ?>

                    <div class="video-central-carousel">

                        <div class="horizontal-carousel-container">

                            <div class="control prev"></div>

                            <div class="horizontal-carousel">

                                <?php echo do_shortcode('[video-central-view id="popular"]'); ?>

                            </div><!-- .horizontal-carousel -->

                            <div class="control next"></div>

                        </div><!-- .horizontal-carousel-container -->

                    </div><!-- .video-central-carousel -->

                    <?php endif; ?>

                </div><!-- .tab-pane -->

        </div><!-- .tab-content -->

    </section><?php

	}
}
add_action('radium_builder_radium_video', 'radium_builder_radium_video_element', 10, 3);