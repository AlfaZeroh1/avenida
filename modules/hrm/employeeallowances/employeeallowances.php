<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeallowances_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../allowances/Allowances_class.php");
require_once("../../auth/rules/Rules_class.php");

if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=hrm_employeeallowances.createdby ";
		$k++;
}
if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeallowances";

//connect to db
$db=new DB();
//Authorization.
$auth->roleid="1120";//View
$auth->levelid=$_SESSION['level'];
$ob = (object)$_GET;
auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeallowances=new Employeeallowances();
if(!empty($delid)){
	$employeeallowances->id=$delid;
	$employeeallowances->delete($employeeallowances);
	redirect("employeeallowances.php");
}
//Authorization.
$auth->roleid="1119";//View
$auth->levelid=$_SESSION['level'];

$allowances = new Allowances();
$fields="*";
$where=" where id='$ob->allowanceid'";
$join="";
$orderby="";
$groupby="";
$having="";
$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$allowances = $allowances->fetchObject;

if(existsRule($auth)){
?>
<div class="container">
<hr>
<!-- <a class="btn btn-info" onclick="showPopWin('addemployeeallowances_proc.php',600,430);">Add Employeeallowances</a> -->
<?php }?>
<h3><?php echo $allowances->name; ?></h3>
<hr>


<table style="clear:both;"  class="table table-bordered table-condensed table-hover table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Allowance </th>
			<th>Employee </th>
			<th>Allowance Type </th>
			<th>Amount </th>
			<th>Month From </th>
			<th>Year From </th>
			<th>Month To </th>
			<th>Year To </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="1121";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="1122";//View
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
		$fields="hrm_employeeallowances.id, hrm_allowances.name as allowanceid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_allowancetypes.name as allowancetypeid, hrm_employeeallowances.amount, hrm_employeeallowances.frommonth, hrm_employeeallowances.fromyear, hrm_employeeallowances.tomonth, hrm_employeeallowances.toyear, hrm_employeeallowances.remarks, hrm_employeeallowances.createdby, hrm_employeeallowances.createdon, hrm_employeeallowances.lasteditedby, hrm_employeeallowances.lasteditedon";
		$join=" left join hrm_allowances on hrm_employeeallowances.allowanceid=hrm_allowances.id  left join hrm_employees on hrm_employeeallowances.employeeid=hrm_employees.id  left join hrm_allowancetypes on hrm_employeeallowances.allowancetypeid=hrm_allowancetypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where ="where hrm_employeeallowances.allowanceid = '$ob->allowanceid' ";
		$employeeallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeeallowances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->allowanceid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->allowancetypeid; ?></td>
			<td><?php echo formatNumber($row->amount); ?></td>
			<td><?php echo $row->frommonth; ?></td>
			<td><?php echo $row->fromyear; ?></td>
			<td><?php echo $row->tomonth; ?></td>
			<td><?php echo $row->toyear; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="1121";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeeallowances_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="1122";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='employeeallowances.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<hr>
</div>
<?php
include"../../../foot.php";

	
?>
