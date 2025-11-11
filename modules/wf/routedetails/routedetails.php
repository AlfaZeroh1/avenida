<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Routedetails_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../routes/Routes_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Routedetails";
//connect to db
$db=new DB();
//Authorization.
$auth->roleid="7451";//View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

$delid=$_GET['delid'];
$id=$_GET['id'];
$routedetails=new Routedetails();
if(!empty($delid)){
	$routedetail=new Routedetails();
	$where=" where routeid='$id' and id<'$delid' ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by id desc";
	$routedetail->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$routedetail = $routedetail->fetchObject;
	
	$routedt=new Routedetails();
	$where=" where routeid='$id' and id>'$delid' ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by id asc";
	$routedt->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$routedt = $routedt->fetchObject;
	$routedt->follows = $routedetail->id;
	
	$rt = new Routedetails();
	$rt = $rt->setObject($routedt);
	$rt->edit($rt);
	      
	$routedetails=new Routedetails();
	$routedetails->id=$delid;
	$routedetails->delete($routedetails);
	redirect("routedetails.php?id=".$id);
}

$routes = new Routes();
$fields=" * ";
$groupby="";
$join=" ";
$where=" where id='$id' ";
$having="";
$orderedby="";
$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$routes = $routes->fetchObject;

//Authorization.
$auth->roleid="7450";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
<div style="float:left;" class="buttons"> <input onclick="showPopWin('addroutedetails_proc.php?routeid=<?php echo $id; ?>',600,430);" value="Add Routedetails " type="button"/> &nbsp; <a href="../routes/route.php?id=<?php echo $id; ?>" class="btn btn-primary">View Chart</a></div>
<?php }?>
<div align="center"><h2><?php echo initialCap($routes->name);?></h2></div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Assignment </th>
			<th>Expected Stay </th>
			<th>Approval Stage</th>
			<th>Remarks </th>
<?php
//Authorization.
$auth->roleid="7452";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="7453";//View
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
		$fields=" wf_routedetails.routeid, hrm_assignments.name ";
		$groupby="";
		$join=" left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid ";
		$where=" where wf_routedetails.routeid='$id' ";
		$having="";
		$orderby="";
		$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num = $routedetails->affectedRows;


		$i=0;
		while($i<$num){
		  $routedetails = new Routedetails();
		  $fields=" wf_routedetails.id, wf_routedetails.employee, wf_routes.name routeid, wf_routedetails.approval, hrm_assignments.name assignmentid, hrm_levels.name levelid, wf_routedetails.expectedduration, wf_routedetails.durationtype, wf_routedetails.remarks ";
		  $groupby="";
		  $join=" left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid left join wf_routes on wf_routes.id=wf_routedetails.routeid left join hrm_levels on hrm_levels.id=wf_routedetails.levelid ";
		  $where=" where wf_routedetails.routeid='$id' and wf_routedetails.follows='$follows' ";
		  $having="";
		  $orderedby="";
		  $routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $row=$routedetails->fetchObject;
		  
		  $emp="";
		  
		  if(!empty($row->employee)){
		    $query="select group_concat(concat(hrm_employees.firstname,' ',concat(hrm_employees.lastname)) separator ' or ') names from hrm_employees where id in($row->employee)";
		    $emp = mysql_fetch_object(mysql_query($query));
		  }
		  
		  $i++;
		  $follows=$row->id;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->assignmentid; ?><?php echo $row->systemtaskid; ?><?php echo $row->levelid; ?> <?php if(!empty($emp->names))echo " - ".$emp->names; ?></td>
			<td><?php echo $row->expectedduration; ?>&nbsp;<?php echo $row->durationtype; ?></td>
			<td><?php echo $row->approval; ?></td>
			<td><?php echo $row->remarks; ?></td>
<?php
//Authorization.
$auth->roleid="7452";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href="javascript:;" onclick="showPopWin('addroutedetails_proc.php?id=<?php echo $row->id; ?>',600,430);">View</a></td>
<?php
}
//Authorization.
$auth->roleid="7453";//View
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<td><a href='routedetails.php?delid=<?php echo $row->id; ?>&id=<?php echo $routes->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
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
