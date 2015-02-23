<?php /** Functions file for Epic theme. **/

/********************* DEFINE MAIN PATHS ********************/

define('Epic_PLUGINS', get_template_directory() . '/plugins' ); // Shortcut to the /plugins/ directory

$adminPath 	= get_template_directory() . '/library/admin/';
$funcPath 	= get_template_directory() . '/library/functions/';
$incPath 	= get_template_directory() . '/library/includes/';

global $al_options;
$al_options = isset($_POST['options']) ? $_POST['options'] : get_option('al_general_settings');
/************************************************************/


/*********** LOAD ALL REQUIRED SCRIPTS AND STYLES ***********/
function loadScripts()
{
	if( !is_admin())
	{
		wp_enqueue_script('jquery');
	  	wp_enqueue_script('swfobject', get_template_directory_uri() .'/sliders/3d/swfobject/swfobject.js');		
		wp_enqueue_script('prettyphoto',  get_template_directory_uri(). '/js/jquery.prettyPhoto.js', array('jquery'), '3.0.1' );
		wp_enqueue_script('coda-slider',  get_template_directory_uri(). '/js/jquery.coda-slider-2.0.js', array('jquery'), '2.0' );
		wp_enqueue_script('cross-slide',  get_template_directory_uri(). '/js/jquery.cross-slide.min.js', array('jquery'), '1.0' );
		wp_enqueue_script('jquery-cookie',  get_template_directory_uri(). '/js/jquery.cookie.js', array('jquery'), '1.0' );
	  	wp_register_style('nivo-styles',  get_template_directory_uri().'/css/nivo-slider.css');
		wp_register_style('coda-styles',  get_template_directory_uri().'/css/coda-slider-2.0.css');
		wp_enqueue_style('pretty-photo-styles',  get_template_directory_uri().'/css/prettyPhoto.css',false,'3.0.1','all');
		wp_enqueue_script('top-menu',  get_template_directory_uri(). '/js/menu.js');
		wp_enqueue_script('jquery-tools',  get_template_directory_uri(). '/js/jquery.tools.min.js', array('jquery'), '1.2.6' );
		
		wp_enqueue_script('galleria-slider', get_template_directory_uri() .'/js/galleria-1.2.8.min.js');	
		wp_enqueue_script('galleria-slider-js', get_template_directory_uri() .'/js/galleria.classic.min.js');	
		wp_enqueue_style('galleria-styles',  get_template_directory_uri().'/js/galleria.classic.css');
		wp_enqueue_script('my-custom-scripts', get_template_directory_uri(). '/js/custom.js', array('jquery'), '1.0' );
		
		$al_options = get_option('al_general_settings'); 
		$slider = $al_options['al_active_slider'] !='' ? $al_options['al_active_slider'] : '';
		//$slider = isset($_GET['slider_type']) ? $_GET['slider_type'] : 'galleria';
	
		if($slider == 'nivo')
		{
			wp_enqueue_style('nivo-styles');
			wp_enqueue_script('nivo-slider', get_template_directory_uri() .'/sliders/nivo/nivo-slider.js');	
		}
		
		elseif($slider == 'alternative')
		{
			wp_enqueue_style('coda-styles');
		}
		
		elseif($slider == '3d')
		{
			wp_enqueue_script('3d-slider', get_template_directory_uri() .'/sliders/3d/swfobject/swfobject.js');		
		}

		if (is_page_template('contact-template.php')){
			 wp_enqueue_script('Validate',  get_template_directory_uri().'/js/validate.js',array('jquery'));
		}
	}
}
add_action( 'wp_enqueue_scripts', 'loadScripts' ); 

function epic_fonts() {
    $protocol = is_ssl() ? 'https' : 'http';
    wp_enqueue_style( 'Arimo-font', "$protocol://fonts.googleapis.com/css?family=Arimo" );
	wp_enqueue_style( 'Oswald-font', "$protocol://fonts.googleapis.com/css?family=Oswald" );
}
add_action( 'wp_enqueue_scripts', 'epic_fonts' );

/************************************************************/


/********************* DEFINE MAIN PATHS ********************/

require_once ($incPath . 'the_breadcrumb.php');
require_once ($incPath . 'OAuth.php');
require_once ($incPath . 'twitteroauth.php');
require_once ($funcPath . 'sidebar-generator.php');
require_once ($funcPath . 'options.php');
require_once ($funcPath . 'post-types.php');
require_once ($funcPath . 'widgets.php');
require_once ($funcPath . 'shortcodes.php');
require_once ($adminPath . 'custom-fields.php');
require_once ($adminPath . 'scripts.php');
require_once ($adminPath . 'admin-panel/admin-panel.php');
require_once ($incPath . 'portfolio_walker.php');
// Redirect To Theme Options Page on Activation
if (is_admin() && isset($_GET['activated'])){
	wp_redirect(admin_url('admin.php?page=adminpanel'));
}

/************** ADD SUPPORT FOR LOCALIZATION ***************/

load_theme_textdomain( 'Epic', get_template_directory() . '/languages' );

	$locale = get_locale();

	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

/************************************************************/


/**************** ADD SUPPORT FOR POST THUMBS ***************/

add_theme_support( 'post-thumbnails');

// Define various thumbnail sizes
add_image_size('portfolio-thumb-2cols', 440, 400, true); 
add_image_size('portfolio-thumb-3cols', 280, 240, true); 
add_image_size('portfolio-thumb-4cols', 200, 200, true); 
add_image_size('blog-thumb', 55, 55, true); 
add_image_size('blog-list', 600, 250, true);

/************************************************************/



/************* ADD SUPPORT FOR WORDPRESS 3 MENUS ************/

add_theme_support( 'nav-menus' );
if(function_exists('register_nav_menu')):
	register_nav_menu( 'primary_nav', 'Primary Navigation');
endif;

/************************************************************/


/************* COMMENTS HOOK *************/

function Epic_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>">
            <div class="comment-author vcard">
            <?php echo get_avatar($comment,$size='65',$default='<path_to_url>' ); ?>
             
            <?php printf(__('<cite class="fn">%s</cite>', 'Epic'), get_comment_author_link()) ?>
            </div>
            <?php if ($comment->comment_approved == '0') : ?>
            <em><?php _e('Your comment is awaiting moderation.', 'Epic') ?></em>
            <br />
            <?php endif; ?>
         
            <div class="comment-meta commentmetadata">
                <a href="<?php echo htmlspecialchars(get_comment_link( $comment->comment_ID )) ?>"></a>
            </div>
            <p>	<a class="comment-date"><?php printf(__('%1$s at %2$s', 'Epic'), get_comment_date(),get_comment_time()) ?></a>
                <?php edit_comment_link(__('(Edit)', 'Epic'),'  ','') ?>
            </p>
         
            <?php comment_text() ?>
            <?php if($args['max_depth']!=$depth) { ?>
            <div class="reply">
            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            
            <?php } ?>
            </div>
         </div>	
	<?php	
}

/*****************************************/


/************** FOOTER WIDGETS ************/

$al_options = get_option('al_general_settings'); 
$footer_widget_count = isset($al_options['al_footer_widgets_count']) ? $al_options['al_footer_widgets_count']:3;

for($i = 1; $i<= $footer_widget_count; $i++)
{
  if ( function_exists('register_sidebar') )
	register_sidebar(array(
	  	'name' => 'Footer Widget '.$i,
		//'id' => 'footer-sidebar-'.$i,
		'before_widget' => '<div class="footer-block">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
}

/*******************************************/


/********** GET PAGES BY PARAMS ************/

/*-- Get root parent of a page --*/
function get_root_page($page_id) 
{
	global $wpdb;
	
	$parent = $wpdb->get_var("SELECT post_parent FROM $wpdb->posts WHERE post_type='page' AND ID = '$page_id'");
	
	if ($parent == 0) 
		return $page_id;
	else 
		return get_root_page($parent);
}


/*-- Get page name by ID --*/
function get_page_name_by_ID($page_id)
{
	global $wpdb;
	$page_name = $wpdb->get_var("SELECT post_title FROM $wpdb->posts WHERE ID = '$page_id'");
	return $page_name;
}


/*-- Get page ID by Page Template --*/
function get_page_ID_by_page_template($template_name)
{
	global $wpdb;
	$page_ID = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = '$template_name' AND meta_key = '_wp_page_template'");
	return $page_ID;
}

/*-- Get page content (Used for pages with custom post types) --*/
if(!function_exists('getPageContent'))
{
	function getPageContent($pageId)
	{
		if(!is_numeric($pageId))
		{
			return;
		}
		global $wpdb;
		$sql_query = 'SELECT DISTINCT * FROM ' . $wpdb->posts .
		' WHERE ' . $wpdb->posts . '.ID=' . $pageId;
		$posts = $wpdb->get_results($sql_query);
		if(!empty($posts))
		{
			foreach($posts as $post)
			{
				return nl2br($post->post_content);
			}
		}
	}
}


/* -- Get page ID by Custom Field Value -- */
function get_page_ID_by_custom_field_value($custom_field, $value)
{
	global $wpdb;
	$page_ID = $wpdb->get_var("
	    SELECT wposts.ID
    	FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
	    WHERE wposts.ID = wpostmeta.post_id 
    	AND wpostmeta.meta_key = '$custom_field' 
	    AND (wpostmeta.meta_value like '$value,%' OR wpostmeta.meta_value like '%,$value,%' OR wpostmeta.meta_value like '%,$value' OR wpostmeta.meta_value = '$value')		
    	AND wposts.post_status = 'publish' 
	    AND wposts.post_type = 'page'
		LIMIT 0, 1");

	return $page_ID;
}
/*******************************************/


/******* PORTFOLIO/GLOBAL SIDEBARS *********/

if ( function_exists('register_sidebar') )
{	
	register_sidebar(array(
		'name' => 'Global Sidebar',
		//'id' => 'global-sidebar-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="top-title"><span>',
        'after_title' => '</span></h3>',
    ));
}


/*******************************************/


/********* STRING MANIPULATIONS ************/

function al_trim($text, $length, $end = '[...]') {
	$text = preg_replace('`\[[^\]]*\]`', '', $text);
	$text = strip_tags($text);
	$text = substr($text, 0, $length);
	$text = substr($text, 0, last_pos($text, " "));
	$text = $text . $end;
	return $text;
}

function last_pos($string, $needle){
   $len=strlen($string);
   for ($i=$len-1; $i>-1;$i--){
       if (substr($string, $i, 1)==$needle) return ($i);
   }
   return FALSE;
}

function limit_words($string, $word_limit) {
 
	// creates an array of words from $string (this will be our excerpt)
	// explode divides the excerpt up by using a space character
 
	$words = explode(' ', $string);
 
	// this next bit chops the $words array and sticks it back together
	// starting at the first word '0' and ending at the $word_limit
	// the $word_limit which is passed in the function will be the number
	// of words we want to use
	// implode glues the chopped up array back together using a space character
 
	return implode(' ', array_slice($words, 0, $word_limit)).'...';
}

function excerpt_ellipse($text) {
   return str_replace('[...]', ' <a href="'.get_permalink().'" class="read-more" style="margin:14px 0 0 0">Read more...</a>', $text); }
add_filter('the_excerpt', 'excerpt_ellipse');

/*******************************************/


/******* POSTS RELATED BY TAXONOMY *********/

function get_taxonomy_related_posts($post_id, $taxonomy, $args=array()) {
  $query = new WP_Query();
  $terms = wp_get_object_terms($post_id, $taxonomy);
  if (count($terms)) {
    $post_ids = get_objects_in_term($terms[0]->term_id,$taxonomy);
    $post = get_post($post_id);
    $args = wp_parse_args($args,array(
      'post_type' => $post->post_type, 
      'post__in' => $post_ids,
      'taxonomy' => $taxonomy,
      'term' => $terms[0]->slug,
	  'posts_per_page' => 3
    ));
    $query = new WP_Query($args);
  }
  return $query;
}

/********************************************/

/*************  ENABLE SESSIONS *************/

function cp_admin_init() {
	if (!session_id())
	session_start();
}

add_action('init', 'cp_admin_init');

/********************************************/


/**************  GOOGLE FONTS ***************/

function font_name($string){
		
	$check = strpos($string, ':');
	if($check == false){
		return $string;
	} else { 
		preg_match("/([\w].*):/i", $string, $matches);
		return $matches[1];
	} 
} 

/********************************************/

/************** LIST TAXONOMY ***************/

function list_taxonomy($taxonomy, $class='')
{
	$args = array ('hide_empty' => false);
	$tax_terms = get_terms($taxonomy, $args); 
	$active = '';
	$output = '<ul class="'.$class.'">';

	foreach ($tax_terms as $tax_term) {
		if ($taxonomy  == $tax_term)
		{
			$active  = ' class="active"';
		}
		$output.='<li><a href="'.esc_attr(get_term_link($tax_term, $taxonomy)) . '"'.$active.'>'.$tax_term->name.'</a></li>';
	}
	$output.='</ul>';
	
	return $output;
}

/********************************************/

add_theme_support( 'automatic-feed-links' );
if ( ! isset( $content_width ) ) $content_width = 960;
add_filter('the_excerpt', 'do_shortcode');
?>