<title><?php echo WISEDIGITS; ?>: <?php echo initialCap($page_title); ?></title>
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

<div id="tabs-1" style="min-height:700px;">
<form class="forms" id="theform" action="addacctypes_proc.php" name="acctypes" method="POST" enctype="multipart/form-data">
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
		<td align="right">CODE : </td>
		<td><input type="text" name="code" id="code" size="8"  value="<?php echo $obj->code; ?>"></td>
	</tr>
	<tr>
		<td align="right">Name : </td>
		<td><input type="text" name="name" id="name" size="45"  value="<?php echo $obj->name; ?>"></td>
	</tr>
	<tr>
		<td align="right">Account Type : </td>
			<td><select name="accounttypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$accounttypes=new Accounttypes();
	$where="  ";
	$fields="fn_accounttypes.id, fn_accounttypes.code, fn_accounttypes.name, fn_accounttypes.remarks, fn_accounttypes.balance, fn_accounttypes.accounttype, fn_accounttypes.direct";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$accounttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($accounttypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->accounttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Sub Account : </td>
			<td><select name="subaccountypeid" class="selectbox">
<option value="">Select...</option>
<?php
	$subaccountypes=new Subaccountypes();
	$where="  ";
	$fields="fn_subaccountypes.id, fn_subaccountypes.name, fn_subaccountypes.accounttypeid, fn_subaccountypes.priority, fn_subaccountypes.remarks, fn_subaccountypes.ipaddress, fn_subaccountypes.createdby, fn_subaccountypes.createdon, fn_subaccountypes.lasteditedby, fn_subaccountypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$subaccountypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($subaccountypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->subaccountypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Balance Type? : </td>
		<td>
			<input type="radio" name="balance" id="balance" value='Dr' <?php if($obj->balance=='Dr'){echo"checked";}?>>Dr 
			<input type="radio" name="balance" id="balance" value='CR' <?php if($obj->balance=='CR'){echo"checked";}?>>CR 
		</td>
	</tr>
	<tr>
		<td align="right">Account Type : </td>
		<td>
			<input type="radio" name="accounttype" id="accounttype" value='Cumulative' <?php if($obj->accounttype=='Cumulative'){echo"checked";}?>>Cumulative 
			<input type="radio" name="accounttype" id="accounttype" value='Non-Cumulative' <?php if($obj->accounttype=='Non-Cumulative'){echo"checked";}?>>Non-Cumulative 
		</td>
	</tr>
	<tr>
		<td align="right">Direct Posting : </td>
		<td>
			<input type="radio" name="direct" id="direct" value='YES' <?php if($obj->direct=='YES'){echo"checked";}?>>YES 
			<input type="radio" name="direct" id="direct" value='No' <?php if($obj->direct=='No'){echo"checked";}?>>No 
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn btn-info" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" class="btn btn-danger" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
<?php if(!empty($obj->id)){?>
<?php }?>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>