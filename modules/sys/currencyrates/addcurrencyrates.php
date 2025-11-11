<title>WiseDigits ERP: Currencyrates </title>
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
<form  id="theform" action="addcurrencyrates_proc.php" name="currencyrates" method="POST" enctype="multipart/form-data">
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
		<td align="right">Currency : </td>
			<td><select name="currencyid" class="selectbox">
<option value="">Select...</option>
<?php
	$currencys=new Currencys();
	$where="  ";
	$fields="sys_currencys.id, sys_currencys.name, sys_currencys.rate, sys_currencys.eurorate, sys_currencys.remarks, sys_currencys.ipaddress, sys_currencys.createdby, sys_currencys.createdon, sys_currencys.lasteditedby, sys_currencys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($currencys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->currencyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Currency Date From : </td>
		<td><input type="text" name="fromcurrencydate" id="fromcurrencydate" class="date_input" size="12" readonly  value="<?php echo $obj->fromcurrencydate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Currency Date To : </td>
		<td><input type="text" name="tocurrencydate" id="tocurrencydate" class="date_input" size="12" readonly  value="<?php echo $obj->tocurrencydate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Kshs. Rate : </td>
		<td><input type="text" name="rate" id="rate" size="8"  value="<?php echo $obj->rate; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Euro Rate : </td>
		<td><input type="text" name="eurorate" id="eurorate" size="8"  value="<?php echo $obj->eurorate; ?>"><font color='red'>*</font></td>
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