<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Leavesections_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Leavesections";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9983";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$leavesections=new Leavesections();
if(!empty($delid)){
	$leavesections->id=$delid;
	$leavesections->delete($leavesections);
	redirect("leavesections.php");
}
//Authorization.
$auth->roleid="9982";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addleavesections_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Section Name </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9984";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9985";//View
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
		$fields="hrm_leavesections.id, hrm_leavesections.name, hrm_leavesections.remarks, hrm_leavesections.ipaddress, hrm_leavesections.createdby, hrm_leavesections.createdon, hrm_leavesections.lasteditedby, hrm_leavesections.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$leavesections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$leavesections->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9984";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addleavesections_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="9985";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='leavesections.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
