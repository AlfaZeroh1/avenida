<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectstocks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectstocks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8540";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectid=$_GET['projectid'];
$projectstocks=new Projectstocks();
if(!empty($delid)){
	$projectstocks->id=$delid;
	$projectstocks->delete($projectstocks);
	redirect("projectstocks.php");
}
//Authorization.
$auth->roleid="8539";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprojectstocks_proc.php',600,430);" value="Add Projectstocks " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item </th>
			<th>Quantity </th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="inv_projectstocks.id, con_projects.id as projectid, inv_items.name as itemid, inv_projectstocks.quantity, inv_projectstocks.ipaddress, inv_projectstocks.createdby, inv_projectstocks.createdon, inv_projectstocks.lasteditedby, inv_projectstocks.lasteditedon";
		$join=" left join con_projects on inv_projectstocks.projectid=con_projects.id  left join inv_items on inv_projectstocks.itemid=inv_items.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where con_projects.id='$projectid' ";
		$projectstocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectstocks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><a href="javascript:;" onclick="showPopWin('stocktrack.php.php?id=<?php echo $row->id; ?>&projectid=<?php echo $row->projectid; ?>',600,430);">View</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
