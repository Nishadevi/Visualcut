<?php

$al_options = get_option('al_general_settings'); 
$loop = new WP_Query( array( 'post_type' => 'slider', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('#coda-slider-1').codaSlider(
		{
			slideEaseFunction: "<?php echo isset($al_options['coda_sliding_effect']) ? $al_options['coda_sliding_effect'] : 'easeInOutExpo' ?>", 
			slideEaseDuration: <?php echo isset($al_options['coda_cycleSpeed']) ? $al_options['coda_cycleSpeed'] : '1000' ?>, 
			autoSlide: <?php echo isset($al_options['coda_autoslide']) ? $al_options['coda_autoslide'] : 'true' ?>, 
			autoSlideInterval: <?php echo isset($al_options['coda_slide_timeout']) ? $al_options['coda_slide_timeout'] : '6000' ?> 			
		});
	});
</script>
<div class="backgroundgradient4">
	<div class="container_12">
        <div class="coda-slider-wrapper">
            <div class="coda-slider preload" id="coda-slider-1">            
                <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <div class="panel">
                        <div class="panel-wrapper">
                           <?php the_content() ?>
                        </div>
                    </div>   
                <?php endwhile ?> 
        
            </div><!-- .coda-slider -->
        </div><!-- .coda-slider-wrapper -->
	</div>
</div>
<!--End Video Section-->

<div class="clearnospacing"></div>
