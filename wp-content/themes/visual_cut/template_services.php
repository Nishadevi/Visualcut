<?php
/*
  Template Name: Services
 */
get_header();
?>
<main role="main" id="main">

    <?php
    $args = array('cat' => 17, 'post_type' => 'sliders', 'posts_per_page' => '-1', 'order_by' => 'id', 'order' => 'ASC');
// the query
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) :
        ?>
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
    <div class="container">
        <div id="content" class="services">
            <div class="block">
               
                    <?php
                    $args = array('post_type' => 'photography', 'posts_per_page' => '2', 'order_by' => 'id', 'order' => 'ASC');
// the query
                    $query = new WP_Query($args);
                    if ($query->have_posts()) :
                         while ($query->have_posts()) : $query->the_post();
                        ?>
                    
                       <div class="header">
                           <h1><span class="icon">A</span><?php the_title(); ?></h1>
                     </div>
                    <div class="holder">
                        <?php the_content(); ?>
                    </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
<?php endif; ?>
                
            </div>
            <div class="block">
               
                    <?php
                    $args = array('post_type' => 'videos', 'posts_per_page' => '2', 'order_by' => 'id', 'order' => 'ASC');
// the query
                    $query1 = new WP_Query($args);
                    if ($query1->have_posts()) :
                         while ($query1->have_posts()) : $query1->the_post();
                        ?>
                    
                       <div class="header">
                           <h1><span class="icon">H</span><?php the_title(); ?></h1>
                       </div>
                    <div class="holder">
                        <?php the_content(); ?>
                    </div>
                    <?php endwhile; ?>
<?php endif; ?>
                </div>
            </div>
        </div>
    
</main>
<?php get_footer(); ?>
