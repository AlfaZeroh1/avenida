<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../routedetails/Routedetails_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("Routes_class.php");
require_once("../../hrm/assignments/Assignments_class.php");
require_once("../../sys/modules/Modules_class.php");
require_once("../../pm/tasks/Tasks_class.php");


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

<link rel="stylesheet" href="../../../css/jquery-ui-1.10.4.custom.min.css"/>
<!--<link rel="stylesheet" href="../../../css/bootstrap.min.css"/>-->

<style>
  #mods, #tree {margin-right:10px;}
  #mods li, #tree li { margin: 20px 5px 5px 5px; padding: 5px; font-size: 12px; }
  #mods{
      padding:5px;
      border-radius: 4px;
      min-height: 130px;
      border: #ccc thin solid;
  }
  .bd{
  padding:4px;
      border-radius: 4px;
      min-height: 130px;
      border: #ccc thin solid;
  font-size: 0.8em;
  }
  .down_arr{
      margin-left: 40%;
  }
  
  .span9{
  background-color: #F5F5F5;
  }
</style>


<a class="btn btn-primary" href="javascript:;" onclick="showPopWin('addroutes_proc.php',420,340);">Add Route</a>
<hr>
  

   <table width="100%" >
   <tr>
   <td style="vertical-align:top;">
<div class="span4 bd"><input type="hidden" name="routeid" id="routeid" value="<?php echo $ob->id; ?>"/>
<ul>
<?php

$modules = new Modules();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where="";
$modules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

while($rw=mysql_fetch_object($modules->result)){
  
  $routes = new Routes();
$fields="wf_routes.id, wf_routes.name, sys_modules.name as moduleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
$join=" left join sys_modules on wf_routes.moduleid=sys_modules.id ";
$having="";
$groupby="";
$orderby="";
$where=" where sys_modules.id='$rw->id' ";
$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$res=$routes->result;
if($routes->affectedRows>0){
?>
  <li class="ui-state-default"><?php echo $rw->description; ?></li>
  <ol>
  <?php
while($row=mysql_fetch_object($res)){
  ?>
  <li><a href="route.php?id=<?php echo $row->id; ?>"><?php echo initialCap($row->name);?></a> <a href="javascript:;" onclick="showPopWin('addroutes_proc.php?id=<?php echo $row->id; ?>',600,430);">&nbsp;<i class="fa fa-edit"></i>&nbsp;</a>&nbsp;<a href="../routedetails/routedetails.php?id=<?php echo $row->id; ?>" target="_blank" class="fa fa-book"></a></li>
  
  <?php
}
?>
</ol>
<?php
}
}
?>
</ul>
</div>
  </td>
  <td style="vertical-align:top;">
<div class="span4 bd" style="margin-right:20px;">
<div class="ui-state-default" style="width:100%;align:center;">
<?php
$routes = new Routes();
$fields="*";
$join="";
$having="";
$groupby="";
$orderby="";
$where=" where id='$ob->id'";
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
$where=" where wf_routedetails.routeid='$ob->id' ";
$having="";
$orderedby="";
$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$num = $routedetails->affectedRows;


$i=0;
while($i<$num){
  $routedetails = new Routedetails();
  $fields=" wf_routedetails.id, wf_routedetails.routeid, hrm_assignments.name, hrm_levels.name levelid, hrm_employees.firstname employeeid, wf_routedetails.employee ";
  $groupby="";
  $join=" left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid left join hrm_levels on hrm_levels.id=wf_routedetails.levelid left join hrm_employees on hrm_employees.assignmentid=hrm_assignments.id ";
  $where=" where wf_routedetails.routeid='$ob->id' and wf_routedetails.follows='$follows' ";
  $having="";
  $orderby="";
  $routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $row=$routedetails->fetchObject;
  
  $emp="";
		  
  if(!empty($row->employee)){
    $query="select group_concat(concat(hrm_employees.firstname,' ',concat(hrm_employees.lastname)) separator ' or ') names from hrm_employees where id in($row->employee)";
    $emp = mysql_fetch_object(mysql_query($query));
  }
  
  $i++;
  $follows=$row->id;
  
  //Authorization.
  $auth->roleid="7453";//View
  $auth->levelid=$_SESSION['level'];

  if(existsRule($auth)){
?>
  <span class="down_arr">&downarrow;</span><li class="ui-state-default"><?php echo $row->name; ?><?php echo $row->levelid; ?><?php if(!empty($emp->names)){echo " - ".$emp->names;}else{if(!empty($row->employeeid)){echo"($row->employeeid)";}}?></li>
<?php
  }
}
?>
<span class="down_arr">&downarrow;</span><li id="start" class="ui-state-highlight margin">Stop</li>
        </ul>
</div>
</td>
<td style="vertical-align:top;">
<div style="float:center;">
<div class="span4">

<ul id="mods" class=""  style="height:750px;">
  <?php
//   $assignments = new Assignments();
//   $fields="hrm_assignments.id, hrm_assignments.name, hrm_employees.firstname employeeid";
//   $where=" ";
//   $orderby="";
//   $groupby="";
//   $join=" left join hrm_employees on hrm_employees.assignmentid=hrm_assignments.id ";
//   $assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
//   while ($row=mysql_fetch_object($assignments->result)) {
//   
//       echo '<li id="' . $row->id . '" class="ui-state-default"><i class="fa fa-user"></i>&nbsp;' . $row->name;
//       if(!empty($row->employeeid))
// 	echo '&nbsp;('.$row->employeeid.')';
//       echo '</li>';
//   }
?>
<li class="ui-state-default">My Tasks</li>
<?php
//retrieve my tasks
$tasks = new Tasks();
$fields="*";
if($_SESSION['level']==1){
  if(!empty($ob->id)) 
    $where=" where routeid='$ob->id' ";
  else
    $where="";

}else{
 $where=" where pm_tasks.employeeid in(select employeeid from auth_users where id='".$_SESSION['userid']."') ";
 if(!empty($ob->id)) 
   $where.=" and routeid='$ob->id' ";
}
$join="";
$having="";
$groupby="";
$orderby=" order by createdon desc ";
$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
while($row=mysql_fetch_object($tasks->result)){
?>
  <li id="<?php echo $row->id; ?>" class="ui-state-default"><i class="fa fa-user"></i>&nbsp;<a href="task.php?id=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></li>
<?php
}
  ?>
</ul>
</div>
</div>
</td>
</tr>
</table>

<script src="../../../js/jquery-2.1.0.min.js"></script>
    <script src="../../../js/jquery-ui-1.10.4.custom.min.js"></script>

    <script>
        jQuery(function() {
            var sender = null;
            var tree = '';
            var picked = 1;
            $("#tree").sortable({
                cancel: ".margin"
            });
            $("#mods, #tree").sortable({
                connectWith: ".connectedSortable",
                receive: function(event, ui) {
                    sender = ui.sender.attr('id');
                },
                stop: function(event, ui) {
                    if (sender !== 'mods')
                        sender = ui.sender;
                    do_post(ui, this.id);
                }
            }).disableSelection();

            function do_post(ui, id) {
                $('#tree li.ui-state-default').each(function() {
                    tree += $(this).text() + ',';
                });
                var routeid = "<?php echo $ob->id; ?>";
                if (sender !== null)
                {
                    picked = 1;
                    
                    $.post('save.php', {routeid: routeid,id:"<?php echo $ob->id; ?>",action:"Save",tp:1, picked: picked, name: ui.item[0].innerHTML, tree: tree}, function(data) {
                        refreshTree(data);
                    });
                } else {
                    picked = 0;
                    $.post('save.php', {routeid: routeid, id:"<?php echo $ob->id; ?>", picked: picked, name: ui.item[0].innerHTML, tree: tree}, function(data) {
                        refreshTree(data);
                    });
                }
                sender = null;
                tree = '';
            }

            function refreshTree(data) {
                $('#tree').html(data);
            }
        });
    </script>