<title>WiseDigits: Expensecategorys </title>
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

<form class="forms" action="addexpensecategorys_proc.php" name="expensecategorys" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expense Category : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Expense Type : </td>
		<td>
		  <select name="expensetypeid" class="selectbox">
		    <option value="">Select...</option>
		    <?php
		    $expensetypes = new Expensetypes();
		    $fields="*";
		    $where="  ";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $expensetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    while($row=mysql_fetch_object($expensetypes->result)){
		      ?>
			<option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->expensetypeid){echo "selected";} ?>><?php echo $row->name; ?></option>
		      <?php
		    }
		    ?>
		  </select>&nbsp;
		</td>
	</tr>
	
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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