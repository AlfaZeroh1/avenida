<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../pos/teams/Teams_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Teams";
//connect to db
$db=new DB();

$obj=(object)$_POST;
$ob = (object)$_GET;

$date = date("Y-m-d H:i:s"); 

if(empty($obj->action)){
  $obj->fromteamedon=date("Y-m-d");
  $obj->toteamedon=date("Y-m-d");
}

if(!empty($ob->did)){
  if($ob->status==0){
    $st=1;
  }else{
    $st=0;
  }
  
  if($st==0){
    $startedon=date("Y-m-d H:i:s");
    $wh=", startedon='$startedon', endedon='' ";
  }else{
    $endedon=date("Y-m-d H:i:s");
    $wh=", endedon='$endedon' ";
    
    $query="select *, DATE_ADD(teamedon , INTERVAL 1 DAY) takenon from pos_teams where id='$ob->did'";
    $r = mysql_fetch_object(mysql_query($query));    
    
    if($r->shiftid=1 and date("Y-m-d")>='2018-01-15'){
      $query="select * from inv_stocktakes where openedon='$r->takenon' and status='Closed' and brancheid='$r->brancheid'";
      mysql_query($query);
      if(mysql_affected_rows()==0)
	$error="Stock take for ".formatDate($r->takenon)." not Closed Yet!";
    }
  }
  
  if(empty($error)){
    $query="update pos_teams set status='$st' $wh where id='$ob->did'";
    mysql_query($query);
  }else{
    showError($error);
  }
}

//Authorization.
$auth->roleid="11928";//View
$auth->levelid=$_SESSION['level'];

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
<h3 style="color:red;">Note: Colour Green shows all the active shifts</h3>
<form action="teams.php" method="post">
<table class="table">
  <tr>
    <td align="right">From:</td>
    <td><input type="text" readonly class="date_input" name="fromteamedon" id="fromteamedon" value="<?php echo $obj->fromteamedon; ?>"/></td>
    <td align="right">To:</td>
    <td><input type="text" readonly class="date_input" name="toteamedon" id="toteamedon" value="<?php echo $obj->toteamedon; ?>"/>
    <input type="hidden" name="brancheid" value="<?php echo $obj->brancheid; ?>"/>
    </td>
    <td><input type="submit" name="action" value="Filter"/>
  </tr>
</table>
</form>
<table style="clear:both;"  class="table table-codensed" id="example" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Location </th>
			<th>Shift </th>
			<th>Startedon </th>
			<th>Ended On </th>
			<th>Teamed On </th>
			<th>Remarks </th>
			<th>Status</th>
<?php
//Authorization.
$auth->roleid="11929";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="11930";//View
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
		$fields="pos_teams.id, sys_branches.name as brancheid, sys_branches.id branche, pos_shifts.name as shiftid, pos_teams.startedon, pos_teams.endedon, pos_teams.teamedon, pos_teams.remarks, pos_teams.ipaddress, pos_teams.createdby, pos_teams.createdon, pos_teams.lasteditedby, pos_teams.lasteditedon, pos_teams.status statusid, case when pos_teams.status=1 then 'Closed' else 'Open' end status";
		$join=" left join sys_branches on pos_teams.brancheid=sys_branches.id  left join pos_shifts on pos_teams.shiftid=pos_shifts.id ";
		$having="";
		$groupby="";
		$where="";
		if(!empty($obj->fromteamedon)){
		  if(empty($where))
		    $where.=" where ";
		  else
		    $where.=" and ";
		    
		  $where.=" pos_teams.teamedon >='$obj->fromteamedon'"; 
		}
		
		if(!empty($obj->toteamedon)){
		  if(empty($where))
		    $where.=" where ";
		  else
		    $where.=" and ";
		    
		  $where.=" pos_teams.teamedon<='$obj->toteamedon' ";
		}		
		
		$orderby=" order by id desc ";
		$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$teams->result;   											
		while($row=mysql_fetch_object($res)){  //print_r($row);
		$i++;
		
		$status=0;
		
		$query="select * from pos_teams where brancheid='$row->branche' and status=0";//echo $query."<br/>";
		mysql_query($query);
		if(mysql_affected_rows()>0){
		  $status=1;
		}
		
		$color="";
		if(empty($row->statusid))
		  $color="green";
	?>
		<tr style="color:<?php echo $color; ?>;">
			<td><?php echo $i; ?></td>
			<td><?php echo $row->brancheid; ?></td>
			<td><?php echo $row->shiftid; ?></td>
			<td><?php echo ($row->startedon); ?></td>
			<td><?php echo ($row->endedon); ?></td>
			<td><?php echo formatDate($row->teamedon); ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td>
			<a href="teams.php?brancheid=<?php echo $row->branche; ?>&did=<?php echo $row->id; ?>&status=<?php echo $row->statusid; ?>"><?php echo $row->status; ?></a>

			</td>
<?php
//Authorization.
$auth->roleid="11929";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td></td>
<?php
}
//Authorization.
$auth->roleid="11930";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td></td>
<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>
</form>
<?php
include"../../../foot.php";
?>
