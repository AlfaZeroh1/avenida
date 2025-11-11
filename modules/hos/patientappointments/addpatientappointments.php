<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#patientname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=patients&field=concat(patientno,' ',concat(surname,' ',othernames))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#patientid").val(ui.item.id);
	}
  });

 
 $("#departmentid").on("change",function(){
    var str=$(this).val();
    
    //var st = str.split("-");
     // alert("");
      $.get("getDoctors.php",{id:parseInt(str)},function(data){
	$("#employeeid").html(data);      
      });     
      
    
  });
  
});
</script>
<script type="text/javascript">
$(document).ready(function(){

  

});
</script>
<title>WiseDigits: Patientappointments</title>
<form action="addpatientappointments_proc.php" class="forms" name="patientappointments" method="POST">
<table align="center" width="100%">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">Patient: </td>
<td><input type="text" size="40" name="patientname" id="patientname" value="<?php echo $obj->patientname; ?>"/>
	<input type="hidden" name="patientid" id="patientid" value="<?php echo $obj->patientid; ?>"/><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Patient Class:</td>
		<td>
			<select name="patientclasseid" class="selectbox">
				<option value="">Select...</option>
				<?php 
				$patientclasses = new Patientclasses();
				$fields=" * ";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$patientclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				while ($row=mysql_fetch_object($patientclasses->result)){
				?>
					<option value="<?php echo $row->id; ?>" <?php if($obj->patientclasseid==$row->id){echo"selected";}?>><?php echo $row->name; ?></option>
				<?php 
				}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right">AppointmentDate: </td>
		<td><input type="text" name="appointmentdate" id="appointmentdate" class="date_input" size="10" readonly  value="<?php echo $obj->appointmentdate; ?>"><font color='red'>*</font></td>
	</tr>
	
	<tr>
		<td align="right">Department : </td>
			<td><select name="departmentid" id="departmentid" class="selectbox" onchange>
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="hos_departments.id, hos_departments.name, hos_departments.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($departments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	
	<tr>
		<td align="right">Physician/Clinician : </td>
			<td>

			<select name="employeeid" id="employeeid" class="selectbox">

</select>
		</td>
	</tr>
	
	<tr>
		<td align="right">Remarks: </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Booked On: </td>
		<td><input type="text" name="bookedon" id="bookedon" class="date_input" size="10" readonly  value="<?php echo $obj->bookedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Pay Consultancy</td>
		<td>
<!-- 			<input type="hidden" name='payconsultancy' value="1"/> -->
			<input type="radio" name="payconsultancy" value="1" <?php if($obj->payconsultancy==1){echo "checked";}?>/><span style="color:red;">Yes</span>
			<input type="radio" name="payconsultancy" value="0" <?php if($obj->payconsultancy==0){echo "checked";}?>/><span style="color:red;">No</span>
		</td>
	</tr>
	<tr>
		<td align="right">Consultancy Fee: </td>
		<td><input type="text" name="amount" id="amount" size="10" value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Observations</td>
		<td>
<!-- 			<input type="hidden" name='payconsultancy' value="1"/> -->
			<input type="radio" name="status" value="1" checked<?php if($obj->status==1){echo "checked";}?>/><span style="color:red;">Yes</span>
			<input type="radio" name="status" value="2" /><span style="color:red;">No</span>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>