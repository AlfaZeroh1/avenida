<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Teamdetails_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../../pos/orders/Orders_class.php");

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

if(!empty($ob->teamid)){
  $obj->teamid=$ob->teamid;
}

//get shift
$query="select pos_shifts.name shiftname from pos_shifts left join pos_teams on pos_teams.shiftid=pos_shifts.id where pos_teams.id in($obj->teamid)";
$shifts = mysql_fetch_object(mysql_query($query));

if(!empty($ob->brancheid)){
  $obj->brancheid=$ob->brancheid;
}

if(!empty($_SESSION['brancheid'])){
//    $obj->brancheid=$_SESSION['brancheid'];
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
</script>

<form action="teamdetailss.php" method="post">
<table>
  <tr>
    <td>Selling Point: </td>
    <td><input type="hidden" name="teamid" value="<?php echo $obj->teamid; ?>"/>
    <?php
    $branches = new Branches();
    $fields=" * ";
    $join="";
    $groupby="";
    $having="";
    $where=" where id in(select pos_teams.brancheid from pos_teams left join pos_teamdetails on pos_teamdetails.teamid=pos_teams.id where pos_teamdetails.employeeid='".$_SESSION['employeeid']."' and status=0) " ;
    $branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);
    ?>
    <select name="brancheid" id="brancheid">
      <option value="">Select...</option>
    <?php
	  
	  while($rw=mysql_fetch_object($branches->result)){
	  ?>
	    <option value="<?php echo $rw->id; ?>" <?php if($rw->id==$obj->brancheid)echo "selected";?>><?php echo $rw->name; ?></option>
	  <?php
	  }
	  ?>
      </select>
     </td>
     <td><input type="submit" name="action" value="Filter"/></td>
     <td class="btn-success" style="min-width:50px; font-size:20px;"><?php echo $shifts->shiftname; ?></td>
  </tr>
</table>
</form>

<table style="clear:both;"  class="table table-codensed" id="example" width="100%" >
	<thead>
		<tr>
			<th>#</th>
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
			<th>Remarks </th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	
		$query="select * from pos_teams left join pos_teamdetails on pos_teams.id=pos_teamdetails.teamid where pos_teams.id='$obj->teamid' ";
		$r = mysql_fetch_object(mysql_query($query));
		
		$i=0;
		$teamdetails = new Orders();
		$fields=" distinct hrm_employees.id employeeid, concat(hrm_employees.firstname, ' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name,  hrm_assignments.name assignmentid, auth_users.id userid,   sum(pos_orderdetails.quantity*pos_orderdetails.price) amount ";
		$join=" left join auth_users on auth_users.id=pos_orders.createdby left join hrm_employees on hrm_employees.id=auth_users.employeeid left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid left join pos_orderdetails on pos_orderdetails.orderid=pos_orders.id left join pos_teams on pos_teams.id=pos_orders.shiftid  ";
		$having="";
		$groupby=" group by hrm_employees.id having amount>0 ";
		$orderby=" ";
		$where=" where pos_orders.status=1 ";
		if(!empty($obj->teamid) and $r->brancheid!=30){
		  $where.=" and pos_orders.shiftid in($obj->teamid) and pos_orders.brancheid2='$obj->brancheid' ";
		}else{
		  $where.=" and pos_teams.teamedon='$r->teamedon' and pos_orders.brancheid2='$obj->brancheid' ";
		}
		$teamdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
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
				
		$query="select sum(pos_teamdetailclearances.submitted) submitted, pos_teamdetailclearances.teamdetailid from pos_teamdetailclearances left join pos_teamdetails on pos_teamdetails.id=pos_teamdetailclearances.teamdetailid left join pos_teams on pos_teams.id=pos_teamdetails.teamid where pos_teamdetailclearances.brancheid='$obj->brancheid' and pos_teamdetails.employeeid='$row->employeeid' and pos_teams.teamedon='$r->teamedon' ";
		$cld = mysql_fetch_object(mysql_query($query));
		
		$query="select pos_teamdetails.*, group_concat(pos_teamdetails.id) id from pos_teamdetails left join pos_teams on pos_teams.id=pos_teamdetails.teamid where pos_teamdetails.employeeid='$row->employeeid' and pos_teams.teamedon='$r->teamedon'";
		$rw = mysql_fetch_object(mysql_query($query));
		
		
		$balance=$row->amount-($row->paid+$cld->submitted);
		
		$color="";
		if($row->enddate!='0000-00-00 00:00:00' and $balance>0){
		  $color="red";
		}
		elseif($row->enddate!='0000-00-00 00:00:00' and $balance<=0){
		  $color="green";
		}
		
		$row->short=$row->amount-($row->paid+$cld->submitted);
		
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
			<td align="right"><?php echo formatNumber($cld->submitted); ?></td>
			<td align="right"><?php echo formatNumber($row->short); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td>
			<?php if($row->short>0){ ?>
			  <a href="javascript:;" onclick="showPopWin('addteamdetails_proc.php?id=<?php echo $rw->id; ?>&brancheid2=<?php echo $obj->brancheid; ?>&employeeid=<?php echo $row->employeeid; ?>&teamid=<?php echo $r->id; ?>',600,430);">Clear</a>
			<?php } ?>
			</td>
			<td>
			  
			  <a href="javascript:;" onClick="clickHerePrint('<?php echo $rw->id; ?>','<?php echo $obj->teamid; ?>','<?php echo $row->userid; ?>');">Print</a>
			  
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
<?php
include"../../../foot.php";
?>
