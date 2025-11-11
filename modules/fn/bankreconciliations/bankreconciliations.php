<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bankreconciliations_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Bankreconciliations";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4376";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$bankreconciliations=new Bankreconciliations();
if(!empty($delid)){
	$bankreconciliations->id=$delid;
	$bankreconciliations->delete($bankreconciliations);
	redirect("bankreconciliations.php");
}
//Authorization.
$auth->roleid="4375";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addbankreconciliations_proc.php',600,430);" value="Add Bankreconciliations " type="button"/></div>
<?php }?>

<script type="text/javascript" language="javascript">
function clickHeretoPrint(bankid,recondate){
  poptastic("printrecon.php?bankid="+bankid+"&todate="+recondate,450,940);
}
</script>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Bank </th>
			<th>Reconciliation Date </th>
			<th>Bank Balance </th>
<?php
//Authorization.
$auth->roleid="4377";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4378";//Add
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
		$fields="fn_bankreconciliations.id, fn_banks.name as bankid, fn_banks.id bank, fn_bankreconciliations.recondate, fn_bankreconciliations.balance";
		$join=" left join fn_banks on fn_bankreconciliations.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby=" order by fn_bankreconciliations.recondate desc ";
		$bankreconciliations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$bankreconciliations->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="javascript:;" onClick="clickHeretoPrint('<?php echo $row->bank; ?>','<?php echo $row->recondate; ?>')"><?php echo $row->bankid; ?></a></td>
			<td><?php echo formatDate($row->recondate); ?></td>
			<td><?php echo formatNumber($row->balance); ?></td>
<?php
//Authorization.
$auth->roleid="4377";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addbankreconciliations_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4378";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='bankreconciliations.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
