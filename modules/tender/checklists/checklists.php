<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Checklists_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Checklists";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7752";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$checklists=new Checklists();
if(!empty($delid)){
	$checklists->id=$delid;
	$checklists->delete($checklists);
	redirect("checklists.php");
}
//Authorization.
$auth->roleid="7751";//View
$auth->levelid=$_SESSION['level'];

$users = new Users();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='".$_SESSION['userid']."'";
$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$users=$users->fetchObject;

$where=" where tender_checklists.id in(select checklistid from tender_checklistemployees where employeeid='$users->employeeid')";

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addchecklists_proc.php'>New Checklists</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Responsibility </th>
			<th>Category </th>
			<th>Tender </th>
			<th>Description </th>
			<th>Deadline </th>
			<th>Status </th>
			<th>Date Done </th>
			<th> </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7753";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7754";//View
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
		$fields="tender_checklists.id, tender_checklists.name, tender_checklistcategorys.name as checklistcategoryid, tender_tenders.name as tenderid, tender_checklists.description, tender_checklists.deadline, tender_checklists.status, tender_checklists.doneon, tender_checklists.completedon, tender_checklists.remarks, tender_checklists.ipaddress, tender_checklists.createdby, tender_checklists.createdon, tender_checklists.lasteditedby, tender_checklists.lasteditedon";
		$join=" left join tender_checklistcategorys on tender_checklists.checklistcategoryid=tender_checklistcategorys.id  left join tender_tenders on tender_checklists.tenderid=tender_tenders.id ";
		$having="";
		$groupby="";
		$orderby="";
		$checklists->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$checklists->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->checklistcategoryid; ?></td>
			<td><?php echo $row->tenderid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo formatDate($row->deadline); ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo formatDate($row->doneon); ?></td>
			<td><?php echo formatDate($row->completedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7753";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addchecklists_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7754";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='checklists.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
