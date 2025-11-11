<title>WiseDigits ERP: Allowances </title>
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

<div class='main'>
<form  id="theform" action="addallowances_proc.php" name="allowances" method="POST" enctype="multipart/form-data">
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
		<td align="right">Allowance : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">% Taxable : </td>
		<td><input type="text" name="percentaxable" id="percentaxable" size="8"  value="<?php echo $obj->percentaxable; ?>"></td>
	</tr>
	<tr>
		<td align="right">Allowance Type : </td>
			<td><select name="allowancetypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$allowancetypes=new Allowancetypes();
	$where="  ";
	$fields="hrm_allowancetypes.id, hrm_allowancetypes.name, hrm_allowancetypes.repeatafter, hrm_allowancetypes.remarks, hrm_allowancetypes.createdby, hrm_allowancetypes.createdon, hrm_allowancetypes.lasteditedby, hrm_allowancetypes.lasteditedon, hrm_allowancetypes.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$allowancetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($allowancetypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->allowancetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Expense Account : </td>
			<td><select name="expenseid" class="selectbox">
<option value="">Select...</option>
<?php
	$expenses=new Expenses();
	$where="  ";
	$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($expenses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->expenseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Overall : </td>
		<td><select name='overall' class="selectbox">
			<option value='All' <?php if($obj->overall=='All'){echo"selected";}?>>All</option>
			<option value='Individual' <?php if($obj->overall=='Individual'){echo"selected";}?>>Individual</option>
		</select></td>
	</tr>
	<tr>
<td align="right">From:</td>
<td>
    <select name="frommonth" id="frommonth" class="selectbox">
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
      </select>
      &nbsp;
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
        </select>
</td>
</tr>
<tr>
<td align="right">To:</td>
<td>
  <select name="tomonth" id="tomonth" class="selectbox">
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
      </select>
      &nbsp;
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
        </select>

</td>
</tr>
	<!--<tr>
		<td align="right">From Month : </td>
		<td><input type="text" name="frommonth" id="frommonth" value="<?php echo $obj->frommonth; ?>"></td>
	</tr>
	<tr>
		<td align="right">From Year : </td>
		<td><input type="text" name="fromyear" id="fromyear" value="<?php echo $obj->fromyear; ?>"></td>
	</tr>
	<tr>
		<td align="right">To : </td>
		<td><input type="text" name="tomonth" id="tomonth" value="<?php echo $obj->tomonth; ?>"></td>
	</tr>
	<tr>
		<td align="right">To : </td>
		<td><input type="text" name="toyear" id="toyear" value="<?php echo $obj->toyear; ?>"></td>
	</tr>-->
	<tr>
		<td align="right">Status : </td>
		<td><select name='status' class="selectbox">
			<option value='active' <?php if($obj->status=='active'){echo"selected";}?>>active</option>
			<option value='inactive' <?php if($obj->status=='inactive'){echo"selected";}?>>inactive</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Non-Cash Benefit : </td>
		<td><input type="radio" name="noncashbenefit" id="noncashbenefit" value="Yes" <?php if($obj->noncashbenefit=='Yes'){echo "checked";}?>>&nbsp;Yes&nbsp;&nbsp;&nbsp;<input type="radio" name="noncashbenefit" id="noncashbenefit" value="No" <?php if($obj->noncashbenefit=='No'){echo "checked";}?>>&nbsp;No
		</td>
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