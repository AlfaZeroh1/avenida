<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Transfers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Transfers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="10341";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$transfers=new Transfers();
if(!empty($delid)){
	$transfers->id=$delid;
	$transfers->delete($transfers);
	redirect("transfers.php");
}
//Authorization.
$auth->roleid="10340";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addtransfers_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Bank </th>
			<th>Amount </th>
			<th>Currency </th>
			<th>Rate </th>
			<th>Rate </th>
			<th>Exchange Rate </th>
			<th>To Bank </th>
			<th>To Currency </th>
			<th>To Euro Rate </th>
			<th>To Rate </th>
			<th>Difference Ksh </th>
			<th>Difference Euro </th>
			<th>Payment Mode </th>
			<th>Transaction No </th>
			<th>Cheque No </th>
			<th>Transfered On </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="10342";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="10343";//Add
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
		$fields="fn_transfers.id, fn_banks.name as bankid, fn_transfers.amount, fn_transfers.currencyid, fn_transfers.rate, fn_transfers.eurorate, fn_transfers.exchangerate, fn_transfers.tobankid, sys_currencys.name as tocurrencyid, fn_transfers.toeurate, fn_transfers.torate, fn_transfers.diffksh, fn_transfers.diffeuro, sys_paymentmodes.name as paymentmodeid, fn_transfers.transactno, fn_transfers.chequeno, fn_transfers.transactdate, fn_transfers.remarks, fn_transfers.createdby, fn_transfers.createdon, fn_transfers.lasteditedon, fn_transfers.lasteditedby, fn_transfers.ipaddress";
		$join=" left join fn_banks on fn_transfers.bankid=fn_banks.id  left join sys_currencys on fn_transfers.tocurrencyid=sys_currencys.id  left join sys_paymentmodes on fn_transfers.paymentmodeid=sys_paymentmodes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$transfers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$transfers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->currencyid; ?></td>
			<td><?php echo formatNumber($row->rate); ?></td>
			<td><?php echo formatNumber($row->eurorate); ?></td>
			<td><?php echo formatNumber($row->exchangerate); ?></td>
			<td><?php echo formatNumber($row->tobankid); ?></td>
			<td><?php echo $row->tocurrencyid; ?></td>
			<td><?php echo formatNumber($row->toeurate); ?></td>
			<td><?php echo formatNumber($row->torate); ?></td>
			<td><?php echo formatNumber($row->diffksh); ?></td>
			<td><?php echo formatNumber($row->diffeuro); ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->transactno; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo formatDate($row->transactdate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="10342";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addtransfers_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="10343";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='transfers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
