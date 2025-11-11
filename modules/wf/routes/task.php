<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../pm/tasks/Tasks_class.php");
require_once("../../wf/routes/Routes_class.php");
require_once("../../wf/routedetails/Routedetails_class.php");
require_once("../../auth/rules/Rules_class.php");

include "../../../head.php";

$ob = (object)$_GET;

//get task wf
$tasks = new Tasks();
$fields="*";
$where=" where id='$ob->id' ";
$join="";
$having="";
$groupby="";
$orderby=" ";
$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$tasks = $tasks->fetchObject;

$routedetails = new Routedetails();
?>
<div class="span4 bd" style="margin-right:20px;">
<div class="ui-state-default" style="width:100%;align:center;">
<?php
$routes = new Routes();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$tasks->routeid'";
$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$routes = $routes->fetchObject;
echo "<h3>".formatNouns($routes->name)."</h3>";
?>
</div>
<ul id="tree" class="connectedSortable">
            <li id="start" class="ui-state-highlight margin">Start</li>
<?php
$fields=" wf_routedetails.routeid, hrm_assignments.name ";
$groupby="";
$join=" left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid ";
$where=" where wf_routedetails.routeid='$tasks->routeid' ";
$having="";
$orderedby="";
$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$num = $routedetails->affectedRows;


$i=0;
while($i<$num){
  $routedetails = new Routedetails();
  $fields=" wf_routedetails.id, wf_routedetails.routeid, hrm_assignments.id assignmentid, hrm_assignments.name, hrm_levels.name levelid, hrm_employees.firstname employeeid ";
  $groupby="";
  $join=" left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid left join hrm_levels on hrm_levels.id=wf_routedetails.levelid left join hrm_employees on hrm_employees.assignmentid=hrm_assignments.id ";
  $where=" where wf_routedetails.routeid='$tasks->routeid' and wf_routedetails.follows='$follows' ";
  $having="";
  $orderby="";
  $routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $row=$routedetails->fetchObject;
  
  $i++;
  $follows=$row->id;
  
  $style="";
  
  //check if the task has passed through the specific point to change styling
  $task = new Tasks();
  $fields="*";
  $where=" where origtask='$tasks->origtask' and assignmentid='$row->assignmentid' and statusid>3 ";
  $join="";
  $having="";
  $groupby="";
  $orderby=" ";
  $task->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $task->sql;
  if($task->affectedRows>0){//echo " Here ";
    $style=" style='background:red;' ";
  }
  
  //check if the task has passed through the specific point to change styling
  $task = new Tasks();
  $fields="*";
  $where=" where origtask='$tasks->origtask' and assignmentid='$row->assignmentid' and statusid<=3 ";
  $join="";
  $having="";
  $groupby="";
  $orderby=" ";
  $task->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $task->sql;
  if($task->affectedRows>0){//echo " Here ";
    $style=" style='background:green;' ";
  }
  
  //Authorization.
  $auth->roleid="7453";//View
  $auth->levelid=$_SESSION['level'];

?>
  <span class="down_arr">&downarrow;</span><li class="ui-state-default" <?php echo $style; ?> ><?php echo $row->name; ?><?php echo $row->levelid; ?><?php if(!empty($row->employeeid)){echo"($row->employeeid)";}?></li>
<?php
}
?>
<span class="down_arr">&downarrow;</span><li id="start" class="ui-state-highlight margin">Stop</li>
        </ul>
</div>