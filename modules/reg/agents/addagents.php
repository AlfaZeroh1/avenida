<title>WiseDigits ERP: Agents </title>
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
<form  id="theform" action="addagents_proc.php" name="agents" method="POST" enctype="multipart/form-data">
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
		<td align="right">Agent : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Agent ID : </td>
		<td><input type="text" name="agentid" id="agentid" value="<?php echo $obj->agentid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Agent Type : </td>
		<td><input type="text" name="agenttypeid" id="agenttypeid" value="<?php echo $obj->agenttypeid; ?>"></td>
	</tr>
	<tr>
		<td align="right">Region : </td>
			<td><select name="regionid" class="selectbox">
<option value="">Select...</option>
<?php
	$regions=new Regions();
	$where="  ";
	$fields="reg_regions.id, reg_regions.name, reg_regions.remarks, reg_regions.ipaddress, reg_regions.createdby, reg_regions.createdon, reg_regions.lasteditedby, reg_regions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$regions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($regions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->regionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Sub Region : </td>
			<td><select name="subregionid" class="selectbox">
<option value="">Select...</option>
<?php
	$subregions=new Subregions();
	$where="  ";
	$fields="reg_subregions.id, reg_subregions.name, reg_subregions.regionid, reg_subregions.remarks, reg_subregions.ipaddress, reg_subregions.createdby, reg_subregions.createdon, reg_subregions.lasteditedby, reg_subregions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$subregions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($subregions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->subregionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Contact Person : </td>
		<td><input type="text" name="contactperson" id="contactperson" value="<?php echo $obj->contactperson; ?>"></td>
	</tr>
	<tr>
		<td align="right">Telephone : </td>
		<td><input type="text" name="tel" id="tel" value="<?php echo $obj->tel; ?>"></td>
	</tr>
	<tr>
		<td align="right">Mobile : </td>
		<td><input type="text" name="mobile" id="mobile" value="<?php echo $obj->mobile; ?>"></td>
	</tr>
	<tr>
		<td align="right">E-mail : </td>
		<td><input type="text" name="email" id="email" value="<?php echo $obj->email; ?>"></td>
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