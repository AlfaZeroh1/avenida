<title>WiseDigits: Documentflows </title>
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
<form  id="theform" action="adddocumentflows_proc.php" name="documentflows" method="POST" enctype="multipart/form-data">
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
		<td align="right">Document : </td>
			<td><select name="documentid">
<option value="">Select...</option>
<?php
	$documents=new Documents();
	$where="  ";
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documents->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($documents->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->documentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status'>
			<option value='Delegated' <?php if($obj->status=='Delegated'){echo"selected";}?>>Delegated</option>
			<option value='Rejected' <?php if($obj->status=='Rejected'){echo"selected";}?>>Rejected</option>
			<option value='Approved' <?php if($obj->status=='Approved'){echo"selected";}?>>Approved</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Document : </td>
		<td><input type="text" name="document" id="document" value="<?php echo $obj->document; ?>"></td>
	</tr>
	<tr>
		<td align="right">Document Link : </td>
		<td><textarea name="link"><?php echo $obj->link; ?></textarea></td>
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