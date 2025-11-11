<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Customerconsignees_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Customerconsignees";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9365";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$customerconsignees=new Customerconsignees();
if(!empty($delid)){
	$customerconsignees->id=$delid;
	$customerconsignees->delete($customerconsignees);
	redirect("customerconsignees.php");
}
//Authorization.
$auth->roleid="9364";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcustomerconsignees_proc.php',600,430);" value="Add Customerconsignees " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Customer </th>
			<th>Name </th>
			<th>Address </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="9366";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9367";//Add
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
		$fields="crm_customerconsignees.id, crm_customers.name as customerid, crm_customerconsignees.name, crm_customerconsignees.address, crm_customerconsignees.remarks, crm_customerconsignees.ipaddress, crm_customerconsignees.createdby, crm_customerconsignees.createdon, crm_customerconsignees.lasteditedby, crm_customerconsignees.lasteditedon";
		$join=" left join crm_customers on crm_customerconsignees.customerid=crm_customers.id ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($ob->customerid)){
		  $where=" where id='$ob->customerid' ";
		}
		$customerconsignees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$customerconsignees->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->customerid; ?></td>
			<td><?php echo $row->name; ?></td>
			<td><?php echo $row->address; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="9366";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcustomerconsignees_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="9367";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='customerconsignees.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
