<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 */

get_header(); ?>

<div class="container_12">
    <div class="grid_12">
        <div class="clear"></div>
        <div class="pagetitle1">
            <h2>Page not found</h2>
            <?php if(class_exists('the_breadcrumb') && $al_options['al_allow_breadcrumbs']){ $bc = new the_breadcrumb;} ?>
            <div class="clearnospacing"></div>   
         </div>
        <div class="divider"></div>  
    </div>
</div>
    
<div class="pagecontents">
    <div class="container_12">
         <div class="grid_12">
           	<h2>
            	<?php _e('Sorry, the page or file you requested may have been moved or deleted.', 'Epic')?>
            </h2>
           	<p>Use the search box below if you were looking for something specific</p>
            <div class="bottom50 top20">
			<?php get_search_form(); ?>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>