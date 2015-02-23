<?php
 
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');
 
if ( post_password_required() ) : ?>
	<p class="nocomment"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'Epic' ); ?></p>
</div>
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>
<!-- You can start editing here. -->
 
<?php if ( have_comments() ) : ?>
<h5 class="top-title top20" id="comments">
	<?php printf( _n( 'Comments (%1$s)', 'Comments (%1$s)', get_comments_number(), 'Epic' ),
		number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
	?>
</h5>
 

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
	<div class="navigation">
		<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'Epic' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'Epic' ) ); ?></div>
	</div> <!-- .navigation -->
<?php endif; ?>
 
<ol class="commentlist">
<?php wp_list_comments('callback=Epic_comment'); ?>
</ol>
 
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'Epic' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'Epic' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>
<?php else : // this is displayed if there are no comments so far ?>
 
<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
 
<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments"><?php _e( 'Comments are closed.', 'Epic' ); ?></p>
 
<?php endif; ?>
<?php endif; ?>
 
<?php if ('open' == $post->comment_status) : ?>
 
<div id="respond" class="top30 bottom20">
    <h3><?php comment_form_title( 'Leave a comment', 'Leave a Reply to %s', 'Epic'); ?></h3>
    <p><?php _e('Your email address will not be shared or published. Required fields are marked *', 'Epic');?></p>
    <div class="cancel-comment-reply">
    <small><?php cancel_comment_reply_link(); ?></small>
</div>
 
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php _e('You must be logged in to post a comment', 'Epic');?></p>
<?php else : ?>
 
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">     
    <?php if ( $user_ID ) : ?>
    	<p>
			<?php _e('Logged in as', 'Epic')?> 
        	<a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. 
            <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out', 'Epic')?> &raquo;</a></p>
    <?php else : ?>
     
    <div class="grid_3 alpha">
        <label for="author"><?php _e( 'Name', 'Epic' ); ?> <?php if ($req) echo "<span>*</span>"; ?></label>
        <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
    </div>
     
    <div class="grid_3 omega">
        <label for="email"><?php _e( 'E-Mail', 'Epic' ); ?><?php if ($req) echo "<span>*</span>"; ?></label>
        <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
    </div>
     
    <div class="grid_6 omega clearfix">
        <label for="url"><?php _e( 'Website', 'Epic' ); ?></label>
        <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
    </div>
     
    <?php endif; ?>
     
    <!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
     
    <div class="grid_6 omega">
        <label for="comment"><?php _e( 'Comment', 'Epic' ); ?></label>
        <textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea>
    </div>
     
    <div class="grid_6 omega clearfix">
        <input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Post Comment', 'Epic')?>" class="button highlight small"  />
        <?php comment_id_fields(); ?>
    </div>
    <?php do_action('comment_form', $post->ID); ?>
 
</form>
 
<?php endif; // If registration required and not logged in ?>
</div>
 
<?php endif;  ?>

