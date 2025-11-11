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
$auth->roleid="7563";//View
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
$auth->roleid="7562";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddocuments_proc.php',600,430);" value="Add Documents " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Route </th>
			<th>Document No </th>
			<th>Document Type </th>
			<th>DMS Department </th>
			<th>DMS Dept Category </th>
			<th>DMS Category </th>
			<th>HRM Department </th>
			<th>Upload Document </th>
			<th>Document Link </th>
			<th>Status </th>
			<th>Description </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7564";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7565";//View
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
		$fields="dms_documents.id, wf_routes.name as routeid, dms_documents.documentno, dms_documenttypes.name as documenttypeid, dms_documents.departmentid, dms_documents.departmentcategoryid, dms_documents.categoryid, dms_documents.hrmdepartmentid, dms_documents.document, dms_documents.link, dms_documents.status, dms_documents.description, dms_documents.remarks, dms_documents.ipaddress, dms_documents.createdby, dms_documents.createdon, dms_documents.lasteditedby, dms_documents.lasteditedon";
		$join=" left join wf_routes on dms_documents.routeid=wf_routes.id  left join dms_documenttypes on dms_documents.documenttypeid=dms_documenttypes.id ";
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
			<td><?php echo $row->routeid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->documenttypeid; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->departmentcategoryid; ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo $row->hrmdepartmentid; ?></td>
			<td><?php echo $row->document; ?></td>
			<td><?php echo $row->link; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7564";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddocuments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7565";//View
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
<?php
include"../../../foot.php";
?>
