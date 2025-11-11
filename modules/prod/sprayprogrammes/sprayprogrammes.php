<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sprayprogrammes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Sprayprogrammes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8720";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$sprayprogrammes=new Sprayprogrammes();
if(!empty($delid)){
	$sprayprogrammes->id=$delid;
	$sprayprogrammes->delete($sprayprogrammes);
	redirect("sprayprogrammes.php");
}
//Authorization.
$auth->roleid="8719";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addsprayprogrammes_proc.php',600,430);" value="Add sprayprogrammes " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>GreenHouse</th>
			<th>Variety </th>
			<th>Chemical </th>
			<th>Ingredients </th>
			<th>Chemical Quantity </th>
			<th>Volume Of Water Used </th>
<!-- 			<th>Green House </th> -->
			<th>Nozzle Used </th>
			<th>Target Pests & Diseases </th>
			<th>Spray Method </th>
			<th>Spray Date </th>
			<th>Spray Time </th>
			<th>REmarks </th>
<?php
//Authorization.
$auth->roleid="8721";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8722";//View
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
		$fields="prod_sprayprogrammes.id, prod_areas.name as areaid, prod_varietys.name as varietyid, prod_chemicals.name as chemicalid, prod_sprayprogrammes.ingredients, prod_sprayprogrammes.quantity, prod_sprayprogrammes.watervol, prod_greenhouses.name as greenhouseid, prod_nozzles.name as nozzleid, prod_sprayprogrammes.target, prod_spraymethods.name as spraymethodid, prod_sprayprogrammes.spraydate, prod_sprayprogrammes.time, prod_sprayprogrammes.remarks, prod_sprayprogrammes.ipaddress, prod_sprayprogrammes.createdby, prod_sprayprogrammes.createdon, prod_sprayprogrammes.lasteditedby, prod_sprayprogrammes.lasteditedon";
		$join=" left join prod_areas on prod_sprayprogrammes.areaid=prod_areas.id  left join prod_varietys on prod_sprayprogrammes.varietyid=prod_varietys.id  left join prod_chemicals on prod_sprayprogrammes.chemicalid=prod_chemicals.id  left join prod_greenhouses on prod_sprayprogrammes.greenhouseid=prod_greenhouses.id  left join prod_nozzles on prod_sprayprogrammes.nozzleid=prod_nozzles.id  left join prod_spraymethods on prod_sprayprogrammes.spraymethodid=prod_spraymethods.id ";
		$having="";
		$groupby="";
		$orderby=" order by prod_sprayprogrammes.createdon desc ";
		$sprayprogrammes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$sprayprogrammes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->greenhouseid; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo $row->chemicalid; ?></td>
			<td><?php echo $row->ingredients; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->watervol); ?></td>
<!-- 			<td><?php echo $row->greenhouseid; ?></td> -->
			<td><?php echo $row->nozzleid; ?></td>
			<td><?php echo $row->target; ?></td>
			<td><?php echo $row->spraymethodid; ?></td>
			<td><?php echo formatDate($row->spraydate); ?></td>
			<td><?php echo $row->time; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8721";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsprayprogrammes_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8722";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='sprayprogrammes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
