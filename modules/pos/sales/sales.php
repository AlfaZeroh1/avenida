<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sales_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addsales_proc.php?mode=".$_GET['mode']."&retrieve=".$_GET['retrieve']);

$page_title="Sales";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2205";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$sales=new Sales();
if(!empty($delid)){
	$sales->id=$delid;
	$sales->delete($sales);
	redirect("sales.php");
}
//Authorization.
$auth->roleid="2204";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a  class="btn btn-info" href='addsales_proc.php'>New Sales</a></div>
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
			<th>Mode </th>
			<th>Sold On </th>
			<th>Expiry Date </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="2206";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2207";//View
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
		$fields="pos_sales.id, pos_sales.documentno, crm_customers.name as customerid, crm_agents.name as agentid, hrm_employees.name as employeeid, pos_sales.remarks, pos_sales.mode, pos_sales.soldon, pos_sales.expirydate, pos_sales.memo, pos_sales.createdby, pos_sales.createdon, pos_sales.lasteditedby, pos_sales.lasteditedon, pos_sales.ipaddress";
		$join=" left join crm_customers on pos_sales.customerid=crm_customers.id  left join crm_agents on pos_sales.agentid=crm_agents.id  left join hrm_employees on pos_sales.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$sales->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$sales->result;
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
			<td><?php echo $row->mode; ?></td>
			<td><?php echo formatDate($row->soldon); ?></td>
			<td><?php echo formatDate($row->expirydate); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="2206";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addsales_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2207";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='sales.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
