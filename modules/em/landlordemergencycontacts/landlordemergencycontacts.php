<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Landlordemergencycontacts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Landlordemergencycontacts";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8112";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$landlordemergencycontacts=new Landlordemergencycontacts();
if(!empty($delid)){
	$landlordemergencycontacts->id=$delid;
	$landlordemergencycontacts->delete($landlordemergencycontacts);
	redirect("landlordemergencycontacts.php");
}
//Authorization.
$auth->roleid="8111";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addlandlordemergencycontacts_proc.php',600,430);" value="Add Landlordemergencycontacts " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Landlord </th>
			<th>Name </th>
			<th>Relation </th>
			<th>Tel </th>
			<th>E-mail </th>
			<th>Postal Address </th>
			<th>Physical Address </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8113";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8114";//View
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
		$fields="em_landlordemergencycontacts.id, em_landlords.name as landlordid, em_landlordemergencycontacts.name, em_landlordemergencycontacts.relation, em_landlordemergencycontacts.tel, em_landlordemergencycontacts.email, em_landlordemergencycontacts.address, em_landlordemergencycontacts.physicaladdress, em_landlordemergencycontacts.remarks, em_landlordemergencycontacts.ipaddress, em_landlordemergencycontacts.createdby, em_landlordemergencycontacts.createdon, em_landlordemergencycontacts.lasteditedby, em_landlordemergencycontacts.lasteditedon";
		$join=" left join em_landlords on em_landlordemergencycontacts.landlordid=em_landlords.id ";
		$having="";
		$groupby="";
		$orderby="";
		$landlordemergencycontacts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$landlordemergencycontacts->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->landlordid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->relation; ?></td>
			<td><?php echo $row->tel; ?></td>
			<td><?php echo $row->email; ?></td>
			<td><?php echo $row->address; ?></td>
			<td><?php echo $row->physicaladdress; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8113";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addlandlordemergencycontacts_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8114";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='landlordemergencycontacts.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
