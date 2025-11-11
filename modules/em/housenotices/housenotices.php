<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Housenotices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Housenotices";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4863";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$housenotices=new Housenotices();
if(!empty($delid)){
	$housenotices->id=$delid;
	$housenotices->delete($housenotices);
	redirect("housenotices.php");
}
//Authorization.
$auth->roleid="4862";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addhousenotices_proc.php',600,430);" value="Add Housenotices " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>House </th>
			<th>Notice Date </th>
			<th>Vacation Date </th>
			<th>Status </th>
			<th>Remarks </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="4864";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4865";//View
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
		$fields="em_housenotices.id, em_houses.name as houseid, em_housenotices.noticedate, em_housenotices.tovacateon, em_housenotices.status, em_housenotices.remarks, em_housenotices.createdby, em_housenotices.createdon, em_housenotices.lasteditedby, em_housenotices.lasteditedon, em_housenotices.ipaddress";
		$join=" left join em_houses on em_housenotices.houseid=em_houses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$housenotices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$housenotices->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo formatDate($row->noticedate); ?></td>
			<td><?php echo formatDate($row->tovacateon); ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->ipaddress; ?></td>
<?php
//Authorization.
$auth->roleid="4864";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addhousenotices_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4865";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='housenotices.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
