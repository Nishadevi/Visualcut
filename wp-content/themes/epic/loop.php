<?php /*** The loop that displays posts.***/ ?>

<?php 

$al_options = get_option('al_general_settings');
?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'Epic' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'Epic' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>


<?php while ( have_posts() ) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class('blogpost'); ?>>
        <!--Image-->
        <?php $custom =  get_post_custom_values("_post_video") ?>
        <?php  if(has_post_thumbnail()):?>
            <div class="shadowblog">
                <div class="featuredimage">
                    <div class="hover">
						<a href="<?php $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); echo $full_image[0]; ?>" rel="prettyPhoto">
							<?php the_post_thumbnail('blog-list', array('class'=>'frame')); ?>
                        </a>
                    </div>
                </div>
            </div>	
        <?php elseif ($custom): ?>
            <div class="shadowblogvideo">
                <div class="featuredimage">
                	<?php echo do_shortcode ('[vimeo id="'.$custom[0].'" width="600" height="340" /]');?>
                </div>
            </div>	
        <?php endif?>
        <!--Date-->
        <div class="grid_2">
            <h3>
                <?php if($al_options['al_blog_show_date']): ?>
                       <?php the_time('M j \'y'); ?>
                <?php endif?>
            </h3>
        </div>
        <div class="grid_3">                 
            <?php if($al_options['al_blog_show_author']): ?>
                <h5 class="post-author">
                    <?php printf( __( 'Author: %1$s', 'Epic' ),  get_the_author()) ?>
                </h5>
            <?php endif?>
            
            <?php if($al_options['al_blog_show_cats']): ?>
                <?php if ( count( get_the_category() ) ) : ?>
                    
                    <?php $category = get_the_category();  if($category[0]):?>
                        <h5 class="post-category">
                            <?php _e('Posted in: ', 'Epic') ?><a href="<?php echo get_category_link($category[0]->term_id )?>"><?php echo $category[0]->cat_name?></a>
                        </h5>
                    <?php endif?>
                <?php endif; ?>
            <?php endif?>
            <?php if( 'open' == $post->comment_status && $al_options['al_blog_show_comments']) : ?>
                <h5 class="post-comment"><?php comments_popup_link( __( 'Comments: 0', 'Epic' ), __( 'Comments: 1', 'Epic' ), __( 'Comments: %', 'Epic' )); ?></h5>
            <?php endif; ?>
        </div>                 
        <div class="addthis_toolbox addthis_default_style addthis_16x16_style alignright icons">
            <a class="addthis_button_preferred_1"></a>
            <a class="addthis_button_preferred_2"></a>
            <a class="addthis_button_preferred_3"></a>
            <a class="addthis_button_preferred_4"></a>
            <a class="addthis_button_compact"></a>
            <a class="addthis_counter addthis_bubble_style"></a>
        </div>
        
        <div class="clearnospacing"></div>
        <div class="dividerblog"></div>                
       
        <!--Title-->
        <h4><?php the_title(); ?></h4>                                              
        <!--Description-->
        <p><?php echo  get_the_excerpt(); ?></p> 
        <div><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %1$s', 'Epic' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" class="button normal small"><?php _e('Read this article', 'Epic')?></a></div>                
	</div>
    <div class="clear"></div>     
<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>

<div class="navigation">
<?php if ( $wp_query->max_num_pages > 1 ) :
   include(Epic_PLUGINS . '/wp-pagenavi.php' );
   if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
?>
<?php endif; ?>
</div>
<?php $addId = (isset ($al_options['al_blog_addid']) && $al_options['al_blog_addid']!=='') ? $al_options['al_blog_addid'] : '[YOUR PROFILE ID HERE]';?>
<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addId ?>"></script>