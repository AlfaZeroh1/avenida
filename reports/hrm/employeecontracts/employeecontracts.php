<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeecontracts/Employeecontracts_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/hrm/contracttypes/Contracttypes_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeecontracts";
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
	if(!empty($obj->shcontracttypeid)  or empty($obj->action)){
		array_push($sColumns, 'contracttypeid');
		array_push($aColumns, "hrm_contracttypes.name as contracttypeid");
		$rptjoin.=" left join hrm_contracttypes on hrm_contracttypes.id=hrm_employeecontracts.contracttypeid ";
	}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "hrm_employeecontracts.remarks");
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.= "left join auth_users on auth_users.id=hrm_employeecontracts.createdby";
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeecontracts.createdon");
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hrm_employeecontracts.ipaddress");
	}

	if(!empty($obj->shstartdate)  or empty($obj->action)){
		array_push($sColumns, 'startdate');
		array_push($aColumns, "hrm_employeecontracts.startdate");
	}

	if(!empty($obj->shstatus)  or empty($obj->action)){
		array_push($sColumns, 'status');
		array_push($aColumns, "hrm_employeecontracts.status");
	}
	
	if(!empty($obj->shconfirmationdate) ){
		array_push($sColumns, 'confirmationdate');
		array_push($aColumns, "hrm_employeecontracts.confirmationdate");
	}

	if(!empty($obj->shprobation)  or empty($obj->action)){
		array_push($sColumns, 'probation');
		array_push($aColumns, "hrm_employeecontracts.probation");
	}

	if(!empty($obj->shcontractperiod)  or empty($obj->action)){
		array_push($sColumns, 'contractperiod');
		array_push($aColumns, "hrm_employeecontracts.contractperiod");
	}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hrm_employeecontracts.employeeid ";
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->contracttypeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.contracttypeid='$obj->contracttypeid'";
	$track++;
}

if(!empty($obj->fromstartdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.startdate>='$obj->fromstartdate'";
	$track++;
}

if(!empty($obj->tostartdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.startdate<='$obj->tostartdate'";
	$track++;
}

if(!empty($obj->fromcontractperiod)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.contractperiod>='$obj->fromcontractperiod'";
	$track++;
}

if(!empty($obj->tocontractperiod)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.contractperiod<='$obj->tocontractperiod'";
	$track++;
}

if(!empty($obj->contractperiod)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.contractperiod='$obj->contractperiod'";
	$track++;
}

if(!empty($obj->status)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.status='$obj->status'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.employeeid='$obj->employeeid'";
	$track++;
}

if(!empty($obj->fromconfirmationdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.confirmationdate>='$obj->fromconfirmationdate'";
	$track++;
}

if(!empty($obj->toconfirmationdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.confirmationdate<='$obj->toconfirmationdate'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeecontracts.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grcontracttypeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" contracttypeid ";
	$obj->shcontracttypeid=1;
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

if(!empty($obj->grstartdate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" startdate ";
	$obj->shstartdate=1;
	$track++;
}

if(!empty($obj->grconfirmationdate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" confirmationdate ";
	$obj->shconfirmationdate=1;
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
 <?php $_SESSION['sTable']="hrm_employeecontracts";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeecontracts",
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
<form  action="employeecontracts.php" method="post" name="employeecontracts" class=''>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Contract Type	</td>
				<td>
				<select name='contracttypeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$contracttypes=new Contracttypes();
				$where="  ";
				$fields="hrm_contracttypes.id, hrm_contracttypes.name, hrm_contracttypes.remarks, hrm_contracttypes.createdby, hrm_contracttypes.createdon, hrm_contracttypes.lasteditedby, hrm_contracttypes.lasteditedon, hrm_contracttypes.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$contracttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($contracttypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->contracttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Start Date </td>
				<td><strong>From:</strong><input type='text' id='fromstartdate' size='12' name='fromstartdate' readonly class="date_input" value='<?php echo $obj->fromstartdate;?>'/>
							<br/><strong>To:</strong><input type='text' id='tostartdate' size='12' name='tostartdate' readonly class="date_input" value='<?php echo $obj->tostartdate;?>'/></td>
			</tr>
			<tr>
				<td>Contract Period (Months)</td>
				<td><strong>From:</strong><input type='text' id='fromcontractperiod' size='from20' name='fromcontractperiod' value='<?php echo $obj->fromcontractperiod;?>'/>
								<br/><strong>To:</strong><input type='text' id='tocontractperiod' size='to20' name='tocontractperiod' value='<?php echo $obj->tocontractperiod;?>'></td>
			</tr>
			<tr>
				<td>Status</td>
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Confirmation Date </td>
				<td><strong>From:</strong><input type='text' id='fromconfirmationdate' size='12' name='fromconfirmationdate' readonly class="date_input" value='<?php echo $obj->fromconfirmationdate;?>'/>
							<br/><strong>To:</strong><input type='text' id='toconfirmationdate' size='12' name='toconfirmationdate' readonly class="date_input" value='<?php echo $obj->toconfirmationdate;?>'/></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from employeecontracts) ";
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grcontracttypeid' value='1' <?php if(isset($_POST['grcontracttypeid']) ){echo"checked";}?>>&nbsp;Contract Type	</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grstartdate' value='1' <?php if(isset($_POST['grstartdate']) ){echo"checked";}?>>&nbsp;Start Date</td>
			<tr>
				<td><input type='checkbox' name='grconfirmationdate' value='1' <?php if(isset($_POST['grconfirmationdate']) ){echo"checked";}?>>&nbsp;Confirmation Date </td>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
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
				<td><input type='checkbox' name='shcontracttypeid' value='1' <?php if(isset($_POST['shcontracttypeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Contract Type	</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
				<td><input type='checkbox' name='shstartdate' value='1' <?php if(isset($_POST['shstartdate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Start Date</td>
			<tr>
				<td><input type='checkbox' name='shconfirmationdate' value='1' <?php if(isset($_POST['shconfirmationdate']) ){echo"checked";}?>>&nbsp;Confirmation Date </td>
				<td><input type='checkbox' name='shprobation' value='1' <?php if(isset($_POST['shprobation'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Probation (Months) </td>
			<tr>
				<td><input type='checkbox' name='shcontractperiod' value='1' <?php if(isset($_POST['shcontractperiod'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Contract Period (Months)</td>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='shstatus' value='1' <?php if(isset($_POST['shstatus'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Status</td>
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
			<?php if($obj->shcontracttypeid==1  or empty($obj->action)){ ?>
				<th>Contract Type </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created by</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created on</th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>Ip Address</th>
			<?php } ?>
			<?php if($obj->shstartdate==1  or empty($obj->action)){ ?>
				<th>Start Date </th>
			<?php } ?>
			<?php if($obj->shconfirmationdate==1 ){ ?>
				<th>Confirmation Date </th>
			<?php } ?>
			<?php if($obj->shprobation==1  or empty($obj->action)){ ?>
				<th>Probation (Months) </th>
			<?php } ?>
			<?php if($obj->shcontractperiod==1  or empty($obj->action)){ ?>
				<th>Contract Period (Months) </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shstatus==1  or empty($obj->action)){ ?>
				<th>Status </th>
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
