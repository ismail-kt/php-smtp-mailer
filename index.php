<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

//inputs to string begin here 
$string='';
$string.="ENQUIRY MAIL <br>";
$string.="Name : ".$_REQUEST['name']."<br>";  //form submited name
$string.="Mail : ".$_REQUEST['mail']."<br>";  //form submited EMAIL
$string.="Number : ".$_REQUEST['num']."<br>"; //form submited CONTCT NUMBER
$string.="Message : ".$_REQUEST['msg']."<br>";  //form submited MESSAGE

$mailtext_o = stripslashes($string);
$mailtext = preg_replace("|\n|","<br>","$mailtext_o");  

$mail = new PHPMailer(true);

$mail->SMTPDebug = 4;
$mail->isSMTP();
$mail->Host = '<MAILER HOST / SERVER>';
$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->Port = 465; //MOSTLY 465

$mail->mailer = "smtp";

$mail->Username = '<EMAIL ADDRESS FOR SMTP>';
$mail->Password = '<PASSWORD FOR SMTP EMAIL>';

// Sender and recipient address
$mail->SetFrom($_REQUEST['mail'], $_REQUEST['name']);  //adding from header to email, preferably email address submited
$mail->addAddress('<to email address>', '<name>');
$mail->addReplyTo($_REQUEST['mail'], $_REQUEST['name']); //adding reply to header to email

// Setting the subject and body
$mail->IsHTML(true);
$mail->Subject = "a mail from :".$_REQUEST['name'];  //subject to mail
$mail->Body = $mailtext; //assigning body as submited details
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';  //alt text

if (!$mail->send()) {
    echo 'Message could not be sent.';  //error
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
  echo 'Message sent.'; //on success
}
?>