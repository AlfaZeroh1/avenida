<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeedeductions/Employeedeductions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hrm/deductiontypes/Deductiontypes_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/hrm/employeepaiddeductions/Employeepaiddeductions_class.php");
require_once("../../../modules/hrm/deductions/Deductions_class.php");






if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeedeductions";
//connect to db
$db=new DB();

$obj=(object)$_POST;

if(empty($obj->action)){
  $obj->frommonth=date("m");
  $obj->fromyear=date("Y");
  $obj->tomonth=date("m");
  $obj->toyear=date("Y");
}

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
if(!empty($obj->grdeductionid) or !empty($obj->grdeductiontypeid) or !empty($obj->grfrommonth) or !empty($obj->grfromyear) or !empty($obj->grtomonth) or !empty($obj->grtoyear) or !empty($obj->gremployeeid) or !empty($obj->grcreatedon) or !empty($obj->grcreatedby) ){
	$obj->shdeductionid='';
	$obj->shamount='';
	$obj->shdeductiontypeid='';
	$obj->shfrommonth='';
	$obj->shfromyear='';
	$obj->shtomonth='';
	$obj->shtoyear='';
	$obj->shemployeeid='';
	$obj->shremarks='';
	$obj->shcreatedon='';
	$obj->shcreatedby='';
	$obj->shipaddress='';
	$obj->shbankacc='';
	$obj->shemployeebankid='';
	$obj->shemployeebankid='';
	
}


	$obj->sh=1;


if(!empty($obj->grdeductionid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" deductionid ";
	$obj->shdeductionid=1;
	$track++;
}

if(!empty($obj->grdeductiontypeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" deductiontypeid ";
	$obj->shdeductiontypeid=1;
	$track++;
}

if(!empty($obj->grfrommonth)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" frommonth ";
	$obj->shfrommonth=1;
	$track++;
}

if(!empty($obj->grfromyear)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" fromyear ";
	$obj->shfromyear=1;
	$track++;
}

if(!empty($obj->grtomonth)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" tomonth ";
	$obj->shtomonth=1;
	$track++;
}

if(!empty($obj->grtoyear)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" toyear ";
	$obj->shtoyear=1;
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
	if(!empty($obj->shdeductionid)  or empty($obj->action)){
		array_push($sColumns, 'deductionid');
		array_push($aColumns, "hrm_deductions.name as deductionid");
		$rptjoin.=" left join hrm_deductions on hrm_deductions.id=hrm_employeedeductions.deductionid ";
		$k++;
		}

	if(!empty($obj->shamount)  or empty($obj->action)){
		array_push($sColumns, 'amount');
		array_push($aColumns, "hrm_employeedeductions.amount");
		$k++;
		}

	if(!empty($obj->shdeductiontypeid)  or empty($obj->action)){
		array_push($sColumns, 'deductiontypeid');
		array_push($aColumns, "hrm_deductiontypes.name as deductiontypeid");
		$join=" left join hrm_deductiontypes on hrm_deductiontypes.id=hrm_employeedeductions.deductiontypeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}

	if(!empty($obj->shfrommonth)  or empty($obj->action)){
		array_push($sColumns, 'frommonth');
		array_push($aColumns, "hrm_employeedeductions.frommonth");
		$k++;
		}

	if(!empty($obj->shfromyear)  or empty($obj->action)){
		array_push($sColumns, 'fromyear');
		array_push($aColumns, "hrm_employeedeductions.fromyear");
		$k++;
		}

	if(!empty($obj->shtomonth)  or empty($obj->action)){
		array_push($sColumns, 'tomonth');
		array_push($aColumns, "hrm_employeedeductions.tomonth");
		$k++;
		}

	if(!empty($obj->shtoyear)  or empty($obj->action)){
		array_push($sColumns, 'toyear');
		array_push($aColumns, "hrm_employeedeductions.toyear");
		$k++;
		}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hrm_employeedeductions.employeeid ";
	}


	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "hrm_employeedeductions.remarks");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeedeductions.createdon");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=hrm_employeedeductions.createdby";
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hrm_employeedeductions.ipaddress");
		$k++;
		}
		
	if(!empty($obj->shbankacc)  or empty($obj->action)){
		array_push($sColumns, 'bankacc');
		array_push($aColumns, "hrm_employees.bankacc");
		$k++;
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeedeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
	if(!empty($obj->shemployeebankid)  or empty($obj->action)){
		array_push($sColumns, 'employeebankid');
		array_push($aColumns, "hrm_employeebanks.name employeebankid");
		$k++;
		
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeedeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join hrm_employeebanks on hrm_employees.employeebankid=hrm_employeebanks.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
	if(!empty($obj->shclearingcode) ){
		array_push($sColumns, 'clearingcode');
		array_push($aColumns, "hrm_bankbranches.code clearingcode");
		$k++;
		
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeedeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join hrm_bankbranches on hrm_bankbranches.id=hrm_employees.bankbrancheid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
      if(!empty($obj->shbankbrancheid)){
		array_push($sColumns, 'bankbrancheid');
		array_push($aColumns, "hrm_bankbranches.name bankbrancheid");
		$k++;
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeedeductions.employeeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join hrm_bankbranches on hrm_bankbranches.id=hrm_employees.bankbrancheid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}



$track=0;

//processing filters
if(!empty($obj->deductionid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.deductionid='$obj->deductionid'";
	$track++;
}

if(!empty($obj->fromamount)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.amount>='$obj->fromamount'";
	$track++;
}

if(!empty($obj->toamount)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.amount<='$obj->toamount'";
	$track++;
}

if(!empty($obj->deductiontypeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.deductiontypeid='$obj->deductiontypeid'";
		$join=" left join hrm_deductiontypes on hrm_deductiontypes.id=hrm_employeedeductions.deductiontypeid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->frommonth)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.frommonth='$obj->frommonth'";
	$track++;
}

if(!empty($obj->fromyear)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.fromyear='$obj->fromyear'";
	$track++;
}

if(!empty($obj->tomonth)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.tomonth='$obj->tomonth'";
	$track++;
}

if(!empty($obj->toyear)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.toyear='$obj->toyear'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.employeeid='$obj->employeeid'";
		$join=" left join hrm_employees on hrm_employeedeductions.id=hrm_employees.employeedeductionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeedeductions.createdby='$obj->createdby'";
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
 <?php $_SESSION['sTable']="hrm_employeedeductions";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	 
 	var tbl = $('#tbl').dataTable( {
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeedeductions",
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
<form  action="employeedeductions.php" method="post" name="employeedeductions" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Deduction</td>
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
				<td>Amount</td>
				<td><strong>From:</strong><input type='text' id='fromamount' size='from20' name='fromamount' value='<?php echo $obj->fromamount;?>'/>
								<br/><strong>To:</strong><input type='text' id='toamount' size='to20' name='toamount' value='<?php echo $obj->toamount;?>'></td>
			</tr>
			<tr>
				<td>Deduction Type</td>
				<td>
				<select name='deductiontypeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$deductiontypes=new Deductiontypes();
				$where="  ";
				$fields="hrm_deductiontypes.id, hrm_deductiontypes.name, hrm_deductiontypes.repeatafter, hrm_deductiontypes.remarks, hrm_deductiontypes.createdby, hrm_deductiontypes.createdon, hrm_deductiontypes.lasteditedby, hrm_deductiontypes.lasteditedon, hrm_deductiontypes.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$deductiontypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($deductiontypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->deductiontypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			</tr>
			<tr>
				<td>From Month</td>
				<td><select name="frommonth" id="frommonth" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->frommonth==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->frommonth==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->frommonth==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->frommonth==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->frommonth==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->frommonth==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->frommonth==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->frommonth==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->frommonth==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->frommonth==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->frommonth==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->frommonth==12){echo"selected";}?>>December</option>
      </select></td>
			</tr>
			<tr>
				<td>From Year</td>
				<td><select name="fromyear" id="fromyear" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+30)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->fromyear==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select></td>
			</tr>
			<tr>
				<td>To Month</td>
				<td><select name="tomonth" id="tomonth" class="selectbox">
        <option value="">Select...</option>
        <option value="1" <?php if($obj->tomonth==1){echo"selected";}?>>January</option>
        <option value="2" <?php if($obj->tomonth==2){echo"selected";}?>>February</option>
        <option value="3" <?php if($obj->tomonth==3){echo"selected";}?>>March</option>
        <option value="4" <?php if($obj->tomonth==4){echo"selected";}?>>April</option>
        <option value="5" <?php if($obj->tomonth==5){echo"selected";}?>>May</option>
        <option value="6" <?php if($obj->tomonth==6){echo"selected";}?>>June</option>
        <option value="7" <?php if($obj->tomonth==7){echo"selected";}?>>July</option>
        <option value="8" <?php if($obj->tomonth==8){echo"selected";}?>>August</option>
        <option value="9" <?php if($obj->tomonth==9){echo"selected";}?>>September</option>
        <option value="10" <?php if($obj->tomonth==10){echo"selected";}?>>October</option>
        <option value="11" <?php if($obj->tomonth==11){echo"selected";}?>>November</option>
        <option value="12" <?php if($obj->tomonth==12){echo"selected";}?>>December</option>
      </select></td>
			</tr>
			<tr>
				<td>To Year</td>
				<td><select name="toyear" id="toyear" class="selectbox">
          <option value="">Select...</option>
          <?php
  $i=date("Y")-10;
  while($i<date("Y")+30)
  {
  	?>
          <option value="<?php echo $i; ?>" <?php if($obj->toyear==$i){echo"selected";}?>><?php echo $i; ?></option>
          <?
    $i++;
  }
  ?>
        </select></td>
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
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
				<td><input type='checkbox' name='grdeductionid' value='1' <?php if(isset($_POST['grdeductionid']) ){echo"checked";}?>>&nbsp;Deduction</td>
				<td><input type='checkbox' name='grdeductiontypeid' value='1' <?php if(isset($_POST['grdeductiontypeid']) ){echo"checked";}?>>&nbsp;Deduction Type</td>
			<tr>
				<td><input type='checkbox' name='grfrommonth' value='1' <?php if(isset($_POST['grfrommonth']) ){echo"checked";}?>>&nbsp;Month From </td>
				<td><input type='checkbox' name='grfromyear' value='1' <?php if(isset($_POST['grfromyear']) ){echo"checked";}?>>&nbsp;Year From</td>
			<tr>
				<td><input type='checkbox' name='grtomonth' value='1' <?php if(isset($_POST['grtomonth']) ){echo"checked";}?>>&nbsp;Month To </td>
				<td><input type='checkbox' name='grtoyear' value='1' <?php if(isset($_POST['grtoyear']) ){echo"checked";}?>>&nbsp;Year To</td>
			<tr>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
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
				<td><input type='checkbox' name='shdeductionid' value='1' <?php if(isset($_POST['shdeductionid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Deduction</td>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shdeductiontypeid' value='1' <?php if(isset($_POST['shdeductiontypeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Deduction Type</td>
				<td><input type='checkbox' name='shfrommonth' value='1' <?php if(isset($_POST['shfrommonth'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Month From </td>
			<tr>
				<td><input type='checkbox' name='shfromyear' value='1' <?php if(isset($_POST['shfromyear'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Year From</td>
				<td><input type='checkbox' name='shtomonth' value='1' <?php if(isset($_POST['shtomonth'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Month To </td>
			<tr>
				<td><input type='checkbox' name='shtoyear' value='1' <?php if(isset($_POST['shtoyear'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Year To</td>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ip Address</td>
			<tr>
			<td><input type='checkbox' name='shbankacc' value='1' <?php if(isset($_POST['shbankacc'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank acc.</td>
			
			<td><input type='checkbox' name='shemployeebankid' value='1' <?php if(isset($_POST['shemployeebankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank .</td>
			<tr>
			<td><input type='checkbox' name='shclearingcode' value='1' <?php if(isset($_POST['shclearingcode']) ){echo"checked";}?>>&nbsp;Clearing code .</td>
			<td><input type='checkbox' name='shbankbrancheid' value='1' <?php if(isset($_POST['shbankbrancheid']) ){echo"checked";}?>>&nbsp;Branch</td>
			<tr>
				
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
			<?php if($obj->shdeductionid==1  or empty($obj->action)){ ?>
				<th>Deduction </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shdeductiontypeid==1  or empty($obj->action)){ ?>
				<th>Deduction Type </th>
			<?php } ?>
			<?php if($obj->shfrommonth==1  or empty($obj->action)){ ?>
				<th>Month Assigned </th>
			<?php } ?>
			<?php if($obj->shfromyear==1  or empty($obj->action)){ ?>
				<th>Year Assigned </th>
			<?php } ?>
			<?php if($obj->shtomonth==1  or empty($obj->action)){ ?>
				<th>Month Moved </th>
			<?php } ?>
			<?php if($obj->shtoyear==1  or empty($obj->action)){ ?>
				<th>Year Moved </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shbankacc==1  or empty($obj->action)){ ?>
				<th> Bank acc</th>
			<?php } ?>
			<?php if($obj->shemployeebankid==1  or empty($obj->action)){ ?>
				<th> Bank</th>
			<?php } ?>
			<?php if($obj->shclearingcode==1 ){ ?>
				<th> Clearing code</th>
			<?php } ?>
			<?php if($obj->shbankbrancheid==1 ){ ?>
				<th> Branch</th>
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
