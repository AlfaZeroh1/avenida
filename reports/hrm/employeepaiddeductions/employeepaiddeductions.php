<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeepaiddeductions/Employeepaiddeductions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/deductions/Deductions_class.php");
require_once("../../../modules/hrm/loans/Loans_class.php");
require_once("../../../modules/hrm/employeeloans/Employeeloans_class.php");
require_once("../../../modules/hrm/assignments/Assignments_class.php");
require_once("../../../modules/hrm/departments/Departments_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeepaiddeductions";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9060";//Report View
$auth->levelid=$_SESSION['level'];

//auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->month=date('m');
	$obj->year=date('Y');
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
if(!empty($obj->gremployeeid) or !empty($obj->grdeductionid) or !empty($obj->grloanid) or !empty($obj->grmonth) or !empty($obj->grpaidon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon)or !empty($obj->grbasic) or !empty($obj->grdepartmentid) ){
	$obj->shemployeeid='';
	$obj->shpfnum='';
	$obj->shdeductionid='';
	$obj->shloanid='';
	$obj->shemployeepaymentid='';
	$obj->shamount=1;
	$obj->shmonth='';
	$obj->shyear='';
	$obj->shpaidon='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shidno='';
	$obj->shnssfno='';
	$obj->shnhifno='';
	$obj->shpin='';
	$obj->shdepartmentid='';
	$obj->shbasic='';
}


	$obj->sh=1;
	$obj->shpfnum=1;
	

if(!empty($obj->gremployeeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employeeid ";
	$obj->shemployeeid=1;
	$track++;
}

if(!empty($obj->grdeductionid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" deductionid ";
	$obj->shdeductionid=1;
	$track++;
}

if(!empty($obj->grloanid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" loanid ";
	$obj->shloanid=1;
	$track++;
}

if(!empty($obj->grmonth)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" month ";
	$obj->shmonth=1;
	$track++;
}

if(!empty($obj->grpaidon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" paidon ";
	$obj->shpaidon=1;
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

if(!empty($obj->grbasic)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" basic ";
	$obj->shbasic=1;
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



//processing columns to show

	  if(!empty($obj->shpin) ){
		array_push($sColumns, 'pinno');
		array_push($aColumns, "hrm_employees.pinno");
		$k++;
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}



	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.lastname,' ',concat(hrm_employees.middlename,' ',hrm_employees.firstname)) as employeeid");
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
		$k++;
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
	 if(!empty($obj->shpfnum) ){
		array_push($sColumns, 'pfnum');
		array_push($aColumns, "hrm_employees.pfnum");
		$k++;
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}


	if(!empty($obj->shdeductionid) ){
		array_push($sColumns, 'deductionid');
		array_push($aColumns, "hrm_deductions.name as deductionid");
		$rptjoin.=" left join hrm_deductions on hrm_deductions.id=hrm_employeepaiddeductions.deductionid ";
		$k++;
	}

	if(!empty($obj->shloanid)  or empty($obj->action)){
		array_push($sColumns, 'loanid');
		array_push($aColumns, "hrm_loans.name as loanid");
		$rptjoin.=" left join hrm_loans on hrm_loans.id=hrm_employeepaiddeductions.loanid ";
		$k++;
	}

	if(!empty($obj->shemployeepaymentid) ){
		array_push($sColumns, 'employeepaymentid');
		array_push($aColumns, "hrm_employeepaiddeductions.employeepaymentid");
		$k++;
		}

		
	if(!empty($obj->shbasic) ){
		array_push($sColumns, 'basic');
		array_push($aColumns, "(select sum(round((hrm_employeepayments.basic+hrm_employeepayments.allowances),0)) from hrm_employeepayments where hrm_employeepayments.month=hrm_employeepaiddeductions.month and hrm_employeepayments.year=hrm_employeepaiddeductions.year and hrm_employeepayments.employeeid=hrm_employeepaiddeductions.employeeid) as basic");
		$k++;
		$join=" ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
	
	if(!empty($obj->shamount) or empty($obj->action)){
		array_push($sColumns, 'amount');
		if(!empty($rptgroup))
		   array_push($aColumns, "case when sum(hrm_employeepaiddeductions.amount) is null then 0 else round(sum(hrm_employeepaiddeductions.amount),0) end amount");
		else
		  array_push($aColumns, "case when hrm_employeepaiddeductions.amount is null then 0 else round((hrm_employeepaiddeductions.amount),0) end amount");
		$k++;
		
		$mnt=$k;
		
		}
		

	if(!empty($obj->shmonth)  or empty($obj->action)){
		array_push($sColumns, 'month');
		array_push($aColumns, "hrm_employeepaiddeductions.month");
		$k++;
		}


	if(!empty($obj->shyear) ){
		array_push($sColumns, 'year');
		array_push($aColumns, "hrm_employeepaiddeductions.year");
		$k++;
		}

	if(!empty($obj->shpaidon)  or empty($obj->action)){
		array_push($sColumns, 'paidon');
		array_push($aColumns, "hrm_employeepaiddeductions.paidon");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=hrm_employeepaiddeductions.createdby";
		$k++;
		}
		
	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeepaiddeductions.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hrm_employeepaiddeductions.ipaddress");
		$k++;
		}

	if(!empty($obj->shidno)  or empty($obj->action)){
		array_push($sColumns, 'idno');
		array_push($aColumns, "hrm_employees.idno");
		$k++;
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shnssfno)  or empty($obj->action)){
		array_push($sColumns, 'nssfno');
		array_push($aColumns, "hrm_employees.nssfno");
		$k++;
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shnhifno)  or empty($obj->action)){
		array_push($sColumns, 'nhifno');
		array_push($aColumns, "hrm_employees.nhifno");
		$k++;
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
	if(!empty($obj->shdepartmentid)  or empty($obj->action)){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "hrm_departments.name as departmentid");
	
		$k++;
		
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join hrm_departments on hrm_departments.id=hrm_assignments.departmentid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	
	



$track=0;

//processing filters
if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.employeeid='$obj->employeeid'";
		$join=" left join hrm_employees on hrm_employeepaiddeductions.id=hrm_employees.employeepaiddeductionid ";
		
	$track++;
}

if(!empty($obj->deductionid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.deductionid='$obj->deductionid'";
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
		
	$track++;
}


if(!empty($obj->loanid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.loanid='$obj->loanid'";
		$join=" left join hrm_loans on hrm_employeepaiddeductions.id=hrm_loans.employeepaiddeductionid ";
		
	$track++;
}

if(!empty($obj->month)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.month='$obj->month'";
	$track++;
}

if(!empty($obj->year)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.year='$obj->year'";
	$track++;
}

if(!empty($obj->frompaidon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.paidon>='$obj->frompaidon'";
	$track++;
}

if(!empty($obj->topaidon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.paidon<='$obj->topaidon'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.createdon<='$obj->tocreatedon'";
	$track++;
}
if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_assignments.departmentid<='$obj->departmentid'";
		
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
if(!empty($obj->shemployeeid)){
	$fd.=" ,concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) ";
}
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#employeename").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
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
 <?php $_SESSION['sTable']="hrm_employeepaiddeductions";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeepaiddeductions",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			$('th:eq(1)', nRow).html("TOTAL");
			var total=0;
			for(var i=0; i<aaData.length; i++){
			  for(var j=2; j<aaData[i].length; j++){
				if(j=="<?php echo $mnt;?>"){
				  total+=Math.round(parseFloat(aaData[i][j])*Math.pow(10,0))/Math.pow(10,0);
				  $('th:eq('+j+')', nRow).html(total);
				}
				else{
				  $('th:eq('+j+')', nRow).html("");
				}
			  }
			}
		}
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
<form  action="employeepaiddeductions.php" method="post" name="employeepaiddeductions" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Deduction Name</td>
				<td>
				<select name='deductionid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$deductions=new Deductions();
				$where="  ";
				$fields="*"; 
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$deductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($deductions->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->deductionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Loan</td>
				<td>
				<select name='loanid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$loans=new Loans();
				$where="  ";
				$fields="hrm_loans.id, hrm_loans.name, hrm_loans.method, hrm_loans.incomeid, hrm_loans.description, hrm_loans.createdby, hrm_loans.createdon, hrm_loans.lasteditedby, hrm_loans.lasteditedon, hrm_loans.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($loans->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->loanid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Month</td>
				<td><select name="month" id="month" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->month==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->month==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->month==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->month==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->month==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->month==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->month==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->month==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->month==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->month==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->month==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->month==12){echo"selected";}?>>December</option>
      </select></td>
			</tr>
			<tr>
				<td>Year</td>
				<td><select name="year" id="year" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+10)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->year==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select></td>
			</tr>
			<tr>
				<td>Paid on</td>
				<td><strong>From:</strong><input type='text' id='frompaidon' size='12' name='frompaidon' readonly class="date_input" value='<?php echo $obj->frompaidon;?>'/>
							<br/><strong>To:</strong><input type='text' id='topaidon' size='12' name='topaidon' readonly class="date_input" value='<?php echo $obj->topaidon;?>'/></td>
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
			
			<tr>
				<td>Department</td>
				<td>
				<select name='departmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$departments=new Departments();
				$where="  ";
				$fields="*"; 
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
			
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='grdeductionid' value='1' <?php if(isset($_POST['grdeductionid']) ){echo"checked";}?>>&nbsp;Deduction Name</td>
			<tr>
				<td><input type='checkbox' name='grloanid' value='1' <?php if(isset($_POST['grloanid']) ){echo"checked";}?>>&nbsp;Loan</td>
				<td><input type='checkbox' name='grmonth' value='1' <?php if(isset($_POST['grmonth']) ){echo"checked";}?>>&nbsp;Month</td>
			<tr>
				<td><input type='checkbox' name='grpaidon' value='1' <?php if(isset($_POST['grpaidon']) ){echo"checked";}?>>&nbsp;Paid on</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grbasic' value='1' <?php if(isset($_POST['grbasic']) ){echo"checked";}?>>&nbsp;Gross Pay</td>
			<tr>
			<td><input type='checkbox' name='grdepartmentid' value='1' <?php if(isset($_POST['grdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			
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
			<td><input type='checkbox' name='shpin' value='1' <?php if(isset($_POST['shpin']) ){echo"checked";}?>>&nbsp;Pin No</td>
			<tr>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shdeductionid' value='1' <?php if(isset($_POST['shdeductionid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Deduction Name</td>
			<tr>
				<td><input type='checkbox' name='shloanid' value='1' <?php if(isset($_POST['shloanid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Loan</td>
				<td><input type='checkbox' name='shemployeepaymentid' value='1' <?php if(isset($_POST['shemployeepaymentid']) ){echo"checked";}?>>&nbsp;Employee payment</td>
			<tr>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
				<td><input type='checkbox' name='shmonth' value='1' <?php if(isset($_POST['shmonth'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Month</td>
			<tr>
				<td><input type='checkbox' name='shyear' value='1' <?php if(isset($_POST['shyear']) ){echo"checked";}?>>&nbsp;Year</td>
				<td><input type='checkbox' name='shpaidon' value='1' <?php if(isset($_POST['shpaidon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Paid on</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
				<td><input type='checkbox' name='shidno' value='1' <?php if(isset($_POST['shidno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;ID No.</td>
			<tr>
				<td><input type='checkbox' name='shnssfno' value='1' <?php if(isset($_POST['shnssfno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;NSSF No.</td>
				<td><input type='checkbox' name='shnhifno' value='1' <?php if(isset($_POST['shnhifno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;NHIF No.</td>
			<tr>
				
				<td><input type='checkbox' name='shbasic' value='1' <?php if(isset($_POST['shbasic']) ){echo"checked";}?>>&nbsp;Gross Pay</td>
				<td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='shpfnum' value='1' <?php if(isset($_POST['shpfnum']) ){echo"checked";}?>>&nbsp;Pf Num</td>
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
			<?php if($obj->shpin==1 ){ ?>
				<th> Pin</th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shpfnum==1  or empty($obj->action)){ ?>
				<th>Pf Num </th>
			<?php } ?>
			
 			<?php if($obj->shdeductionid==1 ){ ?>
				<th>Deduction </th>
			<?php } ?>
			<?php if($obj->shloanid==1  or empty($obj->action)){ ?>
				<th>Loan </th>
			<?php } ?>
			<?php if($obj->shemployeepaymentid==1 ){ ?>
				<th>Payment </th>
			<?php } ?>
			<?php if($obj->shbasic==1 ){ ?>
				<th> Gross Pay</th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shmonth==1  or empty($obj->action)){ ?>
				<th>Month </th>
			<?php } ?>
			<?php if($obj->shyear==1 ){ ?>
				<th>Year </th>
			<?php } ?>
			<?php if($obj->shpaidon==1  or empty($obj->action)){ ?>
				<th>Payment Date </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>Ipaddress </th>
			<?php } ?>
			<?php if($obj->shidno==1  or empty($obj->action)){ ?>
				<th> Idno</th>
			<?php } ?>
			<?php if($obj->shnssfno==1  or empty($obj->action)){ ?>
				<th> Nssfno</th>
			<?php } ?>
			<?php if($obj->shnhifno==1  or empty($obj->action)){ ?>
				<th> Nhifno</th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th> Department</th>
			<?php } ?>
			
			
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
	<tr>
			<th>#</th>
			<?php if($obj->shpin==1 ){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdeductionid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shloanid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shemployeepaymentid==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			
			<?php if($obj->shbasic==1 ){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shmonth==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shyear==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shpaidon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shidno==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shnssfno==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shnhifno==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			
			
		</tr>
	</tfoot>
</div>
</div>
</div>
</div>
</div>
