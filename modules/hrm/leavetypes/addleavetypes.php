<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
<?php 
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
<form class="forms" id="theform" action="addleavetypes_proc.php" name="leavetypes" method="POST" enctype="multipart/form-data">
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
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"></td>
	</tr>
	<tr>
		<td align="right">Days Entitled : </td>
		<td><input type="text" name="noofdays" id="noofdays" value="<?php echo $obj->noofdays; ?>"></td>
	</tr>
	<tr>
		<td align="right">Type : </td>
		<td>
			<input type="radio" name="type" id="type" value='Working Days' <?php if($obj->type=='Working Days'){echo"checked";}?>>Working Days 
			<input type="radio" name="type" id="type" value='Calendar Days' <?php if($obj->type=='Calendar Days'){echo"checked";}?>>Calendar Days 
		</td>
	</tr>
	<tr>
		<td align="right">Maximum C/F : </td>
		<td><input type="text" name="maxcf" id="maxcf" value="<?php echo $obj->maxcf; ?>"></td>
	</tr>
	<tr>
		<td align="right">Earning Rate : </td>
		<td><input type="text" name="earningrate" id="earningrate" size="8"  value="<?php echo $obj->earningrate; ?>"></td>
	</tr>
	<tr>
		<td align="right">Per: </td>
		<td>
			<input type="radio" name="per" id="per" value='Week' <?php if($obj->per=='Week'){echo"checked";}?>>Week 
			<input type="radio" name="per" id="per" value='Month' <?php if($obj->per=='Month'){echo"checked";}?>>Month 
			<input type="radio" name="per" id="per" value='Year' <?php if($obj->per=='Year'){echo"checked";}?>>Year 
		</td>
	</tr>
	<tr>
		<td align="right">Gender : </td>
		<td>
			<input type="radio" name="gender" id="gender" value='Male' <?php if($obj->gender=='Male'){echo"checked";}?>>Male 
			<input type="radio" name="gender" id="gender" value='Female' <?php if($obj->gender=='Female'){echo"checked";}?>>Female 
			<input type="radio" name="gender" id="gender" value='Both' <?php if($obj->gender=='Both'){echo"checked";}?>>Both 
		</td>
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