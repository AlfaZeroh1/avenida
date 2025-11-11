<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Invoices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addinvoices_proc.php?retrieve=".$_GET['retrieve']."&parent=".$_GET['parent']);

$page_title="Invoices";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8656";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$invoices=new Invoices();
if(!empty($delid)){
	$invoices->id=$delid;
	$invoices->delete($invoices);
	redirect("invoices.php");
}
//Authorization.
$auth->roleid="8655";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a  class="btn btn-info" href='addinvoices_proc.php'>New Invoices</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document No </th>
			<th>Packing No </th>
			<th>Customer </th>
			<th>Agent </th>
			<th>Remarks </th>
			<th>Sold On </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="8657";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8658";//View
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
		$fields="pos_invoices.id, pos_invoices.documentno, pos_invoices.packingno, crm_customers.name as customerid, crm_agents.name as agentid, pos_invoices.remarks, pos_invoices.soldon, pos_invoices.memo, pos_invoices.createdby, pos_invoices.createdon, pos_invoices.lasteditedby, pos_invoices.lasteditedon, pos_invoices.ipaddress";
		$join=" left join crm_customers on pos_invoices.customerid=crm_customers.id  left join crm_agents on pos_invoices.agentid=crm_agents.id ";
		$having="";
		$groupby="";
		$orderby="";
		$invoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$invoices->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->packingno; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo $row->agentid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo formatDate($row->soldon); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="8657";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addinvoices_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8658";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='invoices.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
