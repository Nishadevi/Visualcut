<?php 
	$al_options = get_option('al_general_settings'); 
	$height = isset($al_options['al_slider3dimgh']) ?  intval ($al_options['al_slider3dimgh']+110) : 410;
	$width = isset($al_options['al_slider3dimgw']) ?  intval ($al_options['al_slider3dimgw']+100) : 1040;
	
?>
<script type="text/javascript">
	var flashvars = {};
	flashvars.cssSource = "<?php echo get_template_directory_uri() ?>/sliders/3d/piecemaker.css";
	flashvars.xmlSource = "<?php echo get_template_directory_uri() ?>/sliders/3d/piecemaker.php";
	
	var params = {};
	params.play = "true";
	params.menu = "false";
	params.scale = "showall";
	params.wmode = "transparent";
	params.allowfullscreen = "true";
	params.allowscriptaccess = "always";
	params.allownetworking = "all";
	swfobject.embedSWF('<?php echo get_template_directory_uri() ?>/sliders/3d/piecemaker.swf', 'piecemaker', '<?php echo $width?>', '<?php echo $height?>', '10', null, flashvars,    params, null);
	
</script>

    <div id="slider3d" style="width:<?php echo $width?>px; height:<?php echo $height?>px">
        <div id="piecemaker">
            <p>Please download latest flash player to enable Piecemaker slider.</p>
        </div>
    </div>
