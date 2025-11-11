<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Leavesectiondetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Leavesectiondetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9979";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$leavesectiondetails=new Leavesectiondetails();
if(!empty($delid)){
	$leavesectiondetails->id=$delid;
	$leavesectiondetails->delete($leavesectiondetails);
	redirect("leavesectiondetails.php");
}
//Authorization.
$auth->roleid="9978";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addleavesectiondetails_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th> </th>
			<th>Leave Section </th>
			<th>Days </th>
			<th> </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9980";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9981";//View
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
		$fields="hrm_leavesectiondetails.id, hrm_leaves.name as leaveid, hrm_leavesections.name as leavesectionid, hrm_leavesectiondetails.days, hrm_leavesectiondetails.duration, hrm_leavesectiondetails.remarks, hrm_leavesectiondetails.ipaddress, hrm_leavesectiondetails.createdby, hrm_leavesectiondetails.createdon, hrm_leavesectiondetails.lasteditedby, hrm_leavesectiondetails.lasteditedon";
		$join=" left join hrm_leaves on hrm_leavesectiondetails.leaveid=hrm_leaves.id  left join hrm_leavesections on hrm_leavesectiondetails.leavesectionid=hrm_leavesections.id ";
		$having="";
		$groupby="";
		$orderby="";
		$leavesectiondetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$leavesectiondetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->leaveid; ?></td>
			<td><?php echo $row->leavesectionid; ?></td>
			<td><?php echo formatNumber($row->days); ?></td>
			<td><?php echo $row->duration; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9980";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addleavesectiondetails_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="9981";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='leavesectiondetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
