<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Qualifications_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Qualifications";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4210";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$qualifications=new Qualifications();
if(!empty($delid)){
	$qualifications->id=$delid;
	$qualifications->delete($qualifications);
	redirect("qualifications.php");
}
//Authorization.
$auth->roleid="4209";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">

<a class="btn btn-info" onclick="showPopWin('addqualifications_proc.php',600,430);">Add Qualifications</a>
<?php }?>

<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Qualification </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4211";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4212";//View
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
		$fields="hrm_qualifications.id, hrm_qualifications.name, hrm_qualifications.remarks, hrm_qualifications.createdby, hrm_qualifications.createdon, hrm_qualifications.lasteditedby, hrm_qualifications.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$qualifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$qualifications->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4211";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addqualifications_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4212";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='qualifications.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>

</div> <!-- containerEnd -->
<?php
include"../../../foot.php";
?>
