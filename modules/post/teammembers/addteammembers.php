<title>WiseDigits ERP: Teammembers </title>
<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid").val(ui.item.id);
	}
  });

});
 </script>
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
<form  id="theform" action="addteammembers_proc.php" name="teammembers" method="POST" enctype="multipart/form-data">
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
		<td align="right">Team : </td>
			<td><select name="teamid" class="selectbox">
<option value="">Select...</option>
<?php
	$teams=new Teams();
	$where="  ";
	$fields="post_teams.id, post_teams.name, post_teams.remarks, post_teams.ipaddress, post_teams.createdby, post_teams.createdon, post_teams.lasteditedby, post_teams.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($teams->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->teamid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Member : </td>
			<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Role : </td>
			<td><select name="teamroleid" class="selectbox">
<option value="">Select...</option>
<?php
	$teamroles=new Teamroles();
	$where="  ";
	$fields="post_teamroles.id, post_teamroles.name, post_teamroles.remarks, post_teamroles.ipaddress, post_teamroles.createdby, post_teamroles.createdon, post_teamroles.lasteditedby, post_teamroles.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$teamroles->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($teamroles->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->teamroleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Constituted On : </td>
		<td><input type="text" name="teamedon" id="teamedon" class="date_input" size="12" readonly  value="<?php echo $obj->teamedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input  class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input  class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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