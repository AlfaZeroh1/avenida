<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Vatclasses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Vatclasses";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4347";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$vatclasses=new Vatclasses();
if(!empty($delid)){
	$vatclasses->id=$delid;
	$vatclasses->delete($vatclasses);
	redirect("vatclasses.php");
}
//Authorization.
$auth->roleid="4346";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addvatclasses_proc.php',600,430);" value="Add Vatclasses " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>VAT Type </th>
			<th>Percent </th>
			<th>Liability</th>
<?php
//Authorization.
$auth->roleid="4348";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4349";//Add
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
		$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc, fn_liabilitys.name liabilityid";
		$join=" left join fn_liabilitys on fn_liabilitys.id=sys_vatclasses.liabilityid ";
		$having="";
		$groupby="";
		$orderby="";
		$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$vatclasses->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->perc); ?></td>
			<td><?php echo $row->liabilityid; ?></td>
<?php
//Authorization.
$auth->roleid="4348";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addvatclasses_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4349";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='vatclasses.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
