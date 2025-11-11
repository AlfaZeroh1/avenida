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
<form class="forms" id="theform" action="addshifts_proc.php" name="shifts" method="POST" enctype="multipart/form-data">
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
		<td align="right">Ordered : </td>
		<td><input type="text" name="ordered" id="ordered" value="<?php echo $obj->ordered; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Paid : </td>
		<td><input type="text" name="paid" id="paid" value="<?php echo $obj->paid; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Balance : </td>
		<td><input type="text" name="balance" id="balance" value="<?php echo $obj->balance; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Submitted : </td>
		<td><input type="text" name="submitted" id="submitted" value="<?php echo $obj->submitted; ?>"></td>
	</tr>
	
	
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea><font color='red'>*</font></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-success" name="action" id="action" value="CLEAR">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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