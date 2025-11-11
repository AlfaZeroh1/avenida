<title>WiseDigits: Employeeleaves </title>
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
  <script type="text/javascript">
$().ready(function() {
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)))",
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
<script type="text/javascript">
function checkdays(day){
try{
alert(day);
}catch(e){alert(e);}
}
  
</script>

<form action="addemployeeleaves_proc.php" name="employeeleaves"  method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
<?php   
        if ($obj->action=="Send Back" or $obj->action=="Grant" or $obj->action=="Decline")
        {
        $id=$_GET['lid'];
        $employeeleaves=new Employeeleaves();
	$fields=" concat(concat(hrm_employees.firstname,' ',hrm_employees.middlename),' ',hrm_employees.lastname) employeename,hrm_employees.id as emmployeeid,hrm_employees.id,hrm_leaves.name as leaveid,hrm_employeeleaves.* ";
	$join=" left join hrm_leaves on hrm_leaves.id=hrm_employeeleaves.leaveid left join hrm_employees on hrm_employees.id=hrm_employeeleaves.employeeid ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where hrm_employeeleaves.id='$id' ";
	$employeeleaves->retrieve($fields,$join,$where,$having,$groupby,$orderby);
        $res=$employeeleaves->result;
	while($rw=mysql_fetch_object($res)){ 
	$obj->startdate=$rw->startdate;
	$obj->duration=$rw->duration;
	$obj->leaveid=$rw->leaveid;
	$obj->employeename=$rw->employeename;
	$obj->employeeid=$rw->employeeid;
	$obj->status=$rw->status;	
        $obj->id=$id;
	}
	}
?>
	<tr>
	        <td><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
		<td><input type="hidden" name="status" id="status" value="<?php if ($obj->action=="Send Back"){echo 'sent back';}else if ($obj->action=="Grant"){echo 'granted';}else if ($obj->action=="Decline"){echo 'declined';}else{echo 'pending';} ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
<!--	<tr>
		<td align="right">Leave Application : </td>
		<td><input type="text" name="employeeleaveapplicationid" id="employeeleaveapplicationid" value="<?php echo $obj->employeeleaveapplicationid; ?>"><font color='red'>*</font></td>
	</tr>-->
	<tr>
	  <td align="right">Employee:</td>
	  <td><input type='text' size='48' name='employeename' <?php if($obj->status=='pending'){ echo "readonly";}?> id='employeename' value='<?php echo $obj->employeename; ?>'>
	 <input type="text" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'></td>
	</td>
	</tr>
	<tr>
		<td align="right">Leave : </td>
			<td><select name="leaveid" <?php if($obj->status=='pending'){ echo "readonly";}?>  id="leaveid" class="selectbox">
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
		<td align="right">Start Date : </td>
		<td><input type="text" name="startdate" <?php if($obj->status=='pending'){ echo "readonly";}?> id="startdate" class="date_input" size="12" readonly  value="<?php echo $obj->startdate; ?>"></td>
	</tr>
	<tr>        
		<td align="right">Duration(Days) : </td>
		<td><input type="text" name="duration" <?php if($obj->status=='pending'){ echo "readonly";}?> id="duration" value="<?php echo $obj->duration; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<?php }?>
</table>
</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>