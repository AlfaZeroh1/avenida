<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Shifts_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Shifts";
//connect to db
$db=new DB();

$obj = (object)$_POST;
$ob = (object)$_GET;

if(empty($obj->action)){
  $obj->fromdate=date("Y-m-d 00:00:00");
//   $obj->todate=date("Y-m-d 11:59:00");
  $obj->action="Filter";
}

if(!empty($ob->fromdate)){
  $obj->fromdate=$ob->fromdate;
  $obj->action="Filter";
}

if(!empty($ob->todate)){
  $obj->todate=$ob->todate;
  $obj->action="Filter";
}

if(!empty($ob->brancheid)){
  $obj->brancheid=$ob->brancheid;
  $obj->action="Filter";
}

if(!empty($ob->id)){
  //close a shift
  if($ob->type==2){
    $query="update pos_shifts set enddate=Now() where id='$ob->id'";
    mysql_query($query);
  }
  
  if($ob->type==1){
    $query="update pos_shifts set enddate='' where id='$ob->id'";
    mysql_query($query);
  }
}

if($obj->action=="Filter"){
  if(!empty($obj->fromdate)){
    if(empty($rptwhere))
      $rptwhere=" where ";
    else
      $rptwhere.=" and ";
      
    $rptwhere.=" pos_shifts.starttime>='$obj->fromdate' ";
  }
  
  if(!empty($obj->todate)){
    if(empty($rptwhere))
      $rptwhere=" where ";
    else
      $rptwhere.=" and ";
      
    $rptwhere.=" pos_shifts.enddate>='$obj->todate' ";
  }
  
  if(!empty($obj->brancheid)){
    if(empty($rptwhere))
      $rptwhere=" where ";
    else
      $rptwhere.=" and ";
      
    $rptwhere.=" pos_shifts.brancheid='$obj->brancheid' ";
  }
  
}

//Authorization.
$auth->roleid="11916";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$shifts=new Shifts();
if(!empty($delid)){
	$shifts->id=$delid;
	$shifts->delete($shifts);
	redirect("shifts.php");
}
//Authorization.
$auth->roleid="11915";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addshifts_proc.php',600,430);" value="NEW" type="button"/></div> -->
<?php }?>

<form action="" method="post">
<table class="table">
  <tbody>
    <tr>
      <td align="right">From</td>
      <td><input type="text" size="12" readonly class="datetime" name="fromdate" id="fromdate" value="<?php echo $obj->fromdate; ?>"/></td>
      <td align="right">To</td>
      <td><input type="text" size="12" readonly class="datetime" name="todate" id="todate" value="<?php echo $obj->todate; ?>"/></td>
      
      <td align="right">Selling Point</td>
      <td>
      <select name="brancheid" id="brancheid" class="selectbox">
	<option value="">Select...</option>
	<?php
	$branches = new Branches();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res=$branches->result;
	while($row=mysql_fetch_object($res)){
	?>
	  <option value="<?php echo $row->id; ?>" <?php if($obj->brancheid==$row->id)echo "selected"; ?>><?php echo strtoupper($row->name);?></option>
	<?
	}
	?>
      </select>
      </td>
      
      <td><input type="submit" name="action" class="btn btn-primary" value="Filter"/>
    </tr>
  </tbody>
</table>
</form>

<table style="clear:both;"  class="table display" width="100%" >
	<thead>
		<tr>
			<th>#</th>
			<th>Location </th>
			<th>Start Date </th>
			<th>End Date </th>
			<th>Remarks </th>
			<th>Ordered</th>
			<th>Paid</th>
			<th>Balance</th>
			<th>Submitted</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
<?php
//Authorization.
$auth->roleid="11917";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11918";//View
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
		$fields="pos_shifts.id, pos_teams.id as teamid, pos_shifts.submitted, sys_branches.name as brancheid, pos_shifts.starttime, pos_shifts.enddate, pos_shifts.remarks, pos_shifts.ipaddress, pos_shifts.createdby, pos_shifts.createdon, pos_shifts.lasteditedby, pos_shifts.lasteditedon";
		$join=" left join pos_teams on pos_shifts.teamid=pos_teams.id  left join sys_branches on pos_shifts.brancheid=sys_branches.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where="".$rptwhere;
		$shifts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$shifts->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		
		//get orders under this shifts
		$query="select sum(pos_orderdetails.price*pos_orderdetails.quantity) amount,sum(pos_orderpayments.amount) paid from pos_orders left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join pos_orderpayments on pos_orderpayments.orderid=pos_orders.id where pos_orders.shiftid='$row->id'";
		$rw=mysql_fetch_object(mysql_query($query));
		
		$balance=$rw->amount-$rw->paid;
		
		$color="";
		if($row->enddate!='0000-00-00 00:00:00' and $balance>0){
		  $color="red";
		}
		elseif($row->enddate!='0000-00-00 00:00:00' and $balance<=0){
		  $color="green";
		}
	?>
		<tr style="color:<?php echo $color; ?>;">
			<td><?php echo $i; ?></td>
			<td><a href="../teamdetails/teamdetails.php?teamid=<?php echo $row->teamid; ?>"><?php echo $row->brancheid; ?></a></td>
			<td><?php echo ($row->starttime); ?></td>
			<td><?php echo ($row->enddate); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo formatNumber($rw->amount); ?></td>
			<td><?php echo formatNumber($rw->paid); ?></td>
			<td><?php echo formatNumber($balance); ?></td>
			<td><?php echo formatNumber($row->submitted); ?></td>
			<td>
			<?php if($row->enddate=='0000-00-00 00:00:00'){ ?>
			  <a href="shifts.php?id=<?php echo $row->id; ?>&type=2&fromdate=<?php echo $obj->fromdate; ?>&enddate=<?php echo $obj->todate; ?>">Close Shift</a>
			<?php }else{ ?>
			  <a href="shifts.php?id=<?php echo $row->id; ?>&type=1&fromdate=<?php echo $obj->fromdate; ?>&enddate=<?php echo $obj->todate; ?>">Open Shift</a>
			<?php } ?>
			</td>
			<td>
			<?php if($row->status<1){ ?>
			  <a href="javascript:;" onclick="showPopWin('addshifts_proc.php?id=<?php echo $row->id; ?>&type=2',600,430);">Clear Shift</a>
			<?php } ?>
			</td>
<?php
//Authorization.
$auth->roleid="11917";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addshifts_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="11918";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='shifts.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')"><img src='../../../dmodal/trash.png' alt='delete' title='delete' /></a></td>
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
