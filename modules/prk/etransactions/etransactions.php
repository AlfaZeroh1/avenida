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
$auth->roleid="8300";//Add
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
$auth->roleid="8299";//View
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
			<th> </th>
<?php
//Authorization.
$auth->roleid="8301";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8302";//Add
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
		$fields="prk_etransactions.Txnid, prk_etransactions.id, prk_etransactions.orig, prk_etransactions.dest, prk_etransactions.tstamp, prk_etransactions.details, prk_etransactions.username, prk_etransactions.pass, prk_etransactions.mpesa_code, prk_etransactions.mpesa_acc, prk_etransactions.mpesa_msisdn, prk_etransactions.mpesa_trx_date, prk_etransactions.mpesa_trx_time, prk_etransactions.mpesa_amt, prk_etransactions.mpesa_sender, prk_etransactions.updatecode, prk_etransactions.UpdateDateTime, prk_etransactions.dac_charge, prk_etransactions.council_amt, prk_etransactions.slot_id, prk_etransactions.Vehicle_Reg, prk_etransactions.Payment_mode";
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
			<td><?php echo $row->Payment_mode; ?></td>
<?php
//Authorization.
$auth->roleid="8301";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addetransactions_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8302";//View
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
