<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Closeaccounts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Closeaccounts";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8468";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$closeaccounts=new Closeaccounts();
if(!empty($delid)){
	$closeaccounts->id=$delid;
	$closeaccounts->delete($closeaccounts);
	redirect("closeaccounts.php");
}
//Authorization.
$auth->roleid="8467";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addcloseaccounts_proc.php',600,430);" value="Add Closeaccounts " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Plot </th>
			<th> </th>
			<th>Month </th>
			<th>Year </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="8469";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8470";//View
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
		$fields="em_closeaccounts.id, em_closeaccounts.plotid, em_closeaccounts.sttmtdate, em_closeaccounts.month, em_closeaccounts.year, em_closeaccounts.status, em_closeaccounts.ipaddress, em_closeaccounts.createdby, em_closeaccounts.createdon, em_closeaccounts.lasteditedby, em_closeaccounts.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$closeaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$closeaccounts->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->plotid; ?></td>
			<td><?php echo formatDate($row->sttmtdate); ?></td>
			<td><?php echo $row->month; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="8469";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcloseaccounts_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8470";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='closeaccounts.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
