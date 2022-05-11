<?php


class mail_envio {

	public $from = 'info@almazaradevaldeverdeja.com';
	private $name = "La Almazara de Valdeverdeja";
	public $to;
	public $replyto, $nameto;
	public $texto;
	public $subject;
	public $adjunto, $adjuntos;
	public $error;
	
	public $xml;
	
	private $host = "smtp.almazaradevaldeverdeja.com";
  	private $username = "info@almazaradevaldeverdeja.com";
	private $password = 'bASqwef1fG!';

	
	function enviar() {
	
		require("lib/phpmailer/class.phpmailer.php");
  	    $mail = new PHPMailer();

		$mail->IsSMTP();
		
		$mail->Mailer = "smtp";
		$mail->Host = $this->host;
		$mail->Username = $this->username;
		$mail->Password = $this->password;
		$mail->SMTPAuth = true;
		
		$mail->From = $this->from;
		$mail->FromName = $this->name;
		$mail->Subject = $this->subject;
		$mail->Body = $this->texto;
		$mail->AddReplyTo($this->replyto, $this->nameto);
		
		$mail->IsHTML(true);
		
		if ($this->to) {
			foreach($this->to as $to) {
				$mail->AddAddress($to);
			}
		}
		
		$intentos=1; 
		$exito = $mail->Send();
		
	   if(!$exito) {
			$this->error = $mail->ErrorInfo;	
		} else {
			$this->error = "";
		} 
		
		return;
		
	}

	
	
	
	
	

	
		
	
	

}



?>
