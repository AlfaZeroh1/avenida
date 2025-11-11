<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeequalifications/Employeequalifications_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/qualifications/Qualifications_class.php");
require_once("../../../modules/hrm/gradings/Gradings_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeequalifications";
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
	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hrm_employeequalifications.employeeid ";
	}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "hrm_employeequalifications.remarks");
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=hrm_employeequalifications.createdby";
		$k++;
	}
	
	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeequalifications.createdon");
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hrm_employeequalifications.ipaddress");
	}

	if(!empty($obj->shqualificationid)  or empty($obj->action)){
		array_push($sColumns, 'qualificationid');
		array_push($aColumns, "hrm_qualifications.name as qualificationid");
		$rptjoin.=" left join hrm_qualifications on hrm_qualifications.id=hrm_employeequalifications.qualificationid ";
	}

	if(!empty($obj->shgradingid)  or empty($obj->action)){
		array_push($sColumns, 'gradingid');
		array_push($aColumns, "hrm_gradings.name as gradingid");
		$rptjoin.=" left join hrm_gradings on hrm_gradings.id=hrm_employeequalifications.gradingid ";
	}

	if(!empty($obj->shtitle) ){
		array_push($sColumns, 'title');
		array_push($aColumns, "hrm_employeequalifications.title");
	}

	if(!empty($obj->shinstitution)){
		array_push($sColumns, 'institution');
		array_push($aColumns, "hrm_employeequalifications.institution");
	}

if($obj->action=='Filter'){
//processing filters
if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeequalifications.employeeid='$obj->employeeid'";
	$track++;
}

if(!empty($obj->qualificationid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeequalifications.qualificationid='$obj->qualificationid'";
	$track++;
}

if(!empty($obj->gradingid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeequalifications.gradingid='$obj->gradingid'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeequalifications.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeequalifications.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeequalifications.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
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

if(!empty($obj->grqualificationid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" qualificationid ";
	$obj->shqualificationid=1;
	$track++;
}

if(!empty($obj->grgradingid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" gradingid ";
	$obj->shgradingid=1;
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
 <?php $_SESSION['sTable']="hrm_employeequalifications";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeequalifications",
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
<form  action="employeequalifications.php" method="post" name="employeequalifications" class=''>
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
				<td>Qualification</td>
				<td>
				<select name='qualificationid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$qualifications=new Qualifications();
				$where="  ";
				$fields="hrm_qualifications.id, hrm_qualifications.name, hrm_qualifications.remarks, hrm_qualifications.createdby, hrm_qualifications.createdon, hrm_qualifications.lasteditedby, hrm_qualifications.lasteditedon, hrm_qualifications.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$qualifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($qualifications->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->qualificationid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Grade</td>
				<td>
				<select name='gradingid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$gradings=new Gradings();
				$where="  ";
				$fields="hrm_gradings.id, hrm_gradings.name, hrm_gradings.remarks, hrm_gradings.ipaddress, hrm_gradings.createdby, hrm_gradings.createdon, hrm_gradings.lasteditedby, hrm_gradings.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$gradings->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($gradings->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->gradingid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				$where=" where auth_users.id in(select createdby from employeequalifications) ";
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
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grqualificationid' value='1' <?php if(isset($_POST['grqualificationid']) ){echo"checked";}?>>&nbsp;Qualification</td>
			<tr>
				<td><input type='checkbox' name='grgradingid' value='1' <?php if(isset($_POST['grgradingid']) ){echo"checked";}?>>&nbsp;Grade</td>
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
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
				<td><input type='checkbox' name='shqualificationid' value='1' <?php if(isset($_POST['shqualificationid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Qualification</td>
			<tr>
				<td><input type='checkbox' name='shtitle' value='1' <?php if(isset($_POST['shtitle']) ){echo"checked";}?>>&nbsp;Title</td>
				<td><input type='checkbox' name='shinstitution' value='1' <?php if(isset($_POST['shinstitution'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Qualification</td>
			<tr>
				<td><input type='checkbox' name='shgradingid' value='1' <?php if(isset($_POST['shgradingid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Grade</td>
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
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee</th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks</th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created by</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created on</th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>Ip  Address</th>
			<?php } ?>
			<?php if($obj->shqualificationid==1  or empty($obj->action)){ ?>
				<th>Qualification </th>
			<?php } ?>
			<?php if($obj->shgradingid==1  or empty($obj->action)){ ?>
				<th>Grade </th>
			<?php } ?>
			<?php if($obj->shtitle==1 ){ ?>
				<th> Title</th>
			<?php } ?>
			<?php if($obj->shinstitution==1 ){ ?>
				<th>Institution </th>
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
