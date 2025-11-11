<title>WiseDigits ERP: Tasks </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#employeenames").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))&where=projectid=<?php echo $_SESSION['projectid'];?>",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeids").val(ui.item.id);
	}
  });

  $("#assignmentname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=assignments&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#assignmentid").val(ui.item.id);
	}
  });

});
<?php include'js.php'; ?>
</script>


<div class='main'>
<?php
//get module and role
$routes = new Routes();
$fields=" sys_modules.name moduleid, auth_roles.module module ";
$where=" where wf_routes.id='$objs->routeid'";
$join=" left join auth_roles on auth_roles.id=wf_routes.roleid left join sys_modules on sys_modules.id=wf_routes.moduleid ";
$having="";
$groupby="";
$orderby="";
$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$routes=$routes->fetchObject;

$href="../../$routes->moduleid/$routes->module/add".$routes->module."_proc.php?retrieve=1&documentno=".$objs->documentno."&procedure=1";



?>
<script type="text/javascript">
            $(document).ready(function(){
//                 $("#content").load("<?php echo $href; ?>");
            })
        </script>
<div id="content" style="width:80%;float:left;">
 <iframe style="width:100%; height:100%;align:center;" src="<?php echo $href; ?>"></iframe> 
</div>
<div style="width:20%;float:right;">
<form  id="theform" action="addtasks_proc.php" name="tasks" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<thead>
	
	</thead>
	<tbody>	
	
	<tr align="center">
	  <td colspan='' align="center">
	  <input type="hidden" name="id" id="id" value="<?php echo $objs->id; ?>">
		<input type="hidden" name="ownerid" id="ownerid" value="<?php echo $objs->ownerid; ?>">
	    <div class="span4 bd" style="margin-right:20px; align:center;">
	    <div class="ui-state-default" style="width:100%;align:center;">
	    </div>
	    <ul id="tree" class="connectedSortable">
	      <li id="start" class="ui-state-highlight margin">Start</li>
	      <?php
	      //retrieve task statuss
	      $tasktracks = new Tasktracks();
	      $fields="pm_taskstatuss.name statusid, hrm_assignments.name assignmentid, pm_tasktracks.changedon, pm_tasktracks.remarks";
	      $where=" where pm_tasktracks.origtask='$objs->origtask' and $objs->origtask!='' ";
	      $join=" left join pm_tasks on pm_tasks.id=pm_tasktracks.taskid left join pm_taskstatuss on pm_taskstatuss.id=pm_tasktracks.statusid left join hrm_assignments on hrm_assignments.id=pm_tasks.assignmentid ";
	      $having="";
	      $groupby="";
	      $orderby=" order by pm_tasktracks.changedon ";
	      $tasktracks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	      while($row=mysql_fetch_object($tasktracks->result)){
	      ?>
	      <span class="down_arr">&downarrow;</span><li class="ui-state-default"><?php echo $row->assignmentid; ?>  <?php echo $row->changedon; ?> => <font color="blue"><?php echo $row->statusid; ?></font></li>
	      <li ><?php echo $row->remarks; ?> </li>
		
	      <?
	      }
	      ?>
	    <span class="down_arr">&downarrow;</span><li id="start" class="ui-state-highlight margin">Stop</li>
        </ul>
        </div>
	  </td>
	</tr>
	
	<?php if($objs->statusid>2){?>
	<tr>
	  <td align="right" style="font-weight:bold;">Remarks:<textarea class="ckeditor" name="remarks"><?php echo $objs->remarks; ?></textarea>
	</tr>
	<?php }?>
	
	<tr>
		<td align="center">
		<?php if($objs->statusid<3){?>
		<input type="submit" class="btn btn-warning" name="actions" id="actions" value="Start">&nbsp;
<!-- 		<input type="submit" class="btn btn-primary" name="actions" id="actions" value="Delegate">&nbsp; -->
<!-- 		<input type="submit" class="btn btn-success" name="actions" id="actions" value="Push Up to Supervisor">&nbsp; -->
		<?php }else{?>
		<?if($objs->statusid<5 and $objs->routeid>0){?>
		<input type="submit" class="btn btn-success" name="actions" id="actions" value="Approve">&nbsp;
<!-- 		<input type="submit" class="btn btn-primary" name="actions" id="actions" value="Send Back">&nbsp; -->
		<input type="submit" class="btn btn-danger" name="actions" id="actions" value="Decline">&nbsp;
		<?php }else{
		?>
<!-- 		<input type="submit" class="btn btn-primary" name="actions" id="actions" value="Send Back">&nbsp; -->
<!-- 		<input type="submit" class="btn btn-primary" name="actions" id="actions" value="Send Up">&nbsp; -->
		<?php
		if($objs->statusid<8 and $objs->statusid!=5){?>
		<input type="submit" class="btn btn-warning" name="actions" id="actions" value="Finish">
		<?php
		}
		}
		}
		?>
		</td>
	</tr>
	<!--<tr class="yellow">
	  <td colspan="2" align="center">
	    <input type="text" name="employeenames" id="employeenames" value="<?php echo $objs->employeenames; ?>"/>
	    <input type="text" name="employeeids" id="employeeids" value="<?php echo $objs->employeeids; ?>"/>
	  </td>
	</tr>-->
	
	
	
<?php if(!empty($objs->id)){?>
<?php }?>
	<?php if(!empty($objs->id)){?> 
<?php }?>
</tbody>
</table>
</form>
</div>
<?php 
if(!empty($error)){
	showError($error);
}
?>