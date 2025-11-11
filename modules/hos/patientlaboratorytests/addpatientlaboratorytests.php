<title>WiseDigits: Patientlaboratorytests </title>

<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
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
		$("#charge").val(ui.item.charge);
	}
  });

});
</script>
<form action="addpatientlaboratorytests_proc.php" class="forms" name="patientlaboratorytests" method="POST" enctype="multipart/form-data">
<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">Test No : </td>
		<td><input type="text" name="testno" id="testno" readonly="readonly" value="<?php echo $obj->testno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Patient : </td>
			<td><input type="hidden"  name="patientid" value="<?php echo $obj->patientid; ?>"/>
			<input type="text" readonly="readonly" name="patient" value="<?php echo $obj->patient; ?>">
		</td>
	</tr>
	<tr>
		<td align="right"> </td>
		<td><input type="hidden" name="patienttreatmentid" id="patienttreatmentid" value="<?php echo $obj->patienttreatmentid; ?>"></td>
	</tr>
	<tr>
		<td align="right">LaboratoryTest: </td><td><input type='text' size='0' name='laboratorytestname' id='laboratorytestname' value='<?php echo $obj->laboratorytestname; ?>'>
        
					<input type="hidden" name='laboratorytestid' id='laboratorytestid' value='<?php echo $obj->laboratorytestid; ?>'><font color='red'>*</font>
		</td>
     </tr>
	<tr>
		<td align="right">Charge : </td>
		<td><input type="text" name="charge" id="charge" size="8"  value="<?php echo $obj->charge; ?>"></td>
	</tr>
	<tr>
		<td align="Right">Status:</td>
		<td>
		<input type="radio" name="results" value="Positive" <?php if($obj->results=="Positive"){echo"checked";}?>/> Positive
		<input type="radio" name="results" value="Negative" <?php if($obj->results=="Negative"){echo"checked";}?>/> Negative
		</td>
	</tr>
	<tr>
		<td align="right">Lab Results : </td>
		<td><textarea name="labresults" class="ckeditor"><?php echo $obj->labresults; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Tested On : </td>
		<td><input type="text" name="testedon" id="testedon" class="date_input" size="12" readonly  value="<?php echo $obj->testedon; ?>"></td>
	</tr>
	<tr>
		<td align="right"></td>
		<td><input type="hidden" name="consult" id="consult" value="<?php echo $obj->consult; ?>"></td>
	</tr>
	<tr>
	  <td colspan='2' align='center'>
	  <table>
	    <tr>
	      <th>Detail</th>
	      <th>Result</th>
	      <th>&nbsp;</th>
	    </tr>
	    <?php
	    $laboratorytestdetails=new Laboratorytestdetails();
	    $fields="hos_laboratorytestdetails.id, hos_laboratorytests.name as laboratorytestid, hos_laboratorytestdetails.detail, hos_laboratorytestdetails.remarks, hos_laboratorytestdetails.ipaddress, hos_laboratorytestdetails.createdby, hos_laboratorytestdetails.createdon, hos_laboratorytestdetails.lasteditedby, hos_laboratorytestdetails.lasteditedon";
	    $join=" left join hos_laboratorytests on hos_laboratorytestdetails.laboratorytestid=hos_laboratorytests.id ";
	    $having="";
	    $groupby="";
	    $orderby="";
	    $where=" where hos_laboratorytestdetails.laboratorytestid='$obj->laboratorytestid' ";
	    $laboratorytestdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	    $res=$laboratorytestdetails->result;
	    while($row=mysql_fetch_object($res)){
	      ?>
		<tr>
		  <td><?php echo $row->detail; ?></td>
		  <td><textarea name="<?php echo $row->id; ?>"><?php echo $_POST[$row->id]; ?></textarea></td>
		  <td><?php echo $row->remarks; ?></td>
		</tr>
	      <?php
	    }
	    ?>
	  </table>
	  </td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php if(!empty($obj->id)){?> 
	<tr>
		<td colspan="2" align="center">
		</td>
	</tr>
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>