<?php get_header();

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			
$wp_query = new WP_Query(array( 'taxonomy' => 'portfolio_category', 'term' => $term->name, 'post_type' => 'portfolio', 'paged'=>$paged ));


//$page_template_name = get_post_meta($post->ID,'_wp_page_template',true); 
$al_options = get_option('al_general_settings');
$cols = 4;
	
?>
<script type="text/javascript" src="<?php echo get_template_directory_uri()  ?>/js/filterable.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("a[rel^='prettyPhoto']").prettyPhoto({theme: 'dark_square'});
		jQuery('#portfolio-list').filterable();
	
		var $portfolioItem = jQuery('#portfolio-list li');
		jQuery('.zoom-icon, .more-icon').css('opacity','0.1');
		
		$portfolioItem.hover(function(){			
			jQuery(this).find('.zoom-icon, .more-icon').stop(true, true).animate({opacity: 0.9},400);
		}, function(){
			jQuery(this).find('.zoom-icon, .more-icon').stop(true, true).animate({opacity: 0.1},400);		
		});
	});		
</script>



<div id="container">
   <div id="title-container">
   		<h2 class="top-title"><span><?php echo $term ->name ?></span></h2>
		<?php if(class_exists('the_breadcrumb') && $al_options['al_allow_breadcrumbs']){ $albc = new the_breadcrumb; } ?>
	</div>
	<ul id="portfolio-list" class="cols-<?php echo $cols?>"><?php
		if ($wp_query->have_posts()):
			$counter = 1;
			while ($wp_query->have_posts()) : $wp_query->the_post();
				
				$custom = get_post_custom($post->ID);
			   
				// Get the portfolio item categories
				$cats = wp_get_object_terms($post->ID, 'portfolio_category');
			
				// If no category was assigned, don't show the item
				if ( $cats ) :
					$cat_slugs = '';
					foreach( $cats as $cat ) {
						$cat_slugs .= $cat->slug . ",";
					}
					$cat_slugs = substr($cat_slugs, 0, -1);
				?>
                
				<li class="<?php echo $cat_slugs; ?> <?php if($counter>0 && $counter%$cols==0):?>edge<?php endif?> all">
					<div>
						<?php the_post_thumbnail('portfolio-thumb-'.$cols.'cols', array('class' => 'portfolio')); ?>
					</div>
					<div class="poverlay">
						<h4>       
							<a href="<?php echo !empty( $custom['_portfolio_link'][0] ) ? $custom['_portfolio_link'][0] : the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h4>
						<div class="tworowlimit bottom20"><?php echo  limit_words(get_the_excerpt(), '18'); ?></div>
					 
						<?php if( !empty ( $custom['_portfolio_video'][0] ) ) : // Check if there's a video to be displayed in the lightbox when clicking the thumb ?>
							<a href="<?php echo $custom['_portfolio_video'][0]; ?>" class="zoom-icon video" title="<?php the_title(); ?>" rel="prettyPhoto">
						<?php elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : // User has set a custom destination link for this portfolio item ?>
							<a href="<?php echo $custom['_portfolio_link'][0]; ?>" class="more-icon " title="<?php the_title(); ?>">
						<?php else : // open image in original size in the pretty photo lightbox ?>
							<a href="<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); echo $full_image[0]; ?>" class="zoom-icon" title="<?php the_title(); ?>" rel="prettyPhoto">
						<?php endif; ?>
						</a>     
					  
						<p class="center">
							<a href="<?php echo !empty( $custom['_portfolio_link'][0] ) ? $custom['_portfolio_link'][0] : the_permalink(); ?>" class="button center ">Read More</a>
						</p>
					</div>
						
				</li>
			<?php endif; ?> 
			<?php $counter++; endwhile; ?>
		 <?php endif; ?> 
	</ul> 
	<div class="clear"></div>

	<?php get_footer(); ?>
