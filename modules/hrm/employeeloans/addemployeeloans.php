<title>WiseDigits: Employeeloans </title>
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
<?php include'js.php'; ?>
</script>
<script type="text/javascript">

function determine(id)
{
      if(document.getElementById("payable").value==id)
      {
      document.getElementById("duration").value=Math.round((document.getElementById("principal").value/document.getElementById("payable").value)*Math.pow(10,2))/Math.pow(10,2);
      }
      else if(document.getElementById("duration").value==id)
      {
      document.getElementById("payable").value=Math.round((document.getElementById("principal").value/document.getElementById("duration").value)*Math.pow(10,2))/Math.pow(10,2);
      }
}
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
<form  id="theform" action="addemployeeloans_proc.php" name="employeeloans" method="POST" enctype="multipart/form-data">
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
		<td align="right">Loan : </td>
			<td><select name="loanid">
<option value="">Select...</option>
<?php
	$loans=new Loans();
	$where="  ";
	$fields="hrm_loans.id, hrm_loans.name, hrm_loans.method, hrm_loans.description, hrm_loans.createdby, hrm_loans.createdon, hrm_loans.lasteditedby, hrm_loans.lasteditedon, hrm_loans.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($loans->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->loanid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
			<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
	</tr>
	<tr>
		<td align="right">Principal : </td>
		<td><input type="text" name="principal" id="principal" size="8"  value="<?php echo $obj->principal; ?>"></td>
	</tr>
	<tr>
		<td align="right">Method : </td>
		<td><select name='method'>
			<option value='straight-line' <?php if($obj->method=='straight-line'){echo"selected";}?>>straight-line</option>
			<option value='reducing balance' <?php if($obj->method=='reducing balance'){echo"selected";}?>>reducing balance</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Initial Value : </td>
		<td><input type="text" name="initialvalue" id="initialvalue" size="8"  value="<?php echo $obj->initialvalue; ?>"></td>
	</tr>
	<tr>
		<td align="right">Payable : </td>
		<td><input type="text" name="payable" id="payable" size="8" value="<?php echo $obj->payable; ?>" onchange="determine(this.value);"></td>
	</tr>
	<tr>
		<td align="right">Duration : </td>
		<td><input type="text" name="duration" id="duration" size="8"  value="<?php echo $obj->duration; ?>" onchange="determine(this.value);"></td>
	</tr>
	<tr>
		<td align="right"> Interest Type : </td>
		<td><select name='interesttype'>
			<option value='%' <?php if($obj->interesttype=='%'){echo"selected";}?>>%</option>
			<option value='Amount' <?php if($obj->interesttype=='Amount'){echo"selected";}?>>Amount</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Interest : </td>
		<td><input type="text" name="interest" id="interest" size="8"  value="<?php echo $obj->interest; ?>"></td>
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
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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