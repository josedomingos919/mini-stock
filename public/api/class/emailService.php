<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once "vendor/autoload.php";

class Email {

    public function send ($data){
        
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->From = $data["from"]; // "josedomingos768@gmail.com";
        $mail->FromName = $data["fromName"]; //"José Ndonge"
        $mail->addAddress($data["to"],$data["toName"]);

        $mail->isHTML(true);
        $mail->Subject = $data["subject"]; // "Subject Text";
        $mail->Body = $data["body"];       //"<i>Mail body in HTML</i>";
        $mail->AltBody = "API-2020";

        try {
            $mail->send();
            return ["status"=>true,"info"=>"sucesso"];
        } catch (Exception $e) {
            return  ["status"=>false,"info"=>$mail->ErrorInfo];
        }
    }

}

//From email address and name

//To address and name
//$mail->addAddress("recepient1@example.com"); //Recipient name is optional

//Address to which recipient will reply
//$mail->addReplyTo("reply@yourdomain.com", "Reply");

//CC and BCC
//$mail->addCC("cc@example.com");
//$mail->addBCC("bcc@example.com");

//Send HTML or Plain Text email
//$mail->isHTML(true);

//$mail->Subject = "Subject Text";
//$mail->Body = "<i>Mail body in HTML</i>";
//$mail->AltBody = "This is the plain text version of the email content";

//try {
//    $mail->send();
//    echo "Message has been sent successfully";
//} catch (Exception $e) {
//    echo "Mailer Error: " . $mail->ErrorInfo;
//}

