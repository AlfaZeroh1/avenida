<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Qualitychecks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addqualitychecks_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Qualitychecks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8628";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$qualitychecks=new Qualitychecks();
if(!empty($delid)){
	$qualitychecks->id=$delid;
	$qualitychecks->delete($qualitychecks);
	redirect("qualitychecks.php");
}
//Authorization.
$auth->roleid="8627";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a class="btn btn-primary" href='addqualitychecks_proc.php'>New Qualitychecks</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Check Item </th>
			<th>Delivery </th>
			<th>Breeder </th>
			<th>Variety </th>
			<th>Check Date </th>
			<th>Findings </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8629";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8630";//View
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
		$fields="prod_qualitychecks.id, prod_checkitems.name as checkitemid, prod_breederdeliverydetails.name as breederdeliverydetailid, prod_breeders.name as breederid, prod_varietys.name as varietyid, prod_qualitychecks.checkedon, prod_qualitychecks.findings, prod_qualitychecks.remarks, prod_qualitychecks.ipaddress, prod_qualitychecks.createdby, prod_qualitychecks.createdon, prod_qualitychecks.lasteditedby, prod_qualitychecks.lasteditedon";
		$join=" left join prod_checkitems on prod_qualitychecks.checkitemid=prod_checkitems.id  left join prod_breederdeliverydetails on prod_qualitychecks.breederdeliverydetailid=prod_breederdeliverydetails.id  left join prod_breeders on prod_qualitychecks.breederid=prod_breeders.id  left join prod_varietys on prod_qualitychecks.varietyid=prod_varietys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$qualitychecks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$qualitychecks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->checkitemid; ?></td>
			<td><?php echo $row->breederdeliverydetailid; ?></td>
			<td><?php echo $row->breederid; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo formatDate($row->checkedon); ?></td>
			<td><?php echo $row->findings; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8629";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addqualitychecks_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8630";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='qualitychecks.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
