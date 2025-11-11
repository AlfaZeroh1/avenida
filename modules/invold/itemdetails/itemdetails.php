<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Itemdetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9942";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$itemdetails=new Itemdetails();
if(!empty($delid)){
	$itemdetails->id=$delid;
	$itemdetails->delete($itemdetails);
	redirect("itemdetails.php");
}
//Authorization.
$auth->roleid="9941";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('additemdetails_proc.php',600,430);" value="NEW" type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Product </th>
			<th>Solar Center </th>
			<th>Serial No </th>
			<th>Document No </th>
<!-- 			<th>Status </th> -->
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9943";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9944";//View
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
		$fields="inv_itemdetails.id, inv_items.name as itemid, sys_branches.name as brancheid, inv_itemdetails.serialno, inv_itemdetails.documentno, inv_itemdetails.status, inv_itemdetails.remarks, inv_itemdetails.ipaddress, inv_itemdetails.createdby, inv_itemdetails.createdon, inv_itemdetails.lasteditedby, inv_itemdetails.lasteditedon";
		$join=" left join inv_items on inv_itemdetails.itemid=inv_items.id  left join sys_branches on inv_itemdetails.brancheid=sys_branches.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where inv_itemdetails.status='1' ";
		if(!empty($ob->id)){
		  $where.=" and inv_itemdetails.itemid='$ob->id' ";
		}
		$itemdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$itemdetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->brancheid; ?></td>
			<td><?php echo $row->serialno; ?></td>
			<td><?php echo $row->documentno; ?></td>
<!-- 			<td><?php echo $row->status; ?></td> -->
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9943";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('additemdetails_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="9944";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="poptastic('../branchstocks/branchstocks.php?itemdetailid=<?php echo $row->id; ?>',700,1020);">Stock Card</a></td>
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
