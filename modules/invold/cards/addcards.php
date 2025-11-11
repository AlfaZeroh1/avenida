<title>WiseDigits ERP: Cards </title>
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
<form  id="theform" action="addcards_proc.php" name="cards" method="POST" enctype="multipart/form-data">
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
		<td align="right">Card No. : </td>
		<td><input type="text" name="cardno" id="cardno" value="<?php echo $obj->cardno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Card Type : </td>
			<td><select name="cardtypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$cardtypes=new Cardtypes();
	$where="  ";
	$fields="inv_cardtypes.id, inv_cardtypes.name, inv_cardtypes.discount, inv_cardtypes.remarks, inv_cardtypes.createdby, inv_cardtypes.createdon, inv_cardtypes.lasteditedby, inv_cardtypes.lasteditedon, inv_cardtypes.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$cardtypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($cardtypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->cardtypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
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