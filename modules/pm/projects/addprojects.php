<title>WiseDigits ERP: Projects </title>
<?php 
include "../../../head.php";

?>
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

<script type="text/javascript">
$().ready(function() {
  $("#employeesemployeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeesemployeeid").val(ui.item.id);
	}
  });

  $("#employeesemployeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeesemployeeid").val(ui.item.id);
	}
  });

});
</script>
<div class="tabbable">

	<ul class="nav nav-tabs">
		<li><a href="#pane1" data-toggle="tab">DETAILS</a></li>
		<li><a href="#pane2" data-toggle="tab">TEAMS</a></li>
		<li><a href="#pane3" data-toggle="tab">DOCUMENTS</a></li>
		<li><a href="#pane4" data-toggle="tab">TASKS</a></li>
		<li><a href="#pane4" data-toggle="tab">TASKS</a></li>
		
	</ul>
	<div class="tab-content">
	  <div id="pane1" class="tab-pane active">
<form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Customer : </td>
			<td><select name="customerid" class="selectbox">
<option value="">Select...</option>
<?php
	$customers=new Customers();
	$where="  ";
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($customers->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->customerid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Customer Project : </td>
		<td><textarea name="name"><?php echo $obj->name; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Project Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Start Date : </td>
		<td><input type="text" name="startdate" id="startdate" class="date_input" size="12" readonly  value="<?php echo $obj->startdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expected Completion Date : </td>
		<td><input type="text" name="expectedcompletion" id="expectedcompletion" class="date_input" size="12" readonly  value="<?php echo $obj->expectedcompletion; ?>"></td>
	</tr>
	<tr>
		<td align="right">Actual Completion Date : </td>
		<td><input type="text" name="actualcompletion" id="actualcompletion" class="date_input" size="12" readonly  value="<?php echo $obj->actualcompletion; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	
	</table>
		</form>
<div style="clear:both;"></div>
	</div>

	<?php if(!empty($obj->id)){?> 
	  <div id="pane2" class="tab-pane active">
<form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
		<table align='left'>
			<tr>
				<td>&nbsp;</td>
				<td valign="bottom">Employee :<input type='text' size='20' name='projectteamsemployeename' id='projectteamsemployeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='projectteamsemployeeid' id='projectteamsemployeeid' value='<?php echo $obj->field; ?>'></td>
				<td valign="bottom">Position : <select name='projectteamsteampositionid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$teampositions=new Teampositions();
				$fields="pm_teampositions.id, pm_teampositions.name, pm_teampositions.remarks, pm_teampositions.ipaddress, pm_teampositions.createdby, pm_teampositions.createdon, pm_teampositions.lasteditedby, pm_teampositions.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$teampositions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($teampositions->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->teampositionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">Remarks : <textarea name="projectteamsremarks"><?php echo $obj->projectteamsremarks; ?></textarea></td>
				<td valign="bottom"><input type="submit" value="Add Projectteam" name="action"></td>
			</tr>
<?php
		$projectteams=new Projectteams();
		$i=0;
		$fields="pm_projectteams.id, pm_projects.name as projectid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, pm_teampositions.name as teampositionid, pm_projectteams.remarks, pm_projectteams.ipaddress, pm_projectteams.createdby, pm_projectteams.createdon, pm_projectteams.lasteditedby, pm_projectteams.lasteditedon";
		$join=" left join pm_projects on pm_projectteams.projectid=pm_projects.id  left join hrm_employees on pm_projectteams.employeeid=hrm_employees.id  left join pm_teampositions on pm_projectteams.teampositionid=pm_teampositions.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pm_projectteams.projectid='$obj->id'";
		$projectteams->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$projectteams->affectedRows;
		$res=$projectteams->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->employeeid; ?></td>
				<td><?php echo $row->teampositionid; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addprojects_proc.php?id=<?php echo $obj->id; ?>&projectteams=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
		</table>
		</form>
<div style="clear:both;"></div>
</div>
<?php }?>
<?php if(!empty($obj->id)){?> 
<div id="pane3" class="tab-pane">
<form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
		<table align='left'>
			<tr>
				<td>&nbsp;</td>
				<td valign="bottom">Document  Type : <select name='projectdocumentsdocumenttypeid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$documenttypes=new Documenttypes();
				$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($documenttypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->documenttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">Title : <input type="text"  name="projectdocumentstitle" size="20" /></td>
				<td valign="bottom">File : <input type="file" name="projectdocumentsfile" size="20" ></td>
				<td valign="bottom">Date Of Upload : <input type="text" name="projectdocumentsuploadedon" size="16" class="date_input"></td>
				<td valign="bottom">Type :<select name='type' class="selectbox">
					<option value='in' <?php if($obj->type=='in'){echo"selected";}?>>in</option>
					<option value='out' <?php if($obj->type=='out'){echo"selected";}?>>out</option>
					</select>
				<td valign="bottom">Remarks : <textarea name="projectdocumentsremarks"><?php echo $obj->projectdocumentsremarks; ?></textarea></td>
				<td valign="bottom"><input type="submit" value="Add Projectdocument" name="action"></td>
			</tr>
<?php
		$projectdocuments=new Projectdocuments();
		$i=0;
		$fields="pm_projectdocuments.id, pm_projects.name as projectid, dms_documenttypes.name as documenttypeid, pm_projectdocuments.file, pm_projectdocuments.uploadedon, pm_projectdocuments.type, pm_projectdocuments.remarks, pm_projectdocuments.ipaddress, pm_projectdocuments.createdby, pm_projectdocuments.createdon, pm_projectdocuments.lasteditedby, pm_projectdocuments.lasteditedon";
		$join=" left join pm_projects on pm_projectdocuments.projectid=pm_projects.id  left join dms_documenttypes on pm_projectdocuments.documenttypeid=dms_documenttypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pm_projectdocuments.projectid='$obj->id'";
		$projectdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$projectdocuments->affectedRows;
		$res=$projectdocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->documenttypeid; ?></td>
				<td><a href="files/<?php echo $row->file; ?>"><?php echo $row->file; ?></a></td>
				<td><?php echo $row->uploadedon; ?></td>
				<td><?php echo $row->type; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addprojects_proc.php?id=<?php echo $obj->id; ?>&projectdocuments=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
		</form>
<div style="clear:both;"></div>
</div>
<?php }?>
<?php if(!empty($obj->id)){?> 
<div id="pane4" class="tab-pane">
<form  id="theform" action="addprojects_proc.php" name="projects" method="POST" enctype="multipart/form-data">
		<table align='left'>
			<tr>
				<td>&nbsp;</td>
				<td valign="bottom">Description : <textarea name="tasksdescription"><?php echo $obj->tasksdescription; ?></textarea></td>
				<td valign="bottom">Employee :<input type='text' size='20' name='tasksemployeename' id='tasksemployeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='tasksemployeeid' id='tasksemployeeid' value='<?php echo $obj->field; ?>'></td>
				<td valign="bottom">Name : <input type="text" name="tasksname" size="20" ></td>
				<td valign="bottom">Duration : <input type="text" name="tasksduration" size="16" ></td>
				<td valign="bottom">Duration Type :<select name='durationtype' class="selectbox">
					<option value='hours' <?php if($obj->durationtype=='hours'){echo"selected";}?>>hours</option>
					<option value='days' <?php if($obj->durationtype=='days'){echo"selected";}?>>days</option>
					<option value='weeks' <?php if($obj->durationtype=='weeks'){echo"selected";}?>>weeks</option>
					<option value='months' <?php if($obj->durationtype=='months'){echo"selected";}?>>months</option>
					<option value='years' <?php if($obj->durationtype=='years'){echo"selected";}?>>years</option>
					</select>
				<td valign="bottom">Deadline : <input type="text" name="tasksdeadline" size="16" class="date_input"></td>
				<td valign="bottom"><input type="submit" value="Add Task" name="action"></td>
			</tr>
<?php
		$tasks=new Tasks();
		$i=0;
		$fields="pm_tasks.id, pm_tasks.name, pm_tasks.tasktype, pm_tasks.description, pm_projects.name as projectid, wf_routes.name as routeid, pm_tasks.routedetailid, pm_tasks.projecttype, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, pm_tasks.ownerid, hrm_assignments.name as assignmentid, pm_tasks.documenttype, pm_tasks.documentno, pm_tasks.priority, pm_tasks.tracktime, pm_tasks.reqduration, pm_tasks.reqdurationtype, pm_tasks.deadline, pm_tasks.startdate, pm_tasks.starttime, pm_tasks.enddate, pm_tasks.endtime, pm_tasks.duration, pm_tasks.durationtype, pm_tasks.remind, pm_tasks.taskid, pm_tasks.origtask, pm_taskstatuss.name as statusid, pm_tasks.ipaddress, pm_tasks.createdby, pm_tasks.createdon, pm_tasks.lasteditedby, pm_tasks.lasteditedon";
		$join=" left join pm_projects on pm_tasks.projectid=pm_projects.id  left join wf_routes on pm_tasks.routeid=wf_routes.id  left join hrm_employees on pm_tasks.employeeid=hrm_employees.id  left join hrm_assignments on pm_tasks.assignmentid=hrm_assignments.id  left join pm_taskstatuss on pm_tasks.statusid=pm_taskstatuss.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where pm_tasks.projectid='$obj->id'";
		$tasks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$tasks->affectedRows;
		$res=$tasks->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->description; ?></td>
				<td><?php echo $row->employeeid; ?></td>
				<td><?php echo $row->name; ?></td>
				<td><?php echo $row->duration; ?></td>
				<td><?php echo $row->durationtype; ?></td>
				<td><?php echo $row->deadline; ?></td>
				<td><a href='addprojects_proc.php?id=<?php echo $obj->id; ?>&tasks=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
</table>
</form>
<?php }?>
</table>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>