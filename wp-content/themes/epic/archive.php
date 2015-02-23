<?php
/*** The template for displaying Archive pages. **/

get_header(); ?>

<div class="container_12">
	<div class="grid_12">
        <div class="clear"></div>
    		<div class="pagetitle1">
            	<h2>
					<?php if ( is_day() ) : ?>
                        <?php printf( __( 'Daily Archives: <span>%s</span>', 'Epic' ), get_the_date() ); ?>
                    <?php elseif ( is_month() ) : ?>
                        <?php printf( __( 'Monthly Archives: <span>%s</span>', 'Epic' ), get_the_date('F Y') ); ?>
                    <?php elseif ( is_year() ) : ?>
                        <?php printf( __( 'Yearly Archives: <span>%s</span>', 'Epic' ), get_the_date('Y') ); ?>
                    <?php elseif ( is_category() ) : ?>
                        <?php single_cat_title();?>
                    <?php else : ?>
                        <?php _e( 'Blog Archives', 'Epic' ); ?>
                    <?php endif; ?>
            	</h2>
                <?php if(class_exists('the_breadcrumb') && $al_options['al_allow_breadcrumbs']){ $albc = new the_breadcrumb; } ?>
            </div>
        <div class="clearnospacing"></div>   
     	<div class="divider"></div>  
    </div>
</div>

<div class="pagecontents">
	<div class="container_12">
    	<div class="grid_9">
    	
			<?php
                /* Queue the first post, that way we know
                 * what date we're dealing with (if that is the case).
                 *
                 * We reset this later so we can run the loop
                 * properly with a call to rewind_posts().
                 */
                if ( have_posts() )
                    the_post();
            /* Since we called the_post() above, we need to
             * rewind the loop back to the beginning that way
             * we can run the loop properly, in full.
             */
            rewind_posts();
        
            /* Run the loop for the archives page to output the posts.
             * If you want to overload this in a child theme then include a file
             * called loop-archives.php and that will be used instead.
             */
             get_template_part( 'loop', 'archive' );
            ?>
    	</div>
       	<div class="grid_3 sidebarright alignright">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Global Sidebar") ) : ?> <?php   endif;?>
    	</div>
    	<div class="clear"></div>
	</div>
</div>

<?php get_footer(); ?>
