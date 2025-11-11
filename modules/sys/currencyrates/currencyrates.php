<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Currencyrates_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Currencyrates";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8838";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$ob = (object)$_GET;

$delid=$_GET['delid'];
$currencyrates=new Currencyrates();
if(!empty($delid)){
	$currencyrates->id=$delid;
	$currencyrates->delete($currencyrates);
	redirect("currencyrates.php");
}
//Authorization.
$auth->roleid="8837";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcurrencyrates_proc.php',600,430);" value="Add Currencyrates " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Currency </th>
			<th>Currency Date From </th>
			<th>Currency Date To </th>
			<th>Kshs. Rate </th>
			<th>Euro Rate </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8839";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8840";//View
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
		$fields="sys_currencyrates.id, sys_currencys.name as currencyid, sys_currencyrates.fromcurrencydate, sys_currencyrates.tocurrencydate, sys_currencyrates.rate, sys_currencyrates.eurorate, sys_currencyrates.remarks, sys_currencyrates.ipaddress, sys_currencyrates.createdby, sys_currencyrates.createdon, sys_currencyrates.lasteditedby, sys_currencyrates.lasteditedon";
		$join=" left join sys_currencys on sys_currencyrates.currencyid=sys_currencys.id ";
		$having="";
		$groupby="";
		if(!empty($ob->currencyid)){
		  $where=" where currencyid='$ob->currencyid'";
		}
		$orderby=" order by sys_currencyrates.tocurrencydate desc ";
		$currencyrates->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$currencyrates->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->currencyid; ?></td>
			<td><?php echo formatDate($row->fromcurrencydate); ?></td>
			<td><?php echo formatDate($row->tocurrencydate); ?></td>
			<td><?php echo formatNumber($row->rate); ?></td>
			<td><?php echo formatNumber($row->eurorate); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8839";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcurrencyrates_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8840";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='currencyrates.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
