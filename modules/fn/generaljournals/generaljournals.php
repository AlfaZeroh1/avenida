<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Generaljournals_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("addgeneraljournals_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Generaljournals";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="760";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$generaljournals=new Generaljournals();
if(!empty($delid)){
	$generaljournals->id=$delid;
	$generaljournals->delete($generaljournals);
	redirect("generaljournals.php");
}
//Authorization.
$auth->roleid="759";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addgeneraljournals_proc.php'>New Generaljournals</a></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Account </th>
			<th>Debit  Account </th>
			<th>Item Name </th>
			<th>Document No. </th>
			<th>Mode </th>
			<th>Transaction </th>
			<th>Remarks </th>
			<th>Memo </th>
			<th>Transaction Date </th>
			<th>Debit </th>
			<th>Credit </th>
			<th>JV No. </th>
			<th>Cheque No. </th>
			<th>* </th>
			<th>Reconciliation Status </th>
			<th>Reconciliation Date </th>
			<th>Class </th>
<?php
//Authorization.
$auth->roleid="761";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="762";//View
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
		$fields="fn_generaljournals.id, fn_generaljournalaccounts.name as accountid, fn_generaljournals.daccountid, fn_generaljournals.tid, fn_generaljournals.documentno, fn_generaljournals.mode, fn_generaljournals.transactionid, fn_generaljournals.remarks, fn_generaljournals.memo, fn_generaljournals.transactdate, fn_generaljournals.debit, fn_generaljournals.credit, fn_generaljournals.jvno, fn_generaljournals.chequeno, fn_generaljournals.did, fn_generaljournals.reconstatus, fn_generaljournals.recondate, fn_generaljournals.class, fn_generaljournals.ipaddress, fn_generaljournals.createdby, fn_generaljournals.createdon, fn_generaljournals.lasteditedby, fn_generaljournals.lasteditedon";
		$join=" left join fn_generaljournalaccounts on fn_generaljournals.accountid=fn_generaljournalaccounts.id ";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$generaljournals->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->accountid; ?></td>
			<td><?php echo $row->daccountid; ?></td>
			<td><?php echo $row->tid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->mode; ?></td>
			<td><?php echo $row->transactionid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php echo formatDate($row->transactdate); ?></td>
			<td><?php echo formatNumber($row->debit); ?></td>
			<td><?php echo formatNumber($row->credit); ?></td>
			<td><?php echo $row->jvno; ?></td>
			<td><?php echo $row->chequeno; ?></td>
			<td><?php echo $row->did; ?></td>
			<td><?php echo $row->reconstatus; ?></td>
			<td><?php echo formatDate($row->recondate); ?></td>
			<td><?php echo $row->class; ?></td>
<?php
//Authorization.
$auth->roleid="761";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addgeneraljournals_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="762";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='generaljournals.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
