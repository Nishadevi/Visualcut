<?php
	/* Template Name: Home Page (with Blog) */
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
	wp_reset_query();
?>
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
    	<div class="grid_9">
	
		<?php         
            $pp = get_option('posts_per_page');
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			if ( get_query_var('paged') ) {
				$paged = get_query_var('paged');
			} elseif ( get_query_var('page') ) {
				$paged = get_query_var('page');
			} else {
				$paged = 1;
			}
			query_posts( array( 'post_type' => 'post', 'posts_per_page'=> $pp, 'paged' => $paged ) );
     	    get_template_part( 'loop', 'index' );
        ?>
    	</div>
        <div class="grid_3 sidebarright alignright">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Global Sidebar") ) : ?> <?php   endif;?>
        </div> 
        <div class="clear"></div>
	</div>
</div>
<!--End Page Content-->

     

<?php get_footer(); ?>		