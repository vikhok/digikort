<?php
    require_once("phpmailer/src/PHPMailer.php");
    require_once("phpmailer/src/Exception.php");
    require_once("phpmailer/src/SMTP.php");

    function setBaseMailValues() {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPDebug = 0; // debugging: 1 = feil og melding, 2 = kun meldinger
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = "digikortpass";
        $mail->Password = "jwsscynhkiwjbvtw";
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";
        return $mail;
    }

    function sendMail($sender_email, $reciever_email, $reciever_name, $subject, $message) {
        try {
            $mail = setBaseMailValues();
            $mail->isHTML(true);
            $mail->FromName = $sender_email;
            $mail->addAddress($reciever_email, $reciever_name);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->msgHTML($message);
            $mail->AltBody = trim($message);
            $mail->send();
            return true;
        } catch (Exception $e) {
            // echo $e->getMessage();
            return false;
        }
    }
?>