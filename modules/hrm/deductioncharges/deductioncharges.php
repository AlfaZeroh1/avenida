<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deductioncharges_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
	$deductionid=$_GET['deductionid'];
	$where=" where deductionid='$deductionid'";

$page_title="Deductioncharges";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4326";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$deductioncharges=new Deductioncharges();
if(!empty($delid)){
	$deductioncharges->id=$delid;
	$deductioncharges->delete($deductioncharges);
	redirect("deductioncharges.php");
}
//Authorization.
$auth->roleid="4325";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('adddeductioncharges_proc.php?deductionid=<?php echo $deductionid; ?>',600,430);">ADD DEDUCTION CHARGES</a>
<?php }?>
<hr>
<table style="clear:both;" class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Deduction </th>
			<th>Amount From </th>
			<th>Amount To </th>
			<th>Charge </th>
			<th>Type </th>
			<th>Remarks </th>
			<th>Formula </th>
<?php
//Authorization.
$auth->roleid="4327";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4328";//View
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
		$fields="hrm_deductioncharges.id, hrm_deductions.name as deductionid, hrm_deductioncharges.amountfrom, hrm_deductioncharges.amountto, hrm_deductioncharges.charge, hrm_deductioncharges.chargetype, hrm_deductioncharges.remarks, hrm_deductioncharges.formula";
		$join=" left join hrm_deductions on hrm_deductioncharges.deductionid=hrm_deductions.id ";
		$having="";
		$groupby="";
		$orderby="";
		$deductioncharges->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$deductioncharges->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->deductionid; ?></td>
			<td><?php echo formatNumber($row->amountfrom); ?></td>
			<td><?php echo formatNumber($row->amountto); ?></td>
			<td><?php echo formatNumber($row->charge); ?></td>
			<td><?php echo $row->chargetype; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->formula; ?></td>
<?php
//Authorization.
$auth->roleid="4327";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddeductioncharges_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4328";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='deductioncharges.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
</div>
<?php
include"../../../foot.php";
?>
