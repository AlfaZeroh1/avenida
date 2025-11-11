<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rejects_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$ob = (object)$_GET;

$page_title="Rejects";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8624";//View
$auth->levelid=$_SESSION['level'];

redirect("addrejects_proc.php?reduce=".$_GET['reduce']);

auth($auth);
include"../../../head.php";



$delid=$_GET['delid'];
$rejects=new Rejects();
if(!empty($delid)){
	$rejects->id=$delid;
	$rejects->delete($rejects);
	redirect("rejects.php");
}
//Authorization.
$auth->roleid="8623";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<a class="btn btn-info" href='addrejects_proc.php?reduce=<?php echo $ob->reduce; ?>'>New</a>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Reject Type </th>
			<th>Size </th>
			<th>variety </th>
			<th>Quantity </th>
			<th>Date Harvested </th>
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
		$fields="prod_rejects.id, prod_rejecttypes.name as rejecttypeid, prod_varietys.name as varietyid, prod_sizes.name as sizeid, prod_greenhouses.name as greenhouseid, prod_rejects.quantity, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, prod_rejects.barcode, prod_rejects.harvestedon, prod_rejects.reportedon, prod_rejects.remarks, prod_rejects.status, prod_rejects.ipaddress, prod_rejects.createdby, prod_rejects.createdon, prod_rejects.lasteditedby, prod_rejects.lasteditedon";
		$join=" left join prod_rejecttypes on prod_rejects.rejecttypeid=prod_rejecttypes.id  left join prod_varietys on prod_rejects.varietyid=prod_varietys.id  left join prod_sizes on prod_rejects.sizeid=prod_sizes.id  left join prod_plantingdetails on prod_rejects.plantingdetailid=prod_plantingdetails.id  left join prod_greenhouses on prod_rejects.greenhouseid=prod_greenhouses.id  left join hrm_employees on prod_rejects.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$rejects->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $rejects->sql;
		$res=$rejects->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->rejecttypeid; ?></td>
			<td><?php echo $row->sizeid; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatDate($row->harvestedon); ?></td>
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
			<td><a href="javascript:;" onclick="showPopWin('addrejects_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8626";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='rejects.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
