<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documentflows_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Documentflows";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7463";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../hd.php";

$delid=$_GET['delid'];
$documentflows=new Documentflows();
if(!empty($delid)){
	$documentflows->id=$delid;
	$documentflows->delete($documentflows);
	redirect("documentflows.php");
}
//Authorization.
$auth->roleid="7462";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddocumentflows_proc.php',600,430);" value="Add Documentflows " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document </th>
			<th>Remarks </th>
			<th>Status </th>
			<th>Document </th>
			<th>Document Link </th>
<?php
//Authorization.
$auth->roleid="7464";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7465";//View
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
		$fields="wf_documentflows.id, wf_documents.documentno as documentid, wf_documentflows.remarks, wf_documentflows.status, wf_documentflows.document, wf_documentflows.link, wf_documentflows.ipaddress, wf_documentflows.createdby, wf_documentflows.createdon, wf_documentflows.lasteditedby, wf_documentflows.lasteditedon";
		$join=" left join wf_documents on wf_documentflows.documentid=wf_documents.id ";
		$having="";
		$groupby="";
		$orderby="";
		$documentflows->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$documentflows->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->document; ?></td>
			<td><?php echo $row->link; ?></td>
<?php
//Authorization.
$auth->roleid="7464";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddocumentflows_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7465";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='documentflows.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
