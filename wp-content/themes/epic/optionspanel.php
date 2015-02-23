<script type="text/javascript">
<!--
jQuery(document).ready(function(){	
						
	jQuery('#options-handler').toggle(function() {
		jQuery(this).animate({"marginLeft": "+=234px"}, "slow").addClass('active');
		jQuery('#switch-panel').animate({"marginLeft": "+=234px"}, "slow"); 
	}, 

	function() {
		jQuery('#switch-panel').animate({"marginLeft": "-=234px"}, "slow");
		jQuery(this).animate({"marginLeft": "-=234px"}, "slow").removeClass('active'); 
	});
});
/********** THEME SWITCHER ***********/

jQuery(document).ready(function(){
	/* cookie vars */
	var cookie_name = "epic_skin";
	var cookie_options = { path: '/', expires: 7 };
	
	var get_cookie = jQuery.cookie('epic_skin');
	if(get_cookie == null) // If no cookie is set apply default theme
	{
		get_cookie = 'light';
	}
	
	
	jQuery(".skin-background").live('click', function() {
		// Switch theme based on user's choice (via 'themes' page's radio button)
		
		var themename = jQuery(this).find('a').attr("rel");			
		jQuery.cookie('epic_skin', themename, cookie_options);
		jQuery('.skin-background').removeClass('active-th');
		jQuery(this).addClass('active-th');
		
		if (themename=='dark')
		{
			jQuery('head').append('<link rel="stylesheet" id="dark-theme" type="text/css" href="<?php echo get_template_directory_uri() ?>/skins/dark/style.css" />'); 
			jQuery('#pricing-table-1').addClass('pricing-dark');
			//jQuery('#logo-image').attr('src', 'http://ignitethemes.com/themeforest/epic/dark/images/logo.png');
		}
		else
		{
			jQuery('#dark-theme').remove();
			jQuery('#pricing-table-1').removeClass('pricing-dark');
			//jQuery('#logo-image').attr('src', 'http://igniteflash.com/themeforest/epic/light/images/logo.png');
		}
		
		
		return false;
	});
	
	if (get_cookie=='dark')
	{
		jQuery("a[rel='dark']").parent().addClass('active-th');
		jQuery('head').append('<link rel="stylesheet" id="dark-theme" type="text/css" href="<?php echo get_template_directory_uri() ?>/skins/dark/style.css" />'); 
		jQuery('#pricing-table-1').addClass('pricing-dark');
		//jQuery('#logo-image').attr('src', 'http://igniteflash.com/themeforest/epic/dark/images/logo.png');
	}
	else
	{
		jQuery("a[rel='light']").parent().addClass('active-th');
		jQuery('#dark-theme').remove();
		jQuery('#pricing-table-1').removeClass('pricing-dark');
		//jQuery('#logo-image').attr('src', 'http://igniteflash.com/themeforest/epic/light/images/logo.png');
	}
});
-->
</script>
<?php
//$al_options = get_option('al_general_settings'); 



$fonts = array(
	array('value'=>'off', 'text'=>'None / Disabled'),
	array('value'=>'Aclonica', 'text'=>'Aclonica'),
	array('value'=>'Allan', 'text'=>'Allan'),
	array('value'=>'Allerta', 'text'=>'Allerta'),
	array('value'=>'Allerta Stencil', 'text'=>'Allerta Stencil'),
	array('value'=>'Amaranth', 'text'=>'Amaranth'),
	array('value'=>'Annie Use Your Telescope', 'text'=>'Annie Use Your Telescope'),
	array('value'=>'Anonymous Pro', 'text'=>'Anonymous Pro'),
	array('value'=>'Allerta', 'text'=>'Allerta'),
	array('value'=>'Allerta Stencil', 'text'=>'Allerta Stencil'),
	array('value'=>'Anonymous Pro:regular,italic,bold,bolditalic', 'text'=>'Anonymous Pro (plus italic, bold, and bold italic)'),
	array('value'=>'Anton', 'text'=>'Anton'),
	array('value'=>'Architects Daughter', 'text'=>'Architects Daughter'),
	array('value'=>'Arimo', 'text'=>'Arimo'),
	array('value'=>'Arimo:regular,italic,bold,bolditalic', 'text'=>'Arimo (plus italic, bold, and bold italic)'),
	array('value'=>'Arvo', 'text'=>'Arvo'),
	array('value'=>'Arvo:regular,italic,bold,bolditalic', 'text'=>'Arvo (plus italic, bold, and bold italic)'),
	array('value'=>'Astloch', 'text'=>'Astloch'),
	array('value'=>'Astloch:regular,bold', 'text'=>'Astloch (plus bold)'),
	array('value'=>'Bangers', 'text'=>'Bangers'),
	array('value'=>'Bentham', 'text'=>'Bentham'),
	array('value'=>'Bevan', 'text'=>'Bevan'),
	array('value'=>'Bigshot One', 'text'=>'Bigshot One'),
	array('value'=>'Brawler', 'text'=>'Brawler'),
	array('value'=>'Buda:light', 'text'=>'Buda'),
	array('value'=>'Cabin', 'text'=>'Cabin'),
	array('value'=>'Cabin:regular,500,600,bold', 'text'=>'Cabin (plus 500, 600, and bold)'),
	array('value'=>'Cabin Sketch:bold', 'text'=>'Cabin Sketch'),
	array('value'=>'Calligraffitti', 'text'=>'Calligraffitti'),
	array('value'=>'Candal', 'text'=>'Candal'),
	array('value'=>'Cantarell', 'text'=>'Cantarell'),
	array('value'=>'Cantarell:regular,italic,bold,bolditalic', 'text'=>'Cantarell (plus italic, bold, and bold italic)'),
	array('value'=>'Cardo', 'text'=>'Cardo'),
	array('value'=>'Carter One', 'text'=>'Carter One'),
	array('value'=>'Cherry Cream Soda', 'text'=>'Cherry Cream Soda'),
	array('value'=>'Chewy', 'text'=>'Chewy'),
	array('value'=>'Coda', 'text'=>'Coda'),
	array('value'=>'Coming Soon', 'text'=>'Coming Soon'),
	array('value'=>'Copse', 'text'=>'Copse'),
	array('value'=>'Corben:bold', 'text'=>'Corben'),
	array('value'=>'Cousine', 'text'=>'Cousine'),
	array('value'=>'Cousine:regular,italic,bold,bolditalic', 'text'=>'Cousine (plus italic, bold, and bold italic)'),
	array('value'=>'Covered By Your Grace', 'text'=>'Covered By Your Grace'),
	array('value'=>'Crafty Girls', 'text'=>'Crafty Girls'),
	array('value'=>'Crimson Text', 'text'=>'Crimson Text'),
	array('value'=>'Crushed', 'text'=>'Crushed'),
	array('value'=>'Cuprum', 'text'=>'Cuprum'),
	array('value'=>'Damion', 'text'=>'Damion'),
	array('value'=>'Dancing Script', 'text'=>'Dancing Script'),
	array('value'=>'Dawning of a New Day', 'text'=>'Dawning of a New Day'),
	array('value'=>'Didact Gothic', 'text'=>'Didact Gothic'),
	array('value'=>'Droid Sans', 'text'=>'Droid Sans'),		
	array('value'=>'Droid Sans:regular,bold', 'text'=>'Droid Sans (plus bold)'),
	array('value'=>'Droid Sans Mono', 'text'=>'Droid Sans Mono'),
	array('value'=>'Droid Serif', 'text'=>'Droid Serif'),
	array('value'=>'Droid Serif:regular,italic,bold,bolditalic', 'text'=>'Droid Serif (plus italic, bold, and bold italic)'),
	array('value'=>'EB Garamond', 'text'=>'EB Garamond'),
	array('value'=>'Expletus Sans', 'text'=>'Expletus Sans'),
	array('value'=>'Expletus Sans:regular,500,600,bold', 'text'=>'Expletus Sans (plus 500, 600, and bold)'),
	array('value'=>'Fontdiner Swanky', 'text'=>'Fontdiner Swanky'),
	array('value'=>'Francois One', 'text'=>'Francois One'),
	array('value'=>'Geo', 'text'=>'Geo'),	
	array('value'=>'Goudy Bookletter 1911', 'text'=>'Goudy Bookletter 1911'),
	array('value'=>'Gruppo', 'text'=>'Gruppo'),
	array('value'=>'Holtwood One SC', 'text'=>'Holtwood One SC'),
	array('value'=>'Homemade Apple', 'text'=>'Homemade Apple'),
	array('value'=>'Inconsolata', 'text'=>'Inconsolata'),
	array('value'=>'Indie Flower', 'text'=>'Indie Flower'),
	array('value'=>'IM Fell DW Pica', 'text'=>'IM Fell DW Pica'),
	array('value'=>'IM Fell DW Pica:regular,italic', 'text'=>'IM Fell DW Pica (plus italic)'),
	array('value'=>'IM Fell DW Pica SC', 'text'=>'IM Fell DW Pica SC'),
	array('value'=>'IM Fell Double Pica', 'text'=>'IM Fell Double Pica'),
	array('value'=>'IM Fell English', 'text'=>'IM Fell English'),
	array('value'=>'IM Fell English:regular,italic', 'text'=>'IM Fell English (plus italic)'),	
	array('value'=>'IM Fell English SC', 'text'=>'IM Fell English SC'),
	array('value'=>'IM Fell French Canon', 'text'=>'IM Fell French Canon'),
	array('value'=>'IM Fell French Canon:regular,italic', 'text'=>'IM Fell French Canon (plus italic)'),
	array('value'=>'IM Fell French Canon SC', 'text'=>'IM Fell French Canon SC'),
	array('value'=>'IM Fell Great Primer', 'text'=>'IM Fell Great Primer'),
	array('value'=>'IM Fell Great Primer:regular,italic', 'text'=>'IM Fell Great Primer (plus italic)'),
	array('value'=>'IM Fell Great Primer SC', 'text'=>'IM Fell Great Primer SC'),
	array('value'=>'Irish Grover', 'text'=>'Irish Grover'),
	array('value'=>'Irish Growler', 'text'=>'Irish Growler'),
	array('value'=>'Josefin Sans:100,100italic', 'text'=>'Josefin Sans 100 (plus italic)'),
	array('value'=>'Josefin Sans:light,lightitalic', 'text'=>'Josefin Sans Light 300 (plus italic)'),
	array('value'=>'Josefin Sans:regular,regularitalic', 'text'=>'Josefin Sans Regular 400 (plus italic)'),
	array('value'=>'Josefin Sans:bold,bolditalic', 'text'=>'Josefin Sans Bold 700 (plus italic)'),
	array('value'=>'Josefin Slab:100,100italic', 'text'=>'Josefin Slab 100 (plus italic)'),		
	array('value'=>'Josefin Slab:light,lightitalic', 'text'=>'Josefin Slab Light 300 (plus italic)'),
	array('value'=>'Josefin Slab:600,600italic', 'text'=>'Josefin Slab 600 (plus italic)'),
	array('value'=>'Josefin Slab:bold,bolditalic', 'text'=>'Josefin Slab Bold 700 (plus italic)'),
	array('value'=>'Judson', 'text'=>'Judson'),
	array('value'=>'Judson:regular,regularitalic,bold', 'text'=>'Judson (plus bold)'),
	array('value'=>'Just Another Hand', 'text'=>'Just Another Hand'),
	array('value'=>'Just Me Again Down Here', 'text'=>'Just Me Again Down Here'),
	array('value'=>'Kenia', 'text'=>'Kenia'),
	array('value'=>'Kranky', 'text'=>'Kranky'),
	array('value'=>'Kreon:light,regular,bold', 'text'=>'Kreon (plus light and bold)'),
	array('value'=>'Kristi', 'text'=>'Kristi'),
	array('value'=>'Lato:100,100italic', 'text'=>'Lato Light 100 (plus italic)'),
	array('value'=>'Lato:regular,regularitalic', 'text'=>'Lato Regular 400 (plus italic)'),
	array('value'=>'Lato:bold,bolditalic', 'text'=>'Lato Bold 700 (plus italic)'),
	array('value'=>'Lato:900,900italic', 'text'=>'Lato 900 (plus italic)'),
	array('value'=>'League Script', 'text'=>'League Script'),
	array('value'=>'Lekton', 'text'=>'Lekton'),
	array('value'=>'Lekton:regular,italic,bold', 'text'=>'Lekton (plus italic and bold)'),
	array('value'=>'Lobster', 'text'=>'Lobster'),
	array('value'=>'Luckiest Guy', 'text'=>'Luckiest Guy'),
	array('value'=>'Maiden Orange', 'text'=>'Maiden Orange'),
	array('value'=>'Mako', 'text'=>'Mako'),
	array('value'=>'Meddon', 'text'=>'Meddon'),
	array('value'=>'MedievalSharp', 'text'=>'MedievalSharp'),
	array('value'=>'Megrim', 'text'=>'Megrim'),
	array('value'=>'Merriweather', 'text'=>'Merriweather'),
	array('value'=>'Metrophobic', 'text'=>'Metrophobic'),
	array('value'=>'Michroma', 'text'=>'Michroma'),
	array('value'=>'Miltonian Tattoo', 'text'=>'Miltonian Tattoo'),
	array('value'=>'Miltonian', 'text'=>'Miltonian'),
	array('value'=>'Monofett', 'text'=>'Monofett'),
	array('value'=>'Molengo', 'text'=>'Molengo'),
	array('value'=>'Mountains of Christmas', 'text'=>'Mountains of Christmas'),
	array('value'=>'News Cycle', 'text'=>'News Cycle'),
	array('value'=>'Nobile', 'text'=>'Nobile'),
	array('value'=>'Nobile:regular,italic,bold,bolditalic', 'text'=>'Nobile (plus italic, bold, and bold italic)'),
	array('value'=>'Nova Cut', 'text'=>'Nova Cut'),
	array('value'=>'Nova Flat', 'text'=>'Nova Flat'),
	array('value'=>'Nova Mono', 'text'=>'Nova Mono'),
	array('value'=>'Nova Oval', 'text'=>'Nova Oval'),
	array('value'=>'Nova Round', 'text'=>'Nova Round'),
	array('value'=>'Nova Script', 'text'=>'Nova Script'),
	array('value'=>'Nova Slim', 'text'=>'Nova Slim'),
	array('value'=>'Nova Square', 'text'=>'Nova Square'),
	array('value'=>'Neucha', 'text'=>'Neucha'),
	array('value'=>'Neuton', 'text'=>'Neuton'),
	array('value'=>'Nunito:light,regular,bold', 'text'=>'Nunito'),
	array('value'=>'OFL Sorts Mill Goudy TT', 'text'=>'OFL Sorts Mill Goudy TT'),
	array('value'=>'Old Standard TT', 'text'=>'Old Standard TT'),
	array('value'=>'Old Standard TT:regular,italic,bold', 'text'=>'Old Standard TT (plus italic and bold)'),
	array('value'=>'Open Sans:light,lightitalic', 'text'=>'Open Sans light'),
	array('value'=>'Open Sans:regular,regularitalic', 'text'=>'Open Sans regular'),
	array('value'=>'Open Sans:light,lightitalic,regular,regularitalic,600,600italic,bold,bolditalic,800,800italic', 'text'=>'Open Sans (all types)'),
	array('value'=>'Open Sans Condensed:light,lightitalic', 'text'=>'Open Sans Condensed'),
	array('value'=>'Orbitron', 'text'=>'Orbitron Regular (400)'),
	array('value'=>'Orbitron:bold', 'text'=>'Orbitron (Bold)'),
	array('value'=>'Oswald', 'text'=>'Oswald'),
	array('value'=>'Over the Rainbow', 'text'=>'Over the Rainbow'),
	array('value'=>'Reenie Beanie', 'text'=>'Reenie Beanie'),
	array('value'=>'Pacifico', 'text'=>'Pacifico'),
	array('value'=>'Paytone One', 'text'=>'Paytone One'),
	array('value'=>'Permanent Marker', 'text'=>'Permanent Marker'),
	array('value'=>'Philosopher', 'text'=>'Philosopher'),
	array('value'=>'Play:regular,bold', 'text'=>'Play (plus bold)'),
	array('value'=>'PT Sans:regular,italic,bold,bolditalic', 'text'=>'PT Sans (plus itlic, bold, and bold italic)'),
	array('value'=>'PT Sans Caption:regular,bold', 'text'=>'PT Sans Caption (plus bold)'),
	array('value'=>'PT Sans Narrow:regular,bold', 'text'=>'PT Sans Narrow (plus bold)'),
	array('value'=>'PT Serif:regular,italic,bold,bolditalic', 'text'=>'PT Serif (plus italic, bold, and bold italic)'),
	array('value'=>'PT Serif Caption:regular,italic', 'text'=>'PT Serif Caption (plus italic)'),
	array('value'=>'Puritan:regular,italic,bold,bolditalic', 'text'=>'>Puritan (plus italic, bold, and bold italic)'),
	array('value'=>'Quattrocento', 'text'=>'Quattrocento'),
	array('value'=>'Quattrocento', 'text'=>'Quattrocento'),
	array('value'=>'Quattrocento Sans', 'text'=>'Quattrocento Sans'),
	array('value'=>'Radley', 'text'=>'Radley'),
	array('value'=>'Raleway', 'text'=>'Raleway'),
	array('value'=>'Rock Salt', 'text'=>'Rock Salt'),
	array('value'=>'Rokkitt', 'text'=>'Rokkitt'),
	array('value'=>'Schoolbell', 'text'=>'Schoolbell'),
	array('value'=>'Shanti', 'text'=>'Shanti'),
	array('value'=>'Sigmar One', 'text'=>'Sigmar One'),
	array('value'=>'Six Caps', 'text'=>'Six Caps'),
	array('value'=>'Slackey', 'text'=>'Slackey'),
	array('value'=>'Smythe', 'text'=>'Smythe'),
	array('value'=>'Sniglet 800', 'text'=>'Sniglet'),
	array('value'=>'Special Elite', 'text'=>'Special Elite'),
	array('value'=>'Sue Ellen Francisco', 'text'=>'Sue Ellen Francisco'),
	array('value'=>'Sunshiney', 'text'=>'Sunshiney'),
	array('value'=>'Swanky and Moo Moo', 'text'=>'Swanky and Moo Moo'),
	array('value'=>'Syncopate', 'text'=>'Syncopate'),
	array('value'=>'Tangerine', 'text'=>'Tangerine'),
	array('value'=>'Terminal Dosis Light', 'text'=>'Terminal Dosis Light'),
	array('value'=>'The Girl Next Door', 'text'=>'The Girl Next Door'),
	array('value'=>'Tinos', 'text'=>'Tinos'),
	array('value'=>'Tinos:regular,italic,bold,bolditalic', 'text'=>'Tinos (plus italic, bold, and bold italic)'),
	array('value'=>'Ubuntu', 'text'=>'Ubuntu'),
	array('value'=>'Ubuntu:regular,italic,bold,bolditalic', 'text'=>'Ubuntu (plus italic, bold, and bold italic)'),
	array('value'=>'Ultra', 'text'=>'Ultra'),
	array('value'=>'Unkempt', 'text'=>'Unkempt'),
	array('value'=>'UnifrakturCook:bold', 'text'=>'UnifrakturCook'),
	array('value'=>'UnifrakturMaguntia', 'text'=>'UnifrakturMaguntia'),
	array('value'=>'Vibur', 'text'=>'Vibur'),
	array('value'=>'Vollkorn', 'text'=>'Vollkorn'),
	array('value'=>'Vollkorn:regular,italic,bold,bolditalic', 'text'=>'Vollkorn (plus italic, bold, and bold italic)'),
	array('value'=>'VT323', 'text'=>'VT323'),
	array('value'=>'Waiting for the Sunrise', 'text'=>'Waiting for the Sunrise'),
	array('value'=>'Wallpoet', 'text'=>'Wallpoet'),
	array('value'=>'Walter Turncoat', 'text'=>'Walter Turncoat'),
	array('value'=>'Yanone Kaffeesatz', 'text'=>'Yanone Kaffeesatz'),
	array('value'=>'Yanone Kaffeesatz:700', 'text'=>'Yanone Kaffeesatz (Bold)')
);


?>
<div id="switch-wrapper">
	<div id="options-handler"></div>
	<div id="switch-panel">
		<h3>Skins</h3>
			<div class="skin-background">
		   		<a href="#" rel="light">
                	<img src="<?php bloginfo('template_directory'); ?>/skins/light.png" alt="Light skin" width="80" height="73" />
	        	</a>
                <p>Light version</p>
		   </div>	
			<div class="skin-background" style="margin-right:0">
		   		<a href="#" rel="dark">
                	<img src="<?php bloginfo('template_directory'); ?>/skins/dark.png" alt="Dark skin" width="80" height="73" />
	        	</a>
                <p>Dark version</p>
		   </div>	
		
        <div class="clear"></div>
        
        <h3 style="padding-top:20px">Fonts</h3>
        <form method="post" action="" id="font-form">
        	<div>
                <label for="body-font">Body</label>
                <select name="bodyFont" id="body-font">
                    <?php foreach ($fonts as $font):?>
                        <option value="<?php echo $font['value']?>" <?php if(isset($_SESSION['bodyFont']) && $_SESSION['bodyFont'] == $font['value']):?>selected="selected"<?php endif?>><?php echo $font['text']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div>
                <label for="headings-font">Headings</label>
                <select name="headingsFont" id="headings-font">
                    <?php foreach ($fonts as $font):?>
                        <option value="<?php echo $font['value']?>" <?php if(isset($_SESSION['headingsFont']) && $_SESSION['headingsFont'] == $font['value']):?>selected="selected"<?php endif?>><?php echo $font['text']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div>
                <label for="menu-font">Top Menu</label>
                <select name="menuFont" id="menu-font">
                    <?php foreach ($fonts as $font):?>
                        <option value="<?php echo $font['value']?>" <?php if(isset($_SESSION['menuFont']) && $_SESSION['menuFont'] == $font['value']):?>selected="selected"<?php endif?>><?php echo $font['text']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div style="text-align:right; margin-top:20px">
            	<input type="submit" name="saveValues" value="Update Values" class="button highlight small" />
            </div>
        </form>
	</div>
</div>