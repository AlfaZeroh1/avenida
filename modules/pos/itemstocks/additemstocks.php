<title>WiseDigits ERP: Itemstocks </title>
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
<form  id="theform" action="additemstocks_proc.php" name="itemstocks" method="POST" enctype="multipart/form-data">
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
		<td align="right">Document No : </td>
		<td><input type="text" name="documentno" id="documentno" value="<?php echo $obj->documentno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date Code : </td>
		<td><input type="text" name="datecode" id="datecode" value="<?php echo $obj->datecode; ?>"></td>
	</tr>
	<tr>
		<td align="right">Product : </td>
			<td><select name="itemid" class="selectbox">
<option value="">Select...</option>
<?php
	$items=new Items();
	$where="  ";
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.price, pos_items.tax, pos_items.stock, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($items->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->itemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Customer : </td>
			<td><select name="customerid" class="selectbox">
<option value="">Select...</option>
<?php
	$customers=new Customers();
	$where="  ";
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($customers->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->customerid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Action : </td>
		<td><input type="text" name="transaction" id="transaction" value="<?php echo $obj->transaction; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Quantity : </td>
		<td><input type="text" name="quantity" id="quantity" size="8"  value="<?php echo $obj->quantity; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Remain : </td>
		<td><input type="text" name="remain" id="remain" size="8"  value="<?php echo $obj->remain; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date Recorded : </td>
		<td><input type="text" name="recordedon" id="recordedon" class="date_input" size="12" readonly  value="<?php echo $obj->recordedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Date Of Action : </td>
		<td><input type="text" name="actedon" id="actedon" class="date_input" size="12" readonly  value="<?php echo $obj->actedon; ?>"></td>
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