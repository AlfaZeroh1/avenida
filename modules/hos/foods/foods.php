<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Foods_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Foods";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4496";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$foods=new Foods();
if(!empty($delid)){
	$foods->id=$delid;
	$foods->delete($foods);
	redirect("foods.php");
}
//Authorization.
$auth->roleid="4495";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addfoods_proc.php',600,430);" value="Add Foods " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Title </th>
			<th>Price </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4497";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4498";//Add
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
		$fields="hos_foods.id, hos_foods.name, hos_foods.price, hos_foods.remarks, hos_foods.createdby, hos_foods.createdon, hos_foods.lasteditedby, hos_foods.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$foods->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$foods->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->price); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4497";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfoods_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4498";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='foods.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
