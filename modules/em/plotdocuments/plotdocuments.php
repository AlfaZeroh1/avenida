<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Plotdocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Plotdocuments";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8116";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$plotdocuments=new Plotdocuments();
if(!empty($delid)){
	$plotdocuments->id=$delid;
	$plotdocuments->delete($plotdocuments);
	redirect("plotdocuments.php");
}
//Authorization.
$auth->roleid="8115";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addplotdocuments_proc.php',600,430);" value="Add Plotdocuments " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Plot </th>
			<th>Document Type </th>
			<th>Document Name </th>
			<th>Upload Document </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8117";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8118";//View
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
		$fields="em_plotdocuments.id, em_plots.name as plotid, em_plotdocuments.documenttypeid, em_plotdocuments.name, em_plotdocuments.document, em_plotdocuments.remarks, em_plotdocuments.ipaddress, em_plotdocuments.createdby, em_plotdocuments.createdon, em_plotdocuments.lasteditedby, em_plotdocuments.lasteditedon";
		$join=" left join em_plots on em_plotdocuments.plotid=em_plots.id ";
		$having="";
		$groupby="";
		$orderby="";
		$plotdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$plotdocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->plotid; ?></td>
			<td><?php echo $row->documenttypeid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->document; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8117";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addplotdocuments_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8118";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='plotdocuments.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
