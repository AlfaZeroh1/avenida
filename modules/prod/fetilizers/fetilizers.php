<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fetilizers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Fetilizers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9095";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$fetilizers=new Fetilizers();
if(!empty($delid)){
	$fetilizers->id=$delid;
	$fetilizers->delete($fetilizers);
	redirect("fetilizers.php");
}
//Authorization.
$auth->roleid="9094";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addfetilizers_proc.php',600,430);" value="Add Fetilizers " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Fertilizer </th>
			<th>Remarks </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="9096";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9097";//Add
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
		$fields="prod_fetilizers.id, prod_fetilizers.name, prod_fetilizers.remarks, prod_fetilizers.status, prod_fetilizers.ipaddress, prod_fetilizers.createdby, prod_fetilizers.createdon, prod_fetilizers.lasteditedby, prod_fetilizers.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$fetilizers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$fetilizers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="9096";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addfetilizers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9097";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='fetilizers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
