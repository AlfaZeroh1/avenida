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
<form class="forms" id="theform" action="addbranches_proc.php" name="branches" method="POST" enctype="multipart/form-data">
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
		<td align="right">Name: </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Type : </td>
		<td>
			<input type="radio" name="type" id="type" value='Store' <?php if($obj->type=='Store'){echo"checked";}?>>Store 
			<input type="radio" name="type" id="type" value='Center' <?php if($obj->type=='Center'){echo"checked";}?>>Sales Point 
			<input type="radio" name="type" id="type" value='HQ' <?php if($obj->type=='HQ'){echo"checked";}?>>HQ 
			<input type="radio" name="type" id="type" value='External' <?php if($obj->type=='External'){echo"checked";}?>>External 
		</td>
	</tr>
	
	<tr>
		<td align="right">Visible : </td>
		<td>
			<input type="radio" name="visible" id="visible" value='global' <?php if($obj->visible=='global'){echo"checked";}?>>Global 
			<input type="radio" name="visible" id="visible" value='specific' <?php if($obj->visible=='specific'){echo"checked";}?>>Specific Point 
		</td>
	</tr>
	
	
	<tr>
		<td align="right">Printer : </td>
		<td><textarea name="printer"><?php echo $obj->printer; ?></textarea></td>
	</tr>
	
	<tr>
		<td align="right">Printer2 : </td>
		<td><textarea name="printer2"><?php echo $obj->printer2; ?></textarea></td>
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
