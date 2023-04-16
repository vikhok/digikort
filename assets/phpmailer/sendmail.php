<?php
use src\PHPMailer.php;


require_once "..\assets\src\PHPMailer.php";
require_once "..\assets\src\Exception.php";
require_once "..\assets\src\SMTP.php";

// function setBaseMailValues()
if(isset($_POST["submit"]))
{
  $mail = new PHPMailer(true);
  $mail->IsSMTP();
  $mail->SMTPDebug = 0; // debugging: 1 = feil og melding, 2 = kun meldinger
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = "ssl";
  $mail->Host = "smtp.gmail.com";
  $mail->Port = 465;
  $mail->Username = "digikortpass@gmail.com"; //gmail kontoenen er ein "throwaway" konto fra 3.semester som skal slettast
  $mail->Password = 'ithkrqoqytvxkyyo';
  $mail->CharSet = 'UTF-8';
  $mail->Encoding = 'base64';

  $mail->setFrom("digikortpass@gmail.com");
  $mail->addAddress($_POST["email"]);
  $mail->isHTML(true);

  $mail->Subject = $_POST["name"];
  $mail->Body = $_POST["message"];

  $mail->send();

  
  
}

// function sendMail($From, $name, $email, $subject, $message)
// {
//   $mail = setBaseMailValues();
//   $mail->isHTML(true);
//   $mail->FromName = $From;
//   $mail->addAddress($email, $name);
//   $mail->Subject = $subject;
//   $mail->Body = $message;
//   $mail->msgHTML($message);
//   $mail->AltBody = trim($message);
//   $mail->send();
// }

echo
"
<script>
alert('Melding sendt');
document.location.href = 'contact-employee.php'
</script>
;"

?>