<?php /* Template Name: Portfolio (Before/after images) */
get_header();

$al_options = get_option('al_general_settings');
$_SESSION['ptname'] = 'portfolio-template-ba.php';
$_SESSION['epic_page_id'] = $pageId = get_page_ID_by_page_template('portfolio-template-ba.php');

$cats =  get_post_meta($post->ID, "_page_portfolio_cat", $single = true);
$animated = 1;
$maxwidth = isset($al_options['al_ba_maxwidth']) ? $al_options['al_ba_maxwidth'] : '940';
$fadein =  isset($al_options['al_ba_fadein']) ? $al_options['al_ba_fadein'] : '1000';
$fadeout =  isset($al_options['al_ba_fadeout']) ? $al_options['al_ba_fadeout'] : '3000';
if ($animated == 1):
?>
	<style type="text/css">.faded img{max-width:<?php echo $maxwidth?>px}</style>
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
					var $filteredData = $data.find('.ba-item');
				} else {
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
			<h2 style="margin-top:15px">
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
		<div class="grid_12">
			<?php echo getPageContent($pageId); ?>
		</div>
		<div class="grid_12">
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
           <?php if ($animated == 1):?>
               <ul class="portfolio-main filter" style="margin-left:-30px"> 
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
					if ($wp_query->have_posts()): $colcounter=1;  ?>
						<div class="portfolio-content section clearfix">				
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
                           
								$before_image = get_post_meta($post->ID,'_before_image',true); 
								$after_image = get_post_meta($post->ID,'_after_image',true);
								$beforesize = (empty($before_image)) ? '' : getimagesize($before_image);
								$aftersize = (empty($after_image)) ? '' : getimagesize($after_image);
								$beforewidth = '';
								$beforeheight = '';
								if ($beforesize && $aftersize)
								{
									$beforewidth = $beforesize [0];
									$beforeheight = $beforesize [1];
									if ($beforewidth > $maxwidth)
									{
										$beforeheight =  $beforeheight * $maxwidth /$beforewidth; 
										$beforewidth = $maxwidth;
									}	
								}
								?>
								<div class="ba-item" data-id="post-<?php echo $colcounter ?>" data-type="<?php echo $cat_slugs?>" style="width:<?php echo $beforewidth?>px">
									<?php if ($beforesize[0] == $aftersize[0] && $beforesize[1] == $aftersize[1]): ?>	
										<div class="ba-container" style="height:<?php echo $beforeheight?>px">	
											<div class="faded"><img src="<?php echo $before_image ?>" alt="" /><div><img src="<?php echo $after_image ?>" alt="" /></div></div>
										</div>
									<?php else:?>
										<p class="error">Before and after images dimensions are not equal or one of the images is not set. <br /> Please upload equal ones 
										from admin panel and refresh this page.</p>
									<?php endif?>
									<div class="ba-info">
										<h3><?php the_title(); ?></h3>
										<p><?php echo get_the_excerpt(); ?></p>
									</div>
								</div>
							<?php $colcounter++; endwhile;   ?>
						</div>	
						
                    <?php  endif; ?> 
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
	</div>
</div>

<?php get_footer() ?>