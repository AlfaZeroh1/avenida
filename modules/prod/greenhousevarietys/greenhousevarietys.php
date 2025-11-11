<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Greenhousevarietys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Greenhousevarietys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9057";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$greenhousevarietys=new Greenhousevarietys();
if(!empty($delid)){
	$greenhousevarietys->id=$delid;
	$greenhousevarietys->delete($greenhousevarietys);
	redirect("greenhousevarietys.php");
}
//Authorization.
$auth->roleid="9056";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addgreenhousevarietys_proc.php',600,430);" value="Add Greenhousevarietys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Green House </th>
			<th>Variety </th>
			<th>Head Size </th>
			<th>Harvester </th>
			<th>Breeder </th>
			<th>Area </th>
			<th>No Of Plants </th>
			<th>Date Planted </th>
			<th>No Of Beds </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="9058";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9059";//View
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
		$fields="prod_greenhousevarietys.id, prod_greenhouses.name as greenhouseid, prod_varietys.name as varietyid, prod_greenhousevarietys.headsize, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, prod_breeders.name as breederid, prod_greenhousevarietys.area, prod_greenhousevarietys.plants, prod_greenhousevarietys.plantedon, prod_greenhousevarietys.noofbeds, prod_greenhousevarietys.remarks, prod_greenhousevarietys.ipaddress, prod_greenhousevarietys.createdby, prod_greenhousevarietys.createdon, prod_greenhousevarietys.lasteditedby, prod_greenhousevarietys.lasteditedon";
		$join=" left join prod_greenhouses on prod_greenhousevarietys.greenhouseid=prod_greenhouses.id  left join prod_varietys on prod_greenhousevarietys.varietyid=prod_varietys.id  left join hrm_employees on prod_greenhousevarietys.employeeid=hrm_employees.id  left join prod_breeders on prod_greenhousevarietys.breederid=prod_breeders.id ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($ob->id))
		  $where=" where prod_greenhouses.id='$ob->id' ";
		$greenhousevarietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $greenhousevarietys->sql;
		$res=$greenhousevarietys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->greenhouseid; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo $row->headsize; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->breederid; ?></td>
			<td><?php echo formatNumber($row->area); ?></td>
			<td><?php echo formatNumber($row->plants); ?></td>
			<td><?php echo formatDate($row->plantedon); ?></td>
			<td><?php echo formatNumber($row->noofbeds); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="../productionbudgets/productionbudgets.php?greenhousevarietyid=<?php echo $row->id; ?>">Budget</a></td>
<?php
//Authorization.
$auth->roleid="9058";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addgreenhousevarietys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9059";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='greenhousevarietys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
