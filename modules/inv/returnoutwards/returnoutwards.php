<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnoutwards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addreturnoutwards_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Returnoutwards";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="720";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$returnoutwards=new Returnoutwards();
if(!empty($delid)){
	$returnoutwards->id=$delid;
	$returnoutwards->delete($returnoutwards);
	redirect("returnoutwards.php");
}
//Authorization.
$auth->roleid="719";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addreturnoutwards_proc.php'>New Returnoutwards</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Supplier </th>
			<th>Store </th>
			<th>Document No. </th>
			<th>Purchase Invoice/Receipt No </th>
			<th>Mode Of Payment </th>
			<th>Returned On </th>
			<th>Memo </th>
			<th>Remarks </th>
			<th>Project </th>
<?php
//Authorization.
$auth->roleid="721";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="722";//View
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
		$fields="inv_returnoutwards.id, proc_suppliers.name as supplierid, inv_stores.name as storeid, inv_returnoutwards.documentno, inv_returnoutwards.purchaseno, sys_purchasemodes.name as purchasemodeid, inv_returnoutwards.returnedon, inv_returnoutwards.memo, inv_returnoutwards.remarks, inv_returnoutwards.createdby, inv_returnoutwards.createdon, inv_returnoutwards.lasteditedby, inv_returnoutwards.lasteditedon, inv_returnoutwards.ipaddress, con_projects.name as projectid";
		$join=" left join proc_suppliers on inv_returnoutwards.supplierid=proc_suppliers.id  left join inv_stores on inv_returnoutwards.storeid=inv_stores.id  left join sys_purchasemodes on inv_returnoutwards.purchasemodeid=sys_purchasemodes.id  left join con_projects on inv_returnoutwards.projectid=con_projects.id ";
		$having="";
		$groupby="";
		$orderby="";
		$returnoutwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$returnoutwards->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->storeid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->purchaseno; ?></td>
			<td><?php echo $row->purchasemodeid; ?></td>
			<td><?php echo formatDate($row->returnedon); ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->projectid; ?></td>
<?php
//Authorization.
$auth->roleid="721";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addreturnoutwards_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="722";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='returnoutwards.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
