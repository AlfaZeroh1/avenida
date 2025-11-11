<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Breederdeliverydetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Breederdeliverydetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8560";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$breederdeliverydetails=new Breederdeliverydetails();
if(!empty($delid)){
	$breederdeliverydetails->id=$delid;
	$breederdeliverydetails->delete($breederdeliverydetails);
	redirect("breederdeliverydetails.php");
}
//Authorization.
$auth->roleid="8559";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addbreederdeliverydetails_proc.php',600,430);" value="Add Breederdeliverydetails " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Breeder Delivery </th>
			<th>Variety </th>
			<th>Quantity </th>
			<th>Memo </th>
<?php
//Authorization.
$auth->roleid="8561";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8562";//View
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
		$fields="prod_breederdeliverydetails.id, prod_breederdeliverys.name as breederdeliveryid, prod_varietys.name as varietyid, prod_breederdeliverydetails.quantity, prod_breederdeliverydetails.memo, prod_breederdeliverydetails.ipaddress, prod_breederdeliverydetails.createdby, prod_breederdeliverydetails.createdon, prod_breederdeliverydetails.lasteditedby, prod_breederdeliverydetails.lasteditedon";
		$join=" left join prod_breederdeliverys on prod_breederdeliverydetails.breederdeliveryid=prod_breederdeliverys.id  left join prod_varietys on prod_breederdeliverydetails.varietyid=prod_varietys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$breederdeliverydetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$breederdeliverydetails->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->breederdeliveryid; ?></td>
			<td><?php echo $row->varietyid; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo $row->memo; ?></td>
<?php
//Authorization.
$auth->roleid="8561";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addbreederdeliverydetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8562";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='breederdeliverydetails.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
