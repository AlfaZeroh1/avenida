<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deliverynotes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
redirect("adddeliverynotes_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Deliverynotes";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8060";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$deliverynotes=new Deliverynotes();
if(!empty($delid)){
	$deliverynotes->id=$delid;
	$deliverynotes->delete($deliverynotes);
	redirect("deliverynotes.php");
}
//Authorization.
$auth->roleid="8059";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='adddeliverynotes_proc.php'>New Deliverynotes</a></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Delivery Note </th>
			<th>LPO Number </th>
<!-- 			<th>Project </th> -->
			<th>Supplier </th>
			<th>Delivery Date </th>
			<th>Remarks </th>
			<th>Browse File </th>
<?php
//Authorization.
$auth->roleid="8061";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8062";//View
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
		$fields="proc_deliverynotes.id, proc_deliverynotes.documentno, proc_deliverynotes.lpono, con_projects.name as projectid, proc_suppliers.name as supplierid, proc_deliverynotes.deliveredon, proc_deliverynotes.remarks, proc_deliverynotes.file, proc_deliverynotes.ipaddress, proc_deliverynotes.createdby, proc_deliverynotes.createdon, proc_deliverynotes.lasteditedby, proc_deliverynotes.lasteditedon";
		$join=" left join con_projects on proc_deliverynotes.projectid=con_projects.id  left join proc_suppliers on proc_deliverynotes.supplierid=proc_suppliers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$deliverynotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$deliverynotes->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->lpono; ?></td>
<!-- 			<td><?php echo $row->projectid; ?></td> -->
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo formatDate($row->deliveredon); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->file; ?></td>
<?php
//Authorization.
$auth->roleid="8061";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="adddeliverynotes_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8062";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='deliverynotes.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
