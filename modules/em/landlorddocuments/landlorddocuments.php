<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Landlorddocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Landlorddocuments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8108";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$landlorddocuments=new Landlorddocuments();
if(!empty($delid)){
	$landlorddocuments->id=$delid;
	$landlorddocuments->delete($landlorddocuments);
	redirect("landlorddocuments.php");
}
//Authorization.
$auth->roleid="8107";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addlandlorddocuments_proc.php',600,430);" value="Add Landlorddocuments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Landlord </th>
			<th>Document Type </th>
			<th>Document Name </th>
			<th>Upload Document </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8109";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8110";//View
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
		$fields="em_landlorddocuments.id, em_landlords.name as landlordid, em_landlorddocuments.documenttypeid, em_landlorddocuments.name, em_landlorddocuments.document, em_landlorddocuments.remarks, em_landlorddocuments.ipaddress, em_landlorddocuments.createdby, em_landlorddocuments.createdon, em_landlorddocuments.lasteditedby, em_landlorddocuments.lasteditedon";
		$join=" left join em_landlords on em_landlorddocuments.landlordid=em_landlords.id ";
		$having="";
		$groupby="";
		$orderby="";
		$landlorddocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$landlorddocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->landlordid; ?></td>
			<td><?php echo $row->documenttypeid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->document; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8109";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addlandlorddocuments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8110";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='landlorddocuments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
