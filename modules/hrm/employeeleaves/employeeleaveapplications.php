<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeleaves_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/leavesectiondetails/Leavesectiondetails_class.php");
require_once("../../hrm/leaves/Leaves_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeleaveapplications";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4230";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeleaves=new Employeeleaves();
if(!empty($delid)){
	$employeeleaveapplications->id=$delid;
	$employeeleaveapplications->delete($employeeleaveapplications);
	redirect("employeeleaveapplications.php");
}
//Authorization.
$auth->roleid="4229";//View
$auth->levelid=$_SESSION['level'];

?>

<div class="container">
<hr>
<table style="clear:both;"  class="table table-striped table-bordered" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Type Of Leave </th>
			<th>Start Date </th>
			<th>Duration (Working Days) </th>
			<th>Date Applied </th>
			<th>Status </th>
			<th>Remarks </th>
			<th>Memo</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="hrm_employeeleaves.id as lid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_leaves.name as leaveid, hrm_employeeleaves.startdate, hrm_employeeleaves.duration, hrm_employeeleaves.appliedon, hrm_employeeleaves.status, hrm_employeeleaves.remarks, hrm_employeeleaves.memo, hrm_employeeleaves.createdby, hrm_employeeleaves.createdon, hrm_employeeleaves.lasteditedby, hrm_employeeleaves.lasteditedon";
		$join=" left join hrm_employees on hrm_employeeleaves.employeeid=hrm_employees.id  left join hrm_leaves on hrm_employeeleaves.leaveid=hrm_leaves.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		$employeeleaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$employeeleaves->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->leaveid; ?></td>
			<td><?php echo formatDate($row->startdate); ?></td>
			<td><?php echo $row->duration; ?></td>
			<td><?php echo formatDate($row->appliedon); ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remarks;?></td>
			<td><?php echo $row->memo; ?></td>
			<td><?php if($row->status=="pending"){?><a href="javascript:;" onclick="showPopWin('addemployeeleaves_proc.php?lid=<?php echo $row->lid; ?>&tt=granted',600,430);">Grant</a><?php }?></td>
			<td><?php if($row->status=="pending"){?><a href="javascript:;" onclick="showPopWin('addemployeeleaves_proc.php?lid=<?php echo $row->lid; ?>&tt=sent back',600,430);">Send Back</a><?php }?></td>
			<td><?php if($row->status=="pending"){?><a href="javascript:;" onclick="showPopWin('addemployeeleaves_proc.php?lid=<?php echo $row->lid; ?>&tt=declined',600,430);">Decline</a><?php }?></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>

<hr>
</div> <!-- contend -->
<?php
include"../../../foot.php";
?>
