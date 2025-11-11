<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Prepaidprovisioning_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Prepaidprovisioning";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8316";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$prepaidprovisioning=new Prepaidprovisioning();
if(!empty($delid)){
	$prepaidprovisioning->id=$delid;
	$prepaidprovisioning->delete($prepaidprovisioning);
	redirect("prepaidprovisioning.php");
}
//Authorization.
$auth->roleid="8315";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprepaidprovisioning_proc.php',600,430);" value="Add Prepaidprovisioning " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="8317";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8318";//Add
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
		$fields="prk_prepaidprovisioning.Card_Number, prk_prepaidprovisioning.Amount, prk_prepaidprovisioning.Status, prk_prepaidprovisioning.Hash_Key";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$prepaidprovisioning->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$prepaidprovisioning->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->Card_Number; ?></td>
			<td><?php echo $row->Amount; ?></td>
			<td><?php echo $row->Status; ?></td>
			<td><?php echo formatNumber($row->Hash_Key); ?></td>
<?php
//Authorization.
$auth->roleid="8317";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprepaidprovisioning_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8318";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='prepaidprovisioning.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
