<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Seasons_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Seasons";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8676";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$seasons=new Seasons();
if(!empty($delid)){
	$seasons->id=$delid;
	$seasons->delete($seasons);
	redirect("seasons.php");
}
//Authorization.
$auth->roleid="8675";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addseasons_proc.php',600,430);" value="Add Seasons " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Season </th>
			<th>Starts </th>
			<th>Ends </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="8677";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8678";//View
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
		$fields="pos_seasons.id, pos_seasons.name, pos_seasons.start, pos_seasons.end, pos_seasons.remarks, pos_seasons.ipaddress, pos_seasons.createdby, pos_seasons.createdon, pos_seasons.lasteditedby, pos_seasons.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$seasons->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$seasons->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo initialCap($row->name); ?></td>
			<td><?php echo formatDate($row->start); ?></td>
			<td><?php echo formatDate($row->end); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href=""></a></td>
<?php
//Authorization.
$auth->roleid="8677";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addseasons_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8678";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='seasons.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
