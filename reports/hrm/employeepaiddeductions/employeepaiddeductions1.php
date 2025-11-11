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
require_once("../../../modules/fn/banks/Banks_class.php");
require_once("../../../modules/hrm/employeebanks/Employeebanks_class.php");
require_once("../../../modules/hrm/bankbranches/Bankbranches_class.php");

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
	$obj->frommonth=date('m');
	$obj->tomonth=date('m');
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
if(!empty($obj->gremployeeid) or !empty($obj->grdeductionid) or !empty($obj->grmonth) or !empty($obj->grpaidon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shemployeeid='';
	$obj->shdeductionid='';
	$obj->shamount=1;
	$obj->shmonth='';
	$obj->shyear='';
	$obj->shpaidon='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
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

if(!empty($obj->grdeductionid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" deductionid ";
	$obj->shdeductionid=1;
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

//processing columns to show
	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
		$k++;
		}

	if(!empty($obj->shdeductionid)  or empty($obj->action)){
		array_push($sColumns, 'deductionid');
		array_push($aColumns, "hrm_deductions.name as deductionid");
		$rptjoin.=" left join hrm_deductions on hrm_deductions.id=hrm_employeepaiddeductions.deductionid ";
	}


	if(!empty($obj->shbankid)  or empty($obj->action)){
		array_push($sColumns, 'bankid');
		array_push($aColumns, "fn_banks.name as bankid");
		$rptjoin.=" left join fn_banks on fn_banks.id=hrm_employeepaiddeductions.bankid ";
	}

	if(!empty($obj->shemployeebankid)  or empty($obj->action)){
		array_push($sColumns, 'employeebankid');
		array_push($aColumns, "hrm_employeebanks.name as employeebankid");
		$rptjoin.=" left join hrm_employeebanks on hrm_employeebanks.id=hrm_employeepaiddeductions.employeebankid ";
	}

	if(!empty($obj->shbankbrancheid) ){
		array_push($sColumns, 'bankbrancheid');
		array_push($aColumns, "hrm_bankbranches.name as bankbrancheid");
		$rptjoin.=" left join hrm_bankbranches on hrm_bankbranches.id=hrm_employeepaiddeductions.bankbrancheid ";
	}

	if(!empty($obj->shamount)  or empty($obj->action)){
		array_push($sColumns, 'amount');
		array_push($aColumns, "hrm_employeepaiddeductions.amount");
		$k++;
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

$track=0;

//processing filters
if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.employeeid='$obj->employeeid'";
		$join=" left join hrm_employees on hrm_employeepaiddeductions.id=hrm_employees.employeepaiddeductionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->deductionid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.deductionid='$obj->deductionid'";
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaiddeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->bankid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.bankid='$obj->bankid'";
	$track++;
}

if(!empty($obj->employeebankid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.employeebankid='$obj->employeebankid'";
	$track++;
}

if(!empty($obj->bankbrancheid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaiddeductions.bankbrancheid='$obj->bankbrancheid'";
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='gremployeebankid' value='1' <?php if(isset($_POST['gremployeebankid']) ){echo"checked";}?>>&nbsp;Bank (if paid via bank)	</td>
			<tr>
				<td><input type='checkbox' name='grbankbrancheid' value='1' <?php if(isset($_POST['grbankbrancheid']) ){echo"checked";}?>>&nbsp;Bank Branch	</td>
				<td><input type='checkbox' name='grmonth' value='1' <?php if(isset($_POST['grmonth']) ){echo"checked";}?>>&nbsp;Month</td>
			<tr>
				<td><input type='checkbox' name='grpaidon' value='1' <?php if(isset($_POST['grpaidon']) ){echo"checked";}?>>&nbsp;Paid on</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
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
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shdeductionid' value='1' <?php if(isset($_POST['shdeductionid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Deduction Name</td>
			<tr>
				<td><input type='checkbox' name='shbankid' value='1' <?php if(isset($_POST['shbankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank</td>
			<tr>
				<td><input type='checkbox' name='shemployeebankid' value='1' <?php if(isset($_POST['shemployeebankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank (if paid via bank)	</td>
				<td><input type='checkbox' name='shbankbrancheid' value='1' <?php if(isset($_POST['shbankbrancheid']) ){echo"checked";}?>>&nbsp;Bank Branch	</td>
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
				<td><input type='checkbox' name='shpin' value='1' <?php if(isset($_POST['shpin']) ){echo"checked";}?>>&nbsp;Pin No</td>
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
			<?php if($obj->shdeductionid==1  or empty($obj->action)){ ?>
				<th>Deduction </th>
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
			<?php if($obj->shpin==1 ){ ?>
				<th> Pin</th>
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
