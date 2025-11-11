<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeedependants/Employeedependants_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeedependants";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include "../../../head.php";

//processing filters
$rptwhere='';
$track=0;
$fds='';
$fd='';
if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeedependants.employeeid='$obj->employeeid'";
	$track++;
}

if(!empty($obj->name)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" hrm_employeedependants.name='$obj->name'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<div class="buttons"><a class="positive" href="javascript: expandCollapse('boxB','over');" style="vertical-align:text-top;">Open Popup To Filter</a></div>
<div id="boxB" class="sh" style="left: 10px; top: 63px; display: none; z-index: 500;">
<div id="box2"><div class="bar2" onmousedown="dragStart(event, 'boxB')"><span><strong>Choose Criteria</strong></span>
<a href="#" onclick="expandCollapse('boxB','over')">Close</a></div>
<form  action="employeedependants.php" method="post" name="employeedependants">
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Employee</td>
			</tr>
			<tr>
				<td>Dependant</td>
				<td><input type='text' id='name' size='0' name='name' value='<?php echo $obj->name;?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
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
				<td><input type='checkbox' name='shid' value='1' <?php if(isset($_POST['shid']) ){echo"checked";}?>>&nbsp;Id</td>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='shname' value='1' <?php if(isset($_POST['shname']) ){echo"checked";}?>>&nbsp;Dependant</td>
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
<table style="clear:both;"  class="tgrid display" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shid==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1 ){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shname==1 ){ ?>
				<th>Dependant </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$employeedependants=new Employeedependants();
		$fields="hrm_employeedependants.id, concat(hrm_employees.surname,' ', hrm_employees.othernames) as employeeid, hrm_employeedependants.name, hrm_employeedependants.dob, hrm_employeedependants.createdby, hrm_employeedependants.createdon, hrm_employeedependants.lasteditedby, hrm_employeedependants.lasteditedon".$fds.$fd;
		$join=" left join hrm_employees on hrm_employeedependants.employeeid=hrm_employees.id ";
		$having="";
		$where= " $rptwhere";
		$groupby= " $rptgroup";
		$orderby="";
		$employeedependants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$employeedependants->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if($obj->shid==1 ){ ?>
				<td><?php echo $row->id; ?></td>
			<?php } ?>
			<?php if($obj->shemployeeid==1 ){ ?>
				<td><?php echo $row->employeeid; ?></td>
			<?php } ?>
			<?php if($obj->shname==1 ){ ?>
				<td><?php echo $row->name; ?></td>
			<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</div>
</div>
</div>
</div>
</div>
