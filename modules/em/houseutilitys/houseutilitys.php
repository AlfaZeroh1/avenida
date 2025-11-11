<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houseutilitys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Houseutilitys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4120";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$houseutilitys=new Houseutilitys();
if(!empty($delid)){
	$houseutilitys->id=$delid;
	$houseutilitys->delete($houseutilitys);
	redirect("houseutilitys.php");
}
//Authorization.
$auth->roleid="4119";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addhouseutilitys_proc.php',600,430);" value="Add Houseutilitys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>House </th>
			<th>Payment Term </th>
			<th>Amount </th>
			<th> </th>
			<th>Charge Mgt Fee? </th>
			<th>Mgt Fee Deposit </th>
			<th>VATable </th>
			<th>VAT Class </th>
			<th>Is Mgt Fee VATable </th>
			<th>Mgt Fee VAT Class </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4121";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4122";//View
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
		$fields="em_houseutilitys.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, em_paymentterms.name as paymenttermid, em_houseutilitys.amount, em_houseutilitys.showinst, em_houseutilitys.mgtfee, em_houseutilitys.mgtfeeperc, em_houseutilitys.vatable, sys_vatclasses.name as vatclasseid, em_houseutilitys.mgtfeevatable, em_houseutilitys.mgtfeevatclasseid, em_houseutilitys.remarks, em_houseutilitys.ipaddress, em_houseutilitys.createdby, em_houseutilitys.createdon, em_houseutilitys.lasteditedby, em_houseutilitys.lasteditedon";
		$join=" left join em_houses on em_houseutilitys.houseid=em_houses.id  left join em_paymentterms on em_houseutilitys.paymenttermid=em_paymentterms.id  left join sys_vatclasses on em_houseutilitys.vatclasseid=sys_vatclasses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$houseutilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$houseutilitys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->paymenttermid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->showinst; ?></td>
			<td><?php echo $row->mgtfee; ?></td>
			<td><?php echo formatNumber($row->mgtfeeperc); ?></td>
			<td><?php echo $row->vatable; ?></td>
			<td><?php echo $row->vatclasseid; ?></td>
			<td><?php echo $row->mgtfeevatable; ?></td>
			<td><?php echo $row->mgtfeevatclasseid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4121";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addhouseutilitys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4122";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='houseutilitys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
