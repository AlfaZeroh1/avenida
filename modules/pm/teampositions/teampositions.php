<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teampositions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Teampositions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9052";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$teampositions=new Teampositions();
if(!empty($delid)){
	$teampositions->id=$delid;
	$teampositions->delete($teampositions);
	redirect("teampositions.php");
}
//Authorization.
$auth->roleid="9051";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addteampositions_proc.php',600,430);" value="Add Teampositions " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Position </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9053";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9054";//Add
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
		$fields="pm_teampositions.id, pm_teampositions.name, pm_teampositions.remarks, pm_teampositions.ipaddress, pm_teampositions.createdby, pm_teampositions.createdon, pm_teampositions.lasteditedby, pm_teampositions.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$teampositions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$teampositions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9053";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addteampositions_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9054";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='teampositions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
