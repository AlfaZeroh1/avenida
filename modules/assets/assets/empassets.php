<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Assets_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Assets";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7611";//View
$auth->levelid=$_SESSION['level'];

//auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];

$assets=new Assets();

//Authorization.
$auth->roleid="7610";//View
$auth->levelid=$_SESSION['level'];
?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Asset Name </th>
			<th>Photo </th>
			<th>Purchase Date </th>
			<th>Remarks </th>
			<th>Memo </th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="assets_assets.id, assets_assets.name, assets_assets.photo, assets_assets.documentno, assets_categorys.name as categoryid, assets_assets.value, assets_assets.salvagevalue, assets_assets.purchasedon, proc_suppliers.name as supplierid, assets_assets.lpono, assets_assets.deliveryno, assets_assets.remarks, assets_assets.memo, assets_assets.ipaddress, assets_assets.createdby, assets_assets.createdon, assets_assets.lasteditedby, assets_assets.lasteditedon";
		$join=" left join assets_categorys on assets_assets.categoryid=assets_categorys.id  left join proc_suppliers on assets_assets.supplierid=proc_suppliers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where assets_assets.employeeid=(select auth_users.employeeid from auth_users where id='".$_SESSION['userid']."')";
		$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$assets->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->photo; ?></td>
			<td><?php echo formatDate($row->purchasedate); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->memo; ?></td>
			<td><a href="../reports/addreports_proc.php?id=<?php echo $row->id; ?>">Report</a>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
