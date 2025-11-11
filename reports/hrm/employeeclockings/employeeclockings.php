<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeeclockings/Employeeclockings_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeeclockings";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9005";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromtoday=date('Y-m-d');
	$obj->totoday=date('Y-m-d');
	

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
if(!empty($obj->gremployeeid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shemployeeid='';
	$obj->shtoday='';
	$obj->shstarttime='';
	$obj->shremarks='';
	$obj->shendtime='';
	$obj->shtoday='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
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
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hrm_employeeclockings.employeeid ";
		$k++;
		}

	if(!empty($obj->shtoday)  or empty($obj->action)){
		array_push($sColumns, 'today');
		array_push($aColumns, "hrm_employeeclockings.today");
		$k++;
		}

	if(!empty($obj->shstarttime)  or empty($obj->action)){
		array_push($sColumns, 'starttime');
		array_push($aColumns, "hrm_employeeclockings.starttime");
		$k++;
		}

	if(!empty($obj->shremarks)  or empty($obj->action)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "hrm_employeeclockings.remarks");
		$k++;
		}

	if(!empty($obj->shendtime)  or empty($obj->action)){
		array_push($sColumns, 'endtime');
		array_push($aColumns, "hrm_employeeclockings.endtime");
		$k++;
		}

	if(!empty($obj->shtoday)  or empty($obj->action)){
		array_push($sColumns, 'today');
		array_push($aColumns, "hrm_employeeclockings.today");
		$k++;
		}
if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=hrm_employeeclockings.createdby";
		$k++;
		}

	if(!empty($obj->shcreatedon) ){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeeclockings.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeclockings.employeeid='$obj->employeeid'";
		$join=" left join hrm_employees on hrm_employeeclockings.id=hrm_employees.employeeclockingid ";
		
	$track++;
}

if(!empty($obj->fromtoday)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeclockings.today>='$obj->fromtoday'";
	$track++;
}

if(!empty($obj->totoday)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeclockings.today<='$obj->totoday'";
	$track++;
}

if(!empty($obj->starttime)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeclockings.starttime='$obj->starttime'";
	$track++;
}

if(!empty($obj->remarks)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeclockings.remarks='$obj->remarks'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeclockings.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeclockings.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeclockings.createdon<='$obj->tocreatedon'";
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
 <?php $_SESSION['sTable']="hrm_employeeclockings";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeeclockings",
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
<form  action="employeeclockings.php" method="post" name="employeeclockings" >
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
				<td>Date</td>
				<td><strong>From:</strong><input type='text' id='fromtoday' size='8' name='fromtoday' readonly class="date_input" value='<?php echo $obj->fromtoday;?>'/>
							<br/><strong>To:</strong><input type='text' id='totoday' size='8' name='totoday' readonly class="date_input" value='<?php echo $obj->totoday;?>'/></td>
			</tr>
			<tr>
				<td>Time</td>
				<td><input type='text' id='starttime' size='8' name='starttime' value='<?php echo $obj->starttime;?>'></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><input type='text' id='remarks' size='8' name='remarks' value='<?php echo $obj->remarks;?>'></td>
			</tr>
			<tr>
				<td>Created by</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from employeeclockings) ";
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
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
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
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shtoday' value='1' <?php if(isset($_POST['shtoday'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Date</td>
			<tr>
				<td><input type='checkbox' name='shstarttime' value='1' <?php if(isset($_POST['shstarttime'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Time</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Status</td>
			<tr>
				<td><input type='checkbox' name='shendtime' value='1' <?php if(isset($_POST['shendtime'])  or empty($obj->action)){echo"checked";}?>>&nbsp;End time</td>
				<td><input type='checkbox' name='shtoday' value='1' <?php if(isset($_POST['shtoday'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Today</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
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
			<?php if($obj->shtoday==1  or empty($obj->action)){ ?>
				<th>Today Is? </th>
			<?php } ?>
			<?php if($obj->shstarttime==1  or empty($obj->action)){ ?>
				<th>Start Time </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shendtime==1  or empty($obj->action)){ ?>
				<th>End Time </th>
			<?php } ?>
			<?php if($obj->shtoday==1  or empty($obj->action)){ ?>
				<th>Today Is? </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created By </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
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
