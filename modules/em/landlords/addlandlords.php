<!-- <title>WiseDigits: Landlords </title> -->
<?php 
include "../../../head.php";

?>
<link type="text/css" media="all" href="error.css" />
<script src="/wisedigits/estate/js/ui/jquery-ui.js"> </script>
<script src="functions.js"></script>
<script type="text/javascript">
$().ready(function() {
  $("#plotsemployeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))&where=hrm_assignments.departmentid=3&join=' left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid'",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#plotsemployeeid").val(ui.item.id);
	}
  });

});

</script>
<div id="tabs">

	<ul>
		<li><a href="#tabs-1">LANDLORDS</a></li>
		<li><a href="#tabs-2">PROPERTIES</a></li>
		<li><a href="#tabs-3">LANDLORD DOCUMENTS</a></li>
		<li><a href="#tabs-4">LANDLORD EMERGENCY CONTACTS</a></li>
	</ul>
<div id="tabs-1">
<form method="post"class="forms" action="addlandlords_proc.php" id="landlord"  enctype="multipart/form-data">
 <div id="form">
<table width="40%" style="margin-left:300px;">
    <tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
                  <tr>
                                                  <div class="row">
                  <td>
                                    <div class="label">LL Code:</div></td><td>
                                    <div class="input" id="llcode"><input type="text" name="llcode" id="llcode" value="<?php echo $obj->llcode; ?>" readonly/><font color='red'>*</font></div>                
               	</td>
                </div>
	</tr>
<tr>
<div class="row">
		<td>
      <div class="label">First Name:</div></td><td>
<div class="input" id="fname">
    <input type="text" name="firstname" class="detail" id="firstname" value="<?php echo $obj->firstname; ?>" required="required">
<font color='red'>*</font>
</div>
</td>
   </div>
</tr>
	<tr>
    
	<div class="row">
    <td>
      <div class="label">Middle Name : </div></td><td>
      <div class="input" id="jina">
      <input type="text" name="middlename" id="middlename" value="<?php echo $obj->middlename; ?>">
      </div>
      </td>
     </div>
	</tr>
	<tr>
        <div class="row">
		<td>
          <div class="label">Last Name :</div></td><td>
          <div class="input" id="lname">
          <input type="text" name="lastname" id="lastname" value="<?php echo $obj->lastname; ?>" required="required"><font color='red'>*</font>
          </div>
          </td>
    </div>
	</tr>
	<tr>
           <div class="row">
		<td>
      <div class="label">Telephone :</div></td><td>
      <div class="input" id="jina">
      <input type="numbers" name="tel" id="tel" value="<?php echo $obj->tel; ?>">
      </div>
       </td>
</div>
	</tr>
	<tr>
    <div class="row">
		<td> 
      <div class="label">Email :</div></td><td>
      <div class="input" id="jina">
      <input type="email" name="email" id="email" value="<?php echo $obj->email; ?>" size="24">
      </div>
      </td>
</div>
	</tr>
	<tr>
      <div class="row">
		<td>
      <div class="label">Date Registered :</div></td><td>
      <div class="input" id="datereg">
      <input type="text" name="registeredon" id="registeredon" class="date_input" size="14" readonly  value="<?php echo $obj->registeredon; ?>" required="required"><font color='red'>*</font>
      </div>
      </td>
</div>
	</tr>
	<tr>
    <div class="row">
		<td>
      <div class="label">Fax :</div></td><td>
      <div class="input" id="jina">
             <input type="text" name="fax" id="fax" value="<?php echo $obj->fax; ?>">
      </div>
      </td>
</div>
	</tr>
	<tr>
    <div class="row">
		<td>
      <div class="label">Mobile :</div></td><td>
      <div class="input" id="mobil">
      <input type="text" name="mobile" id="mobile" value="<?php echo $obj->mobile; ?>">
      </div>
      </td>
</div>
	</tr>
	<tr>
    <div class="row">
		<td> 
      <div class="label">National ID No :</div></td><td>
      <div class="input" id="idn">
      <input type="text" name="idno" id="idno" value="<?php echo $obj->idno; ?>">
      </div>
      </td>
</div>
	</tr>
	<tr>
        <div class="row">
		<td>
      <div class="label">Passport No :</div></td><td>
      <div class="input" id="pssprt">
      <input type="text" name="passportno" id="passportno" value="<?php echo $obj->passportno; ?>">
      </div>
      </td>
</div>
	</tr>
	<tr>
    <div class="row">
		<td>
      <div class="label">Postal Address :</div></td><td>
      <div class="input" id="pa">
      <textarea name="postaladdress" id="postaladdress"><?php echo $obj->postaladdress; ?></textarea>
      </div>
      </td>
</div>
	</tr>
	<tr>
     <div class="row">
		<td>
      <div class="label">Address :</div></td><td>
      <div class="input" id="jina">
      <textarea name="address"><?php echo $obj->address; ?></textarea>
      </div>
      </td>
</div>
	</tr>
	<tr>
    <div class="row">
		<td>
      <div class="label">Deduct Commission Directly :</div></td><td>
      <div class="input" id="jina">
      <select name='deductcommission' class="selectbox" required="required">
			<option value='Yes' <?php if($obj->deductcommission=='Yes'){echo"selected";}?>>Yes</option>
			<option value='No' <?php if($obj->deductcommission=='No'){echo"selected";}?>>No</option>
		</select>
      </div>
      </td>
</div>
	</tr>
	<tr>
		
        <div class="row">
        <td>
      <div class="label">Status :</div></td><td>
      <div class="input" id="jina">
      <select name='status' class="selectbox" required="required">
			<option value='Active' <?php if($obj->status=='Active'){echo"selected";}?>>Active</option>
			<option value='Inactive' <?php if($obj->status=='Inactive'){echo"selected";}?>>Inactive</option>
		</select>
      </div>
</div>
         </td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" class="btn" name="action" id="submit" value="<?php echo $obj->action; ?>">&nbsp;<input type="submit" class="btn" name="action" id="submit"  value="Cancel" onClick="window.top.hidePopWin(true);"/></td>
	</tr>
    </table>
    </form>
</div>   
</div>
<?php if(!empty($obj->id)){?>
<?php }?>
	<?php if(!empty($obj->id)){?> 

<div id="tabs-2" style="min-height:420px;">
 <form method="post"id="pADD" class="forms" action="addlandlords_proc.php" enctype="multipart/form-data" method="post">
		<table width="45%" style="margin:50px 150px;">
  <tr>
		<td colspan="6"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
        <span class="required_notification">* Denotes Required Field</span>
        </td>
	</tr>
			<tr>
				<td valign="bottom"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">Property Code : <input type="text" name="plotscode" size="8" value="<?php echo $obj->plotscode; ?>" required/></td>
<td valign="bottom">Property Name : <input type="text" name="plotsname" size="20" value="<?php echo $obj->plotsname; ?>" required="required"></td>
<td valign="bottom">Type : <select class="selectbox" name='plotstypeid' required="required">
				<option value="">Select...</option>
				<?php
				$types=new Types();
				$fields="em_types.id, em_types.name, em_types.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$types->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($types->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->typeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
                <td valign="bottom">Action : <select class="selectbox" name='plotsactionid' required="required">
				<option value="">Select...</option>
				<?php
				$actions=new Actions();
				$fields="em_actions.id, em_actions.name, em_actions.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$actions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($actions->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->actionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
                <td valign="bottom">No Of Units : <input type="text" name="plotsnoofhouses" size="16" value="<?php echo $obj->plotsnoofhouses; ?>" required="required"></td>
                                	</tr>
			<tr>
                <td valign="bottom">Region : <select class="selectbox" name='plotsregionid' required="required">
				<option value="">Select...</option>
				<?php
				$regions=new Regions();
				$fields="em_regions.id, em_regions.name, em_regions.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$regions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($regions->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->regionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>

				<td valign="bottom">Estate : <input type="text" name="plotsestate" size="20" value="<?php echo $obj->plotsestate; ?>" required="required"></td>
                		
				<td valign="bottom">Road : <input type="text" name="plotsroad" size="20" value="<?php echo $obj->plotsroad; ?>" required="required"></td>
				<td valign="bottom">Location : <input type="text" name="plotslocation" size="20" value="<?php echo $obj->plotslocation; ?>" required="required"></td>

				<td valign="bottom">Let-Able Area : <input type="text" name="plotsletarea" size="16" value="<?php echo $obj->plotsletarea; ?>" ></td>
                                			</tr>
			<tr>
				<td valign="bottom">UnUsed Area : <input type="text" name="plotsunusedarea" size="16" value="<?php echo $obj->plotsunusedarea; ?>" ></td>

				<td valign="bottom">Manager :<input type='text' size='20' name='plotsemployeename' id='plotsemployeename' value='<?php echo $obj->plotsemployeename; ?>'>
					<input type="hidden" name='plotsemployeeid' id='plotsemployeeid' value='<?php echo $obj->plotsemployeeid; ?>'></td>
				<td valign="bottom">Deposit<span style="color:red;">(Months Rent)</span>: <input type="text"  name="plotsdeposit" value="<?php echo $obj->plotsdeposit; ?>" size="18" maxlength="2" max="12" required></td>

				<td valign="bottom">LR/Plot No : <input type="text" name="plotslrno" size="20" value="<?php echo $obj->plotslrno; ?>" required="required"></td>
<td valign="bottom">Commencement Date : <input type="text" name="plotsmanagefrom" class="date_input" value="<?php echo $obj->plotsmanagefrom; ?>" required></td>
                				</tr>
			<tr>
				<td valign="bottom">Contract Period <span style="color:red;">(Months)</span> :<input type="text" size="18" name="plotsmanagefor" maxlength="2" max="12" value="<?php echo $obj->plotsmanagefor; ?>" required="required"></td>

			
				<td valign="bottom">Agency Fee : <select name="commissiontype" required>
																					<option value="">Select...</option>
																					<option value="1" <?php if($obj->commissiontype==1){echo"selected";}?>>%</option>
																					<option value="2" <?php if($obj->commissiontype==2){echo"selected";}?>>Amount</option>
																				</select> <input type="text" name="plotscommission" size="18" value="<?php echo $obj->plotscommission; ?>" required="required"></td>
				<td valign="bottom">PerfomanceTarget : <input type="text" name="plotstarget" size="18" value="<?php echo $obj->plotstarget; ?>" required="required"></td>
				<td valign="bottom">Penalty Date: <input type="text" name="plotspenaltydate" size="18" required/></td>
				<td valign="bottom">Pay Date : <input type="text" name="plotspaydate" size="18" required/></td>
				<td valign="bottom">Mgt Fee VAT Class : <select name='plotsmgtfeevatclasseid' class="selectbox">
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
				</select></td>
		                 		</tr>
				<tr>
				<td valign="bottom">Deposit Mgt Fee VATable: <select name='depositmgtfeevatable' class="selectbox">
					<option value='Yes' <?php if($obj->depositmgtfeevatable=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->depositmgtfeevatable=='No'){echo"selected";}?>>No</option>
					</select>
                    </td>

				<td valign="bottom">Mgt Fee On Deposit <span style="color:red;">(%)</span>: <input type="text" name="plotsdepositmgtfeeperc" maxlength="100" size="14" ></td>
				<td valign="bottom">VATable: <select name='depositmgtfee' class="selectbox" required="required">
					<option value='Yes' <?php if($obj->depositmgtfee=='Yes'){echo"selected";}?>>Yes</option>
					<option value='No' <?php if($obj->depositmgtfee=='No'){echo"selected";}?>>No</option>
					</select>
				<td valign="bottom">VAT Class : <select name='plotsvatclasseid' class="selectbox" required="required">
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
				<td valign="bottom">Remarks : <textarea name="plotsremarks"><?php echo $obj->plotsremarks; ?></textarea></td>
				<td valign="bottom"><input type="submit" class="btn" value="Add Plot" name="action"></td>
			</tr>
		</table>
        <div class="clearb"></div>
<div style="margin-bottom:50px;">
<div class="shadow">
		<table style="clear:both;"  class="tgrid display" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
        
	<thead>
		<tr>
			<th>Name</th>
			<th>code</th>
			<th>estate</th>
			<th>road</th>
			<th>location</th>
			<th>let Area</th>
			<th>usedArea</th>
			<th>empID</th>
			<th>deposit</th>
			<th>vatable</th>
			<th>status</th>
			<th>LR/PLOT No</th>
			<th>actionID</th>
			<th>noOfHses</th>
			<th>regionID</th>
            <th>manageFor</th>
			<th>indefinite</th>
			<th>typeID</th>
			<th>Agency Fee</th>
			<th>target</th>
            <th>remarks</th>
            <th> </th>
            
<?php
//Authorization.
$auth->roleid="4129";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php
}
//Authorization.
$auth->roleid="4130";//<img src="../view.png" alt="view" title="view" />
$auth->levelid=$_SESSION['level'];

if(existsRule($auth)){
?>
			<th>&nbsp;</th>
<?php } ?>
		</tr>
	</thead>
	<tbody>			
<?php
		$plots=new Plots();
		$i=0;
		$fields="em_plots.id, em_plots.code, concat(em_landlords.firstname,' ',concat(em_landlords.middlename,' ',em_landlords.lastname)) as landlordid, em_actions.name as actionid, em_plots.noofhouses, em_regions.name as regionid, em_plots.managefrom, em_plots.managefor, em_plots.indefinite, em_types.name as typeid, em_plots.commission, em_plots.target, em_plots.name, em_plots.lrno, em_plots.estate, em_plots.road, em_plots.location, em_plots.letarea, em_plots.unusedarea, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, em_plots.deposit, em_plots.vatable, em_plots.status, em_plots.remarks";
		$join=" left join em_landlords on em_plots.landlordid=em_landlords.id  left join em_actions on em_plots.actionid=em_actions.id  left join em_regions on em_plots.regionid=em_regions.id  left join em_types on em_plots.typeid=em_types.id  left join hrm_employees on em_plots.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby=" order by em_plots.code ";
		$where=" where em_plots.landlordid='$obj->id'";
		$plots->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$num=$plots->affectedRows;
		$res=$plots->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><a href="../plots/addplots_proc.php?id=<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
				<td><?php echo $row->code; ?></td>
				<td><?php echo $row->estate; ?></td>
				<td><?php echo $row->road; ?></td>
				<td><?php echo $row->location; ?></td>
				<td><?php echo $row->letarea; ?></td>
				<td><?php echo $row->unusedarea; ?></td>
				<td><?php echo $row->employeeid; ?></td>
				<td><?php echo $row->deposit; ?></td>
				<td><?php echo $row->vatable; ?></td>
				<td><?php echo $row->status; ?></td>
				<td><?php echo $row->lrno; ?></td>
				<td><?php echo $row->actionid; ?></td>
				<td><?php echo $row->noofhouses; ?></td>
				<td><?php echo $row->regionid; ?></td>
				<td><?php echo $row->managefrom; ?></td>
				<td><?php echo $row->managefor; ?></td>
				<td><?php echo $row->indefinite; ?></td>
				<td><?php echo $row->typeid; ?></td>
				<td><?php echo $row->commission; ?></td>
				<td><?php echo $row->target; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addlandlords_proc.php?delid=<?php echo $row->id; ?>' onclick='return confirm(&quot;Are you sure you want to de-activate?&quot;)'><img src='../trash.png' alt='delete' title='delete' /></a></td>
			</tr>
		<?php
		}
?>
</tbody>
</table>
</div>
</div>
</form>
<div class="clearb"></div>
</div>


<div id="tabs-3" style="min-height:420px;">
 <form method="post"id="pADD" class="forms" action="addlandlords_proc.php" enctype="multipart/form-data" method="post">
 <div id="form">
		<table width="45%" style="margin:50px 100px;">
			<tr>
				<td><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">&nbsp;</td>
				<td valign="bottom">Browse Document : <input type="file" name="landlorddocumentsdocument" size="0" ></td>
				<td valign="bottom">Remarks : <textarea name="landlorddocumentsremarks"><?php echo $obj->landlorddocumentsremarks; ?></textarea></td>
				<td valign="bottom">Document Type : <select name='landlorddocumentsdocumenttypeid'>
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
				<td valign="bottom">Document Name : <input type="text" name="landlorddocumentsname" size="30" ></td>
				<td valign="bottom"><input type="submit" value="Add Landlorddocument" name="action"></td>
			</tr>
<?php
		$landlorddocuments=new Landlorddocuments();
		$i=0;
		$fields="em_landlorddocuments.id, concat(em_landlords.firstname,' ',concat(em_landlords.middlename,' ',em_landlords.lastname)) as landlordid, em_landlorddocuments.documenttypeid, em_landlorddocuments.name, em_landlorddocuments.document, em_landlorddocuments.remarks, em_landlorddocuments.ipaddress, em_landlorddocuments.createdby, em_landlorddocuments.createdon, em_landlorddocuments.lasteditedby, em_landlorddocuments.lasteditedon";
		$join=" left join em_landlords on em_landlorddocuments.landlordid=em_landlords.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_landlorddocuments.landlordid='$obj->id'";
		$landlorddocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$landlorddocuments->affectedRows;
		$res=$landlorddocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><a href="files/<?php echo $row->documentno; ?>"><?php echo $row->documentno; ?></a></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->documenttypeid; ?></td>
				<td><?php echo $row->name; ?></td>
				<td><a href='addlandlords_proc.php?id=<?php echo $obj->id; ?>&landlorddocuments=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
		</div>
</form>
<div class="clearb"></div>
</div>

<div id="tabs-4" style="min-height:420px;">
 <form method="post"id="pADD" class="forms" action="addlandlords_proc.php" enctype="multipart/form-data" method="post">
 <div id="form">
		<table width="45%" style="margin:50px 150px;">
			<tr>
				<td><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">&nbsp;</td></tr><tr>
				<td valign="bottom">Name :</td><td> <input type="text" name="landlordemergencycontactsname" size="20" ></td></tr><tr>
				<td valign="bottom">Relation :</td><td>  <input type="text" name="landlordemergencycontactsrelation" size="20" ></td></tr><tr>
				<td valign="bottom">Telephone :</td><td>  <input type="text" name="landlordemergencycontactstel" size="20" ></td></tr><tr>
				<td valign="bottom">Email : </td><td> <input type="text" name="landlordemergencycontactsemail" size="20" ></td></tr><tr>
				<td valign="bottom">Address :</td><td>  <textarea name="landlordemergencycontactsaddress"><?php echo $obj->landlordemergencycontactsaddress; ?></textarea></td></tr><tr>
				<td valign="bottom">Physical Address :</td><td>  <textarea name="landlordemergencycontactsphysicaladdress"><?php echo $obj->landlordemergencycontactsphysicaladdress; ?></textarea></td></tr><tr>
				<td valign="bottom">Remarks :</td><td>  <textarea name="landlordemergencycontactsremarks"><?php echo $obj->landlordemergencycontactsremarks; ?></textarea></td></tr><tr>
				<td align="center"><input class="btn" type="submit" value="Add Landlordemergencycontact" name="action"></td>
			</tr>
<?php
		$landlordemergencycontacts=new Landlordemergencycontacts();
		$i=0;
		$fields="em_landlordemergencycontacts.id, concat(em_landlords.firstname,' ',concat(em_landlords.middlename,' ',em_landlords.lastname)) as landlordid, em_landlordemergencycontacts.name, em_landlordemergencycontacts.relation, em_landlordemergencycontacts.tel, em_landlordemergencycontacts.email, em_landlordemergencycontacts.address, em_landlordemergencycontacts.physicaladdress, em_landlordemergencycontacts.remarks, em_landlordemergencycontacts.ipaddress, em_landlordemergencycontacts.createdby, em_landlordemergencycontacts.createdon, em_landlordemergencycontacts.lasteditedby, em_landlordemergencycontacts.lasteditedon";
		$join=" left join em_landlords on em_landlordemergencycontacts.landlordid=em_landlords.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where em_landlordemergencycontacts.landlordid='$obj->id'";
		$landlordemergencycontacts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$landlordemergencycontacts->affectedRows;
		$res=$landlordemergencycontacts->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->name; ?></td>
				<td><?php echo $row->relation; ?></td>
				<td><?php echo $row->tel; ?></td>
				<td><?php echo $row->email; ?></td>
				<td><?php echo $row->address; ?></td>
				<td><?php echo $row->physicaladdress; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addlandlords_proc.php?id=<?php echo $obj->id; ?>&landlordemergencycontacts=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>
		</div>
</form>
<div class="clearb"></div>
</div>

<?php }?>

<?php 
//if(!empty($error)){
//	showError($error);
//}
?>
</div>