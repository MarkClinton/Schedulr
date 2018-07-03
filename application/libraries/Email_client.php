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
        $this->mail = new phpmailer();
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

    	$this->setSubject("Password Reset From Schedulr");
    	$this->setBody(
    		"Hey " .
    		$user['first_name'] .
    		".<br> You requested a password reset from us. Please follow the link below to reset it. <br>" .
    		"<a href=" . $this->reset_link . $tok .">" . $this->reset_link . $tok . "</a>"
    	);
    	//$this->setBody(file_get_contents(APPPATH.'views/email_temps/password_reset.html'));
    	$this->setSendTo($user['email']);
    	$mailed = $this->send();
    	return $mailed;
	}

	public function welcome_mail($user){
		
		$this->setSubject("Welcome To Schedulr");
    	$this->setBody(
    		"Hey " .
    		$user['firstName'] . " " . $user['lastName'] .
    		".<br> Thanks for signing up to Schedulr!"
    	);
    	//$this->setBody(file_get_contents(APPPATH.'views/email_temps/password_reset.html'));
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
			$mailCheck['code'] = 400;
			$mailCheck['response'] = "Email could not be sent. Please try again";
			
			//echo "Mailer Error: " . $this->mail->ErrorInfo;
		} else {
			$mailCheck['code'] = 200;
			$mailCheck['response'] = "Email sent";

			//echo "Message has been sent";
		}

		return $mailCheck;

	}
    
}
