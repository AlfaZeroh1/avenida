<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectdocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectdocuments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9040";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectdocuments=new Projectdocuments();
if(!empty($delid)){
	$projectdocuments->id=$delid;
	$projectdocuments->delete($projectdocuments);
	redirect("projectdocuments.php");
}
//Authorization.
$auth->roleid="9039";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprojectdocuments_proc.php',600,430);" value="Add Projectdocuments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Project </th>
			<th>Document Type </th>
			<th>Browse File </th>
			<th>Date Uploaded </th>
			<th>Type </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9041";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9042";//View
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
		$fields="pm_projectdocuments.id, pm_projects.name as projectid, dms_documenttypes.name as documenttypeid, pm_projectdocuments.file, pm_projectdocuments.uploadedon, pm_projectdocuments.type, pm_projectdocuments.remarks, pm_projectdocuments.ipaddress, pm_projectdocuments.createdby, pm_projectdocuments.createdon, pm_projectdocuments.lasteditedby, pm_projectdocuments.lasteditedon";
		$join=" left join pm_projects on pm_projectdocuments.projectid=pm_projects.id  left join dms_documenttypes on pm_projectdocuments.documenttypeid=dms_documenttypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectdocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->documenttypeid; ?></td>
			<td><?php echo $row->file; ?></td>
			<td><?php echo formatDate($row->uploadedon); ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9041";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectdocuments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9042";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectdocuments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
