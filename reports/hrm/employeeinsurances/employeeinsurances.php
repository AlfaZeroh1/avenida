<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeeinsurances/Employeeinsurances_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/hrm/insurances/Insurances_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeeinsurances";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include "../../../head.php";

$rptwhere='';
$rptjoin='';
$track=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//processing columns to show
	if(!empty($obj->shinsuranceid)  or empty($obj->action)){
		array_push($sColumns, 'insuranceid');
		array_push($aColumns, "hrm_insurances.name as insuranceid");
		$rptjoin.=" left join hrm_insurances on hrm_insurances.id=hrm_employeeinsurances.insuranceid ";
	}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "hrm_employeeinsurances.remarks");
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "hrm_employeeinsurances.createdby");
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeeinsurances.createdon");
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hrm_employeeinsurances.ipaddress");
	}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
	}

	if(!empty($obj->shpremium) ){
		array_push($sColumns, 'premium');
		array_push($aColumns, "hrm_employeeinsurances.premium");
	}

	if(!empty($obj->shstartdate)  or empty($obj->action)){
		array_push($sColumns, 'startdate');
		array_push($aColumns, "hrm_employeeinsurances.startdate");
	}

	if(!empty($obj->shexpectedenddate) ){
		array_push($sColumns, 'expectedenddate');
		array_push($aColumns, "hrm_employeeinsurances.expectedenddate");
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->insuranceid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeinsurances.insuranceid='$obj->insuranceid'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeinsurances.employeeid='$obj->employeeid'";
	$track++;
}

if(!empty($obj->fromstartdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeinsurances.startdate>='$obj->fromstartdate'";
	$track++;
}

if(!empty($obj->tostartdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeinsurances.startdate<='$obj->tostartdate'";
	$track++;
}

if(!empty($obj->fromexpectedenddate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeinsurances.expectedenddate>='$obj->fromexpectedenddate'";
	$track++;
}

if(!empty($obj->toexpectedenddate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeinsurances.expectedenddate<='$obj->toexpectedenddate'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeinsurances.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeinsurances.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeinsurances.createdby='$obj->createdby'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grinsuranceid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" insuranceid ";
	$obj->shinsuranceid=1;
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

if(!empty($obj->gremployeeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employeeid ";
	$obj->shemployeeid=1;
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

if(!empty($obj->grexpectedenddate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" expectedenddate ";
	$obj->shexpectedenddate=1;
	$track++;
}

//Processing Joins
;$rptgroup='';
$track=0;
}
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
 <?php $_SESSION['sTable']="hrm_employeeinsurances";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeeinsurances",
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
<form  action="employeeinsurances.php" method="post" name="employeeinsurances" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Insurance Name	</td>
				<td>
				<select name='insuranceid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$insurances=new Insurances();
				$where="  ";
				$fields="hrm_insurances.id, hrm_insurances.name, hrm_insurances.remarks, hrm_insurances.createdby, hrm_insurances.createdon, hrm_insurances.lasteditedby, hrm_insurances.lasteditedon, hrm_insurances.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$insurances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($insurances->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->insuranceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Start Date</td>
				<td><strong>From:</strong><input type='text' id='fromstartdate' size='12' name='fromstartdate' readonly class="date_input" value='<?php echo $obj->fromstartdate;?>'/>
							<br/><strong>To:</strong><input type='text' id='tostartdate' size='12' name='tostartdate' readonly class="date_input" value='<?php echo $obj->tostartdate;?>'/></td>
			</tr>
			<tr>
				<td>Expected End Date</td>
				<td><strong>From:</strong><input type='text' id='fromexpectedenddate' size='12' name='fromexpectedenddate' readonly class="date_input" value='<?php echo $obj->fromexpectedenddate;?>'/>
							<br/><strong>To:</strong><input type='text' id='toexpectedenddate' size='12' name='toexpectedenddate' readonly class="date_input" value='<?php echo $obj->toexpectedenddate;?>'/></td>
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
				<td><input type='checkbox' name='grinsuranceid' value='1' <?php if(isset($_POST['grinsuranceid']) ){echo"checked";}?>>&nbsp;Insurance Name	</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='grstartdate' value='1' <?php if(isset($_POST['grstartdate']) ){echo"checked";}?>>&nbsp;Start Date</td>
				<td><input type='checkbox' name='grexpectedenddate' value='1' <?php if(isset($_POST['grexpectedenddate']) ){echo"checked";}?>>&nbsp;Expected End Date</td>
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
				<td><input type='checkbox' name='shinsuranceid' value='1' <?php if(isset($_POST['shinsuranceid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Insurance Name	</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='shpremium' value='1' <?php if(isset($_POST['shpremium']) ){echo"checked";}?>>&nbsp;Premium Paid</td>
				<td><input type='checkbox' name='shstartdate' value='1' <?php if(isset($_POST['shstartdate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Start Date</td>
			<tr>
				<td><input type='checkbox' name='shexpectedenddate' value='1' <?php if(isset($_POST['shexpectedenddate']) ){echo"checked";}?>>&nbsp;Expected End Date</td>
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
			<?php if($obj->shinsuranceid==1  or empty($obj->action)){ ?>
				<th>Insurance </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shpremium==1 ){ ?>
				<th>Premium Paid </th>
			<?php } ?>
			<?php if($obj->shstartdate==1  or empty($obj->action)){ ?>
				<th>Start Date </th>
			<?php } ?>
			<?php if($obj->shexpectedenddate==1 ){ ?>
				<th>Expected End Date </th>
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
