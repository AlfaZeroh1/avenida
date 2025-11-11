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

if(!empty($ob->tableno)){
  $obj->orderedon=$ob->orderedon;
  $obj->tableno=$ob->tableno;
  $obj->createdby=$ob->createdby;
}

if(!empty($ob->shiftid)){
  $obj->shiftid=$ob->shiftid;
}else{
  $query="select group_concat(id) id from pos_teams where status=0";
  $rw = mysql_fetch_object(mysql_query($query));
  $obj->shiftid=$rw->id;
  
}

if(!empty($ob->employeeid))
  $obj->employeeid=$ob->employeeid;
  
if(!empty($ob->brancheid2))
  $obj->brancheid2=$ob->brancheid2;

if(!empty($ob->cancelid)){
  $userid = $_SESSION['userid'];
  $last = date("Y-m-d H:i:s");
  
  $query="update pos_orders set status=3, lasteditedby=$userid, lasteditedon='$last' where id='$ob->cancelid'";
  mysql_query($query);
    
  $query="select pd.*, p.brancheid from pos_orderdetails pd left join pos_orders p on p.id=pd.orderid where pd.orderid='$ob->cancelid'";
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

$query="select pos_teams.id, sys_branches.id brancheid, sys_branches.name branchename, pos_teamroles.type teamroletype from pos_shifts left join pos_teams on pos_teams.shiftid=pos_shifts.id left join pos_teamdetails on pos_teamdetails.teamid=pos_teams.id left join sys_branches on sys_branches.id=pos_teams.brancheid left join pos_teamroles on pos_teamroles.id=pos_teamdetails.teamroleid where pos_teams.status=0 and pos_teamdetails.employeeid='".$_SESSION['employeeid']."'";
$rs = mysql_query($query);
if(mysql_affected_rows()>0){
  $rw=mysql_fetch_object($rs);
  $obj->shiftid=$rw->id;
  $obj->brancheid=$rw->brancheid;
  $obj->brancheid2=$rw->brancheid;
  $obj->branchename=$rw->branchename;
  $obj->teamroletype=$rw->teamroletype;
  
  $_SESSION['brancheid']=$obj->brancheid;
}

if(empty($obj->orderedon)){
  $obj->orderedon=date("Y-m-d");
}

auth($auth);

$pop = $ob->pop;

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

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <a  class="btn btn-info" href='addorders_proc.php'>New Orders</a></div>
<?php }?>

<script type="text/javascript">
function Clickheretoprint(vat,action)
{ 
	$.post("addorders_proc.php",{action:action,type:1, combined:1,vat:vat},function(data){
	
	window.close();
	
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

<form action="" method="post">
<div>
  <input name="orderedon" type="text" size="12" value="<?php echo $obj->orderedon; ?>" class="date_input" readonly/>
  <input type="hidden" name="brancheid" id="brancheid" value="<?php echo $obj->brancheid; ?>"/>
  <input type="text" name="tableno" id="tableno" value="<?php echo $obj->tableno; ?>"/>
  <input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
  <input class="btn btn-info" type="submit" name="action" value="Filter"/>
</div>
</form>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>&nbsp;</th>
<!-- 			<th>&nbsp;</th> -->
			<th>Order No </th>
<!-- 			<th>Ordered By</th> -->
			<th>Table</th>
			<th>Location</th>
			<th>From</th>
			<th>Date Ordered </th>
<!-- 			<th>Remarks </th> -->
			<th>Total </th>
<!-- 			<th>Paid </th> -->
<!-- 			<th>Balance </th> -->
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	
		$i=0;
		$where=" where pos_orders.status!=3 ";
		if(!empty($obj->shiftid) and $_SESSION['levelid']!=1){
// 		  $where.=" and pos_orders.shiftid in($obj->shiftid) ";
		}
		
		
		$fields="pos_orders.id, pos_orders.orderno, pos_orders.shiftid, crm_customers.name as customerid, pos_orders.orderedon, pos_orders.remarks, pos_orders.ipaddress, pos_orders.createdby, pos_orders.createdon, pos_orders.lasteditedby, pos_orders.lasteditedon, sum(pos_orderdetails.quantity*pos_orderdetails.price) total, concat(hrm_employees.pfnum, ' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) username, sys_branches.name branchename, pos_orders.status, pos_orders.tableno, sys_branchess.name brancheid2 ";
		$join=" left join crm_customers on pos_orders.customerid=crm_customers.id left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join auth_users on auth_users.id=pos_orders.createdby left join sys_branches on sys_branches.id=pos_orders.brancheid left join sys_branches sys_branchess on sys_branchess.id=pos_orders.brancheid2 left join hrm_employees on hrm_employees.id=auth_users.employeeid  ";
		$having="";
		$groupby=" group by pos_orders.id ";
		$orderby=" order by pos_orders.id desc ";
		if(!empty($obj->orderedon)){
		  $where.=" and pos_orders.orderedon='$obj->orderedon'";
		}
// 		if(!empty($obj->brancheid2)){
// 		  $where.=" and pos_orders.brancheid2='$obj->brancheid2' ";
// 		}
// 		if(!empty($obj->brancheid) and $_SESSION['leveltype']=='Front Office'){
// 		  $where.=" and pos_orders.brancheid2='$obj->brancheid' ";
// 		}
		
		if(!empty($obj->employeeid)){
		  $where.=" and auth_users.employeeid='$obj->employeeid' ";
		}
		
		if(!empty($obj->tableno)){
		  $where.=" and pos_orders.tableno='$obj->tableno' ";
		}
		
		$orders->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $orders->sql;
		$res=$orders->result;
		$total=0;
		
		while($row=mysql_fetch_object($res)){
		
		$total+=$row->total;
		
		$query="select case when sum(pos_orderpayments.amount) is null then 0 else sum(pos_orderpayments.amount) end paid from pos_orderpayments where orderid='$row->id' ";
		$w=mysql_fetch_object(mysql_query($query));
		
		$row->paid=$w->paid;
      
		$class="";
		$confirmedorders = new Confirmedorders();
		$fields="*";
		$join="";
		$where=" where orderno='$row->orderno' ";
		$having="";
		$groupby="";
		$orderby="";
		$confirmedorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		if($confirmedorders->affectedRows>0){
		  $class="green";
		}
		
		$balance = -$row->paid+$row->total;
		
		$color="";
		if($balance>0 and $row->paid>0){
		  $color="red";
		}
		
		if($balance<=0 ){
		  $color="green";
		  if($_SESSION['leveltype']=="Front Office")
		    continue;
		}
		
		if($row->status==2){
		  $color="blue";
		}
		
		$i++;
		
	?>
		<tr style="color:<?php echo $color; ?>">
			<td><?php echo $i; ?></td>
			<td><input type='checkbox' id="<?php echo $row->orderno; ?>" onClick="setOrder('<?php echo $row->orderno; ?>');"/>
			<td><a href="javascript:;" onClick="showPopWin('print.php?doc=<?php echo $row->orderno; ?>', 600,600)"><?php echo $row->orderno; ?></a></td>
<!-- 			<td><?php echo $row->shiftid; ?></td> -->
<!-- 			<td><?php echo strtoupper($row->username); ?></td> -->
			<td><?php echo strtoupper($row->tableno); ?></td>
			<td><?php echo strtoupper($row->brancheid2); ?></td>
			<td><?php echo strtoupper($row->branchename); ?></td>
			<td><?php echo formatDate($row->orderedon); ?></td>
<!-- 			<td><?php echo $row->remarks; ?></td> -->
			<td align="right"><a onclick="showPopWin('../orderpayments/addorderpayments_proc.php?action3=1&orderno=<?php echo $row->orderno; ?>&orderid=<?php echo $row->id; ?>',600,430);" href="javascript:;"><?php echo formatNumber($row->total); ?></a></td>
<!-- 			<td align="right"><?php echo formatNumber($row->paid); ?></td> -->
<!-- 			<td align="right"><?php echo formatNumber($balance); ?></td> -->
			<td align="right">
			<?php if($row->status!=3){ ?>
			<a onclick="showPopWin('../orderpayments/addorderpayments_proc.php?action3=1&orderno=<?php echo $row->orderno; ?>&orderid=<?php echo $row->id; ?>',600,430);" href="javascript:;">PAY</a>
			<?php } ?>
			</td>
			<td>
			<?php
			//Authorization.
			$auth->roleid="8666";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			    <a href="orders.php?cancelid=<?php echo $row->id; ?>">VOID</a>
			<?php } ?>
			<?php if($row->status==2){?>
			<a href="orders.php?cancelid=<?php echo $row->id; ?>">CANCEL</a>
			<?php }if($row->status==3){ ?>
			CANCELLED
			<?php } ?>
			</td>
		</tr>
	<?php 
	}
	?>
	</tbody>
	
	<tfoot>
		<tr>
			<th>&nbsp;</th>
<!-- 			<th>&nbsp;</th> -->
<!-- 			<th>&nbsp;</th> -->
<!-- 			<th>&nbsp;</th> -->
<!-- 			<th>&nbsp;</th> -->
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>TOTAL </th>
			<th style="text-align:right;"><?php echo formatNumber($total); ?> </th>
			<th>Paid </th>
			<th>Balance </th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
	
</table>
<?php //if(empty($_SESSION['shift'])){ ?>
<a href="javascript:;" class="btn btn-warning" onClick="Clickheretoprint('','PRINT');">BILL</a>
<!-- <a href="javascript:;" class="btn btn-danger" onClick="Clickheretoprint(1,'PRINT VAT RECEIPT');">PRINT VAT RECEIPT</a> -->
<?php //} ?>
<?php
include"../../../foot.php";
?>
