<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Housespecialdeposits_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Housespecialdeposits";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4314";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$housespecialdeposits=new Housespecialdeposits();
if(!empty($delid)){
	$housespecialdeposits->id=$delid;
	$housespecialdeposits->delete($housespecialdeposits);
	redirect("housespecialdeposits.php");
}
//Authorization.
$auth->roleid="4313";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addhousespecialdeposits_proc.php',600,280);"><span>ADD HSE SPECIAL DEPOSITS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>House </th>
			<th>Special Deposit </th>
			<th>Amount </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4315";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4316";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_housespecialdeposits.id, em_houses.name as houseid, em_paymentterms.name as paymenttermid, em_housespecialdeposits.amount, em_housespecialdeposits.remarks";
		$join=" left join em_houses on em_housespecialdeposits.houseid=em_houses.id  left join em_paymentterms on em_housespecialdeposits.paymenttermid=em_paymentterms.id ";
		$having="";
		$groupby="";
		$orderby="";
		$housespecialdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$housespecialdeposits->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->paymenttermid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4315";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addhousespecialdeposits_proc.php?id=<?php echo $row->id; ?>',600,280);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4316";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='housespecialdeposits.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
