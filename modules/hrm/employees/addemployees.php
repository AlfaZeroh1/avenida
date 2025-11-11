-<title>WiseDigits: Employees </title>
<?php 
include "../../../head.php";

?>
<script language="javascript1.1" type="text/javascript">
$(document).ready(function() {
    $('table.display').DataTable();
} );
// hide divs
function loadM(str)
{	//alert("chokoraaaa");
      
	var pm = document.getElementById("m1");
	var pm1 = document.getElementById("m2");
	var pm2 = document.getElementById("m3");
	var pm3 = document.getElementById("m4");
	//var pm4 = document.getElementById("m5");
	
	if(str.value=="yes")
	{
		//do nothing
		pm.style.display="block";
		pm1.style.display="block";
		pm2.style.display="block";
		pm3.style.display="block";
		//pm4.style.display="block";
		text.innerHTML="show";
		
	}
	else
	{
		pm.style.display="none";
		pm1.style.display="none";
		pm2.style.display="none";
		pm3.style.display="none";
// 		pm4.style.display="none";
		//pm.style.display="none";
		text.innerHTML="show";
	}
		
	
}

function getPayable(){
  var principal = $("#employeeloansprincipal").val();
  var duration = $("#employeeloansduration").val();
  var payable = principal/duration;
  $("#employeeloanspayable").val(payable);
}

function hideShow(id){
var s = document.getElementById(id).style;
s.visibility=s.visibility=='hidden'?'visible':'hidden'; 
}
function hide(id){
var s = document.getElementById(id).style;
s.visibility='hidden'; 
}
this.value="<?php echo $obj->marital; ?>";
womAdd('loadM(this)');
womOn();

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

<script type="text/javascript">
$().ready(function() {
  $("#allowancesallowancename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=allowances&field=concat(surname,' ',othernames)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#allowancesallowanceid").val(ui.item.id);
	}
  });

});
</script>

<div class="container" style="margin-top:;">
<div class="panel with-nav-tabs panel-default">
      <div class="panel-heading">
           <ul class="nav nav-tabs">
		<li><a href="#tabs-1" data-toggle="tab">DETAILS</a></li>
		<?php if(!$obj->sys){?>
		<li><a href="#tabs-2" data-toggle="tab">DEPENDANTS</a></li>
		<?php }if(!$obj->sys){?>
		<li><a href="#tabs-3" data-toggle="tab" >DOCUMENTS</a></li>
		<?php }if(!$obj->sys){?>
		<li><a href="#tabs-4" data-toggle="tab">QUALIFICATIONS</a></li>
		<?php }if(!$obj->sys){?>
		<li><a href="#tabs-5" data-toggle="tab">CONTRACTS</a></li>
		<?php }if(!$obj->sys){?>
		<li><a href="#tabs-6" data-toggle="tab">INSURANCES</a></li>
		<?php } if($obj->sys){?>
		<li><a href="#tabs-7" data-toggle="tab">ALLOWANCES</a></li>
		<?php } if($obj->sys){?>
		<li><a href="#tabs-8" data-toggle="tab">DEDUCTIONS</a></li>
		<?php } if($obj->sys){?>
		<li><a href="#tabs-9" data-toggle="tab">SURCHARGES</a></li>
		<?php } if($obj->sys){?>
		<li><a href="#tabs-10" data-toggle="tab">LOANS</a></li>
		<?php }if(!$obj->sys){?>
		<li><a href="#tabs-11" data-toggle="tab">DISCIPLINARIES</a></li>
		<?php }?>
	</ul>
	</div>
                <div class="panel-body">
                    <div class="tab-content">
<div id="tabs-1" class="tab-pane active">
      <form action="addemployees_proc.php"  name="employees" method="POST" enctype="multipart/form-data">
<table style="margin-left:240px;" width="60%" class="titems gridd" border="0" align="center" cellpadding="2" cellspacing="0" id="tblSample">

	<tr>
		<td colspan="2"><input type="hidden" name="id" id="id" value="<?php echo $obj->id; ?>">
						<input type="hidden" name="sys" id="sys" value="<?php echo $obj->sys; ?>">
                        <span class="required_notification">* Denotes Required Field</span>
                        </td>
	</tr>
	<tr>
		<td align="right">Employment Type : </td>
		<td><input type="radio" name="type" id="type" value="1" <?php if($obj->type==1){echo"checked";}?>/>Permanent<br/>
		    <input type="radio" name="type" id="type" value="2" <?php if($obj->type==2){echo"checked";}?>/>Casual<br/>
		    <input type="radio" name="type" id="type" value="3" <?php if($obj->type==3){echo"checked";}?>/>Weekend Casual<br/></td>
	</tr>
	<tr>
		<td align="right">PF Number : </td>
		<td><input type="text" name="pfnum" id="pfnum" value="<?php echo $obj->pfnum; ?>"></td>
	</tr>
	<tr>
		<td align="right">First Name : </td>
		<td><input type="text" name="firstname" id="firstname" value="<?php echo $obj->firstname; ?>"><font color='red'>*</font></td>
	</tr>
	<tr>
		<td align="right">Middle Name : </td>
		<td><input type="text" name="middlename" id="middlename" value="<?php echo $obj->middlename; ?>"></font></td>
	</tr>
	<tr>
		<td align="right">Last Name : </td>
		<td><input type="text" name="lastname" id="lastname" value="<?php echo $obj->lastname; ?>"><font color='red'>*</font></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Gender : </td>
		<td><select name='gender' class="selectbox">
			<option value='Male' <?php if($obj->gender=='Male'){echo"selected";}?>>Male</option>
			<option value='Female' <?php if($obj->gender=='Female'){echo"selected";}?>>Female</option>
		</select></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Supervisor : </td>
		<td><input type="text" name="supervisorid" id="supervisorid" value="<?php echo $obj->supervisorid; ?>"></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Start Date : </td>
		<td><input type="text" name="startdate" id="startdate" class="date_input" size="12" readonly  value="<?php echo $obj->startdate; ?>"></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">End Date : </td>
		<td><input type="text" name="enddate" id="enddate" class="date_input" size="12" readonly  value="<?php echo $obj->enddate; ?>"></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">DoB : </td>
		<td><input type="text" name="dob" id="dob" class="date_input" size="12" readonly  value="<?php echo $obj->dob; ?>"></td>
	</tr>
	<tr>
		<td align="right">ID No : </td>
		<td><input type="text" name="idno" id="idno" value="<?php echo $obj->idno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Passport No. : </td>
		<td><input type="text" name="passportno" id="passportno" value="<?php echo $obj->passportno; ?>"></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Phone No. : </td>
		<td><input type="text" name="phoneno" id="phoneno" value="<?php echo $obj->phoneno; ?>"></td>
	</tr>
	<tr >
		<td align="right">Office E-mail : </td>
		<td><input type="text" name="officemail" id="officemail" value="<?php echo $obj->officemail; ?>"></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">E-mail : </td>
		<td><input type="text" name="email" id="email" value="<?php echo $obj->email; ?>"></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Physical Address : </td>
		<td><textarea name="physicaladdress"><?php echo $obj->physicaladdress; ?></textarea></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Nationality : </td>
			<td><select name="nationalityid" class="selectbox">
<option value="">Select...</option>
<?php
	$nationalitys=new Nationalitys();
	$where="  ";
	$fields="hrm_nationalitys.id, hrm_nationalitys.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$nationalitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	if(empty($obj->nationalityid))
		$obj->nationalityid=93;
	
	while($rw=mysql_fetch_object($nationalitys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->nationalityid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Home County : </td>
			<td><select name="countyid" class="selectbox">
<option value="">Select...</option>
<?php
	$countys=new Countys();
	$where="  ";
	$fields="hrm_countys.id, hrm_countys.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$countys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($countys->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->countyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Marital Status : </td>
		<td><select name='marital' class="selectbox" onchange="loadM(this);">
			<option value='' <?php if($obj->marital==''){echo"selected";}?>></option>
			<option value='Yes' <?php if($obj->marital=='Yes'){echo"selected";}?>>Married</option>
			<option value='No' <?php if($obj->marital=='No'){echo"selected";}?>>Single</option>
	</tr>
	
	<tr id="m1">
		<td>&nbsp;</td>
		<td align="right"></select> Spouse: <input type="text" name="spouse" id="spouse" value="<?php echo $obj->spouse; ?>"></td>
	</tr>
	
	<tr id="m2">
		<td>&nbsp;</td>
		<td align="right">Spouse ID No : <input type="text" name="spouseidno" id="spouseidno" value="<?php echo $obj->spouseidno; ?>"></td>
	</tr>
	
	<tr id="m3">
		<td>&nbsp;</td>
		<td align="right">Spouse Tel : <input type="text" name="spousetel" id="spousetel" value="<?php echo $obj->spousetel; ?>"></td>
	</tr>
	
	<tr id="m4">
		<td>&nbsp;</td>
		<td align="right">Spouse Email : <input type="text" name="spouseemail" id="spouseemail" value="<?php echo $obj->spouseemail; ?>"></td>
	</tr>
	<tr>
		<td align="right">NSSF No : </td>
		<td><input type="text" name="nssfno" id="nssfno" value="<?php echo $obj->nssfno; ?>"></td>
	</tr>
	<tr>
		<td align="right">NHIF No : </td>
		<td><input type="text" name="nhifno" id="nhifno" value="<?php echo $obj->nhifno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Pin No : </td>
		<td><input type="text" name="pinno" id="pinno" value="<?php echo $obj->pinno; ?>"></td>
	</tr>
	<tr>
		<td align="right">University No(HELB) : </td>
		<td><input type="text" name="helbno" id="helbno" value="<?php echo $obj->helbno; ?>"></td>
	</tr>
	<tr>
		<td align="right">Employee Bank : </td>
			<td><select name="employeebankid" class="selectbox">
<option value=NULL>Select...</option>
<?php
	$banks=new Employeebanks();
	$where="  ";
	$fields="hrm_employeebanks.id, hrm_employeebanks.code, hrm_employeebanks.name, hrm_employeebanks.remarks, hrm_employeebanks.createdby, hrm_employeebanks.createdon, hrm_employeebanks.lasteditedby, hrm_employeebanks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($banks->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->employeebankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Bank Branch : </td>
			<td><select name="bankbrancheid" class="selectbox">
<option value=NULL>Select...</option>
<?php
	$bankbranches=new Bankbranches();
	$where="  ";
	$fields="hrm_bankbranches.id, hrm_bankbranches.name, hrm_bankbranches.employeebankid, hrm_bankbranches.remarks, hrm_bankbranches.createdby, hrm_bankbranches.createdon, hrm_bankbranches.lasteditedby, hrm_bankbranches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$bankbranches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($bankbranches->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->bankbrancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select>
		</td>
	</tr>
	<tr>
		<td align="right">Bank Acc. : </td>
		<td><input type="text" name="bankacc" id="bankacc" value="<?php echo $obj->bankacc; ?>"></td>
	</tr>
	<tr <?php if(!$obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Clearing Code : </td>
		<td><input type="text" name="clearingcode" id="clearingcode" value="<?php echo $obj->clearingcode; ?>"></td>
	</tr>
	<tr <?php if(!$obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Reference : </td>
		<td><input type="text" name="ref" id="ref" value="<?php echo $obj->ref; ?>"></td>
	</tr>
	<tr <?php if(!$obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Basic Pay : </td>
		<td><input type="text" name="basic" id="basic" size="8"  value="<?php echo $obj->basic; ?>"></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Job Position : </td>
			<td><select name="assignmentid" class="selectbox">
<option value="">Select...</option>
<?php
$assignments=new Assignments();
$where="";
$fields="hrm_assignments.id, hrm_assignments.code, hrm_assignments.name, hrm_assignments.departmentid, hrm_assignments.remarks, hrm_assignments.createdby, hrm_assignments.createdon, hrm_assignments.lasteditedby, hrm_assignments.lasteditedon";
$join="";
$having="";
$groupby="";
$orderby=" order by name  asc ";
$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
while($rw=mysql_fetch_object($assignments->result)){
?>
<option value="<?php echo $rw->id; ?>" <?php if($obj->assignmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
<?php
}
?>
</select><font size="1px" color='red'>* (Shows un assigned jobs only)</font>
</td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Grade : </td>
		<td><select name="gradeid" class="selectbox">
<option value="">Select...</option>
<?php
	$grades=new Grades();
	$where="  ";
	$fields="hrm_grades.id, hrm_grades.name, hrm_grades.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$grades->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($grades->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->gradeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select></td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Status : </td>
			<td><select name="statusid" class="selectbox">
<option value="">Select...</option>
<?php
	$employeestatuss=new Employeestatuss();
	$where="  ";
	$fields="hrm_employeestatuss.id, hrm_employeestatuss.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeestatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

	while($rw=mysql_fetch_object($employeestatuss->result)){
	?>
		<option value="<?php echo $rw->id; ?>" <?php if($obj->statusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
	<?php
	}
	?>
</select><font color='red'><?php $obj->oldimage=$obj->image; ?><input type="hidden" name="oldimage" value="<?php echo $obj->oldimage; ?>"/>*</font>
		</td>
	</tr>
	<tr <?php if($obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Passport Photo : </td>
		<td><?php if(!empty($obj->image)){?><img src="photos/<?php echo $obj->image; ?>" width="100" height="100"/><?php }?><input type="file" name="image" id="image" value="<?php echo $obj->image; ?>"></td>
	</tr>
	<tr <?php if(!$obj->sys){?>style="visibility: hidden; display: none;"<?php }?>>
		<td align="right">Passport Photo : </td>
		<td><input type="hidden" name="image" value="<?php echo $obj->image; ?>"/><?php if(!empty($obj->image)){?><img src="photos/<?php echo $obj->image; ?>" width="100" height="100"/><?php }?></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input class="btn" type="submit" name="action" id="action" value="<?php echo $obj->action; ?>"/>&nbsp;<input class="btn" type="submit" name="action" id="action" value="Cancel" onclick="window.top.hidePopWin(true);"/>
		<?php if($obj->action=="Update"){?>
		<input class="btn" type="submit" name="action" id="action" value="New Employee"/>
		<?php }?>
		</td>
	</tr>
  
<?php if(!empty($obj->id)){?>
 </table>
 <form>
 </div><!-- tab#1End -->

 <?php }?>
	<?php if(!empty($obj->id)){?> 
	<?php if($obj->sys){?>
	<div class="clearb"></div>

    <div class="tab-pane" id="tabs-7" style="min-height:400px;">
    <form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
      
		<table align='left'>
        
        <!--<tr><td colspan="2">
        <span class="required_notification">* Denotes Required Field</span>
        </td></tr>-->
			<tr>
				<td align="right">Allowance :</td><td>
				<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
				<select name='employeeallowancesallowanceid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$allowances=new Allowances();
				$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowances.allowancetypeid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($allowances->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->allowanceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
              </tr>
              <tr>
              	<td align="right">Allowance Type:</td>
              	<td>
              	<select name='employeeallowancesallowancetypeid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$allowancetypes=new Allowancetypes();
				$fields="hrm_allowancetypes.id, hrm_allowancetypes.name, hrm_allowancetypes.repeatafter, hrm_allowancetypes.remarks, hrm_allowancetypes.createdby, hrm_allowancetypes.createdon, hrm_allowancetypes.lasteditedby, hrm_allowancetypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$allowancetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($allowancetypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->allowancetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
					</td>
              </tr>
              <tr>
				<td align="right">Amount:</td><td> <input type="text" name="employeeallowancesamount"></td>
                 </tr>
                 
                 <tr>
                 	<td align="right">From:</td>
                 	<td>
                 	<select name="employeeallowancesfrommonth" id=employeeallowancesfrommonth class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->employeeallowancesfrommonth==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->employeeallowancesfrommonth==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->employeeallowancesfrommonth==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->employeeallowancesfrommonth==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->employeeallowancesfrommonth==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->employeeallowancesfrommonth==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->employeeallowancesfrommonth==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->employeeallowancesfrommonth==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->employeeallowancesfrommonth==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->employeeallowancesfrommonth==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->employeeallowancesfrommonth==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->employeeallowancesfrommonth==12){echo"selected";}?>>December</option>
      </select>
      &nbsp;
     <select name="employeeallowancesfromyear" id="employeeallowancesfromyear" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->employeeallowancesfromyear==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select>
                 	</td>
                 </tr>
                 
                 <tr>
                 	<td align="right">To:</td>
                 	<td>
                 	<select name="employeeallowancestomonth" id="employeeallowancestomonth" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->employeeallowancestomonth==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->employeeallowancestomonth==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->employeeallowancestomonth==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->employeeallowancestomonth==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->employeeallowancestomonth==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->employeeallowancestomonth==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->employeeallowancestomonth==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->employeeallowancestomonth==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->employeeallowancestomonth==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->employeeallowancestomonth==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->employeeallowancestomonth==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->employeeallowancestomonth==12){echo"selected";}?>>December</option>
      </select>
      &nbsp;
      <select name="employeeallowancestoyear" id="employeeallowancestoyear" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->employeeallowancestoyear==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select>
                 	</td>
                 </tr>
                 
              <tr>
				<td align="right">Remarks:</td><td> <textarea name="employeeallowancesremarks"><?php echo $obj->employeeallowancesremarks; ?></textarea></td>
                  </tr>
              <tr>
				<td colspan="2" align="center"><input type="submit" class="btn" value="Add Employeeallowance" name="action"></td>
			</tr>
<?php
		$employeeallowances=new Employeeallowances();
		$i=0;
		$fields="hrm_employeeallowances.id, hrm_allowances.name as allowanceid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_allowancetypes.name type, hrm_employeeallowances.amount, hrm_employeeallowances.frommonth, hrm_employeeallowances.fromyear, hrm_employeeallowances.tomonth, hrm_employeeallowances.toyear, hrm_employeeallowances.remarks, hrm_employeeallowances.createdby, hrm_employeeallowances.createdon, hrm_employeeallowances.lasteditedby, hrm_employeeallowances.lasteditedon";
		$join=" left join hrm_allowances on hrm_employeeallowances.allowanceid=hrm_allowances.id  left join hrm_employees on hrm_employeeallowances.employeeid=hrm_employees.id left join hrm_allowancetypes on hrm_allowancetypes.id=hrm_employeeallowances.allowancetypeid";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeeallowances.employeeid='$obj->id'";
		$employeeallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$employeeallowances->affectedRows;
		$res=$employeeallowances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->allowanceid; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo getMonth($row->frommonth); ?>&nbsp;<?php echo $row->fromyear; ?></td>
				<td><?php echo getMonth($row->tomonth); ?>&nbsp;<?php echo $row->toyear; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->type; ?></td>
				<td><a href='addemployees_proc.php?id=<?php echo $obj->id; ?>&employeeallowances=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</table>

		</form>
		</div>

	<?php }?>
	<?php if(!$obj->sys){?>


    <div class="tab-pane" id="tabs-2"  style="margin-left:240px;min-height:400px;" width="60%">
      
      <form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
		<table align='left' style="margin-bottom:50px;">
			<tr>
				<td align="right">Dependant :</td><td> 
				<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
				<input type="text" name="employeedependantsname" size="25" ></td></tr>
				
				
				<tr>
                                    <td align="right">DoB :</td>
                                    <td> <input type="text" name="employeedependantsdob" size="8" class="date_input"></td>
				</tr>
				
				<tr>
                                    <td align="right">Relationship :</td>
                                    <td> <input type="text" name="employeedependantsrelationship"></td>
				</tr>
				
				<tr>
                                    <td align="right">Email :</td>
                                    <td> <input type="text" name="employeedependantsemail"></td>
				</tr>
				
				<tr>
                                    <td align="right">Mobile :</td>
                                    <td> <input type="text" name="employeedependantsmobile"></td>
				</tr>
				
				
				<tr>
				<td colspan="2" align="center"><input type="submit" class="btn" value="Add Employeedependant" name="action"></td>
			</tr>
		</table>
	</form>		
			<table class="table table-codensed">
<?php
		$employeedependants=new Employeedependants();
		$i=0;
		$fields="hrm_employeedependants.id, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_employeedependants.name, hrm_employeedependants.dob";
		$join=" left join hrm_employees on hrm_employeedependants.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeedependants.employeeid='$obj->id'";
		$employeedependants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$employeedependants->affectedRows;
		$res=$employeedependants->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->name; ?></td>
				<td><?php echo formatDate($row->dob); ?></td>
				<td><a href='addemployees_proc.php?id=<?php echo $obj->id; ?>&employeedependants=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		

		<?php
		}
?>
</table>
		
		<div class="clearb"></div>
		</div>
		
	<?php }?>		
		
	<?php if(!$obj->sys){?>

    <div class="tab-pane" id="tabs-3" style="min-height:400px;">
      
      <form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
		<table align='left' width="60%" style="margin-bottom:50px;margin-left:200px;">
        <!--<tr><td colspan="5">
        <span class="required_notification">* Denotes Required Field</span>
        </td></tr>-->
			<tr>
				<td align="right">Document :</td><td>
				<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
				<select name='employeedocumentsdocumentid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$documenttypes=new Documenttypes();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where=" where moduleid=2 ";
				$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($documenttypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->documentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
               </tr>
               <tr>
				<td align="right">Browse Document :</td><td> <input type="file" name="employeedocumentsfile" size="20" ></td>
                 </tr>
               <tr>
				<td align="right">Remarks :</td><td> <textarea name="employeedocumentsremarks"><?php echo $obj->employeedocumentsremarks; ?></textarea></td>
                 </tr>
               <tr>
				<td colspan="5" align="center"><input type="submit" class="btn" value="Add Employeedocument" name="action"></td>
			</tr>
			</table>
			</form>
			<table class="table">
		<?php
			$employeedocuments=new Employeedocuments();
		$i=0;
		$fields="hrm_employeedocuments.id, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, dms_documenttypes.name as documentid, hrm_employeedocuments.file, hrm_employeedocuments.remarks";
		$join=" left join hrm_employees on hrm_employeedocuments.employeeid=hrm_employees.id  left join dms_documenttypes on hrm_employeedocuments.documenttypeid=dms_documenttypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeedocuments.employeeid='$obj->id'";
		$employeedocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $employeedocuments->sql;
		$num=$employeedocuments->affectedRows;
		$res=$employeedocuments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->documentid; ?></td>
				<td><a href="files/<?php echo $row->file; ?>"><?php echo $row->file; ?></a></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addemployees_proc.php?id=<?php echo $obj->id; ?>&employeedocuments=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
<div class="clearb"></div>

		<?php
		}
?>
</table>
	</form>
	</div><!-- tab#3 -->
	<?php }?>
					
						

	<?php if(!$obj->sys){?>
<div class="tab-pane" id="tabs-4" style="min-height:400px;" >
<form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
		<table align='left' style="margin:50px 250px;">
        <tr>
        <td colspan="6"></td>
        </tr>
			<tr>
				
				<td align="right">Qualification :</td><td> 
				<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
				<select name='employeequalificationsqualificationid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$qualifications=new Qualifications();
				$fields="hrm_qualifications.id, hrm_qualifications.name, hrm_qualifications.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$qualifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($qualifications->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->employeequalificationsqualificationid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr><tr>
				<td align="right">Title :</td><td> <input type="text" name="employeequalificationstitle" size="25" value="<?php echo $obj->employeequalificationstitle; ?>" ></td></tr><tr>
				<td align="right">Institution : </td><td><textarea name="employeequalificationsinstitution"><?php echo $obj->employeequalificationsinstitution; ?></textarea></td></tr><tr>
				<td align="right">Grade :</td><td> <select name='employeequalificationsgradingid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$gradings=new Gradings();
				$fields="hrm_gradings.id, hrm_gradings.name, hrm_gradings.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$gradings->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($gradings->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->employeequalificationsgradingid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr><tr>
				<td align="right">Remarks :</td><td> <textarea name="employeequalificationsremarks"><?php echo $obj->employeequalificationsremarks; ?></textarea></td></tr><tr>
				<td colspan="2" align="center"><input type="submit" class="btn" value="Add Employeequalification" name="action"></td>
			</tr>

			</table>
</form>
			<table id="table" class="table">
			<thead>
				<th>#</th>
				<th>Qualification</th>
				<th>Title</th>
				<th>Institution</th>
				<th>Grade</th>
				<th>Remarks</th>
				<th></th>
			</thead>		
<?php
		$employeequalifications=new Employeequalifications();
		$i=0;
		$fields="hrm_employeequalifications.id, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_qualifications.name as qualificationid, hrm_employeequalifications.title, hrm_employeequalifications.institution, hrm_gradings.name as gradingid, hrm_employeequalifications.remarks, hrm_employeequalifications.createdby, hrm_employeequalifications.createdon, hrm_employeequalifications.lasteditedby, hrm_employeequalifications.lasteditedon";
		$join=" left join hrm_employees on hrm_employeequalifications.employeeid=hrm_employees.id  left join hrm_qualifications on hrm_employeequalifications.qualificationid=hrm_qualifications.id  left join hrm_gradings on hrm_employeequalifications.gradingid=hrm_gradings.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeequalifications.employeeid='$obj->id'";
		$employeequalifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$employeequalifications->affectedRows;
		$res=$employeequalifications->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->qualificationid; ?></td>
				<td><?php echo $row->title; ?></td>
				<td><?php echo $row->institution; ?></td>
				<td><?php echo $row->gradingid; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addemployees_proc.php?id=<?php echo $obj->id; ?>&employeequalifications=<?php echo $row->id; ?>'>Del</a></td>
			</tr> 
		<?php
		}
?>
     </table>
  

<div class="clearb"></div>
		</div><!-- tab#4 -->
	<?php }?>
	<?php if(!$obj->sys){?>
<div class="tab-pane" id="tabs-5" style="min-height:400px;">
<form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
		<table align='left' width="60%" style="margin:50px 120px;">
        <tr><td colspan="5"></td></tr>
			<tr>
				<td align="right">Contract Type :</td><td> 
				<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
				<select name='employeecontractscontracttypeid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$contracttypes=new Contracttypes();
				$fields=" * ";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$contracttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($contracttypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->contracttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr><tr>
				<td align="right">Start Date :</td><td> <input type="text" name="employeecontractsstartdate" size="8" class="date_input"></td></tr><tr>
				<td align="right">Confirmation Date :</td><td> <input type="text" name="employeecontractsconfirmationdate" size="8" class="date_input"></td></tr><tr>
				<td align="right">Probation (Months) :</td><td> <input type="text" name="employeecontractsprobation" size="4" ></td>
                </tr>
                <tr>
				<td align="right">Contract Period (Months) :</td><td> <input type="text" name="employeecontractscontractperiod" size="4" ></td></tr><tr>
				<td align="right">Status :</td><td> <select name='status' class="selectbox">
					<option value='Active' <?php if($obj->status=='Active'){echo"selected";}?>>Active</option>
					<option value='Suspended' <?php if($obj->status=='Suspended'){echo"selected";}?>>Suspended</option>
					<option value='Terminated' <?php if($obj->status=='Terminated'){echo"selected";}?>>Terminated</option>
					</select></td></tr><tr>
				<td align="right">Remarks : </td><td><textarea name="employeecontractsremarks"><?php echo $obj->employeecontractsremarks; ?></textarea></td>
        	</tr>
<tr>
				<td colspan="2" align="center"><input type="submit" class="btn" value="Add Employeecontract" name="action"></td>
			</tr>
				</table>
</form>
            <table class="table" style="margin-top:20px;">
            
            	<thead>
				<th>#</th>
				<th>Contract</th>
				<th>Start Date</th>
				<th>Confirmation Date</th>
				<th>Probation</th>
				<th>Contract Period</th>
				<th>Status</th>
				<th>Remarks</th>
				<th></th>
			</thead>
<?php
		$employeecontracts=new Employeecontracts();
		$i=0;
		$fields="hrm_employeecontracts.id, hrm_contracttypes.name as contracttypeid, hrm_employeecontracts.startdate, hrm_employeecontracts.confirmationdate, hrm_employeecontracts.probation, hrm_employeecontracts.contractperiod, hrm_employeecontracts.status, hrm_employeecontracts.remarks, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid";
		$join=" left join hrm_contracttypes on hrm_employeecontracts.contracttypeid=hrm_contracttypes.id  left join hrm_employees on hrm_employeecontracts.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeecontracts.employeeid='$obj->id'";
		$employeecontracts->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
		$num=$employeecontracts->affectedRows;
		$res=$employeecontracts->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->contracttypeid; ?></td>
				<td><?php echo formatDate($row->startdate); ?></td>
				<td><?php echo formatDate($row->confirmationdate); ?></td>
				<td><?php echo $row->probation; ?></td>
				<td><?php echo $row->contractperiod; ?></td>
				<td><?php echo $row->status; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addemployees_proc.php?id=<?php echo $obj->id; ?>&employeescontracts=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
			
		<?php
		}
?>
	</table>

<div class="clearb"></div>
		</div><!-- tab#5End -->
	<?php }?>
	<?php if(!$obj->sys){?>
	<div class="clearb"></div>
<div class="tab-pane" id="tabs-6" style="min-height:500px;">
<form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
		<table align='left' style="margin:50px 250px;">
        <tr><td colspan="7"></td></tr>
			<tr>
				
				<td align="right">Insurance :</td><td> 
			<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>	
				<select name='employeeinsurancesinsuranceid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$insurances=new Insurances();
				$fields="hrm_insurances.id, hrm_insurances.name, hrm_insurances.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$insurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($insurances->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->insuranceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr><tr>
				<td align="right">Premium Paid :</td><td> <input type="text" name="employeeinsurancespremium" size="12" ></td></tr><tr>
				<td align="right">Premium Relief (%) :</td><td> <input type="text" name="employeeinsurancesrelief" size="12" ></td></tr><tr>
				<td align="right">Start Date :</td><td> <input type="text" name="employeeinsurancesstartdate" size="8" class="date_input"></td></tr><tr>
				<td align="right">Expected End Date :</td><td> <input type="text" name="employeeinsurancesexpectedenddate" size="8" class="date_input"></td></tr><tr>
				<td align="right">Remarks :</td><td> <textarea name="employeeinsurancesremarks"><?php echo $obj->employeeinsurancesremarks; ?></textarea></td></tr><tr>
				<td align="center" colspan="2"><input type="submit" class="btn" value="Add Employeeinsurance" name="action"></td>
			</tr>
			</table>

</form>
		<table class="table">
            
            	<thead>
				<th>#</th>
				<th>Insurance</th>
				<th>Premium</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Remarks</th>
				<th></th>
			</thead>
<?php
		$employeeinsurances=new Employeeinsurances();
		$i=0;
		$fields="hrm_employeeinsurances.id, hrm_employeeinsurances.employeeid, hrm_insurances.name as insuranceid, hrm_employeeinsurances.premium, hrm_employeeinsurances.startdate, hrm_employeeinsurances.expectedenddate, hrm_employeeinsurances.remarks";
		$join=" left join hrm_insurances on hrm_employeeinsurances.insuranceid=hrm_insurances.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeeinsurances.employeeid='$obj->id'";
		$employeeinsurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$employeeinsurances->affectedRows;
		$res=$employeeinsurances->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->insuranceid; ?></td>
				<td><?php echo $row->premium; ?></td>
				<td><?php echo formatDate($row->startdate); ?></td>
				<td><?php echo formatDate($row->expectedenddate); ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addemployees_proc.php?id=<?php echo $obj->id; ?>&employeeinsurances=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
			
		<?php
		}
?>
			</tr>
			           
</table>
		</div>
	<?php }?>
	<?php if($obj->sys){?>
	<div class="clearb"></div>
<div class="tab-pane" id="tabs-8" style="min-height:400px;">
<form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
		<table align='left' style="margin-left:320px;" width="50%">
          <tr><td colspan="2">
        <span class="required_notification">* Denotes Required Field</span>
        </td></tr>
			<tr>
				<td align="right">Deduction :</td><td> 
				<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
				<select name='employeedeductionsdeductionid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$deductions=new Deductions();
				$fields="hrm_deductions.id, hrm_deductions.name, hrm_deductions.deductiontypeid, hrm_deductions.frommonth, hrm_deductions.fromyear, hrm_deductions.tomonth, hrm_deductions.toyear, hrm_deductions.amount, hrm_deductions.overall, hrm_deductions.status, hrm_deductions.createdby, hrm_deductions.createdon, hrm_deductions.lasteditedby, hrm_deductions.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($deductions->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->employeedeductionsdeductionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td>
                </tr>
                <tr>
				<td align="right">Amount :</td><td> <input type="text" name="employeedeductionsamount"></td>
                </tr>
                <tr>
				<td align="right">Deduction Type :</td><td>
				<select name='employeedeductionsdeductiontypeid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$deductiontypes=new Deductiontypes();
				$fields="hrm_deductiontypes.id, hrm_deductiontypes.name, hrm_deductiontypes.repeatafter, hrm_deductiontypes.remarks, hrm_deductiontypes.createdby, hrm_deductiontypes.createdon, hrm_deductiontypes.lasteditedby, hrm_deductiontypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$deductiontypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($deductiontypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->employeedeductionsdeductiontypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
				</td>
                     </tr>
                <tr>
                 	<td align="right">From:</td>
                 	<td>
                 	<select name="employeedeductionsfrommonth" id="employeedeductionsfrommonth" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->employeedeductionsfrommonth==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->employeedeductionsfrommonth==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->employeedeductionsfrommonth==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->employeedeductionsfrommonth==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->employeedeductionsfrommonth==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->employeedeductionsfrommonth==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->employeedeductionsfrommonth==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->employeedeductionsfrommonth==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->employeedeductionsfrommonth==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->employeedeductionsfrommonth==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->employeedeductionsfrommonth==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->employeedeductionsfrommonth==12){echo"selected";}?>>December</option>
      </select>
      &nbsp;
     <select name="employeedeductionsfromyear" id="employeedeductionsfromyear" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->employeedeductionsfromyear==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select>
                 	</td>
                 </tr>
                 
                 <tr>
                 	<td align="right">To:</td>
                 	<td>
                 	<select name="employeedeductionstomonth" id="employeedeductionstomonth" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->employeedeductionstomonth==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->employeedeductionstomonth==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->employeedeductionstomonth==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->employeedeductionstomonth==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->employeedeductionstomonth==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->employeedeductionstomonth==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->employeedeductionstomonth==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->employeedeductionstomonth==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->employeedeductionstomonth==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->employeedeductionstomonth==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->employeedeductionstomonth==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->employeedeductionstomonth==12){echo"selected";}?>>December</option>
      </select>
      &nbsp;
      <select name="employeedeductionstoyear" id="employeedeductionstoyear" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->employeedeductionstoyear==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select>
                 	</td>
                 </tr>
                  <tr>
				<td align="right">Remarks:</td><td> <textarea name="employeedeductionsremarks"><?php echo $obj->employeedeductionsremarks; ?></textarea></td>
                  </tr>
                <tr>
                <td colspan="2" align="center"><input type="submit" class="btn" value="Add Employeededuction" name="action"></td>
			</tr>
			</table><br/>
			<table class="display table table-striped table-condensed" id="" >
			<thead>
			  <tr>
			    <th>#</th>
			    <th>Name</th>
			    <th>Amount</th>
			    <th>Type</th>
			    <th>From</th>
			    <th>To</th>
			    <th>&nbsp;</th>
			  </tr>
			</thead>
			<tbody>
<?php
		$employeedeductions=new Employeedeductions();
		$i=0;
		$fields="hrm_employeedeductions.id, hrm_deductions.name deductionid, hrm_employeedeductions.amount, hrm_deductiontypes.name type, hrm_employeedeductions.frommonth, hrm_employeedeductions.fromyear, hrm_employeedeductions.tomonth, hrm_employeedeductions.toyear, hrm_employeedeductions.employeeid, hrm_employeedeductions.createdby, hrm_employeedeductions.createdon, hrm_employeedeductions.lasteditedby, hrm_employeedeductions.lasteditedon";
		$join=" left join hrm_deductiontypes on  hrm_deductiontypes.id=hrm_employeedeductions.deductiontypeid left join hrm_deductions on hrm_deductions.id=hrm_employeedeductions.deductionid";
		$having="";
		$groupby="";
		$orderby=" order by id desc ";
		$where=" where hrm_employeedeductions.employeeid='$obj->id'";
		$employeedeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$employeedeductions->affectedRows;
		$res=$employeedeductions->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->deductionid; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->type; ?></td>
				<td><?php echo getMonth($row->frommonth); ?>&nbsp;<?php echo $row->fromyear; ?></td>
				<td><?php echo getMonth($row->tomonth); ?>&nbsp;<?php echo $row->toyear; ?></td>
				<td><a href='addemployees_proc.php?id=<?php echo $obj->id; ?>&employeedeductions=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
		</tbody>
		</table>
</form>
		</div>
	<?php }?>
	
	<?php if($obj->sys){?>
<div class="tab-pane" id="tabs-9" style="min-height:400px;">
<form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
		<table align='left' width="50%" style="margin:50px 120px;">
         <!-- <tr><td colspan="2">
        <span class="required_notification">* Denotes Required Field</span>
        </td></tr>-->
<!--     <tr>  
	<th colspan='2'>Employeesurchages </th>
	</tr>-->
	<tr>
				
				<td align="right">Surcharge :</td><td>
				<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
				<select name='employeesurchagessurchageid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$surchages=new Surchages();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($surchages->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->surchageid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr><tr>
				<td align="right">Surcharge Type :</td><td> <select name='employeesurchagessurchagetypeid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$surchagetypes=new Surchagetypes();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$surchagetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($surchagetypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->employeesurchagessurchagetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr><tr>
				<td align="right">Amount : </td><td><input type="text" name="employeesurchagesamount" size="10" ></td></tr><tr>
				<td align="right">Charged On :</td><td> <input type="text" name="employeesurchageschargedon" size="8" class="date_input"></td></tr><tr>
				<td align="right">From Month : </td><td>
					<select name="employeesurchagesfrommonth" class="selectbox">
						<option value="">Select...</option>
				        <option value="1" <?php if($obj->employeesurchagesfrommonth==1){echo"selected";}?>>January</option>
				        <option value="2" <?php if($obj->employeesurchagesfrommonth==2){echo"selected";}?>>February</option>
				        <option value="3" <?php if($obj->employeesurchagesfrommonth==3){echo"selected";}?>>March</option>
				        <option value="4" <?php if($obj->employeesurchagesfrommonth==4){echo"selected";}?>>April</option>
				        <option value="5" <?php if($obj->employeesurchagesfrommonth==5){echo"selected";}?>>May</option>
				        <option value="6" <?php if($obj->employeesurchagesfrommonth==6){echo"selected";}?>>June</option>
				        <option value="7" <?php if($obj->employeesurchagesfrommonth==7){echo"selected";}?>>July</option>
				        <option value="8" <?php if($obj->employeesurchagesfrommonth==8){echo"selected";}?>>August</option>
				        <option value="9" <?php if($obj->employeesurchagesfrommonth==9){echo"selected";}?>>September</option>
				        <option value="10" <?php if($obj->employeesurchagesfrommonth==10){echo"selected";}?>>October</option>
				        <option value="11" <?php if($obj->employeesurchagesfrommonth==11){echo"selected";}?>>November</option>
				        <option value="12" <?php if($obj->employeesurchagesfrommonth==12){echo"selected";}?>>December</option>
		       	 </select>
				
				</td></tr><tr>
				<td align="right">From Year : </td><td>
				<select name="employeesurchagesfromyear" class="selectbox">
				 <option value="">Select...</option>
			          <?php
			  $i=date("Y")-10;
			  while($i<date("Y")+10)
			  {
			  	?>
			          <option value="<?php echo $i; ?>" <?php if($obj->employeesurchagesfromyear==$i){echo"selected";}?>><?php echo $i; ?></option>
			          <?
			    $i++;
			  }
			  ?>
			        </select>
			       </td></tr><tr>
				<td align="right">To Month :</td><td>
				<select name="employeesurchagestomonth" class="selectbox">
						<option value="">Select...</option>
				        <option value="1" <?php if($obj->employeesurchagestomonth==1){echo"selected";}?>>January</option>
				        <option value="2" <?php if($obj->employeesurchagestomonth==2){echo"selected";}?>>February</option>
				        <option value="3" <?php if($obj->employeesurchagestomonth==3){echo"selected";}?>>March</option>
				        <option value="4" <?php if($obj->employeesurchagestomonth==4){echo"selected";}?>>April</option>
				        <option value="5" <?php if($obj->employeesurchagestomonth==5){echo"selected";}?>>May</option>
				        <option value="6" <?php if($obj->employeesurchagestomonth==6){echo"selected";}?>>June</option>
				        <option value="7" <?php if($obj->employeesurchagestomonth==7){echo"selected";}?>>July</option>
				        <option value="8" <?php if($obj->employeesurchagestomonth==8){echo"selected";}?>>August</option>
				        <option value="9" <?php if($obj->employeesurchagestomonth==9){echo"selected";}?>>September</option>
				        <option value="10" <?php if($obj->employeesurchagestomonth==10){echo"selected";}?>>October</option>
				        <option value="11" <?php if($obj->employeesurchagestomonth==11){echo"selected";}?>>November</option>
				        <option value="12" <?php if($obj->employeesurchagestomonth==12){echo"selected";}?>>December</option>
		       	 </select>
		       	 </td></tr><tr>
				<td align="right">To Year : </td><td>
				<select name="employeesurchagestoyear" class="selectbox">
				 <option value="">Select...</option>
			          <?php
			  $i=date("Y")-10;
			  while($i<date("Y")+10)
			  {
			  	?>
			          <option value="<?php echo $i; ?>" <?php if($obj->employeesurchagestoyear==$i){echo"selected";}?>><?php echo $i; ?></option>
			          <?
			    $i++;
			  }
			  ?>
			        </select>
				</td></tr><tr>
				<td align="right">Remarks :</td><td> <textarea name="employeesurchagesremarks"><?php echo $obj->employeesurchagesremarks; ?></textarea></td></tr><tr>
				
				<td colspan="2" align="center"><input class="btn" type="submit" value="Add Employeesurchage" name="action"></td>
			</tr>
			<tr>
			
            
            	<thead><!--
				<th>#</th>
				<th>Surcharge</th>
				<th>Amount</th>
				<th>Charged On</th>
				<th>From Month</th>
				<th>From Year</th>
				<th>To Year</td>
				<th>Remarks</th>
				<th>Surchage Type</td>-->
				
				<th></th>
			</thead>
			
<?php
		$employeesurchages=new Employeesurchages();
		$i=0;
		$fields="hrm_employeesurchages.id, hrm_surchages.name as surchageid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_surchagetypes.name as surchagetypeid, hrm_employeesurchages.amount, hrm_employeesurchages.chargedon, hrm_employeesurchages.frommonth, hrm_employeesurchages.fromyear, hrm_employeesurchages.tomonth, hrm_employeesurchages.toyear, hrm_employeesurchages.remarks, hrm_employeesurchages.createdby, hrm_employeesurchages.createdon, hrm_employeesurchages.lasteditedby, hrm_employeesurchages.lasteditedon";
		$join=" left join hrm_surchages on hrm_employeesurchages.surchageid=hrm_surchages.id  left join hrm_employees on hrm_employeesurchages.employeeid=hrm_employees.id  left join hrm_surchagetypes on hrm_employeesurchages.surchagetypeid=hrm_surchagetypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeesurchages.employeeid='$obj->id'";
		$employeesurchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$employeesurchages->affectedRows;
		$res=$employeesurchages->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->surchageid; ?></td>
				<td><?php echo $row->amount; ?></td>
				<td><?php echo $row->chargedon; ?></td>
				<td><?php echo $row->frommonth; ?></td>
				<td><?php echo $row->fromyear; ?></td>
				<td><?php echo $row->tomonth; ?></td>
				<td><?php echo $row->toyear; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><?php echo $row->surchagetypeid; ?></td>
				<td><a href='addemployees_proc.php?id=<?php echo $obj->id; ?>&employeesurchages=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
</table>
</tr>
		</table>
		<div style="clear: both;"></div>
</form>
		</div>
	<?php }?>
	<?php if($obj->sys){?>
<div class="tab-pane" id="tabs-10" style="min-height:400px;">
<form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
<table align='left' width="50%" style="margin:50px 120px;">
			<tr>
				
				<td align="right">Loan : </td><td>
				
				<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/><select name='employeeloansloanid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$loans=new Loans();
				$fields="hrm_loans.id, hrm_loans.name, hrm_loans.method, hrm_loans.description, hrm_loans.createdby, hrm_loans.createdon, hrm_loans.lasteditedby, hrm_loans.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($loans->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->loanid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr>
				
				
				
				<tr>
				<td align="right">Loan Type:
				</td><td>
				<select name='employeeloansmethod' class="selectbox">
					<option value='straight-line' <?php if($obj->employeeloansmethod=='straight-line'){echo"selected";}?>>straight-line</option>
					<option value='reducing balance' <?php if($obj->employeeloansmethod=='reducing balance'){echo"selected";}?>>reducing balance</option>
					</select></td></tr><tr>
				<td align="right">Initial Value :</td><td> <input type="text" name="employeeloansinitialvalue" size="8" ></td></tr><tr>
				
				<tr>
				
				<td align="right">Principal : </td><td><input type="text" onchange="getPayable();" name="employeeloansprincipal" id="employeeloansprincipal" size="8" ></td>
				
				</tr>
				
				<tr>
				<td align="right">Duration (Months) : </td><td>
				<input type="text" size="4" name="employeeloansduration" id="employeeloansduration" onchange="getPayable();"  value="<?php echo $obj->employeeloansduration; ?>" /></td>
				</tr>
				
				<td align="right">Payable Amount :</td><td> <input type="text" name="employeeloanspayable" id="employeeloanspayable" size="8" ></td></tr>			
				
				
				<tr>
				<td align="right">Interest Type :</td><td><select name='employeeloansinteresttype' class="selectbox">
			<option value='%' <?php if($obj->employeeloansinteresttype=='%'){echo"selected";}?>>%</option>
			<option value='Amount' <?php if($obj->employeeloansinteresttype=='Amount'){echo"selected";}?>>Amount</option>
		</select>
				</td></tr><tr>
				<td align="right">Interest :</td><td> <input type="text" name="employeeloansinterest" size="8" ></td></tr><tr>
				<td align="right">Month : </td><td>
				<select name="employeeloansmonth" class="selectbox">
						<option value="">Select...</option>
				        <option value="1" <?php if($obj->employeesurchagesfrommonth==1){echo"selected";}?>>January</option>
				        <option value="2" <?php if($obj->employeesurchagesfrommonth==2){echo"selected";}?>>February</option>
				        <option value="3" <?php if($obj->employeesurchagesfrommonth==3){echo"selected";}?>>March</option>
				        <option value="4" <?php if($obj->employeesurchagesfrommonth==4){echo"selected";}?>>April</option>
				        <option value="5" <?php if($obj->employeesurchagesfrommonth==5){echo"selected";}?>>May</option>
				        <option value="6" <?php if($obj->employeesurchagesfrommonth==6){echo"selected";}?>>June</option>
				        <option value="7" <?php if($obj->employeesurchagesfrommonth==7){echo"selected";}?>>July</option>
				        <option value="8" <?php if($obj->employeesurchagesfrommonth==8){echo"selected";}?>>August</option>
				        <option value="9" <?php if($obj->employeesurchagesfrommonth==9){echo"selected";}?>>September</option>
				        <option value="10" <?php if($obj->employeesurchagesfrommonth==10){echo"selected";}?>>October</option>
				        <option value="11" <?php if($obj->employeesurchagesfrommonth==11){echo"selected";}?>>November</option>
				        <option value="12" <?php if($obj->employeesurchagesfrommonth==12){echo"selected";}?>>December</option>
		       	 </select></td></tr><tr>
				<td align="right">Year : </td><td>
				<select name=employeeloansyear class="selectbox">
				 <option value="">Select...</option>
			          <?php
			  $i=date("Y")-10;
			  while($i<date("Y")+10)
			  {
			  	?>
			          <option value="<?php echo $i; ?>" <?php if($obj->employeeloansyear==$i){echo"selected";}?>><?php echo $i; ?></option>
			          <?
			    $i++;
			  }
			  ?>
			        </select></td></tr><tr>
				<td colspan="2" align="center"><input class="btn" type="submit" value="Add Employeeloan" name="action"></td>
			</tr>
						</table>
			<table  class="display table table-bordered table-striped " id="">
            
            	<thead>
				<th>#</th>
				<th>Loan</th>
				<th>Principal</th>
				<th>Method</th>
				<th>Initial Value </th>
				<th>Payable</th>
				<th>Duration</td>
				<th>Interest Type</th>
				<th>Interest</td>
				<th>Month</th>
				<th>Year</th>
				<th>&nbsp;</th>
			</thead>
			<tbody>
<?php
		$employeeloans=new Employeeloans();
		$i=0;
		$fields="hrm_employeeloans.id, hrm_loans.name as loanid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_employeeloans.principal, hrm_employeeloans.method, hrm_employeeloans.initialvalue, hrm_employeeloans.payable, hrm_employeeloans.duration, hrm_employeeloans.interesttype, hrm_employeeloans.interest, hrm_employeeloans.month, hrm_employeeloans.year, hrm_employeeloans.createdby, hrm_employeeloans.createdon, hrm_employeeloans.lasteditedby, hrm_employeeloans.lasteditedon, hrm_employeeloans.ipaddress";
		$join=" left join hrm_loans on hrm_employeeloans.loanid=hrm_loans.id  left join hrm_employees on hrm_employeeloans.employeeid=hrm_employees.id ";
		$having="";
		$groupby="";
		$orderby=" order by id desc ";
		$where=" where hrm_employeeloans.employeeid='$obj->id'";
		$employeeloans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$employeeloans->affectedRows;
		$res=$employeeloans->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->loanid; ?></td>
				<td align="right"><?php echo formatNumber($row->principal); ?></td>
				<td><?php echo $row->method; ?></td>
				<td align="right"><?php echo formatNumber($row->initialvalue); ?></td>
				<td align="right"><?php echo formatNumber($row->payable); ?></td>
				<td><?php echo $row->duration; ?></td>
				<td align="right"><?php echo $row->interesttype; ?></td>
				<td align="right"><?php echo formatNumber($row->interest); ?></td>
				<td><?php echo getMonth($row->month); ?></td>
				<td><?php echo $row->year; ?></td>
				<td><a href='addemployees_proc.php?id=<?php echo $obj->id; ?>&employeeloans=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
</thead>
</table>
		
</form>
</div>

<div class="tab-pane" id="tabs-12" style="min-height:400px;">
<form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
<table align='left' width="80%" style="margin:50px 120px;">
			<tr>
				
				<td align="right">Deduction : </td><td>
				
				<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/><select name='employeepaiddeductionid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$deductions=new Deductions();
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($deductions->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->employeepaiddeductionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
				&nbsp;
				Month: <select name="employeepaiddeductionmonth" class="selectbox">
						<option value="">Select...</option>
				        <option value="1" <?php if($obj->employeepaiddeductionmonth==1){echo"selected";}?>>January</option>
				        <option value="2" <?php if($obj->employeepaiddeductionmonth==2){echo"selected";}?>>February</option>
				        <option value="3" <?php if($obj->employeepaiddeductionmonth==3){echo"selected";}?>>March</option>
				        <option value="4" <?php if($obj->employeepaiddeductionmonth==4){echo"selected";}?>>April</option>
				        <option value="5" <?php if($obj->employeepaiddeductionmonth==5){echo"selected";}?>>May</option>
				        <option value="6" <?php if($obj->employeepaiddeductionmonth==6){echo"selected";}?>>June</option>
				        <option value="7" <?php if($obj->employeepaiddeductionmonth==7){echo"selected";}?>>July</option>
				        <option value="8" <?php if($obj->employeepaiddeductionmonth==8){echo"selected";}?>>August</option>
				        <option value="9" <?php if($obj->employeepaiddeductionmonth==9){echo"selected";}?>>September</option>
				        <option value="10" <?php if($obj->employeepaiddeductionmonth==10){echo"selected";}?>>October</option>
				        <option value="11" <?php if($obj->employeepaiddeductionmonth==11){echo"selected";}?>>November</option>
				        <option value="12" <?php if($obj->employeepaiddeductionmonth==12){echo"selected";}?>>December</option>
		       	 </select>
				&nbsp;
				Year: <select name=employeepaiddeductionyear class="selectbox">
				 <option value="">Select...</option>
			          <?php
			  $i=date("Y")-10;
			  while($i<date("Y")+10)
			  {
			  	?>
			          <option value="<?php echo $i; ?>" <?php if($obj->employeepaiddeductionyear==$i){echo"selected";}?>><?php echo $i; ?></option>
			          <?
			    $i++;
			  }
			  ?>
			        </select>
				&nbsp;<input class="btn" type="submit" value="Filter Deductions" name="action"></td>
			</tr>
						</table>
			<table  class="display table table-bordered table-striped " id="">
            
            	<thead>
			<tr>
				<th>#</th>
				<th>Deduction</th>
				<th>Amount</td>
				<th>Deducted On</th>
			</tr>
			</thead>
			<tbody>
<?php

		$wh="";
		if(!empty($obj->employeepaiddeductionid)){
		  $wh.=" and hrm_employeepaiddeductions.deductionid='$obj->employeepaiddeductionid' ";
		}
		if(!empty($obj->employeepaiddeductionmonth)){
		  $wh.=" and hrm_employeepaiddeductions.month='$obj->employeepaiddeductionmonth' ";
		}
		if(!empty($obj->employeepaiddeductionyear)){
		  $wh.=" and hrm_employeepaiddeductions.year='$obj->employeepaiddeductionyear' ";
		}
		
		$employeepaiddeductions=new Employeepaiddeductions();
		$i=0;
		$fields=" hrm_deductions.name deductionid, hrm_employeepaiddeductions.amount, hrm_employeepaiddeductions.month,  hrm_employeepaiddeductions.year ";
		$join=" left join hrm_deductions on hrm_employeepaiddeductions.deductionid=hrm_deductions.id ";
		$having="";
		$groupby="";
		$orderby=" order by hrm_employeepaiddeductions.id desc ";
		$where=" where hrm_employeepaiddeductions.employeeid='$obj->id' ".$wh;
		$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$employeepaiddeductions->affectedRows;
		$res=$employeepaiddeductions->result;
		$total=0;
		while($row=mysql_fetch_object($res)){
		$i++;$total+=$row->amount;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->deductionid; ?></td>
				<td align="right"><?php echo formatNumber($row->amount); ?></td>
				<td><?php echo getMonth($row->month); ?>&nbsp;<?php echo $row->year; ?></td>
			</tr>
		<?php
		}
?>
</thead>
<tfoot>
  <tr>
				<th>&nbsp;</th>
				<th>Total</th>
				<th align="right"><?php echo formatNumber($total); ?></td>
				<th>&nbsp;</th>
			</tr>
</tfoot>
</table>
		
</form>
</div>
	<?php }?>


		<?php if(!$obj->sys){?>
<div class="tab-pane" id="tabs-11" style="min-height:400px;">
<form action="addemployees_proc.php" name="employees" method="POST"  enctype="multipart/form-data">
		<table align='left' width="60%" style="margin:50px 120px;">
       <tr>
				
				<td align="right">Disciplinary Type :</td><td>
				<input type="hidden" name="employeeid" id="employeeid" value="<?php echo $obj->employeeid; ?>"/>
				<select name='employeedisplinarysdisciplinarytypeid' class="selectbox">
				<option value="">Select...</option>
				<?php
				$disciplinarytypes=new Disciplinarytypes();
				$fields="hrm_disciplinarytypes.id, hrm_disciplinarytypes.name, hrm_disciplinarytypes.remarks, hrm_disciplinarytypes.createdby, hrm_disciplinarytypes.createdon, hrm_disciplinarytypes.lasteditedby, hrm_disciplinarytypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$where="";
				$disciplinarytypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($disciplinarytypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->disciplinarytypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select></td></tr><tr>
				<td align="right">Disciplinary Date : </td><td><input type="text" name="employeedisplinarysdisciplinarydate" size="12" class="date_input"></td></tr><tr>
				<td align="right">Description :</td><td> <textarea name="employeedisplinarysdescription"><?php echo $obj->employeedisplinarysdescription; ?></textarea></td></tr><tr>
				<td align="right">Remarks :</td><td> <textarea name="employeedisplinarysremarks"><?php echo $obj->employeedisplinarysremarks; ?></textarea></td></tr><tr>
				<td align="center" colspan="2"><input type="submit" class="btn" value="Add Employeedisplinary" name="action"></td>
			</tr>
		</table>
</form>
			<table class="table table-condensed table-hover table-striped">
			<thead>
				<th>#</th>
				<th>Disciplinary</th>
				<th>Date</th>
				<th>Description</th>
				<th>Remarks</th>
				<th></th>
			</thead>
<?php
		$employeedisplinarys=new Employeedisplinarys();
		$i=0;
		$fields="hrm_employeedisplinarys.id, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid, hrm_disciplinarytypes.name as disciplinarytypeid, hrm_employeedisplinarys.disciplinarydate, hrm_employeedisplinarys.description, hrm_employeedisplinarys.remarks, hrm_employeedisplinarys.createdby, hrm_employeedisplinarys.createdon, hrm_employeedisplinarys.lasteditedby, hrm_employeedisplinarys.lasteditedon";
		$join=" left join hrm_employees on hrm_employeedisplinarys.employeeid=hrm_employees.id  left join hrm_disciplinarytypes on hrm_employeedisplinarys.disciplinarytypeid=hrm_disciplinarytypes.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where hrm_employeedisplinarys.employeeid='$obj->id'";
		$employeedisplinarys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$num=$employeedisplinarys->affectedRows;
		$res=$employeedisplinarys->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row->disciplinarytypeid; ?></td>
				<td><?php echo $row->disciplinarydate; ?></td>
				<td><?php echo $row->description; ?></td>
				<td><?php echo $row->remarks; ?></td>
				<td><a href='addemployees_proc.php?id=<?php echo $obj->id; ?>&employeedisplinarys=<?php echo $row->id; ?>'>Del</a></td>
			</tr>
		<?php
		}
?>
</table>

		</div><!-- tab#5End -->
	<?php }?>
	
<?php }?>

</form>
<?php 
if(!empty($error)){
	showError($error);
}
?>
 </div>   <!-- tcontent -->
</div>  <!--  tabbbable -->
</div>  <!--container-->

