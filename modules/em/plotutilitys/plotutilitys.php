<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotutilitys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Plotutilitys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4140";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$plotutilitys=new Plotutilitys();
if(!empty($delid)){
	$plotutilitys->id=$delid;
	$plotutilitys->delete($plotutilitys);
	redirect("plotutilitys.php");
}
//Authorization.
$auth->roleid="4139";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addplotutilitys_proc.php',600,430);" value="Add Plotutilitys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Plot </th>
			<th>Payment Term </th>
			<th>Amount </th>
			<th> </th>
			<th>Charge Mgt Fee? </th>
			<th>Mgt Fee Deposit </th>
			<th>VATable </th>
			<th>VAT Class </th>
			<th>Is Mgt Fee VATable </th>
			<th>Mgt Fee VAT Class </th>
<?php
//Authorization.
$auth->roleid="4141";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4142";//View
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
		$fields="em_plotutilitys.id, em_plots.name as plotid, em_paymentterms.name as paymenttermid, em_plotutilitys.amount, em_plotutilitys.showinst, em_plotutilitys.mgtfee, em_plotutilitys.mgtfeeperc, em_plotutilitys.vatable, sys_vatclasses.name as vatclasseid, em_plotutilitys.mgtfeevatable, em_plotutilitys.mgtfeevatclasseid, em_plotutilitys.ipaddress, em_plotutilitys.createdby, em_plotutilitys.createdon, em_plotutilitys.lasteditedby, em_plotutilitys.lasteditedon";
		$join=" left join em_plots on em_plotutilitys.plotid=em_plots.id  left join em_paymentterms on em_plotutilitys.paymenttermid=em_paymentterms.id  left join sys_vatclasses on em_plotutilitys.vatclasseid=sys_vatclasses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$plotutilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plotutilitys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->plotid; ?></td>
			<td><?php echo $row->paymenttermid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->showinst; ?></td>
			<td><?php echo $row->mgtfee; ?></td>
			<td><?php echo formatNumber($row->mgtfeeperc); ?></td>
			<td><?php echo $row->vatable; ?></td>
			<td><?php echo $row->vatclasseid; ?></td>
			<td><?php echo $row->mgtfeevatable; ?></td>
			<td><?php echo $row->mgtfeevatclasseid; ?></td>
<?php
//Authorization.
$auth->roleid="4141";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addplotutilitys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4142";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='plotutilitys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
