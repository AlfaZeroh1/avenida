<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../con/projects/Projects_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Projects";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7579";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$projects=new Projects();
if(!empty($delid)){
	$projects->id=$delid;
	$projects->delete($projects);
	redirect("projects.php");
}
//Authorization.
$auth->roleid="7578";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addprojects_proc.php'>New Projects</a></div>
<?php }?>
<table style="clear:both;"  class="table table-condensed table-striped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Project Name </th>
			<th>Project Type </th>
			<th>Customer </th>
			<th>Manager </th>
			<th>Remarks </th>
			<th>Status </th>
			<th>Items</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="con_projects.id, con_projects.name, con_projecttypes.name as projecttypeid, crm_customers.name as customerid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, con_regions.name as regionid, con_subregions.name as subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_statuss.name as statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
		$join=" left join con_projecttypes on con_projects.projecttypeid=con_projecttypes.id  left join crm_customers on con_projects.customerid=crm_customers.id  left join hrm_employees on con_projects.employeeid=hrm_employees.id  left join con_regions on con_projects.regionid=con_regions.id  left join con_subregions on con_projects.subregionid=con_subregions.id  left join con_statuss on con_projects.statusid=con_statuss.id ";
		$having="";
		$groupby="";
		$orderby="";
		$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$projects->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->projecttypeid; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->statusid; ?></td>
			<td><a href="../projectstocks/projectstocks.php?projectid=<?php echo $row->id; ?>">Items</td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
