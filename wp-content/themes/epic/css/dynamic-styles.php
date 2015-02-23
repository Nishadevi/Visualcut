<?php //header("Content-type: text/css");
require_once( ABSPATH . 'wp-load.php');
$al_options = get_option('al_general_settings');
?>
<style type="text/css">
<?php if ( $al_options['al_custom_background'] != '' || $al_options['al_background_color'] != '' || $al_options['al_background_repeat'] != '') :?>
body{
	<?php 	
	echo $al_options['al_custom_background'] != '' ? 'background-image:url('.$al_options['al_custom_background'].');' : '';  	
	echo $al_options['al_background_color'] != '' ? 'background-color:'.$al_options['al_background_color'].';' : '';  
	echo $al_options['al_background_repeat'] != '' ? 'background-repeat:'.$al_options['al_background_repeat'].';' : ''; 	
	?>
}
<?php endif?>
<?php if ($al_options['al_header_bg'] || $al_options['al_header_bg_static']):?>
.navbar{
	<?php if (!(empty($al_options['al_header_bg']))):?> background-image:url('<?php echo $al_options['al_header_bg']?>'); <?php endif ?> 
	<?php if (!(empty($al_options['al_header_bg_repeat']))):?> background-repeat:<?php echo $al_options['al_header_bg_repeat'] ?>; <?php endif ?> 
	<?php if (!(empty($al_options['al_header_bg_static']))):?> background-color:<?php echo $al_options['al_header_bg_static']?>; <?php endif ?> 
}
<?php endif?>
<?php if($al_options['al_menu_color'] != ''):?>
#menu ul a{color:<?php echo $al_options['al_menu_color']?>}
<?php endif?>
<?php if($al_options['al_submenu_color'] != ''):?>
#menu ul ul a{color:<?php echo $al_options['al_submenu_color']?>}
<?php endif?>
<?php if($al_options['al_menu_hover_color'] != ''):?>
#menu ul .current a, .current-menu-item a, .current_page_item a, .current_page_parent a, .current-menu-parent a, #menu ul a:hover {color:<?php echo $al_options['al_menu_hover_color'] ?> !important;}
<?php endif?>
<?php if($al_options['al_dropdown_menu_bg'] != ''):?>
#menu ul ul {background:<?php echo $al_options['al_dropdown_menu_bg']?>;}
<?php endif?>
<?php if($al_options['al_main_color']):?>
.pagecontents p, p{color:<?php echo $al_options['al_main_color']?>;}
<?php endif?>

<?php if($al_options['al_headings_color']):?>
h1, h2, h3, h4, h5, h6{color:<?php echo $al_options['al_headings_color']?>;}
<?php endif?>

<?php if($al_options['al_footer_color'] != ''):?>
.footer-block *{<?php echo 'color:'.$al_options['al_footer_color'] ?>!important;}
<?php endif?>
<?php if($al_options['al_footer_bg'] != ''):?>
.footer{
	background-image:url('<?php echo $al_options['al_footer_bg']?>'); 
	background-repeat:<?php echo $al_options['footer_bg_repeat'] ?>;	
	<?php if($al_options['al_footer_bg_color'] != ''):?>background-color:<?php	echo  $al_options['al_footer_bg_color'] ?><?php endif?>;
}
<?php endif?>


</style>