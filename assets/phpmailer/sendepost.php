<?php
require_once "src/PHPMailer.php";
require_once "src/Exception.php";
require_once "src/SMTP.php";

function setBaseMailValues()
{
  $mail = new PHPMailer\PHPMailer\PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPDebug = 0; // debugging: 1 = feil og melding, 2 = kun meldinger
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = "ssl";
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 465;
  $mail->Username = "digikortpass"; //gmail kontoenen er ein "throwaway" konto fra 3.semester som skal slettast
  $mail->Password = 'ithkrqoqytvxkyyo';
  $mail->CharSet = 'UTF-8';
  $mail->Encoding = 'base64';
  return $mail;
}

function sendMail($From, $name, $reciever_email, $subject, $message)
{
  $mail = setBaseMailValues();
  $mail->isHTML(true);
  $mail->FromName = $From;
  $mail->addAddress($reciever_email, $name);
  $mail->Subject = $subject;
  $mail->Body = $message;
  $mail->msgHTML($message);
  $mail->AltBody = trim($message);
  $mail->send();
}