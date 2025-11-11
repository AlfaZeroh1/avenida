<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemstatuss_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Itemstatuss";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2165";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$itemstatuss=new Itemstatuss();
if(!empty($delid)){
	$itemstatuss->id=$delid;
	$itemstatuss->delete($itemstatuss);
	redirect("itemstatuss.php");
}
//Authorization.
$auth->roleid="2164";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('additemstatuss_proc.php',600,430);" value="Add Itemstatuss " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
<?php
//Authorization.
$auth->roleid="2166";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2167";//View
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
		$fields="pos_itemstatuss.id, pos_itemstatuss.name, pos_itemstatuss.ipaddress, pos_itemstatuss.createdby, pos_itemstatuss.createdon, pos_itemstatuss.lasteditedby, pos_itemstatuss.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$itemstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$itemstatuss->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
<?php
//Authorization.
$auth->roleid="2166";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('additemstatuss_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2167";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='itemstatuss.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
