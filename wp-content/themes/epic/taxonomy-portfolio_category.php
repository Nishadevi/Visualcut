<?php get_header();
	global $paged;
 	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $paged = (get_query_var('page')) ? get_query_var('page') : 1; 
	$metas = $wpdb->get_results("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '_page_portfolio_num_items_page'");
	$items_per_page = /*$metas[0]->meta_value == '' ? 777 : $metas[0]->meta_value*/ 777;	
	
	global $wp_query;
	$temp = $wp_query;   $wp_query= null;
	$wp_query = new WP_Query(array( 'taxonomy' => 'portfolio_category', 'term' => $term->name, 'post_type' => 'portfolio', 'paged'=>$paged, 'showposts'=> $items_per_page));
	
	$page_template_name = $_SESSION['ptname'];
	$al_options = get_option('al_general_settings');
	$cols = 4;
	
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
?>
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
            <h2><?php echo $term->name;?> </h2>
            <?php if(class_exists('the_breadcrumb') && $al_options['al_allow_breadcrumbs']){ $albc = new the_breadcrumb; } ?>
        </div>
        <div class="clearnospacing"></div>   
     	<div class="divider"></div>  
    </div>
</div>
	     
<?php 
    // The selected categories to show
   	$args = array('type' => 'post', 'hide_empty' => 0,'hierarchical' => 1,'taxonomy' => 'portfolio_category', 'pad_counts'=> false );
    $categories = get_categories( $args );
?>		
    <!-- List categories if this options is allowed from admin panel. -->
   	
    <!-- Portfolio navigation bar -->
<!--Page Content-->
<div class="pagecontents">
	<div class="container_12">
    	<div class="clearnospacing"></div>           
        <?php if ($cols == 8):?> <div class="grid_9"><?php else:?> <div class="grid_12"><?php endif?>
			<?php if ($wp_query->have_posts()):  $counter = 1; $col3counter=1;  $col4counter=1;  ?>
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
                            foreach( $cats as $cat ) {$cat_slugs .= $cat->slug . ",";}
                            $cat_slugs = substr($cat_slugs, 0, -1);
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
                                        <a href="<?php echo $custom['_portfolio_video'][0]; ?>" class="zoom-icon video" title="<?php the_title(); ?>" rel="prettyPhoto">View Video
                                    <?php elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : // User has set a custom destination link for this portfolio item ?>
                                        <a href="<?php echo $custom['_portfolio_link'][0]; ?>" title="<?php the_title(); ?>"><?php _e ('View website', 'Epic') ?>
                                    <?php elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : // View the project details ?>
                                        <a href="<?php the_permalink(); ?>"><?php _e ('View project', 'Epic') ?>
                                    <?php else : // open image in original size in the pretty photo lightbox ?>
                                        <a href="<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); echo $full_image[0]; ?>" class="zoom-icon" title="<?php the_title(); ?>" rel="prettyPhoto">
                                        <?php _e ('View zoomed', 'Epic') ?>
                                    <?php endif; ?>
                                    </a>     
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
                                            <a href="<?php echo $custom['_portfolio_video'][0]; ?>" class="zoom-icon video" title="<?php the_title(); ?>" rel="prettyPhoto">View Video
                                        <?php elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : // User has set a custom destination link for this portfolio item ?>
                                            <a href="<?php echo $custom['_portfolio_link'][0]; ?>" title="<?php the_title(); ?>"><?php _e ('View website', 'Epic') ?>
                                        <?php elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : // View the project details ?>
                                            <a href="<?php the_permalink(); ?>"><?php _e ('View project', 'Epic') ?>
                                        <?php else : // open image in original size in the pretty photo lightbox ?>
                                            <a href="<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); echo $full_image[0]; ?>" class="zoom-icon" title="<?php the_title(); ?>" rel="prettyPhoto">
                                            <?php _e ('View zoomed', 'Epic') ?>
                                        <?php endif; ?>
                                        </a>     
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
                                        <?php if( !empty ( $custom['_portfolio_video'][0] ) ) : // Check if there's a video to be displayed in the lightbox when clicking the thumb ?>
                                            <a href="<?php echo $custom['_portfolio_video'][0]; ?>" class="zoom-icon video" title="<?php the_title(); ?>" rel="prettyPhoto">View Video
                                        <?php elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : // User has set a custom destination link for this portfolio item ?>
                                            <a href="<?php echo $custom['_portfolio_link'][0]; ?>" title="<?php the_title(); ?>"><?php _e ('View website', 'Epic') ?>
                                        <?php elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : // View the project details ?>
                                            <a href="<?php the_permalink(); ?>"><?php _e ('View project', 'Epic') ?>
                                        <?php else : // open image in original size in the pretty photo lightbox ?>
                                            <a href="<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); echo $full_image[0]; ?>" class="zoom-icon" title="<?php the_title(); ?>" rel="prettyPhoto">
                                            <?php _e ('View zoomed', 'Epic') ?>
                                        <?php endif; ?>
                                        </a>     
                                    </span>
                                </div>
                            </div>  
                        <?php elseif ($cols == 5 || $cols == 6):?>
                            <div data-id="post-<?php echo $counter ?>" data-type="<?php echo $cat_slugs?>" class="pft2col<?php echo $cols == 6 ? '2' : ''?> post-<?php echo $counter ?> <?php echo $cat_slugs?> project" > 
                                <div class="portshadow<?php echo $cols == 5 ? '400' : '300' ?>">
                                    <div class="hover">
                                        <span>
                                            <?php if( !empty ( $custom['_portfolio_video'][0] ) ) : // Check if there's a video to be displayed in the lightbox when clicking the thumb ?>
                                                <a href="<?php echo $custom['_portfolio_video'][0]; ?>" title="<?php the_title(); ?>" rel="prettyPhoto">
                                            <?php elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : // View the project details ?>
                                                <a href="<?php the_permalink(); ?>">
                                            <?php else : // open image in original size in the pretty photo lightbox ?>
                                                <a href="<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); echo $full_image[0]; ?>" title="<?php the_title(); ?>" rel="prettyPhoto">
                                            <?php endif; ?>
                                                 <?php $columns =  $cols == 5 ? '2' : '3'; $cs = 'portfolio-thumb-'.$columns.'cols' ?>	
                                                 <?php the_post_thumbnail($cs, array('class' => 'frame')); ?>
                                            </a>     
                                        </span>
                                    </div>
                                </div>
                                <h4><?php the_title(); ?></h4>
                                <p><?php echo  limit_words(get_the_excerpt(), '18'); ?></p>
                                <div><a href="<?php the_permalink(); ?>" class="button normal small"><?php _e ('Details', 'Epic') ?></a></div>
                            </div> 
                        <?php elseif ($cols == 7):?>
                            <a href="<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); echo $full_image[0]; ?>">
                                <img src="" title="" alt="<?php echo get_the_title()?>"/>
                            </a> 
                        <?php endif; ?> 
                            
                    <?php $counter++; $col3counter++;  $col4counter++; endwhile;   ?>	 
                <?php  endif; ?> 
                <?php if ($cols == 5 || $cols == 6):?>
                    </div>
                <?php  endif?>
                <?php if ($cols == 7):?>
                    </div></div></div>
                    <script type='text/javascript'>
                        // Load the classic theme
                        Galleria.loadTheme('<?php echo get_template_directory_uri() ?>/js/galleria.classic.min.js');
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
           
            <div class="clear"></div>
            <?php
            // If the user has set a number of items per page, then display pagination
            if( $items_per_page != 777 ) 
            {
                include(Epic_PLUGINS . '/wp-pagenavi.php' );
                if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
            } 
            ?>
            <div class="clear"></div> 
            <?php
                if (isset ($_SESSION['epic_page_id']))
                echo getPageContent($_SESSION['epic_page_id']); 
            ?>
        </div>
        <?php if ($cols == 8):?>
            <div class="grid_3 sidebarright alignright">
                <?php generated_dynamic_sidebar() ?>
            </div> 
            <div class="clear"></div>
        <?php endif?> 
	</div>
</div>
<?php get_footer() ?>