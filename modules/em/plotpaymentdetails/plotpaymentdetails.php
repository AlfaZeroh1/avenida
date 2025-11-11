<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotpaymentdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Plotpaymentdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4132";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$plotpaymentdetails=new Plotpaymentdetails();
if(!empty($delid)){
	$plotpaymentdetails->id=$delid;
	$plotpaymentdetails->delete($plotpaymentdetails);
	redirect("plotpaymentdetails.php");
}
//Authorization.
$auth->roleid="4131";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addplotpaymentdetails_proc.php', 600, 430);"><span>ADD PLOT PAYMENT DETAILS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Plot </th>
			<th>Client Bank </th>
			<th>Bank Branch </th>
			<th>Account No </th>
			<th>Payment Date </th>
			<th>Payment Mode </th>
			<th>VAT Reg No </th>
			<th>PIN </th>
			<th>Cheques To </th>
<?php
//Authorization.
$auth->roleid="4133";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4134";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_plotpaymentdetails.id, em_plotpaymentdetails.plotid, em_clientbanks.name as clientbankid, em_plotpaymentdetails.branch, em_plotpaymentdetails.accntno, em_plotpaymentdetails.paidon, sys_paymentmodes.name as paymentmodeid, em_plotpaymentdetails.vatno, em_plotpaymentdetails.pin, em_plotpaymentdetails.chequesto";
		$join=" left join em_clientbanks on em_plotpaymentdetails.clientbankid=em_clientbanks.id  left join sys_paymentmodes on em_plotpaymentdetails.paymentmodeid=sys_paymentmodes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$plotpaymentdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plotpaymentdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->plotid; ?></td>
			<td><?php echo $row->clientbankid; ?></td>
			<td><?php echo $row->branch; ?></td>
			<td><?php echo $row->accntno; ?></td>
			<td><?php echo formatDate($row->paidon); ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->vatno; ?></td>
			<td><?php echo $row->pin; ?></td>
			<td><?php echo $row->chequesto; ?></td>
<?php
//Authorization.
$auth->roleid="4133";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addplotpaymentdetails_proc.php?id=<?php echo $row->id; ?>', 600, 430);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4134";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='plotpaymentdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
