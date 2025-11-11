<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Saleorders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addsaleorders_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Saleorders";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4847";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$saleorders=new Saleorders();
if(!empty($delid)){
	$saleorders->id=$delid;
	$saleorders->delete($saleorders);
	redirect("saleorders.php");
}
//Authorization.
$auth->roleid="4846";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a  class="btn btn-info" href='addsaleorders_proc.php'>New Saleorders</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document No </th>
			<th>Customer </th>
			<th>Agent </th>
			<th>Sales Person </th>
			<th>Remarks </th>
			<th>Sold On </th>
			<th>Expiry Date </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="4848";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4849";//View
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
		$fields="pos_saleorders.id, pos_saleorders.documentno, crm_customers.name as customerid, crm_agents.name as agentid, hrm_employees.name as employeeid, pos_saleorders.remarks, pos_saleorders.soldon, pos_saleorders.expirydate, pos_saleorders.memo, pos_saleorders.createdby, pos_saleorders.createdon, pos_saleorders.lasteditedby, pos_saleorders.lasteditedon, pos_saleorders.ipaddress";
		$join=" left join crm_customers on pos_saleorders.customerid=crm_customers.id  left join crm_agents on pos_saleorders.agentid=crm_agents.id  left join hrm_employees on pos_saleorders.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$saleorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$saleorders->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo $row->agentid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo formatDate($row->soldon); ?></td>
			<td><?php echo formatDate($row->expirydate); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="4848";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addsaleorders_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4849";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='saleorders.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
