<?php /** The default template for pages. **/ ?>

<?php get_header(); ?>
<div class="pagecontents">
    <div class="container_12">
        <div class="grid_9">	
            <?php  get_template_part( 'loop', 'index' ); ?>
        </div>
        <div class="grid_3 sidebarright alignright">
            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Global Sidebar") ) : ?> <?php   endif;?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<?php get_footer(); ?>
