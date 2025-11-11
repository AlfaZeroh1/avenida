<title>WiseDigits: Deductioncharges </title>
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

<form action="adddeductioncharges_proc.php" name="deductioncharges"  method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
		<td align="right">Deduction : </td>
			<td><select name="deductionid" class="selectbox">
<option value="">Select...</option>
<?php
	$deductions=new Deductions();
	$where="  ";
	$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductions.deductiontypeid, hrm_deductions.deductioninterval, hrm_deductions.amount, hrm_deductions.charged, hrm_deductions.overall, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($deductions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->deductionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Amount From : </td>
		<td><input type="text" name="amountfrom" id="amountfrom" size="8"  value="<?php echo $obj->amountfrom; ?>"></td>
	</tr>
	<tr>
		<td align="right">Amount To : </td>
		<td><input type="text" name="amountto" id="amountto" size="8"  value="<?php echo $obj->amountto; ?>"></td>
	</tr>
	<tr>
		<td align="right">Charge : </td>
		<td><input type="text" name="charge" id="charge" size="8"  value="<?php echo $obj->charge; ?>"></td>
	</tr>
	<tr>
		<td align="right">Type : </td>
		<td><select name='chargetype' class="selectbox">
			<option value='%' <?php if($obj->chargetype=='%'){echo"selected";}?>>%</option>
			<option value='amount' <?php if($obj->chargetype=='amount'){echo"selected";}?>>amount</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Formula : </td>
		<td><input type="text" name="formula" id="formula" value="<?php echo $obj->formula; ?>"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>