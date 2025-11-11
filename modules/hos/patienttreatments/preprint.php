<?php
require_once '../../../lib.php';

include_once '../../../headerpop.php';

$treatmentid=$_GET['treatmentid'];

$obj = (object)$_POST;
if(!empty($treatmentid)){
	$obj->treatmentid=$treatmentid;
}
if($obj->action=="Print Now"){
	if(empty($obj->observation) and empty($obj->symptoms)  and empty($obj->hpi)  and empty($obj->obs) and empty($obj->findings) and empty($obj->history) and empty($obj->diagnosis) and empty($obj->laboratory) and empty($obj->other) and empty($obj->prescription) and empty($obj->payments)){
		$error="Must select option to print";
	}
	else{?>
		<script type="text/javascript">
		poptastic("print.php?treatmentid=<?php echo $obj->treatmentid;?>&observation=<?php echo $obj->observation;?>&symptoms=<?php echo $obj->symptoms; ?>&hpi=<?php echo $obj->hpi;?>&obs=<?php echo $obj->obs;?>&findings=<?php echo $obj->findings;?>&history=<?php echo $obj->history;?>&diagnosis=<?php echo $obj->diagnosis;?>&laboratory=<?php echo $obj->laboratory;?>&other=<?php echo $obj->other;?>&prescription=<?php echo $obj->prescription;?>&payments=<?php echo $obj->payments;?>",700,1020);
		</script>
		<?php 
	}
}
?>
<form action="preprint.php" method="post">
<table align="center">
	<tr>
		<th><input type="hidden" name="treatmentid" value="<?php echo $obj->treatmentid; ?>"></>Select Print Options</th>
	</tr>
	<tr>
		<td><input type="checkbox" name="observation" value="observation" <?php if($obj->observation=="observation"){echo "checked";}?>/>Observation</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="symptoms" value="symptoms"  <?php if($obj->symptoms=="symptoms"){echo "checked";}?>/>Symptoms</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="hpi" value="hpi"  <?php if($obj->hpi=="hpi"){echo "checked";}?>/>HPI</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="obs" value="obs"  <?php if($obj->obs=="obs"){echo "checked";}?>/>OBS/Gyne/PSMH</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="findings" value="findings"  <?php if($obj->findings=="findings"){echo "checked";}?>/>Examination Findings</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="diagnosis" value="diagnosis" <?php if($obj->diagnosis=="diagnosis"){echo "checked";}?>/>Diagnosis</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="history" value="history" <?php if($obj->history=="history"){echo "checked";}?>/>History</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="laboratory" value="laboratory" <?php if($obj->laboratory=="laboratory"){echo "checked";}?>/>Laboratory</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="other" value="other"  <?php if($obj->other=="other"){echo "checked";}?>/>Other Services</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="prescription" value="prescription" <?php if($obj->prescription=="prescription"){echo "checked";}?>/>Prescription</td>
	</tr>
	<tr>
		<td><input type="checkbox" name="payments" value="payments"  <?php if($obj->payments=="payments"){echo "checked";}?>/>Payments</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><input type="submit" name="action" value="Print Now"/></td>
	</tr>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>