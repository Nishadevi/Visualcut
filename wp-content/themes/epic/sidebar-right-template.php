<?php
/* Template Name: With Sidebar (Right) */
?>
<?php get_header(); ?>
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
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
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
    
    <div class="pagecontents">
        <div class="container_12">
            <div class="grid_9">	
       			<?php the_content(); ?>
			</div>
            <div class="grid_3 sidebarright alignright">
            	<?php generated_dynamic_sidebar() ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<?php endwhile; ?>	


<?php get_footer(); ?>