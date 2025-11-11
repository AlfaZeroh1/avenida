<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Supplieritems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Supplieritems";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8080";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$supplieritems=new Supplieritems();
if(!empty($delid)){
	$supplieritems->id=$delid;
	$supplieritems->delete($supplieritems);
	redirect("supplieritems.php");
}
//Authorization.
$auth->roleid="8079";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addsupplieritems_proc.php',600,430);" value="Add Supplieritems " type="button"/></div>
<?php }?>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item </th>
			<th>Supplier </th>
			<th>Price </th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="8081";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="8082";//View
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
		$fields="proc_supplieritems.id, inv_items.name as itemid, proc_suppliers.name as supplierid, proc_supplieritems.price, proc_supplieritems.remarks, proc_supplieritems.ipaddress, proc_supplieritems.createdby, proc_supplieritems.createdon, proc_supplieritems.lasteditedby, proc_supplieritems.lasteditedon";
		$join=" left join inv_items on proc_supplieritems.itemid=inv_items.id  left join proc_suppliers on proc_supplieritems.supplierid=proc_suppliers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$supplieritems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$supplieritems->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo formatNumber($row->price); ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="8081";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addsupplieritems_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="8082";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='supplieritems.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
