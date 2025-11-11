<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchaseorders_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
//redirect("addpurchaseorders_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Purchaseorders";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8068";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$purchaseorders=new Purchaseorders();
if(!empty($delid)){
	$purchaseorders->id=$delid;
	$purchaseorders->delete($purchaseorders);
	redirect("purchaseorders.php");
}
//Authorization.
$auth->roleid="8067";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <a class="btn btn-info" href='addpurchaseorders_proc.php'>New Purchaseorders</a> -->
<?php }?>
<div style="clear:both;"></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Supplier </th>
<?php
//Authorization.
$auth->roleid="8069";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<th>&nbsp;</th> -->
<?php
}
//Authorization.
$auth->roleid="8070";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<th>&nbsp;</th> -->
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields=" distinct proc_suppliers.name as supplierid, proc_suppliers.id supplier";
		$join=" left join proc_suppliers on proc_purchaseorders.supplierid=proc_suppliers.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="  ";
		$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$purchaseorders->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
// 		$po = new Purchaseorders();
// 		$po->documentno=$row->documentno;
// 		$po->requisitionno=$row->requisitionno;
// 		$pos = $po->checkReceived($po);
// 		if($pos==1){
// 		  continue;
// 		}
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="purchaseorder.php?supplierid=<?php echo $row->supplier; ?>"><?php echo $row->supplierid; ?></a></td>
<?php
//Authorization.
$auth->roleid="8069";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<td><a href="addpurchaseorders_proc.php?id=<?php echo $row->id; ?>">View</a></td> -->
<?php
}
//Authorization.
$auth->roleid="8070";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- 			<td><a href='purchaseorders.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td> -->
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
