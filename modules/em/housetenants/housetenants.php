<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Housetenants_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
	$tenantid=$_GET['tenantid'];
	$where=" where tenantid='$tenantid'";

$page_title="Housetenants";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4246";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$housetenants=new Housetenants();
if(!empty($delid)){
	$housetenants->id=$delid;
	$housetenants->delete($housetenants);
	redirect("housetenants.php");
}
//Authorization.
$auth->roleid="4245";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addhousetenants_proc.php?tenantid=<?php echo $tenantid; ?>',600,430);" value="Add Housetenants " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Landlord</th>
			<th>Plot</th>
			<th>House </th>
			<th>Tenant </th>
			<th>Rental Type </th>
			<th>Date Occupied </th>
			<th>Lease Starts </th>
			<th>Renew Every (Months) </th>
			<th>Lease Ends </th>
			<th>Increase Type </th>
			<th>Increase By </th>
			<th>Increase Every (Months) </th>
			<th>Rent Due Date (Every Month/quarter) </th>
			<th>Last Month Invoiced </th>
			<th>Last Year Invoiced </th>
<?php
//Authorization.
$auth->roleid="4247";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4248";//View
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
		$fields="em_housetenants.id, em_plots.name plotid, concat(em_landlords.firstname,' ',concat(em_landlords.middlename,' ',em_landlords.lastname)) landlordid, em_houses.hseno as houseid, concat(em_tenants.firstname,' ',concat(em_tenants.middlename,' ',em_tenants.lastname)) as tenantid, em_rentaltypes.name as rentaltypeid, em_housetenants.occupiedon, em_housetenants.leasestarts, em_housetenants.renewevery, em_housetenants.leaseends, em_housetenants.increasetype, em_housetenants.increaseby, em_housetenants.increaseevery, em_housetenants.rentduedate, em_housetenants.lastmonthinvoiced, em_housetenants.lastyearinvoiced";
		$join=" left join em_houses on em_housetenants.houseid=em_houses.id left join em_plots on em_plots.id=em_houses.plotid left join em_landlords on em_landlords.id=em_plots.landlordid left join em_tenants on em_housetenants.tenantid=em_tenants.id  left join em_rentaltypes on em_housetenants.rentaltypeid=em_rentaltypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$housetenants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$housetenants->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->landlordid; ?></td>
			<td><?php echo $row->plotid; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->tenantid; ?></td>
			<td><?php echo $row->rentaltypeid; ?></td>
			<td><?php echo formatDate($row->occupiedon); ?></td>
			<td><?php echo formatDate($row->leasestarts); ?></td>
			<td><?php echo $row->renewevery; ?></td>
			<td><?php echo formatDate($row->leaseends); ?></td>
			<td><?php echo $row->increasetype; ?></td>
			<td><?php echo formatNumber($row->increaseby); ?></td>
			<td><?php echo $row->increaseevery; ?></td>
			<td><?php echo $row->rentduedate; ?></td>
			<td><?php echo $row->lastmonthinvoiced; ?></td>
			<td><?php echo $row->lastyearinvoiced; ?></td>
<?php
//Authorization.
$auth->roleid="4247";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addhousetenants_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4248";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='housetenants.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
