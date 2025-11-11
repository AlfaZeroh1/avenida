<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Agentdeposits_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Agentdeposits";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8408";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$agentdeposits=new Agentdeposits();
if(!empty($delid)){
	$agentdeposits->id=$delid;
	$agentdeposits->delete($agentdeposits);
	redirect("agentdeposits.php");
}
//Authorization.
$auth->roleid="8407";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addagentdeposits_proc.php',600,430);" value="Add Agentdeposits " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Agent </th>
			<th>Bank </th>
			<th>Date Deposited </th>
			<th>Amount </th>
			<th>Slip No </th>
			<th>Deposit Slip Image </th>
<?php
//Authorization.
$auth->roleid="8409";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8410";//View
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
		$fields="reg_agentdeposits.id, reg_agents.name as agentid, fn_banks.name as bankid, reg_agentdeposits.depositedon, reg_agentdeposits.amount, reg_agentdeposits.slipno, reg_agentdeposits.file, reg_agentdeposits.ipaddress, reg_agentdeposits.createdby, reg_agentdeposits.createdon, reg_agentdeposits.lasteditedby, reg_agentdeposits.lasteditedon";
		$join=" left join reg_agents on reg_agentdeposits.agentid=reg_agents.id  left join fn_banks on reg_agentdeposits.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$agentdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$agentdeposits->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->agentid; ?></td>
			<td><?php echo $row->bankid; ?></td>
			<td><?php echo formatDate($row->depositedon); ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->slipno; ?></td>
			<td><?php echo $row->file; ?></td>
<?php
//Authorization.
$auth->roleid="8409";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addagentdeposits_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8410";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='agentdeposits.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
