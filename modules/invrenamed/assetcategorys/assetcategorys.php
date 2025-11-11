<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Assetcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Assetcategorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="10337";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$assetcategorys=new Assetcategorys();
if(!empty($delid)){
	$assetcategorys->id=$delid;
	$assetcategorys->delete($assetcategorys);
	redirect("assetcategorys.php");
}
//Authorization.
$auth->roleid="10336";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addassetcategorys_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Category Name </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="10338";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="10339";//Add
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
		$fields="inv_assetcategorys.id, inv_assetcategorys.name, inv_assetcategorys.remarks, inv_assetcategorys.ipaddress, inv_assetcategorys.createdby, inv_assetcategorys.createdon, inv_assetcategorys.lasteditedby, inv_assetcategorys.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$assetcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$assetcategorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="10338";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addassetcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="10339";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='assetcategorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
