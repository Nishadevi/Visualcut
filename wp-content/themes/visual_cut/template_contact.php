<?php
/*
  Template Name: Contact
 */
get_header();
?>
<main role="main" id="main">
    <?php
    $args = array('cat' => 14, 'post_type' => 'sliders', 'posts_per_page' => '1', 'order_by' => 'id', 'order' => 'ASC');
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

        </div>
        <?php wp_reset_postdata(); ?>
<?php endif; ?>
                <?php the_content(); ?>
            
        
</main>
<?php get_footer(); ?>
