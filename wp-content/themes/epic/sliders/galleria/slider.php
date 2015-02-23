<?php
$al_options = get_option('al_general_settings'); 
$loop = new WP_Query( array( 'post_type' => 'slider', 'posts_per_page' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
?>

<div class="backgroundgradient">
             
    <div id="galleria">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <?php	
            $custom = get_post_custom($post->ID);			
            $slideUrl = $custom["slide_url"][0];
            $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); 
            ?>
        
            <?php if ($slideUrl!=''):?>
            	<img src="<?php echo $full_image[0]?>" title="<?php echo  get_the_title() ?>" rel="<?php echo $slideUrl ?>" alt="<?php echo  get_the_content() ?>" />
          	<?php else:?>
            	<img src="<?php echo $full_image[0]?>" title="<?php echo  get_the_title() ?>"  alt="<?php echo  get_the_content() ?>" />
            <?php endif?>
          
         <?php endwhile; ?>         
    </div>
    <div class="clearnospacing"></div>
</div>

<!--Galleria-->
<script type='text/javascript'>
    Galleria.loadTheme('<?php echo  get_template_directory_uri() ?>/js/galleria.classic.min.js');
    // Initialize Galleria
    jQuery('#galleria').galleria({
		autoplay: <?php echo isset($al_options['galleria_autoplay']) ? $al_options['galleria_autoplay'] : '5000' ?>,  
		transition:  '<?php echo isset($al_options['galleria_transition']) ? $al_options['galleria_transition'] : 'fade' ?>',  
		transitionSpeed: <?php echo isset($al_options['galleria_transition_speed']) ? $al_options['galleria_transition_speed'] : '400' ?>,
  		dataSelector: "img",
		imageCrop:true,
		debug:false,
		responsive:true,
		dataConfig: function(img) {
			return {link:  jQuery(img).attr('rel') }
		},
		extend: function( options ) {
			var info = this.jQuery('info');
			
			this.bind( 'loadfinish', function(e) {
				info.hide().fadeIn( options.transitionSpeed );
			});			
		}
	});
</script>