<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customervisits_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Customervisits";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8488";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$customervisits=new Customervisits();
if(!empty($delid)){
	$customervisits->id=$delid;
	$customervisits->delete($customervisits);
	redirect("customervisits.php");
}
//Authorization.
$auth->roleid="8487";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcustomervisits_proc.php',600,430);" value="Add Customervisits " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Customer </th>
			<th>Visted On </th>
			<th>Visited By </th>
			<th>Findings </th>
			<th>Recommendations </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8489";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8490";//Add
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
		$fields="crm_customervisits.id, crm_customers.name as customerid, crm_customervisits.vistedon, hrm_employees.name as employeeid, crm_customervisits.findings, crm_customervisits.recommendations, crm_customervisits.remarks, crm_customervisits.ipaddress, crm_customervisits.createdby, crm_customervisits.createdon, crm_customervisits.lasteditedby, crm_customervisits.lasteditedon";
		$join=" left join crm_customers on crm_customervisits.customerid=crm_customers.id  left join hrm_employees on crm_customervisits.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$customervisits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$customervisits->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo formatDate($row->vistedon); ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->findings; ?></td>
			<td><?php echo $row->recommendations; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8489";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcustomervisits_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8490";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='customervisits.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
