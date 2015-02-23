<?php $al_options = get_option('al_general_settings'); ?>

<!--Video Section -->
<div class="backgroundgradient4">
	<div class="container_12">    	
		<?php $static = $al_options['al_static_content'] ?>
        <?php if (isset($static) && $static != ''): ?>
            <?php echo do_shortcode($static)?> 
        <?php endif ?>        
	</div>
</div>
<!--End Video Section-->