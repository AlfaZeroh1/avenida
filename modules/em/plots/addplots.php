<title>WiseDigits: Property </title>
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
  $("#landlordname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=landlords&field=concat(em_landlords.firstname,' ',concat(em_landlords.middlename,' ',em_landlords.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#landlordid").val(ui.item.id);
	}
  });

  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))&where=hrm_assignments.departmentid=2,&where=hrm_assignments.departmentid=1&join=' left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid'",
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
</script>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">PROPERTY DETAILS</a></li>
		<li><a href="#tabs-2">PROPERTY PAYMENT DETAILS</a></li>
		<li><a href="#tabs-3">UNITS</a></li>
       	<li><a href="#tabs-4">PROPERTY UTILITIES</a></li>
        <li><a href="#tabs-5">PROPERTY SECURITY DEPOSITS</a></li>
        <li><a href="#tabs-9">PROPERTY OTHER FEES</a></li>
        <li><a href="#tabs-6">PROPERTY RENTS</a></li>
        <li><a href="#tabs-7">PROPERTY DOCUMENTS</a></li>
        <li><a href="#tabs-8">PROPERTY INSURANCES</a></li>
	</ul>
	<div id="tabs-1">
<form method="post" class="forms" action="addplots_proc.php" id="plot" method="POST" enctype="multipart/form-data">
 <div id="form">

	<table width="42%" style="margin-left:300px;">
	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
         <div class="row">
		<td>

      <div class="label">Property Code :</div></td><td>
      <div class="clearb"></div>
      <div class="input" id="">
      <input type="text" name="code" id="code" value="<?php echo $obj->code; ?>" readonly="readonly"/><font color='red'>*</font>
      </div>
</td>
</div>
	</tr>
	<tr>
    <div class="row">
			<td>
  
      <div class="label">Landlord :</div></td><td>
      <div class="input" id="mboss">
             <input type='text' name='landlordname' id='landlordname' size="28" value='<?php echo $obj->landlordname; ?>'>
			<input type="hidden" name='landlordid' id='landlordid' value='<?php echo $obj->landlordid; ?>'>
      </div>
  

		</td>
        </div>
	</tr>
	<tr>
         <div class="row">
		<td>

      <div class="label">Action :</div>
      </td>
      <td>
      <div class="input" id="act">
      <select class="selectbox" name="actionid" id="a">
<option value="">Select...</option>
<?php
	$actions=new Actions();
	$where="  ";
	$fields="em_actions.id, em_actions.name, em_actions.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$actions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($actions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->actionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
      </div>

		</td>
          </div>
	</tr>
	<tr>
     <div class="row">
		<td> 
       
      <div class="label">No Of Units : </div></td><td>
      <div class="input" id=" ">
      <input type="text" name="noofhouses" id="noofhouses" value="<?php echo $obj->noofhouses; ?>" >
      </div>
      </td>
  </div>
	</tr>
	<tr>
         <div class="row">
		<td> 

      <div class="label">Region :</div></td><td>
      <div class="input" id="a">
      <select class="selectbox" name="regionid" id="region">
<option value="">Select...</option>
<?php
	$regions=new Regions();
	$where="  ";
	$fields="em_regions.id, em_regions.name, em_regions.remarks";
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
      </div>
      </td>
  </div><font color='red'>*</font>

	</tr>
	<tr>
    <div class="row">
		<td>

      <div class="label">Commencement date :</div></td><td>
      <div class="input" id="b">
      <input type="text" name="managefrom" id="managefrom" class="date_input" size="18" readonly  value="<?php echo $obj->managefrom; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
      <div class="row">
		<td> 

      <div class="label">Contract period :</div></td><td>
      <div class="input" id=" ">
      <input type="text" name="managefor" id="managefor" value="<?php echo $obj->managefor; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
       <div class="row">
		<td> 

      <div class="label">Indefinitely :</div></td><td>
      <div class="input" id=" ">
      <input type="text" name="indefinite" id="indefinite" value="<?php echo $obj->indefinite; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
    <div class="row">
		<td> 
        
      <div class="label">Type :</div></td><td>
      <div class="input" id="c">
      <select class="selectbox" name="typeid" id="typeid">
<option value="">Select...</option>
<?php
	$types=new Types();
	$where="  ";
	$fields="em_types.id, em_types.name, em_types.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$types->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($types->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->typeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
      </div>
      </td>
  </div>
	</tr>
	<tr>
       <div class="row">
		<td>

      <div class="label">Agency Fee[<span style="color:red;">%</span>] :</div></td><td>
      <select name="commissiontype" class="selectbox" required>
		<option value="">Select...</option>
		<option value="1" <?php if($obj->commissiontype==1){echo"selected";}?>>%</option>
		<option value="2" <?php if($obj->commissiontype==2){echo"selected";}?>>Amount</option>
	</select>
      <div class="input" id="d">
      <input type="text" name="commission" id="commission" size="8" maxlength="2" value="<?php echo $obj->commission; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
      <div class="row">
		<td>

      <div class="label">Perfomance Target[<span style="color:red;">%</span>]  :</div></td><td>
      <div class="input" id=" ">
      <input type="text" name="target" id="target" size="8" maxlength="2"  value="<?php echo $obj->target; ?>">
      </div>
       </td>
         </div> 
	</tr>
	<tr>
      <div class="row">
<td>

      <div class="label">Property Name:</div></td><td>
      <div class="input" id="e">
      <input type="text" name="name" id="name" size="45"  value="<?php echo $obj->name; ?>"><font color='red'>*</font>
      </div>
      </td>
  </div>
	</tr>
	<tr>
            <div class="row">
		<td>

      <div class="label">LR/Plot No:</div></td><td>
      <div class="input" id="f">
      <input type="text" name="lrno" id="lrno" value="<?php echo $obj->lrno; ?>"><font color='red'>*</font>
      </div>
              </td>
  </div>

	</tr>
	<tr>
            <div class="row">
		<td>

      <div class="label">Estate :</div></td><td>
      <div class="input" id=" ">
      <input type="text" name="estate" id="estate" value="<?php echo $obj->estate; ?>">
      </div>
        </td>
          </div>
	</tr>
	<tr>
       <div class="row">
	<td> 

      <div class="label">Road :</div></td><td>
      <div class="input" id=" ">
      <input type="text" name="road" id="road" value="<?php echo $obj->road; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
      <div class="row">
		<td> 
      <div class="label">Location :</div></td><td>
      <div class="input" id=" ">
      <input type="text" name="location" id="location" value="<?php echo $obj->location; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
      <div class="row">
<td> 

      <div class="label">Let-Able Area :</div></td><td>
      <div class="input" id=" ">
      <input type="text" name="letarea" id="letarea" size="8"  value="<?php echo $obj->letarea; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
      <div class="row">
		<td> <div class="label">Unused Area :</div></td><td>
      <div class="input" id=" ">
      <input type="text" name="unusedarea" id="unusedarea" size="8"  value="<?php echo $obj->unusedarea; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
      <div class="row">
<td>
<div class="label">Manager :</div></td><td>
      <div class="input" id=" ">
              <input type='text' size='24' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
			<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->employeeid; ?>'>
</div>
</td>
  </div>
	</tr>
	<tr>
  <div class="row">
		<td>
      <div class="label">Deposit :</div></td><td>
      <div class="input" id=" ">
<input type="text" name="deposit" id="deposit" size="4" value="<?php echo $obj->deposit; ?>"><span style="color:red;">(Months)</span>
      </div>
      </td>
  </div>
	</tr>
	<tr>
       <div class="row">
		<td> 
      <div class="label">Deposit Management Fee :</div></td><td>
      <div class="input" id=" ">
<input type="checkbox" name='depositmgtfee' id="depositmgtfee" value="Yes" <?php if($obj->depositmgtfee=="Yes"){echo"checked";}?>/>
      </div>
      </td>
  </div>
	</tr>
	<tr>
    <div class="row">
		<td>
      <div class="label">Deposit Mgt Fee Percent :</div></td><td>
      <div class="input" id=" ">
<input type="text" name="depositmgtfeeperc" id="depositmgtfeeperc" size="8"  value="<?php echo $obj->depositmgtfeeperc; ?>">   
      </div>
      </td>
  </div> 
	</tr>
	<tr>
  <div class="row">
		<td> 
      <div class="label">Mgt Fee VATable :</div></td><td>
      <div class="input" id=" ">
      <input type="checkbox" name='vatable' id="vatable"  value="Yes" <?php if($obj->vatable=="Yes"){echo "checked";}?>/>
      </div>
      </td>
  </div>
	</tr>
	<tr>
        <div class="row">
		<td>
      <div class="label">VAT Class :</div></td><td>
      <div class="input" id=" ">
<select name="vatclasseid" class="selectbox">
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
      </div>
     </td> 
  </div>
	</tr>
	<tr>
    <div class="row">
		<td> 
      <div class="label">Deposit Mgt Fee VATable? :</div></td><td>
      <div class="input" id=" ">
      <input type="checkbox" name='depositmgtfeevatable' id="depositmgtfeevatable" value="Yes" <?php if($obj->depositmgtfeevatable=="Yes"){echo "checked";}?>/>
      </div>
      </td>
  </div>
	</tr>
	<tr>
 <div class="row">
		<td>
      <div class="label">Dep Mgt Fee VAT Class :</div></td><td>
      <div class="input" id=" ">
 <select name="mgtfeevatclasseid"  class="selectbox">
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
		<option value="<?php echo $rw->id; ?>" <?php if($obj->mgtfeevatclasseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
      </div>
      </td>
  </div>
	</tr>
	
	<tr>
    <div class="row">
		<td> 
      <div class="label">Deduct Commission Directly :</div></td><td>
      <div class="input" id=" ">
<input type="checkbox" name='deductcommission' id="deductcommission" value="Yes" <?php if($obj->deductcommission=="Yes"){echo "checked";}?>/>
      </div>
      </td>
  </div>
	</tr>
	<tr>
     <div class="row">
		<td>
      <div class="label">Status :</div></td><td>
      <div class="input" id=" ">
      <select name='status' class="selectbox">
			<option value='active' <?php if($obj->status=='active'){echo"selected";}?>>Active</option>
			<option value='in-active' <?php if($obj->status=='in-active'){echo"selected";}?>>In Active</option>
		</select>
      </div>
      </td>
  </div>
	</tr>
	<tr>
     <div class="row">
		<td> 
      <div class="label">Penalty Date:</div></td><td>
      <div class="input" id="g">
<input type="text" name="penaltydate" id="penaltydate" value="<?php echo $obj->penaltydate; ?>">
      </div>
      </td>
  </div>
	</tr>
	
	<tr>
     <div class="row">
		<td> 
      <div class="label">Pay Date :</div></td><td>
      <div class="input" id="g">
<input type="text" name="paydate" id="paydate" value="<?php echo $obj->paydate; ?>">
      </div>
      </td>
  </div>
	</tr>
	
	<tr>
     <div class="row">
		<td> 
      <div class="label">Remarks :</div></td><td>
      <div class="input" id=" ">
      <textarea name="remarks"><?php echo $obj->remarks; ?></textarea>
      </div>
      </td>
  </div>
	</tr>
	
	
	<tr>
		<td>
		<div class="label">Browse Property Photo :</div> </td>
		<td><input type="file" name="photo" id="photo" value="<?php echo $obj->photo; ?>"></td>
	</tr>
	<tr>
		<td>
		<div class="label">Longitude : </div></td>
		<td><input type="text" name="longitude" id="longitude" size="8"  value="<?php echo $obj->longitude; ?>"></td>
	</tr>
	<tr>
		<td>
		<div class="label">Latitude :</div> </td>
		<td><input type="text" name="latitude" id="latitude" size="8"  value="<?php echo $obj->latitude; ?>"></td>
	</tr>
	
	<tr>
		<td colspan="2" align="center"><input type="submit" id="submit" class="btn" name="action" id="action" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
 </table>
 </form>
 </div>
           <div class="clearb"></div>
    </div>
<?php if(!empty($obj->id)){?>
	<div id="tabs-2" style="min-height:420px;">
    <form method="post" action="addplots_proc.php" class="forms">
    <table style="margin:50px 200px;">
	<tr>
		<td colspan="6"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr> 
	<tr>
		<td><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>"></td>
		<td><input type="hidden" name="plotid" id="plotid" value="<?php echo $obj->plotid; ?>"></td>
	<tr>
		<td align="right">Client Bank : </td>
			<td><select class="selectbox" name="clientbankid" required="required">
<option value="">Select...</option>
<?php
	$clientbanks=new Clientbanks();
	$where="  ";
	$fields="em_clientbanks.id, em_clientbanks.name, em_clientbanks.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$clientbanks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($clientbanks->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->clientbankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td align="right">Bank Branch : </td>
		<td><input type="text" name="branch" id="branch" value="<?php echo $obj->branch; ?>" required="required"></td>
	<tr>
		<td align="right">Account No : </td>
		<td><input type="text" name="accntno" id="accntno" value="<?php echo $obj->accntno; ?>" required="required"></td>
		<td align="right">Payment Date : </td>
		<td><input type="text" name="paidon" id="paidon" class="date_input" size="12" readonly  value="<?php echo $obj->paidon; ?>"></td>
	<tr>
		<td align="right">Payment Mode : </td>
			<td><select class="selectbox" name="paymentmodeid" required="required">
<option value="">Select...</option>
<?php
	$paymentmodes=new Paymentmodes();
	$where="  ";
	$fields="sys_paymentmodes.id, sys_paymentmodes.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($paymentmodes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->paymentmodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
		<td align="right">VAT Reg No : </td>
		<td><input type="text" name="vatno" id="vatno" value="<?php echo $obj->vatno; ?>" required="required"></td>
	<tr>
		<td align="right">PIN : </td>
		<td><input type="text" name="pin" id="pin" value="<?php echo $obj->pin; ?>" required="required"></td>
		<td align="right">Cheques To : </td>
		<td><input type="text" name="chequesto" id="chequesto" size="45"  value="<?php echo $obj->chequesto; ?>" required="required"></td>

	</tr>
	<tr>
		<td colspan="5" align="center"><input type="submit" class="btn" value="<?php echo $obj->actionplotpaymentdetail;?>" name="actionplotpaymentdetail"/>&nbsp;<input class="btn" type="button" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
    </table><!-- t2End -->
       <div class="clearb"></div>
     </form> 
    </div><!-- tab2End -->
<?php }?>
	<?php if(!empty($obj->id)){?> 
<div id="tabs-3" style="min-height:420px;">
        <form method="post" action="addplots_proc.php" class="forms">
    <table width="60%" style="margin:50px 200px;">
	<tr>
		<td colspan="6"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
    <tr>		
                                             <td valign="bottom">Unit Code : <input type="text" name="houseshsecode" value="<?php echo $obj->houseshsecode; ?>" required="required"></td>
    		<td valign="bottom">Unit No : <input type="text" required="required" name="houseshseno" size="14" value="<?php echo $obj->houseshseno; ?>" ></td>
                <td valign="bottom">Description : <select class="selectbox" name='houseshsedescriptionid' required="required">
				<option value="">Select...</option>
				<?php
				$hsedescriptions=new Hsedescriptions();
				$fields="em_hsedescriptions.id, em_hsedescriptions.name, em_hsedescriptions.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$hsedescriptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($hsedescriptions->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->hsedescriptionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">Rental Status : <select class="selectbox" name='housesrentalstatusid' required="required">
				<option value="">Select...</option>
				<?php
				$rentalstatuss=new Rentalstatuss();
				$fields="em_rentalstatuss.id, em_rentalstatuss.name, em_rentalstatuss.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$rentalstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($rentalstatuss->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->housesrentalstatusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">Status : <select class="selectbox" name='houseshousestatusid' required="required">
				<option value="">Select...</option>
				<?php
				$housestatuss=new Housestatuss();
				$fields="em_housestatuss.id, em_housestatuss.name, em_housestatuss.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$housestatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($housestatuss->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->housestatusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
			</tr>
			<tr>
            <td valign="bottom">Rent : <input type="text" name="housesamount" value="<?php echo $obj->housesamount; ?>" ></td>
            <td valign="bottom">Floor : <input type="text" name="housesfloor" value="<?php echo $obj->housesfloor; ?>" ></td>
				<td valign="bottom">Rooms : <input type="text" name="housesbedrms" value="<?php echo $obj->housesbedrms; ?>" ></td>
				<td valign="bottom">Size : <input type="text" name="housessize" value="<?php echo $obj->housessize; ?>" ></td>
				<td valign="bottom">Special Deposit : <input type="number" name="housesdeposit" value="<?php echo $obj->housesdeposit; ?>" ></td>
							</tr>
			<tr>
				<td valign="bottom">Water Account No : <input type="text" name="houseswateraccno" value="<?php echo $obj->houseswateraccno; ?>" required="required"></td>
				<td valign="bottom">Elec Account No : <input type="text" name="houseselecaccno" value="<?php echo $obj->houseselecaccno; ?>" required="required"></td>

				
				

				
				<td valign="bottom">Mgt Fee charged on Deposit?<select name='depositmgtfee' class="selectbox">
					<option value='Yes' <?php if($obj->depositmgtfee=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->depositmgtfee=='No'){echo"selected";}?>>No</option>
					</select>
				<td valign="bottom">Deposit Mgt Fee <span style="color:red;">%</span>: <input type="text" name="housesdepositmgtfeeperc" max="99" maxlength="2"></td>
				<td valign="bottom">Is Deposit Mgt Fee Vatable? <select name='depositmgtfeevatable' class="selectbox">
					<option value='Yes' <?php if($obj->depositmgtfeevatable=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->depositmgtfeevatable=='No'){echo"selected";}?>>No</option>
					</select>
                 </td>
                 </tr>
                 <tr>
				<td valign="bottom">Mgt Fee VAT Class : <select name='housesdepositmgtfeevatclasseid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$vatclasses=new Vatclasses();
				$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($vatclasses->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->depositmgtfeevatclasseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
				<td valign="bottom">Remarks : <textarea name="housesremarks"><?php echo $obj->housesremarks; ?></textarea></td>
             </tr>
             <tr>
				<td colspan="5" align="center"><input type="submit" class="btn" value="Add Unit" name="action"></td>
			</tr>
            </table>
 <div class="shadow">
            <table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
            <thead>
		<tr>
			<th>#</th>
			<th>UnitNo</th>
			<th>Unitcode</th>
			<th>rentstatusID</th>
			<th>UnitstatusID</th>
			<th>Tenant</th>
			<th>vatable</th>
			<th>deposit</th>
			<th>UnitDescID</th>
			<th>water AccNo</th>
			<th>elec AccNo</th>
			<th>floors</th>
			<th>bedrms</th>
			<th>size</th>
			<th>amount</th>
			<th>remarks</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php
		$houses=new Houses();
		$i=0;
		$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_plots.name as plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_hsedescriptions.name as hsedescriptionid, em_houses.deposit, em_houses.vatable, em_housestatuss.name as housestatusid, em_rentalstatuss.name as rentalstatusid, em_houses.remarks";
		$join=" left join em_plots on em_houses.plotid=em_plots.id  left join em_hsedescriptions on em_houses.hsedescriptionid=em_hsedescriptions.id  left join em_housestatuss on em_houses.housestatusid=em_housestatuss.id  left join em_rentalstatuss on em_houses.rentalstatusid=em_rentalstatuss.id ";
		$having="";
		$groupby="";
		$orderby=" order by em_houses.hsecode ";
		$where=" where em_houses.plotid='$obj->id'";
		$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$houses->affectedRows;
		$res=$houses->result;
		while($row=mysql_fetch_object($res)){
		$housetenants = new Housetenants();
		$fields="concat(concat(em_tenants.firstname,' ',em_tenants.middlename), ' ',em_tenants.lastname) tenant";
		$join=" left join em_tenants on em_tenants.id=em_housetenants.tenantid ";
		$where=" where em_housetenants.houseid='$row->id' ";
		$having="";
		$groupby="";
		$orderby="";
		$housetenants->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$housetenants = $housetenants->fetchObject;
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><a href="../houses/addhouses_proc.php?id=<?php echo $row->id; ?>"><?php echo $row->hseno; ?></a></td>
				<td><?php echo $row->hsecode; ?></td>
				<td><?php echo $row->rentalstatusid; ?></td>
				<td><?php echo $row->housestatusid; ?></td>
				<td><?php echo formatNouns($housetenants->tenant); ?></td>
				<td><?php echo $row->vatable; ?></td>
				<td><?php echo $row->deposit; ?></td>
				<td><?php echo $row->hsedescriptionid; ?></td>
				<td><?php echo $row->wateraccno; ?></td>
				<td><?php echo $row->elecaccno; ?></td>
				<td><?php echo $row->floors; ?></td>
				<td><?php echo $row->bedrms; ?></td>
				<td><?php echo $row->size; ?></td>
				<td align="right"><?php echo formatNumber($row->amount); ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addplots_proc.php?delid=<?php echo $row->id; ?>' onclick='return confirm(&quot;Are you sure you want to de-activate?&quot;)'><img src='../trash.png' alt='delete' title='delete' /></a></td>
			</tr>
		<?php
		}
?>
</tbody>
		</table>
        </div>
        <div class="clearb"></div>
        </form>
</div>
<div id="tabs-4" style="min-height:420px;margin:50px 120px;">
<form method="post" action="addplots_proc.php" class="forms">
    <table width="55%" style="">
	<tr>
		<td colspan="6"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
			<tr>
				<td valign="bottom">Utility : <select class="selectbox" name='plotpaymenttermid' required="required">
				<option value="">Select...</option>
				<?php
				$paymentterms=new Paymentterms();
				$where="  where em_paymentterms.type='utility' ";
				$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.remarks";
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
				</select></td>
				<td valign="bottom">Amount : <input type="text" name="plotutilitysamount"  value="<?php echo $obj->plotutilitysamount; ?>" required="required"></td>
				<td valign="bottom"> <input type="hidden" size="6" name="plotutilitysshowinst" value="1" />
				<td valign="bottom">VATable? <select name='vatable' class="selectbox">
				<option value='Yes' <?php if($obj->vatable=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->vatable=='No'){echo"selected";}?>>No</option>
					</select>
				<td valign="bottom">VAT Class : <select name='plotutilitysvatclasseid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$vatclasses=new Vatclasses();
				$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($vatclasses->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->vatclasseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				</tr>
				<tr>
				
					<td valign="bottom">Is Mgt Fee Charged: <select name='mgtfee' class="selectbox">
					<option value='Yes' <?php if($obj->mgtfee=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->mgtfee=='No'){echo"selected";}?>>No</option>
					</select>
					<td valign="bottom"><span style="color:red;">%</span> Mgt Fee : <input type="text" name="plotutilitysmgtfeeperc" ></td>
					 <td valign="bottom">Mgt Fee VATable? <select name='mgtfeevatable' class="selectbox">
					<option value='Yes' <?php if($obj->mgtfeevatable=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->mgtfeevatable=='No'){echo"selected";}?>>No</option>
					</select>
				<td valign="bottom">Mgt Fee VAT Class : <select name='plotutilitysmgtfeevatclasseid' class="selectbox" style="width:120px;">
				<option value="">Select...</option>
				<?php
				$vatclasses=new Vatclasses();
				$fields="sys_vatclasses.id, sys_vatclasses.name, sys_vatclasses.perc";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$vatclasses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($vatclasses->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->mgtfeevatclasseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
			
                <td>
                 </tr>
                <tr>
				
				
				
					<option value='Yes' <?php if($obj->mgtfee=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->mgtfee=='No'){echo"selected";}?>>No</option>
					</select>
				<td valign="bottom">Remarks : <textarea name="plotutilitysremarks"><?php echo $obj->plotutilitysremarks; ?></textarea></td>
                 </tr>
            <tr>
				<td colspan="6" align="center"><input type="submit" class="btn" value="Add Plotutility" name="action"></td>
			</tr>
            </table>
            <table style="margin:50px 200px;">

<?php
		$plotutilitys=new Plotutilitys();
		$i=0;
		$fields="em_plotutilitys.id, em_plots.name as plotid, em_paymentterms.name as paymenttermid, em_plotutilitys.amount, em_plotutilitys.showinst, em_plotutilitys.mgtfee, em_plotutilitys.mgtfeeperc, em_plotutilitys.vatable, sys_vatclasses.name as vatclasseid, em_plotutilitys.mgtfeevatable, em_plotutilitys.mgtfeevatclasseid";
		$join=" left join em_plots on em_plotutilitys.plotid=em_plots.id  left join em_paymentterms on em_plotutilitys.paymenttermid=em_paymentterms.id  left join sys_vatclasses on em_plotutilitys.vatclasseid=sys_vatclasses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_plotutilitys.plotid='$obj->id'";
		$plotutilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$plotutilitys->affectedRows;
		$res=$plotutilitys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->utilityid; ?></td>
				<td align="right"><?php echo $row->amount; ?></td>
				<td><?php echo $row->showinst; ?></td>
				<td><?php echo $row->mgtfeevatclasseid; ?></td>
				<td><?php echo $row->mgtfeevatable; ?></td>
				<td><?php echo $row->vatclasseid; ?></td>
				<td><?php echo $row->vatable; ?></td>
				<td><?php echo $row->mgtfeeperc; ?></td>
				<td><?php echo $row->mgtfee; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addplots_proc.php?id=<?php echo $obj->id; ?>&plotutilitys=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
</table>
</form>
      <div class="clearb"></div>
</div>

            


<div id="tabs-5" style="min-height:420px;">
<form method="post" action="addplots_proc.php" class="forms">
    <table width="50%" style="margin:50px 200px;">
	<tr>
		<td colspan="5"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
			<tr>
				<td align="right">Security Deposit :</td><td><select class="selectbox" name='plotspecialdepositspaymenttermid' required="required">
				<option value="">Select...</option>
				<?php
				$paymentterms=new Paymentterms();
				$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where trim(em_paymentterms.type)='Special Deposit' ";
				$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentterms->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->paymenttermid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
                </tr>
                <tr>
				<td align="right">Amount :</td><td> <input type="text" name="plotspecialdepositsamount" value="<?php echo $obj->plotspecialdepositsamount; ?>" ></td>
                </tr>
                <tr>
				<td align="right">Remarks :</td><td><textarea name="plotspecialdepositsremarks"><?php echo $obj->plotspecialdepositsremarks; ?></textarea></td>
                </tr>
                <tr>
				<td colspan="5" align="center"><input type="submit" class="btn" value="Add Plotspecialdeposit" name="action"></td>
			</tr>
            </table>
            <table style="margin:50px 200px;">
<?php
		$plotspecialdeposits=new Plotspecialdeposits();
		$i=0;
		$fields="em_plotspecialdeposits.id, em_plots.name as plotid, em_paymentterms.name as paymenttermid, em_plotspecialdeposits.amount, em_plotspecialdeposits.remarks";
		$join=" left join em_plots on em_plotspecialdeposits.plotid=em_plots.id  left join em_paymentterms on em_plotspecialdeposits.paymenttermid=em_paymentterms.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_plotspecialdeposits.plotid='$obj->id'";
		$plotspecialdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$plotspecialdeposits->affectedRows;
		$res=$plotspecialdeposits->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->paymenttermid; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addplots_proc.php?id=<?php echo $obj->id; ?>&plotspecialdeposits=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
            

		<?php } ?>
		         </table>
         </form>
         </div>
         
         <div id="tabs-9" style="min-height:420px;">
<form method="post" action="addplots_proc.php" class="forms">
    <table width="50%" style="margin:50px 200px;">
	<tr>
		<td colspan="5"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
			<tr>
				<td align="right">Fee :</td><td><select class="selectbox" name='plotspecialdepositspaymenttermid' required="required">
				<option value="">Select...</option>
				<?php
				$paymentterms=new Paymentterms();
				$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where trim(em_paymentterms.type)='Income' ";
				$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentterms->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->paymenttermid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
                </tr>
                <tr>
				<td align="right">Amount :</td><td> <input type="text" name="plotspecialdepositsamount" value="<?php echo $obj->plotspecialdepositsamount; ?>" ></td>
                </tr>
                <tr>
				<td align="right">Remarks :</td><td><textarea name="plotspecialdepositsremarks"><?php echo $obj->plotspecialdepositsremarks; ?></textarea></td>
                </tr>
                <tr>
				<td colspan="5" align="center"><input type="submit" class="btn" value="Add Plotspecialdeposit" name="action"></td>
			</tr>
            </table>
            <table style="margin:50px 200px;">
<?php
		$plotspecialdeposits=new Plotspecialdeposits();
		$i=0;
		$fields="em_plotspecialdeposits.id, em_plots.name as plotid, em_paymentterms.name as paymenttermid, em_plotspecialdeposits.amount, em_plotspecialdeposits.remarks";
		$join=" left join em_plots on em_plotspecialdeposits.plotid=em_plots.id  left join em_paymentterms on em_plotspecialdeposits.paymenttermid=em_paymentterms.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_plotspecialdeposits.plotid='$obj->id'";
		$plotspecialdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$plotspecialdeposits->affectedRows;
		$res=$plotspecialdeposits->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->paymenttermid; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addplots_proc.php?id=<?php echo $obj->id; ?>&plotspecialdeposits=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
            

		<?php } ?>
		         </table>
         </form>
         </div>

<div id="tabs-6" style="min-height:420px;">
<form method="post" action="addplots_proc.php" class="forms">
    <table width="50%" style="margin:50px 200px;">
	<tr>
		<td colspan="5"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	 <tr>
				<td align="right">Rent End Date :</td><td> <input type="text" name="plotrentsenddate" readonly="readonly" class="date_input" value="<?php echo $obj->plotrentsenddate; ?>" ></td>
                </tr>
			<tr>
				<td align="right">Increase Type :</td><td><select class="selectbox" name='plotrentsincreasetype' required="required">
				<option value="">Select...</option>
					<option value="perc" <?php if($obj->plotrentsincreasetype=="perc"){echo "selected";}?>>%</option>
					<option value="amount" <?php if($obj->plotrentsincreasetype=="amount"){echo "selected";}?>>Amount</option>
				</select></td>
                </tr>
                <tr>
				<td align="right">Increase Value :</td><td> <input type="text" name="plotrentsvalue" value="<?php echo $obj->plotrentsvalue; ?>" ></td>
                </tr>
                <tr>
				<td colspan="5" align="center"><input type="submit" class="btn" value="Adjust Rent" name="action"></td>
			</tr>
            </table>
            
         </form>
         </div>

         <div id="tabs-7" style="min-height:420px;">
<form method="post" action="addplots_proc.php" class="forms">
    <table width="50%" style="margin:50px 200px;">
	<tr>
				<td><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">&nbsp;</td>
				<td valign="bottom">Browse Document : <input type="file" name="plotdocumentsdocumentno" size="0" ></td>
				<td valign="bottom">Remarks : <textarea name="plotdocumentsremarks"><?php echo $obj->plotdocumentsremarks; ?></textarea></td>
				<td valign="bottom">Document Type : <select name='plotdocumentsdocumenttypeid'>
				<option value="">Select...</option>
				<?php
				$documenttypes=new Documenttypes();
				$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($documenttypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->documenttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">Document Name : <input type="text" name="plotdocumentsname" size="30" ></td>
				<td valign="bottom"><input type="submit" value="Add Plotdocument" name="action"></td>
			</tr>
<?php
		$plotdocuments=new Plotdocuments();
		$i=0;
		$fields="em_plotdocuments.id, em_plots.name as plotid, em_plotdocuments.documenttypeid, em_plotdocuments.name, em_plotdocuments.document, em_plotdocuments.remarks, em_plotdocuments.ipaddress, em_plotdocuments.createdby, em_plotdocuments.createdon, em_plotdocuments.lasteditedby, em_plotdocuments.lasteditedon";
		$join=" left join em_plots on em_plotdocuments.plotid=em_plots.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_plotdocuments.plotid='$obj->id'";
		$plotdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$plotdocuments->affectedRows;
		$res=$plotdocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><a href="files/<?php echo $row->documentno; ?>"><?php echo $row->documentno; ?></a></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->documenttypeid; ?></td>
				<td><?php echo $row->name; ?></td>
				<td><a href='addplots_proc.php?id=<?php echo $obj->id; ?>&plotdocuments=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
            
         </form>
         </div>
         
         <div id="tabs-8" style="min-height:420px;">
<form method="post" action="addplots_proc.php" class="forms">
    <table width="50%" style="margin:50px 200px;">
	<tr>
				<td><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">&nbsp;</td>
				<td valign="bottom">Company : <input type="text" name="plotinsurancescompany" size="20" ></td>
				<td valign="bottom">Start Date : <input type="text" name="plotinsurancesstartdate" readonly="readonly" size="12" class="date_input"></td>
				<td valign="bottom">Expiry Date : <input type="text" name="plotinsurancesexpirydate" readonly="readonly" size="12" class="date_input"></td>
				<td valign="bottom">Remarks : <textarea name="plotinsurancesremarks"><?php echo $obj->plotinsurancesremarks; ?></textarea></td>
				<td valign="bottom"><input type="submit" value="Add Plotinsurance" name="action"></td>
			</tr>
<?php
		$plotinsurances=new Plotinsurances();
		$i=0;
		$fields="em_plotinsurances.id, em_plots.name as plotid, em_plotinsurances.company, em_plotinsurances.startdate, em_plotinsurances.expirydate, em_plotinsurances.remarks, em_plotinsurances.ipaddress, em_plotinsurances.createdby, em_plotinsurances.createdon, em_plotinsurances.lasteditedby, em_plotinsurances.lasteditedon";
		$join=" left join em_plots on em_plotinsurances.plotid=em_plots.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_plotinsurances.plotid='$obj->id'";
		$plotinsurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$plotinsurances->affectedRows;
		$res=$plotinsurances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->company; ?></td>
				<td><?php echo $row->startdate; ?></td>
				<td><?php echo $row->expirydate; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addplots_proc.php?id=<?php echo $obj->id; ?>&plotinsurances=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
            
         </form>
         </div>
<?php }?>


<?php 
if(!empty($error)){
	showError($error);
}
?>
</div>