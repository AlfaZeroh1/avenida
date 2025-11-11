<title>WiseDigits ERP: Agentdeposits </title>
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
<form  id="theform" action="addagentdeposits_proc.php" name="agentdeposits" method="POST" enctype="multipart/form-data">
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
		<td align="right">Agent : </td>
			<td><select name="agentid" class="selectbox">
<option value="">Select...</option>
<?php
	$agents=new Agents();
	$where="  ";
	$fields="reg_agents.id, reg_agents.name, reg_agents.agentid, reg_agents.agenttypeid, reg_agents.regionid, reg_agents.subregionid, reg_agents.contactperson, reg_agents.tel, reg_agents.mobile, reg_agents.email, reg_agents.remarks, reg_agents.ipaddress, reg_agents.createdby, reg_agents.createdon, reg_agents.lasteditedby, reg_agents.lasteditedon";
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
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Bank : </td>
			<td><select name="bankid" class="selectbox">
<option value="">Select...</option>
<?php
	$banks=new Banks();
	$where="  ";
	$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($banks->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->bankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Date Deposited : </td>
		<td><input type="text" name="depositedon" id="depositedon" class="date_input" size="12" readonly  value="<?php echo $obj->depositedon; ?>"></td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"></td>
	</tr>
	<tr>
		<td align="right">Slip No : </td>
		<td><input type="text" name="slipno" id="slipno" value="<?php echo $obj->slipno; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Deposit Slip Image : </td>
		<td><input type="text" name="file" id="file" value="<?php echo $obj->file; ?>"></td>
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