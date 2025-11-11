<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotspecialdeposits_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Plotspecialdeposits";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4318";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$plotspecialdeposits=new Plotspecialdeposits();
if(!empty($delid)){
	$plotspecialdeposits->id=$delid;
	$plotspecialdeposits->delete($plotspecialdeposits);
	redirect("plotspecialdeposits.php");
}
//Authorization.
$auth->roleid="4317";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addplotspecialdeposits_proc.php',600,300);"><span>ADD SPECIAL DEPOSITS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Plot </th>
			<th>Special Deposit </th>
			<th>Amount </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4319";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4320";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_plotspecialdeposits.id, em_plots.name as plotid, em_paymentterms.name as paymenttermid, em_plotspecialdeposits.amount, em_plotspecialdeposits.remarks";
		$join=" left join em_plots on em_plotspecialdeposits.plotid=em_plots.id  left join em_paymentterms on em_plotspecialdeposits.paymenttermid=em_paymentterms.id ";
		$having="";
		$groupby="";
		$orderby="";
		$plotspecialdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plotspecialdeposits->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->plotid; ?></td>
			<td><?php echo $row->paymenttermid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4319";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addplotspecialdeposits_proc.php?id=<?php echo $row->id; ?>',600,300);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4320";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='plotspecialdeposits.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
