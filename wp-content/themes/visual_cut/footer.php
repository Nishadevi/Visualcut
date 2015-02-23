<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>
<footer id="footer">
			<div class="container footer-holder">
				<div class="row">
					<div class="col-sm-3">
						<p>&copy;<?php echo date('Y'); ?> <a href="#">Visual Cut.</a> All Rights Reserved. <br/>Powered by <a href="#">MindTrust Labs</a></p>
					</div>
					<nav class="sub-nav col-sm-9">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '', 'menu_id' => 'footer' ) ); ?>
					</nav>
				</div>
			</div>
		</footer>
	</div>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="<?php bloginfo('template_url'); ?>/js/jquery-1.11.1.min.js"><\/script>')</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="<?php bloginfo('template_url'); ?>/js/jquery.main.js"></script>
        <?php wp_footer(); ?>
</body>
</html>