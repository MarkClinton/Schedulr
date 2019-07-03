<?php

class Email_client extends CI_Controller{

	protected $mail;

	protected $reset_link = 'http://localhost:8080/Schedulr/reset_password?tok=';

	protected $subject;

	protected $body;

	protected $send_to;

	public function __construct()
    {
        require_once(APPPATH."libraries/phpmailer.php");
        require_once(APPPATH."libraries/SMTP.php");
        $this->mail = new PHPMailer();
    }

	public function setSubject($subject){
		$this->subject = $subject;
	}

	public function setBody($body){
		$this->body = $body;
	}

	public function setSendTo($address){
		$this->send_to = $address;
	}

	public function password_reset($tok, $user){
		$reset_password_link = $this->reset_link;
		$reset_password_link .= $tok;
		$body_content = file_get_contents(APPPATH.'views/email_temps/password_reset.html');
		$body_content = str_replace('%first_name_replace%', $user["first_name"], $body_content); 
		$body_content = str_replace('%last_name_replace%', $user["last_name"], $body_content); 
		$body_content = str_replace('%password_reset_link%', $reset_password_link, $body_content);
    	$this->setSubject("Password Reset From Schedulr");
		$this->setBody($body_content);
    	$this->setSendTo($user['email']);
    	$mailed = $this->send();
    	return $mailed;
	}

	public function welcome_mail($user){
		
		$body_content = file_get_contents(APPPATH.'views/email_temps/welcome.html');
		$body_content = str_replace('%first_name_replace%', $user["firstName"], $body_content); 
		$body_content = str_replace('%last_name_replace%', $user["lastName"], $body_content); 
    	$this->setSubject("Welcome to Schedulr");
		$this->setBody($body_content);
    	$this->setSendTo($user['email']);
    	$mailed = $this->send();
    	return $mailed;
	}


	public function send(){

		$this->mail->IsSMTP(); // enable SMTP
		//$this->mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$this->mail->SMTPAuth = true; // authentication enabled
		$this->mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
		$this->mail->Host = "smtp.gmail.com";
		$this->mail->Port = 465; // or 587
		$this->mail->Username = "schedulr.team@gmail.com";
		$this->mail->Password = "1207119Mc";
		$this->mail->SetFrom("schedulr.team@gmail.com");

		$this->mail->Subject = $this->subject;
		$this->mail->Body = $this->body;
		$this->mail->AddAddress($this->send_to);

		$this->mail->IsHTML(true);

		$mailCheck = [];

		if(!$this->mail->Send()) {
			// If something wrong happens with the mailer it will say this. 
			$mailCheck['code'] = 400;
			$mailCheck['response'] = "Email could not be sent. Please try again.";
			
			//print "Mailer Error: " . $this->mail->ErrorInfo;
		} else {
			$mailCheck['code'] = 200;
			$mailCheck['response'] = "Email sent";

			//echo "Message has been sent";
		}

		return $mailCheck;

	}



    
}
