<title>WiseDigits ERP: Surchages </title>
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
<form  id="theform" action="addsurchages_proc.php" name="surchages" method="POST" enctype="multipart/form-data">
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
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Surchage Type : </td>
		<td><select name="surchagetypeid" class="selectbox">
			<option value="">Select...</option>
			<?php
			$surchagetypes = new Surchagetypes();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where="";
			$surchagetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($row=mysql_fetch_object($surchagetypes->result)){
			  ?>
			  <option value="<?php echo $row->id; ?>" <?php if($obj->surchagetypeid==$row->id){echo "selected";}?>><?php echo $row->name; ?></option>
			  <?php
			}
			?>
		    </select>
		</td>
	</tr>
	<tr>
		<td align="right">Expense A/C : </td>
		<td><select name="expenseid" class="selectbox">
			<option value="">Select...</option>
			<?php
			$expenses = new Expenses();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where="";
			$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			while($row=mysql_fetch_object($expenses->result)){
			  ?>
			  <option value="<?php echo $row->id; ?>" <?php if($obj->expenseid==$row->id){echo "selected";}?>><?php echo $row->name; ?></option>
			  <?php
			}
			?>
		    </select>
		</td>
	</tr>
	<tr>
		<td align="right">From Month: </td>
		<td><select name="frommonth" id="frommonth" class="selectbox">
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
      </select>&nbsp;<select name="fromyear" id="fromyear" class="selectbox">
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
		<td align="right">To Month: </td>
		<td><select name="tomonth" id="tomonth" class="selectbox">
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
      </select>&nbsp;<select name="toyear" id="toyear" class="selectbox">
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
		<td align="right">Overall : </td>
		<td><select name='overall' class="selectbox">
			<option value='All' <?php if($obj->overall=='All'){echo"selected";}?>>All</option>
			<option value='Individual' <?php if($obj->overall=='Individual'){echo"selected";}?>>Individual</option>
		</select></td>
	</tr>
	
	<tr>
		<td align="right">Taxable : </td>
		<td>
			<input type="radio" name="taxable" value='Yes' <?php if($obj->taxable=='Yes'){echo"checked";}?>>Yes</option>
			<input type="radio" name="taxable" value='No' <?php if($obj->taxable=='No'){echo"checked";}?>>No</option>
		</td>
	</tr>
	
	<tr>
		<td align="right"> Status: </td>
		<td><select name='status' class="selectbox">
			<option value='Active' <?php if($obj->status=='Active'){echo"selected";}?>>Active</option>
			<option value='Not Active' <?php if($obj->status=='Not Active'){echo"selected";}?>>Not Active</option>
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
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>