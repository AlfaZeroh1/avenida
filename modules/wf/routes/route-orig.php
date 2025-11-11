<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../routedetails/Routedetails_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("Routes_class.php");
require_once("../../hrm/assignments/Assignments_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

$page_title="Routes";
//connect to db
$db=new DB();

$ob=(object)$_GET;

if(!empty($ob->rid)){

	$routedetails=new Routedetails();
	$fields=" * ";
	$groupby="";
	$join="  ";
	$where=" where id='$ob->rid' ";
	$having="";
	$orderedby="";
	$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$routedetails = $routedetails->fetchObject;
	
	$follows = $routedetails->follows;
	
	$routedetails=new Routedetails();
	$fields=" * ";
	$groupby="";
	$join="  ";
	$where=" where follows='$ob->rid' ";
	$having="";
	$orderedby="";
	$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$routedetails = $routedetails->fetchObject;
	
	$routedetails->follows=$follows;
	
	$rt = new Routedetails();
	$rt->setObject($routedetails);
	$rt->edit($rt);
	      
	$routedetails = new Routedetails();
	$routedetails->id=$ob->rid;
	$routedetails->delete($routedetails);
	
	redirect("route.php?id=".$ob->id);
}

$routedetails = new Routedetails();

include"../../../head.php";

?>

<style>
  #mods, #tree { list-style-type: none; margin: 0; padding: 0 0 2.5em; float: left; margin-right: 10px; }
  #mods li, #tree li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px; }
  #mods{
      width: 130px;
      min-height: 130px;
      border: black thin solid;
  }
  .down_arr{
      margin-left: 40%;
  }
</style>
<div class="container">
<div>
<a class="btn btn-lg" href="javascript:;" onclick="showPopWin('../routedetails/addroutedetails_proc.php?routeid=<?php echo $ob->id; ?>',600,530);"><i class="fa fa-plus"> Add Detail</i></a>
</div>
<div class="span4" style="margin-top:50px;">
<?php
$routes = new Routes();
$fields="wf_routes.id, wf_routes.name, sys_modules.name as moduleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
$join=" left join sys_modules on wf_routes.moduleid=sys_modules.id ";
$having="";
$groupby="";
$orderby="";
$where="";
$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$res=$routes->result;
while($row=mysql_fetch_object($res)){
  ?>
  <li><a href="route.php?id=<?php echo $row->id; ?>"><?php echo initialCap($row->name);?></a></li>
  <?php
}
?>
</div>
<div class="span4">
<ul style="list-style-type:none;text-align:center;">
<li>
<strong>Start</strong><br /><i class="fa fa-arrow-down"></i>
</li>
<?php
$fields=" wf_routedetails.routeid, hrm_assignments.name ";
$groupby="";
$join=" left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid ";
$where=" where wf_routedetails.routeid='$ob->id' ";
$having="";
$orderedby="";
$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$num = $routedetails->affectedRows;


$i=0;
while($i<$num){
  $routedetails = new Routedetails();
  $fields=" wf_routedetails.id, wf_routedetails.routeid, hrm_assignments.name ";
  $groupby="";
  $join=" left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid ";
  $where=" where wf_routedetails.routeid='$ob->id' and follows='$follows' ";
  $having="";
  $orderby="";
  $routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $row=$routedetails->fetchObject;
  
  $i++;
  $follows=$row->id;
  
  //Authorization.
  $auth->roleid="7453";//View
  $auth->levelid=$_SESSION['level'];

  if(existsRule($auth)){
?>
  <li><strong><span style="font:'tahoma';"><?php echo $row->name; ?></span> <a href='route.php?rid=<?php echo $row->id; ?>&id=<?php echo $row->routeid; ?>' style="font-size:10px;" onclick="return confirm('Are you sure you want to remove?')">Del</a><br />  <i class="fa fa-arrow-down"></i></strong></li>
<?php
  }
}
?>
<li><strong>End</strong></li>
</ul>
</div>
<div>
<ul id="mods" class="connectedSortable">
  <?php
  $assignments = new Assignments();
  $fields="*";
  $where="";
  $orderby="";
  $groupby="";
  $join="";
  $assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  while ($row=mysql_fetch_object($assignments->result)) {
      echo '<li id="' . $row->id . '" class="ui-state-default">' . $row->name . '</li>';
  }
  ?>
</ul>
</div>
</div>