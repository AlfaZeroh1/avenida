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
<form class="forms" id="theform" action="addleavesectiondetails_proc.php" name="leavesectiondetails" method="POST" enctype="multipart/form-data">
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
	$fields="hrm_leaves.id, hrm_leaves.name, hrm_leaves.days, hrm_leaves.remarks, hrm_leaves.ipaddress, hrm_leaves.createdby, hrm_leaves.createdon, hrm_leaves.lasteditedby, hrm_leaves.lasteditedon";
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
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Leave Section : </td>
			<td><select name="leavesectionid" class="selectbox">
<option value="">Select...</option>
<?php
	$leavesections=new Leavesections();
	$where="  ";
	$fields="hrm_leavesections.id, hrm_leavesections.name, hrm_leavesections.remarks, hrm_leavesections.ipaddress, hrm_leavesections.createdby, hrm_leavesections.createdon, hrm_leavesections.lasteditedby, hrm_leavesections.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leavesections->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($leavesections->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->leavesectionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Days : </td>
		<td><input type="text" name="days" id="days" size="8"  value="<?php echo $obj->days; ?>"></td>
	</tr>
	<tr>
		<td align="right">Notice Period : </td>
		<td><input type="text" name="duration" id="duration" value="<?php echo $obj->duration; ?>"></td>
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