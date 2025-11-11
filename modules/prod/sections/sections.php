<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Sections_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Sections";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9023";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$sections=new Sections();
if(!empty($delid)){
	$sections->id=$delid;
	$sections->delete($sections);
	redirect("sections.php");
}
//Authorization.
$auth->roleid="9022";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addsections_proc.php',600,430);" value="Add Sections " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Section </th>
			<th>Block </th>
			<th>In Charge </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9024";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9025";//View
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
		$fields="prod_sections.id, prod_sections.name, prod_blocks.name as blockid, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) as employeeid, prod_sections.remarks, prod_sections.ipaddress, prod_sections.createdby, prod_sections.createdon, prod_sections.lasteditedby, prod_sections.lasteditedon";
		$join=" left join prod_blocks on prod_sections.blockid=prod_blocks.id  left join hrm_employees on prod_sections.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$sections->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->blockid; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9024";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsections_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9025";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='sections.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
