<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hos/patienttreatments/Patienttreatments_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hos/patients/Patients_class.php");
require_once("../../../modules/hos/patientappointments/Patientappointments_class.php");
require_once("../../../modules/hos/diagnosis/Diagnosis_class.php");
require_once("../../../modules/hos/departments/Departments_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Patienttreatments";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8760";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromtreatedon=date('Y-m-d');
	$obj->totreatedon=date('Y-m-d');
}


$rptwhere='';
$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//Processing Groupings
$rptgroup='';
$track=0;
if(!empty($obj->grpatientid) or !empty($obj->grdiagnosiid) or !empty($obj->gradmission) or !empty($obj->grtreatedon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->grdepartmentid) or !empty($obj->grtreatment) ){
	$obj->shpatientid='';
	$obj->shpatientappointmentid='';
	$obj->shsymptoms='';
	$obj->shhpi='';
	$obj->shobs='';
	$obj->shfindings='';
	$obj->shinvestigation='';
	$obj->shdiagnosiid='';
	$obj->shdiagnosis='';
	$obj->shadmission='';
	$obj->shtreatedon='';
	$obj->shpatientstatusid='';
	$obj->shpayconsultancy='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shdepartmentid='';
	$obj->shtreatment='';
}


	$obj->sh=1;


if(!empty($obj->grpatientid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" patientid ";
	$obj->shpatientid=1;
	$track++;
}

if(!empty($obj->grdiagnosiid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" diagnosiid ";
	$obj->shdiagnosiid=1;
	$track++;
}

if(!empty($obj->gradmission)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" admission ";
	$obj->shadmission=1;
	$track++;
}

if(!empty($obj->grtreatedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" treatedon ";
	$obj->shtreatedon=1;
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

if(!empty($obj->grdepartmentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" departmentid ";
	$obj->shdepartmentid=1;
	$track++;
}

if(!empty($obj->grtreatment)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" treatment ";
	$obj->shtreatment=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shpatientid)  or empty($obj->action)){
		array_push($sColumns, 'patientid');
		array_push($aColumns, "concat(hos_patients.surname,' ',hos_patients.othernames) as patientid");
		$rptjoin.=" left join hos_patients on hos_patients.id=hos_patienttreatments.patientid ";
		$k++;
		}

	if(!empty($obj->shdepartmentid)  or empty($obj->action)){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "hos_departments.name departmentid");
		$k++;
		$join=" left join hos_patientappointments on hos_patienttreatments.patientappointmentid=hos_patientappointments.id left join hos_departments on hos_departments.id=hos_patientappointments.departmentid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
	 }
		
	if(!empty($obj->shsymptoms)  or empty($obj->action)){
		array_push($sColumns, 'symptoms');
		array_push($aColumns, "hos_patienttreatments.symptoms");
		$k++;
		}

	if(!empty($obj->shhpi)  or empty($obj->action)){
		array_push($sColumns, 'hpi');
		array_push($aColumns, "hos_patienttreatments.hpi");
		$k++;
		}

	if(!empty($obj->shobs)  or empty($obj->action)){
		array_push($sColumns, 'obs');
		array_push($aColumns, "hos_patienttreatments.obs");
		$k++;
		}

	if(!empty($obj->shfindings)  or empty($obj->action)){
		array_push($sColumns, 'findings');
		array_push($aColumns, "hos_patienttreatments.findings");
		$k++;
		}

	if(!empty($obj->shinvestigation)  or empty($obj->action)){
		array_push($sColumns, 'investigation');
		array_push($aColumns, "hos_patienttreatments.investigation");
		$k++;
		}

	if(!empty($obj->shdiagnosiid)  or empty($obj->action)){
		array_push($sColumns, 'diagnosiid');
		array_push($aColumns, "hos_diagnosis.name as diagnosiid");
		$rptjoin.=" left join hos_diagnosis on hos_diagnosis.id=hos_patienttreatments.diagnosiid ";
		$k++;
		}

	if(!empty($obj->shdiagnosis)  or empty($obj->action)){
		array_push($sColumns, 'diagnosis');
		array_push($aColumns, "hos_patienttreatments.diagnosis");
		$k++;
		}

	if(!empty($obj->shadmission) ){
		array_push($sColumns, 'admission');
		array_push($aColumns, "hos_patienttreatments.admission");
		$k++;
		}

	if(!empty($obj->shtreatedon)  or empty($obj->action)){
		array_push($sColumns, 'treatedon');
		array_push($aColumns, "hos_patienttreatments.treatedon");
		$k++;
		}

	if(!empty($obj->shpatientstatusid) ){
		array_push($sColumns, 'patientstatusid');
		array_push($aColumns, "hos_patientstatuss.name as patientstatusid");
		$rptjoin.=" left join hos_patientstatuss on hos_patientstatuss.id=hos_patienttreatments.patientstatusid ";
		$k++;
		}


	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=hos_patienttreatments.createdby ";
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hos_patienttreatments.createdon");
		$k++;
		}
		
            if(!empty($obj->shdob)  or empty($obj->action)){
		array_push($sColumns, 'dob');
		array_push($aColumns, "hos_patients.dob as dob");
		$rptjoin.=" left join hos_patients on hos_patients.id=hos_patienttreatments.patientid ";
		$k++;
		}

// 	if(!empty($obj->shtreatment)  or empty($obj->action)){
// 		array_push($sColumns, 'treatment');
// 		array_push($aColumns, "hos_patienttreatments.treatment");
// 		$k++;
// 		}



$track=0;

//processing filters
if(!empty($obj->patientid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.patientid='$obj->patientid'";
		
	$track++;
}

if(!empty($obj->patientappointmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.patientappointmentid='$obj->patientappointmentid'";
		$join=" left join hos_patientappointments on hos_patienttreatments.patientappointmentid=hos_patientappointments.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->diagnosiid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.diagnosiid='$obj->diagnosiid'";
// 		$rptjoin.=" left join hos_diagnosis on hos_diagnosis.id=hos_patienttreatments.diagnosiid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->admission)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.admission='$obj->admission'";
	$track++;
}

if(!empty($obj->fromtreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.treatedon>='$obj->fromtreatedon'";
	$track++;
}

if(!empty($obj->totreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.treatedon<='$obj->totreatedon'";
	$track++;
}

if(!empty($obj->patientstatusid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.patientstatusid='$obj->patientstatusid'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" hos_departments.id='$obj->departmentid' ";
	$join=" left join hos_departments on hos_departments.id=hos_patientappointments.departmentid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->treatment)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patienttreatments.treatment like '%$obj->treatment%'";
	$track++;
}
if(!empty($obj->dob)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patients.dob='$obj->dob'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
if(!empty($obj->shpatientid)){
	$fd.=" ,concat(hos_patients.surname,' ',hos_patients.othernames) ";
}
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#patientname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=patients&field=concat(hos_patients.surname,' ',hos_patients.othernames)",
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

  $("#patientappointmentname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=patientappointments&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#patientappointmentid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="hos_patienttreatments";?>
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
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hos_patienttreatments",
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
<button id="create-user">Filter</button>
<div id="toPopup" >
<div class="close"></div>
<span class="ecs_tooltip">Press Esc to close <span class="arrow"></span>
<div id="dialog-modal" title="Filter" style="font:tahoma;font-size:10px;">
<form  action="patienttreatmentsg.php" method="post" name="patienttreatments" >
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
				<td>Patient Appointment</td>
				<td><input type='text' size='20' name='patientappointmentname' id='patientappointmentname' value='<?php echo $obj->patientappointmentname; ?>'>
					<input type="hidden" name='patientappointmentid' id='patientappointmentid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Diagnosis</td>
				<td>
				<select name='diagnosiid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$diagnosis=new Diagnosis();
				$where="  ";
				$fields="hos_diagnosis.id, hos_diagnosis.name, hos_diagnosis.remarks, hos_diagnosis.ipaddress, hos_diagnosis.createdby, hos_diagnosis.createdon, hos_diagnosis.lasteditedby, hos_diagnosis.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$diagnosis->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($diagnosis->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->diagnosiid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Admission</td>
			</tr>
			<tr>
				<td>Treated on</td>
				<td><strong>From:</strong><input type='text' id='fromtreatedon' size='12' name='fromtreatedon' readonly class="date_input" value='<?php echo $obj->fromtreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='totreatedon' size='12' name='totreatedon' readonly class="date_input" value='<?php echo $obj->totreatedon;?>'/></td>
			</tr>
			<tr>
				<td>Patient Status</td>
				<td><input type='text' id='patientstatusid' size='20' name='patientstatusid' value='<?php echo $obj->patientstatusid;?>'></td>
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
			<tr>
				<td>Department</td>
				<td>
				<select name='departmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$departments=new Departments();
				$where=" where hos_departments.id not in (2) ";
				$fields="hos_departments.id, hos_departments.name, hos_departments.remarks";
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
				<td>Treatment</td>
				<td><input type='text' id='treatment' size='20' name='treatment' value='<?php echo $obj->treatment;?>'></td>
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
				<td><input type='checkbox' name='grdiagnosiid' value='1' <?php if(isset($_POST['grdiagnosiid']) ){echo"checked";}?>>&nbsp;Diagnosis</td>
			<tr>
				<td><input type='checkbox' name='gradmission' value='1' <?php if(isset($_POST['gradmission']) ){echo"checked";}?>>&nbsp;Admission</td>
				<td><input type='checkbox' name='grtreatedon' value='1' <?php if(isset($_POST['grtreatedon']) ){echo"checked";}?>>&nbsp;Treated on</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
			<tr>
				<td><input type='checkbox' name='grdepartmentid' value='1' <?php if(isset($_POST['grdepartmentid']) ){echo"checked";}?>>&nbsp;department</td>
				<td><input type='checkbox' name='grtreatment' value='1' <?php if(isset($_POST['grtreatment']) ){echo"checked";}?>>&nbsp;Treatment</td>
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
				<td><input type='checkbox' name='shpatientappointmentid' value='1' <?php if(isset($_POST['shpatientappointmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Patient Appointment</td>
			<tr>
				<td><input type='checkbox' name='shsymptoms' value='1' <?php if(isset($_POST['shsymptoms'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Symptoms</td>
				<td><input type='checkbox' name='shhpi' value='1' <?php if(isset($_POST['shhpi'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Hpi</td>
			<tr>
				<td><input type='checkbox' name='shobs' value='1' <?php if(isset($_POST['shobs'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Obs</td>
				<td><input type='checkbox' name='shfindings' value='1' <?php if(isset($_POST['shfindings'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Findings</td>
			<tr>
				<td><input type='checkbox' name='shinvestigation' value='1' <?php if(isset($_POST['shinvestigation'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Investigation</td>
				<td><input type='checkbox' name='shdiagnosiid' value='1' <?php if(isset($_POST['shdiagnosiid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Diagnosis</td>
			<tr>
				<td><input type='checkbox' name='shdiagnosis' value='1' <?php if(isset($_POST['shdiagnosis'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Patient Diagnosis</td>
				<td><input type='checkbox' name='shadmission' value='1' <?php if(isset($_POST['shadmission']) ){echo"checked";}?>>&nbsp;Admission</td>
			<tr>
				<td><input type='checkbox' name='shtreatedon' value='1' <?php if(isset($_POST['shtreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Treated on</td>
				<td><input type='checkbox' name='shpatientstatusid' value='1' <?php if(isset($_POST['shpatientstatusid']) ){echo"checked";}?>>&nbsp;Patient Status</td>
			<tr>
<!-- 				<td><input type='checkbox' name='shpayconsultancy' value='1' <?php if(isset($_POST['shpayconsultancy'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Pay Consultancy</td> -->
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created on</td>
				<td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='shtreatment' value='1' <?php if(isset($_POST['shtreatment'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Treatment</td>
				<td><input type='checkbox' name='shdob' value='1' <?php if(isset($_POST['shdob'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Age</td>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" class="btn" name="action" id="action" value="Filter" /></td>
	</tr>
</table>
</form>
</div>
</div>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shpatientid==1  or empty($obj->action)){ ?>
				<th>Patient </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th>Department </th>
			<?php } ?>
			<?php if($obj->shsymptoms==1  ){ ?>
				<th>Symptoms </th>
			<?php } ?>
			<?php if($obj->shhpi==1  or empty($obj->action)){ ?>
				<th>HPI </th>
			<?php } ?>
			<?php if($obj->shobs==1  or empty($obj->action)){ ?>
				<th>OBS/Gyne/PSMH </th>
			<?php } ?>
			<?php if($obj->shfindings==1  or empty($obj->action)){ ?>
				<th>Examination Findings </th>
			<?php } ?>
			<?php if($obj->shinvestigation==1  or empty($obj->action)){ ?>
				<th>Investigation </th>
			<?php } ?>
			<?php if($obj->shdiagnosiid==1  or empty($obj->action)){ ?>
				<th> Diagnosis</th>
			<?php } ?>
			<?php if($obj->shdiagnosis==1  or empty($obj->action)){ ?>
				<th>Diagnosis </th>
			<?php } ?>
			<?php if($obj->shadmission==1 ){ ?>
				<th>Admit Patient </th>
			<?php } ?>
			<?php if($obj->shtreatedon==1  or empty($obj->action)){ ?>
				<th>Treated On </th>
			<?php } ?>
			<?php if($obj->shpatientstatusid==1 ){ ?>
				<th>Patient Status </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shage==1  or empty($obj->action)){ ?>
				<th>Age </th>
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