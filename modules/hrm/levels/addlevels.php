<title>WiseDigits ERP: Levels </title>
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
<form  id="theform" action="addlevels_proc.php" name="levels" method="POST" enctype="multipart/form-data">
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
		<td align="right">Level : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Max In Organisation : </td>
		<td><input type="text" name="overallno" id="overallno" value="<?php echo $obj->overallno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Max In Each Dept : </td>
		<td><input type="text" name="deptno" id="deptno" value="<?php echo $obj->deptno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Comes After : </td>
		<td><select name="follows" id="follows" class="selectbox">
		  <option value="">Select...</option>
		  <?php
		  $levels=new Levels();
		  $fields="hrm_levels.id, hrm_levels.name, hrm_levels.overallno, hrm_levels.deptno, hrm_levels.follows, hrm_levels.remarks, hrm_levels.ipaddress, hrm_levels.createdby, hrm_levels.createdon, hrm_levels.lasteditedby, hrm_levels.lasteditedon";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where="";
		  $levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $res=$levels->result;
		  while($row=mysql_fetch_object($res)){
		    ?>
		    <option value="<?php echo $row->id; ?>" <?php if($obj->follows==$row->id){echo"selected";}?>><?php echo initialCap($row->name); ?>
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