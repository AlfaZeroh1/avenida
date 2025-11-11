<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Etransactions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Etransactions";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8232";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$etransactions=new Etransactions();
if(!empty($delid)){
	$etransactions->id=$delid;
	$etransactions->delete($etransactions);
	redirect("etransactions.php");
}
//Authorization.
$auth->roleid="8231";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addetransactions_proc.php',600,430);" value="Add Etransactions " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="8233";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8234";//View
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
		$fields="fn_etransactions.Txnid, fn_etransactions.id, fn_etransactions.orig, fn_etransactions.dest, fn_etransactions.tstamp, fn_etransactions.details, fn_etransactions.username, fn_etransactions.pass, fn_etransactions.mpesa_code, fn_etransactions.mpesa_acc, fn_etransactions.mpesa_msisdn, fn_etransactions.mpesa_trx_date, fn_etransactions.mpesa_trx_time, fn_etransactions.mpesa_amt, fn_etransactions.mpesa_sender, fn_etransactions.updatecode, fn_etransactions.UpdateDateTime, fn_etransactions.dac_charge, fn_etransactions.council_amt, fn_etransactions.slot_id, fn_etransactions.Vehicle_Reg";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$etransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$etransactions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->Txnid; ?></td>
			<td><?php echo $row->orig; ?></td>
			<td><?php echo $row->dest; ?></td>
			<td><?php echo formatDate($row->tstamp); ?></td>
			<td><?php echo $row->details; ?></td>
			<td><?php echo $row->username; ?></td>
			<td><?php echo $row->pass; ?></td>
			<td><?php echo $row->mpesa_code; ?></td>
			<td><?php echo $row->mpesa_acc; ?></td>
			<td><?php echo $row->mpesa_msisdn; ?></td>
			<td><?php echo formatDate($row->mpesa_trx_date); ?></td>
			<td><?php echo $row->mpesa_trx_time; ?></td>
			<td><?php echo formatNumber($row->mpesa_amt); ?></td>
			<td><?php echo $row->mpesa_sender; ?></td>
			<td><?php echo $row->updatecode; ?></td>
			<td><?php echo formatDate($row->UpdateDateTime); ?></td>
			<td><?php echo formatNumber($row->dac_charge); ?></td>
			<td><?php echo formatNumber($row->council_amt); ?></td>
			<td><?php echo $row->slot_id; ?></td>
			<td><?php echo $row->Vehicle_Reg; ?></td>
<?php
//Authorization.
$auth->roleid="8233";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addetransactions_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8234";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='etransactions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
