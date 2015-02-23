<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title>Visual Cut</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
        <link href="<?php bloginfo('template_url'); ?>/css/bootstrap.css" rel="stylesheet">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet">
	<script type='text/javascript'>
		(function (d, t) {
		  var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
		  bh.type = 'text/javascript';
		  bh.src = '//www.bugherd.com/sidebarv2.js?apikey=cwvpph28fovm6v5ec2saxw';
		  s.parentNode.insertBefore(bh, s);
		  })(document, 'script');
	</script>
        <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="page">
		<header id="header">
			<nav class="navbar" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<div class="logo navbar-brand"><a href="<?php bloginfo('url') ?>"><img src="<?php bloginfo('template_url'); ?>/images/logo.png" alt="Visual Cut" /></a></div>
					</div>
					<div class="collapse navbar-collapse" id="navbar">
						<?php
						 wp_nav_menu(
								array(
									'theme_location' => 'primary',
									'depth' => 2,
									'container' => 'nav',
									'container_id' => 'primary-nav',
									'container_class' => '',
									'menu_id' => 'nav'
								)
						);
						?>
					</div>
				</div>
			</nav>
		</header>
            