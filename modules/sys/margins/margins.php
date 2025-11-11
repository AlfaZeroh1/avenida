<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Margins_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Margins";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9408";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$margins=new Margins();
if(!empty($delid)){
	$margins->id=$delid;
	$margins->delete($margins);
	redirect("margins.php");
}
//Authorization.
$auth->roleid="9407";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input onclick="showPopWin('addmargins_proc.php',600,430);" value="Add Margins " type="button"/></div> -->
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Value </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="9409";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9410";//Add
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
		$fields="sys_margins.id, sys_margins.name, sys_margins.value, sys_margins.remarks, sys_margins.ipaddress, sys_margins.createdby, sys_margins.createdon, sys_margins.lasteditedby, sys_margins.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$margins->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$margins->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo formatNumber($row->value); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9409";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addmargins_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9410";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='margins.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
