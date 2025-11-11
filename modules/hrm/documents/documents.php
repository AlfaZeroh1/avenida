<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Documents";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4214";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$documents=new Documents();
if(!empty($delid)){
	$documents->id=$delid;
	$documents->delete($documents);
	redirect("documents.php");
}
//Authorization.
$auth->roleid="4213";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('adddocuments_proc.php',600,430);">Add Documents</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4215";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4216";//View
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
		$fields="hrm_documents.id, hrm_documents.name, hrm_documents.remarks, hrm_documents.createdby, hrm_documents.createdon, hrm_documents.lasteditedby, hrm_documents.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$documents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$documents->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4215";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddocuments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4216";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='documents.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
</div> <!-- contend -->
<?php
include"../../../foot.php";
?>
