<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchases_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addpurchases_proc.php?purchasemodeid=".$_GET['purchasemodeid']."&retrieve=".$_GET['retrieve']);

$page_title="Purchases";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="716";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$purchases=new Purchases();
if(!empty($delid)){
	$purchases->id=$delid;
	$purchases->delete($purchases);
	redirect("purchases.php");
}
//Authorization.
$auth->roleid="715";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addpurchases_proc.php'>New Purchases</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document No. </th>
			<th>L.P.O No </th>
			<th>Store </th>
			<th>Supplier </th>
			<th>Batch No. </th>
			<th>Remarks </th>
			<th>Mode Of Payment </th>
			<th>Purchase Date </th>
			<th>Project </th>
<?php
//Authorization.
$auth->roleid="717";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="718";//View
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
		$fields="inv_purchases.id, inv_purchases.documentno, inv_purchases.lpono, inv_stores.name as storeid, proc_suppliers.name as supplierid, inv_purchases.batchno, inv_purchases.remarks, sys_purchasemodes.name as purchasemodeid, inv_purchases.boughton, inv_purchases.createdby, inv_purchases.createdon, inv_purchases.lasteditedby, inv_purchases.lasteditedon, inv_purchases.ipaddress, con_projects.name as projectid";
		$join=" left join inv_stores on inv_purchases.storeid=inv_stores.id  left join proc_suppliers on inv_purchases.supplierid=proc_suppliers.id  left join sys_purchasemodes on inv_purchases.purchasemodeid=sys_purchasemodes.id  left join con_projects on inv_purchases.projectid=con_projects.id ";
		$having="";
		$groupby="";
		$orderby="";
		$purchases->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$purchases->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->lpono; ?></td>
			<td><?php echo $row->storeid; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->batchno; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->purchasemodeid; ?></td>
			<td><?php echo formatDate($row->boughton); ?></td>
			<td><?php echo $row->projectid; ?></td>
<?php
//Authorization.
$auth->roleid="717";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addpurchases_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="718";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='purchases.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
