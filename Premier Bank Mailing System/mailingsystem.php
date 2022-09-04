
<?php
$connection= mysqli_connect('localhost','root','','users');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//require_once 'Autoloader.php';
require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';
include "vendor/autoload.php";
$mpdf=new \Mpdf\Mpdf();
include 'mail_temp.html';
$mail = new PHPMailer(true);

try {


    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'java.emailsadik@gmail.com';
    $mail->Password   = 'moosmpglcilbmbbo';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->setFrom('java.emailsadik@gmail.com', 'Umar Sadik Mailing System');

if(!$connection){
die("not conneccted".mysql_error());
}
$query= "SELECT*FROM user_infoo";
$exchange= mysqli_query($connection,$query);
$count= mysqli_num_rows($exchange);

if($count>0){

              while ($row= mysqli_fetch_assoc($exchange)) {
//for($i=0;$i<$count;$i++){
//$pdf = new FPDF() ;
$dbmail=($row['email']);
$mail->addBCC($dbmail);
$username = $row['user_name'];
$email_template = 'mail_temp.html';
$message = file_get_contents($email_template);
  $message = str_replace('%username%', $username, $message);
  $mail->addBCC($dbmail);
    $mail->isHTML(true);
    $newu= $username;

  //  $mail->Subject = 'Here is the subject'.time();
    //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



    include "vendor/autoload.php";
    $mpdf=new \Mpdf\Mpdf();
  $mpdf->SetDisplayMode('fullpage');
    //$mail->Subject = $subject;
    $mpdf->WriteHTML($message);
    $pdf = $username.".pdf";
    $new= $pdf;
    $mpdf->output($pdf,"");
  $mail->MsgHTML($message);
  $path= $mail->addAttachment($pdf);
  //$mail->addAttachment($);
if ($newu.".pdf"== $new)
{
  if ($mail->send())
    {

    echo "Email Sent to".$row['email']."...";
    //clear(true);
  unlink($pdf);

}
    else{
    echo"Failed";
    }
}
  else {
  echo"Failed";
  }

}





              }


else{
  echo"no data";
}


}

catch (Exception $e) {
    echo "/////";
}
