<title>WiseDigits ERP: Projectworkschedules </title>
<?php 
$pop=1;
include "../../../head.php";

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

});
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
<form  id="theform" action="addprojectworkschedules_proc.php" name="projectworkschedules" method="POST" enctype="multipart/form-data">
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
		<td align="right">BoQ Item : </td>
			<td><select name="projectboqid" class="selectbox">
<option value="">Select...</option>
<?php
	$projectboqs=new Projectboqs();
	$where="  ";
	$fields="con_projectboqs.id, con_projectboqs.billofquantitieid, con_projectboqs.name, con_projectboqs.quantity, con_projectboqs.unitofmeasureid, con_projectboqs.bqrate, con_projectboqs.total, con_projectboqs.remarks, con_projectboqs.ipaddress, con_projectboqs.createdby, con_projectboqs.createdon, con_projectboqs.lasteditedby, con_projectboqs.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectboqs->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($projectboqs->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->projectboqid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Person Responsible : </td>
			<td><input type='text' size='34' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Project Week : </td>
		<td><select name="projectweek" id="projectweek" class="selectbox">
        <option value="">Select...</option>
        <?php
        $i=1;
        while($i<53){
        ?>
        <option value="<?php echo $i; ?>" <?php if($obj->projectweek==$i){echo"selected";}?>>WK <?php echo $i; ?></option>
        <?php
        $i++;
        }
        ?>
      </select><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Calendar Week : </td>
		<td><select name="week" id="week" class="selectbox">
        <option value="">Select...</option>
        <?php
        $i=1;
        while($i<53){
        ?>
        <option value="<?php echo $i; ?>" <?php if($obj->week==$i){echo"selected";}?>>WK <?php echo $i; ?></option>
        <?php
        $i++;
        }
        ?>
      </select><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><select name="year" id="year" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select></td>
	</tr>
	<tr>
		<td align="right">Priority : </td>
		<td><select name='priority' class="selectbox">
			<option value='Low' <?php if($obj->priority=='Low'){echo"selected";}?>>Low</option>
			<option value='Normal' <?php if($obj->priority=='Normal'){echo"selected";}?>>Normal</option>
			<option value='High' <?php if($obj->priority=='High'){echo"selected";}?>>High</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Track Time : </td>
		<td><select name='tracktime' class="selectbox">
			<option value='Yes' <?php if($obj->tracktime=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->tracktime=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Required Duration : </td>
		<td><input type="text" name="reqduration" id="reqduration" value="<?php echo $obj->reqduration; ?>"></td>
	</tr>
	<tr>
		<td align="right">Req Duration Type : </td>
		<td><select name='reqdurationtype' class="selectbox">
			<option value='minutes' <?php if($obj->reqdurationtype=='minutes'){echo"selected";}?>>minutes</option>
			<option value='hours' <?php if($obj->reqdurationtype=='hours'){echo"selected";}?>>hours</option>
			<option value='days' <?php if($obj->reqdurationtype=='days'){echo"selected";}?>>days</option>
			<option value='weeks' <?php if($obj->reqdurationtype=='weeks'){echo"selected";}?>>weeks</option>
			<option value='months' <?php if($obj->reqdurationtype=='months'){echo"selected";}?>>months</option>
			<option value='years' <?php if($obj->reqdurationtype=='years'){echo"selected";}?>>years</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Deadline : </td>
		<td><input type="text" name="deadline" id="deadline" class="date_input" size="12" readonly  value="<?php echo $obj->deadline; ?>"></td>
	</tr>
	<tr>
		<td align="right">Start Date : </td>
		<td><input type="text" name="startdate" id="startdate" class="date_input" size="12" readonly  value="<?php echo $obj->startdate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Start Time : </td>
		<td><input type="text" name="starttime" id="starttime" value="<?php echo $obj->starttime; ?>"></td>
	</tr>
	<tr>
		<td align="right">End Date : </td>
		<td><input type="text" name="enddate" id="enddate" class="date_input" size="12" readonly  value="<?php echo $obj->enddate; ?>"></td>
	</tr>
	<tr>
		<td align="right">End Time : </td>
		<td><input type="text" name="endtime" id="endtime" value="<?php echo $obj->endtime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Duration : </td>
		<td><input type="text" name="duration" id="duration" value="<?php echo $obj->duration; ?>"></td>
	</tr>
	<tr>
		<td align="right">Duration Type : </td>
		<td><select name='durationtype' class="selectbox">
			<option value='minutes' <?php if($obj->durationtype=='minutes'){echo"selected";}?>>minutes</option>
			<option value='hours' <?php if($obj->durationtype=='hours'){echo"selected";}?>>hours</option>
			<option value='days' <?php if($obj->durationtype=='days'){echo"selected";}?>>days</option>
			<option value='weeks' <?php if($obj->durationtype=='weeks'){echo"selected";}?>>weeks</option>
			<option value='months' <?php if($obj->durationtype=='months'){echo"selected";}?>>months</option>
			<option value='years' <?php if($obj->durationtype=='years'){echo"selected";}?>>years</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Remind On : </td>
		<td><input type="text" name="remind" id="remind" class="date_input" size="12" readonly  value="<?php echo $obj->remind; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>