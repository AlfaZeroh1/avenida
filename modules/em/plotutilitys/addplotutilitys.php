<title>WiseDigits: Plotutilitys </title>
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
<form class="forms" id="theform" action="addplotutilitys_proc.php" name="plotutilitys" method="POST" enctype="multipart/form-data">
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
		<td align="right">Plot : </td>
			<td><select name="plotid">
<option value="">Select...</option>
<?php
	$plots=new Plots();
	$where="  ";
	$fields="em_plots.id, em_plots.code, em_plots.landlordid, em_plots.actionid, em_plots.noofhouses, em_plots.regionid, em_plots.managefrom, em_plots.managefor, em_plots.indefinite, em_plots.typeid, em_plots.commission, em_plots.target, em_plots.name, em_plots.lrno, em_plots.estate, em_plots.road, em_plots.location, em_plots.letarea, em_plots.unusedarea, em_plots.employeeid, em_plots.deposit, em_plots.depositmgtfee, em_plots.depositmgtfeeperc, em_plots.depositmgtfeevatable, em_plots.depositmgtfeevatclasseid, em_plots.mgtfeevatclasseid, em_plots.vatable, em_plots.vatclasseid, em_plots.deductcommission, em_plots.status, em_plots.penaltydate, em_plots.paydate, em_plots.remarks, em_plots.photo, em_plots.longitude, em_plots.latitude, em_plots.ipaddress, em_plots.createdby, em_plots.createdon, em_plots.lasteditedby, em_plots.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($plots->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->plotid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Payment Term : </td>
			<td><select name="paymenttermid">
<option value="">Select...</option>
<?php
	$paymentterms=new Paymentterms();
	$where="  ";
	$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.remarks, em_paymentterms.ipaddress, em_paymentterms.createdby, em_paymentterms.createdon, em_paymentterms.lasteditedby, em_paymentterms.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($paymentterms->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->paymenttermid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Amount : </td>
		<td><input type="text" name="amount" id="amount" size="8"  value="<?php echo $obj->amount; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right"> : </td>
		<td><input type="text" name="showinst" id="showinst" value="<?php echo $obj->showinst; ?>"></td>
	</tr>
	<tr>
		<td align="right">Charge Mgt Fee? : </td>
		<td><select name='mgtfee'>
			<option value='Yes' <?php if($obj->mgtfee=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->mgtfee=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Mgt Fee Deposit : </td>
		<td><input type="text" name="mgtfeeperc" id="mgtfeeperc" size="8"  value="<?php echo $obj->mgtfeeperc; ?>"></td>
	</tr>
	<tr>
		<td align="right">VATable : </td>
		<td><select name='vatable'>
			<option value='Yes' <?php if($obj->vatable=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->vatable=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">VAT Class : </td>
			<td><select name="vatclasseid">
<option value="">Select...</option>
<?php
	$vatclasses=new Vatclasses();
	$where="  ";
	$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($vatclasses->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->vatclasseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Is Mgt Fee VATable : </td>
		<td><select name='mgtfeevatable'>
			<option value='Yes' <?php if($obj->mgtfeevatable=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->mgtfeevatable=='No'){echo"selected";}?>>No</option>
		</select></td>
	</tr>
	<tr>
		<td align="right">Mgt Fee VAT Class : </td>
		<td><input type="text" name="mgtfeevatclasseid" id="mgtfeevatclasseid" value="<?php echo $obj->mgtfeevatclasseid; ?>"></td>
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
if(!empty($error)){
	showError($error);
}
?>