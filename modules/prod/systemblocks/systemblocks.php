<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Systemblocks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Systemblocks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9238";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$systemblocks=new Systemblocks();
if(!empty($delid)){
	$systemblocks->id=$delid;
	$systemblocks->delete($systemblocks);
	redirect("systemblocks.php");
}
//Authorization.
$auth->roleid="9237";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-primary" onclick="showPopWin('addsystemblocks_proc.php',600,430);" value="Add Systemblocks " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>System </th>
			<th>Block </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9239";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9240";//Add
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
		$fields="prod_systemblocks.id, prod_irrigationsystems.name as systemid, prod_blocks.name as blockid, prod_systemblocks.remarks, prod_systemblocks.ipaddress, prod_systemblocks.createdby, prod_systemblocks.createdon, prod_systemblocks.lasteditedby, prod_systemblocks.lasteditedon";
		$join=" left join prod_irrigationsystems on prod_systemblocks.systemid=prod_irrigationsystems.id  left join prod_blocks on prod_systemblocks.blockid=prod_blocks.id ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($ob->systemid))
		  $where=" where prod_systemblocks.systemid='$ob->systemid' ";
		$systemblocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$systemblocks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->systemid; ?></td>
			<td><?php echo $row->blockid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9239";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsystemblocks_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9240";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='systemblocks.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
