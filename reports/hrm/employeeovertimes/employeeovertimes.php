<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeeovertimes/Employeeovertimes_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hrm/overtimes/Overtimes_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeeovertimes";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9397";//Add
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
if(!empty($obj->gremployeeid) or !empty($obj->grovertimeid) or !empty($obj->grfromdate) or !empty($obj->grtodate) or !empty($obj->grmonth) or !empty($obj->gryear) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shemployeeid='';
	$obj->shovertimeid='';
	$obj->shhours='';
	$obj->shfromdate='';
	$obj->shtodate='';
	$obj->shmonth='';
	$obj->shyear='';
	$obj->shremarks='';
	$obj->shipaddress='';
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

if(!empty($obj->grovertimeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" overtimeid ";
	$obj->shovertimeid=1;
	$track++;
}

if(!empty($obj->grfromdate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" fromdate ";
	$obj->shfromdate=1;
	$track++;
}

if(!empty($obj->grtodate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" todate ";
	$obj->shtodate=1;
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

if(!empty($rptgroup)){
  $obj->shhours=1;
}

//processing columns to show
	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hrm_employeeovertimes.employeeid ";
		$k++;
		}

	if(!empty($obj->shovertimeid)  or empty($obj->action)){
		array_push($sColumns, 'overtimeid');
		array_push($aColumns, "hrm_overtimes.name as overtimeid");
		$rptjoin.=" left join hrm_overtimes on hrm_overtimes.id=hrm_employeeovertimes.overtimeid ";
		$k++;
		}

	if(!empty($obj->shhours)  or empty($obj->action)){
		array_push($sColumns, 'hours');
		if(empty($rptgroup))
		  array_push($aColumns, "hrm_employeeovertimes.hours");
		else
		  array_push($aColumns, "sum(hrm_employeeovertimes.hours) hours");
		$k++;
		}

	if(!empty($obj->shfromdate)  or empty($obj->action)){
		array_push($sColumns, 'fromdate');
		array_push($aColumns, "hrm_employeeovertimes.fromdate");
		$k++;
		}

	if(!empty($obj->shtodate)  or empty($obj->action)){
		array_push($sColumns, 'todate');
		array_push($aColumns, "hrm_employeeovertimes.todate");
		$k++;
		}

	if(!empty($obj->shmonth)  or empty($obj->action)){
		array_push($sColumns, 'month');
		array_push($aColumns, "hrm_employeeovertimes.month");
		$k++;
		}

	if(!empty($obj->shyear)  or empty($obj->action)){
		array_push($sColumns, 'year');
		array_push($aColumns, "hrm_employeeovertimes.year");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "hrm_employeeovertimes.remarks");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hrm_employeeovertimes.ipaddress");
		$k++;
		}

	
	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=hrm_employeeovertimes.createdby";
		$k++;
		}

	if(!empty($obj->shcreatedon) ){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeeovertimes.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.employeeid='$obj->employeeid'";
	$track++;
}

if(!empty($obj->overtimeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.overtimeid='$obj->overtimeid'";
		
	$track++;
}

if(!empty($obj->fromfromdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.fromdate>='$obj->fromfromdate'";
	$track++;
}

if(!empty($obj->tofromdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.fromdate<='$obj->tofromdate'";
	$track++;
}

if(!empty($obj->fromtodate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.todate>='$obj->fromtodate'";
	$track++;
}

if(!empty($obj->totodate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.todate<='$obj->totodate'";
	$track++;
}

if(!empty($obj->month)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.month='$obj->month'";
	$track++;
}

if(!empty($obj->year)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.year='$obj->year'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeovertimes.createdon<='$obj->tocreatedon'";
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
	source:"../../../modules/server/server/search.php?main=&module=&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
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
 <?php $_SESSION['sTable']="hrm_employeeovertimes";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeeovertimes",
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
<form  action="employeeovertimes.php" method="post" name="employeeovertimes" >
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
				<td>Overtime</td>
				<td>
				<select name='overtimeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$overtimes=new Overtimes();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($overtimes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->overtimeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>From date</td>
				<td><strong>From:</strong><input type='text' id='fromfromdate' size='12' name='fromfromdate' readonly class="date_input" value='<?php echo $obj->fromfromdate;?>'/>
							<br/><strong>To:</strong><input type='text' id='tofromdate' size='12' name='tofromdate' readonly class="date_input" value='<?php echo $obj->tofromdate;?>'/></td>
			</tr>
			<tr>
				<td>To date</td>
				<td><strong>From:</strong><input type='text' id='fromtodate' size='12' name='fromtodate' readonly class="date_input" value='<?php echo $obj->fromtodate;?>'/>
							<br/><strong>To:</strong><input type='text' id='totodate' size='12' name='totodate' readonly class="date_input" value='<?php echo $obj->totodate;?>'/></td>
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
				<td>Created by</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from hrm_employeeovertimes) ";
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
				<td><input type='checkbox' name='grovertimeid' value='1' <?php if(isset($_POST['grovertimeid']) ){echo"checked";}?>>&nbsp;Overtime</td>
			<tr>
				<td><input type='checkbox' name='grfromdate' value='1' <?php if(isset($_POST['grfromdate']) ){echo"checked";}?>>&nbsp;From date</td>
				<td><input type='checkbox' name='grtodate' value='1' <?php if(isset($_POST['grtodate']) ){echo"checked";}?>>&nbsp;To date</td>
			<tr>
				<td><input type='checkbox' name='grmonth' value='1' <?php if(isset($_POST['grmonth']) ){echo"checked";}?>>&nbsp;Month</td>
				<td><input type='checkbox' name='gryear' value='1' <?php if(isset($_POST['gryear']) ){echo"checked";}?>>&nbsp;Year</td>
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
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shovertimeid' value='1' <?php if(isset($_POST['shovertimeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Overtime</td>
			<tr>
				<td><input type='checkbox' name='shhours' value='1' <?php if(isset($_POST['shhours'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Hours</td>
				<td><input type='checkbox' name='shfromdate' value='1' <?php if(isset($_POST['shfromdate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;From date</td>
			<tr>
				<td><input type='checkbox' name='shtodate' value='1' <?php if(isset($_POST['shtodate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;To date</td>
				<td><input type='checkbox' name='shmonth' value='1' <?php if(isset($_POST['shmonth'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Month</td>
			<tr>
				<td><input type='checkbox' name='shyear' value='1' <?php if(isset($_POST['shyear'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Year</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
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
			<?php if($obj->shovertimeid==1  or empty($obj->action)){ ?>
				<th>Overtime Type </th>
			<?php } ?>
			<?php if($obj->shhours==1  or empty($obj->action)){ ?>
				<th>Hours </th>
			<?php } ?>
			<?php if($obj->shfromdate==1  or empty($obj->action)){ ?>
				<th>Date From </th>
			<?php } ?>
			<?php if($obj->shtodate==1  or empty($obj->action)){ ?>
				<th>To Date </th>
			<?php } ?>
			<?php if($obj->shmonth==1  or empty($obj->action)){ ?>
				<th>Month Payable </th>
			<?php } ?>
			<?php if($obj->shyear==1  or empty($obj->action)){ ?>
				<th>Year Payable </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
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
