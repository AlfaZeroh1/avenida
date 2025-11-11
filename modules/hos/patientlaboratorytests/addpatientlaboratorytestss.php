<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#patientname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=patients&field=concat(surname,' ',othernames)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#patientid").val(ui.item.id);
		$("#patientno").val(ui.item.patientno);
		$("#address").val(ui.item.address);
	}
  });

  $("#laboratorytestname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=laboratorytests&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#laboratorytestid").val(ui.item.id);
		$("#price").val(ui.item.price);
	}
  });

});
</script>
<title>WiseDigits: Patientlaboratorytests</title>
<form action="addpatientlaboratorytestss_proc.php" class="forms" name="patientlaboratorytests" method="POST">
<table align="center" width="100%">
	<tr>
		<td colspan="2"><input type="hidden" name="patienttreatmentid" id="patienttreatmentid" value="<?php echo $obj->patienttreatmentid; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">TestNo: </td>
		<td><input type="text" name="testno" size="4" readonly="readonly" id="testno" value="<?php echo $obj->testno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Patient: </td>
<td><input type="text" name="patientname" id="patientname" value="<?php echo $obj->patientname; ?>"/>
	<input type="hidden" name="patientid" id="patientid" value="<?php echo $obj->patientid; ?>"/><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">PatientNo: </td>
		<td><input type="text" name="patientno" id="patientno" value="<?php echo $obj->patientno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Address: </td>
		<td><textarea name="address" id="address"><?php echo $obj->address; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">LaboratoryTest: </td><td><input type='text' size='0' name='laboratorytestname' id='laboratorytestname' value='<?php echo $obj->laboratorytestname; ?>'>
        
					<input type="hidden" name='laboratorytestid' id='laboratorytestid' value='<?php echo $obj->field; ?>'><font color='red'>*</font>
		</td>
     </tr>
     <tr>
		<td align="right">Charge: </td><td>
			<input type="text" name="price" id="price" size="4" value="<?php echo $obj->price; ?>"/>&nbsp;
            </td>
            </tr>
        <tr>
        <td colspan="3" align="center">
			<input type="submit" class="btn" name="action" id="action" value="<?php echo $obj->action; ?>">
            <input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/>
		</td>
	</tr>
	</table>

		<table style="width: 80%; margin:5px 20px;" >
			<tr>
				<th>#</th>
				<th>Lab Test</th>
				<th>Charge</th>
				<th>&nbsp;</th>
			</tr>
			<?php
			if(!empty($obj->testno) and !empty($obj->patientid)){
				$patientlaboratorytests = new Patientlaboratorytests();
				$i=0;
				$fields="hos_patientlaboratorytests.id, hos_patientlaboratorytests.testno, concat(hos_patients.surname,' ', hos_patients.othernames) as patientid, hos_patientlaboratorytests.patienttreatmentid, hos_laboratorytests.name as laboratorytestid, hos_patientlaboratorytests.labresults, hos_patientlaboratorytests.testedon, hos_patientlaboratorytests.consult, hos_patientlaboratorytests.createdby, hos_patientlaboratorytests.createdon, hos_patientlaboratorytests.lasteditedby, hos_patientlaboratorytests.lasteditedon";
				$join=" left join hos_patients on hos_patientlaboratorytests.patientid=hos_patients.id  left join hos_laboratorytests on hos_patientlaboratorytests.laboratorytestid=hos_laboratorytests.id ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where hos_patientlaboratorytests.testno='$obj->testno' ";
				$patientlaboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
				$res=$patientlaboratorytests->result;
				while($row=mysql_fetch_object($res)){
				$i++;
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->laboratorytestid; ?></td>
				<td><?php echo $row->charge; ?></td>
				<td><a href="addpatientlaboratorytestss.php?id=<?php echo $obj->patienttreatmentid; ?>&delid=<?php echo $row->id; ?>">Delete</a></td>
			</tr>
			<?php 
			}
			}
			?>
		</table>
	
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>