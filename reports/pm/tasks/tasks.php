<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pm/tasks/Tasks_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/wf/routes/Routes_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/pm/taskstatuss/Taskstatuss_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Tasks";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9424";//Add
$auth->levelid=$_SESSION['level'];

//auth($auth);
include "../../../head.php";

if (empty($obj->action)){
	$obj->fromstartdate=date('Y-m-d');
	$obj->tostartdate=date('Y-m-d');
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
if(!empty($obj->grname) or !empty($obj->grtasktype) or  !empty($obj->grrouteid) or !empty($obj->grprojecttype) or !empty($obj->gremployeeid) or !empty($obj->grpriority) or !empty($obj->grdeadline) or !empty($obj->grstartdate) or !empty($obj->grstatusid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shname='';
	$obj->shtasktype='';
	$obj->shdescription='';
	$obj->shrouteid='';
	$obj->shroutedetailid='';
	$obj->shemployeeid='';
	$obj->shownerid='';
	$obj->shassignmentid='';
	$obj->shdocumenttype='';
	$obj->shdocumentno='';
	$obj->shpriority='';
	$obj->shtracktime='';
	$obj->shreqduration='';
	$obj->shreqdurationtype='';
	$obj->shdeadline='';
	$obj->shstartdate='';
	$obj->shenddate='';
	$obj->shremind='';
	$obj->shskid='';
	$obj->shorigtask='';
	$obj->shstatusid='';
	$obj->shipaddress='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
}


	$obj->sh=1;


if(!empty($obj->grname)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" name ";
	$obj->shname=1;
	$track++;
}

if(!empty($obj->grtasktype)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" tasktype ";
	$obj->shtasktype=1;
	$track++;
}



if(!empty($obj->grrouteid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" routeid ";
	$obj->shrouteid=1;
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

if(!empty($obj->grpriority)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" priority ";
	$obj->shpriority=1;
	$track++;
}

if(!empty($obj->grdeadline)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" deadline ";
	$obj->shdeadline=1;
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

if(!empty($obj->grstatusid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" statusid ";
	$obj->shstatusid=1;
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
	if(!empty($obj->shname)  or empty($obj->action)){
		array_push($sColumns, 'name');
		array_push($aColumns, "pm_tasks.name");
		$k++;
		}

	if(!empty($obj->shtasktype)  or empty($obj->action)){
		array_push($sColumns, 'tasktype');
		array_push($aColumns, "pm_tasks.tasktype");
		$k++;
		}

	if(!empty($obj->shdescription)  or empty($obj->action)){
		array_push($sColumns, 'description');
		array_push($aColumns, "pm_tasks.description");
		$k++;
		}

	

	if(!empty($obj->shrouteid) ){
		array_push($sColumns, 'routeid');
		array_push($aColumns, "wf_routes.name as routeid");
		$rptjoin.=" left join wf_routes on wf_routes.id=pm_tasks.routeid ";
		$k++;
		}

	if(!empty($obj->shroutedetailid) ){
		array_push($sColumns, 'routedetailid');
		array_push($aColumns, "pm_tasks.routedetailid");
		$k++;
		}

	
	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=pm_tasks.employeeid ";
		$k++;
		}

	if(!empty($obj->shownerid)  or empty($obj->action)){
		array_push($sColumns, 'ownerid');
		array_push($aColumns, "pm_tasks.ownerid");
		
		$k++;
		}

	if(!empty($obj->shassignmentid)  or empty($obj->action)){
		array_push($sColumns, 'assignmentid');
		array_push($aColumns, "hrm_assignments.name as assignmentid");
		$rptjoin.=" left join hrm_assignments on hrm_assignments.id=pm_tasks.assignmentid ";
		$k++;
		}

	if(!empty($obj->shdocumenttype) ){
		array_push($sColumns, 'documenttype');
		array_push($aColumns, "pm_tasks.documenttype");
		$k++;
		}

	if(!empty($obj->shdocumentno) ){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "pm_tasks.documentno");
		$k++;
		}

	if(!empty($obj->shpriority)  or empty($obj->action)){
		array_push($sColumns, 'priority');
		array_push($aColumns, "pm_tasks.priority");
		$k++;
		}

	if(!empty($obj->shtracktime) ){
		array_push($sColumns, 'tracktime');
		array_push($aColumns, "pm_tasks.tracktime");
		$k++;
		}

	if(!empty($obj->shreqduration)  or empty($obj->action)){
		array_push($sColumns, 'reqduration');
		array_push($aColumns, "pm_tasks.reqduration");
		$k++;
		}

	if(!empty($obj->shreqdurationtype) ){
		array_push($sColumns, 'reqdurationtype');
		array_push($aColumns, "pm_tasks.reqdurationtype");
		$k++;
		}

	if(!empty($obj->shdeadline)  or empty($obj->action)){
		array_push($sColumns, 'deadline');
		array_push($aColumns, "pm_tasks.deadline");
		$k++;
		}

	if(!empty($obj->shstartdate)  or empty($obj->action)){
		array_push($sColumns, 'startdate');
		array_push($aColumns, "pm_tasks.startdate");
		$k++;
		}

	if(!empty($obj->shenddate)  or empty($obj->action)){
		array_push($sColumns, 'enddate');
		array_push($aColumns, "pm_tasks.enddate");
		$k++;
		}

	if(!empty($obj->shremind)  or empty($obj->action)){
		array_push($sColumns, 'remind');
		array_push($aColumns, "pm_tasks.remind");
		$k++;
		}

	if(!empty($obj->taskid) ){
		array_push($sColumns, 'skid');
		array_push($aColumns, "pm_tasks.skid");
		$k++;
		}

	if(!empty($obj->shorigtask) ){
		array_push($sColumns, 'origtask');
		array_push($aColumns, "pm_tasks.origtask");
		$k++;
		}

	if(!empty($obj->shstatusid)  or empty($obj->action)){
		array_push($sColumns, 'statusid');
		array_push($aColumns, "pm_taskstatuss.name as statusid");
		$rptjoin.=" left join pm_taskstatuss on pm_taskstatuss.id=pm_tasks.statusid ";
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "pm_tasks.ipaddress");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=pm_tasks.createdby ";
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "pm_tasks.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->name)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.name='$obj->name'";
	$track++;
}

if(!empty($obj->tasktype)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.tasktype='$obj->tasktype'";
	$track++;
}



if(!empty($obj->routeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.routeid='$obj->routeid'";
		$join=" left join wf_routes on pm_tasks.id=wf_routes.taskid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}


if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.employeeid='$obj->employeeid'";
		
	$track++;
}

if(!empty($obj->priority)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.priority='$obj->priority'";
	$track++;
}

if(!empty($obj->fromdeadline)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.deadline>='$obj->fromdeadline'";
	$track++;
}

if(!empty($obj->todeadline)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.deadline<='$obj->todeadline'";
	$track++;
}

if(!empty($obj->fromstartdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.startdate>='$obj->fromstartdate'";
	$track++;
}

if(!empty($obj->tostartdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.startdate<='$obj->tostartdate'";
	$track++;
}

if(!empty($obj->statusid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.statusid='$obj->statusid'";
		
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pm_tasks.createdon<='$obj->tocreatedon'";
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
 <?php $_SESSION['sTable']="pm_tasks";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pm_tasks",
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
<form  action="tasks.php" method="post" name="tasks" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Task Name</td>
				<td><input type='text' id='name' size='20' name='name' value='<?php echo $obj->name;?>'></td>
			</tr>
			<tr>
				<td>Task Type</td>
				<td><input type='text' id='tasktype' size='20' name='tasktype' value='<?php echo $obj->tasktype;?>'></td>
			</tr>
			
			<tr>
				<td>Route</td>
				<td>
				<select name='routeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$routes=new Routes();
				$where="  ";
				$fields="wf_routes.id, wf_routes.name, wf_routes.moduleid, wf_routes.roleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($routes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->routeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td>Priority</td>
			</tr>
			<tr>
				<td>Deadline</td>
				<td><strong>From:</strong><input type='text' id='fromdeadline' size='12' name='fromdeadline' readonly class="date_input" value='<?php echo $obj->fromdeadline;?>'/>
							<br/><strong>To:</strong><input type='text' id='todeadline' size='12' name='todeadline' readonly class="date_input" value='<?php echo $obj->todeadline;?>'/></td>
			</tr>
			<tr>
				<td>Start date</td>
				<td><strong>From:</strong><input type='text' id='fromstartdate' size='12' name='fromstartdate' readonly class="date_input" value='<?php echo $obj->fromstartdate;?>'/>
							<br/><strong>To:</strong><input type='text' id='tostartdate' size='12' name='tostartdate' readonly class="date_input" value='<?php echo $obj->tostartdate;?>'/></td>
			</tr>
			<tr>
				<td>Status</td>
				<td>
				<select name='statusid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$taskstatuss=new Taskstatuss();
				$where="  ";
				$fields="pm_taskstatuss.id, pm_taskstatuss.name, pm_taskstatuss.remarks, pm_taskstatuss.ipaddress, pm_taskstatuss.createdby, pm_taskstatuss.createdon, pm_taskstatuss.lasteditedby, pm_taskstatuss.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$taskstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($taskstatuss->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->statusid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
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
				<td><input type='checkbox' name='grname' value='1' <?php if(isset($_POST['grname']) ){echo"checked";}?>>&nbsp;Task Name</td>
				<td><input type='checkbox' name='grtasktype' value='1' <?php if(isset($_POST['grtasktype']) ){echo"checked";}?>>&nbsp;Task Type</td>
			<tr>
				
				<td><input type='checkbox' name='grrouteid' value='1' <?php if(isset($_POST['grrouteid']) ){echo"checked";}?>>&nbsp;Route</td>
			<tr>
				
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='grpriority' value='1' <?php if(isset($_POST['grpriority']) ){echo"checked";}?>>&nbsp;Priority</td>
				<td><input type='checkbox' name='grdeadline' value='1' <?php if(isset($_POST['grdeadline']) ){echo"checked";}?>>&nbsp;Deadline</td>
			<tr>
				<td><input type='checkbox' name='grstartdate' value='1' <?php if(isset($_POST['grstartdate']) ){echo"checked";}?>>&nbsp;Start date</td>
				<td><input type='checkbox' name='grstatusid' value='1' <?php if(isset($_POST['grstatusid']) ){echo"checked";}?>>&nbsp;Status</td>
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
				<td><input type='checkbox' name='shname' value='1' <?php if(isset($_POST['shname'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Task Name</td>
				<td><input type='checkbox' name='shtasktype' value='1' <?php if(isset($_POST['shtasktype'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Task Type</td>
			<tr>
				<td><input type='checkbox' name='shdescription' value='1' <?php if(isset($_POST['shdescription'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Description</td>
				
			<tr>
				<td><input type='checkbox' name='shrouteid' value='1' <?php if(isset($_POST['shrouteid']) ){echo"checked";}?>>&nbsp;Route</td>
				<td><input type='checkbox' name='shroutedetailid' value='1' <?php if(isset($_POST['shroutedetailid']) ){echo"checked";}?>>&nbsp;Route Detail</td>
			<tr>
				
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='shownerid' value='1' <?php if(isset($_POST['shownerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Owner</td>
				<td><input type='checkbox' name='shassignmentid' value='1' <?php if(isset($_POST['shassignmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Assignment</td>
			<tr>
				<td><input type='checkbox' name='shdocumenttype' value='1' <?php if(isset($_POST['shdocumenttype']) ){echo"checked";}?>>&nbsp;Documenttype</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='shpriority' value='1' <?php if(isset($_POST['shpriority'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Priority</td>
				<td><input type='checkbox' name='shtracktime' value='1' <?php if(isset($_POST['shtracktime']) ){echo"checked";}?>>&nbsp;Track time</td>
			<tr>
				<td><input type='checkbox' name='shreqduration' value='1' <?php if(isset($_POST['shreqduration'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Required Duration</td>
				<td><input type='checkbox' name='shreqdurationtype' value='1' <?php if(isset($_POST['shreqdurationtype']) ){echo"checked";}?>>&nbsp;Required Duration type</td>
			<tr>
				<td><input type='checkbox' name='shdeadline' value='1' <?php if(isset($_POST['shdeadline'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Deadline</td>
				<td><input type='checkbox' name='shstartdate' value='1' <?php if(isset($_POST['shstartdate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Start date</td>
			<tr>
				<td><input type='checkbox' name='shenddate' value='1' <?php if(isset($_POST['shenddate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;End date</td>
				<td><input type='checkbox' name='shremind' value='1' <?php if(isset($_POST['shremind'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remind</td>
			<tr>
				<td><input type='checkbox' name='taskid' value='1' <?php if(isset($_POST['taskid']) ){echo"checked";}?>>&nbsp;Task</td>
				<td><input type='checkbox' name='shorigtask' value='1' <?php if(isset($_POST['shorigtask']) ){echo"checked";}?>>&nbsp;Original Tasl</td>
			<tr>
				<td><input type='checkbox' name='shstatusid' value='1' <?php if(isset($_POST['shstatusid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Status</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created on</td>
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
			<?php if($obj->shname==1  or empty($obj->action)){ ?>
				<th>Task Name </th>
			<?php } ?>
			<?php if($obj->shtasktype==1  or empty($obj->action)){ ?>
				<th>Task Type </th>
			<?php } ?>
			<?php if($obj->shdescription==1  or empty($obj->action)){ ?>
				<th>Task Description </th>
			<?php } ?>
			<?php if($obj->shrouteid==1 ){ ?>
				<th>Route </th>
			<?php } ?>
			<?php if($obj->shroutedetailid==1 ){ ?>
				<th>Route Detail </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Responsible Person </th>
			<?php } ?>
			<?php if($obj->shownerid==1  or empty($obj->action)){ ?>
				<th>Owner </th>
			<?php } ?>
			<?php if($obj->shassignmentid==1  or empty($obj->action)){ ?>
				<th>Assignment </th>
			<?php } ?>
			<?php if($obj->shdocumenttype==1 ){ ?>
				<th>Document Type </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1 ){ ?>
				<th>Document No </th>
			<?php } ?>
			<?php if($obj->shpriority==1  or empty($obj->action)){ ?>
				<th>Priority </th>
			<?php } ?>
			<?php if($obj->shtracktime==1 ){ ?>
				<th>Track Time Spent </th>
			<?php } ?>
			<?php if($obj->shreqduration==1  or empty($obj->action)){ ?>
				<th>Required Duration </th>
			<?php } ?>
			<?php if($obj->shreqdurationtype==1 ){ ?>
				<th>Required Duration Type </th>
			<?php } ?>
			<?php if($obj->shdeadline==1  or empty($obj->action)){ ?>
				<th>Deadline </th>
			<?php } ?>
			<?php if($obj->shstartdate==1  or empty($obj->action)){ ?>
				<th>Start Date </th>
			<?php } ?>
			<?php if($obj->shenddate==1  or empty($obj->action)){ ?>
				<th>End Date </th>
			<?php } ?>
			<?php if($obj->shremind==1  or empty($obj->action)){ ?>
				<th>Remind </th>
			<?php } ?>
			<?php if($obj->taskid==1 ){ ?>
				<th>Task </th>
			<?php } ?>
			<?php if($obj->shorigtask==1 ){ ?>
				<th>Original Task </th>
			<?php } ?>
			<?php if($obj->shstatusid==1  or empty($obj->action)){ ?>
				<th>Status </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created By </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On </th>
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
