<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returninwards_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
$types=$_GET['types'];
if(!empty($types)){
	$obj->types=$types;
}
//Redirect to horizontal layout
redirect("addreturninwards_proc.php?types=$obj->types&retrieve=".$_GET['retrieve']."&parent=".$_GET['parent']);

$page_title="Returninwards";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8656";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$returninwards=new Returninwards();
if(!empty($delid)){
	$returninwards->id=$delid;
	$returninwards->delete($returninwards);
	redirect("returninwards.php");
}
//Authorization.
$auth->roleid="8655";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a href='addreturninwards_proc.php'>New Returninwards</a></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Document No </th>
			<th>Packing No </th>
			<th>Customer </th>
			<th>Agent </th>
			<th>Remarks </th>
			<th>Sold On </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="8657";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8658";//View
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
		$fields="pos_returninwards.id, pos_returninwards.documentno, pos_returninwards.packingno, crm_customers.name as customerid, crm_agents.name as agentid, pos_returninwards.remarks, pos_returninwards.soldon, pos_returninwards.memo, pos_returninwards.createdby, pos_returninwards.createdon, pos_returninwards.lasteditedby, pos_returninwards.lasteditedon, pos_returninwards.ipaddress";
		$join=" left join crm_customers on pos_returninwards.customerid=crm_customers.id  left join crm_agents on pos_returninwards.agentid=crm_agents.id ";
		$having="";
		$groupby="";
		$orderby="";
		$returninwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$returninwards->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->packingno; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo $row->agentid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo formatDate($row->soldon); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="8657";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="addreturninwards_proc.php?id=<?php echo $row->id; ?>">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8658";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='returninwards.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
