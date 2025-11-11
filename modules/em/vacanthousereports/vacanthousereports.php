<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Vacanthousereports_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Vacanthousereports";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4807";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$vacanthousereports=new Vacanthousereports();
if(!empty($delid)){
	$vacanthousereports->id=$delid;
	$vacanthousereports->delete($vacanthousereports);
	redirect("vacanthousereports.php");
}
//Authorization.
$auth->roleid="4806";//View
$auth->levelid=$_SESSION['level'];

?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>House </th>
			<th>Vacated On </th>
			<th>Remarks </th>
			<th>Remark Upon Approval/Decline </th>
			<th>Posted By</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="em_vacanthousereports.id, em_houses.hsecode as houseid,em_houses.hseno,em_plots.name plotid, concat(concat(concat(em_landlords.llcode,' ',em_landlords.firstname),' ',em_landlords.middlename),' ',em_landlords.lastname) landlordid, em_vacanthousereports.vacatedon, em_vacanthousereports.remarks, em_vacanthousereports.remarks2, em_vacanthousereports.status, auth_users.username, em_vacanthousereports.createdon, em_vacanthousereports.lasteditedby, em_vacanthousereports.lasteditedon";
		$join=" left join em_houses on em_vacanthousereports.houseid=em_houses.id left join em_plots on em_plots.id=em_houses.plotid left join em_landlords on em_landlords.id=em_plots.landlordid left join auth_users on auth_users.id=em_vacanthousereports.createdby ";
		$having="";
		$groupby="";
		$orderby="";
		$vacanthousereports->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$res=$vacanthousereports->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><strong>Landlord</strong>: <?php echo $row->landlordid; ?>&nbsp;<strong>Plot</strong>: <?php echo $row->plotid; ?>&nbsp;<strong>Hse Code</strong>: <?php echo $row->houseid; ?>&nbsp;<strong>Hse No</strong>: <?php echo $row->hseno; ?></td>
			<td><?php echo formatDate($row->vacatedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->remarks2; ?></td>
			<td><?php echo $row->username; ?></td>
			<td><a href="javascript:;" onclick="showPopWin('addvacanthousereports_proc.php?id=<?php echo $row->id; ?>',600,430);">Approve</a></td>
			<td><a href='vacanthousereports.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Decline</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
