<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teamdetails_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../../pos/orders/Orders_class.php");
require_once("../../pos/shifts/Shifts_class.php");
require_once("../../hrm/employeesurchages/Employeesurchages_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Teams";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="9486";//Add
$auth->levelid=$_SESSION['level'];

$ob = (object)$_GET;

$obj = (object)$_POST;

if(empty($obj->action)){
  $obj->month=date("m");
  $obj->year=date("Y");
  
  $array = array();

  $_SESSION['shpemployees']=$array;

}

if($obj->action=="Payroll Surchage"){
  $shop = $_SESSION['shpemployees'];
  $i=0;
  while($i<count($shop)){
    $employeesurchages = new Employeesurchages();
    $employeesurchages->surchageid=4;
    $employeesurchages->amount=$shop[$i]['amount'];
    $employeesurchages->employeeid=$shop[$i]['employeeid'];
    $employeesurchages->teamdetailid=$shop[$i]['teamdetailid'];
    $employeesurchages->frommonth=$obj->month;
    $employeesurchages->fromyear=$obj->year;
    $employeesurchages->tomonth=$obj->month;
    $employeesurchages->toyear=$obj->year;
    $employeesurchages->chargedon=$obj->teamedon;
    
    $employeesurchages = $employeesurchages->setObject($employeesurchages);
    
    if($employeesurchages->add($employeesurchages)){
      
      $query="update pos_teamdetails set surchage=surchage+$employeesurchages->amount, id='$employeesurchages->teamdetailid' where teamid='$obj->teamid' and employeeid='$employeesurchages->employeeid'";
      mysql_query($query);
      
    }
    
   
    
    $i++;
    
  }
}

if(!empty($ob->teamid)){
  $obj->teamid=$ob->teamid;
}

//get shift
if(empty($obj->shiftid))
  $query="select pos_shifts.name shiftname, pos_teams.teamedon, pos_shifts.id, pos_teams.id teamid from pos_shifts left join pos_teams on pos_teams.shiftid=pos_shifts.id where pos_teams.id in($obj->teamid)";
else
  $query="select pos_shifts.name shiftname, pos_teams.teamedon, pos_shifts.id, pos_teams.id teamid from pos_shifts left join pos_teams on pos_teams.shiftid=pos_shifts.id where pos_teams.teamedon='$obj->teamedon' and pos_teams.shiftid='$obj->shiftid' and pos_teams.brancheid='$obj->brancheid'";

$shifts = mysql_fetch_object(mysql_query($query));

$obj->teamid=$shifts->teamid;
$obj->shiftid = $shifts->id;

if(!empty($_SESSION['shift']))
  $obj->teamedon=$shifts->teamedon;
elseif(empty($obj->action))
  $obj->teamedon=date("Y-m-d");
  
  $obj->teamedon=$shifts->teamedon;
  
if(!empty($ob->brancheid)){
  $obj->brancheid=$ob->brancheid;
}

if(!empty($_SESSION['tobrancheid']) and !empty($_SESSION['shift'])){
   $obj->brancheid=$_SESSION['tobrancheid'];
}

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$teamdetails=new Teamdetails();
if(!empty($delid)){
	$teams->id=$delid;
	$teams->delete($teams);
	redirect("teams.php");
}
//Authorization.
$auth->roleid="9486";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!-- <div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addteams_proc.php',600,430);" value="NEW" type="button"/></div> -->
<?php }?>

<script type="text/javascript">
function clickHerePrint(itemdetailid, teamid, createdby){
  
  var brancheid = $("#brancheid").val();
  poptastic("print.php?itemdetailid="+itemdetailid+"&brancheid="+brancheid+"&teamid="+teamid+"&createdby="+createdby);
  
}

function enableSurchage(str, id, amount, teamdetailid){
  if(str.checked){
    $("#surchage"+id).prop("readonly",false);
    $("#surchage"+id).val(amount);
  }
  else{
    $("#surchage"+id).prop("readonly",true);
    $("#surchage"+id).val(0);
  }
  setSurchage(str.checked,id,amount,teamdetailid);
}

function setSurchage(checked,id,amount,teamdetailid){
  $.post("setEmployees.php",{checked:checked,id:id,amount:amount,teamdetailid:teamdetailid},function(data){
    
  });
}
</script>

<form action="teamdetailss.php" method="post">
<table class="table">
  <tr>
    <td>Selling Point: </td>
    <td><input type="hidden" name="teamid" value="<?php echo $obj->teamid; ?>"/>
    <select name="brancheid" id="brancheid">
      <?php if(!empty($_SESSION['shift'])) ?>
      <option value="">Select...</option>
    <?php
	  $branches = new Branches();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where="";
	  $orderby=" order by name ";
	  if($_SESSION['shift']==1){
	    $where=" where id in(select brancheid from pos_teams t left join pos_teamdetails td on t.id=td.teamid where td.employeeid='".$_SESSION['employeeid']."' and status=0) " ;
      }
	  $branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  while($rw=mysql_fetch_object($branches->result)){
	  ?>
	    <option value="<?php echo $rw->id; ?>" <?php if($rw->id==$obj->brancheid)echo "selected";?>><?php echo $rw->name; ?></option>
	  <?php
	  }
	  ?>
      </select>
     </td>
     <td>Teamed On: </td>
     <td>
     
     <input type="text" <?php if(empty($_SESSION['shift']))echo "class='date_input'";?> readonly name="teamedon" id="teamedon" value="<?php echo $obj->teamedon; ?>"/>
     
     </td>
     <td>Shift: </td>
     <td>
      <select name="shiftid" id="shiftid">
      
      <option value="">Select...</option>
    <?php
	  $branches = new Shifts();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where="";
	  $orderby=" order by name ";
	  $branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  while($rw=mysql_fetch_object($branches->result)){
	  ?>
	    <option value="<?php echo $rw->id; ?>" <?php if($rw->id==$obj->shiftid)echo "selected";?>><?php echo $rw->name; ?></option>
	  <?php
	  }
	  ?>
      </select>
     </td>
     <td><input type="submit" name="action" value="Filter"/></td>
     <td class="btn-success" style="min-width:50px; font-size:20px;"><?php echo $shifts->shiftname; ?></td>
  </tr>
</table>

<table style="clear:both;"  class="table table-codensed" id="example" width="100%" >
	<thead>
		<tr>
			<th>#</th>
			<?php
			//Authorization.
			$auth->roleid="1171";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<th>&nbsp;</th>
			<?php } ?>
			<th>Position </th>
			<th>Shift </th>
			<?php
			//Authorization.
			$auth->roleid="7486";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>			
			<th>Ordered</th>
			<th>Collected</th>
			<?php
			}
			?>
			<th>Balance</th>
			<th>Remitted</th>
			<th>UnRemitted</th>
			<?php
			//Authorization.
			$auth->roleid="1171";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<th>Surchage</th>
			<?php
			}
			?>
			<th>Remarks </th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		if(!empty($_SESSION['shift'])){
		  $query="select * from pos_teams left join pos_teamdetails on pos_teams.id=pos_teamdetails.teamid where pos_teamdetails.employeeid='".$_SESSION['employeeid']."' order by pos_teams.id desc ";
		  $r = mysql_fetch_object(mysql_query($query));
		}else{
		  $r->teamedon=$obj->teamedon;
		}
		$i=0;
		$teamdetails = new Orders();
		$fields=" distinct hrm_employees.id employeeid, concat(hrm_employees.firstname, ' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name,  hrm_assignments.name assignmentid, auth_users.id userid,   sum(pos_orderdetails.quantity*pos_orderdetails.price) amount, pos_teams.id teamid, pos_teams.brancheid ";
		$join=" left join auth_users on auth_users.id=pos_orders.createdby left join hrm_employees on hrm_employees.id=auth_users.employeeid left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join pos_teams on pos_teams.id=pos_orders.shiftid  ";
		$having="";
		$groupby=" group by hrm_employees.id having amount>0 ";
		$orderby=" ";
		$where=" where pos_orders.status=1 and pos_teams.shiftid='$obj->shiftid' ";
				
		if(!empty($obj->teamid) and $r->brancheid!=30 and !empty($_SESSION['shift']) and $obj->brancheid<>32){
		  $where.="  and pos_orders.brancheid2='$obj->brancheid' ";
		  if($obj->brancheid<>32)
            $where.=" and pos_orders.shiftid in($obj->teamid) ";
		}else{
		  $where.=" and pos_teams.teamedon='$r->teamedon' and pos_orders.brancheid2='$obj->brancheid' ";
		}
		$teamdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $teamdetails->sql;
		$res=$teamdetails->result;
		$tordered=0;
		$tcollected=0;
		$tbalance=0;
		$tremitted=0;
		$tshort=0;
		
		while($row=mysql_fetch_object($res)){
				
// 		if(empty($rw->amount))
// 		  continue;
		
		$i++;
				
		$query="select sum(pos_teampayments.amount) submitted from pos_teampayments left join pos_teamdetails on pos_teamdetails.id=pos_teampayments.teamdetailid where pos_teampayments.brancheid='$obj->brancheid' and pos_teamdetails.employeeid='$row->employeeid' and pos_teamdetails.teamid in($row->teamid) and pos_teampayments.cashier=0 ";
		$cld = mysql_fetch_object(mysql_query($query));
		
		$query="select *, group_concat(id) id from pos_teamdetails where employeeid='$row->employeeid' and teamid in($row->teamid)";
		$rw = mysql_fetch_object(mysql_query($query));
		
		$query="select sum(amount) amount from pos_teampayments where teamdetailid in($rw->id) and pos_teampayments.brancheid='$obj->brancheid' and pos_teampayments.cashier=0 ";
		$r=mysql_fetch_object(mysql_query($query));
		
		$balance=$row->amount-($row->paid+$r->amount+$rw->surchage);
		
		$color="";
		if($row->enddate!='0000-00-00 00:00:00' and $balance>0){
		  $color="red";
		}
		elseif($row->enddate!='0000-00-00 00:00:00' and $balance<=0){
		  $color="green";
		}
		
		$row->short=$balance;
		
		$tordered+=$row->amount;
		$tcollected+=$row->paid;
		$tbalance+=$balance;
		$tremitted+=$cld->submitted;
		$tshort+=$row->short;
		
		$status="Open";
		if($row->status==1)
		  $status="Close";
	?>
		<tr style="color:<?php echo $color; ?>;">
			<td><?php echo $i; ?></td>
			<?php
			//Authorization.
			$auth->roleid="1171";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<td><input type="checkbox" onClick="enableSurchage(this,'<?php echo $row->employeeid; ?>','<?php echo $row->short; ?>','<?php echo $rw->id; ?>');" name="<?php echo $row->employeeid; ?>" value="<?php echo $row->employeeid; ?>"/>
			<?php } ?>
			<td><?php echo $row->assignmentid; ?></td>
			
			<td><a href="../orders/orders.php?shiftid=<?php echo $obj->teamid; ?>&employeeid=<?php echo $row->employeeid; ?>&brancheid2=<?php echo $obj->brancheid; ?>"><?php echo initialCap($row->name); ?></a></td>
			<?php
			//Authorization.
			$auth->roleid="7486";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<td align="right"><?php echo formatNumber($row->amount); ?></td>
			<td align="right"><?php echo formatNumber($row->paid); ?></td>
			<?php
			}
			?>
			<td align="right"><?php echo formatNumber($balance); ?></td>
			<td align="right"><a href="javascript:;" onclick="showPopWin('addteamdetails_proc.php?id=<?php echo $rw->id; ?>&brancheid2=<?php echo $obj->brancheid; ?>&employeeid=<?php echo $row->employeeid; ?>&teamid=<?php echo $obj->teamid; ?>',800,530);"><?php echo formatNumber($cld->submitted); ?></a></td>
			<td align="right"><?php echo formatNumber($row->short); ?></td>
			<?php
			//Authorization.
			$auth->roleid="1171";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<td align="right"><input type="text" onChange="setSurchage(true,'<?php echo $row->employeeid; ?>',this.value);" readonly name="surchage<?php echo $row->employeeid; ?>" id="surchage<?php echo $row->employeeid; ?>" value="<?php echo formatNumber($row->surchage); ?>"/></td>
			<?php
			}
			?>
			<td><?php echo $row->remarks; ?></td>
			<td>
			<?php if($row->short>0){ ?>
			  <a href="javascript:;" onclick="showPopWin('addteamdetails_proc.php?id=<?php echo $rw->id; ?>&brancheid2=<?php echo $obj->brancheid; ?>&employeeid=<?php echo $row->employeeid; ?>&teamid=<?php echo $obj->teamid; ?>',800,530);">Clear</a>
			<?php } ?>
			</td>
			<td>
			  
			  <a href="javascript:;" onClick="clickHerePrint('<?php echo $rw->id; ?>','<?php echo $row->teamid; ?>','<?php echo $row->brancheid; ?>');">Print</a>
			  
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
			<th style="text-align:right;"><?php echo formatNumber($tordered); ?></th>
			<th style="text-align:right;"><?php echo formatNumber($tcollected); ?></th>
			<?php
			//Authorization.
			$auth->roleid="7486";//View
			$auth->levelid=$_SESSION['level'];

			if(existsRule($auth)){
			?>
			<th style="text-align:right;"><?php echo formatNumber($tbalance); ?></th>
			<th style="text-align:right;"><?php echo formatNumber($tremitted); ?></th>
			<th style="text-align:right;"><?php echo formatNumber($tshort); ?></th>
			<?php 
			}
			?>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</tfoot>
</table>

<table>
<?php
//Authorization.
$auth->roleid="1171";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<tr>
    <td><strong>Year:</strong></td>
    <td><select name="year" class="input-small">
          <option value="">Select...</option>
          <?php
	  $i=date("Y")-10;
	  while($i<date("Y")+10)
	  {
		?>
		  <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
		  <?
	    $i++;
	  }
	  ?>
      </select></td>
    <td>Month:</td>
    <td><select name="month">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select>
      </td>
    <td><input type="submit" name="action" class="btn btn-primary" value="Payroll Surchage"/></td>
</tr>
<?php } ?>
</table>
</form>
<?php
include"../../../foot.php";
?>
