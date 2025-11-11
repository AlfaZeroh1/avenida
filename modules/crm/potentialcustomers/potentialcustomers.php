<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Potentialcustomers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Potentialcustomers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8492";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$potentialcustomers=new Potentialcustomers();
if(!empty($delid)){
	$potentialcustomers->id=$delid;
	$potentialcustomers->delete($potentialcustomers);
	redirect("potentialcustomers.php");
}
//Authorization.
$auth->roleid="8491";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addpotentialcustomers_proc.php',600,430);" value="Add Potentialcustomers " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Customer Name </th>
			<th>Agent Name </th>
			<th>Department </th>
			<th>Category Department </th>
			<th>Category </th>
			<th>Sales Person </th>
			<th>Id No. </th>
			<th>Pin No </th>
			<th>Address </th>
			<th>TelNo. </th>
			<th>Fax </th>
			<th>E-mail </th>
			<th>Contact Name </th>
			<th>Contact Phone </th>
			<th>Remarks </th>
			<th>Status </th>
<?php
//Authorization.
$auth->roleid="8493";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8494";//Add
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
		$fields="crm_potentialcustomers.id, crm_potentialcustomers.name, crm_agents.name as agentid, crm_departments.name as departmentid, crm_categorydepartments.name as categorydepartmentid, crm_categorys.name as categoryid, hrm_employees.name as employeeid, crm_potentialcustomers.idno, crm_potentialcustomers.pinno, crm_potentialcustomers.address, crm_potentialcustomers.tel, crm_potentialcustomers.fax, crm_potentialcustomers.email, crm_potentialcustomers.contactname, crm_potentialcustomers.contactphone, crm_potentialcustomers.remarks, crm_potentialcustomers.status, crm_potentialcustomers.createdby, crm_potentialcustomers.createdon, crm_potentialcustomers.lasteditedby, crm_potentialcustomers.lasteditedon, crm_potentialcustomers.ipaddress";
		$join=" left join crm_agents on crm_potentialcustomers.agentid=crm_agents.id  left join crm_departments on crm_potentialcustomers.departmentid=crm_departments.id  left join crm_categorydepartments on crm_potentialcustomers.categorydepartmentid=crm_categorydepartments.id  left join crm_categorys on crm_potentialcustomers.categoryid=crm_categorys.id  left join hrm_employees on crm_potentialcustomers.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$potentialcustomers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$potentialcustomers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->agentid; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->categorydepartmentid; ?></td>
			<td><?php echo $row->categoryid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->idno; ?></td>
			<td><?php echo $row->pinno; ?></td>
			<td><?php echo $row->address; ?></td>
			<td><?php echo $row->tel; ?></td>
			<td><?php echo $row->fax; ?></td>
			<td><?php echo $row->email; ?></td>
			<td><?php echo $row->contactname; ?></td>
			<td><?php echo $row->contactphone; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->status; ?></td>
<?php
//Authorization.
$auth->roleid="8493";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpotentialcustomers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8494";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='potentialcustomers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
