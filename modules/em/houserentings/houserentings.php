<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Houserentings_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Houserentings";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4100";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$houserentings=new Houserentings();
if(!empty($delid)){
	$houserentings->id=$delid;
	$houserentings->delete($houserentings);
	redirect("houserentings.php");
}
//Authorization.
$auth->roleid="4099";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons">
<a class="button icon chat" onclick="showPopWin('addhouserentings_proc.php', 600, 600);"><span>ADD HOUSE RENTINGS</span></a>
</div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>House </th>
			<th>Tenant </th>
			<th>Rental Type </th>
			<th>Date Occupied </th>
			<th>Vacated On </th>
			<th>Lease Starts </th>
			<th>Renew Every (Months) </th>
			<th>Lease Ends </th>
			<th>Increase Type </th>
			<th>Increase By </th>
			<th>Increase Every (Months) </th>
			<th>Rent Due Date (Every Month/quarter) </th>
<?php
//Authorization.
$auth->roleid="4101";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4102";//<img src="../view.png" alt="view" title="view" />
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
		$fields="em_houserentings.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, concat(em_tenants.firstname,' ',concat(em_tenants.middlename,' ',em_tenants.lastname)) as tenantid, em_rentaltypes.name as rentaltypeid, em_houserentings.occupiedon, em_houserentings.vacatedon, em_houserentings.leasestarts, em_houserentings.renewevery, em_houserentings.leaseends, em_houserentings.increasetype, em_houserentings.increaseby, em_houserentings.increaseevery, em_houserentings.rentduedate";
		$join=" left join em_houses on em_houserentings.houseid=em_houses.id  left join em_tenants on em_houserentings.tenantid=em_tenants.id  left join em_rentaltypes on em_houserentings.rentaltypeid=em_rentaltypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$houserentings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$houserentings->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->houseid; ?></td>
			<td><?php echo $row->tenantid; ?></td>
			<td><?php echo $row->rentaltypeid; ?></td>
			<td><?php echo formatDate($row->occupiedon); ?></td>
			<td><?php echo formatDate($row->vacatedon); ?></td>
			<td><?php echo formatDate($row->leasestarts); ?></td>
			<td><?php echo $row->renewevery; ?></td>
			<td><?php echo formatDate($row->leaseends); ?></td>
			<td><?php echo $row->increasetype; ?></td>
			<td><?php echo formatNumber($row->increaseby); ?></td>
			<td><?php echo $row->increaseevery; ?></td>
			<td><?php echo $row->rentduedate; ?></td>
<?php
//Authorization.
$auth->roleid="4101";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addhouserentings_proc.php?id=<?php echo $row->id; ?>', 600, 600);"><img src="../view.png" alt="view" title="view" /></a></td>
<?php
}
//Authorization.
$auth->roleid="4102";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='houserentings.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src="../trash.png" alt="delete" title="delete" /></a></td>
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
