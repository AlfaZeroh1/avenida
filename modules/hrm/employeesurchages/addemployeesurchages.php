<title>WiseDigits: Employeesurchages </title>
<?php 
$pop=1;
include "../../../head.php";

?>

<script type="text/javascript">
$().ready(function() {
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
		$("#basic").val(ui.item.basic);
	}
  });

});

function calculateAmount(){

  var basic = $("#basic").val();
  var days = $("#days").val();
  
  var surchage = (basic*12/365)*days;
  $("#amount").val(surchage);
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
<form  id="theform" action="addemployeesurchages_proc.php" name="employeesurchages" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Surcharge : </td>
			<td><select name="surchageid">
<option value="">Select...</option>
<?php
	$surchages=new Surchages();
	$where="  ";
	$fields="hrm_surchages.id, hrm_surchages.name, hrm_surchages.amount, hrm_surchages.remarks, hrm_surchages.surchagetypeid, hrm_surchages.frommonth, hrm_surchages.fromyear, hrm_surchages.tomonth, hrm_surchages.toyear, hrm_surchages.overall, hrm_surchages.status, hrm_surchages.createdby, hrm_surchages.createdon, hrm_surchages.lasteditedby, hrm_surchages.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($surchages->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->surchageid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
			<td><input type='text' size='45' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
			<input type="hidden" name='basic' id='basic' value='<?php echo $obj->basic; ?>'><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Surchage Type : </td>
			<td><select name="surchagetypeid">
<option value="">Select...</option>
<?php
	$surchagetypes=new Surchagetypes();
	$where="  ";
	$fields="hrm_surchagetypes.id, hrm_surchagetypes.name, hrm_surchagetypes.repeatafter, hrm_surchagetypes.remarks, hrm_surchagetypes.createdby, hrm_surchagetypes.createdon, hrm_surchagetypes.lasteditedby, hrm_surchagetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$surchagetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($surchagetypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->surchagetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Days : </td>
		<td><input type="text" name="days" id="days" size="8" readonly value="<?php echo $obj->days; ?>" onchange="calculateAmount();"></td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Charged On : </td>
		<td><input type="text" name="chargedon" id="chargedon" class="date_input" size="12" readonly  value="<?php echo $obj->chargedon; ?>"></td>
	</tr>
	<tr>
				<td align="right">From:</td><td><select name="frommonth" id="frommonth" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->frommonth==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->frommonth==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->frommonth==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->frommonth==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->frommonth==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->frommonth==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->frommonth==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->frommonth==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->frommonth==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->frommonth==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->frommonth==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->frommonth==12){echo"selected";}?>>December</option>
      </select>&nbsp;
      <select name="fromyear" id="fromyear" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->fromyear==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select></td>
			</tr>
	<tr>
				<td align="right">To:</td><td><select name="tomonth" id="tomonth" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->tomonth==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->tomonth==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->tomonth==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->tomonth==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->tomonth==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->tomonth==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->tomonth==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->tomonth==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->tomonth==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->tomonth==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->tomonth==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->tomonth==12){echo"selected";}?>>December</option>
      </select>&nbsp;
      <select name="toyear" id="toyear" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->toyear==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select></td>
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
if(!empty($error)){
	showError($error);
}
?>