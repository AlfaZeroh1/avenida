<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemstocks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Itemstocks";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8692";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

auth($auth);
include"../../../headerpop.php";




$obj=(object)$_POST;
$ob = (object)$_GET;

if(!empty($ob->itemid)){
  $obj->itemid=$ob->itemid;
}
$class = $_GET['class'];


auth($auth);
include"../../../rptheader.php";


$rptwhere=" where inv_stocktrack.itemid='$obj->itemid' ";

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
$itemstocks=new Itemstocks();
if(!empty($delid)){
	$itemstocks->id=$delid;
	$itemstocks->delete($itemstocks);
	redirect("itemstocks.php");
}
//Authorization.
$auth->roleid="8691";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>

<?php }?>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {

 	$('#example').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
		"bJQueryUI": true,
		"iDisplayLength":20,
		"sPaginationType": "full_numbers"
	} );
} );
</script> 

<form action="itemstocks.php" method="post">
<table align='center'>
	<tr align="center">
		<td>
		<input type='hidden' name="itemid" value="<?php echo $obj->itemid; ?>"/>
                 <input type='hidden' name="class" value="<?php echo $obj->class; ?>"/>
		
		From: <input type="text" size="12" readonly="readonly" class="date_input" name="fromrecorddate" id="fromrecorddate" value="<?php echo $obj->fromrecorddate; ?>"/>
										&nbsp;To: <input type="text" size="12" readonly="readonly" class="date_input" name="torecorddate" id="torecorddate" value="<?php echo $obj->torecorddate; ?>"/>
										<input type="hidden" name="itemid" value="<?php echo $obj->itemid; ?>"/>
										<input  class="btn btn-info" type="submit" class="btn" value="Filter" name="action" id="action"/>
	</tr>
</table>
</form>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<!--<th>Document No </th>-->
			<th>Product </th>
			<th>Length </th>
			<!--<th>Customer </th>-->
			<th>Action </th>
			<th>Quantity </th>
			<th>Remain </th>
			<th>Date Recorded </th>
			<th>Date Of Action </th>
			<th>Username </th>
<?php
//Authorization.
$auth->roleid="8693";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<!--<th>&nbsp;</th>-->
<?php
}
//Authorization.
$auth->roleid="8694";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<!--<th>&nbsp;</th>-->
<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$fields="pos_itemstocks.id, pos_itemstocks.documentno, pos_items.name as itemid, pos_sizes.name sizeid, crm_customers.name as customerid, pos_itemstocks.transaction, pos_itemstocks.quantity, pos_itemstocks.remain, pos_itemstocks.recordedon, pos_itemstocks.actedon, pos_itemstocks.ipaddress, pos_itemstocks.createdby, pos_itemstocks.createdon, pos_itemstocks.lasteditedby, pos_itemstocks.lasteditedon";
		$join=" left join pos_items on pos_itemstocks.itemid=pos_items.id  left join crm_customers on pos_itemstocks.customerid=crm_customers.id left join pos_sizes on pos_itemstocks.sizeid=pos_sizes.id ";
		$having="";
		$groupby="";
		$orderby="";
		if(!empty($ob->itemid))
		  $where=" where pos_items.id='$ob->itemid' ";
		$itemstocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$itemstocks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<!--<td><?php echo $row->documentno; ?></td>-->
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->sizeid; ?></td>
			<!--<td><?php echo $row->customerid; ?></td>-->
			<td><?php echo $row->transaction; ?></td>
			<td><?php echo formatNumber($row->quantity); ?></td>
			<td><?php echo formatNumber($row->remain); ?></td>
			<td><?php echo formatDate($row->recordedon); ?></td>
			<td><?php echo formatDate($row->actedon); ?></td>
			<td><?php echo $row->username; ?></td>
<?php
//Authorization.
$auth->roleid="8693";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<!--<td><a href="javascript:;" onclick="showPopWin('additemstocks_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>-->
<?php
}
//Authorization.
$auth->roleid="8694";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<!--<td><a href='itemstocks.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>-->
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
