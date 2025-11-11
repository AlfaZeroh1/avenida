<title>WiseDigits ERP: Beds </title>
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
<form class="forms" id="theform" action="addbeds_proc.php" name="beds" method="POST" enctype="multipart/form-data">
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
		<td align="right">Ward : </td>
			<td><select name="wardid" class="selectbox">
<option value="">Select...</option>
<?php
	$wards=new Wards();
	$where="  ";
	$fields="hos_wards.id, hos_wards.name, hos_wards.departmentid, hos_wards.remarks, hos_wards.firstroom, hos_wards.lastroom, hos_wards.roomprefix, hos_wards.status, hos_wards.createdby, hos_wards.createdon, hos_wards.lasteditedby, hos_wards.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$wards->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($wards->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->wardid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Room Number : </td>
		<td><input type="text" name="roomno" id="roomno" value="<?php echo $obj->roomno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Beds : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> </td>
		<td><input type="hidden" name="status" id="status" value="<?php echo $obj->status; ?>"></td>
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