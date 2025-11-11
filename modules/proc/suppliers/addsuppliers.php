<title>WiseDigits ERP: Suppliers </title>
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
 	
  $("#suppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=suppliers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#supplierid").val(ui.item.id);
	}
  });

 } );
 </script>

<div class='main'>
<form class="forms" id="theform" action="addsuppliers_proc.php" name="suppliers" method="POST" enctype="multipart/form-data">
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
		<td align="right">Code : </td>
		<td><input type="text" name="code" id="code" value="<?php echo $obj->code; ?>"></td>
	</tr>
	<tr>
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" value="<?php echo $obj->name; ?>"></td>
	</tr>
	<?php if(empty($obj->merge)){ ?>
	<tr>
		<td align="right">Supplier Category : </td>
			<td><select name="suppliercategoryid" class="selectbox">
<option value="">Select...</option>
<?php
	$suppliercategorys=new Suppliercategorys();
	$where="  ";
	$fields="proc_suppliercategorys.id, proc_suppliercategorys.name, proc_suppliercategorys.remarks, proc_suppliercategorys.createdby, proc_suppliercategorys.createdon, proc_suppliercategorys.lasteditedby, proc_suppliercategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliercategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($suppliercategorys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->suppliercategoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
			  <td align="right">Currency</td>
			  <td><select name="currencyid" class="selectbox">
				<option value="">Select...</option>
				<?php
				$currencys = new Currencys();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" ";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($currencys->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->currencyid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select></td>
	</tr>
	<tr>
			  <td align="right">Country</td>
			  <td><select name="countryid" class="selectbox">
				<option value="">Select...</option>
				<?php
				$countrys = new Countrys();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby="";
				$where=" ";
				$countrys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($countrys->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->countryid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select></td>
	</tr>
	<tr>
		<td align="right">Region : </td>
			<td><select name="regionid" class="selectbox">
<option value="">Select...</option>
<?php
	$regions=new Regions();
	$where="  ";
	$fields="sys_regions.id, sys_regions.name, sys_regions.remarks, sys_regions.ipaddress, sys_regions.createdby, sys_regions.createdon, sys_regions.lasteditedby, sys_regions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$regions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($regions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->regionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Sub Region : </td>
			<td><select name="subregionid" class="selectbox">
<option value="">Select...</option>
<?php
	$subregions=new Subregions();
	$where="  ";
	$fields="sys_subregions.id, sys_subregions.name, sys_subregions.regionid, sys_subregions.remarks, sys_subregions.ipaddress, sys_subregions.createdby, sys_subregions.createdon, sys_subregions.lasteditedby, sys_subregions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$subregions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($subregions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->subregionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Contact : </td>
		<td><input type="text" name="contact" id="contact" value="<?php echo $obj->contact; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Physical Address : </td>
		<td><textarea name="physicaladdress"><?php echo $obj->physicaladdress; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Phone No. : </td>
		<td><input type="text" name="tel" id="tel" value="<?php echo $obj->tel; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Pin No. : </td>
		<td><input type="text" name="pinno" id="pinno" value="<?php echo $obj->pinno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Vat No. : </td>
		<td><input type="text" name="vatno" id="vatno" value="<?php echo $obj->vatno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Etr No. : </td>
		<td><input type="text" name="etrno" id="etrno" value="<?php echo $obj->etrno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Fax : </td>
		<td><input type="text" name="fax" id="fax" value="<?php echo $obj->fax; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">E-mail : </td>
		<td><input type="text" name="email" id="email" value="<?php echo $obj->email; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Cell-Phone : </td>
		<td><input type="text" name="cellphone" id="cellphone" value="<?php echo $obj->cellphone; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Status : </td>
		<td><select name='status' class="selectbox">
			<option value='Active' <?php if($obj->status=='Active'){echo"selected";}?>>Active</option>
			<option value='Suspended' <?php if($obj->status=='Suspended'){echo"selected";}?>>Suspended</option>
			<option value='Blocked' <?php if($obj->status=='Blocked'){echo"selected";}?>>Blocked</option>
		</select></td>
	</tr>
	<?php }else{ ?>
	<tr>
		<td align="right">Merge To:</td>
		<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
		<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->supplierid; ?>'></td>
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