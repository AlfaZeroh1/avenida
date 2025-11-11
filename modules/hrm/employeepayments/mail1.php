<?php
require_once "Mail.php";
require_once "mime.php";

$from      = "mujoga@gmail.com";
$to        = "mujoga@gmail.com";
$subject   = "Test Message!";
$bodyTxt   = "Its working!";

$config=array(
    'host'      => 'ssl://smtp.googlemail.com',
    'port'      => 465,
    'auth'      => true,
    'username'  => 'mujoga',
    'password'  => 'josemariaescriva'
);

$filepath="images/logo.png";
$fileContentType="text/plain";

$mime = new Mail_Mime("\r\n");
$mime->setTXTBody($bodyTxt);
$mime->addAttachment($filepath,$fileContentType);

$headerInfo=array(
    'From'      => $from,
    'To'        => $to,
    'Subject'   => $subject
);

$body = $mime->get();
$headers = $mime->headers($headerInfo);

$smtp = Mail::factory('smtp',$config);

$mail = $smtp->send($to, $headers, $body);

if(!(PEAR::isError($mail)))
{
    echo "Mail sent successfully!";
}

else
{
    echo $mail->getMessage();
}
?>
