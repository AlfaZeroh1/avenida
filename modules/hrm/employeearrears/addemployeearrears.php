<title>WiseDigits ERP: Employeearrears </title>
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
<form  id="theform" action="addemployeearrears_proc.php" name="employeearrears" method="POST" enctype="multipart/form-data">
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
		<td align="right">Arrears : </td>
			<td><select name="arrearid" class="selectbox">
<option value="">Select...</option>
<?php
	$arrears=new Arrears();
	$where="  ";
	$fields="hrm_arrears.id, hrm_arrears.name, hrm_arrears.taxable, hrm_arrears.status, hrm_arrears.remarks, hrm_arrears.createdby, hrm_arrears.createdon, hrm_arrears.lasteditedby, hrm_arrears.lasteditedon, hrm_arrears.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($arrears->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->arrearid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Employee : </td>
			<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Month : </td>
		<td><select name="month" id="month" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Year : </td>
		<td><select name="year" id="year" class="selectbox">
          <option value="">Select...</option>
          <?php
	  $i=date("Y")-10;
	  while($i<date("Y")+10)
	  {
		?>
		  <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
		  <?
	    $i++;
	  }
	  ?>
        </select><font color='red'>*</font></td>
	</tr>
	
	<tr>
		<td align="right">Amount : </td>
		<td><input type='text' size='20' name='amount' id='amount' value='<?php echo $obj->amount; ?>'/></td>
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
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>