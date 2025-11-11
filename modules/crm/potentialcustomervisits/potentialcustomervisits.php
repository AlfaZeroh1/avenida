<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Potentialcustomervisits_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Potentialcustomervisits";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8496";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$potentialcustomervisits=new Potentialcustomervisits();
if(!empty($delid)){
	$potentialcustomervisits->id=$delid;
	$potentialcustomervisits->delete($potentialcustomervisits);
	redirect("potentialcustomervisits.php");
}
//Authorization.
$auth->roleid="8495";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addpotentialcustomervisits_proc.php',600,430);" value="Add Potentialcustomervisits " type="button"/></div>
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
$auth->roleid="8497";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8498";//Add
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
		$fields="crm_potentialcustomervisits.id, crm_customers.name as potentialcustomerid, crm_potentialcustomervisits.vistedon, hrm_employees.name as employeeid, crm_potentialcustomervisits.findings, crm_potentialcustomervisits.recommendations, crm_potentialcustomervisits.remarks, crm_potentialcustomervisits.ipaddress, crm_potentialcustomervisits.createdby, crm_potentialcustomervisits.createdon, crm_potentialcustomervisits.lasteditedby, crm_potentialcustomervisits.lasteditedon";
		$join=" left join crm_customers on crm_potentialcustomervisits.potentialcustomerid=crm_customers.id  left join hrm_employees on crm_potentialcustomervisits.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$potentialcustomervisits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$potentialcustomervisits->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->potentialcustomerid; ?></td>
			<td><?php echo formatDate($row->vistedon); ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->findings; ?></td>
			<td><?php echo $row->recommendations; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8497";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpotentialcustomervisits_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8498";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='potentialcustomervisits.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
