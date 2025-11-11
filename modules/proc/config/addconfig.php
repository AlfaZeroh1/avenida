<title>WiseDigits ERP: Config </title>
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
<form  id="theform" action="addconfig_proc.php" name="config" method="POST" enctype="multipart/form-data">
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
		<td><input type="text" name="name" readonly id="name" value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	<?php if($obj->id==3){ ?>
	
	<tr>
		<td align="right"> Value: </td>
		<td><select name="value">
		<?php 
		$liabilitys = new Liabilitys();
		$where="  ";
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$liabilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		while($row=mysql_fetch_object($liabilitys->result)){
		?>
		  <option value="<?php echo $row->id; ?>" <?php if($obj->value==$row->id){echo "selected";}?>><?php echo $row->name; ?></option>
		<?php
		}
		?>
		</select>
		</td>
	</tr>
	
	<? }else{ ?>
	<tr>
		<td align="right">Value : </td>
		<td><textarea name="value"><?php echo $obj->value; ?></textarea></td>
	</tr>
	<?php } ?>
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