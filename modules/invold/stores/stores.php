<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stores_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Stores";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7491";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$stores=new Stores();
if(!empty($delid)){
	$stores->id=$delid;
	$stores->delete($stores);
	redirect("stores.php");
}
//Authorization.
$auth->roleid="7490";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addstores_proc.php',600,430);" value="Add Stores " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Store </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7492";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7493";//View
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
		$fields="inv_stores.id, inv_stores.name, inv_stores.remarks, inv_stores.ipaddress, inv_stores.createdby, inv_stores.createdon, inv_stores.lasteditedby, inv_stores.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$stores->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$stores->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7492";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addstores_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7493";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='stores.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
