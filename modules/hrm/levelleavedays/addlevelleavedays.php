<title>WiseDigits ERP: Levelleavedays </title>
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
<form  id="theform" action="addlevelleavedays_proc.php" name="levelleavedays" method="POST" enctype="multipart/form-data">
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
		<td align="right">Leave : </td>
			<td><select name="leaveid" class="selectbox">
<option value="">Select...</option>
<?php
	$leaves=new Leaves();
	$where="  ";
	$fields="hrm_leaves.id, hrm_leaves.name, hrm_leaves.days, hrm_leaves.remarks, hrm_leaves.createdby, hrm_leaves.createdon, hrm_leaves.lasteditedby, hrm_leaves.lasteditedon, hrm_leaves.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($leaves->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->leaveid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Level: </td>
			<td><select name="levelid" class="selectbox">
<option value="">Select...</option>
<?php
	$levels=new Levels();
	$where="  ";
	$fields="hrm_levels.id, hrm_levels.name, hrm_levels.overallno, hrm_levels.deptno, hrm_levels.follows, hrm_levels.remarks, hrm_levels.ipaddress, hrm_levels.createdby, hrm_levels.createdon, hrm_levels.lasteditedby, hrm_levels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($levels->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->levelid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right"> No OF Days: </td>
		<td><input type="text" name="leavedays" id="leavedays" size="8"  value="<?php echo $obj->leavedays; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><input type="text" name="remarks" id="remarks" value="<?php echo $obj->remarks; ?>"></td>
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