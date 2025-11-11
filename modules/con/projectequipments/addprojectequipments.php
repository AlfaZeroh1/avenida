<title>WiseDigits ERP: Projectequipments </title>
<?php 
$pop=1;
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

<div class='main'>
<form  id="theform" action="addprojectequipments_proc.php" name="projectequipments" method="POST" enctype="multipart/form-data">
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
		<td align="right">Equipment : </td>
			<td><select name="equipmentid" class="selectbox">
<option value="">Select...</option>
<?php
	$equipments=new Equipments();
	$where="  ";
	$fields="con_equipments.id, con_equipments.name, con_equipments.hirecost, con_equipments.purchasecost, con_equipments.remarks, con_equipments.ipaddress, con_equipments.createdby, con_equipments.createdon, con_equipments.lasteditedby, con_equipments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$equipments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($equipments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->equipmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Work Schedule : </td>
			<td><select name="projectworkscheduleid" class="selectbox">
<option value="">Select...</option>
<?php
	$projectworkschedules=new Projectworkschedules();
	$where="  ";
	$fields="con_projectworkschedules.id, con_projectworkschedules.projectboqid, con_projectworkschedules.employeeid, con_projectworkschedules.projectweek, con_projectworkschedules.week, con_projectworkschedules.year, con_projectworkschedules.priority, con_projectworkschedules.tracktime, con_projectworkschedules.reqduration, con_projectworkschedules.reqdurationtype, con_projectworkschedules.deadline, con_projectworkschedules.startdate, con_projectworkschedules.starttime, con_projectworkschedules.enddate, con_projectworkschedules.endtime, con_projectworkschedules.duration, con_projectworkschedules.durationtype, con_projectworkschedules.remind, con_projectworkschedules.remarks, con_projectworkschedules.ipaddress, con_projectworkschedules.createdby, con_projectworkschedules.createdon, con_projectworkschedules.lasteditedby, con_projectworkschedules.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectworkschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($projectworkschedules->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->projectworkscheduleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Project Week : </td>
		<td><input type="text" name="projectweek" id="projectweek" value="<?php echo $obj->projectweek; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Calendar Week : </td>
		<td><input type="text" name="week" id="week" value="<?php echo $obj->week; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Month : </td>
		<td><input type="text" name="month" id="month" value="<?php echo $obj->month; ?>"></td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><input type="text" name="year" id="year" value="<?php echo $obj->year; ?>"></td>
	</tr>
	<tr>
		<td align="right">Equipment Type : </td>
		<td><select name='type' class="selectbox">
			<option value='Hired' <?php if($obj->type=='Hired'){echo"selected";}?>>Hired</option>
			<option value='Purchased' <?php if($obj->type=='Purchased'){echo"selected";}?>>Purchased</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Rate : </td>
		<td><input type="text" name="rate" id="rate" size="8"  value="<?php echo $obj->rate; ?>"></td>
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