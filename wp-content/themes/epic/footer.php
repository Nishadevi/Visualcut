<!-- BEGIN FOOTER -->
<div class="clear"></div>
<div class="footer">
	<div class="container_12">
		<?php $al_options = get_option('al_general_settings'); 
        if (isset($al_options['al_footer_logo']) && !empty($al_options['al_footer_logo'])):?>
			<div class="grid_12">
                <div class="footerlogo">
                	<img src="<?php echo $al_options['al_footer_logo'] ?>" alt=""  />
                </div>
            </div>
		<?php endif?>
		<?php
            $footer_widget_count = isset($al_options['al_footer_widgets_count']) ? $al_options['al_footer_widgets_count']:3;
          	for($i = 1; $i<= $footer_widget_count; $i++){
				echo  ($i%3==0) ? '<div class="grid_4 omega">' : '<div class="grid_4">';
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Widget ".$i) ) :endif;
				echo '</div>';
            }			
        ?>
        <div class="clear"></div>
        <?php if (isset($al_options['al_footer_social']) && !empty($al_options['al_footer_social'])):?>
            <div class="grid_12">
                <div class="socialbar">
                   <?php echo do_shortcode($al_options['al_footer_social']) ?>           
                </div> 
            </div>
            <div class="clearfooter"></div>
    	<?php endif?>
    </div>   
</div>
<div class="bottombar">
    <div class="container_12">
        <div class="grid_4">
         	<div class="copyright"><?php echo $al_options['al_copyright']?></div>
        </div>
        <div class="grid_8 omega">
           <?php  echo do_shortcode($al_options['al_footerinfo']);?>
        </div>        
	</div>
    <div class="topbutton">
    	<a href="#" class="toTop" id="w2b-StoTop">Top</a>
    </div>
    <div class="clearnospacing"></div>
</div> 
<!-- END FOOTER -->
<?php echo $al_options['al_ganalytics'];?>
<?php wp_footer()?>

</body>
</html>