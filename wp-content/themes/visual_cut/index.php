<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
get_header(); ?>
<main role="main" id="main">
<?php
$args = array('cat' => 15, 'post_type' => 'sliders', 'posts_per_page' => '-1', 'orderby' => 'menu_order', 'order' => 'ASC');
// the query
$the_query = new WP_Query($args);
?>
<?php if ($the_query->have_posts()) : ?>
    <!-- Slider Begin -->
     <div id="main-gallery" class="carousel slide gallery carousel-fade" data-ride="carousel" data-interval="false">
        <ol class="carousel-indicators">
           <?php  
           $slide_counter = 0;
           while ($the_query->have_posts()) : $the_query->the_post(); 
                
           ?>
            <li data-target="#main-gallery" data-slide-to="<?php echo $slide_counter; ?>" class="<?php if(($slide_counter+1) == 1){echo 'active';}?>"></li>
           
            <?php 
			$slide_counter++;
            endwhile; ?>
        </ol>
        <div class="carousel-inner">
                
            <?php
            $slide_counter = 1;
            while ($the_query->have_posts()) : $the_query->the_post();
                if ($slide_counter == "1") {
                    $active_slider = "active";
                } else {
                    $active_slider = "";
                }
                ?>
                <div class="item <?php echo $active_slider; ?>">
                    <div class="img-holder">
                <?php
                // $feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
                $feat_image = get_post_meta(get_the_ID(), 'wpcf-featured-image', true);
                $thum_image = get_post_meta(get_the_ID(), 'wpcf-thumbnail-image', false);
                $thumb_video_link = get_post_meta(get_the_ID(), 'wpcf-video-link', false);
                ?>
                    <img src="<?php echo $feat_image ?>" alt="">
                    <?php if(count($thum_image) > 0) {?>
                    <ul class="thumbnail-list">                    
	                  <?php foreach ($thum_image as $index => $value) { ?>
							 <li class="thumbnail">
							        <?php if($thumb_video_link[$index] != "" ) {?>
									 <a  id="lightvimeo" href="<?php if($thum_image[$index] !="") {echo $thumb_video_link[$index];} else { echo " ";};?>" class="btn-play iframe">	<?php }?>
									 	<?php if($thum_image[$index] !="") {?>
									 	<img src="<?php echo $thum_image[$index];?>" alt="image description">
									 	<?php } ?>
									 	 <?php if($thumb_video_link[$index] != "" ) {?>
									 </a>
									 <?php }?> 
							 </li> 
						<?php } ?>
					</ul>  
				<?php }?>
                </div>
                    <div class="carousel-caption">
		
                   <?php echo get_post_meta(get_the_ID(), 'wpcf-image-content', true); ?>
                
                </div>
                </div>
                    <?php
                    $slide_counter++;
                endwhile;
                ?>
        </div>
        <a class="left carousel-control" href="#main-gallery" role="button" data-slide="prev">
            <img src="<?php bloginfo('template_url'); ?>/images/l-arrow.svg" alt="image description">
        </a>
        <a class="right carousel-control" href="#main-gallery" role="button" data-slide="next">
            <img src="<?php bloginfo('template_url'); ?>/images/r-arrow.svg" alt="image description">
        </a>
    </div>
    <!-- Slider End -->
    <?php wp_reset_postdata(); ?>
<?php endif; ?>
        <section class="visual-block">
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        <h1>VISUAL <mark>CUT WILL POP YOUR EYE CHERRIES</mark></h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque fermentum purus ac tristique tincidunt. Pellentesque a urna id lectus bl&shy;andit rhoncus id eu elit. Praesent porttitor sagittis tincidunt. Nullam lacus enim, condimentum eu diam ac, sagittis sagittis nisi. Aliquam quam tortor, rhoncus sit amet odio quis, scelerisque posuere velit. Donec arcu orci, viverra a tempus eget, iaculis et est. Fusce ut risus malesua</p>
                    </div>
                    <div class="col-sm-3">
                        <a href="<?php do_shortcode('[link]') ?>/about" class="btn btn-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </section>
</main>
<?php get_footer(); ?>
<script>
jQuery(document).ready(function () {
	jQuery("#lightvimeo").fancybox({
		'padding'       : 0,
		  
		  'autoDimensions': false,
		  'width': 1280, // or your size
		  'height': 720,
		 
		  'type': 'iframe',
		  'swf': {
		    'wmode': 'transparent',
		    'allowfullscreen': 'true'
		  }
		 }); // fancybox
		 return false;
});
</script>