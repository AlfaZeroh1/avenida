<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Checklistdocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Checklistdocuments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7728";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$checklistdocuments=new Checklistdocuments();
if(!empty($delid)){
	$checklistdocuments->id=$delid;
	$checklistdocuments->delete($checklistdocuments);
	redirect("checklistdocuments.php");
}
//Authorization.
$auth->roleid="7727";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addchecklistdocuments_proc.php',600,430);" value="Add Checklistdocuments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Title </th>
			<th>Check List </th>
			<th>Document Type </th>
			<th>Upload File </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7729";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7730";//View
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
		$fields="tender_checklistdocuments.id, tender_checklistdocuments.title, tender_checklists.action as checklistid, dms_documenttypes.name as documenttypeid, tender_checklistdocuments.file, tender_checklistdocuments.remarks, tender_checklistdocuments.ipaddress, tender_checklistdocuments.createdby, tender_checklistdocuments.createdon, tender_checklistdocuments.lasteditedby, tender_checklistdocuments.lasteditedon";
		$join=" left join tender_checklists on tender_checklistdocuments.checklistid=tender_checklists.id  left join dms_documenttypes on tender_checklistdocuments.documenttypeid=dms_documenttypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$checklistdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$checklistdocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->title; ?></td>
			<td><?php echo $row->checklistid; ?></td>
			<td><?php echo $row->documenttypeid; ?></td>
			<td><?php echo $row->file; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7729";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addchecklistdocuments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7730";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='checklistdocuments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
