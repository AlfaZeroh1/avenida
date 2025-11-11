<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../patientprescriptions/Patientprescriptions_class.php");
require_once '../../fn/generaljournals/Generaljournals_class.php';
require_once '../../fn/generaljournalaccounts/Generaljournalaccounts_class.php';


include "../../../head.php";
?>

<script type="text/javascript" charset="utf-8">
$("#itemname").autocomplete("../../server/server/search.php?main=inv&module=items&field=name&where=inv_items.departmentid=1", {
	width: 260,
	selectFirst: false
});
$("#itemname").result(function(event, data, formatted) {
	if (data)
	{
		//$(this).parent().next().find("input").val(data[1]);
		document.getElementById("itemname").value=data[0];
		document.getElementById("itemsitemid").value=data[1];
		document.getElementById("costprice").value=data[9];
		document.getElementById("tradeprice").value=data[10];
		document.getElementById("itemsquantity").value=0;
		document.getElementById("available").value=data[20];
		document.getElementById("itemsprice").value=data[11];
		//}			
		
		
	}
		
});
</script>

<table>
				<tr>
					<td colspan="9" align="center">Current Patient: 
					<font color="red"><strong><?php echo initialCap($obj->name); ?></strong></font> <?php if($obj->admission=="Yes"){echo "--Admitted";}?>
					<input type="hidden" name="patienttreatmentid" id="patienttreatmentid" value="<?php echo $obj->patienttreatmentid; ?>"></td>
	</tr>
				<tr>
					<th>Item Description</th>
					<th>Cost Price</th>
					<th>Trade Price</th>					
					<th>Retail Price</th>
					<th>Available</th>
					<th>Quantity</th>
					<th>Frequency</th>
					<th>Duration(days)</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td><input type="text" name="itemname" id="itemname" size="30" tabindex="1" <?php echo $obj->itemname; ?>/>
						<input type="hidden" name="itemsitemid" id="itemsitemid" value="<?php echo $obj->itemsitemid; ?>"/></td>
					<td><input type="text" name="costprice" id="costprice" size="4" readonly="readonly" value="<?php echo $obj->costprice; ?>"/></td>	
					<td><input type="text" name="tradeprice" id="tradeprice" size="4" readonly="readonly" value="<?php echo $obj->tradeprice; ?>"/></td>
					<td><input type="text" name="itemsprice" id="itemsprice" size="4" tabindex="2" value="<?php echo $obj->itemsprice; ?>"/></td>
					<td><input type="text" name="available" id="available" size="4" readonly="readonly" value="<?php echo $obj->available; ?>"/></td>
					<td><input type="text" name="itemsquantity" id="itemsquantity" size="4" tabindex="3" onchange="checkQuantity();" value="<?php echo $obj->itemsquantity; ?>"/></td>
					<td><input type="text" name="frequency" id="frequency" size="4" value="<?php echo $obj->frequency; ?>"></td>
					<td><input type="text" name="duration" id="duration" size="4" value="<?php echo $obj->duration; ?>"></td>
					<td><input class="btn" type="submit" value="Add Item" name="action" tabindex="4"/></td>
					
				</tr>
</table>
						<table style="clear:both;"  class="tgrid display" id="prescriptions" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Item</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Frequency</th>
			<th>Duration(days)</th>
			<th>Total</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$patientprescriptions = new Patientprescriptions();
		$i=0;
		$fields="hos_patientprescriptions.id, inv_items.name as itemid, hos_patienttreatments.id, hos_patientprescriptions.quantity, hos_patientprescriptions.price, hos_patientprescriptions.Totals, hos_patientprescriptions.issued, hos_patientprescriptions.createdby, hos_patientprescriptions.createdon, hos_patientprescriptions.lasteditedby, hos_patientprescriptions.lasteditedon, hos_patientprescriptions.frequency, hos_patientprescriptions.duration ";
		$join=" left join inv_items on hos_patientprescriptions.itemid=inv_items.id  left join hos_patienttreatments on hos_patientprescriptions.patienttreatmentid=hos_patienttreatments.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hos_patientprescriptions.patienttreatmentid='$obj->treatmentid'";
		$patientprescriptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$patientprescriptions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
	<?php   
					$totals=formatNumber($row->price*$row->quantity);
	?>
		
			<tr>	
			<td><?php echo $i; ?></td>
			<td><?php echo $row->itemid; ?></td>
			<td><?php echo $row->quantity; ?></td>
			<td><?php echo formatNumber($row->price); ?></td>
			<td><?php echo $row->frequency; ?></td>
			<td><?php echo $row->duration; ?></td>
			<td align="right"><?php echo formatNumber($row->Totals);  ?></td>

			
			<td><a href="javascript:;" onclick="showPopWin('../patientprescriptions/addpatientprescriptions_proc.php?id=<?php echo $row->id; ?>', 600, 430);">Edit</a></td>
			<td><a href='../patientprescriptions/patientprescriptions.php?delid=<?php echo $row->id; ?>' onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
		</tr>
	<?php 
	}
	?>
	</tbody>
</table>