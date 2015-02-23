<?php
/* ***************************************************** 
 * File Description: Contains all theme's shortcodes
 * Author: Weblusive
 * Author URI: http://www.weblusive.com
 * ************************************************** */


/*********** ENABLE RAW CONTENT ************/
function my_formatter($content) 
{
       $new_content = '';
       $pattern_full = '{(\[raw\].*?\[/raw\])}is';
       $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
       $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

       foreach ($pieces as $piece) 
       {
               if (preg_match($pattern_contents, $piece, $matches)) 
               {
                       $new_content .= $matches[1];
               } else 
               {
                       $new_content .= wptexturize(wpautop($piece));
               }
       }

       return $new_content;
}

remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'my_formatter', 99);

/**********************************************/


/***************** BUTTONS ********************/

function al_button($atts, $content = null) {

	extract(shortcode_atts(array(
		"id"			=> '',
		"url" 			=> '#', 
		"size"		 	=> 'medium',
		"type"			=> 'normal',		
	), $atts));
	
	$id = isset($id) && $id != '' ? 'id="'.$id.'"' : '';
	
	return '<a href="'.$url.'" '.$id.' class="button '.$size.' '.$type.'">'.$content.'</a>';
	
}
add_shortcode('button', 'al_button');

/************************************************/



/*********** SINGLE ARTICLE BY ID ***************/

function sc_article($atts, $content = null) {

	extract(shortcode_atts(array(
		"id"=> '',
	), $atts));
	
	$post = get_post($id);
	$url = get_permalink($id);
	return '<h2><a href="'.$url.'">'.$post->post_title.'</a></h2><div>'.do_shortcode($post->post_content).'</div>';
	
}
add_shortcode('article', 'sc_article');

/************************************************/


/*************** SOCIAL BUTTONS *****************/

function al_socialbutton($atts, $content = null) {

	extract(shortcode_atts(array(
		"name"	=> '',
		"url" 	=> '#', 
		"icon"	=> '',
		"title"	=> '',
		"target" => '_blank'
	), $atts));
	
	$title = isset($title) && $title != '' ? $title : $name;
	$predefined = array('facebook', 'twitter', 'rss', 'skype', 'flickr', 'vimeo', 'myspace');
	$icon = in_array($name, $predefined) ? get_template_directory_uri().'/images/icons/'.$name.'.png' : $icon.'' ;
	
	return '<a href="'.$url.'" class="tip_trigger" target="'.$target.'"><img class="social" src="'.$icon.'" alt="'.$title.'" /><span class="tip">'.$title.'</span></a>';
}
add_shortcode('social_button', 'al_socialbutton');

/************************************************/


/************** TEXT HIGLIGHTING ****************/

function al_highlight($atts, $content = null) {

	extract(shortcode_atts(array(
		"color"			=> '',
	), $atts));	
	
	return '<span class="'.$color.'">'.$content.'</span>';
}
add_shortcode('highlight', 'al_highlight');

/************************************************/


/**************** MINI TWITTER ******************/

function al_minitwit($atts, $content = null) {

	extract(shortcode_atts(array(
		"name" => 'igniteflash',
		"followCaption" => 'Follow Us' 
	), $atts));	
	
	$return = ' 
		<div class="grid_12">
            <div id="twitter_div">
                <ul id="twitter_update_list">
                    <li>&nbsp;</li>
                </ul>
              <div class="aligncenter"><a href="http://www.twitter.com/'.$name.'" class="button highlight small">'.$followCaption.'</a></div>
            </div>
        </div>
		<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
		<script type="text/javascript" src="https://api.twitter.com/1/statuses/user_timeline/'.$name.'.json?callback=twitterCallback2&amp;count=1"></script>';
	return $return;
}
add_shortcode('minitwit', 'al_minitwit');

/************************************************/


/****** SHOW POSTS BY CATEGORY AND COUNT ********/

function al_show_posts( $atts )
{

	extract( shortcode_atts( array(
		'category' => '',
		'num' => '5',
		'order' => 'DESC',
		'orderby' => 'date',
		'class' =>'popular-posts',
		'minimal' => 0
	), $atts) );

	$out = '';

	$query = array();

	if ( $category != '' )
		$query[] = 'category=' . $category;

	if ( $num )
		$query[] = 'numberposts=' . $num;

	if ( $order )
		$query[] = 'order=' . $order;

	if ( $orderby )
		$query[] = 'orderby=' . $orderby;

	$posts_to_show = get_posts( implode( '&', $query ) );

	$out = '<ul class="'.$class.'">';

	foreach ($posts_to_show as $ps) {
		$permalink = get_permalink( $ps->ID );
		if ($minimal)
		{
			$out.='<li><a href ="'.$permalink.'" title="'.get_the_title($ps->ID).'" class="post-minimal">'.get_the_title($ps->ID).'</a></li>';
		}
		else
		{
			$out .="
			<li>
				<div class=\"list-post-thumb\">".get_the_post_thumbnail($ps->ID, array(45,45))."</div>
				<div class=\"list-post-desc\">
					<a href =\"{$permalink}\" title=\"{$ps->post_title}\"  class=\"wt-title\">{$ps->post_title}</a>
					<span>".get_the_time('F jS, Y', $ps->ID)."</span>
					<span class=\"by-author\">by ".get_the_author()."</span> 
				</div>
				<div class=\"clear\"></div>
			</li>";
		}
	}

	$out .= '</ul>';

    return $out;
}

add_shortcode('showposts', 'al_show_posts');

/*************** RELATED POSTS ******************/

function al_related_posts( $atts ) {
	extract(shortcode_atts(array(
	    'limit' => '5',
	    
	), $atts));

	global $wpdb, $post, $table_prefix;

	if ($post->ID) {
		$retval = '<ul>';
 		// Get tags
		$tags = wp_get_post_tags($post->ID);
		$tagsarray = array();
		foreach ($tags as $tag) {
			$tagsarray[] = $tag->term_id;
		}
		$tagslist = implode(',', $tagsarray);

		// Do the query
		$q = "SELECT p.*, count(tr.object_id) as count
			FROM $wpdb->term_taxonomy AS tt, $wpdb->term_relationships AS tr, $wpdb->posts AS p WHERE tt.taxonomy ='post_tag' AND tt.term_taxonomy_id = tr.term_taxonomy_id AND tr.object_id  = p.ID AND tt.term_id IN ($tagslist) AND p.ID != $post->ID
				AND p.post_status = 'publish'
				AND p.post_date_gmt < NOW()
 			GROUP BY tr.object_id
			ORDER BY count DESC, p.post_date_gmt DESC
			LIMIT $limit;";

		$related = $wpdb->get_results($q);
 		if ( $related ) {
			foreach($related as $r) {
				$retval .= '<li><a title="'.wptexturize($r->post_title).'" href="'.get_permalink($r->ID).'">'.wptexturize($r->post_title).'</a></li>';
			}
		} else {
			$retval .= '
	<li>No related posts found</li>';
		}
		$retval .= '</ul>';
		return $retval;
	}
	return;
}
add_shortcode('related_posts', 'al_related_posts');

/************************************************/


/***************** LIST PAGES *******************/

function al_list_pages($atts, $content, $tag) {
	global $post;
		
	// set defaults
	$defaults = array(
	    'class'       => $tag,
	    'depth'       => 0,
	    'show_date'   => '',
	    'date_format' => get_option('date_format'),
	    'exclude'     => '',
	    'child_of'    => 0,
	    'title_li'    => '',
	    'authors'     => '',
	    'sort_column' => 'menu_order, post_title',
	    'link_before' => '',
	    'link_after'  => '',
	    'exclude_tree'=> ''
	);
	
	
	$atts = shortcode_atts($defaults, $atts);
	
	
	$atts['echo'] = 0;
	if($tag == 'child-pages')
		$atts['child_of'] = $post->ID;	

	// create output
	$out = wp_list_pages($atts);
	if(!empty($out))
		$out = '<ul class="'.$atts['class'].'">' . $out . '</ul>';
	
  return $out;
}

add_shortcode('child-pages', 'al_list_pages');
add_shortcode('list-pages', 'al_list_pages');

/************************************************/


/*************** DIVIDER LINE ******************/

function al_divider($atts, $content = null) {
	  extract(shortcode_atts(array(
        'top' => '',       
    ), $atts));
	  
	if ($top)
	{
		return '<div class="divider"><h5><a class="alignright toTop" href="#">Top &uarr;</a></h5></div>';
	}
	else
	{
   		return '<div class="divider"></div>';
	}
}
add_shortcode('divider', 'al_divider');

/***********************************************/



/****************** SPACING ********************/

function al_spacing($atts, $content = null) {
  extract(shortcode_atts(array(
        'type' => 'top',
        'amount' => '10',
   ), $atts));
   return '<div class="'.$type.$amount.'"></div>';
}
add_shortcode('spacing', 'al_spacing');

/************************************************/


/************* VIMEO EMBED (VIA ID) *************/

function al_vimeo($atts, $content=null) {
	
	   extract(shortcode_atts(array(
            "id" => '',
            "width" => '600',
            "height" => '400',
			"class" => 'frame'
        ), $atts));
    
    /*$data = '
		<object class="'.$class.'" width="'.$width.'" height="'.$height.'" data="http://vimeo.com/moogaloop.swf?clip_id='.$id.'&amp;server=vimeo.com" type="application/x-shockwave-flash">
            <param name="allowfullscreen" value="true" />
			<param name="wmode" value="transparent" />
            <param name="allowscriptaccess" value="always" />
            <param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$id.'&amp;server=vimeo.com" />
        </object>';*/
	$data = '<iframe src="http://player.vimeo.com/video/'.$id.'?title=0&amp; byline=0&amp; portrait=0&amp; color=00adef" width="'.$width.'" height="'.$height.'" frameborder="0" class="'.$class.'"></iframe>';
	
    return $data;
}
add_shortcode('vimeo', 'al_vimeo');

/************************************************/


/************** YOUTUBE EMBED (VIA ID) **********/ 
$youtube_nr = 0;
function al_youtube($atts, $content=null) {
	 extract(shortcode_atts(array(
			'id'  => '',
			'width'  => '600',
			'height' => '340',
			"class" => 'frame'
			), $atts));

		return '<div class="youtube_video"><object class="'.$class.'" type="application/x-shockwave-flash" style="width:'.$width.'px; height:'.$height.'px;" data="http://www.youtube.com/v/'.$id.'&amp;hl=en_US&amp;fs=1&amp;"><param name="movie" value="http://www.youtube.com/v/'.$id.'&amp;hl=en_US&amp;fs=1&amp;" /></object></div>';

}
add_shortcode('youtube', 'al_youtube');
/************************************************/


/***************** CLEAR ************************/

function al_clear($atts, $content = null) {	
	return '<div class="clear"></div>';
}
add_shortcode('clear', 'al_clear');

/************************************************/


/********* STANDARD UNORDERED LISTS *************/

function al_list($atts, $content = null) {
	extract(shortcode_atts(array(
		'type' 	=> '',	
	), $atts));

	return '<div class="list'.$type.'">'.$content.'</div>';
}
add_shortcode('list', 'al_list');

/************************************************/


/****************** COLUMNS *********************/

// COLUMN FULL
function full( $atts, $content = null ) {
   return '<div class="grid_12">' . do_shortcode($content) . '</div>'; }
add_shortcode('full', 'full');
// COLUMN 1/2
function one_half( $atts, $content = null ) {
   return '<div class="grid_6">' . do_shortcode($content) . '</div>'; }
add_shortcode('one_half', 'one_half');

// COLUMN 1/2 Last
function one_half_last( $atts, $content = null ) {
   return '<div class="grid_6 omega">' . do_shortcode($content) . '</div><div class="clear"></div>'; }
add_shortcode('one_half_last', 'one_half_last');

// COLUMN 1/3 
function one_third( $atts, $content = null ) {
   return '<div class="grid_4">' . do_shortcode($content) . '</div>'; }
add_shortcode('one_third', 'one_third');

// COLUMN 1/3 Last
function one_third_last( $atts, $content = null ) {
   return '<div class="grid_4 omega">' . do_shortcode($content) . '</div><div class="clear"></div>'; }
add_shortcode('one_third_last', 'one_third_last');

// COLUMN 1/4
function one_fourth( $atts, $content = null ) {
   return '<div class="grid_3">' . do_shortcode($content) . '</div>'; }
add_shortcode('one_fourth', 'one_fourth');

// COLUMN 1/4 Last
function one_fourth_last( $atts, $content = null ) {
   return '<div class="grid_3 omega">' . do_shortcode($content) . '</div><div class="clear"></div>'; }
add_shortcode('one_fourth_last', 'one_fourth_last');

// COLUMN 1/6
function one_sixth( $atts, $content = null ) {
   return '<div class="grid_2">' . do_shortcode($content) . '</div>'; }
add_shortcode('one_sixth', 'one_sixth');

// COLUMN 1/6 Last
function one_sixth_last( $atts, $content = null ) {
   return '<div class="grid_2 omega">' . do_shortcode($content) . '</div><div class="clear"></div>'; }
add_shortcode('one_sixth_last', 'one_sixth_last');

// COLUMN 2/3
function two_third( $atts, $content = null ) {
   return '<div class="grid_8">' . do_shortcode($content) . '</div>'; }
add_shortcode('two_third', 'two_third');

// COLUMN 2/3 Last
function two_third_last( $atts, $content = null ) {
   return '<div class="grid_8 omega">' . do_shortcode($content) . '</div><div class="clear"></div>'; }
add_shortcode('two_third_last', 'two_third_last');

/************************************************/


/******************* QUOTES *********************/

function al_quote( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'author' => '',
		'type'	 => '',
	), $atts));
	$return = '';
	if ($type == 'static')
	{
		$return = '<div class="quote"><div class="static">'.do_shortcode($content).'<br /><span>'.$author.'</span></div></div>';
	}
	else
	{
		$return = '<div class="blockquote">'.do_shortcode($content).'<br /><span>'.$author.'</span></div>';
	}
	$return.= '<div class="clear"></div>';
	return $return; 
}
add_shortcode('quote', 'al_quote');

/************************************************/


/*****************  TABS *******************/

add_shortcode( 'tabgroup', 'al_tab_group' );
function al_tab_group( $atts, $content ){
	extract(shortcode_atts(array(
		'location' => ''
	), $atts));
	$GLOBALS['tab_count'] = 0;
	$location = empty($location) ? '' : ' '.$location.'tab';
	do_shortcode( $content );
	
	if( is_array( $GLOBALS['tabs'] ) ){
	foreach( $GLOBALS['tabs'] as $tab ){
	$tabs[] = '<li><a class="" href="#">'.$tab['title'].'</a></li>';
	$panes[] = '<div class="pane'.$location.'">'.do_shortcode($tab['content']).'</div>';
	}
	$return = "\n".'<div class="wrap"><ul class="tabs'.$location.'">'.implode( "\n", $tabs ).'</ul><div class="clearnospacing"></div>'."\n".'<div class="panes clearfix">'.implode( "\n", $panes ).'</div></div>'."\n";
	}
	return $return;
}

add_shortcode( 'tab', 'al_tab' );

function al_tab( $atts, $content ){
	extract(shortcode_atts(array(
	'title' => 'Tab %d'
	), $atts));
	
	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  $content );
	
	$GLOBALS['tab_count']++;
}

/************************************************/


/************ TESTIMONIALS ROTATOR **************/

add_shortcode( 'trotator', 'al_trotator' );
function al_trotator( $atts, $content ){
	$count = 0;
	$GLOBALS['tritem_count']=0;
	do_shortcode( $content );

	if( is_array( $GLOBALS['tritem'] ) ){
		foreach( $GLOBALS['tritem'] as $tab ){
			if ($count == 0)
			{
				$panes[] = '<li class="slide">'.do_shortcode($tab['content']).'<span> <br />'.$tab['author'].'</span></li>';	
			}
			else
			{
				$panes[] = '<li class="slide" style="display:none">'.do_shortcode($tab['content']).'<span>'.$tab['author'].'</span></li>';		
			}
			$count++;
		}
		$return = "\n".'<ul id="testimonials">'.implode( "\n", $panes ).''."\n".'</ul>';
		$return.='<script type="text/javascript">jQuery(document).ready(function() {jQuery(\'#coda-slider-1\').codaSlider();});</script>';
	}
	return $return;
}

add_shortcode( 'tritem', 'al_tritem' );

function al_tritem( $atts, $content ){
	extract(shortcode_atts(array(
	'author' => ''
	), $atts));
	
	$x = $GLOBALS['tritem_count'];
	$GLOBALS['tritem'][$x] = array('author' => $author, 'content' =>  $content );
	
	$GLOBALS['tritem_count']++;
}

/************************************************/


/*********** SLIDESHOW WITH LIGHTBOX ************/

add_shortcode( 'slideshow', 'al_slideshow' );
function al_slideshow( $atts, $content ){
	$count = 0;
	$GLOBALS['sitem_count']=0;
	do_shortcode( $content );

	if( is_array( $GLOBALS['sitem'] ) ){
		foreach( $GLOBALS['sitem'] as $tab ){
			if ($count == 0)
			{
				$panes[] ='<li class="slide hover"><a href="'.$tab['full'].'" rel="prettyPhoto" title="'.$tab['title'].'"><img src="'.$tab['thumb'].'" alt=""/></a></li>';	
			}
			else
			{
				$panes[] = '<li class="slide hover" style="display:none"><a href="'.$tab['full'].'" rel="prettyPhoto" title="'.$tab['title'].'"><img src="'.$tab['thumb'].'" alt=""/></a></li>';	
			}
			$count++;
		}
		$return = "\n".' <div class="shadowtestimonials"><ul id="testimonialsimageonly">'.implode( "\n", $panes ).'</ul></div>';
		$return.='<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(\'#testimonialsimageonly .slide\');
			setInterval(function(){
				jQuery(\'#testimonialsimageonly .slide\').filter(\':visible\').fadeOut(1000,function(){
					if(jQuery(this).next().size()){jQuery(this).next().fadeIn(1000);}
					else{jQuery(\'#testimonialsimageonly .slide\').eq(0).fadeIn(1000);}
				});
			},6000);	
		});	
		</script>';
	}
	return $return;
}

add_shortcode( 'sitem', 'al_sitem' );

function al_sitem( $atts, $content ){
	extract(shortcode_atts(array(
		'title' => '',
		'thumb' => '',
		'full' => ''
	), $atts));
	
	$x = $GLOBALS['sitem_count'];
	$GLOBALS['sitem'][$x] = array('title' => $title, 'content' =>  $content, 'thumb'=>$thumb, 'full'=>$full );
	
	$GLOBALS['sitem_count']++;
}

/************************************************/


/**************** KEN BURNS GALLERY *****************/

add_shortcode( 'kenburns', 'al_kenburns' );
function al_kenburns( $atts, $content ){
	$GLOBALS['kbitem_count'] = 0;
	
	do_shortcode( $content );
	
	
	if( is_array( $GLOBALS['kbitems'] ) ){
		$icount = 0;
	foreach( $GLOBALS['kbitems'] as $item ){
		$panes[] = "{src:  '".$item['image']."', alt:  '".$item['title']."', from: '".$item['startpos']."',to:   '".$item['endpos']."',time: ".$item['timeout']."},";
		$icount ++ ;
	}
	
	$return ='<div id="kbholder" class="flashmodule"></div><div class="kencaption"></div>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		$caption = jQuery(\'div.kencaption\'),
		jQuery(\'#kbholder\').crossSlide({
			fade: 1,
			}, [
			  '.implode( "\n", $panes ).' 
			], 
			function(idx, img, idxOut, imgOut) {
			if (idxOut == undefined)
			{
				$caption.text(img.alt).animate({ opacity: .7 })
			}
			else
			{
				$caption.fadeOut();
			}
			$caption.show().css({ opacity: 0 });
		});
		
	});
	</script>';
	
	}
	return $return;
}

add_shortcode( 'kbitem', 'al_kbitem' );

function al_kbitem( $atts, $content ){
	extract(shortcode_atts(array(
		'image' => '',
		'title' => '',
		'timeout' => '3',
		'startpos' => '100% 80% 1x',
		'endpos' => '100% 0% 1.7x'
	), $atts));
	
	$x = $GLOBALS['kbitem_count'];
	$GLOBALS['kbitems'][$x] = array( 'image' => $image, 'title' => $title, 'timeout' => $timeout, 'startpos' => $startpos, 'endpos' => $endpos, 'content' =>  $content );
	
	$GLOBALS['kbitem_count']++;
	
}
/************************************************/


/***************** TOGGLES **********************/

function al_toggle($atts, $content = null ) {
	extract(shortcode_atts(array(
		'class'	=> '',
		'title'	=> '',
	), $atts));
		
	return '<div class="toggle-trigger">
				<a href="#" class="tr'.$class.'">'.$title.'</a>
			</div> 
			<div class="toggle-container"> 
				<div class="toggle-block">'.do_shortcode($content).'</div>
			</div>'; 
}
add_shortcode('toggle', 'al_toggle');

/************************************************/


/***************** MORE LINK ********************/

function al_more($atts, $content = null ) {
	extract(shortcode_atts(array(
		'url'	=> '',
		'title'	=> '',
	), $atts));
		
	return '<h5><a href="'.$url.'" class="portfolio-link">'.$title.' &rarr;</a></h5>';
}
add_shortcode('more', 'al_more');

/************************************************/


/**************** ALIGNED IMAGES ****************/

function al_alimage( $atts, $content = null)
{
   extract(shortcode_atts(array(
		'align'	=> 'left',	
	), $atts));	
   return '<div class="align'.$align.'">'. do_shortcode($content) . '</div>';
}
add_shortcode('alimage', 'al_alimage');

/************************************************/


/***************** SHADOWS **********************/

function al_shadow( $atts, $content = null)
{
   extract(shortcode_atts(array(
		'size'	=> '',
	), $atts));	
	
	return '<div class="shadow'.$size.'">'. do_shortcode($content) .'</div>';
}
add_shortcode('shadow', 'al_shadow');

/************************************************/


/************* IMAGE IN LIGHTBOX ****************/

function al_lightbox( $atts, $content = null)
{
   extract(shortcode_atts(array(
		'thumb'	=> '',
		'full'	=> '',
		'title' => '',
		'shadow' => ''
	), $atts));	
	
	$return = '';
	if ($shadow) $return = '<div class="shadow'.$shadow.'">';
	
	$return.='<div class="frame hover"><a title="'.$title.'" rel="prettyPhoto" href="'.$full.'"><img alt="'.$title.'" src="'.$thumb.'"></a></div>';
	
	if ($shadow) $return.= '</div>';
	
   return $return;
}
add_shortcode('lightbox', 'al_lightbox');

/************************************************/


/*************** GOOGLE MAPS ********************/

/*
Plugin Name: Google Maps v3 Shortcode
Plugin URI: http://gis.yohman.com
Description: This plugin allows you to add one or more maps to your page/post using shortcodes.  Features include:  multiple maps on the same page, specify location by address or lat/lon combo, add kml, show traffic, add your own custom image icon, set map size.
Version: 1.02
Author: yohda
Author URI: http://gis.yohman.com/
*/

// Add the google maps api to header

// Main function to generate google map
function mapme($attr) {

	// default atts
	$attr = shortcode_atts(array(	
		'lat'   => '0', 
		'lon'    => '0',
		'id' => 'map',
		'z' => '1',
		'w' => '260',
		'h' => '260',
		'maptype' => 'ROADMAP',
		'address' => '',
		'kml' => '',
		'marker' => '',
		'markerimage' => '',
		'traffic' => 'no',
		'infowindow' => ''
		
		), $attr);
									
$returnme = '<div id="' .$attr['id'] . '" style="width:' . $attr['w'] . 'px;height:' . $attr['h'] . 'px;"></div>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript">
    	var latlng = new google.maps.LatLng(' . $attr['lat'] . ', ' . $attr['lon'] . ');
		var myOptions = {
			zoom: ' . $attr['z'] . ',
			center: latlng,
			mapTypeId: google.maps.MapTypeId.' . $attr['maptype'] . '
		};
		var ' . $attr['id'] . ' = new google.maps.Map(document.getElementById("' . $attr['id'] . '"),
		myOptions);
		';
				
		//kml
		if($attr['kml'] != '') 
		{
			//Wordpress converts "&" into "&#038;", so converting those back
			$thiskml = str_replace("&#038;","&",$attr['kml']);		
			$returnme .= '
			var kmllayer = new google.maps.KmlLayer(\'' . $thiskml . '\');
			kmllayer.setMap(' . $attr['id'] . ');
			';
		}
		
		//traffic
		if($attr['traffic'] == 'yes')
		{
			$returnme .= '
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap(' . $attr['id'] . ');
			';
		}
	
		//address
		if($attr['address'] != '')
		{
			$returnme .= '
		    var geocoder_' . $attr['id'] . ' = new google.maps.Geocoder();
			var address = \'' . $attr['address'] . '\';
			geocoder_' . $attr['id'] . '.geocode( { \'address\': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					' . $attr['id'] . '.setCenter(results[0].geometry.location);
					';
					
					if ($attr['marker'] !='')
					{
						//add custom image
						if ($attr['markerimage'] !='')
						{
							$returnme .= 'var image = "'. $attr['markerimage'] .'";';
						}
						$returnme .= '
						var marker = new google.maps.Marker({
							map: ' . $attr['id'] . ', 
							';
							if ($attr['markerimage'] !='')
							{
								$returnme .= 'icon: image,';
							}
						$returnme .= '
							position: ' . $attr['id'] . '.getCenter()
						});
						';

						//infowindow
						if($attr['infowindow'] != '') 
						{
							//first convert and decode html chars
							$thiscontent = htmlspecialchars_decode($attr['infowindow']);
							$returnme .= 'var contentString = \'' . $thiscontent . '\'
								var infowindow = new google.maps.InfoWindow({
								content: contentString
							});
										
							google.maps.event.addListener(marker, \'click\', function() {
							  infowindow.open(' . $attr['id'] . ',marker);
							});
				
							';
						}


					}
			$returnme .= '
				} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
			});
			';
		}

		//marker: show if address is not specified
		if ($attr['marker'] != '' && $attr['address'] == '')
		{
			//add custom image
			if ($attr['markerimage'] !='')
			{
				$returnme .= 'var image = "'. $attr['markerimage'] .'";';
			}

			$returnme .= '
				var marker = new google.maps.Marker({
				map: ' . $attr['id'] . ', 
				';
				if ($attr['markerimage'] !='')
				{
					$returnme .= 'icon: image,';
				}
			$returnme .= '
				position: ' . $attr['id'] . '.getCenter()
			});
			';

			//infowindow
			if($attr['infowindow'] != '') 
			{
				$returnme .= '
				var contentString = \'' . $attr['infowindow'] . '\';
				var infowindow = new google.maps.InfoWindow({
					content: contentString
				});
							
				google.maps.event.addListener(marker, \'click\', function() {
				  infowindow.open(' . $attr['id'] . ',marker);
				});
	
				';
			}


		}

		$returnme .= '</script>';

		return $returnme;
	?>
    

	<?php
}
add_shortcode('map', 'mapme');

/************************************************/


/******** SHORTCODE SUPPORT FOR WIDGETS *********/

if (function_exists ('shortcode_unautop')) {
	add_filter ('widget_text', 'shortcode_unautop');
}
add_filter ('widget_text', 'do_shortcode');

/************************************************/


/************* LIST POPULAR POSTS ***************/

function al_popular_posts($atts, $content = null) {
    extract(shortcode_atts(array(
            "limit" => '2',
            "cat" => ''
    ), $atts));

   
	global $post;
    $query = new WP_Query();
	$query->query('ignore_sticky_posts=1&showposts='.$limit.'&orderby=comment_count');
	
	 $retour='<ul class="popular-posts">';
	
	while ($query->have_posts()) : $query->the_post(); 
	
    	$thumb = has_post_thumbnail() ?  get_the_post_thumbnail($post->ID, array(55,55)) : '';
        $retour.='
		<li>
			<div class="dividerblog"></div>
			<div class="boxsmgrid peek"><a href="'.get_permalink($post->ID).'" class="wt-title">'.$thumb.'</a></div>
			<div class="list-post-desc">
				<p>'.limit_words(get_the_content(), '12').'</p>				 
			</div>
			<div class="clearnospacing"></div>
			<h6 class="post-date">'.get_the_time('F jS, Y').'</h6>
			<h6 class="post-comment">'.do_shortcode('[comments_count id="'.$post->ID.'" /]').'</h6> 
			<div class="clearnospacing"></div>
		</li>
		';
        endwhile;
        $retour.='</ul>';
     
                           
        return $retour;
}
add_shortcode("popular_posts", "al_popular_posts");

/************************************************/


/************* LIST RECENT COMMENTS ***************/

function al_recent_comments($atts, $content = null) {
    extract(shortcode_atts(array(
            "limit" => '5'
    ), $atts));

   
	global $wpdb;
	
	$return = '<ul>';  	
		
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,70) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 5";
	$comments = $wpdb->get_results($sql);
	foreach ($comments as $comment) :
	$return.='
	<li>
		<div class="list-post-thumb">
			<a class="wt-title" href="'.get_permalink($comment->ID).'#comment-'.$comment->comment_ID.'" title="'.strip_tags($comment->comment_author).' '.__('on ', 'Epic').' '.$comment->post_title.'">'.get_avatar($comment, '45').'</a>
		</div>
		
		<div class="list-post-desc">
			<a class="wt-title" href="'.get_permalink($comment->ID).'#comment-'.$comment->comment_ID.'" title="'.strip_tags($comment->comment_author).' '.__('on', 'Epic').' '.$comment->post_title.'">'.strip_tags($comment->comment_author).' : '.strip_tags($comment->com_excerpt).'</a>
			<p style="font-size:11px">'.date('F jS, Y', strtotime($comment->comment_date_gmt)).'</p>
		</div>
		<div class="clear"></div>
	</li>';

	endforeach; 
	
	wp_reset_query();
	
	$return.= '</ul>';
	
	return $return;
}
add_shortcode("recent_comments", "al_recent_comments"); 



/************* PORTFOLIO WORKS ***************/

function al_list_portfolio($atts, $content = null) {
    extract(shortcode_atts(array(
            "limit" => '4',
    		"cols"  => '4',
			"category" => ''
    ), $atts));
 	global $post;
    $counter = 1; 
	$args = array('post_type' => 'portfolio', 'taxonomy'=> 'portfolio_category', 'showposts' => $limit, 'posts_per_page' => 9, 'orderby' => 'date','order' => 'DESC');
	if (!empty($category))
	$args['term'] = $category; 
   	$query = new WP_Query($args);
	
	$return = '';
	 $col3counter=1;  $col4counter=1; 
	   	
	while ($query->have_posts())  : $query->the_post(); 
		$custom = get_post_custom($post->ID);  	
		
		if ($cols == 2)
		{
			$return.='<div class="shadow400">
				<div class="boxgrid400 peek">
					'.get_the_post_thumbnail($post->ID, 'portfolio-thumb-2cols', array('class' => 'cover')).'
					<h3>'.get_the_title().'</h3>
					<p>'.limit_words(get_the_excerpt(), '18').'</p>
					<span>';
					if( !empty ( $custom['_portfolio_video'][0] ) ) : // Check if there's a video to be displayed in the lightbox when clicking the thumb
						$return.='<a href="'.$custom['_portfolio_video'][0].'" class="zoom-icon video" title="'.get_the_title().'" rel="prettyPhoto">'.__('View video', 'Epic');
					elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : // User has set a custom destination link for this portfolio item 
						$return.='<a href="'.$custom['_portfolio_link'][0].'" title="'.get_the_title().'">'.__('View website', 'Epic'); 
					elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : // View the project details 
						$return.='<a href="'.get_permalink($post->ID).'">'.__('View project', 'Epic');
					else : // open image in original size in the pretty photo lightbox ?
						$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); 
						$return.='<a href="'.$full_image[0].'" class="zoom-icon" title="'.get_the_title().'" rel="prettyPhoto">'.__('View zoomed', 'Epic');
					endif; 
					$return.='</a>     
					</span>
				</div>
			</div>';
		}
	  	elseif ($cols == 3)
      	{
			$return.='<div class="shadow300">';
				if ($col3counter%2==0):
					$return.='<div class="boxgrid300 slidedown">';
				else:
					$return.='<div class="boxgrid300 slideright">';
				endif;
			 $return.= get_the_post_thumbnail($post->ID, 'portfolio-thumb-3cols', array('class' => 'cover')).'
					<h3>'.get_the_title().'</h3>
					<p>'.limit_words(get_the_excerpt(), '18').'</p>
					<span>';
					if( !empty ( $custom['_portfolio_video'][0] ) ) : // Check if there's a video to be displayed in the lightbox when clicking the thumb
						$return.='<a href="'.$custom['_portfolio_video'][0].'" class="zoom-icon video" title="'.get_the_title().'" rel="prettyPhoto">'.__('View video', 'Epic');
					elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : // User has set a custom destination link for this portfolio item 
						$return.='<a href="'.$custom['_portfolio_link'][0].'" title="'.get_the_title().'">'.__('View website', 'Epic'); 
					elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : // View the project details 
						$return.='<a href="'.get_permalink($post->ID).'">'.__('View project', 'Epic');
					else : // open image in original size in the pretty photo lightbox ?
						$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); 
						$return.='<a href="'.$full_image[0].'" class="zoom-icon" title="'.get_the_title().'" rel="prettyPhoto">'.__('View zoomed', 'Epic');
					endif; 
					$return.='</a>     
					</span>
				</div>
			</div>';
		}
		elseif ($cols == 4)
		{
			$return.='<div class="shadow200">';
			if ($col4counter%2==0):
				$return.='<div class="boxgrid slidedown">';
			else:
				$return.='<div class="boxgrid slideright">';
			endif;
			$return.= get_the_post_thumbnail($post->ID, 'portfolio-thumb-4cols', array('class' => 'cover'));
			$return.='<h3>'.get_the_title().'</h3>
					<p>'.limit_words(get_the_excerpt(), '18').'</p>
					<span>';
					if( !empty ( $custom['_portfolio_video'][0] ) ) : // Check if there's a video to be displayed in the lightbox when clicking the thumb
						$return.='<a href="'.$custom['_portfolio_video'][0].'" class="zoom-icon video" title="'.get_the_title().'" rel="prettyPhoto">'.__('View video', 'Epic');
					elseif( isset($custom['_portfolio_link'][0]) && $custom['_portfolio_link'][0] != '' ) : // User has set a custom destination link for this portfolio item 
						$return.='<a href="'.$custom['_portfolio_link'][0].'" title="'.get_the_title().'">'.__('View website', 'Epic'); 
					elseif(  isset( $custom['_portfolio_no_lightbox'][0] )  &&  $custom['_portfolio_no_lightbox'][0] !='' ) : // View the project details 
						$return.='<a href="'.get_permalink($post->ID).'">'.__('View project', 'Epic');
					else : // open image in original size in the pretty photo lightbox ?
						$full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false); 
						$return.='<a href="'.$full_image[0].'" class="zoom-icon" title="'.get_the_title().'" rel="prettyPhoto">'.__('View zoomed', 'Epic');
					endif; 
					$return.='</a>     
					</span>
				</div>
			</div>';
		}
		$counter++;   $col3counter++;  $col4counter++;
	endwhile; wp_reset_query();
	
	$return.='<div class="clear"></div>';
	
	return $return;
	
}
add_shortcode("list_portfolio", "al_list_portfolio"); 

/* ****** Display number of comments for specific post ****** */
function al_comments_count($atts) {
	extract( shortcode_atts( array(
		'id' => ''
	), $atts ) );

	$num = 0;
	$post_id = $id;
	$queried_post = get_post($post_id);
	$cc = $queried_post->comment_count;
		if( $cc == $num || $cc > 1 ) : $cc = $cc.' Comments';
		else : $cc = $cc.' Comment';
		endif;
	$permalink = get_permalink($post_id);

	return '<a href="'. $permalink . '" class="comments_link">' . $cc . '</a>';

}
add_shortcode('comments_count', 'al_comments_count');
	
?>