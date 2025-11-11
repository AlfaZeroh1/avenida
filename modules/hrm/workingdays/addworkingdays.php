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
<form class="forms" id="theform" action="addworkingdays_proc.php" name="workingdays" method="POST" enctype="multipart/form-data">
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
		<td align="right">Day : </td>
		<td><select name="name" class="selectbox">
		  <option value="">Select...</option>
		  <option value="Monday" <?php if($obj->name=='Monday'){echo "selected";}?>>Monday</option>
		  <option value="Tuesday" <?php if($obj->name=='Tuesday'){echo "selected";}?>>Tuesday</option>
		  <option value="Wednesday" <?php if($obj->name=='Wednesday'){echo "selected";}?>>Wednesday</option>
		  <option value="Thursday" <?php if($obj->name=='Thursday'){echo "selected";}?>>Thursday</option>
		  <option value="Friday" <?php if($obj->name=='Friday'){echo "selected";}?>>Friday</option>
		  <option value="Saturday" <?php if($obj->name=='Saturday'){echo "selected";}?>>Saturday</option>
		  <option value="Sunday" <?php if($obj->name=='Sunday'){echo "selected";}?>>Sunday</option>
		  </select>
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