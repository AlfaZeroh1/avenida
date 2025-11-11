<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Harvestrejects_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$ob = (object)$_GET;

$page_title="Harvestrejects";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8624";//View
$auth->levelid=$_SESSION['level'];

redirect("addharvestrejects_proc.php?reduce=".$_GET['reduce']);

auth($auth);
include"../../../head.php";



$delid=$_GET['delid'];
$harvestrejects=new Harvestrejects();
if(!empty($delid)){
	$harvestrejects->id=$delid;
	$harvestrejects->delete($harvestrejects);
	redirect("harvestrejects.php");
}
//Authorization.
$auth->roleid="8623";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<a class="btn btn-info" href='addharvestrejects_proc.php?reduce=<?php echo $ob->reduce; ?>'>New</a>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Reject Type </th>
			<th>Size </th>
			<th>Product </th>
			<th>Quantity </th>
			<th>Date Graded </th>
			<th>Date Reported </th>
			<th>Employee </th>
			<th>BarCode </th>
			<th>Remarks </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8625";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8626";//View
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
		$fields="post_harvestrejects.id, prod_rejecttypes.name as rejecttypeid, prod_sizes.name as sizeid, pos_items.name as itemid, post_harvestrejects.quantity, post_harvestrejects.gradedon, post_harvestrejects.reportedon, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, post_harvestrejects.barcode, post_harvestrejects.remarks, post_harvestrejects.status, post_harvestrejects.ipaddress, post_harvestrejects.createdby, post_harvestrejects.createdon, post_harvestrejects.lasteditedby, post_harvestrejects.lasteditedon";
		$join=" left join prod_rejecttypes on post_harvestrejects.rejecttypeid=prod_rejecttypes.id  left join prod_sizes on post_harvestrejects.sizeid=prod_sizes.id  left join pos_items on post_harvestrejects.itemid=pos_items.id  left join hrm_employees on post_harvestrejects.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where post_harvestrejects.reduce='$ob->reduce' ";
		$harvestrejects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$harvestrejects->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->rejecttypeid; ?></td>
			<td><?php echo $row->sizeid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatDate($row->gradedon); ?></td>
			<td><?php echo formatDate($row->reportedon); ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->barcode; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="8625";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addharvestrejects_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8626";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='harvestrejects.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
