<title>WiseDigits: Employeepaiddeductions </title>
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

<div class='main'>
<form  id="theform" action="addemployeepaiddeductions_proc.php" name="employeepaiddeductions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<!--<tr>
		<td align="right">Payment : </td>
		<td><input type="text" name="employeepaymentid" id="employeepaymentid" value="<?php echo $obj->employeepaymentid; ?>"></td>
	</tr>-->
	<tr>
		<td align="right">Deduction : </td>
			<td><select name="deductionid">
<option value="">Select...</option>
<?php
	$deductions=new Deductions();
	$where="  ";
	$fields="*";
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
		<td align="right">Loan : </td>
			<td>
			<input type="hidden" name="employeeloanid" id="employeeloanid" value="<?php echo $obj->employeeloanid; ?>"/>
			<select name="loanid">
<option value="">Select...</option>
<?php
	$loans=new Loans();
	$where="  ";
	$fields="*";
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
			<td>
			<input type="text" size="32" name="employeename" id="employeename" value="<?php echo $obj->employeename; ?>"/>
			<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
		</td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Reducing? </td>
		<td><input type="radio" name="reducing" 
id="reducing" value="Yes" <?php if($obj->reducing=='Yes'){echo "checked";}?> 
/>Yes&nbsp;<input type="radio" name="reducing" 
id="reducing" value="No" <?php if($obj->reducing=='No'){echo "checked";}?> 
/>No</td>
	</tr>
	
	<tr>
		<td align="right">Month : </td>
		<td><input type="text" size="4" name="month" id="month" value="<?php echo $obj->month; ?>"></td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><input type="text" size="4" name="year" id="year" value="<?php echo $obj->year; ?>"></td>
	</tr>
	<tr>
		<td align="right">Payment Date : </td>
		<td><input type="text" name="paidon" id="paidon" class="date_input" size="12" readonly  value="<?php echo $obj->paidon; ?>"></td>
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