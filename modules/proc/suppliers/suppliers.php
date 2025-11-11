<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Suppliers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Suppliers";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8084";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$suppliers=new Suppliers();
if(!empty($delid)){
	$suppliers->id=$delid;
	$suppliers->delete($suppliers);
	redirect("suppliers.php");
}
//Authorization.
$auth->roleid="8083";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div class="container">
<hr>
<a class="btn btn-info" onclick="showPopWin('addsuppliers_proc.php',600,430);">Add Suppliers</a>
<?php }?>
<hr>
<table style="clear:both;"  class="table table-codensed table-stripped" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Code </th>
			<th>Name </th>
			<th>Supplier Category </th>
			<th>Currency</th>
			<th>Region </th>
			<th>Phone No. </th>
			<th>Pin No. </th>
			<th>Vat No. </th>
			<th>Etr No. </th>
			<th>E-mail </th>
			<th>Cell-Phone </th>
			<th>Status</th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="8085";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8086";//View
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
		$fields="proc_suppliers.id, proc_suppliers.code, sys_currencys.name currencyid, proc_suppliers.name, proc_suppliercategorys.name as suppliercategoryid, sys_regions.name as regionid, sys_subregions.name as subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel,proc_suppliers.pinno,proc_suppliers.vatno,proc_suppliers.etrno, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
		$join=" left join proc_suppliercategorys on proc_suppliers.suppliercategoryid=proc_suppliercategorys.id  left join sys_regions on proc_suppliers.regionid=sys_regions.id  left join sys_subregions on proc_suppliers.subregionid=sys_subregions.id left join sys_currencys on sys_currencys.id=proc_suppliers.currencyid ";
		$having="";
		$groupby="";
		if(!empty($ob->suppliercategoryid))
		  $where=" where proc_suppliers.suppliercategoryid='$ob->suppliercategoryid' ";
		$orderby="";
		$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$suppliers->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->suppliercategoryid; ?></td>
			<td><?php echo $row->currencyid; ?></td>
			<td><?php echo $row->regionid; ?></td>
			<td><?php echo $row->tel; ?></td>
			<td><?php echo $row->pinno; ?></td>
			<td><?php echo $row->vatno; ?></td>
			<td><?php echo $row->etrno; ?></td>
			<td><?php echo $row->email; ?></td>
			<td><?php echo $row->cellphone; ?></td>
			<td><?php echo $row->status; ?></td>
			<td><a href="javascript:;" onclick="showPopWin('addsuppliers_proc.php?id=<?php echo $row->id; ?>&merge=1',600,430);">Merge</a></td>
<?php
//Authorization.
$auth->roleid="8085";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsuppliers_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8086";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='suppliers.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
