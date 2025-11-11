<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeleaveapplications_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../../hrm/leaveextensions/Leaveextensions_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Employeeleaveapplications";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="4230";//View
$auth->levelid=$_SESSION['level'];

$obj=(object)$_POST;

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$employeeleaveapplications=new Employeeleaveapplications();
if(!empty($delid)){
	$employeeleaveapplications->id=$delid;
	$employeeleaveapplications->delete($employeeleaveapplications);
	redirect("employeeleaveapplications.php");
}
if(empty($obj->action)){
  $obj->todate=date('Y-m-d');
  $obj->fromdate=date("Y-m-d",mktime(0,0,0,date('m',strtotime($obj->todate)),date('d',strtotime($obj->todate))-30,date('Y',strtotime($obj->todate))));
}
$track=0;

if(!empty($obj->fromdate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeeleaveapplications.appliedon>='$obj->fromdate'";
	$track++;
}
if(!empty($obj->todate)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeeleaveapplications.appliedon<='$obj->todate'";
	$track++;
}
if(!empty($obj->status)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeeleaveapplications.status='$obj->status'";
	$track++;
}

//Authorization.
$auth->roleid="4229";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<!--<div style="float:left;" class="buttons"> <input class="btn btn-info" onclick="showPopWin('addemployeeleaveapplications_proc.php',600,430);" value="NEW" type="button"/></div>-->
<?php }?>

 <form action="" method="post">
  <table class="table">
    <tr>
      <td align="right">Status: </td>
      <td><select name="status" class="selectbox">
	<option value="">ALL</option>
	<option value="pending" <?php if($obj->status=='pending'){echo "selected";}?>>Pending</option>
	<option value="declined" <?php if($obj->status=='declined'){echo "selected";}?>>Declined</option>
	<option value="granted" <?php if($obj->status=='granted'){echo "selected";}?>>Granted</option>
	<option value="sent back" <?php if($obj->status=='sent back'){echo "selected";}?>>Sent back</option>
      </select></td>
      <td align="right">From:</td>
      <td> <input type="text" size="12" class="date_input" readonly name="fromdate" value="<?php echo $obj->fromdate; ?>"/></td>
      <td>To:</td>
      <td> <input type="text" size="12" class="date_input" readonly name="todate" value="<?php echo $obj->todate; ?>"/> </td>
      <td><input type="submit" class="btn btn-primary" name="action" value="Filter"/></td>
    </tr>
  </table>
 </form>
<table style="clear:both;"  class="table display" width="100%">
	<thead>
		<tr>
			<th>#</th>
			<th>Employee </th>
			<th>Employee Incharge </th>
			<th>Leave Type </th>
			<th>Start Date </th>
			<th>Duration (Working Days) </th>
			<th>Date Applied </th>
			<th>Status </th>
			<th>Remarks </th>
			<th>Type </th>
<?php
//Authorization.
$auth->roleid="4231";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4232";//View
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
		$fields="hrm_employeeleaveapplications.id, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, concat(hr.firstname,' ',concat(hr.middlename,' ',hr.lastname)) as employeeid1, hrm_leavetypes.name as leavetypeid, hrm_employeeleaveapplications.startdate, hrm_employeeleaveapplications.duration, hrm_employeeleaveapplications.appliedon, hrm_employeeleaveapplications.status, hrm_employeeleaveapplications.remarks, hrm_employeeleaveapplications.createdby, hrm_employeeleaveapplications.createdon, hrm_employeeleaveapplications.lasteditedby, hrm_employeeleaveapplications.lasteditedon, hrm_employeeleaveapplications.ipaddress, hrm_employeeleaveapplications.type";
		$join=" left join hrm_employees on hrm_employeeleaveapplications.employeeid=hrm_employees.id  left join hrm_leavetypes on hrm_employeeleaveapplications.leavetypeid=hrm_leavetypes.id left join hrm_employees hr on hrm_employeeleaveapplications.employeeid1=hr.id ";
		$having="";
		$groupby="";
		$orderby="";
		if($_SESSION['brancheid']!=6){
		        if(!empty($rptwhere))
		                 $where=$rptwhere." and ";
		        else 
		                 $where=" where ";
			$where.=" hrm_employees.brancheid='".$_SESSION['brancheid']."' ";
		}else{
		        $where=$rptwhere;
		}
		$employeeleaveapplications->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeeleaveapplications->result;
		while($row=mysql_fetch_object($res)){
		$i++;
		      $leaveextensions = new Leaveextensions();
		      $fields=" case when sum(days) is null then 0 else sum(days) end days";
		      $where=" where employeeleaveapplicationid='$row->id' and type='Extension' ";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $leaveextensions->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $employeeleavedays->sql;
		      $leaveextensions=$leaveextensions->fetchObject;
		      
		      $leaveextension = new Leaveextensions();
		      $fields=" case when sum(days) is null then 0 else sum(days) end days";
		      $where=" where employeeleaveapplicationid='$row->id' and type='Recalling' ";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $leaveextension->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $employeeleavedays->sql;
		      $leaveextension=$leaveextension->fetchObject;
		      
		      $row->duration=$row->duration+$leaveextensions->days-$leaveextension->days;
		
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->employeeid; ?></td>
			<td><?php echo $row->employeeid1; ?></td>
			<td><?php echo $row->leavetypeid; ?></td>
			<td><?php echo formatDate($row->startdate); ?></td>
			<td><?php echo $row->duration; ?></td>
			<td><?php echo formatDate($row->appliedon); ?></td>
			<td><?php echo $row->status; ?></td>
			<td><?php echo $row->remarks; ?></td>
			<td><?php echo $row->type; ?></td>
<?php
//Authorization.
$auth->roleid="4231";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addemployeeleaveapplications_proc.php?id=<?php echo $row->id; ?>',600,430);"><img src='../../../dmodal/view.png' alt='view' title='view' /></a></td>
<?php
}
//Authorization.
$auth->roleid="4232";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><?php if($row->status=='granted') { ?><a href="javascript:;" onclick="showPopWin('../leaveextensions/addleaveextensions_proc.php?employeeleaveapplicationid=<?php echo $row->id; ?>',600,430);">Extend or Recall</a>
			<?php }else{?>&nbsp;<?php } ?></td>
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
