<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Departmentcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Departmentcategorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4754";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$departmentcategorys=new Departmentcategorys();
if(!empty($delid)){
	$departmentcategorys->id=$delid;
	$departmentcategorys->delete($departmentcategorys);
	redirect("departmentcategorys.php");
}
//Authorization.
$auth->roleid="4753";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('adddepartmentcategorys_proc.php',600,430);" value="Add Departmentcategorys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Department </th>
			<th>Category </th>
			<th>Remarks </th>
			<th> </th>
<?php
//Authorization.
$auth->roleid="4755";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4756";//View
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
		$fields="inv_departmentcategorys.id, inv_departments.name as departmentid, inv_departmentcategorys.name, inv_departmentcategorys.remarks, inv_departmentcategorys.createdby, inv_departmentcategorys.createdon, inv_departmentcategorys.lasteditedby, inv_departmentcategorys.lasteditedon, inv_departmentcategorys.ipaddress";
		$join=" left join inv_departments on inv_departmentcategorys.departmentid=inv_departments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$departmentcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$departmentcategorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->ipaddress; ?></td>
<?php
//Authorization.
$auth->roleid="4755";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('adddepartmentcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4756";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='departmentcategorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
