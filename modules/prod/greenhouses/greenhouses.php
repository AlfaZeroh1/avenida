<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Greenhouses_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Greenhouses";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9019";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$greenhouses=new Greenhouses();
if(!empty($delid)){
	$greenhouses->id=$delid;
	$greenhouses->delete($greenhouses);
	redirect("greenhouses.php");
}
//Authorization.
$auth->roleid="9018";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addgreenhouses_proc.php',600,430);" value="Add Greenhouses " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Green House </th>
			<th>Section </th>
			<th>Remarks </th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="9020";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9021";//View
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
		$fields="prod_greenhouses.id, prod_greenhouses.name, concat(prod_blocks.name,' ',prod_sections.name) as sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
		$join=" left join prod_sections on prod_greenhouses.sectionid=prod_sections.id left join prod_blocks on prod_blocks.id=prod_sections.blockid";
		$having="";
		$groupby="";
		$orderby="";
		$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$greenhouses->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->sectionid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><a href="../greenhousevarietys/greenhousevarietys.php?id=<?php echo $row->id; ?>">Varieties</td>
<?php
//Authorization.
$auth->roleid="9020";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addgreenhouses_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9021";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='greenhouses.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
