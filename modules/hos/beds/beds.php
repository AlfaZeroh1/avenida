<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Beds_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Beds";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1259";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$beds=new Beds();
if(!empty($delid)){
	$beds->id=$delid;
	$beds->delete($beds);
	redirect("beds.php");
}
//Authorization.
$auth->roleid="1258";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addbeds_proc.php',600,430);" value="Add Beds " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Ward </th>
			<th>Room Number </th>
			<th>Beds </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="1260";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1261";//View
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
		$fields="hos_beds.id, hos_wards.name as wardid, hos_beds.roomno, hos_beds.name, case when hos_beds.status=1 then 'Free' else 'Occupied' end status, hos_beds.createdby, hos_beds.createdon, hos_beds.lasteditedby, hos_beds.lasteditedon";
		$join=" left join hos_wards on hos_beds.wardid=hos_wards.id ";
		$having="";
		$groupby="";
		$orderby="";
		$beds->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$beds->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->wardid; ?></td>
			<td><?php echo $row->roomno; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="1260";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addbeds_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1261";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='beds.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
