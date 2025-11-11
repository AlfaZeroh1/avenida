<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Billofquantities_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Billofquantities";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7780";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$billofquantities=new Billofquantities();
if(!empty($delid)){
	$billofquantities->id=$delid;
	$billofquantities->delete($billofquantities);
	redirect("billofquantities.php");
}
//Authorization.
$auth->roleid="7779";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addbillofquantities_proc.php',600,430);" value="Add Billofquantities " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Tender </th>
			<th>Bill Of Quantity </th>
			<th>Quantity </th>
			<th>Unit Of Measure </th>
			<th>BQ Rate </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7781";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7782";//View
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
		$fields="tender_billofquantities.id, tender_tenders.name as tenderid, tender_billofquantities.bqitem, tender_billofquantities.quantity, tender_unitofmeasures.name as unitofmeasureid, tender_billofquantities.bqrate, tender_billofquantities.remarks, tender_billofquantities.ipaddress, tender_billofquantities.createdby, tender_billofquantities.createdon, tender_billofquantities.lasteditedby, tender_billofquantities.lasteditedon";
		$join=" left join tender_tenders on tender_billofquantities.tenderid=tender_tenders.id  left join tender_unitofmeasures on tender_billofquantities.unitofmeasureid=tender_unitofmeasures.id ";
		$having="";
		$groupby="";
		$orderby="";
		$billofquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$billofquantities->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->tenderid; ?></td>
			<td><?php echo $row->bqitem; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->unitofmeasureid; ?></td>
			<td><?php echo formatNumber($row->bqrate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7781";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addbillofquantities_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7782";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='billofquantities.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
