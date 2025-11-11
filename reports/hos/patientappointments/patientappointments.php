<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hos/patientappointments/Patientappointments_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hos/patients/Patients_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/departments/Departments_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Patientappointments";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8734";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromappointmentdate=date('Y-m-d');
	$obj->toappointmentdate=date('Y-m-d');
}

$rptwhere='';
$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//processing columns to show
	if(!empty($obj->shpatientid)  or empty($obj->action)){
		array_push($sColumns, 'patientid');
		//array_push($aColumns, "hos_patients.id as patientid");
		array_push($aColumns, "concat(hos_patients.surname,' ',hos_patients.othernames) as patientid");
		$rptjoin.=" left join hos_patients on hos_patients.id=hos_patientappointments.patientid ";
		
		$k++;
	}

	if(!empty($obj->shappointmentdate)  or empty($obj->action)){
		array_push($sColumns, 'appointmentdate');
		array_push($aColumns, "hos_patientappointments.appointmentdate");
		$k++;
	}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "hrm_employees.id as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hos_patientappointments.employeeid ";
		$k++;
	}

	if(!empty($obj->shdepartmentid) ){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "hos_departments.name as departmentid");
		$rptjoin.=" left join hos_departments on hos_departments.id=hos_patientappointments.departmentid ";
		$k++;
	}

	if(!empty($obj->shbookedon)  or empty($obj->action)){
		array_push($sColumns, 'bookedon');
		array_push($aColumns, "hos_patientappointments.bookedon");
		$k++;
	}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "hos_patientappointments.remarks");
		$k++;
	}

	if(!empty($obj->shstatus) ){
		array_push($sColumns, 'status');
		array_push($aColumns, "hos_patientappointments.status");
		$k++;
	}

	if(!empty($obj->shpayconsultancy)  or empty($obj->action)){
		array_push($sColumns, 'payconsultancy');
		array_push($aColumns, "hos_patientappointments.payconsultancy");
		$k++;
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "hos_patientappointments.createdby");;
		$k++;
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hos_patientappointments.createdon");
		$k++;
	}



//processing filters
if(!empty($obj->patientid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientappointments.patientid='$obj->patientid'";
	$track++;
}

if(!empty($obj->fromappointmentdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientappointments.appointmentdate>='$obj->fromappointmentdate'";
	$track++;
}

if(!empty($obj->toappointmentdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientappointments.appointmentdate<='$obj->toappointmentdate'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientappointments.employeeid='$obj->employeeid'";
	$track++;
}

if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientappointments.departmentid='$obj->departmentid'";
	$track++;
}

if(!empty($obj->frombookedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientappointments.bookedon>='$obj->frombookedon'";
	$track++;
}

if(!empty($obj->tobookedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientappointments.bookedon<='$obj->tobookedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientappointments.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientappointments.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientappointments.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grpatientid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" patientid ";
	$obj->shpatientid=1;
	$track++;
}

if(!empty($obj->grappointmentdate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" appointmentdate ";
	$obj->shappointmentdate=1;
	$track++;
}

if(!empty($obj->gremployeeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employeeid ";
	$obj->shemployeeid=1;
	$track++;
}

if(!empty($obj->grdepartmentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" departmentid ";
	$obj->shdepartmentid=1;
	$track++;
}

if(!empty($obj->grbookedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" bookedon ";
	$obj->shbookedon=1;
	$track++;
}

if(!empty($obj->grcreatedby)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdby ";
	$obj->shcreatedby=1;
	$track++;
}

if(!empty($obj->grcreatedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdon ";
	$obj->shcreatedon=1;
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#patientname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=patients&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#patientid").val(ui.item.id);
	}
  });

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
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="hos_patientappointments";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {

 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hos_patientappointments",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
 	} );
 } );
 </script>

<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Filter</button>&nbsp;<?php if(!empty($rptgroup)){?><a class="btn btn-warning" target="_blank" href="../../graphs/graphs/bars.php">Bar Graph</a><?php } ?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter</h4>
      </div>
      <div class="modal-body">
<form  action="patientappointments.php" method="post" name="patientappointments" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Patient</td>
				<td><input type='text' size='20' name='patientname' id='patientname' value='<?php echo $obj->patientname; ?>'>
					<input type="hidden" name='patientid' id='patientid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Appointment Date</td>
				<td><strong>From:</strong><input type='text' id='fromappointmentdate' size='12' name='fromappointmentdate' readonly class="date_input" value='<?php echo $obj->fromappointmentdate;?>'/>
							<br/><strong>To:</strong><input type='text' id='toappointmentdate' size='12' name='toappointmentdate' readonly class="date_input" value='<?php echo $obj->toappointmentdate;?>'/></td>
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Department</td>
				<td>
				<select name='departmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$departments=new Departments();
				$where="  ";
				$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
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
				<td>Booked On</td>
				<td><strong>From:</strong><input type='text' id='frombookedon' size='12' name='frombookedon' readonly class="date_input" value='<?php echo $obj->frombookedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tobookedon' size='12' name='tobookedon' readonly class="date_input" value='<?php echo $obj->tobookedon;?>'/></td>
			</tr>
			<tr>
				<td>Created by</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="*";
				$where="";
				$join="   ";
				$having="";
				$groupby="";
				$orderby="";
				$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($users->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->createdby==$rw->id){echo "selected";}?>><?php echo $rw->username;?></option>
				<?php
				}
				?>
			</td>
			</tr>
			<tr>
				<td>Created on</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grpatientid' value='1' <?php if(isset($_POST['grpatientid']) ){echo"checked";}?>>&nbsp;Patient</td>
				<td><input type='checkbox' name='grappointmentdate' value='1' <?php if(isset($_POST['grappointmentdate']) ){echo"checked";}?>>&nbsp;Appointment Date</td>
			<tr>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='grdepartmentid' value='1' <?php if(isset($_POST['grdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='grbookedon' value='1' <?php if(isset($_POST['grbookedon']) ){echo"checked";}?>>&nbsp;Booked On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
				<th colspan="3"><div align="left"><strong>Fields to Show (For Detailed Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='shpatientid' value='1' <?php if(isset($_POST['shpatientid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Patient</td>
				<td><input type='checkbox' name='shappointmentdate' value='1' <?php if(isset($_POST['shappointmentdate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Appointment Date</td>
			<tr>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='shbookedon' value='1' <?php if(isset($_POST['shbookedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Booked On</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shstatus' value='1' <?php if(isset($_POST['shstatus']) ){echo"checked";}?>>&nbsp;Status</td>
				<td><input type='checkbox' name='shpayconsultancy' value='1' <?php if(isset($_POST['shpayconsultancy'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Pay Consultancy</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created on</td>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" name="action" id="action" value="Filter" /></td>
	</tr>
</table>
</form>
</div>
</div>
</div>
</div>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shpatientid==1  or empty($obj->action)){ ?>
				<th>Patient </th>
			<?php } ?>
			<?php if($obj->shappointmentdate==1  or empty($obj->action)){ ?>
				<th>Appointment Date </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Physician/Clinician </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1 ){ ?>
				<th>Department </th>
			<?php } ?>
			<?php if($obj->shbookedon==1  or empty($obj->action)){ ?>
				<th>Booked On </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shstatus==1 ){ ?>
				<th>Status </th>
			<?php } ?>
			<?php if($obj->shpayconsultancy==1  or empty($obj->action)){ ?>
				<th>Pay Consultancy </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
</div>
</div>
</div>
</div>
</div>
