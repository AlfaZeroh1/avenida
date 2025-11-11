<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchaseorders_class.php");
require_once("../../auth/rules/Rules_class.php");

$_SESSION['shppurchaseorder']=array();

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
//redirect("addpurchaseorders_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Purchaseorders";
//connect to db
$db=new DB();

$ob = (object)$_GET;

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

<script type="text/javascript" charset="utf-8">
function checkSelected(str){
    
  if($(str).is(':checked')){
  
    $.post( "add.php", { action: "Add", documentno:str.value } );
    
  }else{
    $.post( "add.php", { action: "Remove", documentno:str.value } );
  }
 }
</script>

<div style="clear:both;"></div>
<form action="../../proc/inwards/addinwards_proc.php" method="POST">
 <input type='submit' name="action3" class="btn btn-info" value="New Inward"/>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>LPO No. </th>
			<th>Requisition No </th>
			<th>Supplier </th>
			<th>Currency </th>
			<th>Remarks </th>
			<th>Order On </th>
			<th>Browse File </th>
			<th>&nbsp;</th>
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
		$fields="proc_purchaseorders.id, sys_currencys.name currencyid, con_projects.name as projectid, proc_purchaseorders.documentno, proc_purchaseorders.requisitionno, proc_suppliers.name as supplierid, proc_purchaseorders.remarks, proc_purchaseorders.orderedon, proc_purchaseorders.file, proc_purchaseorders.createdby, proc_purchaseorders.createdon, proc_purchaseorders.lasteditedby, proc_purchaseorders.lasteditedon, proc_purchaseorders.ipaddress";
		$join=" left join con_projects on proc_purchaseorders.projectid=con_projects.id  left join proc_suppliers on proc_purchaseorders.supplierid=proc_suppliers.id left join sys_currencys on sys_currencys.id=proc_purchaseorders.currencyid ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where 1=1 ";
		if(!empty($ob->supplierid)){
		  $where.=" and proc_suppliers.id='$ob->supplierid'";
		}
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
			<td><input type="checkbox" name="<?php echo $row->documentno; ?>" value="<?php echo $row->documentno; ?>" onClick="checkSelected(this);" /></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->requisitionno; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo $row->currencyid; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo formatDate($row->orderedon); ?></td>
			<td><?php echo $row->file; ?></td>
			<td><a href="addpurchaseorders_proc.php?retrieve=1&action=Filter&invoiceno=<?php echo $row->documentno; ?>&inward=<?php echo $ob->inward; ?>">View</a></td>
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
</form>
<?php
include"../../../foot.php";
?>
