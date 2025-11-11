<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/nationalitys/Nationalitys_class.php");
require_once("../../../modules/hrm/countys/Countys_class.php");
require_once("../../../modules/hrm/employeebanks/Employeebanks_class.php");
require_once("../../../modules/hrm/bankbranches/Bankbranches_class.php");
require_once("../../../modules/hrm/assignments/Assignments_class.php");
require_once("../../../modules/hrm/departments/Departments_class.php");
require_once("../../../modules/hrm/grades/Grades_class.php");
require_once("../../../modules/hrm/employeestatuss/Employeestatuss_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employees";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8761";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
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
if(!empty($obj->grpfnum) or !empty($obj->grfirstname) or !empty($obj->grgender) or !empty($obj->grsupervisorid) or !empty($obj->grstartdate) or !empty($obj->grenddate) or !empty($obj->grnationalityid) or !empty($obj->grcountyid) or !empty($obj->grmarital) or !empty($obj->gremployeebankid) or !empty($obj->grbankbrancheid) or !empty($obj->grassignmentid) or !empty($obj->grdepartmentid) or !empty($obj->grgradeid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon)or !empty($obj->grtype) ){
	$obj->shpfnum='';
	$obj->shfirstname='';
	$obj->shgender='';
	$obj->shsupervisorid='';
	$obj->shstartdate='';
	$obj->shenddate='';
	$obj->shdob='';
	$obj->shidno='';
	$obj->shpassportno='';
	$obj->shphoneno='';
	$obj->shemail='';
	$obj->shofficemail='';
	$obj->shphysicaladdress='';
	$obj->shnationalityid='';
	$obj->shcountyid='';
	$obj->shmarital='';
	$obj->shspouse='';
	$obj->shspouseidno='';
	$obj->shspousetel='';
	$obj->shspouseemail='';
	$obj->shnssfno='';
	$obj->shnhifno='';
	$obj->shpinno='';
	$obj->shhelbno='';
	$obj->shemployeebankid='';
	$obj->shgrbankbrancheid='';
	$obj->shbankacc='';
	$obj->shclearingcode='';
	$obj->shref='';
	$obj->shassignmentid='';
	$obj->shdepartmentid='';
	$obj->shgradeid='';
	$obj->shstatusid='';
	$obj->shimage='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shtype='';
}


	$obj->sh=1;
	
if(!empty($obj->grpfnum)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" pfnum ";
	$obj->shpfnum=1;
	$track++;
}

if(!empty($obj->grfirstname)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" firstname ";
	$obj->shfirstname=1;
	$track++;
}

if(!empty($obj->grgender)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" gender ";
	$obj->shgender=1;
	$track++;
}

if(!empty($obj->grsupervisorid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" supervisorid ";
	$obj->shsupervisorid=1;
	$track++;
}

if(!empty($obj->grstartdate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" startdate ";
	$obj->shstartdate=1;
	$track++;
}

if(!empty($obj->grenddate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" enddate ";
	$obj->shenddate=1;
	$track++;
}

if(!empty($obj->grnationalityid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" nationalityid ";
	$obj->shnationalityid=1;
	$track++;
}

if(!empty($obj->grcountyid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" countyid ";
	$obj->shcountyid=1;
	$track++;
}

if(!empty($obj->grmarital)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" marital ";
	$obj->shmarital=1;
	$track++;
}

if(!empty($obj->gremployeebankid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employeebankid ";
	$obj->shemployeebankid=1;
	$track++;
}

if(!empty($obj->grbankbrancheid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" bankbrancheid ";
	$obj->shbankbrancheid=1;
	$track++;
}

if(!empty($obj->grassignmentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" assignmentid ";
	$obj->shassignmentid=1;
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

if(!empty($obj->grgradeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" gradeid ";
	$obj->shgradeid=1;
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

if(!empty($obj->grtype)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" type ";
	$obj->shtype=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shpfnum)  or empty($obj->action)){
		array_push($sColumns, 'pfnum');
		array_push($aColumns, "hrm_employees.pfnum");
		$k++;
		}

	if(!empty($obj->shfirstname)  or empty($obj->action)){
		array_push($sColumns, 'firstname');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as firstname");
		$k++;
		}

	if(!empty($obj->shgender)  or empty($obj->action)){
		array_push($sColumns, 'gender');
		array_push($aColumns, "hrm_employees.gender");
		$k++;
		}

	if(!empty($obj->shsupervisorid) ){
		array_push($sColumns, 'supervisorid');
		array_push($aColumns, "hrm_employees.supervisorid");
		$k++;
		}

	if(!empty($obj->shstartdate)  or empty($obj->action)){
		array_push($sColumns, 'startdate');
		array_push($aColumns, "hrm_employees.startdate");
		$k++;
		}

	if(!empty($obj->shenddate)  or empty($obj->action)){
		array_push($sColumns, 'enddate');
		array_push($aColumns, "hrm_employees.enddate");
		$k++;
		}

	if(!empty($obj->shdob) ){
		array_push($sColumns, 'dob');
		array_push($aColumns, "hrm_employees.dob");
		$k++;
		}

	if(!empty($obj->shidno) ){
		array_push($sColumns, 'idno');
		array_push($aColumns, "hrm_employees.idno");
		$k++;
		}

	if(!empty($obj->shpassportno) ){
		array_push($sColumns, 'passportno');
		array_push($aColumns, "hrm_employees.passportno");
		$k++;
		}

	if(!empty($obj->shphoneno) ){
		array_push($sColumns, 'phoneno');
		array_push($aColumns, "hrm_employees.phoneno");
		$k++;
		}

	if(!empty($obj->shemail) ){
		array_push($sColumns, 'email');
		array_push($aColumns, "hrm_employees.email");
		$k++;
		}

	if(!empty($obj->shofficemail) ){
		array_push($sColumns, 'officemail');
		array_push($aColumns, "hrm_employees.officemail");
		$k++;
		}

	if(!empty($obj->shphysicaladdress) ){
		array_push($sColumns, 'physicaladdress');
		array_push($aColumns, "hrm_employees.physicaladdress");
		$k++;
		}

	if(!empty($obj->shnationalityid) ){
		array_push($sColumns, 'nationalityid');
		array_push($aColumns, "hrm_nationalitys.name as nationalityid");
		$rptjoin.=" left join hrm_nationalitys on hrm_nationalitys.id=hrm_employees.nationalityid ";
		$k++;
		}

	if(!empty($obj->shcountyid)  or empty($obj->action)){
		array_push($sColumns, 'countyid');
		array_push($aColumns, "hrm_countys.name as countyid");
		$rptjoin.=" left join hrm_countys on hrm_countys.id=hrm_employees.countyid ";
		$k++;
		}

	if(!empty($obj->shmarital) ){
		array_push($sColumns, 'marital');
		array_push($aColumns, "hrm_employees.marital");
		$k++;
		}

	if(!empty($obj->shspouse) ){
		array_push($sColumns, 'spouse');
		array_push($aColumns, "hrm_employees.spouse");
		$k++;
		}

	if(!empty($obj->shspouseidno) ){
		array_push($sColumns, 'spouseidno');
		array_push($aColumns, "hrm_employees.spouseidno");
		$k++;
		}

	if(!empty($obj->shspousetel) ){
		array_push($sColumns, 'spousetel');
		array_push($aColumns, "hrm_employees.spousetel");
		$k++;
		}

	if(!empty($obj->shspouseemail) ){
		array_push($sColumns, 'spouseemail');
		array_push($aColumns, "hrm_employees.spouseemail");
		$k++;
		}

	if(!empty($obj->shnssfno) ){
		array_push($sColumns, 'nssfno');
		array_push($aColumns, "hrm_employees.nssfno");
		$k++;
		}

	if(!empty($obj->shnhifno)  or empty($obj->action)){
		array_push($sColumns, 'nhifno');
		array_push($aColumns, "hrm_employees.nhifno");
		$k++;
		}

	if(!empty($obj->shpinno) ){
		array_push($sColumns, 'pinno');
		array_push($aColumns, "hrm_employees.pinno");
		$k++;
		}

	if(!empty($obj->shhelbno) ){
		array_push($sColumns, 'helbno');
		array_push($aColumns, "hrm_employees.helbno");
		$k++;
		}

	if(!empty($obj->shemployeebankid)  or empty($obj->action)){
		array_push($sColumns, 'employeebankid');
		array_push($aColumns, "hrm_employeebanks.name as employeebankid");
		$rptjoin.=" left join hrm_employeebanks on hrm_employeebanks.id=hrm_employees.employeebankid ";
		$k++;
		}

	if(!empty($obj->shgrbankbrancheid) ){
		array_push($sColumns, 'grbankbrancheid');
		array_push($aColumns, "hrm_employees.grbankbrancheid");
		$k++;
		}

	if(!empty($obj->shbankacc) ){
		array_push($sColumns, 'bankacc');
		array_push($aColumns, "hrm_employees.bankacc");
		$k++;
		}

	if(!empty($obj->shclearingcode) ){
		array_push($sColumns, 'clearingcode');
		array_push($aColumns, "hrm_employees.clearingcode");
		$k++;
		}

	if(!empty($obj->shref) ){
		array_push($sColumns, 'ref');
		array_push($aColumns, "hrm_employees.ref");
		$k++;
		}

	

	if(!empty($obj->shassignmentid) ){
		array_push($sColumns, 'assignmentid');
		array_push($aColumns, "hrm_assignments.name as assignmentid");
		$rptjoin.=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		$k++;
		}
		
	 if(!empty($obj->shdepartmentid)){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "hrm_departments.name as departmentid");
		$k++;
		$join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join hrm_departments on hrm_departments.id=hrm_assignments.departmentid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}


	if(!empty($obj->shgradeid)  or empty($obj->action)){
		array_push($sColumns, 'gradeid');
		array_push($aColumns, "hrm_grades.name as gradeid");
		$rptjoin.=" left join hrm_grades on hrm_grades.id=hrm_employees.gradeid ";
		$k++;
		}

	if(!empty($obj->shstatusid) ){
		array_push($sColumns, 'statusid');
		array_push($aColumns, "hrm_employeestatuss.name as statusid");
		$rptjoin.=" left join hrm_employeestatuss on hrm_employeestatuss.id=hrm_employees.statusid ";
		$k++;
		}

	if(!empty($obj->shimage) ){
		array_push($sColumns, 'image');
		array_push($aColumns, "hrm_employees.image");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "hrm_employees.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employees.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hrm_employees.ipaddress");
		$k++;
		}
	if(!empty($obj->shtype) ){
		array_push($sColumns, 'type');
		array_push($aColumns, "(case when hrm_employees.type=1 then 'Permanent' else 'Casual' end) type");
		$k++;
		}
	if(!empty($rptgroup)){
	  $obj->shcount=1;
	  array_push($sColumns, 'cnt');
		array_push($aColumns, "count(*) cnt");
		$k++;
	}


$track=0;

//processing filters
if(!empty($obj->pfnum)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.pfnum='$obj->pfnum'";
	$track++;
}

if(!empty($obj->firstname)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.firstname='$obj->firstname'";
		$join=" left join hrm_employees on hrm_employees.id=hrm_employees.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->gender)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.gender='$obj->gender'";
	$track++;
}

if(!empty($obj->supervisorid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.supervisorid='$obj->supervisorid'";
	$track++;
}

if(!empty($obj->fromstartdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.startdate>='$obj->fromstartdate'";
	$track++;
}

if(!empty($obj->tostartdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.startdate<='$obj->tostartdate'";
	$track++;
}

if(!empty($obj->fromenddate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.enddate>='$obj->fromenddate'";
	$track++;
}

if(!empty($obj->toenddate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.enddate<='$obj->toenddate'";
	$track++;
}

if(!empty($obj->nationalityid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.nationalityid='$obj->nationalityid'";
		
	$track++;
}

if(!empty($obj->countyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.countyid='$obj->countyid'";
		//$join=" left join hrm_countys on hrm_employees.id=hrm_countys.employeeid ";
		
	$track++;
}

if(!empty($obj->marital)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.marital='$obj->marital'";
	$track++;
}

if(!empty($obj->employeebankid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.employeebankid='$obj->employeebankid'";
		$join=" left join hrm_employeebanks on hrm_employees.id=hrm_employeebanks.employeeid ";
		
	$track++;
}

if(!empty($obj->bankbrancheid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.bankbrancheid='$obj->bankbrancheid'";
		$join=" left join hrm_bankbranches on hrm_employees.id=hrm_bankbranches.employeeid ";
		
	$track++;
}




if(!empty($obj->assignmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.assignmentid='$obj->assignmentid'";
		$join=" left join hrm_assignments on hrm_employees.id=hrm_assignments.employeeid ";
		
	$track++;
}





if(!empty($obj->gradeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.gradeid='$obj->gradeid'";
		$join=" left join hrm_grades on hrm_employees.id=hrm_grades.employeeid ";
		
	$track++;
}

if(!empty($obj->statusid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.statusid='$obj->statusid'";
		$join=" left join hrm_employeestatuss on hrm_employees.id=hrm_employeestatuss.employeeid ";
		
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.createdon<='$obj->tocreatedon'";
	$track++;
}
if(!empty($obj->type)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employees.type='$obj->type'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
if(!empty($obj->shfirstname)){
	$fd.=" ,concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) ";
}
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#firstnaname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#firstname").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="hrm_employees";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employees",
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
<form  action="employees.php" method="post" name="employees" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>PF Number</td>
				<td><input type='text' id='pfnum' size='20' name='pfnum' value='<?php echo $obj->pfnum;?>'></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input type='text' size='20' name='firstnaname' id='firstnaname' value='<?php echo $obj->firstnaname; ?>'>
					<input type="hidden" name='firstname' id='firstname' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Gender</td>
			</tr>
			<tr>
				<td>Supervisor</td>
				<td><input type='text' id='supervisorid' size='20' name='supervisorid' value='<?php echo $obj->supervisorid;?>'></td>
			</tr>
			<tr>
				<td>Start Date</td>
				<td><strong>From:</strong><input type='text' id='fromstartdate' size='12' name='fromstartdate' readonly class="date_input" value='<?php echo $obj->fromstartdate;?>'/>
							<br/><strong>To:</strong><input type='text' id='tostartdate' size='12' name='tostartdate' readonly class="date_input" value='<?php echo $obj->tostartdate;?>'/></td>
			</tr>
			<tr>
				<td>End Date</td>
				<td><strong>From:</strong><input type='text' id='fromenddate' size='12' name='fromenddate' readonly class="date_input" value='<?php echo $obj->fromenddate;?>'/>
							<br/><strong>To:</strong><input type='text' id='toenddate' size='12' name='toenddate' readonly class="date_input" value='<?php echo $obj->toenddate;?>'/></td>
			</tr>
			<tr>
				<td>Nationality</td>
				<td>
				<select name='nationalityid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$nationalitys=new Nationalitys();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$nationalitys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($nationalitys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->nationalityid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>County</td>
				<td>
				<select name='countyid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$countys=new Countys();
				$where="  ";
				$fields="*";
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
				<td>Marital Status</td>
			</tr>
			<tr>
				<td>Bank</td>
				<td>
				<select name='employeebankid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$employeebanks=new Employeebanks();
				$where="  ";
				$fields="hrm_employeebanks.id, hrm_employeebanks.code, hrm_employeebanks.name, hrm_employeebanks.remarks, hrm_employeebanks.createdby, hrm_employeebanks.createdon, hrm_employeebanks.lasteditedby, hrm_employeebanks.lasteditedon, hrm_employeebanks.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$employeebanks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($employeebanks->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->employeebankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Bank Branch </td>
				<td>
				<select name='bankbrancheid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$bankbranches=new Bankbranches();
				$where="  ";
				$fields="hrm_bankbranches.id, hrm_bankbranches.name, hrm_bankbranches.employeebankid, hrm_bankbranches.remarks, hrm_bankbranches.createdby, hrm_bankbranches.createdon, hrm_bankbranches.lasteditedby, hrm_bankbranches.lasteditedon, hrm_bankbranches.ipaddress";
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
				<td>Assignment</td>
				<td>
				<select name='assignmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$assignments=new Assignments();
				$where="  ";
				$fields="hrm_assignments.id, hrm_assignments.code, hrm_assignments.name, hrm_assignments.departmentid, hrm_assignments.levelid, hrm_assignments.remarks, hrm_assignments.createdby, hrm_assignments.createdon, hrm_assignments.lasteditedby, hrm_assignments.lasteditedon, hrm_assignments.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($assignments->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->assignmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Grade</td>
				<td>
				<select name='gradeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$grades=new Grades();
				$where="  ";
				$fields="hrm_grades.id, hrm_grades.name, hrm_grades.remarks, hrm_grades.ipaddress, hrm_grades.createdby, hrm_grades.createdon, hrm_grades.lasteditedby, hrm_grades.lasteditedon";
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
				</select>
</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>
				<select name='statusid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$employeestatuss=new Employeestatuss();
				$where="  ";
				$fields="*";
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
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from hrm_employees) ";
				$join=" left join hrm_employees on hrm_employees.id=auth_users.employeeid ";
				$having="";
				$groupby="";
				$orderby=" order by employeename ";
				$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($rw=mysql_fetch_object($users->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->createdby==$rw->id){echo "selected";}?>><?php echo $rw->employeeid;?></option>
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
			
			<tr>
				<td>Emp Type:</td>
				<td>
				<select name='type' class='selectbox'>
				<option value="">Select...</option>
				<option value="1" <?php if($obj->type==1){echo"selected";}?>>Permanent</option>
				<option value="2" <?php if($obj->type==2){echo"selected";}?>>Casual</option>
				</select>
</td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grpfnum' value='1' <?php if(isset($_POST['grpfnum']) ){echo"checked";}?>>&nbsp;PF Number</td>
				<td><input type='checkbox' name='grfirstname' value='1' <?php if(isset($_POST['grfirstname']) ){echo"checked";}?>>&nbsp;Name</td>
			<tr>
				<td><input type='checkbox' name='grgender' value='1' <?php if(isset($_POST['grgender']) ){echo"checked";}?>>&nbsp;Gender</td>
				<td><input type='checkbox' name='grsupervisorid' value='1' <?php if(isset($_POST['grsupervisorid']) ){echo"checked";}?>>&nbsp;Supervisor</td>
			<tr>
				<td><input type='checkbox' name='grstartdate' value='1' <?php if(isset($_POST['grstartdate']) ){echo"checked";}?>>&nbsp;Start Date</td>
				<td><input type='checkbox' name='grenddate' value='1' <?php if(isset($_POST['grenddate']) ){echo"checked";}?>>&nbsp;End Date</td>
			<tr>
				<td><input type='checkbox' name='grnationalityid' value='1' <?php if(isset($_POST['grnationalityid']) ){echo"checked";}?>>&nbsp;Nationality</td>
				<td><input type='checkbox' name='grcountyid' value='1' <?php if(isset($_POST['grcountyid']) ){echo"checked";}?>>&nbsp;County</td>
			<tr>
				<td><input type='checkbox' name='grmarital' value='1' <?php if(isset($_POST['grmarital']) ){echo"checked";}?>>&nbsp;Marital Status</td>
				<td><input type='checkbox' name='gremployeebankid' value='1' <?php if(isset($_POST['gremployeebankid']) ){echo"checked";}?>>&nbsp;Bank</td>
			<tr>
				<td><input type='checkbox' name='grbankbrancheid' value='1' <?php if(isset($_POST['grbankbrancheid']) ){echo"checked";}?>>&nbsp;Bank Branch </td>
				<td><input type='checkbox' name='grassignmentid' value='1' <?php if(isset($_POST['grassignmentid']) ){echo"checked";}?>>&nbsp;Assignment</td>
			<tr>
			<td><input type='checkbox' name='grdepartmentid' value='1' <?php if(isset($_POST['grdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='grgradeid' value='1' <?php if(isset($_POST['grgradeid']) ){echo"checked";}?>>&nbsp;Grade</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grtype' value='1' <?php if(isset($_POST['grtype']) ){echo"checked";}?>>&nbsp;Type </td>
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
				<td><input type='checkbox' name='shpfnum' value='1' <?php if(isset($_POST['shpfnum'])  or empty($obj->action)){echo"checked";}?>>&nbsp;PF Number</td>
				<td><input type='checkbox' name='shfirstname' value='1' <?php if(isset($_POST['shfirstname'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Name</td>
			<tr>
				<td><input type='checkbox' name='shgender' value='1' <?php if(isset($_POST['shgender'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Gender</td>
				<td><input type='checkbox' name='shsupervisorid' value='1' <?php if(isset($_POST['shsupervisorid']) ){echo"checked";}?>>&nbsp;Supervisor</td>
			<tr>
				<td><input type='checkbox' name='shstartdate' value='1' <?php if(isset($_POST['shstartdate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Start Date</td>
				<td><input type='checkbox' name='shenddate' value='1' <?php if(isset($_POST['shenddate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;End Date</td>
			<tr>
				<td><input type='checkbox' name='shdob' value='1' <?php if(isset($_POST['shdob']) ){echo"checked";}?>>&nbsp;DoB</td>
				<td><input type='checkbox' name='shidno' value='1' <?php if(isset($_POST['shidno']) ){echo"checked";}?>>&nbsp;ID No</td>
			<tr>
				<td><input type='checkbox' name='shpassportno' value='1' <?php if(isset($_POST['shpassportno']) ){echo"checked";}?>>&nbsp;Passport</td>
				<td><input type='checkbox' name='shphoneno' value='1' <?php if(isset($_POST['shphoneno']) ){echo"checked";}?>>&nbsp;Phone No.</td>
			<tr>
				<td><input type='checkbox' name='shemail' value='1' <?php if(isset($_POST['shemail']) ){echo"checked";}?>>&nbsp;E-mail </td>
				<td><input type='checkbox' name='shofficemail' value='1' <?php if(isset($_POST['shofficemail']) ){echo"checked";}?>>&nbsp;Office Email</td>
			<tr>
				<td><input type='checkbox' name='shphysicaladdress' value='1' <?php if(isset($_POST['shphysicaladdress']) ){echo"checked";}?>>&nbsp;Physical Address</td>
				<td><input type='checkbox' name='shnationalityid' value='1' <?php if(isset($_POST['shnationalityid']) ){echo"checked";}?>>&nbsp;Nationality</td>
			<tr>
				<td><input type='checkbox' name='shcountyid' value='1' <?php if(isset($_POST['shcountyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;County</td>
				<td><input type='checkbox' name='shmarital' value='1' <?php if(isset($_POST['shmarital']) ){echo"checked";}?>>&nbsp;Marital Status</td>
			<tr>
				<td><input type='checkbox' name='shspouse' value='1' <?php if(isset($_POST['shspouse']) ){echo"checked";}?>>&nbsp;Spouse</td>
				<td><input type='checkbox' name='shspouseidno' value='1' <?php if(isset($_POST['shspouseidno']) ){echo"checked";}?>>&nbsp;Spouse ID No</td>
			<tr>
				<td><input type='checkbox' name='shspousetel' value='1' <?php if(isset($_POST['shspousetel']) ){echo"checked";}?>>&nbsp;Spouse Tel</td>
				<td><input type='checkbox' name='shspouseemail' value='1' <?php if(isset($_POST['shspouseemail']) ){echo"checked";}?>>&nbsp;Spouse Email</td>
			<tr>
				<td><input type='checkbox' name='shnssfno' value='1' <?php if(isset($_POST['shnssfno']) ){echo"checked";}?>>&nbsp;NSSF No</td>
				<td><input type='checkbox' name='shnhifno' value='1' <?php if(isset($_POST['shnhifno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;NHIF No </td>
			<tr>
				<td><input type='checkbox' name='shpinno' value='1' <?php if(isset($_POST['shpinno']) ){echo"checked";}?>>&nbsp;Pin No</td>
				<td><input type='checkbox' name='shhelbno' value='1' <?php if(isset($_POST['shhelbno']) ){echo"checked";}?>>&nbsp;University No(HELB)</td>
			<tr>
				<td><input type='checkbox' name='shemployeebankid' value='1' <?php if(isset($_POST['shemployeebankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank</td>
				<td><input type='checkbox' name='shgrbankbrancheid' value='1' <?php if(isset($_POST['shgrbankbrancheid']) ){echo"checked";}?>>&nbsp;Bank Branch </td>
			<tr>
				<td><input type='checkbox' name='shbankacc' value='1' <?php if(isset($_POST['shbankacc']) ){echo"checked";}?>>&nbsp;Bank Acc.</td>
				<td><input type='checkbox' name='shclearingcode' value='1' <?php if(isset($_POST['shclearingcode']) ){echo"checked";}?>>&nbsp;Clearing Code</td>
			<tr>
				<td><input type='checkbox' name='shref' value='1' <?php if(isset($_POST['shref']) ){echo"checked";}?>>&nbsp;Reference</td>
				<td><input type='checkbox' name='shassignmentid' value='1' <?php if(isset($_POST['shassignmentid']) ){echo"checked";}?>>&nbsp;Assignment</td>
			<tr>
				  <td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='shgradeid' value='1' <?php if(isset($_POST['shgradeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Grade</td>
				<td><input type='checkbox' name='shstatusid' value='1' <?php if(isset($_POST['shstatusid']) ){echo"checked";}?>>&nbsp;Status</td>
			<tr>
				<td><input type='checkbox' name='shimage' value='1' <?php if(isset($_POST['shimage']) ){echo"checked";}?>>&nbsp;Image</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address	</td>
			<tr>
			<td><input type='checkbox' name='shtype' value='1' <?php if(isset($_POST['shtype']) ){echo"checked";}?>>&nbsp;Type	</td>
				
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
			<?php if($obj->shpfnum==1  or empty($obj->action)){ ?>
				<th>PF Number </th>
			<?php } ?>
			<?php if($obj->shfirstname==1  or empty($obj->action)){ ?>
				<th>First Name </th>
			<?php } ?>
			<?php if($obj->shgender==1  or empty($obj->action)){ ?>
				<th>Gender </th>
			<?php } ?>
			<?php if($obj->shsupervisorid==1 ){ ?>
				<th>Supervisor </th>
			<?php } ?>
			<?php if($obj->shstartdate==1  or empty($obj->action)){ ?>
				<th>Start Date </th>
			<?php } ?>
			<?php if($obj->shenddate==1  or empty($obj->action)){ ?>
				<th>End Date </th>
			<?php } ?>
			<?php if($obj->shdob==1 ){ ?>
				<th>DoB </th>
			<?php } ?>
			<?php if($obj->shidno==1 ){ ?>
				<th>ID No </th>
			<?php } ?>
			<?php if($obj->shpassportno==1 ){ ?>
				<th>Passport No. </th>
			<?php } ?>
			<?php if($obj->shphoneno==1 ){ ?>
				<th>Phone No. </th>
			<?php } ?>
			<?php if($obj->shemail==1 ){ ?>
				<th>E-mail </th>
			<?php } ?>
			<?php if($obj->shofficemail==1 ){ ?>
				<th>Office Email </th>
			<?php } ?>
			<?php if($obj->shphysicaladdress==1 ){ ?>
				<th>Physical Address </th>
			<?php } ?>
			<?php if($obj->shnationalityid==1 ){ ?>
				<th>Nationality </th>
			<?php } ?>
			<?php if($obj->shcountyid==1  or empty($obj->action)){ ?>
				<th>County </th>
			<?php } ?>
			<?php if($obj->shmarital==1 ){ ?>
				<th>Marital Status </th>
			<?php } ?>
			<?php if($obj->shspouse==1 ){ ?>
				<th>Spouse </th>
			<?php } ?>
			<?php if($obj->shspouseidno==1 ){ ?>
				<th>Spouse ID No </th>
			<?php } ?>
			<?php if($obj->shspousetel==1 ){ ?>
				<th>Spouse Tel </th>
			<?php } ?>
			<?php if($obj->shspouseemail==1 ){ ?>
				<th>Spouse Email </th>
			<?php } ?>
			<?php if($obj->shnssfno==1 ){ ?>
				<th>NSSF No </th>
			<?php } ?>
			<?php if($obj->shnhifno==1  or empty($obj->action)){ ?>
				<th>NHIF No </th>
			<?php } ?>
			<?php if($obj->shpinno==1 ){ ?>
				<th>Pin No </th>
			<?php } ?>
			<?php if($obj->shhelbno==1 ){ ?>
				<th>University No(HELB) </th>
			<?php } ?>
			<?php if($obj->shemployeebankid==1  or empty($obj->action)){ ?>
				<th>Employee Bank </th>
			<?php } ?>
			<?php if($obj->shgrbankbrancheid==1 ){ ?>
				<th> Bank Branch</th>
			<?php } ?>
			<?php if($obj->shbankacc==1 ){ ?>
				<th>Bank Acc. </th>
			<?php } ?>
			<?php if($obj->shclearingcode==1 ){ ?>
				<th>Clearing Code </th>
			<?php } ?>
			<?php if($obj->shref==1 ){ ?>
				<th>Reference </th>
			<?php } ?>
			
			<?php if($obj->shassignmentid==1 ){ ?>
				<th>Assignment </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1 ){ ?>
				<th>Department </th>
			<?php } ?>
			<?php if($obj->shgradeid==1  or empty($obj->action)){ ?>
				<th>Grade </th>
			<?php } ?>
			<?php if($obj->shstatusid==1 ){ ?>
				<th>Status </th>
			<?php } ?>
			<?php if($obj->shimage==1 ){ ?>
				<th>Image </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created by </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created on </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>Ip Address </th>
			<?php } ?>
			<?php if($obj->shcount==1 ){ ?>
				<th>Count </th>
			<?php } ?>
			<?php if($obj->shtype==1 ){ ?>
				<th>Type </th>
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
