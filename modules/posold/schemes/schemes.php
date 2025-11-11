<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Schemes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Schemes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="2213";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$schemes=new Schemes();
if(!empty($delid)){
	$schemes->id=$delid;
	$schemes->delete($schemes);
	redirect("schemes.php");
}
//Authorization.
$auth->roleid="2212";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addschemes_proc.php',600,430);" value="Add Schemes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Scheme </th>
			<th>Location </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="2214";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="2215";//View
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
		$fields="pos_schemes.id, pos_schemes.name, pos_schemes.location, pos_schemes.description, pos_schemes.createdby, pos_schemes.createdon, pos_schemes.lasteditedby, pos_schemes.lasteditedon, pos_schemes.ipaddress";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$schemes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$schemes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->location; ?></td>
			<td><?php echo $row->description; ?></td>
<?php
//Authorization.
$auth->roleid="2214";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addschemes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="2215";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='schemes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
