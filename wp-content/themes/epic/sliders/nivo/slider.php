<?php

$al_options = get_option('al_general_settings'); 
$loop = new WP_Query( array( 'post_type' => 'slider', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
?>

<script type="text/javascript">
	  jQuery(window).load(function() {
        jQuery('#slider').nivoSlider({
        	effect:'<?php echo $al_options['nivo_effect']?>',
        	slices:<?php echo $al_options['nivo_slices']?>,
        	animSpeed:<?php echo $al_options['nivo_speed']?>,
        	pauseTime:<?php echo $al_options['nivo_pause']?>,
        	directionNav:<?php echo $al_options['nivo_direction']?>,
        	controlNav:<?php echo $al_options['nivo_controlnav']?>,
        	keyboardNav:<?php echo $al_options['nivo_keynav']?>
        });
    });
</script>
<div class="backgroundgradient2">

    <div class="container_12">
        <div id="slider" class="nivoSlider nivoframe">
        
            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<?php	
				$custom = get_post_custom($post->ID);
				$link = $custom['slide_url'][0];
				$image_id = get_post_thumbnail_id();  
				$image_url = wp_get_attachment_image_src($image_id,'full'); 
			?>
			<a href="<?php echo $link ?>">
            	<img src="<?php echo $image_url[0]?>" alt="" title="<?php the_title()?>"  />
            </a>		
            <?php endwhile; ?>    
        </div>
     </div>
            
    <div class="clearnospacing"></div>
</div>