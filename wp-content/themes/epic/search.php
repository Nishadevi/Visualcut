<?php
/*** The template for displaying Search Results pages. ***/

get_header(); ?>
	
<div class="container_12">
	<div class="grid_12">
    	<div class="pagetitle1">
            <h2>
                <?php printf( __( 'Search Results for: %s', 'Epic' ), '<strong>' . get_search_query() . '</strong>' ); ?>
            </h2>
        </div>
        <div class="divider"></div>
	</div>
</div>
<div class="pagecontents">
	<div class="container_12">
    	<div class="grid_9">
			<?php if ( have_posts() ) : ?>
                <?php get_template_part( 'loop', 'search' );?>
            <?php else : ?>
                <div id="post-0" class="post no-results not-found">
                    <h4><?php _e( 'Nothing Found', 'Epic' ); ?></h4>
                    <div class="entry-content">
                        <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'Epic' ); ?></p>
                     </div><!-- .entry-content -->
                </div><!-- #post-0 -->
        	<?php endif; ?>
    	</div>
       	<div class="grid_3 sidebarright alignright">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Global Sidebar") ) : ?> <?php   endif;?>
    	</div>
    	<div class="clear"></div>
	</div>
</div>


<?php get_footer(); ?>
