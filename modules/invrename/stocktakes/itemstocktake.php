<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../inv/items/items_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Items";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4750";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$ob = (object)$_GET;

$delid=$_GET['delid'];
$items=new Items();
if(!empty($delid)){
	$items->id=$delid;
	$items->delete($items);
	redirect("items.php");
}
//Authorization.
$auth->roleid="4749";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('additems_proc.php',600,430);" value="Add Items " type="button"/></div>
<?php }?>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Category </th>
			<th>Stock Take Value</th>
			<th>Current Value</th>
			<th>Variance </th>
<?php
//Authorization.
$auth->roleid="4751";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4752";//View
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
		$fields="*";
		$join=" ";
		$having="";
		$groupby="";
		$orderby="";
		$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$items->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		//get stocktake value
		$query="select sum(dt.quantity*dt.costprice) total from inv_stocktakedetails dt left join inv_stocktakes st on dt.stocktakeid=st.id where dt.itemid='$row->id' and st.documentno='$ob->documentno'";
		$stock = mysql_fetch_object(mysql_query($query));
		
		$current = mysql_fetch_object(mysql_query("select sum(debit-credit) total from fn_generaljournals where accountid in($in)"));
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><a href="../items/items.php?categoryid=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
			<td><?php echo formatNumber($stock->total); ?></td>
			<td><?php echo formatNumber($current->total); ?></td>
			<td><?php echo formatNumber($stock->total-$current->total); ?></td>
<?php
//Authorization.
$auth->roleid="4751";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('additems_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="4752";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='items.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
