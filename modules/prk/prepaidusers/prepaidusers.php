<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Prepaidusers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Prepaidusers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8320";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$prepaidusers=new Prepaidusers();
if(!empty($delid)){
	$prepaidusers->id=$delid;
	$prepaidusers->delete($prepaidusers);
	redirect("prepaidusers.php");
}
//Authorization.
$auth->roleid="8319";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprepaidusers_proc.php',600,430);" value="Add Prepaidusers " type="button"/></div>
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
<?php
//Authorization.
$auth->roleid="8321";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8322";//Add
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
		$fields="prk_prepaidusers.User_id, prk_prepaidusers.User_pin, prk_prepaidusers.Account_balance, prk_prepaidusers.last_reload_card, prk_prepaidusers.Status, prk_prepaidusers.User_phone_number, prk_prepaidusers.User_Pin_Retries, prk_prepaidusers.User_Allowed_pin_Retries";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$prepaidusers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$prepaidusers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->User_id; ?></td>
			<td><?php echo $row->User_pin; ?></td>
			<td><?php echo $row->Account_balance; ?></td>
			<td><?php echo $row->last_reload_card; ?></td>
			<td><?php echo $row->Status; ?></td>
			<td><?php echo $row->User_phone_number; ?></td>
			<td><?php echo $row->User_Pin_Retries; ?></td>
			<td><?php echo $row->User_Allowed_pin_Retries; ?></td>
<?php
//Authorization.
$auth->roleid="8321";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprepaidusers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8322";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='prepaidusers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
