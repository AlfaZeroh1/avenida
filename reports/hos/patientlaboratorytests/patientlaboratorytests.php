<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hos/patientlaboratorytests/Patientlaboratorytests_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/hos/patients/Patients_class.php");
require_once("../../../modules/hos/laboratorytests/Laboratorytests_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");



if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Patientlaboratorytests";
//connect to db
$db=new DB();

$obj=(object)$_POST;
//Authorization.
$auth->roleid="8736";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);

include "../../../head.php";

if(empty($obj->action)){
	$obj->fromtestedon=date('Y-m-d');
	$obj->totestedon=date('Y-m-d');
}

$rptwhere='';
$rptjoin='';
$track=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//processing columns to show
	if(!empty($obj->shtestno)  or empty($obj->action)){
		array_push($sColumns, 'testno');
		array_push($aColumns, "hos_patientlaboratorytests.testno");
	}

	if(!empty($obj->shpatientid)  or empty($obj->action)){
		array_push($sColumns, 'patientid');
		array_push($aColumns, "concat(hos_patients.surname,' ',hos_patients.othernames) as patientid");
		
		array_push($sColumns, 'dob');
		array_push($aColumns, "hos_patients.dob");
		
		$rptjoin.=" left join hos_patients on hos_patients.id=hos_patientlaboratorytests.patientid ";
	}

	if(!empty($obj->shpatienttreatmentid)  or empty($obj->action)){
		array_push($sColumns, 'patienttreatmentid');
		array_push($aColumns, "hos_patientlaboratorytests.patienttreatmentid");
	}

	if(!empty($obj->shlaboratorytestid)  or empty($obj->action)){
		array_push($sColumns, 'laboratorytestid');
		array_push($aColumns, "hos_patientlaboratorytests.laboratorytestid");
	}

	if(!empty($obj->shcharge)  or empty($obj->action)){
		array_push($sColumns, 'charge');
		array_push($aColumns, "hos_patientlaboratorytests.charge");
	}

	if(!empty($obj->shresults)  or empty($obj->action)){
		array_push($sColumns, 'results');
		array_push($aColumns, "hos_patientlaboratorytests.results");
	}

	if(!empty($obj->shlabresults)  or empty($obj->action)){
		array_push($sColumns, 'labresults');
		array_push($aColumns, "hos_patientlaboratorytests.labresults");
	}

	if(!empty($obj->shtestedon)  or empty($obj->action)){
		array_push($sColumns, 'testedon');
		array_push($aColumns, "hos_patientlaboratorytests.testedon");
	}

	if(!empty($obj->shconsult) ){
		array_push($sColumns, 'consult');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as consult");
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "hos_patientlaboratorytests.createdby");
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hos_patientlaboratorytests.createdon");
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->testno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.testno='$obj->testno'";
	$track++;
}

if(!empty($obj->patientid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.patientid='$obj->patientid'";
	$track++;
}

if(!empty($obj->patienttreatmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.patienttreatmentid='$obj->patienttreatmentid'";
	$track++;
}

if(!empty($obj->laboratorytestid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.laboratorytestid='$obj->laboratorytestid'";
	$track++;
}

if(!empty($obj->results)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.results='$obj->results'";
	$track++;
}

if(!empty($obj->fromtestedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.testedon>='$obj->fromtestedon'";
	$track++;
}

if(!empty($obj->totestedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.testedon<='$obj->totestedon'";
	$track++;
}


if(!empty($obj->fromdob)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patients.dob>='$obj->fromdob'";
	$track++;
}

if(!empty($obj->todob)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patients.dob<='$obj->todob'";
	$track++;
}

if(!empty($obj->consult)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.consult='$obj->consult'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientlaboratorytests.createdon<='$obj->tocreatedon'";
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

if(!empty($obj->grlaboratorytestid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" laboratorytestid ";
	$obj->shlaboratorytestid=1;
	$track++;
}

if(!empty($obj->grtestedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" testedon ";
	$obj->shtestedon=1;
	$track++;
}

if(!empty($obj->grconsult)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" consult ";
	$obj->shconsult=1;
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
;$rptgroup='';
$track=0;
}
//Default shows
if(!empty($obj->shpatientid)){
	$fd.=" ,concat(hos_patients.surname,' ',hos_patients.othernames) ";
}
if(!empty($obj->shconsult)){
	$fd.=" ,concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) ";
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

  $("#consuname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#consult").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="hos_patientlaboratorytests";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
			
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hos_patientlaboratorytests",
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
<form  action="patientlaboratorytests.php" method="post" name="patientlaboratorytests" class=''>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Test no</td>
				<td><input type='text' id='testno' size='20' name='testno' value='<?php echo $obj->testno;?>'></td>
			</tr>
			<tr>
				<td>Patient</td>
				<td><input type='text' size='20' name='patientname' id='patientname' value='<?php echo $obj->patientname; ?>'>
					<input type="hidden" name='patientid' id='patientid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Patient Treatment</td>
				<td><input type='text' id='patienttreatmentid' size='20' name='patienttreatmentid' value='<?php echo $obj->patienttreatmentid;?>'></td>
			</tr>
			<tr>
				<td>Laboratory test</td>
				<td>
				<select name='laboratorytestid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$laboratorytests=new Laboratorytests();
				$where="  ";
				$fields="hos_laboratorytests.id, hos_laboratorytests.name, hos_laboratorytests.charge, hos_laboratorytests.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby=" order by hos_laboratorytests.name ";
				$laboratorytests->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($laboratorytests->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->laboratorytestid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Results</td>
				<td>
				<input type="radio" name="results" value="Positive" <?php if($obj->results=="Positive"){echo"checked";}?>/> Positive
				<input type="radio" name="results" value="Negative" <?php if($obj->results=="Negative"){echo"checked";}?>/> Negative
				</td>
			</tr>
			<tr>
				<td>Tested on</td>
				<td><strong>From:</strong><input type='text' id='fromtestedon' size='12' name='fromtestedon' readonly class="date_input" value='<?php echo $obj->fromtestedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='totestedon' size='12' name='totestedon' readonly class="date_input" value='<?php echo $obj->totestedon;?>'/></td>
			</tr>
			<tr>
				<td>Age:</td>
				<td><strong>From:</strong><input type='text' id='fromdob' size='4' name='fromdob' value='<?php echo $obj->fromdob;?>'/>
								<br/><strong>To:</strong><input type='text' id='todob' size='4' name='todob' value='<?php echo $obj->todob;?>'></td>
			</tr>
			<tr>
				<td>Consult</td>
				<td><input type='text' size='20' name='consuname' id='consuname' value='<?php echo $obj->consuname; ?>'>
					<input type="hidden" name='consult' id='consult' value='<?php echo $obj->field; ?>'></td>
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
				<td><input type='checkbox' name='grlaboratorytestid' value='1' <?php if(isset($_POST['grlaboratorytestid']) ){echo"checked";}?>>&nbsp;Laboratory test</td>
			<tr>
				<td><input type='checkbox' name='grtestedon' value='1' <?php if(isset($_POST['grtestedon']) ){echo"checked";}?>>&nbsp;Tested on</td>
				<td><input type='checkbox' name='grconsult' value='1' <?php if(isset($_POST['grconsult']) ){echo"checked";}?>>&nbsp;Consult</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
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
				<td><input type='checkbox' name='shtestno' value='1' <?php if(isset($_POST['shtestno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Test no</td>
				<td><input type='checkbox' name='shpatientid' value='1' <?php if(isset($_POST['shpatientid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Patient</td>
			<tr>
				<td><input type='checkbox' name='shpatienttreatmentid' value='1' <?php if(isset($_POST['shpatienttreatmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Patient Treatment</td>
				<td><input type='checkbox' name='shlaboratorytestid' value='1' <?php if(isset($_POST['shlaboratorytestid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Laboratory test</td>
			<tr>
				<td><input type='checkbox' name='shcharge' value='1' <?php if(isset($_POST['shcharge'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Charge</td>
				<td><input type='checkbox' name='shresults' value='1' <?php if(isset($_POST['shresults'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Results</td>
			<tr>
				<td><input type='checkbox' name='shlabresults' value='1' <?php if(isset($_POST['shlabresults'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Lab results</td>
				<td><input type='checkbox' name='shtestedon' value='1' <?php if(isset($_POST['shtestedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Tested on</td>
			<tr>
				<td><input type='checkbox' name='shconsult' value='1' <?php if(isset($_POST['shconsult']) ){echo"checked";}?>>&nbsp;Consult</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
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
			<?php if($obj->shtestno==1  or empty($obj->action)){ ?>
				<th>Test No </th>
			<?php } ?>
			<?php if($obj->shpatientid==1  or empty($obj->action)){ ?>
				<th>Patient </th>
				<th>DoB </th>
			<?php } ?>
			<?php if($obj->shpatienttreatmentid==1  or empty($obj->action)){ ?>
				<th>Treatment </th>
			<?php } ?>
			<?php if($obj->shlaboratorytestid==1  or empty($obj->action)){ ?>
				<th>Laboratory Test </th>
			<?php } ?>
			<?php if($obj->shcharge==1  or empty($obj->action)){ ?>
				<th>Charge </th>
			<?php } ?>
			<?php if($obj->shresults==1  or empty($obj->action)){ ?>
				<th>Result </th>
			<?php } ?>
			<?php if($obj->shlabresults==1  or empty($obj->action)){ ?>
				<th>Lab Results </th>
			<?php } ?>
			<?php if($obj->shtestedon==1  or empty($obj->action)){ ?>
				<th>Tested On </th>
			<?php } ?>
			<?php if($obj->shconsult==1 ){ ?>
				<th>Consult </th>
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
