<?php

if (!class_exists('Radium_User_Rating')) {

    class Radium_User_Rating {

        public $current_rating;

        public $current_position;

        public $count;

        function __construct() {

            // Get rating data for the current post
            if (is_single()) $this->retrieve_values();

            // Listen to rating info.
            add_action('wp_ajax_radium_rating', 		array(&$this, 'sync_rating'));
            add_action('wp_ajax_nopriv_radium_rating', 	array(&$this, 'sync_rating'));
            add_action('wp_enqueue_scripts', 			array(&$this, 'load_scripts'));

        }

        public function load_scripts() {

            global $post;

            if ($post) wp_localize_script('jquery', 'radium_script', array( 'post_id' => $post->ID, 'ajaxurl' => admin_url('admin-ajax.php') ) );

        }

        private function retrieve_values() {

            $current_rating = get_post_meta(get_the_ID(), '_radium_current_rating', true);

            if (!$current_rating) $current_rating = 0;

            $this->current_rating = $current_rating;

            $current_position = get_post_meta(get_the_ID(), '_radium_current_position', true);

            if (!$current_position) $current_position = 0;

            $this->current_position = $current_position;

            $count = get_post_meta(get_the_ID(), '_radium_ratings_count', true);

            if (!$count) $count = 0;

            $this->count = $count;
        }

        public function sync_rating()  {

            // Sync values
            $position = (int)$_POST['rating_position'];
            $post_id = (int)$_POST['post_id'];

            // Current values
            $current_position = (int)get_post_meta($post_id, '_radium_current_position', true);

            if (!$current_position) $current_position = 0;

            $current_rating = (int)get_post_meta($post_id, '_radium_current_rating', true);

            if (!$current_rating) $current_rating = 0;

            $count = (int)get_post_meta($post_id, '_radium_ratings_count', true);

            if (!$count) $count = 0;

            // new values
            $new_position = ($current_position * $count + $position) / ($count + 1);
            $new_count = $count + 1;
            $new_rating = floor(($new_position / 10) * 5) / 10;

            // update values
            update_post_meta($post_id, '_radium_current_position', $new_position, get_post_meta($post_id, '_radium_current_position', true));
            update_post_meta($post_id, '_radium_current_rating', $new_rating, get_post_meta($post_id, '_radium_current_rating', true));
            update_post_meta($post_id, '_radium_ratings_count', $new_count, get_post_meta($post_id, '_radium_ratings_count', true));

            exit;
        }

    }

}

new Radium_User_Rating();

/**
 * [radium_get_total_post_score description]
 * @return [type] [description]
 */
function radium_get_total_post_score (){

    // Post Rating - Defined by post author in admin post edit page
   if ( get_post_meta( get_the_ID(), '_radium_post_score', true) ) {

        // Loop through the scores
        // get the scores sum
        // divide the sum of all scores by scores count
        $score_rows = get_post_meta( get_the_ID(), '_radium_rating',  true );

        $score = array();

        if ( $score_rows ) {

            foreach( $score_rows as $key => $row ){
                $score[$key] = $row['field_text'];
            }

            $total = 0;

            foreach( $score as $key=>$value ){

                $total = $total + $value;

            }

        }

        $average = (count( $score ) > 0) ? round ( ($total / count( $score )) * 10) : 0;

        return apply_filters( __FUNCTION__, $average);

    } else
        return 0;

}

/**
 * radium_review_post Show Post review
 *
 * @return null
 */
function radium_review_post(){

    if ( !is_single() ) return;

    // Post Rating - Defined by post author in admin post edit page
   if ( get_post_meta( get_the_ID(), '_radium_post_score', true) ) :

        $rating_score_total     = radium_get_total_post_score();
        $rating_type            = get_post_meta( get_the_ID(), '_radium_rating_type',               true );
        $rating_position        = get_post_meta( get_the_ID(), '_radium_rating_display_position',   true );
        $rating_header          = get_post_meta( get_the_ID(), '_radium_rating_header',             true );
        $rating_brief_summary   = get_post_meta( get_the_ID(), '_radium_rating_brief_summary',      true );
        $rating_long_summary    = get_post_meta( get_the_ID(), '_radium_rating_longer_summary', 	true );
        $rating_score           = get_post_meta( get_the_ID(), '_radium_rating',                    true );
        $user_ratings 			= get_post_meta( get_the_ID(), '_radium_user_rating_enable', 		true );;
        $ratings = new Radium_User_Rating;

    ?><div class="entry-rating <?php echo $rating_type . ' ' . $rating_position; ?>" itemprop="review" itemscope itemtype="http://schema.org/Review">
        <div class="inner">
            <?php

            if( $rating_header ) echo '<h3 class="entry-title" itemprop="name">' . $rating_header. '</h3>'; ?>

                <span style="display:none" itemprop="itemreviewed"><?php the_title(); ?></span>
                <span style="display:none" itemprop="author"><?php the_author(); ?></span>

            <?php if ( $rating_type == 'stars') :

                if( $rating_score ) :

                    foreach( $rating_score as $row ) : ?>

                        <div class="item rating-star clearfix">
                            <h4 class="rating-title"><?php echo $row['field_label']; ?></h4>
                            <div class="rating-stars-outer">
                                <div class="rating-stars-wrapper">
                                    <div class="rating-stars" style="width:<?php echo $row['field_text']; ?>0%;"></div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach;

                endif;

                if ( $rating_long_summary ) : ?>

                    <div class="rating-summary final-score-stars clearfix">
                        <div class="long-summary">
                            <div class="description"><strong><?php _e('Summary', 'radium'); ?>:</strong> <div itemprop="description"><?php echo $rating_long_summary; ?></div></div>
                        </div>
                        <div class="rating-final-score">
                            <div class="rating-final-score-inner">
                                <h3><span itemprop="reviewRating"><?php echo $rating_score_total; ?>%</span></h3>
                                <h4><span><?php echo $rating_brief_summary; ?></span></h4>
                                <span class="final-score-stars-under">
                                    <span class="final-score-stars-top" style="width:100%"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                <?php endif;

                if( $user_ratings ) :

                    $current_rating = $ratings->current_rating ? $ratings->current_rating : 0;
                    $count = $ratings->count ? $ratings->count : 0;
                    $current_position = $ratings->current_position ? $ratings->current_position : 0;

                    ?>

                    <div class="user-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                        <meta itemprop="ratingValue" content="<?php echo $current_rating; ?>">
                        <meta itemprop="ratingCount" content="<?php echo $count; ?>">
                        <span class="user-review-description">
                            <strong><span class="your-rating" style="display:none;"><?php _e('Your Rating', 'radium'); ?></span><span class="user-rating"><?php _e('User Rating', 'radium'); ?></span></strong>:
                            <span class="score">
                                <?php echo $current_rating; ?></span> <em>(<span class="count"><?php echo $count; ?></span> <?php _e('votes', 'radium'); ?>)</em>
                            </span>

                        <div class="user-review-rating">
                            <div class="user-rating-stars-outer">
                                <div class="rating-stars-wrapper">
                                    <div class="rating-stars" style="width:<?php echo $current_position; ?>0%;"></div>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php endif;

           elseif( $rating_type == 'percentage') :

                if( $rating_score ) :

                    foreach( $rating_score as $row ) : ?>

                        <div class="item rating-percentage clearfix">
                            <h4 class="rating-title"><?php echo $row['field_label']; ?></h4>
                            <div class="rating-percentage-outer">
                                <div class="rating-percentage-wrapper">
                                    <div class="rating-percentage" style="width:<?php echo $row['field_text']; ?>0%;"><span></span></div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach;

                endif;

                if ( $rating_long_summary ) : ?>

                    <div class="rating-summary final-score-percentage clearfix">
                        <div class="long-summary">
                            <div class="description"><strong><?php _e('Summary', 'radium'); ?>:</strong> <div itemprop="description"><?php echo $rating_long_summary; ?></div></div>
                        </div>
                        <div class="rating-final-score">
                            <div class="rating-final-score-inner">
                                <h3><span itemprop="reviewRating"><?php echo $rating_score_total; ?>%</span></h3>
                                <h4><span itemprop="review"><?php echo $rating_brief_summary; ?></span></h4>
                                <span class="final-score-percentage-under">
                                    <span class="final-score-percentage-top" style="width:100%"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                <?php endif;

                if( $user_ratings ) : ?>

                    <div class="user-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                            <meta itemprop="ratingValue" content="<?php echo $ratings->current_rating; ?>">
                            <meta itemprop="ratingCount" content="<?php echo $ratings->count; ?>">
                               <span class="user-review-description">
                            <strong><span class="your-rating" style="display:none;"><?php _e('Your Rating', 'radium'); ?></span><span class="user-rating"><?php _e('User Rating', 'radium'); ?></span></strong>:
                            <span class="score">
                                <?php echo $ratings->current_rating; ?></span> <em>(<span class="count"><?php echo $ratings->count; ?></span> <?php _e('votes', 'radium'); ?>)</em>
                        </span>

                        <div class="user-review-rating">
                            <div class="user-rating-stars-outer">
                                <div class="rating-stars-wrapper">
                                    <div class="rating-stars" style="width:<?php echo $ratings->current_position; ?>0%;"><span></span></div>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php endif;

               else :

                // Output rating score
                echo '<div class="score-' . number_format( $rating_score_total, 0, '.', '' ) . '">';

                    echo '<div class="chart-shortcode chart-70 chart-left" data-linewidth="6" data-percent="0" data-animatepercent="60" data-size="70" data-barcolor="#E67300" data-trackcolor="#baebe8">
                        <span>' . number_format( $rating_score_total, 0, '.', '' ) . '</span>
                    </div>';

                echo '</div>';

            endif; ?>

        </div>
    </div>
    <?php endif;

}

/**
 * [radium_add_reviews_to_post description]
 * @return [type] [description]
 */
function radium_add_reviews_to_post () {

    if( get_post_meta( get_the_ID(), '_radium_rating_display_position', true ) === 'bottom' ) {

        add_action('radium_after_post_content', 'radium_review_post');

    } else {

        add_action('radium_before_post_content', 'radium_review_post');

    }

}
add_action('radium_before_page', 'radium_add_reviews_to_post');


/**
 * radium_review_post_score Show Post Score
 *
 * @return [type] [description]
 */
function radium_review_post_score(){

    if ( !is_single() ) return;

    $score_total = radium_get_total_post_score();

    // Rating and Scores Breakdown
    if ( get_post_meta( get_the_ID(), '_radium_post_score',  true ) ) { ?>

        <div class="single-box clearfix entry-breakdown">

            <h3 class="entry-title">
                <?php echo $ti_option['single_breakdown_title']; ?>
            </h3>

            <?php

            $score_output = get_post_meta( get_the_ID(), '_radium_rating',  true );

            if( $score_output ) {

                foreach( $score_output as $row ){?>
                    <div class="item clearfix">
                        <h4 class="entry-meta">
                            <span class="total"><?php echo $row['field_text']; ?></span>
                            <?php echo $row['field_label']; ?>
                        </h4>
                        <div class="score-outer">
                            <div class="score-line" style="width:<?php echo $row['field_text']; ?>0%;"></div>
                        </div>
                    </div>
            <?php
                }
            } ?>

            <div class="total-score clearfix">
                <h4 class="entry-meta">
                    <span class="total"><?php echo number_format( $score_total, 1, '.', '' ); ?></span>
                    <?php echo __( 'Total Score', 'radium' ); ?>
                </h4>
                <div class="score-outer">
                    <div class="score-line" style="width:<?php echo number_format( $score_total, 1, '', '' ); ?>%;"><span></span></div>
                </div>
            </div>

        </div>
    <?php }

}

//add_action('radium_after_post_content', 'radium_review_post_score');

/**
 * radium_review_score dial
 *
 * @return null
 */
function radium_get_review_score() {

    if( !get_post_meta( get_the_ID(), '_radium_post_score', true ) ) return;

    $review_type = get_post_meta( get_the_ID(), '_radium_rating_type', true );

    $output = '<div class="review-score">';

        $score_total = radium_get_total_post_score();

        $output .= '<div class="chart-shortcode2 chart-70 chart-left">';

        $output .= '<div class="score-inner">';

            $output .= '<span class="numbers">' . number_format( $score_total, 0, '.', '' ) . '%</span>';

            $output .= '<span class="title">' . __( 'Review Score', 'radium' ) . '</span>';

        $output .= '</div>';

        $output .= '</div>';

    $output .= '</div>';

    $output = apply_filters( __FUNCTION__, $output );

    echo $output;

}
//add_action('radium_post_grid_extras', 'radium_get_review_score');
//add_action('radium_after_post_review_thumb', 'radium_get_review_score');

if ( !function_exists('radium_get_review_post_meta') ) {

    function radium_get_review_post_meta($output = '') {

        $post_meta_elements = radium_get_option('post_meta_elements');

        $show_rating_score = isset($post_meta_elements['rating_score']) ? true : false;

        if( !get_post_meta( get_the_ID(), '_radium_post_score', true ) || !$show_rating_score ) return;

        //calculate average at base 10
        $score_total = radium_get_total_post_score();

        $score_total = ($score_total / 10);

        $output .= '<div class="entry-review">';
            $output .= '<div class="inner"><i class="icon-star"></i><span class="number">'. $score_total .'</span></div>';
        $output .= '</div>';

        return $output;

    }
    add_filter('radium_large_carousel_meta_before_image', 'radium_get_review_post_meta'); //add to large slider
    add_filter('radium_megamenu_post_grid_meta', 'radium_get_review_post_meta'); //add to large slider

}

/**
 * radium_review_score meta
 *
 * @return null
 */
if ( !function_exists('radium_review_post_meta') ) {

    function radium_review_post_meta() {

        echo radium_get_review_post_meta();

    }
    add_action('radium_after_post_meta', 'radium_review_post_meta');
    add_action('radium_after_post_tab_widget_post_meta', 'radium_review_post_meta');
    add_action('radium_post_grid_extras', 'radium_review_post_meta');

}
