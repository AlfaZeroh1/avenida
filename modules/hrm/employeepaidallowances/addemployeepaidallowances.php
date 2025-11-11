<title>WiseDigits: Employeepaidallowances </title>
<?php 
$pop=1;
include "../../../head.php";

?>
 <script type="text/javascript" charset="utf-8">
 $(document).ready(function() {
 	
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)))",
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

 } );
 </script>

<div class='main'>
<form  id="theform" action="addemployeepaidallowances_proc.php" name="employeepaidallowances" method="POST" enctype="multipart/form-data">
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
		<td align="right">Payment : </td>
			<td><select name="employeepaymentid">
<option value="">Select...</option>
<?php
	$employeepayments=new Employeepayments();
	$where="  ";
	$fields="hrm_employeepayments.id, hrm_employeepayments.employeeid, hrm_employeepayments.assignmentid, hrm_employeepayments.paymentmodeid, hrm_employeepayments.bankid, hrm_employeepayments.employeebankid, hrm_employeepayments.bankbrancheid, hrm_employeepayments.bankacc, hrm_employeepayments.clearingcode, hrm_employeepayments.ref, hrm_employeepayments.month, hrm_employeepayments.year, hrm_employeepayments.basic, hrm_employeepayments.allowances, hrm_employeepayments.deductions, hrm_employeepayments.netpay, hrm_employeepayments.paidon, hrm_employeepayments.ipaddress, hrm_employeepayments.createdby, hrm_employeepayments.createdon, hrm_employeepayments.lasteditedby, hrm_employeepayments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($employeepayments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->employeepaymentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Allowance : </td>
			<td><select name="allowanceid">
<option value="">Select...</option>
<?php
	$allowances=new Allowances();
	$where="  ";
	$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowances.allowancetypeid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon, hrm_allowances.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($allowances->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->allowanceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
		<td align="right">Month : </td>
		<td><input type="text" name="month" id="month" value="<?php echo $obj->month; ?>"></td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><input type="text" name="year" id="year" value="<?php echo $obj->year; ?>"></td>
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
