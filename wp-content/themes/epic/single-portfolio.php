<?php
/**
 * Portfolio Single Posts template.
 */

get_header(); ?>

<?php  $al_options = get_option('al_general_settings'); ?>
<div class="container_12">
	<div class="grid_12">
        <div class="clear"></div>
       	<div class="pagetitle1">
			<h2><?php the_title()?></h2>
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
      	<?php if ( have_posts() ) while ( have_posts() ) : ?>
        
		<?php $custom = get_post_custom($post-> ID); $check = ($custom['sbg_selected_sidebar_replacement'][0]); $pos = strpos($check, '"0"'); if(!$pos): ?>
        	<div class="grid_9">
		<?php else: ?>
            <div class="grid_12">
        <?php endif ?>
        	 <?php the_post(); the_content();  ?>
			 
			
        </div>
        <?php if (!$pos): ?>
        <div class="grid_3 sidebarright alignright">
              <?php generated_dynamic_sidebar(); ?>
        </div>
        <?php endif?>
        <div class="clear"></div>
        <?php endwhile ?> 
	</div>
</div>        
<?php get_footer(); ?>