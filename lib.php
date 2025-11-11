<?php
function initialCap($val)
{
	$str = explode(" ",$val);
	$len = count($str);
	$i=$len;
	$strn="";
	$j=0;
	while($i>0)
	{
		$strn.=strtoupper(substr($str[$j],0,1))."".substr($str[$j],1)." ";
		$j++;
		$i--;
	}
	return $strn;
}

function initialCapL($val)
{
	$str = explode(" ",$val);
	$len = count($str);
	$i=$len;
	$strn="";
	$j=0;
	while($i>0)
	{
		$strn.=strtoupper(substr($str[$j],0,1))."".strtolower(substr($str[$j],1))." ";
		$j++;
		$i--;
	}
	return $strn;
}

function formatNouns($val)
{
	$str = explode(" ",$val);
	$len = count($str);
	$i=$len;
	$strn="";
	$j=0;
	while($i>0)
	{
		$strn.=strtoupper(substr($str[$j],0,1))."".strtolower(substr($str[$j],1))." ";
		$j++;
		$i--;
	}
	return $strn;
}

function formatNumber($num)
{
	$ext = explode(".",$num);
	if(empty($ext[1]))
		return number_format($num,2,'.',',');
	else
		return number_format($num,2,'.',',');
	return $num;
}

function formatNumberP($num)
{
	$ext = explode(".",$num);
	if(empty($ext[1]))
		return number_format($num,2,'.','');
	else
		return number_format($num,2,'.','');
	return $num;
}

function formatNumberto4($num)
{
	$ext = explode(".",$num);
	if(empty($ext[1]))
		return number_format($num,4,'.',',');
	else
		return number_format($num,4,'.',',');
	return $num;
}

function formatNumberD($num,$n)
{
	$ext = explode(".",$num);
	if(empty($ext[1]))
		return number_format($num,$n,'.',',');
	else
		return number_format($num,$n,'.',',');
	return $num;
}

function getMonth($month){
	if(!empty($month))
		return date('M', mktime(0, 0, 0, $month, 1, 2000));
}

function getDat($date){
	if(!empty($date) && $date!=="0000-00-00")
		return date("dS",strtotime($date));
}

function getDates($year,$month,$date,$bool=false){
	
	return mktime(0, 0, 0,  date("Y",$year),date("m",$month)  , date("d",$date));
}

function formatNumbertoZero($num)
{
	$ext = explode(".",$num);
	 if(empty($ext[1]))
		return number_format($num,0,'.',',');
	else
		return number_format($num,0,'.',',');
	return $num;
}

function formatDate($date)
{
	if(!empty($date) && $date!=="0000-00-00")
		return date("d-m-Y",strtotime($date));
}

function showError($error)
{
	if(!empty($error))
	{
	?>
    <script type="text/javascript">        
	alert("<?php echo $error; ?>");
	</script>
    <?
	}
}
function logging($str){
	$fd=fopen("data.log","a");
	fwrite($fd,$str."\n");
	fclose($fd);
}
function redirect($url,$new=false){
if(!$new)
{
?><HEAD>
		<SCRIPT language="JavaScript1.1">
			<!--
				location.replace("<? echo $url ?>");
			//-->
		</SCRIPT>
	</HEAD>
<?
}else{
?><HEAD>
		<SCRIPT language="JavaScript1.1">
			<!--
				window.open("<? echo $url ?>","_blank");
			//-->
		</SCRIPT>
	</HEAD>
<?
}
}
function firstThree($str){
	$st=explode(' ',$str);
	for($i=0;$i<count($st);$i++){
		$s.=substr($st[$i],0,3)." ";
	}
	return $s;
}

function addTime($time,$minutes){
	$date = date("H:i", strtotime('+ '.$minutes.' minutes',strtotime($time)));
	return $date;
}
function addDate($date,$days){
	$date = date('Y-m-d',strtotime($date . "+".$days." days"));
	return $date;
}

function sendMail($to,$subject,$message) {
	$from = "jgatheru@wisedigits.com";
	$headers = "From:" . $from;
	if(mail($to,$subject,$message,$headers))
		echo "Mail Sent.";
	else
		echo "Mail not Sent.";
}

function auth($auth)
{
	$auth->roleid=$auth->roleid;
	$auth->levelid=$auth->levelid;
	if(!existsRule($auth))
	{
		$levelerror=1;
		redirect("../../../modules/auth/users/login.php?levelerror=".$levelerror);
	}
}

function moduleAuth($moduleid,$levelid){
        $query="select * from auth_rules where roleid in (select id from auth_roles where moduleid='$moduleid') and levelid='$levelid'";//echo $query;
	mysql_query($query);
	if(mysql_affected_rows()>0)
	  return true;
	else
	  return false;
}

function modularAuth($moduleid,$levelid,$module,$submodule){
	$query="select * from auth_rules where roleid in (select id from auth_roles where name like 'view $module $submodule%') and levelid='$levelid'";
	mysql_query($query);
	if(mysql_affected_rows()>0)
	  return true;
	else
	  return false;
}

function checkSubModule($module, $sub){
   $query="select * from sys_modules where name='$module'";
  $res=mysql_query($query);
    $rw=mysql_fetch_object($res);
    
    $sql="select * from auth_rules where roleid in(select id from auth_roles where moduleid='$rw->id' and module='$sub') and levelid='".$_SESSION['level']."'";
    mysql_query($sql);
    if(mysql_affected_rows()>0){
      return true;
    }else{
      return false;
    }
    
}

function reportAuth($moduleid,$levelid){
        $query="select * from auth_rules where roleid in (select id from auth_roles where moduleid='$moduleid' and name like 'report%') and levelid='$levelid'";//echo $query;
	mysql_query($query);
	if(mysql_affected_rows()>0)
	  return true;
	else
	  return false;
}

function existsRule($auth){

	$rules=new Rules ();
	$fields=" * " ;
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where roleid='$auth->roleid' and levelid='$auth->levelid'";
	$rules->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $rules->sql;
	if($rules->affectedRows>0)
		return true;
	else
		return false;

}
function img_resize( $tmpname, $size, $save_dir, $save_name )
{
	$save_dir .= ( substr($save_dir,-1) != "/") ? "/" : "";
	$gis       = GetImageSize($tmpname);
	$type       = $gis[2];
	switch($type)
	{
		case "1": $imorig = imagecreatefromgif($tmpname); break;
		case "2": $imorig = imagecreatefromjpeg($tmpname);break;
		case "3": $imorig = imagecreatefrompng($tmpname); break;
		default:  $imorig = imagecreatefromjpeg($tmpname);
	}

	$x = imageSX($imorig);
	$y = imageSY($imorig);
	if($gis[0] <= $size)
	{
		$av = $x;
		$ah = $y;
	}
	else
	{
		$yc = $y*1.3333333;
		$d = $x>$yc?$x:$yc;
		$c = $d>$size ? $size/$d : $size;
		$av = $x*$c;        //высота исходной картинки
		$ah = $y*$c;        //длина исходной картинки
	}
	$im = imagecreate($av, $ah);
	$im = imagecreatetruecolor($av,$ah);
	if (imagecopyresampled($im,$imorig , 0,0,0,0,$av,$ah,$x,$y))
		if (imagejpeg($im, $save_dir.$save_name)) {
		echo"Success\n";
		return true;
	}
	else {
		echo"Failure\n";
		return false;
	}
}
function sendNotification($email,$name,$subject,$body){
  include("../../../class.phpmailer.php");
  include("../../../class.smtp.php");
  
  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
  $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
  $mail->Port       = 465;                   // set the SMTP port

  $mail->Username   = "mujoga@gmail.com";  // GMAIL username
  $mail->Password   = "josemariaescriva";            // GMAIL password

  $mail->From       = "replyto@yourdomain.com";
  $mail->FromName   = "WiseDigits ERP";
  $mail->Subject    = $subject;
  $mail->AltBody    = ""; //Text Body
  $mail->WordWrap   = 50; // set word wrap
  
  $mail->MsgHTML($body);
  
  $body .= file_get_contents('mail.html');
  
  $mail->AddAddress($email,$name);

  $mail->IsHTML(true); // send as HTML

  if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
    echo "Message has been sent";
  }
}
function executeQuery($query){
$db = new DB();
  if($db->driver=="mysql"){
    $res = mysql_query($query);
    return $res;
  }
  else if($db->driver=="mssql"){
    return mssql_query($query);
  }
}

function fetchObject($rs){
  $db = new DB();
  if($db->driver=="mysql"){
    return mysql_fetch_object($rs);
  }
  else if($db->driver=="mssql"){
    return mssql_fetch_object($rs);
  }
}

function modularAuthR($moduleid,$levelid){
	$query="select * from auth_rules where roleid in (select id from auth_roles where moduleid='$moduleid') and levelid='$levelid'";
	mysql_query($query);
	if(mysql_affected_rows()>0)
	  return true;
	else
	  return false;
}

function searchForId($id, $array, $field, $warmth) {
   $i=0;
   while($i<count($array))
   {  	
    if($array[$i][$field]==$id and $array[$i]['warmth']==$warmth)
    {
      return $i;
    }
    $i++;
   }
   return -1;
}

function searchForId3($id, $array, $field) {
   $i=0;
   while($i<count($array))
   {  	
    if($array[$i][$field]==$id)
    {
      return $i;
    }
    $i++;
   }
   return -1;
}

function searchForId2($id, $array,$field) {
   foreach ($array as $key => $val) {
       if ($val[$field] === $id) {
           return $key;
       }
   }
   return count($array);
}

function getQntPackage($package,$quantity){

   if(!empty($package)){
    if(($quantity/$package)>1 or ($quantity/$package)<-1)
      return round($quantity/$package,2);
   }
   return $quantity;
}

function getPricePackage($package, $cost){

   if(!empty($package)){
      $cost = $package*$cost;
   }
   return $cost;
}

?>