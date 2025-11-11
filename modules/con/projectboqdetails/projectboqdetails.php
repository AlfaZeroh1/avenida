<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectboqdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projectboqdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8516";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projectboqdetails=new Projectboqdetails();
if(!empty($delid)){
	$projectboqdetails->id=$delid;
	$projectboqdetails->delete($projectboqdetails);
	redirect("projectboqdetails.php");
}
//Authorization.
$auth->roleid="8515";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addprojectboqdetails_proc.php',600,430);" value="Add Projectboqdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>BoQ Item </th>
			<th>Category </th>
			<th> </th>
			<th>Estimation Manual Item </th>
			<th>Unit Of Measure </th>
			<th>Quantity </th>
			<th>Rate </th>
			<th>Total </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8517";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8518";//View
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
		$fields="con_projectboqdetails.id, con_projectboqs.name as projectboqid, con_materialcategorys.name as materialcategoryid, con_materialsubcategorys.name as materialsubcategoryid, con_estimationmanuals.name as estimationmanualid, tender_unitofmeasures.name as unitofmeasureid, con_projectboqdetails.quantity, con_projectboqdetails.rate, con_projectboqdetails.total, con_projectboqdetails.remarks, con_projectboqdetails.ipaddress, con_projectboqdetails.createdby, con_projectboqdetails.createdon, con_projectboqdetails.lasteditedby, con_projectboqdetails.lasteditedon";
		$join=" left join con_projectboqs on con_projectboqdetails.projectboqid=con_projectboqs.id  left join con_materialcategorys on con_projectboqdetails.materialcategoryid=con_materialcategorys.id  left join con_materialsubcategorys on con_projectboqdetails.materialsubcategoryid=con_materialsubcategorys.id  left join con_estimationmanuals on con_projectboqdetails.estimationmanualid=con_estimationmanuals.id  left join tender_unitofmeasures on con_projectboqdetails.unitofmeasureid=tender_unitofmeasures.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projectboqdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projectboqdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->projectboqid; ?></td>
			<td><?php echo $row->materialcategoryid; ?></td>
			<td><?php echo $row->materialsubcategoryid; ?></td>
			<td><?php echo $row->estimationmanualid; ?></td>
			<td><?php echo $row->unitofmeasureid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->rate); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8517";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addprojectboqdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8518";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='projectboqdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
