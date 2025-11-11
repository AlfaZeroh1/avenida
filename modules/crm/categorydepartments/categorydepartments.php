<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Categorydepartments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Categorydepartments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4783";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$categorydepartments=new Categorydepartments();
if(!empty($delid)){
	$categorydepartments->id=$delid;
	$categorydepartments->delete($categorydepartments);
	redirect("categorydepartments.php");
}
//Authorization.
$auth->roleid="4782";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcategorydepartments_proc.php',600,430);" value="Add Categorydepartments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Department Category </th>
			<th>Department </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="4784";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4785";//Add
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
		$fields="crm_categorydepartments.id, crm_categorydepartments.name, crm_departments.name as departmentid, crm_categorydepartments.remarks, crm_categorydepartments.createdby, crm_categorydepartments.createdon, crm_categorydepartments.lasteditedby, crm_categorydepartments.lasteditedon";
		$join=" left join crm_departments on crm_categorydepartments.departmentid=crm_departments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$categorydepartments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$categorydepartments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->departmentid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="4784";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcategorydepartments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4785";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='categorydepartments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
