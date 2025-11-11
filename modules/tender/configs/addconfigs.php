<title>WiseDigits ERP: Configs </title>
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
<form  id="theform" action="addconfigs_proc.php" name="configs" method="POST" enctype="multipart/form-data">
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
		<td align="right">Config Title : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Value : </td>
			<td><select name="documentsid" class="selectbox">
<option value="">Select...</option>
<?php
	$documentss=new Documentss();
	$where=" where dms_documentss.categoryid=1  ";
	$fields="dms_documentss.id, dms_documentss.routeid, dms_documentss.documentno, dms_documenttypes.name documenttypeid, dms_documentss.departmentid, dms_documentss.departmentcategoryid, dms_documentss.categoryid, dms_documentss.hrmdepartmentid, dms_documentss.document, dms_documentss.link, dms_documentss.status, dms_documentss.expirydate, dms_documentss.description, dms_documentss.remarks, dms_documentss.ipaddress, dms_documentss.createdby, dms_documentss.createdon, dms_documentss.lasteditedby, dms_documentss.lasteditedon";
	$join=" left join dms_documenttypes on dms_documenttypes.id=dms_documentss.documenttypeid ";
	$having="";
	$groupby="";
	$orderby="";
	$documentss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($documentss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->documentsid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->documenttypeid);?> >> <?php echo $rw->document; ?></option>
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