<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerissues_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Customerissues";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8404";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$customerissues=new Customerissues();
if(!empty($delid)){
	$customerissues->id=$delid;
	$customerissues->delete($customerissues);
	redirect("customerissues.php");
}
//Authorization.
$auth->roleid="8403";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcustomerissues_proc.php',600,430);" value="Add Customerissues " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Issue # </th>
			<th>Customer </th>
			<th>Issue Type </th>
			<th>Description </th>
			<th>Remarks </th>
			<th>Status </th>
			<th>Assigned To </th>
			<th>Started On </th>
			<th>Finished On </th>
<?php
//Authorization.
$auth->roleid="8405";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8406";//View
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
		$fields="crm_customerissues.id, crm_customerissues.documentno, crm_customerissues.customerid, crm_customerissues.issuetypeid, crm_customerissues.description, crm_customerissues.remarks, crm_customerissues.status, hrm_employees.name as employeeid, crm_customerissues.startedon, crm_customerissues.finishedon, crm_customerissues.ipaddress, crm_customerissues.createdby, crm_customerissues.createdon, crm_customerissues.lasteditedby, crm_customerissues.lasteditedon";
		$join=" left join hrm_employees on crm_customerissues.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$customerissues->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$customerissues->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo $row->issuetypeid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo formatDate($row->startedon); ?></td>
			<td><?php echo formatDate($row->finishedon); ?></td>
<?php
//Authorization.
$auth->roleid="8405";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcustomerissues_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8406";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='customerissues.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
