<?php
    require_once("phpmailer/src/PHPMailer.php");
    require_once("phpmailer/src/Exception.php");
    require_once("phpmailer/src/SMTP.php");

    function setBaseMailValues() {
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPDebug = 0; // debug modes: 0, 1, 2, 3, 4.
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = "digikortpass";
        $mail->Password = "yawlkmrtncwhxyoj";
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";
        return $mail;
    }

    function sendMail($reciever_email, $subject, $message, $reciever_name = "", $sender_name = "Digikort") {
        try {
            $mail = setBaseMailValues();
            $mail->isHTML(true);
            $mail->FromName = $sender_name;
            $mail->addAddress($reciever_email, $reciever_name);
            $mail->Subject = $subject;
            $mail->Body = $message;
            $mail->msgHTML($message);
            $mail->AltBody = trim($message);
            $mail->send();
            return true;
        } catch (Exception $e) {
            //echo $e->getMessage();
            return false;
        }
    }
?>