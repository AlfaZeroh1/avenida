<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotinsurances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Plotinsurances";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8120";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$plotinsurances=new Plotinsurances();
if(!empty($delid)){
	$plotinsurances->id=$delid;
	$plotinsurances->delete($plotinsurances);
	redirect("plotinsurances.php");
}
//Authorization.
$auth->roleid="8119";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addplotinsurances_proc.php',600,430);" value="Add Plotinsurances " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Plot </th>
			<th>Insurance Company </th>
			<th>Start Date </th>
			<th>Expiry Date </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8121";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8122";//View
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
		$fields="em_plotinsurances.id, em_plots.name as plotid, em_plotinsurances.company, em_plotinsurances.startdate, em_plotinsurances.expirydate, em_plotinsurances.remarks, em_plotinsurances.ipaddress, em_plotinsurances.createdby, em_plotinsurances.createdon, em_plotinsurances.lasteditedby, em_plotinsurances.lasteditedon";
		$join=" left join em_plots on em_plotinsurances.plotid=em_plots.id ";
		$having="";
		$groupby="";
		$orderby="";
		$plotinsurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plotinsurances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->plotid; ?></td>
			<td><?php echo $row->company; ?></td>
			<td><?php echo formatDate($row->startdate); ?></td>
			<td><?php echo formatDate($row->expirydate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8121";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addplotinsurances_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8122";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='plotinsurances.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
