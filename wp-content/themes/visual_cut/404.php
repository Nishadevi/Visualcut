<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
<main role="main" id="main">
    <?php
$args = array('cat' => 8, 'post_type' => 'sliders', 'posts_per_page' => '-1', 'order_by' => 'id', 'order' => 'ASC');
// the query
$the_query = new WP_Query($args);
 if ($the_query->have_posts()) : ?>
   <div class="intro">
            <?php
            $slide_counter = 1;
            while ($the_query->have_posts()) : $the_query->the_post();
                if ($slide_counter == "1") {
                    $active_slider = "active";
                } else {
                    $active_slider = "";
                }
                ?>
                
                <?php
                // $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                $feat_image = get_post_meta(get_the_ID(), 'wpcf-featured-image', true);
                ?>
                    <img src="<?php echo $feat_image ?>" alt="">
               
                    <?php
                    $slide_counter++;
                endwhile;
                ?>
                    
   </div>
            <?php wp_reset_postdata(); ?>
<?php endif; ?>
	<div class="container">
				<div id="content">

			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Not Found', 'twentythirteen' ); ?></h1>
			</header>

			<div class="page-wrapper">
				<div class="page-content">
					<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'twentythirteen' ); ?></h2>
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentythirteen' ); ?></p>

					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</div><!-- .page-wrapper -->

		</div><!-- #content -->
	</div><!-- #primary -->
</main>
<?php get_footer(); ?>