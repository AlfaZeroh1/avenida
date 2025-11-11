<title>WiseDigits: Patientvitalsigns </title>
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

<form action="addpatientvitalsigns_proc.php" name="patientvitalsigns" class="forms" method="POST" enctype="multipart/form-data">
<div style="margin-left:30%;margin-top:10px;">
    <table width="60%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="3" align='center'><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
		<input type="hidden" name="patientid" id="patientid" value="<?php echo $obj->patientid; ?>">
		<input type="hidden" name="patientappointmentid" id="patientappointmentid" value="<?php echo $obj->patientappointmentid; ?>">
		<input type="hidden" name="patienttreatmentid" id="patienttreatmentid" value="<?php echo $obj->patienttreatmentid; ?>">
		<font color='red'><strong><?php echo initialCap($patients->name); ?></strong></font>
		</td>
	</tr>
	
	<tr>
		<td align="right">Observation Date : </td>
		<td><input type="text" name="observedon" id="observedon" class="date_input" size="12" readonly  value="<?php echo $obj->observedon; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Observation Time : </td>
		<td><input type="text" name="observedtime" id="observedtime" value="<?php echo $obj->observedtime; ?>"><font color='red'>*</font></td>
	</tr>
	
	<tr>
	
	<tr>
		<th>Vital Sign</th>
		<th>Results</th>
		<th>Remarks</th>
	</tr>
<?php
	$vitalsigns=new Vitalsigns();
	$where="  ";
	$fields="hos_vitalsigns.id, hos_vitalsigns.name, hos_vitalsigns.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$vitalsigns->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($vitalsigns->result)){
	?>
		
		<tr>
			<td valign="bottom" align="right"><input type="hidden" name="vitalsign<?php echo $rw->id; ?>" value="<?php echo $_POST['vitalsign'.$rw->id];?>"/><?php echo $rw->name; ?></td>
			<td valign="bottom"><input type="text"  name="results<?php echo $rw->id; ?>" value="<?php echo $_POST['results'.$rw->id];  ?>"/></td>
			<td valign="bottom"><textarea name="remarks<?php echo $rw->id; ?>"><?php echo $_POST['remarks'.$rw->id];?></textarea></td>
		</tr>
	<?php
	}
	?>
	<tr>
		<td colspan="3" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</div>
</form>

<?php 
if(!empty($error)){
	showError($error);
}
?>