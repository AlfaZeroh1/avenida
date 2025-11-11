<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Assets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Assets";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="10309";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$assets=new Assets();
if(!empty($delid)){
	$assets->id=$delid;
	$assets->delete($assets);
	redirect("assets.php");
}
//Authorization.
$auth->roleid="10308";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addassets_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Category </th>
			<th>Quantity </th>
			<th>Cost Price </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="10310";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="10311";//View
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
		$fields="inv_assets.id, inv_assets.name, inv_assetcategorys.name as categoryid, inv_assets.quantity, inv_assets.costprice, inv_assets.remarks, inv_assets.ipaddress, inv_assets.createdby, inv_assets.createdon, inv_assets.lasteditedby, inv_assets.lasteditedon";
		$join=" left join inv_assetcategorys on inv_assets.categoryid=inv_assetcategorys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$assets->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo formatNumber($row->costprice); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="10310";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addassets_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="10311";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='assets.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
