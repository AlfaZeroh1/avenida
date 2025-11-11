<title>WiseDigits: Units </title>
<?php 
include "../../../head.php";

?>
<script type="text/javascript">
$().ready(function() {
  $("#plotname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=plots&field=concat(code,' ',name)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#plotid").val(ui.item.id);
	}
  });

  $("#tenantname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=tenants&field=concat(concat(firstname,' ',middlename),' ',lastname)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#tenantid").val(ui.item.id);
	}
  });

});
</script>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">U DETAILS</a></li>
		<li><a href="#tabs-2">U TENANT</a></li>
		<li><a href="#tabs-3">U UTILS</a></li>		
		<li><a href="#tabs-12">U FEES</a></li>
       	<li><a href="#tabs-4">U UTIL EXEMPTIONS</a></li>
        <li><a href="#tabs-5">P.T HISTORY</a></li>
        <li><a href="#tabs-6">U RENTS</a></li>
		<li><a href="#tabs-7">P RENTS</a></li>
       	<li><a href="#tabs-8">U BREAKAGES</a></li>
        <li><a href="#tabs-9">U SECURITY DEPO</a></li>
        <li><a href="#tabs-10">U DEPO EXEMPTIONS</a></li>
        <li><a href="#tabs-11">UNIT INSPECTIONS</a></li>
	</ul>
    <div id="tabs-1">
<form method="post"class="forms" action="addhouses_proc.php" name="houses" id="house" method="POST" enctype="multipart/form-data">
<div id="form">
	<table width="42%" style="margin-left:300px;">
	<tr>
		<td colspan="4"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
	<tr>
    <div class="row">
		<td> 
      <div class="label">Unit No :</div></td><td>
      <div class="input" id="a">
       <input type="text" name="hseno" id="hseno" value="<?php echo $obj->hseno; ?>" required="required"><font color='red'>*</font>
      </div>
      </td>
        </div>
	</tr>
	<tr>
    <div class="row">
		<td> 
      <div class="label">Unit Code :</div></td><td>
      <div class="input" id="b">
<input type="text" name="hsecode" id="hsecode" value="<?php echo $obj->hsecode; ?>" readonly="readonly"><font color='red'>*</font>
      </div>
      </td>
  </div>
	</tr>
	<tr>
  <div class="row">
		<td>
      <div class="label">Property :</div></td><td>
      <div class="input" id="c">
        <textarea name='plotname' id='plotname'  required="required"><?php echo $obj->plotname; ?></textarea>
			<input type="hidden" name='plotid' id='plotid' value='<?php echo $obj->plotid; ?>'><font color='red'>*</font>
      </div>
      </td>
  </div>
	</tr>
	<tr>
      <div class="row">
    		<td> 
      <div class="label">Rent :</div></td><td>
      <div class="input" id="d">
      <input type="text" name="amount" id="amount" size="14" <?php if(!empty($obj->id)){echo "Readonly";}?>  value="<?php echo $obj->amount; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
      <div class="row">
		<td> 
      <div class="label">Size :</div></td><td>
      <div class="input" id="">
      <input type="text" name="size" id="size" size="8"  value="<?php echo $obj->size; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
      <div class="row">
		<td> 
      <div class="label">Rooms :</div></td><td>
      <div class="input" id=" ">
      <input type="text" name="bedrms" id="bedrms" size="4" value="<?php echo $obj->bedrms; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
            <div class="row">
<td> 
      <div class="label">Floor :</div></td><td>
      <div class="input" id=" ">
      <input type="text" name="floor" id="floor" size="4" value="<?php echo $obj->floor; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
           <div class="row">
		<td>
      <div class="label">Elec A/C No :</div></td><td>
      <div class="input" id=" ">
              <input type="text" name="elecaccno" id="elecaccno" value="<?php echo $obj->elecaccno; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
      <div class="row">
		<td> 
      <div class="label">Water A/C No :</div></td><td>
      <div class="input" id=" ">
        <input type="text" name="wateraccno" id="wateraccno" value="<?php echo $obj->wateraccno; ?>">
      </div>
      </td>
  </div>
	</tr>
	<tr>
    <div class="row">
		<td> 
      <div class="label">Description :</div></td><td>
      <div class="input" id=" ">
      <select class="selectbox" name="hsedescriptionid">
<option value="">Select...</option>
<?php
	$hsedescriptions=new Hsedescriptions();
	$where="  ";
	$fields="em_hsedescriptions.id, em_hsedescriptions.name, em_hsedescriptions.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$hsedescriptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($hsedescriptions->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->hsedescriptionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
      <div class="label">Security Rent Deposit :</div></td><td>
      <div class="input" id=" ">
              <input type="text" name="deposit" id="deposit" size="4" maxlength="2" max="12" value="<?php echo $obj->deposit; ?>"><span style="color:red;">(Months)</span>
      </div>
  </div>
</td>
	</tr>
	<tr>
    <div class="row">
		<td> 
      <div class="label">VATable :</div></td><td>
      <div class="input" id=" ">
         <select class="selectbox" name='vatable'>
			<option value='Yes' <?php if($obj->vatable=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->vatable=='No'){echo"selected";}?>>No</option>
		</select>
      </div>
      </td>
  </div>
  </tr>
	<tr>
    <div class="row">
		<td> 
      <div class="label">Unit Status :</div></td><td>
      <div class="input" id="e">
              <select class="selectbox" name="housestatusid" id="hsid" required="required">
<option value="">Select...</option>
<?php
	$housestatuss=new Housestatuss();
	$where="  ";
	$fields="em_housestatuss.id, em_housestatuss.name, em_housestatuss.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$housestatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($housestatuss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->housestatusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
      </div>
      </td>
  </div>
	</tr>
	<tr>
     <div class="row">
		<td> 
      <div class="label">Rental Status :</div></td><td>
      <div class="input" id="f">
      <select class="selectbox" name="rentalstatusid"  id="rsid">
<option value="">Select...</option>
<?php
	$rentalstatuss=new Rentalstatuss();
	$where="  ";
	$fields="em_rentalstatuss.id, em_rentalstatuss.name, em_rentalstatuss.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rentalstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($rentalstatuss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->rentalstatusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'>*</font>
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
		<td colspan="2" align="center"><input type="submit" class="btn" name="action" id="submit" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
    </table>
 </div>
 </form>
      <div class="clearb"></div>
</div><!-- T#1End -->
<?php if(!empty($obj->id)){?>
<div id="tabs-2" style="min-height:420px;">
<form method="post"action="addhouses_proc.php" name="houses" class="forms" method="POST" enctype="multipart/form-data">
	<table style="margin:50px 200px;">
	<tr>
		<td colspan="1" align="right"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
		
Payable: </td><td colspan='4'><select name="payable" class="selectbox">
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
        <span class="required_notification">* Denotes Required Field</span>
        </td>
		<td align="left"> 
<input type='hidden' name='houseid' value='<?php echo $obj->houseid; ?>'/>
<font color='red'>*</font>
		</td>
	<tr>
		<td align="right">Tenant : </td>
			<td><input type='text' size='36' name='tenantname' id='tenantname' value='<?php echo $obj->tenantname; ?>' required="required"/>
			<input type="hidden" name='tenantid' id='tenantid' value='<?php echo $obj->tenantid; ?>'><font color='red'>*</font>
			&nbsp;
		</td>
		<td align="right">Rental Type : </td>
		<td><select class="selectbox" name="rentaltypeid">
<option value="">Select...</option>
<?php
	$rentaltypes=new Rentaltypes();
	$where="  ";
	$fields="em_rentaltypes.id, em_rentaltypes.name, em_rentaltypes.months, em_rentaltypes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rentaltypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($rentaltypes->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->rentaltypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>
	<tr>
		<td align="right">Date Occupied :</td>
		<td><input type="text" name="occupiedon" id="occupiedon" class="date_input" readonly  value="<?php echo $obj->occupiedon; ?>"
        required="required"/><font color='red'>*</font></td>
		<td align="right">Lease Starts : </td>
		<td><input type="text" name="leasestarts" id="leasestarts" class="date_input" readonly  value="<?php echo $obj->leasestarts; ?>"></td>
	<tr>
		<td align="right">Renew Every : </td>
		<td><input type="text" maxlength="2" name="renewevery" size="4" id="renewevery" value="<?php echo $obj->renewevery; ?>"><span style="color:red;">(Months)</span></td>
		<td align="right">Lease Ends : </td>
		<td><input type="text" name="leaseends" id="leaseends" class="date_input" readonly  value="<?php echo $obj->leaseends; ?>"></td>
	<tr>
		<td align="right">Increase Type : </td>
		<td><select class="selectbox" name='increasetype'>
			<option value='' <?php if($obj->increasetype==''){echo"selected";}?>></option>
			<option value='%' <?php if($obj->increasetype=='%'){echo"selected";}?>>%</option>
			<option value='Amount' <?php if($obj->increasetype=='Amount'){echo"selected";}?>>Amount</option>
		</select></td>
		<td align="right">Increase By : </td>
		<td><input type="number" name="increaseby" id="increaseby" size="8"  value="<?php echo $obj->increaseby; ?>"></td>
	<tr>
		<td align="right">Increase Every : </td>
		<td><input type="number" name="increaseevery" id="increaseevery" maxlength="2" max="12" size="4" value="<?php echo $obj->increaseevery; ?>"><span style="color:red;">(Months)</span></td>
		<td align="right">Rent Due Date : </td>
		<td><input type="number" name="rentduedate" maxlength="2" max="12" id="rentduedate" size="4" value="<?php echo $obj->rentduedate; ?>"><span style="color:red;">(Every Month/quarter)</span></td>
	
	<?php
	if(!empty($obj->tenantid)){
	?>
	<tr>
		<td align="right">Vacated On : </td>
		<td><input type="text" name="vacatedon" id="vacatedon" class="date_input" readonly size="12" value="<?php echo $obj->vacatedon; ?>"><span style="color:red;">(Months)</span></td>
		<td align="right">&nbsp; </td>
		<td>&nbsp;</td>
	<?php }?>
	<tr>
		<td colspan="5" align="center">
		<?php if($obj->actionhousetenant=="Update Housetenant"){?>
			<input type="submit" class="btn" value="Vacate" name="actionhousetenant"/>
		<?php }?>
		<input type="submit" class="btn" value="<?php echo $obj->actionhousetenant;?>" name="actionhousetenant"/>&nbsp;<input type="button" class="btn" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/></td>
	</tr>
     	</table>
        </form>
        <?php if(!empty($obj->tenantid) and !empty($obj->houseid)){?>
        <table style="margin:50px 200px; width:70%" class="tgrid display">
       <tr>
	<th colspan='4' align='center'>PAID DEPOSITS</th>
       </tr>
       <tr>
	<th>#</th>
	<th>Deposit Name</th>
	<th>Amount</th>
	<th>Date Paid</th>
	<th>Remarks</th>
	<th>With Landlord/Office</th>
       </tr>
       <?php
       $i=0;
       $tenantdeposits = new Tenantdeposits();
       $fields="em_paymentterms.name paymenttermid, em_tenantdeposits.amount, em_tenantdeposits.paidon, em_tenantdeposits.remarks, case when em_tenantdeposits.status=1 then 'With Landlord' when em_tenantdeposits.status=2 then 'With the Office' end status ";
       $join=" left join em_paymentterms on em_paymentterms.id=em_tenantdeposits.paymenttermid ";
      $having="";
      $groupby="";
      $orderby=" order by paymenttermid ";
      $where=" where houseid='$obj->houseid' and tenantid='$obj->tenantid'";
      $tenantdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
      while($row=mysql_fetch_object($tenantdeposits->result)){$i++;
      ?>
	<tr>
	  <td><?php echo $i; ?></td>
	  <td><?php echo $row->paymenttermid; ?></td>
	  <td><?php echo formatNumber($row->amount); ?></td>
	  <td><?php echo formatDate($row->paidon); ?></td>
	  <td><?php echo $row->remarks; ?></td>
	  <td><?php echo $row->status; ?></td>
	</tr>
      <?php
      }
       ?>
       </table>
       <?php }?>
<div class="clearb"></div>
</div>
<?php }?>
	<?php if(!empty($obj->id)){?> 
<div id="tabs-3" style="min-height:420px;">
<form method="post"action="addhouses_proc.php" name="houses" class="forms" method="POST" enctype="multipart/form-data">
		<table width="50%" style="margin:5% 25%;">
        <tr><td colspan="6">
<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
			<tr>	</tr>
			<tr>
				<td valign="bottom">Utility : <select name='houseutilityspaymenttermid' class="selectbox" required="required">
				<option value="">Select...</option>
				<?php
				$paymentterms=new Paymentterms();
				$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where trim(em_paymentterms.type)='Utility' ";
				$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentterms->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->paymenttermid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
				<td valign="bottom">Amount : <input type="text" required="required" name="houseutilitysamount" value="<?php echo $obj->houseutilitysamount; ?>" ></td>
				<td valign="bottom">VATable? <select name='vatable' class="selectbox">
					<option value='Yes' <?php if($obj->vatable=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->vatable=='No'){echo"selected";}?>>No</option>
					</select>
                 </td>
				 <td valign="bottom">VAT Class : <select name='houseutilitysvatclasseid' class="selectbox">
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
				<td valign="bottom">Is Mgt Fee charged? <select name='mgtfee' class="selectbox">
					<option value='Yes' <?php if($obj->mgtfee=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->mgtfee=='No'){echo"selected";}?>>No</option>
					</select>
				<td valign="bottom">Mgt Fee <span style="color:red;">(%)</span>:<input type="text" maxlength="2" max="99" name="houseutilitysmgtfeeperc"></td>
					<option value='Yes' <?php if($obj->mgtfee=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->mgtfee=='No'){echo"selected";}?>>No</option>
					</select>
					
				<td valign="bottom">Mgt Fee VATable? <select name='mgtfeevatable' class="selectbox">
					<option value='Yes' <?php if($obj->mgtfeevatable=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->mgtfeevatable=='No'){echo"selected";}?>>No</option>
					</select>
				
				
                 
				
				<td valign="bottom">Mgt Fee VAT Class : <select name='houseutilitysmgtfeevatclasseid'  class="selectbox">
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
				</select>
                </td>
				
                </tr>
                <tr>
				<td valign="bottom">Show in Statement : <input type="checkbox" name="showinst" size="6" ></td>
				<td colspan="3" valign="bottom">Remarks : <textarea name="houseutilitysremarks"><?php echo $obj->houseutilitysremarks; ?></textarea></td>
              </tr>
            <tr>
				<td colspan="6" align="center"><input type="submit" class="btn" value="Add Houseutility" name="action"></td>
			</tr>
            </table>
            <table style="margin-top:50px;">
<?php
		$houseutilitys=new Houseutilitys();
		$i=0;
		$fields="em_houseutilitys.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, em_paymentterms.name as paymenttermid, em_houseutilitys.amount, em_houseutilitys.showinst, em_houseutilitys.mgtfee, em_houseutilitys.mgtfeeperc, em_houseutilitys.vatable, sys_vatclasses.name as vatclasseid, em_houseutilitys.mgtfeevatable, em_houseutilitys.mgtfeevatclasseid, em_houseutilitys.remarks";
		$join=" left join em_houses on em_houseutilitys.houseid=em_houses.id  left join em_paymentterms on em_houseutilitys.paymenttermid=em_paymentterms.id  left join sys_vatclasses on em_houseutilitys.vatclasseid=sys_vatclasses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_houseutilitys.houseid='$obj->id'";
		$houseutilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$houseutilitys->affectedRows;
		$res=$houseutilitys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->showinst; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->paymenttermid; ?></td>
				<td><?php echo $row->mgtfeevatable; ?></td>
				<td><?php echo $row->vatclasseid; ?></td>
				<td><?php echo $row->vatable; ?></td>
				<td><?php echo $row->mgtfeeperc; ?></td>
				<td><?php echo $row->mgtfee; ?></td>
				<td><?php echo $row->mgtfeevatclasseid; ?></td>
				<td><a href='addhouses_proc.php?id=<?php echo $obj->id; ?>&houseutilitys=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
        </form>
<div class="clearb"></div>
</div><!-- Tab#3#End -->

<div id="tabs-12" style="min-height:420px;">
<form method="post"action="addhouses_proc.php" name="houses" class="forms" method="POST" enctype="multipart/form-data">
		<table width="50%" style="margin:5% 25%;">
        <tr><td colspan="6">
<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
			<tr>	</tr>
			<tr>
				<td valign="bottom">Utility : <select name='houseutilityspaymenttermid' class="selectbox" required="required">
				<option value="">Select...</option>
				<?php
				$paymentterms=new Paymentterms();
				$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.remarks";
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
				<td valign="bottom">Amount : <input type="text" required="required" name="houseutilitysamount" value="<?php echo $obj->houseutilitysamount; ?>" ></td>
				<td valign="bottom">VATable? <select name='vatable' class="selectbox">
					<option value='Yes' <?php if($obj->vatable=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->vatable=='No'){echo"selected";}?>>No</option>
					</select>
                 </td>
				 <td valign="bottom">VAT Class : <select name='houseutilitysvatclasseid' class="selectbox">
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
				<td valign="bottom">Is Mgt Fee charged? <select name='mgtfee' class="selectbox">
					<option value='Yes' <?php if($obj->mgtfee=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->mgtfee=='No'){echo"selected";}?>>No</option>
					</select>
				<td valign="bottom">Mgt Fee <span style="color:red;">(%)</span>:<input type="text" maxlength="2" max="99" name="houseutilitysmgtfeeperc"></td>
					<option value='Yes' <?php if($obj->mgtfee=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->mgtfee=='No'){echo"selected";}?>>No</option>
					</select>
					
				<td valign="bottom">Mgt Fee VATable? <select name='mgtfeevatable' class="selectbox">
					<option value='Yes' <?php if($obj->mgtfeevatable=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->mgtfeevatable=='No'){echo"selected";}?>>No</option>
					</select>
				
				
                 
				
				<td valign="bottom">Mgt Fee VAT Class : <select name='houseutilitysmgtfeevatclasseid'  class="selectbox">
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
				</select>
                </td>
				
                </tr>
                <tr>
				<td valign="bottom">Show in Statement : <input type="checkbox" name="showinst" size="6" ></td>
				<td colspan="3" valign="bottom">Remarks : <textarea name="houseutilitysremarks"><?php echo $obj->houseutilitysremarks; ?></textarea></td>
              </tr>
            <tr>
				<td colspan="6" align="center"><input type="submit" class="btn" value="Add Houseutility" name="action"></td>
			</tr>
            </table>
            <table style="margin-top:50px;">
<?php
		$houseutilitys=new Houseutilitys();
		$i=0;
		$fields="em_houseutilitys.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, em_paymentterms.name as paymenttermid, em_houseutilitys.amount, em_houseutilitys.showinst, em_houseutilitys.mgtfee, em_houseutilitys.mgtfeeperc, em_houseutilitys.vatable, sys_vatclasses.name as vatclasseid, em_houseutilitys.mgtfeevatable, em_houseutilitys.mgtfeevatclasseid, em_houseutilitys.remarks";
		$join=" left join em_houses on em_houseutilitys.houseid=em_houses.id  left join em_paymentterms on em_houseutilitys.paymenttermid=em_paymentterms.id  left join sys_vatclasses on em_houseutilitys.vatclasseid=sys_vatclasses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_houseutilitys.houseid='$obj->id'";
		$houseutilitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$houseutilitys->affectedRows;
		$res=$houseutilitys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->showinst; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->paymenttermid; ?></td>
				<td><?php echo $row->mgtfeevatable; ?></td>
				<td><?php echo $row->vatclasseid; ?></td>
				<td><?php echo $row->vatable; ?></td>
				<td><?php echo $row->mgtfeeperc; ?></td>
				<td><?php echo $row->mgtfee; ?></td>
				<td><?php echo $row->mgtfeevatclasseid; ?></td>
				<td><a href='addhouses_proc.php?id=<?php echo $obj->id; ?>&houseutilitys=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
        </form>
<div class="clearb"></div>
</div>
<div id="tabs-4" style="min-height:420px;">
<form method="post"action="addhouses_proc.php" name="houses" class="forms" method="POST" enctype="multipart/form-data">
		<table style="margin:50px 400px;">
        <tr><td colspan="6">
<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
			<tr>
				<td align="center">Utility :</td><td><select class="selectbox" name='houseutilityexemptionsutilityid' required="required">
				<option value="">Select...</option>
				<?php
				$paymentterms=new Paymentterms();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where type='Utility'";
				$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentterms->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->utilityid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
              </tr>
              <tr>
				<td align="center">Remarks :</td><td><textarea name="houseutilityexemptionsremarks"><?php echo $obj->houseutilityexemptionsremarks; ?></textarea></td>
             </tr>
             <tr>
				<td colspan="2" align="center"><input type="submit" class="btn" value="Add Houseutilityexemption" name="action"></td>
			</tr>
            </table>
            <table style="margin:50px 200px;">
<?php
		$houseutilityexemptions=new Houseutilityexemptions();
		$i=0;
		$fields="em_houseutilityexemptions.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, em_utilitys.name as utilityid, em_houseutilityexemptions.remarks";
		$join=" left join em_houses on em_houseutilityexemptions.houseid=em_houses.id  left join em_utilitys on em_houseutilityexemptions.utilityid=em_utilitys.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_houseutilityexemptions.houseid='$obj->id'";
		$houseutilityexemptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$houseutilityexemptions->affectedRows;
		$res=$houseutilityexemptions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->utilityid; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addhouses_proc.php?id=<?php echo $obj->id; ?>&houseutilityexemptions=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
        </form>
<div class="clearb"></div>
</div><!-- Tab#4#End -->
<div id="tabs-5" style="min-height:420px;">
<div class="shadow">
<form method="post" action="addhouses_proc.php" name="houses" class="forms" method="POST" enctype="multipart/form-data">
		<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
        	<thead>
		<tr>
			<th>#</th>
			<th>Tenant </th>
			<th>Rental Type </th>
			<th>Date Occupied </th>
			<th>Vacated On </th>
			<th>Lease Starts </th>
			<th>Renew Every (Months) </th>
			<th>Lease Ends </th>
			<th>Increase Type </th>
			<th>Increase By </th>
			<th>Increase Every (Months) </th>
			<th>Rent Due Date (Every Month/quarter) </th>
			<th>&nbsp;</th>
		</tr>
			</thead>
            
<?php
		$houserentings=new Houserentings();
		$i=0;
		$fields="em_houserentings.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, concat(em_tenants.firstname,' ',concat(em_tenants.middlename,' ',em_tenants.lastname)) as tenantid, em_rentaltypes.name as rentaltypeid, em_houserentings.occupiedon, em_houserentings.vacatedon, em_houserentings.leasestarts, em_houserentings.renewevery, em_houserentings.leaseends, em_houserentings.increasetype, em_houserentings.increaseby, em_houserentings.increaseevery, em_houserentings.rentduedate, em_houserentings.status";
		$join=" left join em_houses on em_houserentings.houseid=em_houses.id  left join em_tenants on em_houserentings.tenantid=em_tenants.id  left join em_rentaltypes on em_houserentings.rentaltypeid=em_rentaltypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_houserentings.houseid='$obj->id'";
		$houserentings->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$houserentings->affectedRows;
		$res=$houserentings->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
    <tbody>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->tenantid; ?></td>
				<td><?php echo $row->rentaltypeid; ?></td>
				<td><?php echo formatDate($row->occupiedon); ?></td>
				<td><?php echo formatDate($row->vacatedon); ?></td>
				<td><?php echo formatDate($row->leasestarts); ?></td>
				<td><?php echo $row->renewevery; ?></td>
				<td><?php echo formatDate($row->leaseends); ?></td>
				<td><?php echo $row->increasetype; ?></td>
				<td><?php echo $row->increaseby; ?></td>
				<td><?php echo $row->increaseevery; ?></td>
				<td><?php echo $row->rentduedate; ?></td>
				<td>
				<?php if($row->status==2){?>
				<a href="">Refund</a>
				<?php }?>
				</td>
           </tr>
           </tbody>
		<?php
		}
?>
		</table>
       </form>
       
       </div>
        <div class="clearb"></div>
</div>
<div id="tabs-6" style="min-height:420px;">
<form method="post" action="addhouses_proc.php" class="forms" >
		<table align='left' width="50%" style="margin:50px 320px;">
        <tr><td colspan="3">
<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
			<tr>
				<td align="right"><input type="hidden" name="houserentsprevious" value="<?php echo $obj->houserentsprevious; ?>" size="25" ></td>
                </tr>
                <tr>
				<td align="right">End Date :</td><td> <input type="text" class="date_input" readonly="readonly" name="houserentsenddate" size="18" value="<?php echo $obj->houserentsenddate; ?>" required="required" ></td>
                 </tr>
                <tr>
				<td align="right">New Rent Amount :</td><td> <input type="text" name="houserentscurrent" value="<?php echo $obj->houserentscurrent; ?>" required="required"></td>
                 </tr>
                <tr>
				<td align="center" colspan="3"><input type="submit" class="btn" value="Update Houserent" name="action"></td>
			</tr>
<?php
		$houserents=new Houserents();
		$i=0;
		$fields="em_houserents.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, em_houserents.previous, em_houserents.enddate, em_houserents.current";
		$join=" left join em_houses on em_houserents.houseid=em_houses.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_houserents.houseid='$obj->id'";
		$houserents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$houserents->affectedRows;
		$res=$houserents->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo formatNumber($row->previous); ?></td>
				<td><?php echo formatDate($row->enddate); ?></td>
				<td><?php echo formatNumber($row->current); ?></td>
				<td>&nbsp;</td>
			</tr>
			
		<?php
		}
?>
		</table>
        </form>
<div class="clearb"></div>
</div><!-- Tab#4#End -->
        
<div id="tabs-7" style="min-height:420px;">
<div class="shadow" style="margin-top:30px;">
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
        	<thead>
		<tr>
			<th>#</th>
			<th>#</th>
			<th>#</th>
			<th>#</th>
			<th>#</th>
			<th>#</th>
			<th>#</th>
			<th>#</th>
			<th>#</th>
			<th>#</th>
			<th>#</th>
		</tr>
			</thead>
			
<?php
		$tenantpayments=new Tenantpayments();
		$i=0;
		$fields="em_tenantpayments.id, concat(em_tenants.firstname,' ',concat(em_tenants.middlename,' ',em_tenants.lastname)) as tenantid, em_tenantpayments.documentno, em_paymentterms.name as paymenttermid, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, em_tenantpayments.chequeno, em_tenantpayments.amount, em_tenantpayments.paidon, em_tenantpayments.month, em_tenantpayments.year, em_tenantpayments.paidby, em_tenantpayments.remarks";
		$join=" left join em_tenants on em_tenantpayments.tenantid=em_tenants.id  left join em_paymentterms on em_tenantpayments.paymenttermid=em_paymentterms.id  left join sys_paymentmodes on em_tenantpayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on em_tenantpayments.bankid=fn_banks.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_tenantpayments.houseid='$obj->id'";
		$tenantpayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$num=$tenantpayments->affectedRows;
		$res=$tenantpayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
    <tbody>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->tenantid; ?></td>
				<td><?php echo $row->month; ?></td>
				<td><?php echo $row->year; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->documentno; ?></td>
				<td><?php echo $row->paymentmodeid; ?></td>
				<td><?php echo $row->paidon; ?></td>
				<td><?php echo $row->paidby; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addhouses_proc.php?id=<?php echo $obj->id; ?>&tenantpayments=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
      </tbody>
      		
    
		<?php
		}
?>
</table>
</div>
<div class="clearb"></div>
</div><!-- Tab#4#End -->
<div id="tabs-8" style="min-height:420px;">
<form method="post" class="forms" action="addhouses_proc.php">
	<table style="margin:50px 350px;">
        <tr><td colspan="6">
<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
			<tr>
				<td align="center">Tenant :</td><td><input type='text' size='36' name='tenantname' readonly="readonly" value='<?php echo $obj->tenantname; ?>' required="required"></td>
                </tr>
                <tr>
				<td align="center">Breakage :</td><td> <input type="text" name="housebreakagesbreakage" size="25" value="<?php echo $obj->housebreakagesbreakage; ?>" required="required"></td>
                                </tr>
                <tr>
				<td align="center">Cost : </td><td><input type="text" name="housebreakagescost" size="25" value="<?php echo $obj->housebreakagescost; ?>" required="required" ></td>
                                </tr>
                <tr>
				<td align="center">Remarks : </td><td><textarea name="housebreakagesremarks"><?php echo $obj->housebreakagesremarks; ?></textarea></td>
                </tr>
                <tr>
				<td colspan="3" align="center"><input type="submit" class="btn" value="Add Housebreakage" name="action"></td>
			</tr>
<?php
		$housebreakages=new Housebreakages();
		$i=0;
		$fields="em_housebreakages.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, concat(em_tenants.firstname,' ',concat(em_tenants.middlename,' ',em_tenants.lastname)) as tenantid, em_housebreakages.breakage, em_housebreakages.fixed, em_housebreakages.cost, em_housebreakages.paidbytenant, em_housebreakages.remarks";
		$join=" left join em_houses on em_housebreakages.houseid=em_houses.id  left join em_tenants on em_housebreakages.tenantid=em_tenants.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_housebreakages.houseid='$obj->id'";
		$housebreakages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$housebreakages->affectedRows;
		$res=$housebreakages->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->tenantid; ?></td>
				<td><?php echo $row->breakage; ?></td>
				<td><?php echo $row->fixed; ?></td>
				<td><?php echo $row->cost; ?></td>
				<td><?php echo $row->paidbytenant; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addhouses_proc.php?id=<?php echo $obj->id; ?>&housebreakages=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
            
		<?php
		}
?>
	</table>	
       </form>
<div class="clearb"></div>
</div><!-- Tab#4#End -->
<div id="tabs-9" style="min-height:420px;">
<form method="post"class="forms" action="addhouses_proc.php">
	<table style="margin:50px 400px;">
        <tr><td colspan="6">
<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
            <tr>
				<td align="right">Security Deposit :</td><td>
				<?php 
				$paymentterms=new Paymentterms();
				$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where em_paymentterms.type='Special Deposit' ";
				$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
				?>
				<select class="selectbox" name='housespecialdepositspaymenttermid' required="required">
				<option value="">Select...</option>
				<?php
				

				while($rw=mysql_fetch_object($paymentterms->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->housespecialdepositspaymenttermid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
                </tr>
                <tr>
				<td align="right">Amount :</td><td><input type="text" name="housespecialdepositsamount" value="<?php echo $obj->housespecialdepositsamount; ?>" required="required"></td>
                 </tr>
                <tr>
				<td align="right">Remarks :</td><td><textarea name="housespecialdepositsremarks"><?php echo $obj->housespecialdepositsremarks; ?></textarea></td>
                 </tr>
                <tr>
				<td colspan="3" align="center"><input type="submit" class="btn" value="Add Housespecialdeposit" name="action"></td>
			</tr>
<?php
		$housespecialdeposits=new Housespecialdeposits();
		$i=0;
		$fields="em_housespecialdeposits.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, em_paymentterms.name as paymenttermid, em_housespecialdeposits.amount, em_housespecialdeposits.remarks";
		$join=" left join em_houses on em_housespecialdeposits.houseid=em_houses.id  left join em_paymentterms on em_housespecialdeposits.paymenttermid=em_paymentterms.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_housespecialdeposits.houseid='$obj->id'";
		$housespecialdeposits->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$housespecialdeposits->affectedRows;
		$res=$housespecialdeposits->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->paymenttermid; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addhouses_proc.php?id=<?php echo $obj->id; ?>&housespecialdeposits=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
       
		<?php
		}
?>
	     </table>	
        </form>
<div class="clearb"></div>
</div><!-- Tab#4#End -->
<div id="tabs-10" style="min-height:420px;">
<form method="post"class="forms" action="addhouses_proc.php">
	<table style="margin:50px 400px;">
        <tr><td colspan="6">
<input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
            <tr>
				<td align="center">Security Deposit :</td><td><select class="selectbox" name='housespecialdepositexemptionspaymenttermid' required="required">
				<option value="">Select...</option>
				<?php
				$paymentterms=new Paymentterms();
				$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where em_paymentterms.type='Special Deposit' ";
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
				<td align="center">Remarks :</td><td><textarea name="housespecialdepositexemptionsremarks"><?php echo $obj->housespecialdepositexemptionsremarks; ?></textarea></td>
                </tr>
                <tr>
				<td colspan="3" align="center"><input type="submit" class="btn" value="Add Housespecialdepositexemption" name="action"></td>
			</tr>
<?php
		$housespecialdepositexemptions=new Housespecialdepositexemptions();
		$i=0;
		$fields="em_housespecialdepositexemptions.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, em_paymentterms.name as paymenttermid, em_housespecialdepositexemptions.remarks";
		$join=" left join em_houses on em_housespecialdepositexemptions.houseid=em_houses.id  left join em_paymentterms on em_housespecialdepositexemptions.paymenttermid=em_paymentterms.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_housespecialdepositexemptions.houseid='$obj->id'";
		$housespecialdepositexemptions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$housespecialdepositexemptions->affectedRows;
		$res=$housespecialdepositexemptions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->paymenttermid; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addhouses_proc.php?id=<?php echo $obj->id; ?>&housespecialdepositexemptions=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
</form>
</div>

<div id="tabs-11" style="min-height:420px;">
<form method="post"class="forms" action="addhouses_proc.php">
	<table style="margin:50px 400px;">
        <tr>
				
				<td align="right">Unit Status : </td><td><select name='houseinspectionshousestatusid'>
				<option value="">Select...</option>
				<?php
				$houses=new Houses();
				$fields="em_houses.id, em_houses.hseno, em_houses.hsecode, em_houses.plotid, em_houses.amount, em_houses.size, em_houses.bedrms, em_houses.floor, em_houses.elecaccno, em_houses.wateraccno, em_houses.hsedescriptionid, em_houses.deposit, em_houses.depositmgtfee, em_houses.depositmgtfeevatable, em_houses.depositmgtfeevatclasseid, em_houses.depositmgtfeeperc, em_houses.vatable, em_houses.housestatusid, em_houses.rentalstatusid, em_houses.chargeable, em_houses.penalty, em_houses.remarks, em_houses.ipaddress, em_houses.createdby, em_houses.createdon, em_houses.lasteditedby, em_houses.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$houses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($houses->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->housestatusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr><tr>
				<td align="right">Findings :</td><td> <textarea name="houseinspectionsfindings"><?php echo $obj->houseinspectionsfindings; ?></textarea></td></tr><tr>
				<td align="right">Recommendations :</td><td> <textarea name="houseinspectionsrecommendations"><?php echo $obj->houseinspectionsrecommendations; ?></textarea></td></tr><tr>
				<td align="right">Remarks :</td><td> <textarea name="houseinspectionsremarks"><?php echo $obj->houseinspectionsremarks; ?></textarea></td></tr><tr>
				<td align="right">Employee :</td><td><input type='text' size='20' name='houseinspectionsemployeename' id='houseinspectionsemployeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='houseinspectionsemployeeid' id='houseinspectionsemployeeid' value='<?php echo $obj->field; ?>'></td></tr><tr>
				<td align="right">Done On :</td><td> <input type="text" name="houseinspectionsdoneon" size="20" class="date_input"></td></tr><tr>
				<td align="center"><input class="btn" type="submit" value="Add Houseinspection" name="action"></td>
			</tr>
<?php
		$houseinspections=new Houseinspections();
		$i=0;
		$fields="em_houseinspections.id, concat(em_houses.hseno,' - ',em_houses.hsecode) as houseid, em_housestatuss.name as housestatusid, em_houseinspections.findings, em_houseinspections.recommendations, em_houseinspections.remarks, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, em_houseinspections.doneon, em_houseinspections.ipaddress, em_houseinspections.createdby, em_houseinspections.createdon, em_houseinspections.lasteditedby, em_houseinspections.lasteditedon";
		$join=" left join em_houses on em_houseinspections.houseid=em_houses.id  left join em_housestatuss on em_houseinspections.housestatusid=em_housestatuss.id  left join hrm_employees on em_houseinspections.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_houseinspections.houseid='$obj->id'";
		$houseinspections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$houseinspections->affectedRows;
		$res=$houseinspections->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->housestatusid; ?></td>
				<td><?php echo $row->findings; ?></td>
				<td><?php echo $row->recommendations; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->employeeid; ?></td>
				<td><?php echo $row->doneon; ?></td>
				<td><a href='addhouses_proc.php?id=<?php echo $obj->id; ?>&houseinspections=<?php echo $row->id; ?>'>Del</a></td>
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