<?php

global $new_meta_boxes;
$new_meta_boxes =
array(
	
	"_headline" => array(
	"name" => "_headline",
	"std" => "",
	"title" => "Alternative page title",
	"description" => "If you want to use a title other from the one displayed in menu (For example, page title for 'Portfolio' could be 'Recent works'",
	"type" => "text",
	"location" => "Page"),
	
	"_promo" => array(
	"name" => "_promo",
	"std" => "",
	"title" => "Promo text",
	"description" => "Page header with alternative background to put some promo text. Shortcodes are allowed",
	"type" => "textarea",
	"location" => "Page"
	),
	
	
	"_page_portfolio_cat" => array(
	"name" => "_page_portfolio_cat",
	"std" => "",
	"title" => "Portfolio Categories",
	"description" => "Choose only if this page uses a Portfolio page template",
	"type" => "portfolio_cat",
	"location" => "Page"),
	
	"_page_portfolio_num_items_page" => array(
	"name" => "_page_portfolio_num_items_page",
	"std" => "",
	"title" => "Number of Portfolio items per Page",
	"description" => "Number of items displayed per page. Leave blank if you don't want to paginate the portfolio items",
	"type" => "text",
	"location" => "Page"),
		


	"slide_url" => array(
		"name" => "slide_url",
		"std" => "",
		"title" => "Slider Item custom destination URL",
		"description" => "Set optional url to go when a user clicks on a slide.<br />Example: http://www.google.com/",
		"type" => "text",
	"location" => "Slider"),	
	
	
	"_portfolio_no_lightbox" => array(
	"name" => "_portfolio_no_lightbox",
	"std" => "",
	"title" => "Thumbnail links to Portfolio Item Detail?",
	"description" => "Thumbnail to link directly to the portfolio item detail or custom URL instead of opening the full image in the lightbox.<br />(Exception: \"Video\" field(if not blank) will override this field's value.)",
	"type" => "checkbox",
	"location" => "Portfolio"),
	
	"_portfolio_link" => array(
	"name" => "_portfolio_link",
	"std" => "",
	"title" => "Portfolio Item custom destination URL",
	"description" => "If you want the portfolio item have custom link rather going to item's details page.<br />Example: http://www.weblusive.com/<br />(Exception: \"Video\" field(if not blank) will override this field's value.)",
	"type" => "text",
	"location" => "Portfolio"),

	"_portfolio_video" => array(
	"name" => "_portfolio_video",
	"std" => "",
	"title" => "Portfolio Video in lightbox",
	"description" => "<strong>Supports  Flv, MP4, Quicktime, as well as Youtube, Vimeo, etc.. </strong><br /> Examples:<br />http://www.adobe.com/products/flashplayer/include/marquee/design.swf?width=792&height=294<br />http://www.youtube.com/watch?v=ehuwoGVLyhg<br />http://vimeo.com/123456<br />",
	"type" => "text",
	"location" => "Portfolio"),
	
	"_portfolio_video" => array(
	"name" => "_portfolio_video",
	"std" => "",
	"title" => "Portfolio Video in lightbox",
	"description" => "<strong>Supports  Flv, MP4, Quicktime, as well as Youtube, Vimeo, etc.. </strong><br /> Examples:<br />http://www.adobe.com/products/flashplayer/include/marquee/design.swf?width=792&height=294<br />http://www.youtube.com/watch?v=ehuwoGVLyhg<br />http://vimeo.com/123456<br />",
	"type" => "text",
	"location" => "Portfolio"),
	
	"_portfolio_video" => array(
	"name" => "_portfolio_video",
	"std" => "",
	"title" => "Portfolio Video in lightbox",
	"description" => "<strong>Supports  Flv, MP4, Quicktime, as well as Youtube, Vimeo, etc.. </strong><br /> Examples:<br />http://www.adobe.com/products/flashplayer/include/marquee/design.swf?width=792&height=294<br />http://www.youtube.com/watch?v=ehuwoGVLyhg<br />http://vimeo.com/123456<br />",
	"type" => "text",
	"location" => "Portfolio"),
	
	"_before_image" => array(
		"name" => "_before_image",
		"std" => "",
		"type" => "image",
		"title" => "Before image",
		"description" => "Please make sure before and after images are of same dimensions.",
		"location" => "Portfolioba",
	), 
	
	"_after_image" => array(
		"name" => "_after_image",
		"std" => "",
		"type" => "image",
		"title" => "After image",
		"description" => "Please make sure before and after images are of same dimensions.",
		"location" => "Portfolioba",
	), 	
	
	
	"_post_video" => array(
	"name" => "_post_video",
	"std" => "",
	"title" => "Vimeo video in post listing (just enter the video ID)",
	"description" => "Example: 19966855",
	"type" => "text",
	"location" => "Post"),
	
);

function new_meta_boxes_page() {
	new_meta_boxes('Page');
}

function new_meta_boxes_slider() {
	new_meta_boxes('Slider');
}

function new_meta_boxes_post() {
	new_meta_boxes('Post');
}


function new_meta_boxes_portfolio() {
	new_meta_boxes('Portfolio');
}

function new_meta_boxes_portfolioba() {
	new_meta_boxes('Portfolioba');
}

function new_meta_boxes( $type ) {
	global $post, $new_meta_boxes;
	
	// Use nonce for verification
    echo '<input type="hidden" name="Epic_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	echo '<div class="form-wrap">';

	foreach($new_meta_boxes as $meta_box) {
		if( $meta_box['location'] == $type) {
			
			if ( $meta_box['type'] == 'title' ) {
				echo '<p style="font-size: 18px; font-weight: bold; font-style: normal; color: #e5e5e5; text-shadow: 0 1px 0 #111; line-height: 40px; background-color: #464646; border: 1px solid #111; padding: 0 10px; -moz-border-radius: 6px;">' . $meta_box[ 'title' ] . '</p>';
			} else {			
				$meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);
		
				if($meta_box_value == "")
					$meta_box_value = $meta_box['std'];
		
				echo '<div class="form-field form-required">';
				
				switch ( $meta_box['type'] ) {
					
					
					
					case 'text':
						echo 	'<label for="' . $meta_box[ 'name' ] .'"><strong>' . $meta_box[ 'title' ] . '</strong></label>';
						echo 	'<input type="text" name="' . $meta_box[ 'name' ] . '" value="' . htmlspecialchars( $meta_box_value ) . '" />';
						
						break;
					case 'textarea':
						echo 	'<label for="' . $meta_box[ 'name' ] .'"><strong>' . $meta_box[ 'title' ] . '</strong></label>';
						echo 	'<textarea name="' . $meta_box[ 'name' ] . '" id ="'. $meta_box[ 'name' ].'">' . htmlspecialchars( $meta_box_value ). '</textarea>';
						
						break;
					
					case 'datetime':
						echo 	'<label for="' . $meta_box[ 'name' ] .'"><strong>' . $meta_box[ 'title' ] . '</strong></label>';
						echo 	'<input type="text" id ="'. $meta_box[ 'name' ].'" name="' . $meta_box[ 'name' ] . '" value="' . htmlspecialchars( $meta_box_value ) . '" class="datetime" />';
						break;
						
					case 'checkbox':
						if($meta_box_value == '1'){ $checked = "checked=\"checked\""; }else{ $checked = "";} 
						echo 	'<label for="' . $meta_box[ 'name' ] .'"><strong>' . $meta_box[ 'title' ] . '</strong>&nbsp;
						<input style="width: 20px;" id ="'. $meta_box[ 'name' ].'" type="checkbox" name="' . $meta_box[ 'name' ] . '" value="1" ' . $checked . ' /></label>';
						break;
						
					case 'select':
						echo 	'<label for="' . $meta_box[ 'name' ] .'"><strong>' . $meta_box[ 'title' ] . '</strong></label>';
						echo	'<select name="' . $meta_box[ 'name' ] . '" id ="'. $meta_box[ 'name' ].'">';
						echo  '<p>'.$meta_box[ 'description'].'</p>'; 
						// Loop through each option in the array
						foreach ($meta_box[ 'options' ] as $option) {
							if(is_array($option)) {
								echo '<option ' . ( $meta_box_value == $option['value'] ? 'selected="selected"' : '' ) . ' value="' . $option['value'] . '">' . $option['text'] . '</option>';
							} else {
   								echo '<option ' . ( $meta_box_value == $option ? 'selected="selected"' : '' ) . ' value="' . $option['value'] . '">' . $option['text'] . '</option>';
							}
						}
                    	echo	'</select>';
                    break;
					
					case 'image':					
						echo'<label for="'.$meta_box['name'].'_upload"><strong>'.$meta_box['title'].'</strong></label>';
						echo'<input type="file" name="'.$meta_box['name'].'_upload" size="55" /><br />';
						echo'<small>Upload image here</small></p>';
						echo'<p><label> </label>';
						echo'<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" size="55" /><br />';
						echo'<small>or add a URL to the image here</small>';
						
					break;
					
					case 'portfolio_cat':
						echo 	'<label for="' . $meta_box[ 'name' ] .'" id ="'. $meta_box[ 'name' ].'"><strong>' . $meta_box[ 'title' ] . '</strong></label>';
						
						// Get the categories first
						$args = array( 'taxonomy' => 'portfolio_category', 'hide_empty' => '0' );
						$categories = get_categories( $args ); 
						
						$selected_cats = explode( ",", $meta_box_value );
						
						echo '<ul style="margin-top: 5px;">';

						// Loop through each category
						foreach ($categories as $category) {
														
							foreach ($selected_cats as $selected_cat) {
        	           			if($selected_cat == $category->cat_ID){ $checked = 'checked="checked"'; break; } else { $checked = ""; }
		            	    }
							
			                echo '<li><input style="width: 20px;" type="checkbox" name="' . $meta_box[ 'name' ] . '[]" value="' . $category->cat_ID . '" ' . $checked . ' />&nbsp;' . $category->name . '</li>';
						}
						
						echo '</ul>';
						break;
				}

				echo 	'<p>' . $meta_box[ 'description' ] . '</p>';
				echo '</div>';
			}
		}
	}
	
	echo '</div>';
}

function create_meta_box() {
	global $theme_name;
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'new_meta_boxes_page', 'Epic'  . ' Page Settings', 'new_meta_boxes_page', 'page', 'normal', 'high' );
		add_meta_box( 'new_meta_boxes_post', 'Epic'  . ' Post Settings', 'new_meta_boxes_post', 'post', 'normal', 'high' );
		add_meta_box( 'new_meta_boxes_slider', 'Epic'  . ' Slider Settings', 'new_meta_boxes_slider', 'slider', 'normal', 'high' );
		add_meta_box( 'new_meta_boxes_portfolio', 'Epic'  . ' Portfolio Settings', 'new_meta_boxes_portfolio', 'portfolio', 'normal', 'high' );
		add_meta_box( 'new_meta_boxes_portfolioba', 'Epic'  . ' Before / After images', 'new_meta_boxes_portfolioba', 'portfolio', 'side', 'low' );
	}
}

function save_postdata( $post_id ) {
	
	if ( !wp_verify_nonce(isset($_POST['Epic_meta_box_nonce']) ? $_POST['Epic_meta_box_nonce'] : '', basename(__FILE__)) ) {
		
		return $post_id;
	}
	
	if ( wp_is_post_revision( $post_id ) or wp_is_post_autosave( $post_id ) )
		return $post_id;
		
	global $post, $new_meta_boxes;

	foreach($new_meta_boxes as $meta_box) {
		
		if ( $meta_box['type'] != 'title)' ) {
		
			if ( 'page' == $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id ))
					return $post_id;
			} else {
				if ( !current_user_can( 'edit_post', $post_id ))
					return $post_id;
			}
			
			if (isset($_POST[$meta_box['name']]) && is_array($_POST[$meta_box['name']]) ) {
				$cats = '';
				foreach($_POST[$meta_box['name']] as $cat){
					$cats .= $cat . ",";
				}
				$data = substr($cats, 0, -1);
			}
			
			else { $data = ''; if(isset($_POST[$meta_box['name']])) $data = $_POST[$meta_box['name']]; }

			$imageuploadlocation = "";
			$metaboxname = "";
			$metaboxname_upload = "";
			 
			if($meta_box['type'] == 'image') 
			{
				
				$metaboxname = $meta_box['name'];
				$metaboxname_upload = $metaboxname.'_upload';
			 
				if(isset($_FILES[$metaboxname_upload]) && $_FILES[$metaboxname_upload]['name'] != "") 
				{
					
					$overrides = array( 'test_form' => false);
					$imagefile=wp_handle_upload($_FILES[$metaboxname_upload], $overrides);
					$imageuploadlocation = $imagefile['url'];
					
					delete_post_meta($post_id, $metaboxname, get_post_meta($post_id, $metaboxname, true));
					add_post_meta($post_id, $metaboxname, $imageuploadlocation, true);
				} 
				else 
				{
					$imageuploadlocation = isset($metaboxname) ? get_post_meta($post_id, $metaboxname, true) : '';
					delete_post_meta($post_id, $metaboxname, get_post_meta($post_id, $metaboxname, true));
					if (isset( $_POST[$metaboxname]))
					{
						add_post_meta($post_id, $metaboxname, $_POST[$metaboxname], true);
					}
				} 
			 
			} 
			else
			{			
				if(get_post_meta($post_id, $meta_box['name']) == "")
					add_post_meta($post_id, $meta_box['name'], $data, true);
				elseif($data != get_post_meta($post_id, $meta_box['name'], true))
					update_post_meta($post_id, $meta_box['name'], $data);
				elseif($data == "")
					delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
			}	
		}
	}
}

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');

?>