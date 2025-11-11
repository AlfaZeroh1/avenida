<title>WiseDigits ERP: Fleetschedules </title>
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

<script type="text/javascript">
$().ready(function() {
  $("#supplierssuppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=suppliers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#supplierssupplierid").val(ui.item.id);
	}
  });

  $("#incomesincomename").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=incomes&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#incomesincomeid").val(ui.item.id);
	}
  });

  $("#expensesexpensename").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=expenses&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#expensesexpenseid").val(ui.item.id);
	}
  });

  $("#projectsprojectname").autocomplete({
	source:"../../../modules/server/server/search.php?main=con&module=projects&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#projectsprojectid").val(ui.item.id);
	}
  });

});
</script>

<div class="container" style="margin-top:;">
<div class="tabbable">

<ul class="nav nav-tabs">
		<li><a href="#pane1" data-toggle="tab">DETAILS</a></li>
		<li><a href="#pane2" data-toggle="tab">EXPENSES</a></li>
		<li><a href="#pane3" data-toggle="tab">INCOMES</a></li>
</ul>
<div class="tab-content">
    <div id="pane1" class="tab-pane active">
<form class="forms" id="theform" action="addfleetschedules_proc.php" name="fleetschedules" method="POST" enctype="multipart/form-data">
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
		<td align="right">Asset : </td>
			<td><select name="assetid" class="selectbox">
<option value="">Select...</option>
<?php
	$assets=new Assets();
	$where="  ";
	$fields="assets_assets.id, assets_assets.name, assets_assets.photo, assets_assets.documentno, assets_assets.categoryid, assets_assets.departmentid, assets_assets.employeeid, assets_assets.value, assets_assets.salvagevalue, assets_assets.purchasedon, assets_assets.supplierid, assets_assets.lpono, assets_assets.deliveryno, assets_assets.remarks, assets_assets.memo, assets_assets.ipaddress, assets_assets.createdby, assets_assets.createdon, assets_assets.lasteditedby, assets_assets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($assets->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->assetid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
		</td>
	</tr>
	<tr>
		<td align="right">Driver : </td>
			<td><select name="employeeid" class="selectbox">
<option value="">Select...</option>
<?php
	$employees=new Employees();
	$where="  ";
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($employees->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->employeeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Project : </td>
			<td><select name="projectid" class="selectbox">
<option value="">Select...</option>
<?php
	$projects=new Projects();
	$where="  ";
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.exitclause, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($projects->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->projectid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Customer : </td>
			<td><select name="customerid" class="selectbox">
<option value="">Select...</option>
<?php
	$customers=new Customers();
	$where="  ";
	$fields="crm_customers.id, crm_customers.name, crm_customers.acctypeid, crm_customers.refid, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
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
		<td align="right">Source : </td>
		<td><input type="text" name="source" id="source" value="<?php echo $obj->source; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Destination : </td>
		<td><input type="text" name="destination" id="destination" value="<?php echo $obj->destination; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Departure Time : </td>
		<td><input type="text" name="departuretime" id="departuretime" class="date_input" size="12" readonly  value="<?php echo $obj->departuretime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Expected Arrival Time : </td>
		<td><input type="text" name="expectedarrivaltime" id="expectedarrivaltime" class="date_input" size="12" readonly  value="<?php echo $obj->expectedarrivaltime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Actual Arrival Time : </td>
		<td><input type="text" name="arrivaltime" id="arrivaltime" class="date_input" size="12" readonly  value="<?php echo $obj->arrivaltime; ?>"></td>
	</tr>
	<tr>
		<td align="right">Remarks : </td>
		<td><textarea name="remarks"><?php echo $obj->remarks; ?></textarea></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
</table>
	</form>
</div>

<?php if(!empty($obj->id)){?>
<div id="pane2" class="tab-pane">
<form class="forms" id="theform" action="addassets_proc.php" name="assets" method="POST" enctype="multipart/form-data">
		<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
			<tr>
			  <td colspan='16'><a href="../../fn/exptransactions/addexptransactions_proc.php?fleetscheduleid=<?php echo $obj->id; ?>">New</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th valign="bottom">Expense</th>
				<th valign="bottom">Bank</th>
				<th valign="bottom">Payment Mode</th>
				<th valign="bottom">Documentno</th>
				<th valign="bottom">Memo</th>
				<th valign="bottom">Remarks</th>
				<th valign="bottom">Expense Date</th>
				<th valign="bottom">Total</th>
				<th valign="bottom">Amount</th>
				<th valign="bottom">Discount</th>
				<th valign="bottom">Tax</th>
				<th valign="bottom">Quantity</th>
				<th valign="bottom">Purchase Mode</th>
				<th valign="bottom">Supplier</th>
				<th valign="bottom">&nbsp;</th>
			</tr>
<?php
		$exptransactions=new Exptransactions();
		$i=0;
		$fields="fn_exptransactions.id, fn_exptransactions.documentno, fn_expenses.name as expenseid, proc_suppliers.name as supplierid, sys_purchasemodes.name as purchasemodeid, fn_exptransactions.quantity, fn_exptransactions.tax, fn_exptransactions.discount, fn_exptransactions.amount, fn_exptransactions.total, fn_exptransactions.expensedate, fn_exptransactions.remarks, fn_exptransactions.memo, fn_exptransactions.documentno, sys_paymentmodes.name as paymentmodeid, fn_exptransactions.bankid, fn_exptransactions.chequeno, fn_exptransactions.ipaddress, fn_exptransactions.createdby, fn_exptransactions.createdon, fn_exptransactions.lasteditedby, fn_exptransactions.lasteditedon";
		$join=" left join fn_expenses on fn_exptransactions.expenseid=fn_expenses.id  left join proc_suppliers on fn_exptransactions.supplierid=proc_suppliers.id  left join sys_purchasemodes on fn_exptransactions.purchasemodeid=sys_purchasemodes.id  left join sys_paymentmodes on fn_exptransactions.paymentmodeid=sys_paymentmodes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_exptransactions.fleetscheduleid='$obj->id'";
		$exptransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$num=$exptransactions->affectedRows;
		$res=$exptransactions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->expenseid; ?></td>
				<td><?php echo $row->bankid; ?></td>
				<td><?php echo $row->paymentmodeid; ?></td>
				<td><?php echo $row->documentno; ?></td>
				<td><?php echo $row->memo; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->expensedate; ?></td>
				<td><?php echo $row->total; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->discount; ?></td>
				<td><?php echo $row->tax; ?></td>
				<td><?php echo $row->quantity; ?></td>
				<td><?php echo $row->purchasemodeid; ?></td>
				<td><?php echo $row->supplierid; ?></td>
				<td><a href='addfleetschedules_proc.php?id=<?php echo $obj->id; ?>&exptransactions=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
		</td>
	</tr>
	<tr>
	<td colspan='<?php echo ($num+2); ?>'><hr/></td>
	</tr>
	</table>
	</form>
</div>

<?php }if(!empty($obj->id)){?>
<div id="pane3" class="tab-pane">
<form class="forms" id="theform" action="addassets_proc.php" name="assets" method="POST" enctype="multipart/form-data">
		<table width="100%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">
			<tr>
			  <td colspan='16'><a href="../../fn/inctransactions/addinctransactions_proc.php?fleetscheduleid=<?php echo $obj->id; ?>&customerid=<?php echo $obj->customerid; ?>&projectid=<?php echo $obj->projectid; ?>">New</td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<th valign="bottom">Income</th>
				<th valign="bottom">Jvno</th>
				<th valign="bottom">Drawer</th>
				<th valign="bottom">Memo</th>
				<th valign="bottom">Remarks</th>
				<th valign="bottom">Income Date</th>
				<th valign="bottom">Chequeno</th>
				<th valign="bottom">Bank </th>
				<th valign="bottom">Payment Mode</th>
				<th valign="bottom">Amount</th>
				<th valign="bottom">Ref</th>
				<th valign="bottom">Quantity</th>
				<th valign="bottom">Document No</th>
				<th valign="bottom">&nbsp;</th>
			</tr>
<?php
		$inctransactions=new Inctransactions();
		$i=0;
		$fields="fn_inctransactions.id, fn_incomes.name as incomeid, em_plots.name as plotid, em_paymentterms.name as paymenttermid, crm_customers.name as customerid, fn_inctransactions.quantity, fn_inctransactions.tax, fn_inctransactions.discount, fn_inctransactions.amount, fn_inctransactions.total, fn_inctransactions.expensedate, fn_inctransactions.month, fn_inctransactions.year, fn_inctransactions.paid, fn_inctransactions.remarks, fn_inctransactions.memo, fn_inctransactions.documentno, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, fn_imprestaccounts.name as imprestaccountid, fn_inctransactions.chequeno, fn_inctransactions.ipaddress, fn_inctransactions.createdby, fn_inctransactions.createdon, fn_inctransactions.lasteditedby, fn_inctransactions.lasteditedon";
		$join=" left join fn_incomes on fn_inctransactions.incomeid=fn_incomes.id  left join em_plots on fn_inctransactions.plotid=em_plots.id  left join em_paymentterms on fn_inctransactions.paymenttermid=em_paymentterms.id  left join crm_customers on fn_inctransactions.customerid=crm_customers.id  left join sys_paymentmodes on fn_inctransactions.paymentmodeid=sys_paymentmodes.id  left join fn_banks on fn_inctransactions.bankid=fn_banks.id  left join fn_imprestaccounts on fn_inctransactions.imprestaccountid=fn_imprestaccounts.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where fn_inctransactions.fleetscheduleid='$obj->id'";
		$inctransactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$inctransactions->affectedRows;
		$res=$inctransactions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->incomeid; ?></td>
				<td><?php echo $row->jvno; ?></td>
				<td><?php echo $row->drawer; ?></td>
				<td><?php echo $row->memo; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->incomedate; ?></td>
				<td><?php echo $row->chequeno; ?></td>
				<td><?php echo $row->bankid; ?></td>
				<td><?php echo $row->paymentmodeid; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->ref; ?></td>
				<td><?php echo $row->quantity; ?></td>
				<td><?php echo $row->documentno; ?></td>
				<td><a href='addfleetschedules_proc.php?id=<?php echo $obj->id; ?>&inctransactions=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
		</td>
	</tr>
	<tr>
	<td colspan='<?php echo ($num+2); ?>'><hr/></td>
	</tr>
<?php }?>
</table>
</form>
</div>
<?php 
include "../../../foot.php";
if(!empty($error)){
	showError($error);
}
?>