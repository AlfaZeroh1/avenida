<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Inwards_class.php");
require_once("../../auth/rules/Rules_class.php");

$_SESSION['shpinward']=array();


if(empty($_SESSION['userid'])){
	redirect ("../../auth/users/login.php");
}
//Redirect to horizontal layout
//redirect("addinwards_proc.php?retrieve=".$_GET['retrieve']);

$page_title="Inwards";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8064";//View
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$inwards=new Inwards();
if(!empty($delid)){
	$inwards->id=$delid;
	$inwards->delete($inwards);
	redirect("inwards.php");
}
//Authorization.
$auth->roleid="8063";//View
$auth->levelid=$_SESSION['level'];

?>
<script type="text/javascript" charset="utf-8">
function checkSelected(str){
    
  if($(str).is(':checked')){
  
    $.post( "add.php", { action: "Add", documentno:str.value } );
    
  }else{
    $.post( "add.php", { action: "Remove", documentno:str.value } );
  }
 }
</script>
<form action="../../inv/purchases/addpurchases_proc.php" method="POST">
 <input type='submit' name="action3" class="btn btn-info" value="New Invoice"/>
<table style="clear:both;"  class="tgrid display" id="example" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
			<th>Inward Note No </th>
			<th>Delivery Note No </th>
			<th>Supplier </th>
			<th>Inward Date </th>
			<th>Remarks </th>
			<th>Total </th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="proc_inwards.id, proc_inwards.documentno, sum(proc_inwarddetails.total) total, proc_inwards.deliverynoteno, proc_suppliers.name as supplierid, proc_inwards.inwarddate, proc_inwards.remarks, proc_inwards.file, proc_inwards.ipaddress, proc_inwards.createdby, proc_inwards.createdon, proc_inwards.lasteditedby, proc_inwards.journals, proc_inwards.lasteditedon";
		$join=" left join proc_inwarddetails on proc_inwarddetails.inwardid=proc_inwards.id left join proc_suppliers on proc_inwards.supplierid=proc_suppliers.id ";
		$having="";
		$groupby=" group by proc_inwards.documentno ";
		$orderby=" order by proc_inwards.id desc ";
		$where=" where proc_inwarddetails.status!=1 ";
		if(!empty($ob->supplierid)){
		  if(!empty($where))
		    $where.=" and ";
		  else
		    $where.=" where ";
		  $where.=" proc_inwards.supplierid='$ob->supplierid' ";
		}
		$inwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$inwards->result;
		while($row=mysql_fetch_object($res)){
		$color="";
		if($row->journals!='Yes')
		  $color="red";
		
		$i++;
	?>
		<tr style="color:<?php echo $color; ?>">
			<td><?php echo $i; ?></td>
			<td><input type="checkbox" name="<?php echo $row->documentno; ?>" value="<?php echo $row->documentno; ?>" onClick="checkSelected(this);" /></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->deliverynoteno; ?></td>
			<td><?php echo $row->supplierid; ?></td>
			<td><?php echo formatDate($row->inwarddate); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td align="right"><?php echo formatNumber($row->total); ?></td>
			<td><a href="addinwards_proc.php?retrieve=1&documentno=<?php echo $row->documentno; ?>">View</a></td>
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
