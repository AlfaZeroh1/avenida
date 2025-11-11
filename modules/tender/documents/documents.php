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
$auth->roleid="7736";//View
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
$auth->roleid="7735";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddocuments_proc.php',600,430);" value="Add Documents " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Tender </th>
			<th>Document Type </th>
			<th>Title </th>
			<th>Upload File </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7737";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7738";//View
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
		$fields="tender_documents.id, tender_tenders.name as tenderid, dms_documenttypes.name as documenttypeid, tender_documents.title, tender_documents.file, tender_documents.remarks, tender_documents.ipaddress, tender_documents.createdby, tender_documents.createdon, tender_documents.lasteditedby, tender_documents.lasteditedon";
		$join=" left join tender_tenders on tender_documents.tenderid=tender_tenders.id  left join dms_documenttypes on tender_documents.documenttypeid=dms_documenttypes.id ";
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
			<td><?php echo $row->tenderid; ?></td>
			<td><?php echo $row->documenttypeid; ?></td>
			<td><?php echo $row->title; ?></td>
			<td><?php echo $row->file; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7737";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddocuments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7738";//View
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
