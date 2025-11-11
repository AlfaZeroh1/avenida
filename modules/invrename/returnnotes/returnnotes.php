<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnnotes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addreturnnotes_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Returnnotes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4851";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$returnnotes=new Returnnotes();
if(!empty($delid)){
	$returnnotes->id=$delid;
	$returnnotes->delete($returnnotes);
	redirect("returnnotes.php");
}
//Authorization.
$auth->roleid="4850";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addreturnnotes_proc.php'>New Returnnotes</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Supplier </th>
			<th>Document No. </th>
			<th>Purchase Invoice/Receipt No </th>
			<th>Mode Of Payment </th>
			<th>Returned On </th>
			<th>Memo </th>
			<th>Remarks </th>
			<th>Project </th>
<?php
//Authorization.
$auth->roleid="4852";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4853";//View
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
		$fields="inv_returnnotes.id, fn_suppliers.name as supplierid, inv_returnnotes.documentno, inv_returnnotes.purchaseno, sys_purchasemodes.name as purchasemodeid, inv_returnnotes.returnedon, inv_returnnotes.memo, inv_returnnotes.remarks, inv_returnnotes.createdby, inv_returnnotes.createdon, inv_returnnotes.lasteditedby, inv_returnnotes.lasteditedon, inv_returnnotes.ipaddress, con_projects.name as projectid";
		$join=" left join fn_suppliers on inv_returnnotes.supplierid=fn_suppliers.id  left join sys_purchasemodes on inv_returnnotes.purchasemodeid=sys_purchasemodes.id  left join con_projects on inv_returnnotes.projectid=con_projects.id ";
		$having="";
		$groupby="";
		$orderby="";
		$returnnotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$returnnotes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->purchaseno; ?></td>
			<td><?php echo $row->purchasemodeid; ?></td>
			<td><?php echo formatDate($row->returnedon); ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->projectid; ?></td>
<?php
//Authorization.
$auth->roleid="4852";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addreturnnotes_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4853";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='returnnotes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
