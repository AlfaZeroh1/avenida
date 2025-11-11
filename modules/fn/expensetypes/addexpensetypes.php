<title>WiseDigits: Expensetypes </title>
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
<form class="forms" id="theform" action="addexpensetypes_proc.php" name="expensetypes" method="POST" enctype="multipart/form-data">
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
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>">
		<input type="hidden" name="oldacctypeid" id="oldacctypeid" value="<?php echo $obj->oldacctypeid; ?>"/>
		<font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Priority : </td>
		<td colspan="2"><input type="text" name="priority" id="priority" value="<?php echo $obj->priority; ?>"></td>
	</tr>
	<tr>
		<td align="right">Type : </td>
		<td>
		<select name="acctypeid" class="selectbox" onChange="loadP(this.value);">
		    <option value="">Select...</option>
		    <?php
		    $acctypes = new Acctypes();
		    $fields="*";
		    $where=" where id in(4,26) ";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    while($row=mysql_fetch_object($acctypes->result)){
		      ?>
			<option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->acctypeid){echo "selected";} ?>><?php echo $row->name; ?></option>
		      <?php
		    }
		    ?>
		  </select>
		<font color='red'>*</font></td>
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
if(!empty($error)){
	showError($error);
}
?>