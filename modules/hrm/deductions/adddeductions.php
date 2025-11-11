<title>WiseDigits: Deductions </title>
<?php 
$pop=1;
include "../../../head.php";

$arr=array(1,2,3,4,5,7);
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
<form  id="theform" action="adddeductions_proc.php" name="deductions" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Deduction : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>" <?php if(in_array($obj->id,$arr)){echo"readonly";}?>><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Deduction Type : </td>
			<td><select name="deductiontypeid">
<option value="">Select...</option>
<?php
	$deductiontypes=new Deductiontypes();
	$where="  ";
	$fields="hrm_deductiontypes.id, hrm_deductiontypes.name, hrm_deductiontypes.repeatafter, hrm_deductiontypes.remarks, hrm_deductiontypes.createdby, hrm_deductiontypes.createdon, hrm_deductiontypes.lasteditedby, hrm_deductiontypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deductiontypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($deductiontypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->deductiontypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	
	<tr>
		<td align="right">Liability Acct : </td>
			<td><select name="liabilityid" class="selectbox">
<option value="">Select...</option>
<?php
	$liabilitys=new Liabilitys();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$liabilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($liabilitys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->liabilityid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Employer Pays: </td>
		<td><input type="radio" name="epays" id="epays" value="yes" <?php if($obj->epays=="yes"){echo "checked";}?>>yes
		<input type="radio" name="epays" id="epays" value="no"  <?php if($obj->epays=="no"){echo "checked";}?>>no&nbsp;
		Exp Account: <select name="expenseid" class="selectbox">
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
</select>
		</td>
	</tr>
	
	<tr>
		<td align="right">Statement: </td>
		<td><input type="radio" name="statement" id="statement" value="yes" <?php if($obj->statement=="yes"){echo "checked";}?>>yes
		<input type="radio" name="statement" id="statement" value="no"  <?php if($obj->statement=="no"){echo "checked";}?>>no</td>
	</tr>
	
	<tr>
	<td align="right">From Month</td><td><select name="frommonth" id="frommonth" class="selectbox">
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
      </select></td>
			</tr>
	
	<tr>
				<td align="right">From Year</td>
				<td><select name="fromyear" id="fromyear" class="selectbox">
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
	<td align="right">To Month</td><td><select name="tomonth" id="tomonth" class="selectbox">
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
      </select></td>
			</tr>
	<tr>
				<td align="right">To Year</td>
				<td><select name="toyear" id="toyear" class="selectbox">
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
		<td align="right">Deduction Type : </td>
		<td><select name='deductiontype'>
			<option value='%' <?php if($obj->deductiontype=='%'){echo"selected";}?>>%</option>
			<option value='Amount' <?php if($obj->deductiontype=='Amount'){echo"selected";}?>>Amount</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>">
		<!--<input type="hidden" name="liabilityid" id="liabilityid"  value="<?php echo $obj->liabilityid; ?>">-->
		<input type="hidden" name="acctypeid" id="acctypeid"  value="<?php echo $obj->acctypeid; ?>">
		</td>
	</tr>
	
	<tr>
		<td align="right">Relief : </td>
		<td><input type="text" name="relief" id="relief" size="4"  value="<?php echo $obj->relief; ?>">%
		</td>
	</tr>
	<tr>
		<td align="right">Taxable : </td>
		<td>
			<input type="radio" name="taxable" value='Yes' <?php if($obj->taxable=='Yes'){echo"checked";}?>>Yes</option>
			<input type="radio" name="taxable" value='No' <?php if($obj->taxable=='No'){echo"checked";}?>>No</option>
		</td>
	</tr>
	
	<tr>
		<td align="right">Applies To : </td>
		<td><select name='overall'>
			<option value='All' <?php if($obj->overall=='All'){echo"selected";}?>>All</option>
			<option value='Individual' <?php if($obj->overall=='Individual'){echo"selected";}?>>Individual</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status'>
			<option value='active' <?php if($obj->status=='active'){echo"selected";}?>>active</option>
			<option value='inactive' <?php if($obj->status=='inactive'){echo"selected";}?>>inactive</option>
		</select></td>
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