<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Laboratorytestdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Laboratorytestdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8858";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$id=$_GET['id'];
$laboratorytestdetails=new Laboratorytestdetails();
if(!empty($delid)){
	$laboratorytestdetails->id=$delid;
	$laboratorytestdetails->delete($laboratorytestdetails);
	redirect("laboratorytestdetails.php");
}
//Authorization.
$auth->roleid="8857";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addlaboratorytestdetails_proc.php?laboratorytestid=<?php echo $id; ?>',600,430);" value="Add Laboratorytestdetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Laboratory Tests </th>
			<th>Test Detail </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8859";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8860";//Add
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
		$fields="hos_laboratorytestdetails.id, hos_laboratorytests.name as laboratorytestid, hos_laboratorytestdetails.detail, hos_laboratorytestdetails.remarks, hos_laboratorytestdetails.ipaddress, hos_laboratorytestdetails.createdby, hos_laboratorytestdetails.createdon, hos_laboratorytestdetails.lasteditedby, hos_laboratorytestdetails.lasteditedon";
		$join=" left join hos_laboratorytests on hos_laboratorytestdetails.laboratorytestid=hos_laboratorytests.id ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($id))
		  $where=" where hos_laboratorytestdetails.laboratorytestid='$id' ";
		else
		  $where="";
		  
		$laboratorytestdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$laboratorytestdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->laboratorytestid; ?></td>
			<td><?php echo $row->detail; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8859";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addlaboratorytestdetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8860";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='laboratorytestdetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
