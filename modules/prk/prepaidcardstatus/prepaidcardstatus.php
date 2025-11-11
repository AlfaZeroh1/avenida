<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Prepaidcardstatus_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Prepaidcardstatus";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8312";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$prepaidcardstatus=new Prepaidcardstatus();
if(!empty($delid)){
	$prepaidcardstatus->id=$delid;
	$prepaidcardstatus->delete($prepaidcardstatus);
	redirect("prepaidcardstatus.php");
}
//Authorization.
$auth->roleid="8311";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprepaidcardstatus_proc.php',600,430);" value="Add Prepaidcardstatus " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="8313";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8314";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="prk_prepaidcardstatus.Card_Number, prk_prepaidcardstatus.Amount, prk_prepaidcardstatus.Status, prk_prepaidcardstatus.User_pin, prk_prepaidcardstatus.User_id, prk_prepaidcardstatus.Card_Serial_number, prk_prepaidcardstatus.User_phone_number, prk_prepaidcardstatus.User_Pin_Retries, prk_prepaidcardstatus.User_Allowed_pin_Retries";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$prepaidcardstatus->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$prepaidcardstatus->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->Card_Number; ?></td>
			<td><?php echo $row->Amount; ?></td>
			<td><?php echo $row->Status; ?></td>
			<td><?php echo $row->User_pin; ?></td>
			<td><?php echo $row->User_id; ?></td>
			<td><?php echo $row->Card_Serial_number; ?></td>
			<td><?php echo $row->User_phone_number; ?></td>
			<td><?php echo $row->User_Pin_Retries; ?></td>
			<td><?php echo $row->User_Allowed_pin_Retries; ?></td>
<?php
//Authorization.
$auth->roleid="8313";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprepaidcardstatus_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8314";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='prepaidcardstatus.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
