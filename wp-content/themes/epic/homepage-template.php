<?php
	/* Template Name: Home Page */
	get_header();
?>

<?php
	$al_options = get_option('al_general_settings'); 
	$slider = isset($al_options['al_active_slider']) && $al_options['al_active_slider'] !='' ? $al_options['al_active_slider'] : '';
	//$slider = isset($_GET['slider_type']) ? $_GET['slider_type'] : 'galleria';
	if ($slider)
	{
		get_template_part('sliders/'.$slider.'/slider');
	}
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	<?php $promo = get_post_meta($post->ID, "_promo", $single = false);?>
	<?php if(!empty($promo[0]) ):?>
        <div class="smallbar"></div>
        <div class="calloutcontainer">
            <div class="container_12">
                <div class="grid_12">            
                    <?php echo do_shortcode($promo[0]);?>
                </div>
            </div>
        </div>    
	<?php endif?>
    <!--Page Content-->
    <div class="pagecontents">
        <div class="container_12">       
            <?php the_content(); ?>
        </div>
    </div>
    <!--End Page Content-->
<?php endwhile; ?> 
     

<?php get_footer(); ?>		