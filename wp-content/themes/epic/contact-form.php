<?php


//If the form is submitted
if(isset($_POST['sendmail'])) {
  
	$email= '';
	$message = '';
	$contactName = stripslashes(trim($_POST['contactName']));
	$subject = stripslashes(trim($_POST['subject']));
	$website = trim($_POST['website']);
	if (!empty($website))
	$website = '<p><strong>Mailer Website:</strong><span>'.$website.'</span></p>';
	
	$al_options = explode('|', $_POST['options']);

	//If there is no error, send the email
	if(!isset($hasError)) {
		if(trim($_POST['contactName']) === '') {
			$nameError = _e('You forgot to enter your name.', 'Epic');
			$hasError = true;
		} 
		else {
			$name = trim($_POST['contactName']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$emailError = _e('You forgot to enter your email address.', 'Epic');
			$hasError = true;
		} else if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", trim($_POST['email']))) {
            $emailError = 'You entered an invalid email address.';
            $hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
		 
		//Check to make sure comments were entered 
		if(trim($_POST['message']) === '') {
			$messageError = _e('You forgot to enter your message.', 'Epic');
			$hasError = true;
		} 
		else {
			if(function_exists('stripslashes')) {
		  		$message = stripslashes(trim($_POST['message']));
		 	} 
		 	else {
		  		$message = trim($_POST['message']);
			}
		}
	}
	if(!isset($hasError)) {
		
		$status = "";
		
		require_once "library/class.phpmailer.php";
		$mail = new PHPMailer();
		$mail->IsMail();
		$mail->IsHTML(true);    
		$mail->CharSet  = "utf-8";
		$mail->From     = $email;
		$mail->FromName = $contactName;
		$mail->WordWrap = 50;    
		$mail->Subject  = $subject;
		$mail->Body     =  $message.''; 
		$mail->AddAddress($al_options[3]);
		$mail->AddReplyTo($_POST['email']);
		
		if(!$mail->Send()) {  // send e-mail
			$status =  '<div class="error"><p>'.$al_options[0].'</p></div>';
		}
		else
		{
			$status =  '<div class="success"><p>'.$al_options[1].'</p></div>';
		}
		echo $status; die();
		
	} 

	die;
} 

?>