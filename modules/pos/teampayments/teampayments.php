<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teampayments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Teampayments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="12477";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$teampayments=new Teampayments();
if(!empty($delid)){
	$teampayments->id=$delid;
	$teampayments->delete($teampayments);
	redirect("teampayments.php");
}
//Authorization.
$auth->roleid="12476";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addteampayments_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Team Detail </th>
			<th> </th>
			<th> </th>
			<th>Payment Mode </th>
			<th>Bank </th>
			<th> </th>
			<th>Amount </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="12478";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="12479";//Add
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
		$fields="pos_teampayments.id, pos_teampayments.teamdetailid, pos_teampayments.cashier, pos_teampayments.brancheid, pos_teampayments.paymentmodeid, pos_teampayments.bankid, pos_teampayments.imprestaccountid, pos_teampayments.amount, pos_teampayments.remarks, pos_teampayments.ipaddress, pos_teampayments.createdby, pos_teampayments.createdon, pos_teampayments.lasteditedby, pos_teampayments.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$teampayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$teampayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->teamdetailid; ?></td>
			<td><?php echo $row->cashier; ?></td>
			<td><?php echo $row->brancheid; ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo $row->imprestaccountid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="12478";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addteampayments_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="12479";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='teampayments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
