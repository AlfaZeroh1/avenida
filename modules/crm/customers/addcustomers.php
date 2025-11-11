<title>WiseDigits ERP: Customers </title>
<?php 
$pop=1;
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=name",
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
<form  id="theform" action="addcustomers_proc.php" name="customers" method="POST" enctype="multipart/form-data">
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
		<td align="right">Customer Name : </td>
		<td><input type="text" name="name" id="name" size="45"  value="<?php echo $obj->name; ?>"><font color='red'>*</font></td>
	</tr>
	
	<tr>
		<td align="right">Parent : </td>
			<td><select name="customerid" class="selectbox">
<option value="">Select...</option>
<?php
	$customers=new Customers();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby=" order by name ";
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
		<td align="right">Agent Name : </td>
			<td><select name="agentid" class="selectbox">
<option value="">Select...</option>
<?php
	$agents=new Agents();
	$where="  ";
	$fields="crm_agents.id, crm_agents.name, crm_agents.address, crm_agents.tel, crm_agents.fax, crm_agents.email, crm_agents.statusid, crm_agents.remarks, crm_agents.createdby, crm_agents.createdon, crm_agents.lasteditedby, crm_agents.lasteditedon, crm_agents.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agents->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($agents->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->agentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Department : </td>
			<td><select name="departmentid" class="selectbox">
<option value="">Select...</option>
<?php
	$departments=new Departments();
	$where="  ";
	$fields="crm_departments.id, crm_departments.name, crm_departments.remarks, crm_departments.createdby, crm_departments.createdon, crm_departments.lasteditedby, crm_departments.lasteditedon, crm_departments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($departments->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Continent : </td>
			<td><select name="continentid" class="selectbox">
<option value="">Select...</option>
<?php
	$continents=new Continents();
	$where="  ";
	$fields="crm_continents.id, crm_continents.name, crm_continents.remarks, crm_continents.ipaddress, crm_continents.createdby, crm_continents.createdon, crm_continents.lasteditedby, crm_continents.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$continents->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($continents->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->continentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Country : </td>
			<td><select name="countryid" class="selectbox">
<option value="">Select...</option>
<?php
	$countrys=new Countrys();
	$where="  ";
	$fields="crm_countrys.id, crm_countrys.name, crm_countrys.continentid, crm_countrys.remarks, crm_countrys.ipaddress, crm_countrys.createdby, crm_countrys.createdon, crm_countrys.lasteditedby, crm_countrys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$countrys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($countrys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->countryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Currency : </td>
			<td><select name="currencyid" class="selectbox">
<option value="">Select...</option>
<?php
	$currencys=new Currencys();
	$where="  ";
	$fields="sys_currencys.id, sys_currencys.name, sys_currencys.rate, sys_currencys.remarks, sys_currencys.ipaddress, sys_currencys.createdby, sys_currencys.createdon, sys_currencys.lasteditedby, sys_currencys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($currencys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->currencyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	
	<tr>
		<td align="right">Sale Type : </td>
			<td>
			<?php
			$saletypes=new Saletypes();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$saletypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			?>
			<select name="saletypeid" class="selectbox">
<option value="">Select...</option>
<?php

	while($rw=mysql_fetch_object($saletypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->saletypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	
	<tr>
		<td align="right">Vatable : </td>
		<td><select name='vatable' class="selectbox">
			<option value='No' <?php if($obj->vatable=='No'){echo"selected";}?>>No</option>
			<option value='Yes' <?php if($obj->vatable=='Yes'){echo"selected";}?>>Yes</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Sales Person : </td>
			<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
		</td>
	</tr>
	<!--<tr>
		<td align="right">Id No. : </td>
		<td><input type="text" name="idno" id="idno" value="<?php echo $obj->idno; ?>"></td>
	</tr>-->
	<tr>
		<td align="right">Tax Reg No : </td>
		<td><input type="text" name="pinno" id="pinno" value="<?php echo $obj->pinno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Address : </td>
		<td><textarea name="address"><?php echo $obj->address; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">TelNo. : </td>
		<td><input type="text" name="tel" id="tel" value="<?php echo $obj->tel; ?>"></td>
	</tr>
	<tr>
		<td align="right">Fax : </td>
		<td><input type="text" name="fax" id="fax" value="<?php echo $obj->fax; ?>"></td>
	</tr>
	<tr>
		<td align="right">E-mail : </td>
		<td><input type="text" name="email" id="email" value="<?php echo $obj->email; ?>"></td>
	</tr>
	<tr>
		<td align="right">Contact Name : </td>
		<td><input type="text" name="contactname" id="contactname" value="<?php echo $obj->contactname; ?>"></td>
	</tr>
	<tr>
		<td align="right">Contact Phone : </td>
		<td><input type="text" name="contactphone" id="contactphone" value="<?php echo $obj->contactphone; ?>"></td>
	</tr>
	<!--<tr>
		<td align="right">Next Of Kin : </td>
		<td><input type="text" name="nextofkin" id="nextofkin" size="45"  value="<?php echo $obj->nextofkin; ?>"></td>
	</tr>
	<tr>
		<td align="right">Relation Of Next Of Kin : </td>
		<td><input type="text" name="nextofkinrelation" id="nextofkinrelation" value="<?php echo $obj->nextofkinrelation; ?>"></td>
	</tr>
	<tr>
		<td align="right">Next Of Kin Address : </td>
		<td><textarea name="nextofkinaddress"><?php echo $obj->nextofkinaddress; ?></textarea></td>
	</tr>
	<tr>
		<td align="right">Next Of Kin Id No : </td>
		<td><input type="text" name="nextofkinidno" id="nextofkinidno" value="<?php echo $obj->nextofkinidno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Next Of Kin Pin No. : </td>
		<td><input type="text" name="nextofkinpinno" id="nextofkinpinno" value="<?php echo $obj->nextofkinpinno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Next Of Kin Tel No. : </td>
		<td><input type="text" name="nextofkintel" id="nextofkintel" value="<?php echo $obj->nextofkintel; ?>"></td>
	</tr>-->
	<tr>
		<td align="right">Credit Limit : </td>
		<td><input type="text" name="creditlimit" id="creditlimit" size="8"  value="<?php echo $obj->creditlimit; ?>"></td>
	</tr>
	<tr>
		<td align="right">Credit Days : </td>
		<td><input type="text" name="creditdays" id="creditdays" value="<?php echo $obj->creditdays; ?>"></td>
	</tr>
	<tr>
		<td align="right">Discount : </td>
		<td><input type="text" name="discount" id="discount" size="8"  value="<?php echo $obj->discount; ?>"></td>
	</tr>
	
	<tr>
		<td align="right">Show Logo : </td>
		<td><select name='showlogo' class="selectbox">
			<option value='Yes' <?php if($obj->showlogo=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->showlogo=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
		<tr>
		<td align="right">INCO TERMS: </td>
			<td>
			<?php
			$freights=new freights();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$freights->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			?>
			<select name="freightid" class="selectbox">
<option value="">Select...</option>
<?php

	while($rw=mysql_fetch_object($freights->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->freightid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Status : </td>
			<td>
			<?php
			$statuss=new Statuss();
	$where="  ";
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			?>
			<select name="statusid" class="selectbox">
<option value="">Select...</option>
<?php

	while($rw=mysql_fetch_object($statuss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->statusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Show FLO : </td>
		<td>
		<input type="radio" name="flo" id="flo" <?php if($obj->flo=='Yes'){echo"checked";}?> value="Yes">Yes&nbsp;
		<input type="radio" name="flo" id="flo" <?php if($obj->flo=='No'){echo"checked";}?> value="No">No
		</td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn btn-primary" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input class="btn btn-danger" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
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