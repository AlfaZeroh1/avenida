<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Packinglistreturns_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addpackinglistreturns_proc.php?retrieve=".$_GET['retrieve']."&returns=".$_GET['returns']);

$page_title="Packinglistreturns";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8672";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$packinglistreturns=new Packinglistreturns();
if(!empty($delid)){
	$packinglistreturns->id=$delid;
	$packinglistreturns->delete($packinglistreturns);
	redirect("packinglistreturns.php");
}
//Authorization.
$auth->roleid="8671";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a  class="btn btn-info" href='addpackinglistreturns_proc.php'>New Packinglistreturns</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Packing No </th>
			<th>Order No </th>
			<th>Box No </th>
			<th>Customer </th>
			<th>Date Of Packing </th>
			<th>Vehicle </th>
			<th>Driver </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8673";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8674";//View
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
		$fields="pos_packinglistreturns.id, pos_packinglistreturns.documentno, pos_packinglistreturns.orderno, pos_packinglistreturns.boxno, crm_customers.name as customerid, pos_packinglistreturns.packedon, assets_fleets.name as fleetid, hrm_employees.name as employeeid, pos_packinglistreturns.remarks, pos_packinglistreturns.ipaddress, pos_packinglistreturns.createdby, pos_packinglistreturns.createdon, pos_packinglistreturns.lasteditedby, pos_packinglistreturns.lasteditedon";
		$join=" left join crm_customers on pos_packinglistreturns.customerid=crm_customers.id  left join assets_fleets on pos_packinglistreturns.fleetid=assets_fleets.id  left join hrm_employees on pos_packinglistreturns.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$packinglistreturns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$packinglistreturns->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->orderno; ?></td>
			<td><?php echo $row->boxno; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo formatDate($row->packedon); ?></td>
			<td><?php echo $row->fleetid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8673";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addpackinglistreturns_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8674";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='packinglistreturns.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
