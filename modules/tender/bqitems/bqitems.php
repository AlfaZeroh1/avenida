<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bqitems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Bqitems";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7784";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$bqitems=new Bqitems();
if(!empty($delid)){
	$bqitems->id=$delid;
	$bqitems->delete($bqitems);
	redirect("bqitems.php");
}
//Authorization.
$auth->roleid="7783";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addbqitems_proc.php',600,430);" value="Add Bqitems " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>BQ Item </th>
			<th>Unit Of Measure </th>
			<th>BQ Rate </th>
			<th>Actual Rate </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7785";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7786";//View
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
		$fields="tender_bqitems.id, tender_bqitems.name, tender_unitofmeasures.name as unitofmeasureid, tender_bqitems.bqrate, tender_bqitems.actualrate, tender_bqitems.remarks, tender_bqitems.ipaddress, tender_bqitems.createdby, tender_bqitems.createdon, tender_bqitems.lasteditedby, tender_bqitems.lasteditedon";
		$join=" left join tender_unitofmeasures on tender_bqitems.unitofmeasureid=tender_unitofmeasures.id ";
		$having="";
		$groupby="";
		$orderby="";
		$bqitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$bqitems->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->unitofmeasureid; ?></td>
			<td><?php echo formatNumber($row->bqrate); ?></td>
			<td><?php echo formatNumber($row->actualrate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7785";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addbqitems_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7786";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='bqitems.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
