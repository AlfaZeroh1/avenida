<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeleavedays_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeleavedays";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9263";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeleavedays=new Employeeleavedays();
if(!empty($delid)){
	$employeeleavedays->id=$delid;
	$employeeleavedays->delete($employeeleavedays);
	redirect("employeeleavedays.php");
}
//Authorization.
$auth->roleid="9262";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addemployeeleavedays_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;"  class="table table-codensed" id="example" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Leave Type </th>
			<th>Year </th>
			<th>Days </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9264";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9265";//View
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
		$fields="hrm_employeeleavedays.id, concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) employeeid, hrm_leavetypes.name as leavetypeid, hrm_employeeleavedays.year, hrm_employeeleavedays.days, hrm_employeeleavedays.remarks, hrm_employeeleavedays.ipaddress, hrm_employeeleavedays.createdby, hrm_employeeleavedays.createdon, hrm_employeeleavedays.lasteditedby, hrm_employeeleavedays.lasteditedon";
		$join=" left join hrm_employees on hrm_employeeleavedays.employeeid=hrm_employees.id  left join hrm_leavetypes on hrm_employeeleavedays.leavetypeid=hrm_leavetypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$employeeleavedays->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeeleavedays->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->leavetypeid; ?></td>
			<td><?php echo $row->year; ?></td>
			<td><?php echo $row->days; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9264";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeeleavedays_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="9265";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeeleavedays.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
