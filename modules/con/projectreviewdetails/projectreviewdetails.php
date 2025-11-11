<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectreviewdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectreviewdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8532";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectreviewdetails=new Projectreviewdetails();
if(!empty($delid)){
	$projectreviewdetails->id=$delid;
	$projectreviewdetails->delete($projectreviewdetails);
	redirect("projectreviewdetails.php");
}
//Authorization.
$auth->roleid="8531";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprojectreviewdetails_proc.php',600,430);" value="Add Projectreviewdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Review Item </th>
			<th>Status </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8533";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8534";//Add
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
		$fields="con_projectreviewdetails.id, con_projectreviewdetails.reviewid, con_projectreviewdetails.status, con_projectreviewdetails.remark, con_projectreviewdetails.ipaddress, con_projectreviewdetails.createdby, con_projectreviewdetails.createdon, con_projectreviewdetails.lasteditedby, con_projectreviewdetails.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$projectreviewdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectreviewdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->reviewid; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remark; ?></td>
<?php
//Authorization.
$auth->roleid="8533";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectreviewdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8534";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectreviewdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
