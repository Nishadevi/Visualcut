<?php 
	$page_template_name = get_post_meta($post->ID,'_wp_page_template',true); 
	$al_options = get_option('al_general_settings');
	$cols = 4;
	$fadein =  isset($al_options['al_ba_fadein']) ? $al_options['al_ba_fadein'] : '1000';
	$fadeout =  isset($al_options['al_ba_fadeout']) ? $al_options['al_ba_fadeout'] : '3000';
	// Check which layout was selected
	switch($page_template_name)
	{
		case 'portfolio-template-2columns.php':
		$cols = 2;	
		break;
		
		case 'portfolio-template-3columns.php':
		$cols = 3;	
		break;
		
		case 'portfolio-template-4columns.php':
		$cols = 4;	
		break;

		case 'portfolio-template-2coltrad.php':
		$cols = 5;	
		break;
		
		case 'portfolio-template-3coltrad.php':
		$cols = 6;	
		break;
		
		case 'portfolio-template-galleria.php':
		$cols = 7;	
		break;
		
		case 'portfolio-template-sidebar.php':
		$cols = 8;	
		break;
		
	}
	$_SESSION['ptname'] = $page_template_name;
	$cats =  get_post_meta($post->ID, "_page_portfolio_cat", $single = true);
?>
<?php if ($cols == 5 || $cols == 6):?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()  ?>/js/jquery.quicksand.js"></script>
    <script type="text/javascript">
		jQuery(document).ready(function($){
			// Clone applications to get a second collection
			var $data = $(".portfolio-content").clone();
		
			//NOTE: Only filter on the main portfolio page, not on the subcategory pages
			$('.portfolio-main li').click(function(e) {
				$(".filter li").removeClass("active");	
				// Use the last category class as the category to filter by. This means that multiple categories are not supported (yet)
				var filterClass=$(this).attr('class');
				
				if (filterClass == 'all-projects') {
					var $filteredData = $data.find('.project');
				} else {
					//var $filteredData = $data.find('.project[data-type=' + filterClass + ']');
					var $filteredData = $data.find('div[data-type~=' + filterClass + ']');
				}
				$(".portfolio-content").quicksand($filteredData, 
					{
						duration: 800,
						easing: 'swing',
					},
					function() {
						hover_overlay();
						$("a[rel^='prettyPhoto']").prettyPhoto();
						jQuery('div.faded').hover(function() {
							var fade = jQuery('> div', this);
							if (fade.is(':animated')) {fade.stop().fadeTo(<?php echo $fadein?>, 1);} else {fade.fadeIn(<?php echo $fadein?>);}
						}, function () {
							var fade = jQuery('> div', this);
							if (fade.is(':animated')) {fade.stop().fadeTo(<?php echo $fadeout?>, 0);} else {fade.fadeOut(<?php echo $fadeout?>);}
						});
					}
				);		
				$(this).addClass("active"); 			
				return false;
			});
			
			// Before / after images animation
			jQuery('div.faded').hover(function() {
				var fade = jQuery('> div', this);
				if (fade.is(':animated')) {fade.stop().fadeTo(<?php echo $fadein?>, 1);} else {fade.fadeIn(<?php echo $fadein?>);}
			}, function () {
				var fade = jQuery('> div', this);
				if (fade.is(':animated')) {fade.stop().fadeTo(<?php echo $fadeout?>, 0);} else {fade.fadeOut(<?php echo $fadeout?>);}
			});
		});
    </script>
<?php endif?>

<?php $promo = get_post_meta($post->ID, "_promo", $single = false);?>
<?php if(!empty($promo[0]) ):?>
    <div class="smallbar top20"></div>
    <div class="calloutcontainer">
        <div class="container_12">
            <div class="grid_12">            
                <?php echo do_shortcode($promo[0]);?>
            </div>
        </div>
    </div>   
<?php endif?>
<div class="container_12">
	<div class="grid_12">
        <div class="clear"></div>
		<div class="pagetitle1">
            <h2>
				<?php 
                    $headline = get_post_meta($post->ID, "_headline", $single = false);
                    if(!empty($headline[0]) ){echo $headline[0];}
                    else{echo get_the_title();} 
                ?>
            </h2>
            <?php if(class_exists('the_breadcrumb') && $al_options['al_allow_breadcrumbs']){ $albc = new the_breadcrumb; } ?>
        </div>
        <div class="clearnospacing"></div>   
     	<div class="divider"></div>  
    </div>
</div>

<!--Page Content-->
<div class="pagecontents">
	<div class="container_12">
    	<div class="clearnospacing"></div>           
        
		<?php
			$_SESSION['epic_page_id'] = $pageId = get_page_ID_by_page_template($page_template_name);
			echo getPageContent($pageId); 
		?>
		
		<?php if ($cols == 8):?> <div class="grid_9"><?php else:?> <div class="grid_12"><?php endif?>
       
			<?php
            $loop = new WP_Query(array('post_type' => 'portfolio', 'posts_per_page' => 10)); 
            // If the number of items per page has been set
            if( get_post_meta($post->ID, "_page_portfolio_num_items_page", $single = true) != '' ) 
			{ 
                $items_per_page = get_post_meta($post->ID, "_page_portfolio_num_items_page", $single = false);
            } 
			else 
			{ // else don't paginate
                $items_per_page = 777;
            }
		
			// The selected categories to show
			$cats = get_post_meta($post->ID, "_page_portfolio_cat", $single = true);
			$args = array( 'taxonomy' => 'portfolio_category', 'hide_empty' => '0',  'include' => $cats);
			$categories = get_categories( $args ); 	
			?>		
            <!-- List categories if this options is allowed from admin panel. -->
           <?php if ($cols == 5 || $cols == 6):?>
               <ul class="portfolio-main filter"> 
                    <li class="active all-projects" >
                        <a href="" title="<?php _e('All categories', 'Epic')?>"><?php _e('All Categories', 'Epic')?></a>
                    </li> 
                    <?php 
						$cats = get_post_meta($post->ID, "_page_portfolio_cat", $single = true);
						$MyWalker = new PortfolioWalker();
						$args = array( 'taxonomy' => 'portfolio_category', 'hide_empty' => '0', 'include' => $cats, 'title_li'=> '', 'walker' => $MyWalker, 'show_count' => '1');
						$categories = wp_list_categories ($args);
					?>
                </ul>
                <div class="clear"></div>
            <?php endif?>
     
			<?php 
            if( $cats == '' ) 
			{
                echo '<div class="portfolio-content">
                <p>'. _e('No categories selected. To fix this, please login to your WP Admin area and set the categories you want 
                    to show by editing this page and setting one or more categories in the multi checkbox field "Portfolio Categories".', 'Epic').'
                    
                </p>
                </div>';
            } 
			else 
			{ 
                // If the user hasn't set a number of items per page, then use JavaScript filtering
                if( $items_per_page == 777 ) :
          	 	endif; 
            
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				//  query the posts in selected terms
                $portfolio_posts_to_query = get_objects_in_term( explode( ",", $cats ), 'portfolio_category');
                if (!empty($portfolio_posts_to_query)):
				
					$wp_query = new WP_Query( array( 'post_type' => 'portfolio', 'orderby' => 'menu_order', 'order' => 'ASC', 'post__in' => $portfolio_posts_to_query, 'paged' => $paged, 'showposts' => $items_per_page[0] ) ); 
					$counter = 1;
					?>
					<?php if ($wp_query->have_posts()): $col3counter=1;  $col4counter=1;  ?>
                    	<?php if ($cols == 5 || $cols == 6):?>
                        	<div class="portfolio-content section clearfix">
						<?php  endif?>
                        <?php if ($cols == 7):?>
                        	<div class="shadowgalleria"><div class="frame"><div id="galleria_large">
                        <?php endif?>
						<?php while ($wp_query->have_posts()) : 							
                            $wp_query->the_post();
                            $custom = get_post_custom($post->ID);
                            // Get the portfolio item categories
                            $cats = wp_get_object_terms($post->ID, 'portfolio_category');
							
                            // If no category was assigned, don't show the item
                            if ( $cats ) :
                                $cat_slugs = '';
                                foreach( $cats as $cat ) {$cat_slugs .= $cat->slug . " ";}
                               // $cat_slugs = substr($cat_slugs, 0, -1);
								endif;
                            ?>
							
							<?php if ($cols == 2): ?>
                            <div class="shadow400">
                                <div class="boxgrid400 peek">
                                    <?php the_post_thumbnail('portfolio-thumb-2cols', array('class' => 'cover')); ?>
                                    <h3><?php the_title(); ?></h3>
                                    <p><?php echo  limit_words(get_the_excerpt(), '18'); ?></p>
                                    <span>
                                        <?php if( !empty ( $custom['_portfolio_video'][0] ) ) : // Check if there's a video to be displayed in the lightbox when clicking the thumb ?>
                                            <a href="<?php echo $custom['_portfolio_video'][0]; ?>" class="zoom-icon video" title="<?php the_title(); ?>" rel="prettyPhoto"><?php _e('View Video', 'Epic')?></a>
                                        <?php elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : // User has set a custom destination link for this portfolio item ?>
                                            <a href="<?php echo $custom['_portfolio_link'][0]; ?>" title="<?php the_title(); ?>"><?php _e ('View website', 'Epic') ?></a>
                                        <?php elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : // View the project details ?>
                                            <a href="<?php the_permalink(); ?>"><?php _e ('View project', 'Epic') ?></a>     
                                        <?php else : // open image in original size in the pretty photo lightbox ?>
                                            <?php 
											$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); 
											$argsThumb = array(
												'order'          => 'ASC',
												'post_type'      => 'attachment',
												'post_parent'    => $post->ID,
												'post_mime_type' => 'image',
												'post_status'    => null,
												'exclude' => get_post_thumbnail_id()
											);
											?>
											<a href="<?php  echo $full_image[0]; ?>" class="zoom-icon" title="<?php the_title(); ?>" rel="prettyPhoto[ppgal<?php echo $post->ID?>]"><?php _e ('View zoomed', 'Epic') ?></a>     
												
											<?php 
												$attachments = get_posts($argsThumb);
												 
												if ($attachments) {
													foreach ($attachments as $attachment) {
														echo '<a href="'.wp_get_attachment_url($attachment->ID, 'full', false, false).'" class="invisible" rel="prettyPhoto[ppgal'.$post->ID.']" title="'.get_the_title($post->ID).'"></a>';
													}
												}
											?>
                                            
                                        <?php endif; ?>
                                        
                                    </span>
                                </div>
                            </div>
                            <?php elseif ($cols == 3 || $cols == 8):  ?>
                                <div class="shadow300">
                                    <div class="boxgrid300 <?php if ($col3counter%2==0):?>slidedown<?php else:?>slideright<?php endif?>">
                                        <?php the_post_thumbnail('portfolio-thumb-3cols', array('class' => 'cover')); ?>
                                        <h3><?php the_title(); ?></h3>
                                        <p><?php echo  limit_words(get_the_excerpt(), '18'); ?></p>
                                        <span>
                                            <?php if( !empty ( $custom['_portfolio_video'][0] ) ) : // Check if there's a video to be displayed in the lightbox when clicking the thumb ?>
                                                <a href="<?php echo $custom['_portfolio_video'][0]; ?>" class="zoom-icon video" title="<?php the_title(); ?>" rel="prettyPhoto"><?php _e('View Video', 'Epic')?></a>
                                            <?php elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : // User has set a custom destination link for this portfolio item ?>
                                                <a href="<?php echo $custom['_portfolio_link'][0]; ?>" title="<?php the_title(); ?>"><?php _e ('View website', 'Epic') ?></a>
                                            <?php elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : // View the project details ?>
                                                <a href="<?php the_permalink(); ?>"><?php _e ('View project', 'Epic') ?></a>
                                            <?php else : // open image in original size in the pretty photo lightbox ?>
                                            <?php 
											$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); 
											$argsThumb = array(
												'order'          => 'ASC',
												'post_type'      => 'attachment',
												'post_parent'    => $post->ID,
												'post_mime_type' => 'image',
												'post_status'    => null,
												'exclude' => get_post_thumbnail_id()
											);
											?>
											<a href="<?php  echo $full_image[0]; ?>" class="zoom-icon" title="<?php the_title(); ?>" rel="prettyPhoto[ppgal<?php echo $post->ID?>]"><?php _e ('View zoomed', 'Epic') ?></a>     
												
											<?php 
												$attachments = get_posts($argsThumb);
												 
												if ($attachments) {
													foreach ($attachments as $attachment) {
														echo '<a href="'.wp_get_attachment_url($attachment->ID, 'full', false, false).'" class="invisible" rel="prettyPhoto[ppgal'.$post->ID.']" title="'.get_the_title($post->ID).'"></a>';
													}
												}
											?>
                                            <?php endif; ?>
                                             
                                        </span>
                                    </div>
                                </div>
                            <?php elseif ($cols == 4):  ?>
                                <div class="shadow200">
                                    <div class="boxgrid <?php if ($col4counter%2==0):?>slidedown<?php else:?>slideright<?php endif?>">
                                        <?php the_post_thumbnail('portfolio-thumb-4cols', array('class' => 'cover')); ?>
                                        <h3><?php the_title(); ?></h3>
                                        <p><?php echo  limit_words(get_the_excerpt(), '18'); ?></p>
                                        <span>
                                            <?php if( !empty ( $custom['_portfolio_video'][0] ) ) : // Check if there's a video to be displayed in the lightbox when clicking the thumb ?></a>
                                                <a href="<?php echo $custom['_portfolio_video'][0]; ?>" class="zoom-icon video" title="<?php the_title(); ?>" rel="prettyPhoto"><?php _e('View Video','Epic')?></a>
                                            <?php elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : // User has set a custom destination link for this portfolio item ?>
                                                <a href="<?php echo $custom['_portfolio_link'][0]; ?>" title="<?php the_title(); ?>"><?php _e ('View website', 'Epic') ?></a>
                                            <?php elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : // View the project details ?>
                                                <a href="<?php the_permalink(); ?>"><?php _e ('View project', 'Epic') ?></a>
												<?php 
												$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); 
												$argsThumb = array(
													'order'          => 'ASC',
													'post_type'      => 'attachment',
													'post_parent'    => $post->ID,
													'post_mime_type' => 'image',
													'post_status'    => null,
													'exclude' => get_post_thumbnail_id()
												);
												?>
												<a href="<?php  echo $full_image[0]; ?>" class="zoom-icon" title="<?php the_title(); ?>" rel="prettyPhoto[ppgal<?php echo $post->ID?>]"><?php _e ('View zoomed', 'Epic') ?></a>     
													
												<?php 
													$attachments = get_posts($argsThumb);
													 
													if ($attachments) {
														foreach ($attachments as $attachment) {
															echo '<a href="'.wp_get_attachment_url($attachment->ID, 'full', false, false).'" class="invisible" rel="prettyPhoto[ppgal'.$post->ID.']" title="'.get_the_title($post->ID).'"></a>';
														}
													}
												?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </div>  
                            <?php elseif ($cols == 5 || $cols == 6): $columns =  $cols == 5 ? '2' : '3'; $cs = 'portfolio-thumb-'.$columns.'cols';	?>
                               	<div data-id="post-<?php echo $counter ?>" data-type="<?php echo $cat_slugs?>" class="pft2col<?php echo $cols == 6 ? '2' : ''?> post-<?php echo $counter ?> project" > 
                                    <div class="portshadow<?php echo $cols == 5 ? '400' : '300' ?>">
                                        
										<?php 
										$link = '';
										$inLightbox = 0;
										$before_image = get_post_meta($post->ID,'_before_image',true);
																
										if ($before_image):
											$after_image = get_post_meta($post->ID,'_after_image',true);
											$beforesize = (empty($before_image)) ? '' : getimagesize($before_image);
											$aftersize = (empty($after_image)) ? '' : getimagesize($after_image);
											
											if ($beforesize && $aftersize && $beforesize[0] == $aftersize[0] && $beforesize[1] == $aftersize[1]): ?>	
												<div class="ba-container" style="height:437px">	
													<div class="faded"><img src="<?php echo $before_image ?>" alt="" class="frame" /><div><img src="<?php echo $after_image ?>" alt="" class="frame" /></div></div>
												</div>
											<?php else:?>
												<div class="ba-error">Before and after images dimensions are not equal or one of the images is not set. <br /> Please upload equal images with 440x400 pixels dimensions 
												from admin panel and refresh this page.</p>
											<?php endif?>
										<?php else:?>
											<div class="hover">
												<span>
													<?php 
														if( !empty ( $custom['_portfolio_video'][0] ) ) : $link = $custom['_portfolio_video'][0]; 	$inLightbox = 1; // Check if there's a video to be displayed in the lightbox when clicking the thumb ?>
														<a href="<?php echo $link; ?>" title="<?php the_title(); ?>" rel="prettyPhoto">
															<?php the_post_thumbnail($cs, array('class' => 'frame')); ?>
														</a>
													<?php elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : 
														$link = $custom['_portfolio_link'][0]; 	$inLightbox = 0; // User has set a custom destination link for this portfolio item ?>
														<a href="<?php echo $link; ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail($cs, array('class' => 'frame')); ?></a>
													<?php elseif(isset( $custom['_portfolio_no_lightbox'])  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : 
														$link = get_permalink();
														$inLightbox = 0;
														// View the project details ?>
														<a href="<?php echo $link ?>"><?php the_post_thumbnail($cs, array('class' => 'frame')); ?></a>
													<?php else : // open image in original size in the pretty photo lightbox ?>
														<?php 
															$inLightbox = 1;
															$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); 
															$link =  $full_image[0];
															$argsThumb = array(
																'order'          => 'ASC',
																'post_type'      => 'attachment',
																'post_parent'    => $post->ID,
																'post_mime_type' => 'image',
																'post_status'    => null,
																'exclude' => get_post_thumbnail_id()
															);
														?>
														<a href="<?php  echo $full_image[0]; ?>" class="zoom-icon" title="<?php the_title(); ?>" rel="prettyPhoto[ppgal<?php echo $post->ID?>]">
															<?php the_post_thumbnail($cs, array('class' => 'frame')); ?>
														</a>     
															
														<?php 
															$attachments = get_posts($argsThumb);
															 
															if ($attachments) {
																foreach ($attachments as $attachment) {
																	echo '<a href="'.wp_get_attachment_url($attachment->ID, 'full', false, false).'" class="invisible" rel="prettyPhoto[ppgal'.$post->ID.']" title="'.get_the_title($post->ID).'"></a>';
																}
															}
														?>
													<?php endif; ?>
												</span>
											</div>
										<?php endif?>
                                    </div>
                                    <h4><?php the_title(); ?></h4>
                                    <p><?php echo  limit_words(get_the_excerpt(), '18'); ?></p>
                                    <div>
										<?php if($before_image):?>
											<a href="<?php echo $before_image?>" class="button normal small" rel="prettyPhoto[ppgalba]"><?php _e ('Details', 'Epic') ?></a>
											<?php if($after_image):?><a href="<?php echo $after_image?>" class="invisible" rel="prettyPhoto[ppgalba]"></a><?php endif?>
										<?php else:?>
											<a href="<?php echo $link ?>" class="button normal small" <?php if ($inLightbox ==1):?>rel="prettyPhoto"<?php endif?>><?php _e ('Details', 'Epic') ?></a>
										<?php endif?>
									</div>
                                </div> 
                        	<?php elseif ($cols == 7):?>
								<a href="<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); echo $full_image[0]; ?>">
                                	<img src="" title="" alt="<?php echo get_the_title()?>"/>
                                </a> 
                            <?php endif; ?> 
                     
					 <?php if ($cols == 6 && $counter %3 == 0):?>
                        <div class="clearnospacing"></div>
                    <?php endif?>        	
					<?php $counter++; $col3counter++;  $col4counter++; endwhile;   ?>	 
                    <?php  endif; ?> 
                   	 <?php if ($cols == 5 || $cols == 6):?>
                        	</div>
                    <?php  endif?>
                       
                        <?php if ($cols == 7):?>
                        	</div></div></div>
                            <script type="text/javascript">
								// Load the classic theme
								//Galleria.loadTheme('<?php echo get_template_directory_uri() ?>/js/galleria.classic.min.js');
								// Initialize Galleria
								jQuery('#galleria_large').galleria({
							  		extend: function( options ) {
										var info = this.$('info');
										this.bind( 'loadfinish', function(e) {
								  		info.hide().fadeIn( options.transitionSpeed );
										});
							  		}
								});
							</script>
                        <?php endif?>                      				 					                  
				<?php endif ?>
            	<div class="clear"></div>
				<?php
                // If the user has set a number of items per page, then display pagination
				if( $items_per_page != 777 ) 
				{
					include(Epic_PLUGINS . '/wp-pagenavi.php' );
					if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
				} 
			} ?>
			<div class="clear"></div> 
			

         </div>
         <?php if ($cols == 8):?>
            <div class="grid_3 sidebarright alignright">
                <?php generated_dynamic_sidebar() ?>
            </div> 
            <div class="clear"></div>
        <?php endif?> 
	</div>
</div>