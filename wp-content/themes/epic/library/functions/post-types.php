<?php
/*************** SLIDER POST-TYPES  ****************/
add_action('init', 'slider_items_register');

function slider_items_register() 
{
	$args = array(
       'label' => 'Slider Items',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'page',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' )
    );
	register_post_type( 'slider' , $args);
	
	//add_filter('manage_edit-slider_columns', 'slider_edit_columns');
	//add_action('manage_posts_custom_column',  'slider_custom_columns');	
	
}

add_action( 'admin_menu', 'register_slider_menu' );

function register_slider_menu() {
	add_submenu_page(
		'edit.php?post_type=slider',
		'Order Slides',
		'Order',
		'edit_pages', 'slides-order',
		'slider_order_page'
	);
}


function slider_order_page() 
{
	?></pre>
	<div class="wrap">
        <h2><?php _e('Sort Slides', 'Epic')?></h2>
        <?php _e('Simply drag the slides up or down and they will be saved in that order.', 'Epic')?>
        
        <?php $slides = new WP_Query( array( 'post_type' => 'slider', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) ); ?>
        <table id="sortable-table" class="wp-list-table widefat fixed posts">
            <thead>
                <tr>
                    <th class="column-order"><?php _e('Order', 'Epic')?></th>
                    <th class="column-title"><?php _e('Title', 'Epic')?></th>
                    <th class="column-thumbnail"><?php _e('Thumbnail', 'Epic')?></th>
         
                </tr>
            </thead>
            <tbody data-post-type="slider"><!--?php while( $products--->
				<?php if( $slides->have_posts() )  : ?>
                    <?php while ($slides->have_posts()): $slides->the_post(); ?>
                        <tr id="post-<?php the_ID(); ?>">
                            <td class="column-order"><img title="" src="<?php echo get_stylesheet_directory_uri() . '/images/move-icon.png'; ?>" alt="Move Icon" width="32" height="32" /></td>
                            <td class="column-title"><strong><?php the_title(); ?></strong></td>
                    		<td class="column-thumbnail"><?php the_post_thumbnail( 'blog-thumb' ); ?></td>
                         </tr>
                    <?php endwhile; ?>
                <?php else : ?>        
                    <?php _e('No slides found, make sure you to create one:', 'Epic')?> <a href="post-new.php?post_type=product"><?php _e('Create a new slider item', 'Epic')?></a>.
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>	
            </tbody>
            <tfoot>
                <tr>
                    <th class="column-order"><?php _e('Order', 'Epic')?></th>
                    <th class="column-title"><?php _e('Title', 'Epic')?></th>
                    <th class="column-thumbnail"><?php _e('Thumbnail', 'Epic')?></th>
                </tr>
            </tfoot>
        </table>
 	</div>
	<pre>
	<!-- .wrap -->	
	<?php 
}

add_action( 'wp_ajax_sneek_update_post_order', 'sneek_update_post_order' );

function sneek_update_post_order() {
	global $wpdb;

	$post_type     = $_POST['postType'];
	$order        = $_POST['order'];

	/**
	*    Expect: $sorted = array(
	*                menu_order => post-XX
	*            );
	*/
	foreach( $order as $menu_order => $post_id )
	{
		$post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order     = intval($menu_order);
		wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
	}

	die( '1' );
}

function add_slide()
{
	add_meta_box("slider_details", "Slider Options", "slider_options", "slider", "normal", "low");
}
	
function slider_options()
{
	global $post;
	$custom = get_post_custom($post->ID);
	$slide_url = isset($custom["slide_url"][0]) ? $custom["slide_url"][0] : '';
	?>
	<div class="al_input">
		<label for="slideurl">Slide URL:</label>
		<input name="slide_url" id="slideurl" value="<?php echo $slide_url; ?>" />
		<small>Url the slide refers to. Leave blank if you don't want it to be a link.</small><div class="clearfix"></div>		
	</div>   
	<?php
}

function update_slide_url()
{
	global $post;
	if(isset($_POST["slide_url"]))
	update_post_meta($post->ID, "slide_url", $_POST["slide_url"]);
}


add_filter("manage_edit-slider_columns", "slider_edit_columns");
add_action("manage_posts_custom_column",  "slider_columns_display");
 
function slider_edit_columns($portfolio_columns){
	$slider_columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Slide Title",
		"description" => "Description",
		"slide_url" => "Slide url",
		'slider_image' => 'Image',
	);
	return $slider_columns;
}
 
function slider_columns_display($slider_columns){
	switch ($slider_columns)
	{
		case "description":
			the_excerpt();
			break;
		case 'slider_image':
			the_post_thumbnail( 'blog-thumb' );
		break;
		case 'slide_url':  
			$custom = get_post_custom();  
			echo $custom['slide_url'][0];  
			break;  				
	}
}




/*************** PORTFOLIO POST-TYPES  ****************/
add_action('init', 'portfolio_register');

function portfolio_register() {	

	register_post_type( 'portfolio' , 
						array(
							'label' => 'Portfolio',
							'singular_label' => 'Portfolio',
							'exclude_from_search' => false,
							'publicly_queryable' => true,
							//'rewrite' => array('with_front' => false),
							'menu_position' => null,
							'show_ui' => true, 
							'query_var' => true,
							'capability_type' => 'page',
							'hierarchical' => false,
							'edit_item' => __( 'Edit Work', 'Epic'),
							'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments', 'revisions')
						)
					);

	register_taxonomy( 'portfolio_category', 
						'portfolio', 
						array( 'hierarchical' => true, 
								'label' => __('Categories', 'Epic'),
								'singular_label' => __('Category', 'Epic'), 
								'public' => true,
  								'show_tagcloud' => false,
								'query_var' => 'true',
			 					'rewrite' => array('slug' => 'portfolio_category' , 'with_front' => false)
						)
					);  
	
	add_filter('manage_edit-portfolio_columns', 'portfolio_edit_columns');
	add_action('manage_posts_custom_column',  'portfolio_custom_columns');
	
	function portfolio_edit_columns($columns){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => 'Title',
			'portfolio_category' => 'Category',
			'portfolio_description' => 'Description',
			'portfolio_image' => 'Image Preview'
		);
	
		return $columns;
	}
	
	function portfolio_custom_columns($column){
		global $post;
		switch ($column)
		{
			case "portfolio_category":  
				echo get_the_term_list($post->ID, 'portfolio_category', '', ', ','');  
				break;  

			case 'portfolio_description':
				the_excerpt();  
				break;  

			case 'portfolio_image':
				the_post_thumbnail( 'blog-thumb' );
				break;
		}
	}
}


function my_post_type_link_filter_function( $post_link, $id = 0, $leavename = FALSE ) {
    if ( strpos('%portfolio_category%', $post_link)  < 0 ) {
      return $post_link;
    }
    $post = get_post($id);
    if ( !is_object($post) || $post->post_type != 'portfolio' ) {
      return $post_link;
    }
    $terms = wp_get_object_terms($post->ID, 'portfolio_category');
    if ( !$terms ) {
      return str_replace('portfolio/category/%portfolio_category%/', '', $post_link);
    }
    return str_replace('%portfolio_category%', $terms[0]->slug, $post_link);
}
  
add_filter('post_type_link', 'my_post_type_link_filter_function', 1, 3);
  


add_action( 'admin_menu', 'register_portfolio_menu' );

function register_portfolio_menu() {
	add_submenu_page(
		'edit.php?post_type=portfolio',
		'Order portfolio',
		'Sort items',
		'edit_pages', 'portfolio-order',
		'portfolio_order_page'
	);
}


function portfolio_order_page() 
{
	?></pre>
	<div class="wrap">
        <h2>Sort Items</h2>
        Simply drag the items up or down and they will be saved in that order.
        
        <?php $slides = new WP_Query( array( 'post_type' => 'portfolio', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) ); ?>
        <table id="sortable-table-portfolio" class="wp-list-table widefat fixed posts">
            <thead>
                <tr>
                    <th class="column-order">Order</th>
                    <th class="column-title">Title</th>
                    <th class="column-thumbnail">Thumbnail</th>
         
                </tr>
            </thead>
            <tbody data-post-type="portfolio"><!--?php while( $products--->
				<?php if( $slides->have_posts() )  : ?>
                    <?php while ($slides->have_posts()): $slides->the_post(); ?>
                        <tr id="post-<?php the_ID(); ?>">
                            <td class="column-order"><img title="" src="<?php echo get_stylesheet_directory_uri() . '/images/move-icon.png'; ?>" alt="Move Icon" width="32" height="32" /></td>
                            <td class="column-title"><strong><?php the_title(); ?></strong></td>
                    		<td class="column-thumbnail"><?php the_post_thumbnail( 'blog-thumb' ); ?></td>
                         </tr>
                    <?php endwhile; ?>
                <?php else : ?>        
                    No portfolio items found, make sure you <a href="post-new.php?post_type=portfolio">create one</a>.
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>	
            </tbody>
            <tfoot>
                <tr>
                    <th class="column-order">Order</th>
                    <th class="column-title">Title</th>
                    <th class="column-thumbnail">Thumbnail</th>
                </tr>
            </tfoot>
        </table>
 	</div>
	<pre>
	<!-- .wrap -->	
	<?php 
}

add_action( 'wp_ajax_portfolio_update_post_order', 'portfolio_update_post_order' );

function portfolio_update_post_order() {
	global $wpdb;

	$post_type     = $_POST['postType'];
	$order        = $_POST['order'];

	/**
	*    Expect: $sorted = array(
	*                menu_order => post-XX
	*            );
	*/
	foreach( $order as $menu_order => $post_id )
	{
		$post_id         = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order     = intval($menu_order);
		wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
	}

	die( '1' );
}



?>