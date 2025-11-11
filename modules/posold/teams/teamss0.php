<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teams_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../pos/orders/Orders_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Teams";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="11928";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;
$obj = (object)$_POST;

//get shift
$query="select pos_shifts.name shiftname, pos_teams.teamedon, pos_shifts.id from pos_shifts left join pos_teams on pos_teams.shiftid=pos_shifts.id where pos_teams.id in($obj->teamid)";
$shifts = mysql_fetch_object(mysql_query($query));

if(!empty($_SESSION['shift']))
  $obj->teamedon=$shifts->teamedon;
elseif(empty($obj->action))
  $obj->teamedon=date("Y-m-d");
  
if(!empty($ob->brancheid)){
  $obj->brancheid=$ob->brancheid;
}

if(!empty($_SESSION['tobrancheid']) and !empty($_SESSION['shift'])){
   $obj->brancheid=$_SESSION['tobrancheid'];
}

if(!empty($ob->did)){
  if($ob->status==0){
    $st=1;
  }else{
    $st=0;
  }
  
  if($st==1){
    $startedon=date("Y-m-d H:i:s");
    $wh=", startedon='$startedon', endedon='' ";
  }else{
    $endedon=date("Y-m-d H:i:s");
    $wh=", endedon='$endedon' ";
  }
  
  $query="update pos_teams set status='$st' $wh where id='$ob->did'";
  mysql_query($query);
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$teams=new Teams();
if(!empty($delid)){
	$teams->id=$delid;
	$teams->delete($teams);
	redirect("teams.php");
}
//Authorization.
$auth->roleid="11927";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addteams_proc.php',600,430);" value="NEW" type="button"/></div> -->
<?php }?>

<form action="teamss.php" method="post">
<table class="table">
  <tr>
    <td align="right">From:</td>
    <td><input type="text" readonly class="date_input" name="teamedon" id="teamedon" value="<?php echo $obj->teamedon; ?>"/></td>
<!--     <td align="right">To:</td> -->
    <td>
<!--     <input type="text" readonly class="date_input" name="toteamedon" id="toteamedon" value="<?php echo $obj->toteamedon; ?>"/> -->
    <input type="hidden" name="brancheid" value="<?php echo $obj->brancheid; ?>"/>
    </td>
    <td><input type="submit" name="action" value="Filter"/>
  </tr>
</table>
</form>

<table style="clear:both;"  class="table table-codensed" id="example" width="100%" >
	<thead>
		<tr>
			<th>#</th>
			<th>Location </th>
			<th>&nbsp;</th>
			<th>Shift </th>
			<th>Startedon </th>
			<th>Ended On </th>
			<th>Teamed On </th>
			<?php
			//Authorization.
			$auth->roleid="7486";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<th>Ordered</th>
			<th>Cashier Float</th>
			<th>From Waiters</th>
			<th>Remitted</th>
			<th>UnRemitted</th>
			<th>Waiter Shortage</th>
			<?php } ?>
			<th>Remarks </th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		
		if(empty($obj->teamedon))
		  $obj->teamedon=date("Y-m-d");
		
		if(!empty($_SESSION['shift'])){
		  $query="select * from pos_teams left join pos_teamdetails on pos_teams.id=pos_teamdetails.teamid where pos_teamdetails.employeeid='".$_SESSION['employeeid']."' order by pos_teams.id desc ";
		  $r = mysql_fetch_object(mysql_query($query));
		}else{
		  $r->teamedon=$obj->teamedon;
		}
		
		$teams = new Orders();
		$fields=" distinct sys_branches.name as brancheid, sys_branches.id branche,  pos_shifts.name shift, pos_teams.startedon, pos_teams.endedon, pos_teams.teamedon, pos_teams.remarks, pos_teams.ipaddress, pos_teams.createdby, pos_teams.createdon, pos_teams.lasteditedby, pos_teams.lasteditedon, pos_teams.status, pos_teams.submitted, pos_teams.shiftid shiftids, sum(pos_orderdetails.price*pos_orderdetails.quantity) amount, group_concat(distinct pos_orders.shiftid) shiftid";
		$join=" left join pos_teams on pos_teams.id=pos_orders.shiftid left join sys_branches on pos_orders.brancheid2=sys_branches.id  left join pos_shifts on pos_teams.shiftid=pos_shifts.id left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id ";
		$having="";
		$groupby=" group by  branche, pos_shifts.id, pos_teams.teamedon ";
		$orderby=" order by pos_orders.id desc ";
		$where=" where pos_orders.status=1 ";
		
		if(!empty($obj->teamid) and $r->brancheid!=30 and !empty($_SESSION['shift'])){
		  $where.=" and pos_orders.brancheid2='$obj->brancheid' ";
		}else{
		  $where.=" and pos_teams.teamedon='$r->teamedon' and pos_orders.brancheid2='$obj->brancheid' ";
		}
		
		$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$teams->result;
		
		$tordered=0;
		$tcollected=0;
		$tremitted=0;
		$twaiters=0;
		$tshortage=0;
		$tunremitted=0;
		
		while($row=mysql_fetch_object($res)){
		$i++;
		
		//get orders under this shifts
		$query="select sum(pos_orderdetails.price*pos_orderdetails.quantity) amount, sum(pos_orderpayments.amount) paid from pos_orders left join pos_orderpayments on pos_orderpayments.orderid=pos_orders.id left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id where pos_orders.shiftid in($row->shiftid)";
		$rw=mysql_fetch_object(mysql_query($query));
				
		//get bar tender
		$query="select group_concat(hrm_employees.id) employeeid, group_concat(concat(hrm_employees.firstname, ' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) separator ', ') name from hrm_employees left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid left join hrm_levels on hrm_levels.id=hrm_assignments.levelid where hrm_employees.id in(select employeeid from pos_teamdetails left join pos_teams on pos_teamdetails.teamid=pos_teams.id where pos_teams.teamedon='$r->teamedon' and pos_teams.brancheid='$row->branche' and pos_teams.shiftid='$row->shiftids') and hrm_levels.id!=8 ";//echo $query;
		$emp = mysql_fetch_object(mysql_query($query));
		
		$query="select group_concat(id) id from pos_teamdetails where employeeid='$emp->employeeid' and teamid in($row->shiftid)";
		$rws = mysql_fetch_object(mysql_query($query));
		
		$query="select sum(pos_teampayments.amount) submitted from pos_teamdetails left join pos_teampayments on pos_teamdetails.id=pos_teampayments.teamdetailid where pos_teampayments.brancheid='$row->branche' and pos_teamdetails.teamid in($row->shiftid) and pos_teampayments.cashier=0 ";
		$waiter=mysql_fetch_object(mysql_query($query));
		
		$waiter->amount = $row->amount-$waiter->submitted;
				
		$query="select sum(pos_teampayments.amount) submitted from pos_teamdetails left join pos_teampayments on pos_teamdetails.id=pos_teampayments.teamdetailid where pos_teampayments.brancheid='$row->branche' and pos_teamdetails.teamid in($row->shiftid) and pos_teamdetails.employeeid in($emp->employeeid) and pos_teampayments.cashier=1";
		$cashier=mysql_fetch_object(mysql_query($query));
		
		$query="select sum(amount) amount from fn_imprests where employeeid in($emp->employeeid) and issuedon='$r->teamedon'";
		$float = mysql_fetch_object(mysql_query($query));
		
		$row->submitted=$cashier->submitted;		
		
		$balance=$waiter->submitted-$row->submitted+$float->amount;
		
		$color="";
		if($row->enddate!='0000-00-00 00:00:00' and $balance>0){
		  $color="red";
		}
		elseif($row->enddate!='0000-00-00 00:00:00' and $balance<=0 and $waiter->submitted<>0){
		  $color="green";
		}
		
		$status="Close";
		if($row->status==1)
		  $status="Open";		
		
		//($row->amount+$row->submitted)-($rw->paid+$waiter->amount);
		
		$tordered+=$row->amount;
		$tcollected+=$row->paid;
		$tremitted+=$row->submitted;
		$twaiters+=$waiter->submitted;
		$tshortage+=$waiter->amount;
		$tunremitted+=$balance;
		
	?>
		<tr style="color:<?php echo $color; ?>;">
			<td><?php echo $i; ?></td>
			<td><?php echo $row->brancheid; ?></td>
			<td><?php echo initialCap($emp->name); ?></td>
			<td><a href="../teamdetails/teamdetailss.php?teamid=<?php echo $row->shiftid; ?>&brancheid=<?php echo $row->branche; ?>"><?php echo $row->shift; ?></a></td>
			<td><?php echo ($row->startedon); ?></td>
			<td><?php echo ($row->endedon); ?></td>
			<td><?php echo ($row->teamedon); ?></td>
			<?php
			//Authorization.
			$auth->roleid="7486";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<td align="right"><?php echo formatNumber($row->amount); ?></td>
			<td align="right"><?php echo formatNumber($float->amount); ?></td>
			<td align="right"><?php echo formatNumber($waiter->submitted); ?></td>
			<td align="right"><?php echo formatNumber($row->submitted); ?></td>
			<td align="right"><?php echo formatNumber($balance); ?></td>
			<td align="right"><?php echo formatNumber($waiter->amount); ?></td>
			<?php
			}
			?>
			<td><?php echo $row->remarks; ?></td>
			<?php
			//Authorization.
			$auth->roleid="2085";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<td>		  
			    <a href="teamss.php?brancheid=<?php echo $row->branche; ?>&did=<?php echo $row->id; ?>&status=<?php echo $row->status; ?>"><?php echo $status; ?></a>
			  
			</td>
			<td>
			  <a href="javascript:;" onclick="showPopWin('../teamdetails/addteamdetails_proc.php?id=<?php echo $rws->id; ?>&brancheid2=<?php echo $obj->brancheid; ?>&employeeid=<?php echo $emp->employeeid; ?>&teamid=<?php echo $obj->teamid; ?>&cashier=1&teamedon=<?php echo $obj->teamedon; ?>',800,530);">Clear</a>
			</td>
			<?php
			}else{
			?>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<?php } ?>
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
			<th>&nbsp;</th>
			<?php
			//Authorization.
			$auth->roleid="7486";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<th style="text-align:right;"><?php echo $tordered; ?></th>
			<th style="text-align:right;"><?php echo $tcollected; ?></th>
			<th style="text-align:right;"><?php echo $tremitted; ?></th>
			<th style="text-align:right;"><?php echo $twaiters; ?></th>
			<th style="text-align:right;"><?php echo $tshortage; ?></th>
			<th style="text-align:right;"><?php echo $tunremitted; ?></th>
			<?php } ?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
	
</table>
<?php
include"../../../foot.php";
?>
