<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Orders_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../confirmedorders/Confirmedorders_class.php");
require_once("../../inv/branchstocks/Branchstocks_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}
//Redirect to horizontal layout
//redirect("addorders_proc.php?retrieve=".$_GET['retrieve']);

unset($_SESSION['shpordernos']);

$page_title="Orders";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="8664";//View
$auth->levelid=$_SESSION['level'];

$obj = (object)$_POST;
$ob = (object)$_GET;

if(!empty($ob->orderno))
    $obj->orderno=$ob->orderno;

if(!empty($ob->employeeid))
  $obj->employeeid=$ob->employeeid;
  
if(!empty($ob->brancheid2))
  $obj->brancheid2=$ob->brancheid2;

if(!empty($ob->cancelid)){
  $userid = $_SESSION['userid'];
  $last = date("Y-m-d H:i:s");
  
  $query="update pos_orderdetails set status=3, lasteditedby=$userid, lasteditedon='$last' where id='$ob->cancelid'";//echo $query;
  mysql_query($query);
    
  $query="select pd.*, p.brancheid from pos_orderdetails pd left join pos_orders p on p.id=pd.orderid where pd.id='$ob->cancelid'";//echo $query;
  $res=mysql_query($query);
  while($row=mysql_fetch_object($res)){  
    
    $branchstockss = new Branchstocks();
    $fields="*";
    $where=" where itemid='$row->itemid' and brancheid='$row->brancheid' ";
    $join="";
    $having="";
    $groupby="";
    $orderby="";
    $branchstockss->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  
    $branchstocks = new Branchstocks();
    $branchstocks->brancheid=$obj->brancheid;
    $branchstocks->itemid=$obj->itemid;
    $branchstocks->itemdetailid=$obj->itemdetailid;
    $branchstocks->documentno=$obj->documentno;
    $branchstocks->recorddate=$obj->transferedon;
//     $branchstocks->quantity=$obj->quantity;
    $branchstocks->transactionid=$transaction->id;
    
    if($branchstockss->affectedRows>0){
      $branchstockss = $branchstockss->fetchObject;
      
      $branchstockss->quantity+=$row->quantity;
      $branchstocks->edit($branchstockss);
      
    }else{
      $branchstocks->quantity=$row->quantity;
      $branchstocks->add($branchstocks);
    }
  }
}

auth($auth);
$pop=$ob->pop;
include"../../../head.php";

$delid=$_GET['delid'];
$orders=new Orders();
if(!empty($delid)){
	$orders->id=$delid;
	$orders->delete($orders);
	redirect("orders.php");
}
//Authorization.
$auth->roleid="8663";//View
$auth->levelid=$_SESSION['level'];

?>

<script type="text/javascript">
function Clickheretoprint(vat,action)
{ 
	$.post("addorders_proc.php",{action:action,type:1, combined:1,vat:vat},function(data){
	
	  location.replace("orderss.php");
	
	});
}

function setOrder(orderno){
  var checked;
  checked=$("#"+orderno).is(':checked');
  $.post("setorder.php",{orderno:orderno,checked:checked});
}
</script>
<style type="text/css">

.green{
  background-image: -webkit-gradient(linear, left 0%, left 100%, from(#ffffff), to(#33CC33));
  background-image: -webkit-linear-gradient(top, #ffffff, 0%, #33CC33, 100%);
  background-image: -moz-linear-gradient(top, #ffffff 0%, #33CC33 100%);
  background-image: linear-gradient(to bottom, #ffffff 0%, #33CC33 100%);
}

.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
  background-color:;
}
</style>

<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Product</th>
			<th>Qnt</th>
			<th>Price</th>
			<th>Total</th>
			<th>&nbsp;</th>
						
		</tr>
	</thead>
	<tbody>
	<?php
	
		$i=0;
		$where=" where pos_orders.status!=3 and pos_orders.shiftid in($obj->shiftid)";
		$where=" where 1=1 ";
		
		$fields="pos_orderdetails.id, pos_orders.orderno orderno, pos_orders.billno, pos_orders.shiftid, crm_customers.name as customerid, pos_orders.orderedon, pos_orders.remarks, pos_orders.ipaddress, pos_orders.createdby, pos_orders.createdon, pos_orders.lasteditedby, pos_orders.lasteditedon, (pos_orderdetails.quantity*pos_orderdetails.price) total, concat(hrm_employees.pfnum, ' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) username, sys_branches.name branchename, pos_orders.status, (pos_orders.tableno), sys_branchess.name brancheid2, pos_orders.billno, auth_users.employeeid, inv_items.name itemname, pos_orderdetails.quantity, pos_orderdetails.price, pos_orderdetails.status ";
		
		$join=" left join crm_customers on pos_orders.customerid=crm_customers.id left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join auth_users on auth_users.id=pos_orders.lasteditedby left join sys_branches on sys_branches.id=pos_orders.brancheid left join sys_branches sys_branchess on sys_branchess.id=pos_orders.brancheid2 left join hrm_employees on hrm_employees.id=auth_users.employeeid left join inv_items on inv_items.id=pos_orderdetails.itemid ";
		
		$having="";
		$groupby="  ";
		$orderby=" order by pos_orders.id desc ";
		if(!empty($obj->orderno)){
		  $where.=" and pos_orders.orderno='$obj->orderno'";
		}
		
		$orders->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $orders->sql;
		$res=$orders->result;
		$total=0;
		
		while($row=mysql_fetch_object($res)){
		
		$total+=$row->total;
		
		$i++;
		
	?>
		<tr style="color:<?php echo $color; ?>">
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemname; ?></td>
			<td><?php echo ($row->quantity); ?></td>
			<td><?php echo formatNumber($row->price); ?></td>
			<td><?php echo formatNumber($row->total); ?></td>
			<td>
			<?php
			
			if($row->status==3){
                echo "VOIDED";
            }else{
			
                //Authorization.
                $auth->roleid="8666";//View
                $auth->levelid=$_SESSION['level'];

                if(existsRule($auth)){
                ?>
                    <a href="orderss.php?cancelid=<?php echo $row->id; ?>&orderno=<?php echo $row->orderno; ?>&pop=1">VOID</a> 
                <?php 
                }
                
			}
			?>
			</td>
		</tr>
	<?php 
	}
	?>
	</tbody>
	
	<tfoot>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
	
</table>
<?php
include"../../../foot.php";
?>
