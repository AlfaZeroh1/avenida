<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once 'php.php';
require_once '../employees/Employees_class.php';
require_once("../../sys/config/Config_class.php");
require_once("../configs/Configs_class.php");
// example on using PHPMailer with GMAIL

$db = new DB();

include("class.phpmailer.php");
include("class.smtp.php"); // note, this is optional - gets called from main class if not already loaded

$emp = $_SESSION['emp'];print_r($emp);
$month = $_GET['month'];
$year = $_GET['year'];

$mail             = new PHPMailer();

//$body             = $mail->getFile('../examples/contents.html');
$body             = file_get_contents('contents.html');
//$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "mail.wisedigits.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port

$query="select value from hrm_configs where name='EMAIL'";
$row=mysql_fetch_object(mysql_query($query));
$mail->Username   = $row->value;  // GMAIL username

$query="select value from hrm_configs where name='PASSWORD'";
$row=mysql_fetch_object(mysql_query($query));
$mail->Password   = $row->value;            // GMAIL password

$mail->From       = "replyto@yourdomain.com";
$mail->FromName   = "WiseDigits HRM";
$mail->Subject    = "Payslip ".getMonth($month)." ".$year;
$mail->AltBody    = ""; //Text Body
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body);

//$mail->AddAttachment("/path/to/file.zip");             // attachment
//$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment

$num = count($emp);
$i=0;
while($i<$num){

$employees = new Employees();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='".$emp[$i]."' and email!=''";
$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$employees=$employees->fetchObject;

//create a resource folder
$config = new Config();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where name='DMS_RESOURCE'";
$config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$config=$config->fetchObject;
$i++;

//make pdf
payslip($employees->id, $month, $year);
  //attach payslip
  $dir=$config->value."HRM/payslips/".$employees->pfnum."".getMonth($month)."".$year.".pdf";
  $mail->AddAttachment($dir);
  $mail->AddAddress($employees->email,$employees->firstname." ".$employees->middlename." ".$employees->lastname);

  $mail->IsHTML(true); // send as HTML

  if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
    echo "Message has been sent";
  }
}

?>
