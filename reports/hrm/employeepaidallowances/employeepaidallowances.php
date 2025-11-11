<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeepaidallowances/Employeepaidallowances_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hrm/allowances/Allowances_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/hrm/departments/Departments_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeepaidallowances";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9438";//Report View
$auth->levelid=$_SESSION['level'];

//auth($auth);
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
if(!empty($obj->grallowanceid) or !empty($obj->gremployeeid) or !empty($obj->grhours) or !empty($obj->grmonth) or !empty($obj->gryear) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->grdepartmentid) ){
	$obj->shallowanceid='';
	$obj->shemployeeid='';
	$obj->shovertimeid='';
	$obj->shhours='';
	$obj->shamount='';
	$obj->shmonth='';
	$obj->shyear='';
	$obj->shdepartmentid='';
	$obj->shcreatedby='';
	$obj->shipaddress='';
	$obj->shcreatedon='';
}


	$obj->sh=1;
	$obj->shamount=1;


if(!empty($obj->grallowanceid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" allowanceid ";
	$obj->shallowanceid=1;
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

if(!empty($obj->grhours)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" hours ";
	$obj->shhours=1;
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

if(!empty($obj->gryear)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" year ";
	$obj->shyear=1;
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
	

	if(!empty($obj->shallowanceid)  or empty($obj->action)){
		array_push($sColumns, 'allowanceid');
		array_push($aColumns, "hrm_allowances.name as allowanceid");
		$rptjoin.=" left join hrm_allowances on hrm_allowances.id=hrm_employeepaidallowances.allowanceid ";
		$k++;
		}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hrm_employeepaidallowances.employeeid ";
		$k++;
		}

	if(!empty($obj->shovertimeid)  or empty($obj->action)){
		array_push($sColumns, 'overtimeid');
		array_push($aColumns, "hrm_employeepaidallowances.overtimeid");
		$k++;
		}

	if(!empty($obj->shhours)  or empty($obj->action)){
		array_push($sColumns, 'hours');
		array_push($aColumns, "hrm_employeepaidallowances.hours");
		$k++;
		}

	if(!empty($obj->shamount) or empty($obj->action)){
		array_push($sColumns, 'amount');
		if(!empty($rptgroup))
		   array_push($aColumns, "case when sum(hrm_employeepaidallowances.amount) is null then 0 else round(sum(hrm_employeepaidallowances.amount),0) end amount");
		else
		  array_push($aColumns, "case when hrm_employeepaidallowances.amount is null then 0 else round((hrm_employeepaidallowances.amount),0) end amount");
		$k++;
		
		$mnt=$k;
		
		}

	if(!empty($obj->shmonth)  or empty($obj->action)){
		array_push($sColumns, 'month');
		array_push($aColumns, "hrm_employeepaidallowances.month");
		$k++;
		}

	if(!empty($obj->shyear)  or empty($obj->action)){
		array_push($sColumns, 'year');
		array_push($aColumns, "hrm_employeepaidallowances.year");
		$k++;
		}
		
		if(!empty($obj->shdepartmentid)  or empty($obj->action)){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "hrm_departments.name as departmentid");
	
		$k++;
		
		$join=" left join hrm_employees on hrm_employees.id=hrm_employeepaidallowances.employeeid ";
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


	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=hrm_employeepaidallowances.createdby";
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hrm_employeepaidallowances.ipaddress");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeepaidallowances.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->allowanceid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaidallowances.allowanceid='$obj->allowanceid'";
		$join=" left join hrm_allowances on hrm_employeepaidallowances.id=hrm_allowances.employeepaidallowanceid ";
		$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaidallowances.employeeid='$obj->employeeid'";
		$join=" left join hrm_employees  on hrm_employeepaidallowances.id=hrm_employees .employeepaidallowanceid ";
		$track++;
}

if(!empty($obj->hours)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaidallowances.hours='$obj->hours'";
	$track++;
}

if(!empty($obj->month)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaidallowances.month='$obj->month'";
	$track++;
}

if(!empty($obj->year)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaidallowances.year='$obj->year'";
	$track++;
}

if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_assignments.departmentid<='$obj->departmentid'";
		
	$track++;
}

if(!empty($obj->frompaidon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaidallowances.paidon>='$obj->frompaidon'";
	$track++;
}

if(!empty($obj->topaidon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaidallowances.paidon<='$obj->topaidon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeepaidallowances.createdby='$obj->createdby'";
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
	source:"../../../modules/server/server/search.php?main=hrm&module=employees &field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
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
 <?php $_SESSION['sTable']="hrm_employeepaidallowances";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeepaidallowances",
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
<form  action="employeepaidallowances.php" method="post" name="employeepaidallowances" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Allowance</td>
				<td>
				<select name='allowanceid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$allowances=new Allowances();
				$where="  ";
				$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowances.allowancetypeid, hrm_allowances.expenseid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon, hrm_allowances.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($allowances->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->allowanceid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td>Hours</td>
				<td><input type='text' id='hours' size='0' name='hours' value='<?php echo $obj->hours;?>'></td>
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
			<tr>
				<td>Paidon</td>
				<td><strong>From:</strong><input type='text' id='frompaidon' size='12' name='frompaidon' readonly class="date_input" value='<?php echo $obj->frompaidon;?>'/>
							<br/><strong>To:</strong><input type='text' id='topaidon' size='12' name='topaidon' readonly class="date_input" value='<?php echo $obj->topaidon;?>'/></td>
			</tr>
			<tr>
				<td>Created by</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from hrm_employeepaidallowances) ";
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grallowanceid' value='1' <?php if(isset($_POST['grallowanceid']) ){echo"checked";}?>>&nbsp;Allowance</td>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='grhours' value='1' <?php if(isset($_POST['grhours']) ){echo"checked";}?>>&nbsp;Hours</td>
				<td><input type='checkbox' name='grmonth' value='1' <?php if(isset($_POST['grmonth']) ){echo"checked";}?>>&nbsp;Month</td>
			<tr>
				<td><input type='checkbox' name='gryear' value='1' <?php if(isset($_POST['gryear']) ){echo"checked";}?>>&nbsp;Year</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
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
				
				<td><input type='checkbox' name='shallowanceid' value='1' <?php if(isset($_POST['shallowanceid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Allowance</td>
			<tr>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shovertimeid' value='1' <?php if(isset($_POST['shovertimeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Overtime</td>
			<tr>
				<td><input type='checkbox' name='shhours' value='1' <?php if(isset($_POST['shhours'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Hours</td>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shmonth' value='1' <?php if(isset($_POST['shmonth'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Month</td>
				<td><input type='checkbox' name='shyear' value='1' <?php if(isset($_POST['shyear'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Year</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ip Address</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created on</td>
			<tr>
			<td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
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
			
			<?php if($obj->shallowanceid==1  or empty($obj->action)){ ?>
				<th>Allowance </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shovertimeid==1  or empty($obj->action)){ ?>
				<th>Overtime </th>
			<?php } ?>
			<?php if($obj->shhours==1  or empty($obj->action)){ ?>
				<th>Hours</th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shmonth==1  or empty($obj->action)){ ?>
				<th>Month </th>
			<?php } ?>
			<?php if($obj->shyear==1  or empty($obj->action)){ ?>
				<th>Year </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th> Department</th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th> Ip Address</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
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
