<title>WiseDigits ERP: Tasks </title>
<?php 
include "../../../rptheader.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid").val(ui.item.id);
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
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	$('#tbl').dataTable( {
 		"sScrollY": 180,
 		"bJQueryUI": true,
 		"bSort":false,
 		"sPaginationType": "full_numbers"
 	} );
 } );
 </script>

<div class='main'>
<form  id="theform" action="addtasks_proc.php" name="tasks" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($objs->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $objs->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $objs->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Task Name : </td>
		<td><input type="text" name="name" id="name" size="45"  value="<?php echo $objs->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Task Description : </td>
		<td><textarea name="description"><?php echo $objs->description; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Project : </td>
		<td><input type="text" name="projectid" id="projectid" value="<?php echo $objs->projectid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Route : </td>
			<td><select name="routeid" class="selectbox">
<option value="">Select...</option>
<?php
	$routes=new Routes();
	$where="  ";
	$fields="wf_routes.id, wf_routes.name, wf_routes.moduleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($routes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($objs->routeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Project Type : </td>
		<td><select name='projecttype' class="selectbox">
			<option value='Tender' <?php if($objs->projecttype=='Tender'){echo"selected";}?>>Tender</option>
			<option value='Project' <?php if($objs->projecttype=='Project'){echo"selected";}?>>Project</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Responsible Person : </td>
			<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $objs->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $objs->employeeid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Assignment : </td>
			<td><input type='text' size='20' name='assignmentname' id='assignmentname' value='<?php echo $objs->assignmentname; ?>'>
			<input type="hidden" name='assignmentid' id='assignmentid' value='<?php echo $objs->assignmentid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Document Type : </td>
		<td><input type="text" name="documenttype" id="documenttype" value="<?php echo $objs->documenttype; ?>"></td>
	</tr>
	<tr>
		<td align="right">Document No : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $objs->documentno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Priority : </td>
		<td><select name='priority' class="selectbox">
			<option value='Low' <?php if($objs->priority=='Low'){echo"selected";}?>>Low</option>
			<option value='Normal' <?php if($objs->priority=='Normal'){echo"selected";}?>>Normal</option>
			<option value='High' <?php if($objs->priority=='High'){echo"selected";}?>>High</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Track Time Spent : </td>
		<td><select name='tracktime' class="selectbox">
			<option value='Yes' <?php if($objs->tracktime=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($objs->tracktime=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Required Duration : </td>
		<td><input type="text" name="reqduration" id="reqduration" value="<?php echo $objs->reqduration; ?>"></td>
	</tr>
	<tr>
		<td align="right">Required Duration Type : </td>
		<td><select name='reqdurationtype' class="selectbox">
			<option value='minutes' <?php if($objs->reqdurationtype=='minutes'){echo"selected";}?>>minutes</option>
			<option value='hours' <?php if($objs->reqdurationtype=='hours'){echo"selected";}?>>hours</option>
			<option value='days' <?php if($objs->reqdurationtype=='days'){echo"selected";}?>>days</option>
			<option value='weeks' <?php if($objs->reqdurationtype=='weeks'){echo"selected";}?>>weeks</option>
			<option value='months' <?php if($objs->reqdurationtype=='months'){echo"selected";}?>>months</option>
			<option value='years' <?php if($objs->reqdurationtype=='years'){echo"selected";}?>>years</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Deadline : </td>
		<td><input type="text" name="deadline" id="deadline" class="date_input" size="12" readonly  value="<?php echo $objs->deadline; ?>"></td>
	</tr>
	<tr>
		<td align="right">Start Date : </td>
		<td><input type="text" name="startdate" id="startdate" class="date_input" size="12" readonly  value="<?php echo $objs->startdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Start Time : </td>
		<td><input type="text" name="starttime" id="starttime" value="<?php echo $objs->starttime; ?>"></td>
	</tr>
	<tr>
		<td align="right">End Date : </td>
		<td><input type="text" name="enddate" id="enddate" class="date_input" size="12" readonly  value="<?php echo $objs->enddate; ?>"></td>
	</tr>
	<tr>
		<td align="right">End Time : </td>
		<td><input type="text" name="endtime" id="endtime" value="<?php echo $objs->endtime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Duration : </td>
		<td><input type="text" name="duration" id="duration" value="<?php echo $objs->duration; ?>"></td>
	</tr>
	<tr>
		<td align="right">Duration Type : </td>
		<td><select name='durationtype' class="selectbox">
			<option value='hours' <?php if($objs->durationtype=='hours'){echo"selected";}?>>hours</option>
			<option value='days' <?php if($objs->durationtype=='days'){echo"selected";}?>>days</option>
			<option value='weeks' <?php if($objs->durationtype=='weeks'){echo"selected";}?>>weeks</option>
			<option value='months' <?php if($objs->durationtype=='months'){echo"selected";}?>>months</option>
			<option value='years' <?php if($objs->durationtype=='years'){echo"selected";}?>>years</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Remind : </td>
		<td><input type="text" name="remind" id="remind" class="date_input" size="12" readonly  value="<?php echo $objs->remind; ?>"></td>
	</tr>
	<tr>
		<td align="right">Associated Task : </td>
		<td><input type="text" name="taskid" id="taskid" value="<?php echo $objs->taskid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
			<td><select name="statusid" class="selectbox">
<option value="">Select...</option>
<?php
	$taskstatuss=new Taskstatuss();
	$where="  ";
	$fields="pm_taskstatuss.id, pm_taskstatuss.name, pm_taskstatuss.remarks, pm_taskstatuss.ipaddress, pm_taskstatuss.createdby, pm_taskstatuss.createdon, pm_taskstatuss.lasteditedby, pm_taskstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$taskstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($taskstatuss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($objs->statusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $objs->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($objs->id)){?>
<?php }?>
	<?php if(!empty($objs->id)){?> 
<?php }?>
</table>
</form>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>