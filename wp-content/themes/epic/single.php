<?php
/**
 * The Template for displaying all single posts.
 */

get_header(); ?>
<?php $al_options = get_option('al_general_settings'); ?>	
<div class="container_12">
	<div class="grid_12">
        <div class="clear"></div>
    		<div class="pagetitle1">
				<h2><?php the_title(); ?></h2>
            	<?php if(class_exists('the_breadcrumb') && $al_options['al_allow_breadcrumbs']){ $bc = new the_breadcrumb;} ?>
                <div class="clearnospacing"></div>   
            </div>
        <div class="clearnospacing"></div>   
     	<div class="divider"></div>  
    </div>
</div>

<div class="pagecontents">
	<div class="container_12">
    	<div class="grid_9">
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                <div class="blogpost" id="post-<?php the_ID();?>">
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
                    <?php echo  the_content(); ?>
                    <?php 
                    	$tags_list = get_the_tag_list( '', '' );
                        if ( $tags_list ) : ?>
                        <div class="tagcloud single-cloud"><?php printf( __( '%s', 'Epic' ), $tags_list ); ?></div>
                    <?php endif; ?>          
                </div>
                <div class="clear"></div>    
                
                <?php if($al_options['al_blog_show_rp']): ?>
                    <h3 class="top-title bottom30"><span><?php _e('Related Posts', 'Epic')?></span></h3>
                    <div class="list8">
                        <?php
                            $cat = get_the_category();
                            $cat = $cat[1]->cat_ID; 
                            echo do_shortcode('[showposts num="4" category="'.$cat.'" class="minimal-posts blogpost" minimal="1"]'); 
                        ?>
                    </div>
                <?php endif?>
                <?php comments_template( '', true ); ?>
            <?php endwhile; ?>
    	</div>
       	<div class="grid_3 sidebarright alignright">
			<?php generated_dynamic_sidebar() ?>
        </div>    
    	<div class="clear"></div>
		<?php $test = false; if ($test) {comment_form(); wp_link_pages( $args );} ?>
	</div>
</div>	
<?php $addId = (isset ($al_options['al_blog_addid']) && $al_options['al_blog_addid']!=='') ? $al_options['al_blog_addid'] : '[YOUR PROFILE ID HERE]';?>
<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $addId ?>"></script>
<?php get_footer(); ?>