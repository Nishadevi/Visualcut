<?php /* 
Template Name: Under Construction 
*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=UTF-8" /> 
	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
    <link rel="stylesheet" type="text/css"  media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="shortcut icon" href="<?php echo $al_options['al_favicon'] ?>" /> 
 	<?php $skin = isset($al_options['al_skin']) && $al_options['al_skin'] != '' ? $al_options['al_skin'] : 'light'; ?>
    <?php if ($skin == 'dark'):?>
    	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/skins/dark/style.css" /> 
  	<?php endif?>
   	<?php  $al_options = get_option('al_general_settings'); ?>
	<?php  
		$date = explode('/', $al_options['al_uc_ldate']);
		if(empty($date)) $date = array(24,06,2012);
	?>
   	<?php include (TEMPLATEPATH . '/css/dynamic-styles.php'); ?>
   	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Arimo" />
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Oswald" />
   
	
    
    <!--[if lte IE 6]>
    	<script src="<?php echo get_template_directory_uri()  ?>/js/ie6/warning.js"></script>
        <script>window.onload=function(){e("<?php echo get_template_directory_uri()  ?>/js/ie6/")}</script>
    <![endif]-->
    <!--[if IE ]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()  ?>/css/ie.css" /><![endif]-->
  	
   <?php wp_head(); ?>
   <script src="<?php echo get_template_directory_uri()  ?>/js/jquery.countdown.min.js" type="text/javascript"></script>
   <script type="text/javascript">
		jQuery(document).ready(function(){ 
			jQuery('#countdown_dashboard').countDown({
				targetDate: {
					'day': 		<?php echo $date[0]?>,
					'month': 	<?php echo $date[1]?>,
					'year': 	<?php echo $date[2]?>,
					'hour': 	11,
					'min': 		0,
					'sec': 		0
				}
			});
    	}); 
    </script> 
</head>

<body id="under-construction">

<!-- BEGIN HEADER -->

<div class="navbar">       
    <div id="cs-logo">
        <img src="<?php echo $al_options['al_uclogo']?>" alt=""  />
    </div>
</div>    
<!-- END HEADER -->
    
<div id="container" class="pagecontents" style="top:320px">
    <div class="center">
        <h3 class="coming-soon"><?php echo $al_options['al_uc_maincaption']?></h3>
        <p><?php echo $al_options['al_uc_pr_head_text']?></p>
        <div class="bottombar" style="margin:60px 0px">
            <div id="countdown_dashboard">
                <div class="dash weeks_dash">
                    <span class="dash_title"><?php _e('weeks', 'Epic') ?></span>
                    <div class="digit">0</div>
                    <div class="digit">0</div>
                </div>
            
                <div class="dash days_dash">
                    <span class="dash_title"><?php _e('days', 'Epic') ?></span>
                    <div class="digit">0</div>
                    <div class="digit">0</div>
                </div>
            
                <div class="dash hours_dash">
                    <span class="dash_title"><?php _e('hours', 'Epic') ?></span>
                    <div class="digit">0</div>
                    <div class="digit">0</div>
                </div>
            
                <div class="dash minutes_dash">
                    <span class="dash_title"><?php _e('minutes', 'Epic') ?></span>
                    <div class="digit">0</div>
                    <div class="digit">0</div>
                </div>
            
                <div class="dash seconds_dash">
                    <span class="dash_title"><?php _e('seconds', 'Epic') ?></span>
                    <div class="digit">0</div>
                    <div class="digit">0</div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
		<?php if (isset($al_options['al_uc_social']) && $al_options['al_uc_social'] != ''):?>
            <div id="uc-social" ><?php echo do_shortcode($al_options['al_uc_social'])?></div>
        <?php endif?>
    </div>    
</div>     
<?php wp_footer() ?>
</body>
</html>

