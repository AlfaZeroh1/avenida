<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Prepaidbilling_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Prepaidbilling";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8308";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$prepaidbilling=new Prepaidbilling();
if(!empty($delid)){
	$prepaidbilling->id=$delid;
	$prepaidbilling->delete($prepaidbilling);
	redirect("prepaidbilling.php");
}
//Authorization.
$auth->roleid="8307";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprepaidbilling_proc.php',600,430);" value="Add Prepaidbilling " type="button"/></div>
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
<?php
//Authorization.
$auth->roleid="8309";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8310";//Add
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
		$fields="prk_prepaidbilling.User_id, prk_prepaidbilling.User_id_type, prk_prepaidbilling.Transaction_Type, prk_prepaidbilling.Transaction_Amount, prk_prepaidbilling.Account_Balance, prk_prepaidbilling.Card_number";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$prepaidbilling->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$prepaidbilling->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->User_id; ?></td>
			<td><?php echo $row->User_id_type; ?></td>
			<td><?php echo $row->Transaction_Type; ?></td>
			<td><?php echo formatNumber($row->Transaction_Amount); ?></td>
			<td><?php echo formatNumber($row->Account_Balance); ?></td>
			<td><?php echo $row->Card_number; ?></td>
<?php
//Authorization.
$auth->roleid="8309";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprepaidbilling_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8310";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='prepaidbilling.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
