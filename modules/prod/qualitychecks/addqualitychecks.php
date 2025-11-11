<title>WiseDigits ERP: Qualitychecks </title>
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

<div class='main'>
<form  id="theform" action="addqualitychecks_proc.php" name="qualitychecks" method="POST" enctype="multipart/form-data">
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
 <?php if(!empty($obj->retrieve)){?>
	<tr>
		<td colspan="4" align="center"><input type="hidden" name="retrieve" value="<?php echo $obj->retrieve; ?>"/>Document No:<input type="text" size="4" name="invoiceno"/>&nbsp;<input class="btn btn-info" type="submit" name="action" value="Filter"/></td>
	</tr>
	<?php }?>
			<tr>
				<td><label>Breeder:</label></td>
<td><select name="breederid" id="breederid" class="selectbox">
<option value="">Select...</option>
<?php
	$breeders=new Breeders();
	$where="  ";
	$fields="prod_breeders.id, prod_breeders.code, prod_breeders.name, prod_breeders.contact, prod_breeders.physicaladdress, prod_breeders.tel, prod_breeders.fax, prod_breeders.email, prod_breeders.cellphone, prod_breeders.status, prod_breeders.createdby, prod_breeders.createdon, prod_breeders.lasteditedby, prod_breeders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breeders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($breeders->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->breederid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>			</td>
			</tr>
			<tr>
				<td><label>Check Date:</label></td>
<td><input type="text" name="checkedon" id="checkedon" class="date_input" size="12" readonly  value="<?php echo $obj->checkedon; ?>">			</td>
			</tr>
		</table>
	<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
	<tr>
		<th align="right">Check Item  </th>
		<th align="right">Delivery  </th>
		<th align="right">Variety  </th>
		<th align="right">Findings  </th>
		<th align="right">Remarks  </th>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><select name="checkitemid"  class="selectbox">
<option value="">Select...</option>
<?php
	$checkitems=new Checkitems();
	$where="  ";
	$fields="prod_checkitems.id, prod_checkitems.name, prod_checkitems.remarks, prod_checkitems.ipaddress, prod_checkitems.createdby, prod_checkitems.createdon, prod_checkitems.lasteditedby, prod_checkitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checkitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($checkitems->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->checkitemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
<font color='red'>*</font>		<td>
<?php
$breederdeliverydetails=new Breederdeliverydetails();
	$where="  ";
	$fields="prod_breederdeliverydetails.id, prod_breederdeliverys.documentno, prod_breederdeliverys.week, prod_breederdeliverydetails.breederdeliveryid, prod_varietys.name varietyid, prod_breederdeliverydetails.quantity, prod_breederdeliverydetails.memo, prod_breederdeliverydetails.ipaddress, prod_breederdeliverydetails.createdby, prod_breederdeliverydetails.createdon, prod_breederdeliverydetails.lasteditedby, prod_breederdeliverydetails.lasteditedon";
	$join=" left join prod_breederdeliverys on prod_breederdeliverys.id=prod_breederdeliverydetails.breederdeliveryid left join prod_varietys on prod_varietys.id=prod_breederdeliverydetails.varietyid";
	$having="";
	$groupby="";
	$orderby="";
	$breederdeliverydetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
?>
<select name="breederdeliverydetailid"  class="selectbox">
<option value="">Select...</option>
<?php
	

	while($rw=mysql_fetch_object($breederdeliverydetails->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->breederdeliveryid==$rw->id){echo "selected";}?>><?php echo $rw->documentno." - ".initialCap($rw->varietyid)." - WK".$rw->week;?></option>
	<?php
	}
	?>
</select>
		</td>
<font color='red'>*</font>		<td><select name="varietyid"  class="selectbox">
<option value="">Select...</option>
<?php
	$varietys=new Varietys();
	$where="  ";
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
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
<font color='red'>*</font>		<td><textarea name="findings" id="findings"><?php echo $obj->findings; ?></textarea><font color='red'>*</font></td>
		<td><textarea name="remarks" id="remarks"><?php echo $obj->remarks; ?></textarea></td>
	<td><input type="submit" name="action2" value="Add"/></td>
	</tr>
	</table>
<table style="clear:both" class="tgrid display" id="example" cellpadding="0" align="center" width="100%" cellspacing="0">
	<thead>
	<tr style="font-size:18px; vertical-align:text-top; ">
		<th align="left" >#</th>
		<th align="left">Check Item  </th>
		<th align="left">Delivery  </th>
		<th align="left">Variety  </th>
		<th align="left">Findings  </th>
		<th align="left">Remarks  </th>
		<th><input type="hidden" name="iterator" value="<?php echo $obj->iterator; ?>"/></th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	if($_SESSION['shpqualitychecks']){
		$shpqualitychecks=$_SESSION['shpqualitychecks'];
		$i=0;
		$j=$obj->iterator;
		$total=0;
		while($j>0){
		?>
		<tr style="font-size:12px; vertical-align:text-top; ">
			<td><?php echo ($i+1); ?></td>
			<td><?php echo $shpqualitychecks[$i]['checkitemid']; ?> </td>
			<td><?php echo $shpqualitychecks[$i]['breederdeliverydetailname']; ?> </td>
			<td><?php echo $shpqualitychecks[$i]['varietyname']; ?> </td>
			<td><?php echo $shpqualitychecks[$i]['findings']; ?> </td>
			<td><?php echo $shpqualitychecks[$i]['remarks']; ?> </td>
			<td><?php echo $shpqualitychecks[$i]['total']; ?> </td>
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
	redirect("addqualitychecks_proc.php?retrieve=");
}

?>