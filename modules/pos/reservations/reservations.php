<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Reservations_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Reservations";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2189";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$reservations=new Reservations();
if(!empty($delid)){
	$reservations->id=$delid;
	$reservations->delete($reservations);
	redirect("reservations.php");
}
//Authorization.
$auth->roleid="2188";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addreservations_proc.php',600,430);" value="Add Reservations " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item </th>
			<th>Customer </th>
			<th>Reserved On </th>
			<th>Duration </th>
			<th>Quantity </th>
			<th>Parcel No. </th>
			<th>Ground No. </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="2190";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2191";//View
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
		$fields="pos_reservations.id, pos_items.name as itemid, crm_customers.name as customerid, pos_reservations.reservedon, pos_reservations.duration, pos_reservations.quantity, pos_reservations.parcelno, pos_reservations.groundno, pos_salestatus.name as salestatusid, pos_reservations.createdby, pos_reservations.createdon, pos_reservations.lasteditedby, pos_reservations.lasteditedon, pos_reservations.ipaddress";
		$join=" left join pos_items on pos_reservations.itemid=pos_items.id  left join crm_customers on pos_reservations.customerid=crm_customers.id  left join pos_salestatus on pos_reservations.salestatusid=pos_salestatus.id ";
		$having="";
		$groupby="";
		$orderby="";
		$reservations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$reservations->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo formatDate($row->reservedon); ?></td>
			<td><?php echo $row->duration; ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo $row->parcelno; ?></td>
			<td><?php echo $row->groundno; ?></td>
			<td><?php echo $row->salestatusid; ?></td>
<?php
//Authorization.
$auth->roleid="2190";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addreservations_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2191";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='reservations.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
