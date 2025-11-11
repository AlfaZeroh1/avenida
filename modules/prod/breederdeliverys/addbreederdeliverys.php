<title>WiseDigits ERP: Breederdeliverys </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#breedername").autocomplete({
	source:"../../../modules/server/server/search.php?main=prod&module=breeders&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#breederid").val(ui.item.id);
	}
  });

});
<?php include'js.php'; ?>
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
<form  id="theform" action="addbreederdeliverys_proc.php" name="breederdeliverys" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input class="btn btn-info" type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Delivery No:</label></td>
<td><input type="text" name="documentno" readonly id="documentno" size="4"  value="<?php echo $obj->documentno; ?>">			</td>
			</tr>
			<tr>
				<td><label>Breeder:</label></td>
				<td><input type='text' size='20' name='breedername' id='breedername' value='<?php echo $obj->breedername; ?>'>
					<input type="hidden" name='breederid' id='breederid' value='<?php echo $obj->breederid; ?>'></td>
			</td>
			</tr>
			<tr>
				<td><label>Date Delivered:</label></td>
<td><input type="text" name="deliveredon" id="deliveredon" class="date_input" size="12" readonly  value="<?php echo $obj->deliveredon; ?>">			</td>
			</tr>
			<tr>
				<td><label>Calendar Week:</label></td>
<td><select name="week" id="week" class="selectbox">
        <option value="">Select...</option>
        <?php
        $i=1;
        while($i<53){
        ?>
        <option value="<?php echo $i; ?>" <?php if($obj->week==$i){echo"selected";}?>>WK <?php echo $i; ?></option>
        <?php
        $i++;
        }
        ?>
      </select></td>
			</tr>
			<td>
		<label>Remarks:</label>			</td>
			<td>
<textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea>			</td>
			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Variety  </th>
		<th align="right">Quantity  </th>
		<th align="right">Memo  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="varietyid"  class="selectbox">
<option value="">Select...</option>
<?php
	$varietys=new Varietys();
	$where="  ";
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($varietys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->varietyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
<font color='red'>*</font>		<td><input type="text" name="quantity" id="quantity" size="4" value="<?php echo $obj->quantity; ?>"></td>
		<td><textarea name="memo" id="memo"><?php echo $obj->memo; ?></textarea></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Variety  </th>
		<th align="left">Quantity  </th>
		<th align="left">Memo  </th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpbreederdeliverys']){
		$shpbreederdeliverys=$_SESSION['shpbreederdeliverys'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpbreederdeliverys[$i]['varietyname']; ?> </td>
			<td><?php echo $shpbreederdeliverys[$i]['quantity']; ?> </td>
			<td><?php echo $shpbreederdeliverys[$i]['memo']; ?> </td>
			<td><?php echo $shpbreederdeliverys[$i]['total']; ?> </td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=edit&edit=<?php echo $obj->edit; ?>">Edit</a></td>
			<td><a href="edit.php?i=<?php echo $i; ?>&action=del&edit=<?php echo $obj->edit; ?>">Del</a></td>
		</tr>
		<?php
		$i++;
		$j--;
		}
	}
	?>
	</tbody>
</table>
<table align="center" width="100%">
	<?php if(empty($obj->retrieve)){?>
	<tr>
		<td colspan="2" align="center"><input class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
	<?php }else{?>
	<tr>
		<td colspan="2" align="center"><input class="btn btn-info" type="button" name="action" id="action" value="Print" onclick="Clickheretoprint();"/></td>
	</tr>
	<?php }?>
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
if($saved=="Yes"){
	redirect("addbreederdeliverys_proc.php?retrieve=");
}

?>