<title>WiseDigits ERP: Irrigationmixtures </title>
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
<form  id="theform" action="addirrigationmixtures_proc.php" name="irrigationmixtures" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input class="btn btn-info" type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">  </td>
			<td><input type="hidden" name="irrigationid"  value="<?php echo $obj->irrigationid; ?>"/>

		</td>
	</tr>
	<tr>
		<td align="right">Tank : </td>
			<td><select name="tankid" class="selectbox">
<option value="">Select...</option>
<?php
	$tanks=new Irrigationtanks();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tanks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($tanks->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->tankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Water Volume : </td>
		<td><input type="text" name="water" id="water" size="8"  value="<?php echo $obj->water; ?>"></td>
	</tr>
	<tr>
		<td align="right">EC Level : </td>
		<td><input type="text" name="ec" id="ec" size="8"  value="<?php echo $obj->ec; ?>"></td>
	</tr>
	<tr>
		<td align="right">PH : </td>
		<td><input type="text" name="ph" id="ph" size="8"  value="<?php echo $obj->ph; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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