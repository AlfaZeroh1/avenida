<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Categorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Categorys";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4012";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$categorys=new Categorys();
if(!empty($delid)){
	$categorys->id=$delid;
	$categorys->delete($categorys);
	redirect("categorys.php");
}
//Authorization.
$auth->roleid="4011";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info" onclick="showPopWin('addcategorys_proc.php',600,430);" value="Add Categorys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Category </th>
			<th>Department</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4013";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4014";//View
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
		$fields="pos_categorys.id, pos_categorys.name, pos_departments.name as departmentid, pos_categorys.remarks, pos_categorys.ipaddress, pos_categorys.createdby, pos_categorys.createdon, pos_categorys.lasteditedby, pos_categorys.lasteditedon";
		$join=" left join pos_departments on pos_categorys.departmentid=pos_departments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$categorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo strtoupper($row->name); ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4013";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4014";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='categorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
