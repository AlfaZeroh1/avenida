<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Salestatus_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Salestatus";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2209";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$salestatus=new Salestatus();
if(!empty($delid)){
	$salestatus->id=$delid;
	$salestatus->delete($salestatus);
	redirect("salestatus.php");
}
//Authorization.
$auth->roleid="2208";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addsalestatus_proc.php',600,430);" value="Add Salestatus " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
<?php
//Authorization.
$auth->roleid="2210";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2211";//View
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
		$fields="pos_salestatus.id, pos_salestatus.name, pos_salestatus.ipaddress, pos_salestatus.createdby, pos_salestatus.createdon, pos_salestatus.lasteditedby, pos_salestatus.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$salestatus->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$salestatus->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
<?php
//Authorization.
$auth->roleid="2210";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsalestatus_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2211";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='salestatus.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
