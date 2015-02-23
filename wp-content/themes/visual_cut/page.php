<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<main role="main" id="main">
				<?php
$args = array('cat' => 14, 'post_type' => 'sliders', 'posts_per_page' => '-1', 'order_by' => 'id', 'order' => 'ASC');
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
                    <?php wp_reset_postdata(); ?>
<?php endif; ?>
   </div>
			<section class="visual-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        <h1><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </section>
		</main>
<?php get_footer(); ?>
				
			<?php endwhile; ?>
<?php get_footer(); ?>
