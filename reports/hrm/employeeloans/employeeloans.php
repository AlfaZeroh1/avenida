<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeeloans/Employeeloans_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/hrm/loans/Loans_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeeloans";
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
	if(!empty($obj->shloanid)  or empty($obj->action)){
		array_push($sColumns, 'loanid');
		array_push($aColumns, "hrm_loans.name as loanid");
		$rptjoin.=" left join hrm_loans on hrm_loans.id=hrm_employeeloans.loanid ";
	}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hrm_employeeloans.employeeid ";
	}

	if(!empty($obj->shprincipal)  or empty($obj->action)){
		array_push($sColumns, 'principal');
		array_push($aColumns, "hrm_employeeloans.principal");
	}

	if(!empty($obj->shmethod)  or empty($obj->action)){
		array_push($sColumns, 'method');
		array_push($aColumns, "hrm_employeeloans.method");
	}

	if(!empty($obj->shinitialvalue)  or empty($obj->action)){
		array_push($sColumns, 'initialvalue');
		array_push($aColumns, "hrm_employeeloans.initialvalue");
	}

	if(!empty($obj->shpayable)  or empty($obj->action)){
		array_push($sColumns, 'payable');
		array_push($aColumns, "hrm_employeeloans.payable");
	}

	if(!empty($obj->shduration)  or empty($obj->action)){
		array_push($sColumns, 'duration');
		array_push($aColumns, "hrm_employeeloans.duration");
	}

	if(!empty($obj->shinterest) ){
		array_push($sColumns, 'interest');
		array_push($aColumns, "hrm_employeeloans.interest");
	}

	if(!empty($obj->shmonth) ){
		array_push($sColumns, 'month');
		array_push($aColumns, "hrm_employeeloans.month");
	}

	if(!empty($obj->shyear)  or empty($obj->action)){
		array_push($sColumns, 'year');
		array_push($aColumns, "hrm_employeeloans.year");
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeeloans.createdon");
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=hrm_employeeloans.createdby";
		$k++;
		}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->loanid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.loanid='$obj->loanid'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.employeeid='$obj->employeeid'";
	$track++;
}

if(!empty($obj->fromprincipal)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.principal>='$obj->fromprincipal'";
	$track++;
}

if(!empty($obj->toprincipal)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.principal<='$obj->toprincipal'";
	$track++;
}

if(!empty($obj->principal)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.principal='$obj->principal'";
	$track++;
}

if(!empty($obj->method)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.method='$obj->method'";
	$track++;
}

if(!empty($obj->month)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.month='$obj->month'";
	$track++;
}

if(!empty($obj->year)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.year='$obj->year'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeeloans.createdby='$obj->createdby'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grloanid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" loanid ";
	$obj->shloanid=1;
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
 <?php $_SESSION['sTable']="hrm_employeeloans";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeeloans",
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
<form  action="employeeloans.php" method="post" name="employeeloans" class=''>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Loan</td>
				<td>
				<select name='loanid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$loans=new Loans();
				$where="  ";
				$fields="hrm_loans.id, hrm_loans.name, hrm_loans.method, hrm_loans.description, hrm_loans.createdby, hrm_loans.createdon, hrm_loans.lasteditedby, hrm_loans.lasteditedon, hrm_loans.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($loans->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->loanid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td>Principal</td>
				<td><strong>From:</strong><input type='text' id='fromprincipal' size='from20' name='fromprincipal' value='<?php echo $obj->fromprincipal;?>'/>
								<br/><strong>To:</strong><input type='text' id='toprincipal' size='to20' name='toprincipal' value='<?php echo $obj->toprincipal;?>'></td>
			</tr>
			<tr>
				<td>Method</td>
			</tr>
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
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from hrm_employeeloans) ";
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
				<td><input type='checkbox' name='grloanid' value='1' <?php if(isset($_POST['grloanid']) ){echo"checked";}?>>&nbsp;Loan</td>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='grmonth' value='1' <?php if(isset($_POST['grmonth']) ){echo"checked";}?>>&nbsp;Month</td>
				<td><input type='checkbox' name='gryear' value='1' <?php if(isset($_POST['gryear']) ){echo"checked";}?>>&nbsp;Year</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
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
				<td><input type='checkbox' name='shloanid' value='1' <?php if(isset($_POST['shloanid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Loan</td>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='shprincipal' value='1' <?php if(isset($_POST['shprincipal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Principal</td>
				<td><input type='checkbox' name='shmethod' value='1' <?php if(isset($_POST['shmethod'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Method</td>
			<tr>
				<td><input type='checkbox' name='shinitialvalue' value='1' <?php if(isset($_POST['shinitialvalue'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Initial Value</td>
				<td><input type='checkbox' name='shpayable' value='1' <?php if(isset($_POST['shpayable'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Payable</td>
			<tr>
				<td><input type='checkbox' name='shduration' value='1' <?php if(isset($_POST['shduration'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Duration</td>
				<td><input type='checkbox' name='shinterest' value='1' <?php if(isset($_POST['shinterest']) ){echo"checked";}?>>&nbsp;Interest</td>
			<tr>
				<td><input type='checkbox' name='shmonth' value='1' <?php if(isset($_POST['shmonth']) ){echo"checked";}?>>&nbsp;Month</td>
				<td><input type='checkbox' name='shyear' value='1' <?php if(isset($_POST['shyear'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Year</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
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
			<?php if($obj->shloanid==1  or empty($obj->action)){ ?>
				<th>Loan </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shprincipal==1  or empty($obj->action)){ ?>
				<th>Principal </th>
			<?php } ?>
			<?php if($obj->shmethod==1  or empty($obj->action)){ ?>
				<th>Method </th>
			<?php } ?>
			<?php if($obj->shinitialvalue==1  or empty($obj->action)){ ?>
				<th>Initial Value </th>
			<?php } ?>
			<?php if($obj->shpayable==1  or empty($obj->action)){ ?>
				<th>Payable </th>
			<?php } ?>
			<?php if($obj->shduration==1  or empty($obj->action)){ ?>
				<th>Duration </th>
			<?php } ?>
			<?php if($obj->shinterest==1 ){ ?>
				<th>Interest </th>
			<?php } ?>
			<?php if($obj->shmonth==1 ){ ?>
				<th>Month </th>
			<?php } ?>
			<?php if($obj->shyear==1  or empty($obj->action)){ ?>
				<th>Year </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
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
