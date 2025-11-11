<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Parkingslots_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Parkingslots";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8304";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$parkingslots=new Parkingslots();
if(!empty($delid)){
	$parkingslots->id=$delid;
	$parkingslots->delete($parkingslots);
	redirect("parkingslots.php");
}
//Authorization.
$auth->roleid="8303";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addparkingslots_proc.php',600,430);" value="Add Parkingslots " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="8305";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8306";//Add
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
		$fields="prk_parkingslots.SlotID, prk_parkingslots.Street_Name, prk_parkingslots.X, prk_parkingslots.Y, prk_parkingslots.Agent_ID";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$parkingslots->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$parkingslots->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->SlotID; ?></td>
			<td><?php echo $row->Street_Name; ?></td>
			<td><?php echo formatNumber($row->X); ?></td>
			<td><?php echo formatNumber($row->Y); ?></td>
			<td><?php echo $row->Agent_ID; ?></td>
<?php
//Authorization.
$auth->roleid="8305";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addparkingslots_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8306";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='parkingslots.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
