<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Civilstatuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Civilstatuss";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4488";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$civilstatuss=new Civilstatuss();
if(!empty($delid)){
	$civilstatuss->id=$delid;
	$civilstatuss->delete($civilstatuss);
	redirect("civilstatuss.php");
}
//Authorization.
$auth->roleid="4487";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcivilstatuss_proc.php',600,430);" value="Add Civilstatuss " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Civil Status </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4489";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4490";//Add
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
		$fields="hos_civilstatuss.id, hos_civilstatuss.name, hos_civilstatuss.remarks, hos_civilstatuss.createdby, hos_civilstatuss.createdon, hos_civilstatuss.lasteditedby, hos_civilstatuss.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$civilstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$civilstatuss->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4489";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcivilstatuss_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4490";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='civilstatuss.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
