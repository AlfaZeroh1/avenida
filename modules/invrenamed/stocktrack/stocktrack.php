<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Stocktrack_class.php");
require_once("../../auth/rules/Rules_class.php");

$itemid=$_GET['itemid'];


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Stocktrack";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="728";//View
$auth->levelid=$_SESSION['level'];

$obj=(object)$_POST;
$ob = (object)$_GET;

if(!empty($ob->itemid)){
  $obj->itemid=$ob->itemid;
}

if(!empty($ob->brancheid)){
  $obj->brancheid=$ob->brancheid;
}

$class = $_GET['class'];


auth($auth);
$pop=1;
include "../../../head.php";


$rptwhere=" where inv_stocktrack.itemid='$obj->itemid' and inv_stocktrack.brancheid='$obj->brancheid' ";//echo $rptwhere;

$track=1;

if(empty($obj->action)){
  $obj->fromrecorddate=date('Y-m-d',mktime(0,0,0,date("m")-1,date("d"),date("Y")));
  $obj->torecorddate=date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")));
}
  
  if(!empty($obj->fromrecorddate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" inv_stocktrack.recorddate>='$obj->fromrecorddate'";
	$track++;
}

if(!empty($obj->torecorddate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" inv_stocktrack.recorddate<='$obj->torecorddate'";
	$track++;
}


$delid=$_GET['delid'];
$itemid=$_GET['itemid'];
$stocktrack=new Stocktrack();
if(!empty($delid)){
	$stocktrack->id=$delid;
	$stocktrack->delete($stocktrack);
	redirect("stocktrack.php");
}


//Authorization.
$auth->roleid="727";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){



?>
<!-- <div style="float:left;" class="buttons"> <input onclick="showPopWin('addstocktrack_proc.php',600,430);" value="Add Stocktrack " type="button"/></div> -->
<?php }?>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {

	//TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
	$('#example').dataTable( {
		"sScrollY": 500,
		"bJQueryUI": true,
		"iDisplayLength":20,
		"sPaginationType": "full_numbers"
	} );
} );
</script> 
<form action="stocktrack.php" method="post">
<table align='center'>
	<tr align="center">
		<td>
		<input type='hidden' name="itemid" value="<?php echo $obj->itemid; ?>"/>
		<input type='hidden' name="brancheid" value="<?php echo $obj->brancheid; ?>"/>
                 <input type='hidden' name="class" value="<?php echo $obj->class; ?>"/>		
		From: </td>
		<td><input type="text" size="12" readonly="readonly" class="date_input" name="fromrecorddate" id="fromrecorddate" value="<?php echo $obj->fromrecorddate; ?>"/></td>
		<td>To:</td> <td><input type="text" size="12" readonly="readonly" class="date_input" name="torecorddate" id="torecorddate" value="<?php echo $obj->torecorddate; ?>"/>
		<input type="hidden" name="itemid" value="<?php echo $obj->itemid; ?>"/></td>
		<td><input type="submit" class="btn" value="Filter" name="action" id="action"/></td>
	</tr>
</table>
</form>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >

	<thead>
		<tr>
			<th>#</th>
			<th>Item Name </th>
			<th>Document No. </th>
			<th>Quantity </th>
			<th>Remain </th>
			<th>Transaction </th>
			<th>Date </th>
			<th>Created By</th>
			<th>Created On</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="inv_stocktrack.id, inv_items.name itemid, auth_users.username, inv_stocktrack.tid, inv_stocktrack.documentno, inv_stocktrack.batchno, inv_stocktrack.quantity, inv_stocktrack.costprice, inv_stocktrack.value, inv_stocktrack.discount, inv_stocktrack.tradeprice, inv_stocktrack.retailprice, inv_stocktrack.applicabletax, inv_stocktrack.expirydate, inv_stocktrack.recorddate, inv_stocktrack.status, inv_stocktrack.remain, inv_stocktrack.transaction, inv_stocktrack.createdby, inv_stocktrack.createdon, inv_stocktrack.lasteditedby, inv_stocktrack.lasteditedon, inv_stocktrack.ipaddress";
		$join=" left join inv_items on inv_items.id=inv_stocktrack.itemid left join auth_users on auth_users.id=inv_stocktrack.createdby ";
		$having="";
		$groupby="";
		$orderby="";
	
		$where=$rptwhere;
		$stocktrack->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $stocktrack->sql;
		$res=$stocktrack->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->documentno; ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo $row->remain; ?></td>
			<td><?php echo $row->transaction; ?></td>
			<td><?php echo $row->recorddate; ?></td>
			<td><?php echo $row->username; ?></td>
			<td><?php echo $row->createdon; ?></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
