<title>WiseDigits: Fleetaccidents </title>
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
<form class="forms" id="theform" action="addfleetaccidents_proc.php" name="fleetaccidents" method="POST" enctype="multipart/form-data">
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
		<td align="right">Vehicle : </td>
		<td><input type="text" name="fleetid" id="fleetid" value="<?php echo $obj->fleetid; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea><font color='red'>*</font></td>
	</tr>
	
	<tr>
		<td align="right">Accident Date : </td>
		<td><input type="text" name="accidentdate" id="accidentdate" class="date_input" size="12" readonly  value="<?php echo $obj->accidentdate; ?>"><font color='red'>*</font></td>
		
	</tr>
	</select><font color='red'><?php $obj->oldimage=$obj->image; ?><input type="hidden" name="oldimage" value="<?php echo $obj->oldimage; ?>"/>*</font>
		</td>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right"> Photo : </td>
		<td><?php if(!empty($obj->image)){?><img src="photos/<?php echo $obj->image; ?>" width="100" height="100"/><?php }?><input type="file" name="image" id="image" value="<?php echo $obj->image; ?>"></td>
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