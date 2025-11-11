<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Quotations_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addquotations_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Quotations";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="3999";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$quotations=new Quotations();
if(!empty($delid)){
	$quotations->id=$delid;
	$quotations->delete($quotations);
	redirect("quotations.php");
}
//Authorization.
$auth->roleid="3998";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a  class="btn btn-info" href='addquotations_proc.php'>New Quotations</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item </th>
			<th>Quote No </th>
			<th>Customer </th>
			<th>Agent </th>
			<th>Sales Person </th>
			<th>Description </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Trade Price </th>
			<th>Retail Price </th>
			<th>Discount </th>
			<th>Tax </th>
			<th>Bonus </th>
			<th>Total </th>
			<th>Quote Status </th>
			<th>Quoted On </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="4000";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4001";//View
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
		$fields="pos_quotations.id, inv_items.name as itemid, pos_quotations.documentno, crm_customers.name as customerid, crm_agents.name as agentid, hrm_employees.name as employeeid, pos_quotations.description, pos_quotations.quantity, pos_quotations.costprice, pos_quotations.tradeprice, pos_quotations.retailprice, pos_quotations.discount, pos_quotations.tax, pos_quotations.bonus, pos_quotations.total, pos_quotations.status, pos_quotations.quotedon, pos_quotations.memo, pos_quotations.createdby, pos_quotations.createdon, pos_quotations.lasteditedby, pos_quotations.lasteditedon, pos_quotations.ipaddress";
		$join=" left join inv_items on pos_quotations.itemid=inv_items.id  left join crm_customers on pos_quotations.customerid=crm_customers.id  left join crm_agents on pos_quotations.agentid=crm_agents.id  left join hrm_employees on pos_quotations.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$quotations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$quotations->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo $row->agentid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->description; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo formatNumber($row->tradeprice); ?></td>
			<td><?php echo formatNumber($row->retailprice); ?></td>
			<td><?php echo formatNumber($row->discount); ?></td>
			<td><?php echo formatNumber($row->tax); ?></td>
			<td><?php echo formatNumber($row->bonus); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo formatDate($row->quotedon); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="4000";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addquotations_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4001";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='quotations.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
