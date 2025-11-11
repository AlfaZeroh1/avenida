<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Graded_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addgraded_proc.php?status=".$_GET['status']."&retrieve=".$_GET['retrieve']);

$page_title="Graded";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8620";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$graded=new Graded();
if(!empty($delid)){
	$graded->id=$delid;
	$graded->delete($graded);
	redirect("graded.php");
}
//Authorization.
$auth->roleid="8619";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addgraded_proc.php'>New Graded</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Size </th>
			<th>Item </th>
			<th>Quantity </th>
			<th>Date Graded </th>
			<th>Employee </th>
			<th>BarCode </th>
			<th>Remarks </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8621";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8622";//View
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
		$fields="post_graded.id, prod_sizes.name as sizeid, prod_items.name as itemid, post_graded.quantity, post_graded.gradedon, hrm_employees.name as employeeid, post_graded.barcode, post_graded.remarks, post_graded.status, post_graded.ipaddress, post_graded.createdby, post_graded.createdon, post_graded.lasteditedby, post_graded.lasteditedon";
		$join=" left join prod_sizes on post_graded.sizeid=prod_sizes.id  left join prod_items on post_graded.itemid=prod_items.id  left join hrm_employees on post_graded.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$graded->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$graded->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->sizeid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatDate($row->gradedon); ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->barcode; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="8621";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addgraded_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8622";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='graded.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
