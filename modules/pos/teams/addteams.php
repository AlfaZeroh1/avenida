<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
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

<div id="tabs-1" style="min-height:700px;">
<form class="forms" id="theform" action="addteams_proc.php" name="teams" method="POST" enctype="multipart/form-data">
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
		<td align="right">Location : </td>
			<td><select name="brancheid" class="selectbox">
<option value="">Select...</option>
<?php
	$branches=new Branches();
	$where="  ";
	$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.type, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($branches->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->brancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Shift : </td>
			<td><select name="shiftid" class="selectbox">
<option value="">Select...</option>
<?php
	$shifts=new Shifts();
	$where="  ";
	$fields="pos_shifts.id, pos_shifts.name, pos_shifts.starttime, pos_shifts.enddate, pos_shifts.remarks, pos_shifts.ipaddress, pos_shifts.createdby, pos_shifts.createdon, pos_shifts.lasteditedby, pos_shifts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$shifts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($shifts->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->shiftid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Startedon : </td>
		<td><input type="text" name="startedon" id="startedon" class="date_input" size="12" readonly  value="<?php echo $obj->startedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Ended On : </td>
		<td><input type="text" name="endedon" id="endedon" class="date_input" size="12" readonly  value="<?php echo $obj->endedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Teamed On : </td>
		<td><input type="text" name="teamedon" id="teamedon" class="date_input" size="12" readonly  value="<?php echo $obj->teamedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>