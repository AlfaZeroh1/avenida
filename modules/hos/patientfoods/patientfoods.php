<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Patientfoods_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Patientfoods";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4512";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$patientfoods=new Patientfoods();
if(!empty($delid)){
	$patientfoods->id=$delid;
	$patientfoods->delete($patientfoods);
	redirect("patientfoods.php");
}
//Authorization.
$auth->roleid="4511";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addpatientfoods_proc.php',600,430);" value="Add Patientfoods " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Food </th>
			<th>Patient </th>
			<th>Price </th>
			<th> </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="4513";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4514";//Add
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
		$fields="hos_patientfoods.id, hos_patientfoods.foodid, hos_patientfoods.patientid, hos_patientfoods.price, hos_patientfoods.servedon, hos_meals.name as mealid, hos_patientfoods.createdby, hos_patientfoods.createdon, hos_patientfoods.lasteditedby, hos_patientfoods.lasteditedon";
		$join=" left join hos_meals on hos_patientfoods.mealid=hos_meals.id ";
		$having="";
		$groupby="";
		$orderby="";
		$patientfoods->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientfoods->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->foodid; ?></td>
			<td><?php echo $row->patientid; ?></td>
			<td><?php echo formatNumber($row->price); ?></td>
			<td><?php echo formatDate($row->servedon); ?></td>
			<td><?php echo $row->mealid; ?></td>
<?php
//Authorization.
$auth->roleid="4513";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpatientfoods_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4514";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='patientfoods.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
