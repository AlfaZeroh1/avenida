<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
$servername = "localhost";
$username = "root";
$password = "wisedigits";
$dbname = "wisedb";



// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$phone = $_POST['User_Email'];
$pass = $_POST['User_Password'];

$lastlogin="";
$status="";  //if status equals 0, no error success message is generated
$error="";
$message="--";
$userid="";


// ==================================================MAINTENANCE SECTION====================
/*
*For maintenance Alert message set the message in the maintain variable below
Once done set it to "okay"
*/
$maintain="okay";
// $maintain="MAINTENANCE IN PROGRESS!!! Try Again after 2 minutes";
// ======================================================================================

$sql = "select * from auth_users where username = '$phone' and password = md5('$pass') ";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!empty($row['status'])){     
    if($row['status']=="Active"){
      $status=0;$message="Successfully Logged in";$userid=$row['id'];
      echo $status.";".$error.";".$message.";".$userid.";".$maintain.";";
    }
    if($row['status']=="Inactive"){
    $status=1;$error="Your Account is <b>Dormant</b>.Consult Admin";$userid=$row['id'];
      echo $status.";".$error.";".$message.";".$userid.";".$maintain.";";
    
    }
    if($row['status']=="blocked"){
    $status=1;$error="Sorry, your account is <b>Blocked</b> at the moment.<br/>Please Consult Admin";$userid=$row['id'];
      echo $status.";".$error.";".$message.";".$userid.";".$maintain.";";
     
    }else{
      $status=1;$error="Account is <b>Not accessible</b> at the moment.<br/>Try again or Seek technical help";$userid=$row['id'];
      echo $status.";".$error.";".$message.";".$userid.";".$maintain.";";
    }
  }else{
      $status=1;$error="Invalid <b>Username</b> or <b>Password</b> Please Try Again !";$userid=0;
      echo $status.";".$error.";".$message.";".$userid.";".$maintain.";";
  }
}else{
  echo "Check Again";
}

$conn->close();

?>