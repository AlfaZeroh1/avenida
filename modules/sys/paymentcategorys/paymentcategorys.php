<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Paymentcategorys";
//connect to db
$db=new DB();

$ob = (object)$_GET;

//Authorization.
$auth->roleid="9499";//Add
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$paymentcategorys=new Paymentcategorys();
if(!empty($delid)){
	$paymentcategorys->id=$delid;
	$paymentcategorys->delete($paymentcategorys);
	redirect("paymentcategorys.php");
}
//Authorization.
$auth->roleid="9498";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input  class="btn btn-info"  onclick="showPopWin('addpaymentcategorys_proc.php',600,430);" value="Add Paymentcategorys " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Payment Mode </th>
			<th>Category Name </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9500";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9501";//Add
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
		$fields="sys_paymentcategorys.id, sys_paymentmodes.name as paymentmodeid, sys_paymentcategorys.name, sys_paymentcategorys.remarks, sys_paymentcategorys.ipaddress, sys_paymentcategorys.createdby, sys_paymentcategorys.createdon, sys_paymentcategorys.lasteditedby, sys_paymentcategorys.lasteditedon";
		$join=" left join sys_paymentmodes on sys_paymentcategorys.paymentmodeid=sys_paymentmodes.id ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($ob->paymentmodeid)){
		  $where=" where sys_paymentcategorys.paymentmodeid='$ob->paymentmodeid'";
		}
		$paymentcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$paymentcategorys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->paymentmodeid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9500";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addpaymentcategorys_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9501";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='paymentcategorys.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
