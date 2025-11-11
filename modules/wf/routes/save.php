<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../routedetails/Routedetails_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("Routes_class.php");
require_once("../../hrm/assignments/Assignments_class.php");
require_once("../../sys/modules/Modules_class.php");
require_once("../../hrm/assignments/Assignments_class.php");
require_once("../../wf/routes/Routes_class.php");
require_once("../../wf/systemtasks/Systemtasks_class.php");
require_once("../../hrm/levels/Levels_class.php");
require_once("../../hrm/departments/Departments_class.php");

$ob = (object)$_POST;
	
?>
<div class='main'>
<form  id="theform" action="addroutedetails_proc.php" name="routedetails" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
				<input type="hidden" name="routeid" value="<?php echo $ob->routeid; ?>"/>
				<input type="hidden" name="levelid" value="<?php echo $ob->levelid; ?>"/>
				<input type="hidden" name="assignmentid" value="<?php echo $ob->assignmentid; ?>"/>
				<input type="hidden" name="follows" value="<?php echo $ob->follows; ?>"/></td>
	</tr>
	
	<tr>
		<td align="right">Expected Stay : </td>
		<td><input type="text" name="expectedduration" id="expectedduration" size="8"  value="<?php echo $obj->expectedduration; ?>"></td>
	</tr>
	<tr>
		<td align="right">Duration Type : </td>
		<td><select name='durationtype' class="selectbox">
			<option value='Hrs' <?php if($obj->durationtype=='Hrs'){echo"selected";}?>>Hrs</option>
			<option value='Days' <?php if($obj->durationtype=='Days'){echo"selected";}?>>Days</option>
			<option value='Weeks' <?php if($obj->durationtype=='Weeks'){echo"selected";}?>>Weeks</option>
			<option value='Months' <?php if($obj->durationtype=='Months'){echo"selected";}?>>Months</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" class="btn btn-primary" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-cancel" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>
<ul id="tree" class="connectedSortable">
            <li id="start" class="ui-state-highlight margin">Start</li>
<?php
$routedetails = new Routedetails();
$fields=" wf_routedetails.routeid, hrm_assignments.name ";
$groupby="";
$join=" left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid ";
$where=" where wf_routedetails.routeid='$ob->routeid' ";
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
  $where=" where wf_routedetails.routeid='$ob->routeid' and follows='$follows' ";
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
  <span class="down_arr">&downarrow;</span><li class="ui-state-default"><?php echo $row->name; ?></li>
<?php
  }
}
?>
<span class="down_arr">&downarrow;</span><li id="start" class="ui-state-highlight margin">Stop</li>
        </ul>