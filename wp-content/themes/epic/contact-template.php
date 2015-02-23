<?php /* 
Template Name: Contact Form 
*/ ?>

<?php get_header(); ?>
 <?php $promo = get_post_meta($post->ID, "_promo", $single = false);?>
<?php if(!empty($promo[0]) ):?>

    <div class="smallbar top20"></div>
    <div class="calloutcontainer">
        <div class="container_12">
            <div class="grid_12">            
                <?php echo do_shortcode($promo[0]);?>
            </div>
        </div>
    </div>  
 
<?php endif?>
<div class="container_12">
	
    <div class="grid_12">
        <div class="clear"></div>
        <div class="pagetitle1">
            <h2>
                <?php 
					$headline = get_post_meta($post->ID, "_headline", $single = false);
                	if(!empty($headline[0]) ){echo $headline[0];}
                	else{echo get_the_title();} 
				?>
            </h2>
            <?php if(class_exists('the_breadcrumb') && $al_options['al_allow_breadcrumbs']){ $bc = new the_breadcrumb;} ?>
            <div class="clearnospacing"></div>   
         </div>
        <div class="divider"></div>  
    </div>
    <div class="clearnospacing"></div>
</div>

<div class="pagecontents">
    <div class="container_12">
        <div class="grid_9">	
             <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                    <?php if(isset($hasError) || isset($captchaError)): ?>
                        <p class="error"><?php _e('There was an error submitting the form.', 'Epic')?><p>
                    <?php endif ?>
                        
                    <form action="" id="contactForm" method="post" class="clearfix contactsubmit">
                        <p><?php _e('Your email address will not be shared. Required fields are marked *', 'Epic')?></p>
                        <div class="clearsmall"></div>
                        <div id="registerErrors"></div>
                       	<div class="grid_3">
                            <label for="contactName"><?php _e( 'Name', 'Epic' ); ?><span>*</span></label>
                            <input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="requiredField txt" />
                            <?php if(isset($nameError) && $nameError != ''): ?><span class="error"><?php echo $nameError;?></span><?php endif;?>
                        </div>
                        <div class="grid_3 omega">    
                            <label for="email"><?php _e( 'E-mail', 'Epic' ); ?><span>*</span></label>
                            <input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" class="requiredField txt" />
                            <?php if(isset($emailError) && $emailError != ''): ?><span class="error"><?php echo $emailError;?></span><?php endif;?>
                        </div>
                        <div class="grid_3 clearfix">
                            <label for="subject"><?php _e( 'Subject', 'Epic' ); ?></label>
                            <input type="text" name="subject" value="<?php if(isset($_POST['subject'])) echo $_POST['subject'];?>" class="txt" id="subject" />
                            <?php if(isset($subject) && !$subject = ''): ?><span class="error"><?php echo $subjectError;?></span><?php endif;?>
                        </div>
                        <div class="grid_3 omega">
                            <label for="website"><?php _e( 'Website', 'Epic' ); ?></label>
                            <input type="text" name="website" value="<?php if(isset($_POST['website'])) echo $_POST['website'];?>" class="txt" id="website" />
                            <?php if(isset($website) && !$website = ''): ?><span class="error"><?php echo $websiteError;?></span><?php endif;?>
                        </div>
                        <div class="grid_6 clearfix">
                            <label for="message"><?php _e( 'Message', 'Epic' ); ?><span>*</span></label>
                            <textarea name="message" cols="100" rows="200" id="message" class="txt requiredField"><?php echo isset($_POST['message']) && $_POST['message']!='' ?  stripslashes($_POST['message'])  : ''?></textarea>
                            <?php if(isset($messageError) && $messageError != '') { ?>
                                <span class="error"><?php echo $messageError;?></span> 
                            <?php } ?>
                        </div>                       
                        <div class="grid_6 clearfix">
                            <?php 
                                $al_options = get_option('al_general_settings'); 
                                $options = array(
                                    $al_options['al_contact_error_message'], 
                                    $al_options['al_contact_success_message'],
                                    $al_options['al_subject'],
                                    $al_options['al_email_address']
                                );
                            ?>
                            <input type="hidden" name = "options" value="<?php echo implode('|', $options) ?>" />
                            <input type="hidden" name="siteurl" value="<?php echo get_option('blogname')?>" />
                            <input type="submit" id="send" class="button highlight small" name="sendmail" value="<?php _e( 'Send Message', 'Epic' ); ?>" />
                            <div class="clear"></div>
                        </div>
                    </form>
                <?php endwhile; ?>
            <?php endif; ?>   
        </div>
        <div class="grid_3 sidebarright alignright">
        	<?php generated_dynamic_sidebar() ?>
        </div>
        <div class="clear"></div>
    </div>
</div>

   
<script type="text/javascript">

jQuery(document).ready(function(){
  jQuery("#contactForm").validate({
	submitHandler: function() {
	
		var postvalues =  jQuery(".contactsubmit").serialize();
		jQuery.ajax
		 ({
		   type: "POST",
		   url: "<?php echo get_template_directory_uri()  ?>/contact-form.php",
		   data: postvalues,
		   success: function(response)
		   {
		 	 jQuery("#registerErrors").addClass('success-message').html(response).show('normal');
		     jQuery('.contactsubmit :input.not("#send")').val("");
		 	 jQuery('.contactsubmit #message').val("");
		   }
		 });
		return false;
		
    },
	focusInvalid: true,
	focusCleanup: false,
	errorLabelContainer: jQuery("#registerErrors"),
  	rules: 
	{
		contactName: {required: true},
		email: {required: true, minlength: 6,maxlength: 50, email:true},
		message: {required: true}
	},
	
	messages: 
	{
		contactName: {required: "<?php _e( 'Name is required', 'Epic' ); ?>"},
		email: {required: "<?php _e( 'E-mail is required', 'Epic' ); ?>", email: "<?php _e( 'Please provide a valid e-mail', 'Epic' ); ?>"},
		message: {required: "<?php _e( 'Message is required', 'Epic' ); ?>"}
		
	},
	
	errorPlacement: function(error, element) 
	{
		var er = element.attr("name");
		error.insertAfter(element);
	},
	invalidHandler: function()
	{
		jQuery("#contactForm").scrollTop(jQuery("#contactForm").scrollTop() + 100);
	}
});
});
</script>
<?php get_footer(); ?>   

