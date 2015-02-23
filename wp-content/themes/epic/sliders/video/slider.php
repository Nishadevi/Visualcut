<?php $al_options = get_option('al_general_settings'); ?>

<!--Video Section -->
<div class="backgroundgradient3">
	<div class="container_12">
    	<div class="homevideo">
        	<?php $videoId = $al_options['al_video_id'] ?>
    		<?php if (isset($videoId) && $videoId != ''): ?>
            	<iframe src="http://player.vimeo.com/video/<?php echo $videoId ?>?title=0&amp; byline=0&amp; portrait=0&amp; autoplay=1&amp; color=00adef" width="920" height="520"></iframe>
    		<?php else: ?>
            	<p>
                	You have chosen a static video but haven't provided an Id. Please go to Epic => General Settings => Homepage tab on your admin
                	panel and set a video id.
                </p>
            <?php endif ?>
        </div>
	</div>
</div>
<!--End Video Section-->