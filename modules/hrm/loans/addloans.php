<title>WiseDigits ERP: Loans </title>
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
<form  id="theform" action="addloans_proc.php" name="loans" method="POST" enctype="multipart/form-data">
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
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Method : </td>
		<td><select name='method' class="selectbox">
			<option value='straight-line' <?php if($obj->method=='straight-line'){echo"selected";}?>>straight-line</option>
			<option value='reducing balance' <?php if($obj->method=='reducing balance'){echo"selected";}?>>reducing balance</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Type : </td>
		<td><select name='type' class="selectbox">
			<option value='Office' <?php if($obj->type=='Office'){echo"selected";}?>>Office</option>
			<option value='Bank' <?php if($obj->type=='Bank'){echo"selected";}?>>Bank</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Income : </td>
			<td><select name="incomeid" class="selectbox">
<option value="">Select...</option>
<?php
	$incomes=new Incomes();
	$where="  ";
	$fields="fn_incomes.id, fn_incomes.name, fn_incomes.code, fn_incomes.remarks, fn_incomes.ipaddress, fn_incomes.createdby, fn_incomes.createdon, fn_incomes.lasteditedby, fn_incomes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$incomes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($incomes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->incomeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Liability Acct : </td>
			<td><select name="liabilityid" class="selectbox">
			  <option value="">Select...</option>
			  <?php
				  $liabilitys=new Liabilitys();
				  $where="  ";
				  $fields="*";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $liabilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				  while($rw=mysql_fetch_object($liabilitys->result)){
				  ?>
					  <option value="<?php echo $rw->id; ?>" <?php if($obj->liabilityid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				  <?php
				  }
				  ?>
			  </select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Description : </td>
		<td><textarea name="description"><?php echo $obj->description; ?></textarea></td>
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
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>