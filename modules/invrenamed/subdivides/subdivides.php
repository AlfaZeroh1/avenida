<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Subdivides_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addsubdivides_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Subdivides";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4855";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$subdivides=new Subdivides();
if(!empty($delid)){
	$subdivides->id=$delid;
	$subdivides->delete($subdivides);
	redirect("subdivides.php");
}
//Authorization.
$auth->roleid="4854";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addsubdivides_proc.php'>New Subdivides</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Voucher </th>
			<th>Item </th>
			<th>New Item </th>
			<th>Subdivided On </th>
			<th>Repackage Type </th>
			<th>Remarks </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="4856";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4857";//View
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
		$fields="inv_subdivides.id, inv_subdivides.documentno, inv_items.name as itemid, inv_items2.name as newitemid, inv_subdivides.subdividedon, inv_subdivides.type, inv_subdivides.remarks, inv_subdivides.memo, inv_subdivides.createdby, inv_subdivides.createdon, inv_subdivides.lasteditedby, inv_subdivides.lasteditedon, inv_subdivides.ipaddress";
		$join=" left join inv_items on inv_subdivides.itemid=inv_items.id  left join inv_items2 on inv_subdivides.newitemid=inv_items2.id ";
		$having="";
		$groupby="";
		$orderby="";
		$subdivides->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$subdivides->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->newitemid; ?></td>
			<td><?php echo formatDate($row->subdividedon); ?></td>
			<td><?php echo $row->type; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="4856";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addsubdivides_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4857";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='subdivides.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
