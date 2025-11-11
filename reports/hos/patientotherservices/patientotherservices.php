<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hos/patientotherservices/Patientotherservices_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hos/patients/Patients_class.php");
require_once("../../../modules/hos/patienttreatments/Patienttreatments_class.php");
require_once("../../../modules/hos/otherservices/Otherservices_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Patientotherservices";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9085";//Add
$auth->levelid=$_SESSION['level'];

//auth($auth);
include "../../../head.php";

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
if(!empty($obj->grdocumentno) or !empty($obj->grpatientid) or !empty($obj->grpatienttreatmentid) or !empty($obj->grotherserviceid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shdocumentno='';
	$obj->shpatientid='';
	$obj->shpatienttreatmentid='';
	$obj->shotherserviceid='';
	$obj->shcharge='';
	$obj->shremarks='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
}


	$obj->sh=1;


if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
	$track++;
}

if(!empty($obj->grpatientid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" patientid ";
	$obj->shpatientid=1;
	$track++;
}

if(!empty($obj->grpatienttreatmentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" patienttreatmentid ";
	$obj->shpatienttreatmentid=1;
	$track++;
}

if(!empty($obj->grotherserviceid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" otherserviceid ";
	$obj->shotherserviceid=1;
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

//processing columns to show
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "hos_patientotherservices.documentno");
		$k++;
		}

	if(!empty($obj->shpatientid)  or empty($obj->action)){
		array_push($sColumns, 'patientid');
		array_push($aColumns, "concat(hos_patients.surname,' ',hos_patients.othernames) as patientid");
		$rptjoin.=" left join hos_patients on hos_patients.id=hos_patientotherservices.patientid ";
		$k++;
		}

	if(!empty($obj->shpatienttreatmentid)  or empty($obj->action)){
		array_push($sColumns, 'patienttreatmentid');
		array_push($aColumns, "hos_patientotherservices.patienttreatmentid");
		$k++;
		}

	if(!empty($obj->shotherserviceid)  or empty($obj->action)){
		array_push($sColumns, 'otherserviceid');
		array_push($aColumns, "hos_otherservices.name as otherserviceid");
		$rptjoin.=" left join hos_otherservices on hos_otherservices.id=hos_patientotherservices.otherserviceid ";
		$k++;
		}

	if(!empty($obj->shcharge)  or empty($obj->action)){
		array_push($sColumns, 'charge');
		array_push($aColumns, "hos_patientotherservices.charge");
		$k++;
		}

	if(!empty($obj->shremarks)  or empty($obj->action)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "hos_patientotherservices.remarks");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "hos_patientotherservices.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hos_patientotherservices.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hos_patientotherservices.ipaddress");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientotherservices.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->patientid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientotherservices.patientid='$obj->patientid'";
// 		$join=" left join hos_patients on hos_patientotherservices.id=hos_patients.patientotherserviceid ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
	$track++;
}

if(!empty($obj->patienttreatmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientotherservices.patienttreatmentid='$obj->patienttreatmentid'";
		$join=" left join hos_patienttreatments on hos_patientotherservices.id=hos_patienttreatments.patientotherserviceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->otherserviceid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientotherservices.otherserviceid='$obj->otherserviceid'";
		$join=" left join hos_otherservices on hos_patientotherservices.id=hos_otherservices.patientotherserviceid ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientotherservices.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientotherservices.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientotherservices.createdon<='$obj->tocreatedon'";
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

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="hos_patientotherservices";?>
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
<form  action="patientotherservices.php" method="post" name="patientotherservices" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document no</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Patientid</td>
				<td><input type='text' size='20' name='patientname' id='patientname' value='<?php echo $obj->patientname; ?>'>
					<input type="hidden" name='patientid' id='patientid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Patient Treatment</td>
				<td>
				<select name='patienttreatmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$patienttreatments=new Patienttreatments();
				$where="  ";
				$fields="hos_patienttreatments.id, hos_patienttreatments.patientid, hos_patienttreatments.patientappointmentid, hos_patienttreatments.symptoms, hos_patienttreatments.hpi, hos_patienttreatments.obs, hos_patienttreatments.findings, hos_patienttreatments.investigation, hos_patienttreatments.diagnosiid, hos_patienttreatments.diagnosis, hos_patienttreatments.treatment, hos_patienttreatments.admission, hos_patienttreatments.treatedon, hos_patienttreatments.patientstatusid, hos_patienttreatments.payconsultancy, hos_patienttreatments.createdby, hos_patienttreatments.createdon, hos_patienttreatments.lasteditedby, hos_patienttreatments.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$patienttreatments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($patienttreatments->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->patienttreatmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Other service</td>
				<td>
				<select name='otherserviceid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$otherservices=new Otherservices();
				$where="  ";
				$fields="hos_otherservices.id, hos_otherservices.name, hos_otherservices.departmentid, hos_otherservices.charge, hos_otherservices.createdby, hos_otherservices.createdon, hos_otherservices.lasteditedby, hos_otherservices.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$otherservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($otherservices->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->otherserviceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Created By</td>
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
				<td>Created On</td>
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
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document no</td>
				<td><input type='checkbox' name='grpatientid' value='1' <?php if(isset($_POST['grpatientid']) ){echo"checked";}?>>&nbsp;Patientid</td>
			<tr>
				<td><input type='checkbox' name='grpatienttreatmentid' value='1' <?php if(isset($_POST['grpatienttreatmentid']) ){echo"checked";}?>>&nbsp;Patient Treatment</td>
				<td><input type='checkbox' name='grotherserviceid' value='1' <?php if(isset($_POST['grotherserviceid']) ){echo"checked";}?>>&nbsp;Other service</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document no</td>
				<td><input type='checkbox' name='shpatientid' value='1' <?php if(isset($_POST['shpatientid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Patientid</td>
			<tr>
				<td><input type='checkbox' name='shpatienttreatmentid' value='1' <?php if(isset($_POST['shpatienttreatmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Patient Treatment</td>
				<td><input type='checkbox' name='shotherserviceid' value='1' <?php if(isset($_POST['shotherserviceid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Other service</td>
			<tr>
				<td><input type='checkbox' name='shcharge' value='1' <?php if(isset($_POST['shcharge'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Charge</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
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
</div>
</div>
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Service No </th>
			<?php } ?>
			<?php if($obj->shpatientid==1  or empty($obj->action)){ ?>
				<th>Patient </th>
			<?php } ?>
			<?php if($obj->shpatienttreatmentid==1  or empty($obj->action)){ ?>
				<th>Patientappointmentid </th>
			<?php } ?>
			<?php if($obj->shotherserviceid==1  or empty($obj->action)){ ?>
				<th>Service </th>
			<?php } ?>
			<?php if($obj->shcharge==1  or empty($obj->action)){ ?>
				<th>Charge </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Createdby </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Createdon</th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th> </th>
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
