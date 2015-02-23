<?php
/*
  Template Name: Photo Projects
 */
get_header(); 
?>
<main role="main" id="main">
			<?php
$args = array('cat' => 20, 'post_type' => 'sliders', 'posts_per_page' => '-1', 'order_by' => 'id', 'order' => 'ASC');
// the query
$the_query = new WP_Query($args);
?>
<?php if ($the_query->have_posts()) : ?>
    <!-- Slider Begin -->
     <div id="main-gallery" class="carousel slide gallery carousel-fade" data-ride="carousel" data-interval="false">
        <div class="carousel-inner">
                
            <?php
            $slide_counter = 1;
            while ($the_query->have_posts()) : $the_query->the_post();
            $count=0;
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
                $thumb = get_post_meta(get_the_ID(), 'wpcf-thumbnail-image', FALSE);
                
                ?>
                    <img src="<?php echo $feat_image ?>" alt="">
                   <ul class="thumbnail-list">
                        <?php if ($thumb[0] != '') :
                             foreach($thumb as $thumbs) { ?>
                                <li class="thumbnail">
                                    <a href="<?php echo $thumbs; ?>" data-rel="gallery1" class="lightbox">
                                        <img src="<?php echo $thumbs; ?>" alt="image description">
                                    </a>
                                </li>
                          <?php   } 
                        endif;
?>
                        
                    </ul>
                </div>
                    <div class="visual-block">
			<div class="container">
                            <div class="row">
				<div class="col-sm-10">
                                    <?php the_content(); ?>
                                </div>
                            </div>
			</div>
                    </div>
                    <div class="carousel-caption">
                        <div class="holder">
                            <?php echo get_post_meta(get_the_ID(), 'wpcf-image-content', true); ?>
                        </div>
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
    
		</main>
<?php get_footer(); ?>
