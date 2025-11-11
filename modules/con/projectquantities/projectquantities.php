<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectquantities_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectquantities";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7571";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectquantities=new Projectquantities();
if(!empty($delid)){
	$projectquantities->id=$delid;
	$projectquantities->delete($projectquantities);
	redirect("projectquantities.php");
}
//Authorization.
$auth->roleid="7570";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addprojectquantities_proc.php',800,500);">Add Projectquantities</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Project </th>
			<th>Project BoQ Detail </th>
			<th>Item </th>
			<th> </th>
			<th>Category </th>
			<th>Sub-category </th>
			<th>Quantity </th>
			<th>Estimate Rate </th>
			<th>Remarks </th>
			<th>Project Week </th>
			<th>Calendar Week </th>
			<th>Year Required </th>
<?php
//Authorization.
$auth->roleid="7572";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7573";//View
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
		$fields="con_projectquantities.id, con_projects.name as projectid, con_projectboqdetails.name as projectboqdetailid, inv_items.name as itemid, con_labours.name as labourid, con_materialcategorys.name as categoryid, con_materialsubcategorys.name as subcategoryid, con_projectquantities.quantity, con_projectquantities.rate, con_projectquantities.remarks, con_projectquantities.projectweek, con_projectquantities.week, con_projectquantities.year, con_projectquantities.ipaddress, con_projectquantities.createdby, con_projectquantities.createdon, con_projectquantities.lasteditedby, con_projectquantities.lasteditedon";
		$join=" left join con_projects on con_projectquantities.projectid=con_projects.id  left join con_projectboqdetails on con_projectquantities.projectboqdetailid=con_projectboqdetails.id  left join inv_items on con_projectquantities.itemid=inv_items.id  left join con_labours on con_projectquantities.labourid=con_labours.id  left join con_materialcategorys on con_projectquantities.categoryid=con_materialcategorys.id  left join con_materialsubcategorys on con_projectquantities.subcategoryid=con_materialsubcategorys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectquantities->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->projectid; ?></td>
			<td><?php echo $row->projectboqdetailid; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->labourid; ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo $row->subcategoryid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->rate); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->projectweek; ?></td>
			<td><?php echo $row->week; ?></td>
			<td><?php echo $row->year; ?></td>
<?php
//Authorization.
$auth->roleid="7572";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectquantities_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7573";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectquantities.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
