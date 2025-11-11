<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeepayments/Employeepayments_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/assignments/Assignments_class.php");
require_once("../../../modules/sys/paymentmodes/Paymentmodes_class.php");
require_once("../../../modules/fn/banks/Banks_class.php");
require_once("../../../modules/hrm/employeebanks/Employeebanks_class.php");
require_once("../../../modules/hrm/bankbranches/Bankbranches_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeepayments";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8771";//Report View
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
if(!empty($obj->gremployeeid) or !empty($obj->grassignmentid) or !empty($obj->grpaymentmodeid) or !empty($obj->gremployeebankid) or !empty($obj->grbankbrancheid) or !empty($obj->gryear) or !empty($obj->grmonth) or !empty($obj->grpaidon) or !empty($obj->grcreatedon) or !empty($obj->grcreatedby) ){
	$obj->shemployeeid='';
	$obj->shassignmentid='';
	$obj->shpaymentmodeid='';
	$obj->shbankid='';
	$obj->shemployeebankid='';
	$obj->shbankbrancheid='';
	$obj->shbankacc='';
	$obj->shclearingcode='';
	$obj->shref='';
	$obj->shmonth='';
	$obj->shyear='';
	$obj->shbasic='';
	$obj->shallowances='';
	$obj->shdeductions='';
	$obj->shnetpay='';
	$obj->shpaidon='';
	$obj->shcreatedon='';
	$obj->shcreatedby='';
	$obj->shipaddress='';
}


	$obj->sh=1;


if(!empty($obj->gremployeeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employeeid ";
	$obj->shemployeeid=1;
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

if(!empty($obj->grpaymentmodeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" paymentmodeid ";
	$obj->shpaymentmodeid=1;
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

if(!empty($obj->gryear)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" year ";
	$obj->shyear=1;
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

if(!empty($obj->grcreatedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdon ";
	$obj->shcreatedon=1;
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

//processing columns to show
	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hrm_employeepayments.employeeid ";
		$k++;
		}

	if(!empty($obj->shassignmentid)  or empty($obj->action)){
		array_push($sColumns, 'assignmentid');
		array_push($aColumns, "hrm_assignments.name as assignmentid");
		$rptjoin.=" left join hrm_assignments on hrm_assignments.id=hrm_employeepayments.assignmentid ";
		$k++;
		}

	if(!empty($obj->shpaymentmodeid)  or empty($obj->action)){
		array_push($sColumns, 'paymentmodeid');
		array_push($aColumns, "sys_paymentmodes.name as paymentmodeid");
		$rptjoin.=" left join sys_paymentmodes on sys_paymentmodes.id=hrm_employeepayments.paymentmodeid ";
		$k++;
		}

	if(!empty($obj->shbankid)  or empty($obj->action)){
		array_push($sColumns, 'bankid');
		array_push($aColumns, "fn_banks.name as bankid");
		$rptjoin.=" left join fn_banks on fn_banks.id=hrm_employeepayments.bankid ";
		$k++;
		}

	if(!empty($obj->shemployeebankid)  or empty($obj->action)){
		array_push($sColumns, 'employeebankid');
		array_push($aColumns, "hrm_employeebanks.name as employeebankid");
		$rptjoin.=" left join hrm_employeebanks on hrm_employeebanks.id=hrm_employeepayments.employeebankid ";
		$k++;
		}

	if(!empty($obj->shbankbrancheid) ){
		array_push($sColumns, 'bankbrancheid');
		array_push($aColumns, "hrm_bankbranches.name as bankbrancheid");
		$rptjoin.=" left join hrm_bankbranches on hrm_bankbranches.id=hrm_employeepayments.bankbrancheid ";
		$k++;
		}

	if(!empty($obj->shbankacc)  or empty($obj->action)){
		array_push($sColumns, 'bankacc');
		array_push($aColumns, "hrm_employeepayments.bankacc");
		$k++;
		}

	if(!empty($obj->shclearingcode)  or empty($obj->action)){
		array_push($sColumns, 'clearingcode');
		array_push($aColumns, "hrm_employeepayments.clearingcode");
		$k++;
		}

	if(!empty($obj->shref) ){
		array_push($sColumns, 'ref');
		array_push($aColumns, "hrm_employeepayments.ref");
		$k++;
		}

	if(!empty($obj->shmonth)  or empty($obj->action)){
		array_push($sColumns, 'month');
		array_push($aColumns, "hrm_employeepayments.month");
		$k++;
		}

	if(!empty($obj->shyear)  or empty($obj->action)){
		array_push($sColumns, 'year');
		array_push($aColumns, "hrm_employeepayments.year");
		$k++;
		}

	if(!empty($obj->shbasic)  or empty($obj->action)){
		array_push($sColumns, 'basic');
		array_push($aColumns, "hrm_employeepayments.basic");
		$k++;
		}

	if(!empty($obj->shallowances)  or empty($obj->action)){
		array_push($sColumns, 'allowances');
		array_push($aColumns, "hrm_employeepayments.allowances");
		$k++;
		}

	if(!empty($obj->shdeductions)  or empty($obj->action)){
		array_push($sColumns, 'deductions');
		array_push($aColumns, "hrm_employeepayments.deductions");
		$k++;
		}

	if(!empty($obj->shnetpay)  or empty($obj->action)){
		array_push($sColumns, 'netpay');
		array_push($aColumns, "hrm_employeepayments.netpay");
		$k++;
		
		$mnt=$k;
		}

	if(!empty($obj->shpaidon)  or empty($obj->action)){
		array_push($sColumns, 'paidon');
		array_push($aColumns, "hrm_employeepayments.paidon");
		$k++;
		}

	if(!empty($obj->shcreatedon) ){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeepayments.createdon");
		$k++;
		}

	if(!empty($obj->shcreatedby) ){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "hrm_employeepayments.createdby");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hrm_employeepayments.ipaddress");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.employeeid='$obj->employeeid'";
		$join=" left join hrm_employees on hrm_employeepayments.id=hrm_employees.employeepaymentid ";
		
	$track++;
}

if(!empty($obj->assignmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.assignmentid='$obj->assignmentid'";
		$join=" left join hrm_assignments on hrm_employeepayments.id=hrm_assignments.employeepaymentid ";
		
	$track++;
}

if(!empty($obj->paymentmodeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.paymentmodeid='$obj->paymentmodeid'";
		$join=" left join sys_paymentmodes on hrm_employeepayments.id=sys_paymentmodes.employeepaymentid ";
		
	$track++;
}

if(!empty($obj->bankid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.bankid='$obj->bankid'";
		$join=" left join fn_banks on hrm_employeepayments.id=fn_banks.employeepaymentid ";
		
	$track++;
}

if(!empty($obj->employeebankid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.employeebankid='$obj->employeebankid'";
		$join=" left join hrm_employeebanks on hrm_employeepayments.id=hrm_employeebanks.employeepaymentid ";
		
	$track++;
}

if(!empty($obj->bankbrancheid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.bankbrancheid='$obj->bankbrancheid'";
		$join=" left join hrm_bankbranches on hrm_employeepayments.id=hrm_bankbranches.employeepaymentid ";
		
	$track++;
}

if(!empty($obj->year)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.year='$obj->year'";
	$track++;
}

if(!empty($obj->month)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.month='$obj->month'";
	$track++;
}

if(!empty($obj->frompaidon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.paidon>='$obj->frompaidon'";
	$track++;
}

if(!empty($obj->topaidon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.paidon<='$obj->topaidon'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepayments.createdby='$obj->createdby'";
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
 <?php $_SESSION['sTable']="hrm_employeepayments";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
// 	 TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
	 
	 
	
				
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeepayments",
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
				  total+=parseInt(aaData[i][j]);
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
<form  action="employeepayments.php" method="post" name="employeepayments" >
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
				<td>Assignment</td>
				<td>
				<select name='assignmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$assignments=new Assignments();
				$where="  ";
				$fields="hrm_assignments.id, hrm_assignments.code, hrm_assignments.name, hrm_assignments.departmentid, hrm_assignments.levelid, hrm_assignments.doctor, hrm_assignments.remarks, hrm_assignments.createdby, hrm_assignments.createdon, hrm_assignments.lasteditedby, hrm_assignments.lasteditedon, hrm_assignments.ipaddress, hrm_assignments.sectionid";
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
				<td>Payment Mode</td>
				<td>
				<select name='paymentmodeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$paymentmodes=new Paymentmodes();
				$where="  ";
				$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.acctypeid, sys_paymentmodes.remarks";
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
			</tr>
			<tr>
				<td>Bank</td>
				<td>
				<select name='bankid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$banks=new Banks();
				$where="  ";
				$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($banks->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->bankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Bank (if paid via bank)	</td>
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
				<td>Bank Branch	</td>
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
				<td>Paid On</td>
				<td><strong>From:</strong><input type='text' id='frompaidon' size='12' name='frompaidon' readonly class="date_input" value='<?php echo $obj->frompaidon;?>'/>
							<br/><strong>To:</strong><input type='text' id='topaidon' size='12' name='topaidon' readonly class="date_input" value='<?php echo $obj->topaidon;?>'/></td>
			</tr>
			<tr>
				<td>Created On</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='grassignmentid' value='1' <?php if(isset($_POST['grassignmentid']) ){echo"checked";}?>>&nbsp;Assignment</td>
			<tr>
				<td><input type='checkbox' name='grpaymentmodeid' value='1' <?php if(isset($_POST['grpaymentmodeid']) ){echo"checked";}?>>&nbsp;Payment Mode</td>
				<td><input type='checkbox' name='gremployeebankid' value='1' <?php if(isset($_POST['gremployeebankid']) ){echo"checked";}?>>&nbsp;Bank (if paid via bank)	</td>
			<tr>
				<td><input type='checkbox' name='grbankbrancheid' value='1' <?php if(isset($_POST['grbankbrancheid']) ){echo"checked";}?>>&nbsp;Bank Branch	</td>
				<td><input type='checkbox' name='gryear' value='1' <?php if(isset($_POST['gryear']) ){echo"checked";}?>>&nbsp;Year</td>
			<tr>
				<td><input type='checkbox' name='grmonth' value='1' <?php if(isset($_POST['grmonth']) ){echo"checked";}?>>&nbsp;Month</td>
				<td><input type='checkbox' name='grpaidon' value='1' <?php if(isset($_POST['grpaidon']) ){echo"checked";}?>>&nbsp;Paid On</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
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
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shassignmentid' value='1' <?php if(isset($_POST['shassignmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Assignment</td>
			<tr>
				<td><input type='checkbox' name='shpaymentmodeid' value='1' <?php if(isset($_POST['shpaymentmodeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Payment Mode</td>
				<td><input type='checkbox' name='shbankid' value='1' <?php if(isset($_POST['shbankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank</td>
			<tr>
				<td><input type='checkbox' name='shemployeebankid' value='1' <?php if(isset($_POST['shemployeebankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank (if paid via bank)	</td>
				<td><input type='checkbox' name='shbankbrancheid' value='1' <?php if(isset($_POST['shbankbrancheid']) ){echo"checked";}?>>&nbsp;Bank Branch	</td>
			<tr>
				<td><input type='checkbox' name='shbankacc' value='1' <?php if(isset($_POST['shbankacc'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank Account	</td>
				<td><input type='checkbox' name='shclearingcode' value='1' <?php if(isset($_POST['shclearingcode'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Clearing Code</td>
			<tr>
				<td><input type='checkbox' name='shref' value='1' <?php if(isset($_POST['shref']) ){echo"checked";}?>>&nbsp;Reference</td>
				<td><input type='checkbox' name='shmonth' value='1' <?php if(isset($_POST['shmonth'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Month</td>
			<tr>
				<td><input type='checkbox' name='shyear' value='1' <?php if(isset($_POST['shyear'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Year</td>
				<td><input type='checkbox' name='shbasic' value='1' <?php if(isset($_POST['shbasic'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Basic</td>
			<tr>
				<td><input type='checkbox' name='shallowances' value='1' <?php if(isset($_POST['shallowances'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total Allowances</td>
				<td><input type='checkbox' name='shdeductions' value='1' <?php if(isset($_POST['shdeductions'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total Deductions</td>
			<tr>
				<td><input type='checkbox' name='shnetpay' value='1' <?php if(isset($_POST['shnetpay'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Netpay</td>
				<td><input type='checkbox' name='shpaidon' value='1' <?php if(isset($_POST['shpaidon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Paid On</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
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
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shassignmentid==1  or empty($obj->action)){ ?>
				<th>Assignment </th>
			<?php } ?>
			<?php if($obj->shpaymentmodeid==1  or empty($obj->action)){ ?>
				<th>Payment Mode </th>
			<?php } ?>
			<?php if($obj->shbankid==1  or empty($obj->action)){ ?>
				<th>Paying Bank </th>
			<?php } ?>
			<?php if($obj->shemployeebankid==1  or empty($obj->action)){ ?>
				<th>Bank (if Paid Via Bank) </th>
			<?php } ?>
			<?php if($obj->shbankbrancheid==1 ){ ?>
				<th>Bank Branch </th>
			<?php } ?>
			<?php if($obj->shbankacc==1  or empty($obj->action)){ ?>
				<th>Bank Account </th>
			<?php } ?>
			<?php if($obj->shclearingcode==1  or empty($obj->action)){ ?>
				<th>Clearing Code </th>
			<?php } ?>
			<?php if($obj->shref==1 ){ ?>
				<th>Reference </th>
			<?php } ?>
			<?php if($obj->shmonth==1  or empty($obj->action)){ ?>
				<th>Month </th>
			<?php } ?>
			<?php if($obj->shyear==1  or empty($obj->action)){ ?>
				<th>Year </th>
			<?php } ?>
			<?php if($obj->shbasic==1  or empty($obj->action)){ ?>
				<th>Basic </th>
			<?php } ?>
			<?php if($obj->shallowances==1  or empty($obj->action)){ ?>
				<th>Total Allowances </th>
			<?php } ?>
			<?php if($obj->shdeductions==1  or empty($obj->action)){ ?>
				<th>Total Deductions </th>
			<?php } ?>
			<?php if($obj->shnetpay==1  or empty($obj->action)){ ?>
				<th>Net Pay </th>
			<?php } ?>
			<?php if($obj->shpaidon==1  or empty($obj->action)){ ?>
				<th>Paid On </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
				<th>Created On </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>Created By </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>I.P address </th>
			<?php } ?>
			
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
	<tr>
		
			
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shassignmentid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shpaymentmodeid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shbankid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shemployeebankid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shbankbrancheid==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shbankacc==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shclearingcode==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shref==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shmonth==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shyear==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shbasic==1  or empty($obj->action)){ ?>
				<th>Basic </th>
			<?php } ?>
			<?php if($obj->shallowances==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdeductions==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shnetpay==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shpaidon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
		</tr>
	</tfoot>
</div>
</div>
</div>
</div>
</div>
