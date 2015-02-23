<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  <?php language_attributes( ) ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=UTF-8" /> 
	
	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
    
	<link rel="alternate" type="application/rss+xml" title="RSS2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="stylesheet" type="text/css"  media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

	<?php  $al_options = get_option('al_general_settings'); ?>
	
   	<?php if(!empty($al_options['al_favicon'])):?>
	<link rel="shortcut icon" href="<?php echo $al_options['al_favicon'] ?>" /> 
 	<?php endif?>
    <!--[if IE ]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/ie.css" /><![endif]-->
  	
   <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
   <?php wp_head(); ?>
   <?php  
		if($al_options['al_custom_js'] != '') echo $al_options['al_custom_js'];
    	$skin = isset($al_options['al_skin']) && $al_options['al_skin'] != '' ? $al_options['al_skin'] : 'light';
    ?>	
    <?php if ($skin == 'dark'):?>
       	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/skins/dark/style.css" /> 	
  	<?php endif ?>
	<?php include (TEMPLATEPATH . '/css/dynamic-styles.php'); ?>

    <?php 
   		$bodyFont = isset($al_options['al_body_font']) ? $al_options['al_body_font'] : 'off';
		$headingsFont =(isset($al_options['al_headings_font']) && $al_options['al_headings_font'] !== 'off') ? $al_options['al_headings_font'] : 'Oswald';
		$menuFont = (isset($al_options['al_menu_font']) && $al_options['al_menu_font'] !== 'off') ? $al_options['al_menu_font'] : 'Oswald';
	
		$fonts['body, p, a'] = $bodyFont;
		$fonts['h1, h2, h3, h4, .callouttext'] = $headingsFont;
		$fonts['.sf-menu > li > a'] = $menuFont;
		
		foreach ($fonts as $value => $key)
		{
			if($key != 'off' && $key != ''){ 
				$api_font = str_replace(" ", '+', $key);
				$font_name = font_name($key);
				
				echo '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family='.$api_font.'" />';
				echo "<style type=\"text/css\">".$value."{ font-family: '".$key."' !important; }</style>";			
			}
		}
	?>
<script type='text/javascript'>
(function (d, t) {
  var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
  bh.type = 'text/javascript';
  bh.src = '//www.bugherd.com/sidebarv2.js?apikey=cwvpph28fovm6v5ec2saxw';
  s.parentNode.insertBefore(bh, s);
  })(document, 'script');
</script>
</head>

<body  <?php body_class(); ?>>
<div class="bar">
	<div class="container_12">
    
        <div class="grid_6">
            <div class="mininav">
                <?php echo do_shortcode($al_options['al_header_left']) ?>
            </div>
        </div>
        
        <div class="grid_6 alignright omega">
            <!--Social Networks-->
                <div class="socialbar">
                	<?php echo do_shortcode($al_options['al_header_social']) ?>
                </div>
            <!--End Social Networks-->        
        </div>
        <div class="clear"></div>
	</div>
</div>
<!--End Top Nav-->

<!--Main Bar-->
<div class="navbar">
    <div class="container_12">
        <!--Logo-->
        <div class="grid_2 logo"> 
            <a href="<?php echo site_url() ?>">
                <?php if(!empty($al_options['al_logo'])):?>
                    <img src="<?php echo $al_options['al_logo'] ?>" alt="<?php echo $al_options['al_logotext']?>" id="logo-image" />
                <?php else:?>
                	<?php echo isset($al_options['al_logotext']) ? $al_options['al_logotext'] : 'Epic' ?>
                <?php endif?>
            </a>
        </div>
        <!--End Logo-->
        <!--Main Nav--> 
        <div class="grid_10">  
            <?php 
                if(function_exists('wp_nav_menu')):
                    wp_nav_menu( 
                    array( 
                        'menu' =>'primary_nav', 
                        'container'=>'div', 
                        'depth' => 4, 
                        'container_id' => 'menu',
                        'menu_class' => 'sf-menu'
                        )  
                    ); 
                else:
                    ?>
                    <div id="menu">
                        <ul class="sf-menu top-level-menu"><?php wp_list_pages('title_li=&depth=4'); ?></ul> 
                    </div>
                    <?php
                endif; 
            ?>
            <div class="clear"></div>
        </div>
	</div>
</div>
    