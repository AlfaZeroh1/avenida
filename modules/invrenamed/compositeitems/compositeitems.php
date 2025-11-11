<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Compositeitems_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../inv/items/Items_class.php");
// require_once("../../pos/paymentplans/Paymentplans_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Compositeitems";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9947";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;
$obj=(object)$_POST;

if(!empty($ob->itemid))
  $obj->itemid=$ob->itemid;

auth($auth);

$pop=1;
include"../../../head.php";

$delid=$_GET['delid'];
$compositeitems=new Compositeitems();
if(!empty($delid)){
	$compositeitems->id=$delid;
	$compositeitems->delete($compositeitems);
	redirect("compositeitems.php");
}
//Authorization.
$auth->roleid="9946";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addcompositeitems_proc.php?itemid=<?php echo $ob->itemid; ?>',600,430);" value="NEW" type="button"/></div>
<?php }?>

<script type="text/javascript">
// $().ready(function() {
  function calculateTotal(){
    var balance;
    var totalinterest;
    var totalreceivables;
    var permonth;
    var cashprice;
    var discount;
    var deposit;
    var interest;
    var installment;
    var total;
    
    total=$("#total").val();
    discount=$("#discount").val();
    cashprice=total*(100-discount)/100;
    cashprice=Math.round(cashprice / 10) * 10;
    deposit=$("#deposit").val();
    balance = cashprice-deposit;
    installment=$("#installment").val();
    interest=$("#interest").val();
    totalinterest=balance*installment*interest/100;
    totalinterest = Math.round(totalinterest / 10) * 10;
    totalreceivables=balance+totalinterest;
    permonth=totalreceivables/installment;
    
    $("#cashprice").val(cashprice);
    $("#balance").val(balance);
    $("#totalinterest").val(totalinterest);
    $("#totalreceivables").val(totalreceivables);
    $("#permonth").val(permonth);
  }
// });
</script>

<table style="clear:both;" width="100%" class="table display" >
	<thead>
		<tr>
			<th>#</th>
			<th>Product </th>
			<th>Constituent Product </th>
			<th>Branch </th>
			<th>Quantity </th>
<?php
//Authorization.
$auth->roleid="9948";//Add
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="9949";//Add
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
		$fields="inv_compositeitems.id, inv_items.name as itemid, inv_compositeitems.quantity, inv_items2.name itemid2, sys_branches.name branch";
		$join=" left join inv_items on inv_compositeitems.itemid=inv_items.id left join inv_items inv_items2 on inv_compositeitems.itemid2=inv_items2.id left join sys_branches on sys_branches.id=inv_compositeitems.brancheid ";
		$having="";
		$groupby="";
		$orderby="";
		$where="";
		if(!empty($obj->itemid)){
		  $where=" where inv_items.id='$obj->itemid' ";
		}
		$compositeitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $compositeitems->sql;
		$res=$compositeitems->result;
		$total=0;
		
		while($row=mysql_fetch_object($res)){
		$i++;
		$total=$row->cashretail*$row->quantity;
		$ttotal+=$total;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->itemid2; ?></td>
			<td><?php echo $row->branch; ?></td>
			<td><?php echo $row->quantity; ?></td>
<?php
//Authorization.
$auth->roleid="9948";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addcompositeitems_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="9949";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='compositeitems.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
