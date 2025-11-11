<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sam_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Sam";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="12473";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$sam=new Sam();
if(!empty($delid)){
	$sam->id=$delid;
	$sam->delete($sam);
	redirect("sam.php");
}
//Authorization.
$auth->roleid="12472";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addsam_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>First Name </th>
			<th>Other Names </th>
			<th>Address </th>
			<th>Branch </th>
<?php
//Authorization.
$auth->roleid="12474";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="12475";//Add
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
		$fields="sys_sam.id, sys_sam.firstname, sys_sam.othernames, sys_sam.address, sys_branches.name as brancheid, sys_sam.ipaddress, sys_sam.createdby, sys_sam.createdon, sys_sam.lasteditedby, sys_sam.lasteditedon";
		$join=" left join sys_branches on sys_sam.brancheid=sys_branches.id ";
		$having="";
		$groupby="";
		$orderby="";
		$sam->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$sam->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->firstname; ?></td>
			<td><?php echo $row->othernames; ?></td>
			<td><?php echo $row->address; ?></td>
			<td><?php echo $row->brancheid; ?></td>
<?php
//Authorization.
$auth->roleid="12474";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsam_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="12475";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='sam.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
