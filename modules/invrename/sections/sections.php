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
$auth->roleid="724";//View
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
$auth->roleid="723";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addsections_proc.php',600,430);" value="Add Sections " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Name </th>
			<th>Name </th>
			<th>Name </th>
<?php
//Authorization.
$auth->roleid="725";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="726";//View
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
		$fields="inv_sections.id, inv_sections.section, inv_sections.code, inv_sections.description, inv_sections.createdby, inv_sections.createdon, inv_sections.lasteditedby, inv_sections.lasteditedon, inv_sections.ipaddress";
		$join="";
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
			<td><?php echo $row->section; ?></td>
			<td><?php echo $row->code; ?></td>
			<td><?php echo $row->description; ?></td>
<?php
//Authorization.
$auth->roleid="725";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsections_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="726";//View
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
