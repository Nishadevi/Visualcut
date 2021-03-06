<?php 
/* Template Name: Blog */

get_header();
$catid = get_query_var('cat');
$cat = &get_category($catid);

?>
<div class="clearnospacing"></div>
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
            <?php if(class_exists('the_breadcrumb') && $al_options['al_allow_breadcrumbs']){ $bc = new the_breadcrumb;} ?>
            <div class="clearnospacing"></div>   
        </div>
        <div class="divider"></div>  
    </div>
</div>

<!--Page Content-->
<div class="pagecontents">
	<div class="container_12">
    	<div class="grid_9">
	
		<?php 
            $temp = $wp_query;
            $wp_query= null;
            $wp_query = new WP_Query();
            $pp = get_option('posts_per_page');
            $wp_query->query('posts_per_page='.$pp.'&paged='.$paged);			
     	    get_template_part( 'loop', 'index' );
        ?>
    	</div>
        <div class="grid_3 sidebarright alignright">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Global Sidebar") ) : ?> <?php   endif;?>
        </div> 
        <div class="clear"></div>
	</div>
</div>
<?php get_footer();?>