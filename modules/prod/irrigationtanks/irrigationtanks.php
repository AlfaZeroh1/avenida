<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Irrigationtanks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Irrigationtanks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9222";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$irrigationtanks=new Irrigationtanks();
if(!empty($delid)){
	$irrigationtanks->id=$delid;
	$irrigationtanks->delete($irrigationtanks);
	redirect("irrigationtanks.php");
}
//Authorization.
$auth->roleid="9221";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addirrigationtanks_proc.php',600,430);" value="Add Irrigationtanks " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Irrigation Tank </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9223";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9224";//Add
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
		$fields="prod_irrigationtanks.id, prod_irrigationtanks.name, prod_irrigationtanks.remarks, prod_irrigationtanks.ipaddress, prod_irrigationtanks.createdby, prod_irrigationtanks.createdon, prod_irrigationtanks.lasteditedby, prod_irrigationtanks.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$irrigationtanks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$irrigationtanks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9223";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addirrigationtanks_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9224";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='irrigationtanks.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
