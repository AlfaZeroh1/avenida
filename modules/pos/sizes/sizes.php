<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sizes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Sizes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8821";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$sizes=new Sizes();
if(!empty($delid)){
	$sizes->id=$delid;
	$sizes->delete($sizes);
	redirect("sizes.php");
}
//Authorization.
$auth->roleid="8820";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addsizes_proc.php',600,430);" value="Add Sizes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Size </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8822";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8823";//Add
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
		$fields="pos_sizes.id, pos_sizes.name, pos_sizes.remarks, pos_sizes.ipaddress, pos_sizes.createdby, pos_sizes.createdon, pos_sizes.lasteditedby, pos_sizes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$sizes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8822";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsizes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8823";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='sizes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
