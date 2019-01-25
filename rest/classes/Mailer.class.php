<?php

require_once(__DIR__.'/../PHPMailer/src/Exception.php');
require_once(__DIR__.'/../PHPMailer/src/PHPMailer.php');
require_once(__DIR__.'/../PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailer {
    private $mail;
    
    public function __construct(){
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = 2;
        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->Host = 'smtp.orange.fr';  // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
        $this->mail->Username = 'mathieuferron@orange.fr';                 // SMTP username
        $this->mail->Password = 'cristal86';                           // SMTP password
        $this->mail->SMTPSecure = 'ssl';            // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = 465;    
    }   

    public function send(){
        $ret = false;
        try {
            //Recipients
            $this->mail->setFrom('mathieuferron@orange.fr', 'Mailer');
            $this->mail->addAddress('mathieuferron06@gmail.com', 'Mathieu');     // Add a recipient
            $this->mail->addReplyTo('mathieuferron06@gmail.com', 'Information');
    
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    
            //Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = 'Here is the subject';
            $this->mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $this->mail->send();
            $ret = true;
        }catch (Exception $e){
            trigger_error('==== email : '.$mail->ErrorInfo);
            $ret = false;
        }
        return $ret;
    }

}