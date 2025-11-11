<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hrm/employeesurchages/Employeesurchages_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/hrm/surchages/Surchages_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/hrm/surchagetypes/Surchagetypes_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Employeesurchages";
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
	if(!empty($obj->shsurchageid)  or empty($obj->action)){
		array_push($sColumns, 'surchageid');
		array_push($aColumns, "hrm_surchages.name as surchageid");
		$rptjoin.=" left join hrm_surchages on hrm_surchages.id=hrm_employeesurchages.surchageid ";
	}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=hrm_employeesurchages.employeeid ";
	}

	if(!empty($obj->shsurchagetypeid)  or empty($obj->action)){
		array_push($sColumns, 'surchagetypeid');
		array_push($aColumns, "hrm_surchagetypes.name as surchagetypeid");
		$rptjoin.=" left join hrm_surchagetypes on hrm_surchagetypes.id=hrm_employeesurchages.surchagetypeid ";
	}

	if(!empty($obj->shamount)  or empty($obj->action)){
		array_push($sColumns, 'amount');
		array_push($aColumns, "hrm_employeesurchages.amount");
	}

	if(!empty($obj->shchangedon)  or empty($obj->action)){
		array_push($sColumns, 'changedon');
		//array_push($aColumns, "hrm_employeesurchages.changedon");
	}

	if(!empty($obj->shfrommonth)  or empty($obj->action)){
		array_push($sColumns, 'frommonth');
		array_push($aColumns, "hrm_employeesurchages.frommonth");
	}

	if(!empty($obj->shfromyear)  or empty($obj->action)){
		array_push($sColumns, 'fromyear');
		array_push($aColumns, "hrm_employeesurchages.fromyear");
	}

	if(!empty($obj->shtoyear)  or empty($obj->action)){
		array_push($sColumns, 'toyear');
		array_push($aColumns, "hrm_employeesurchages.toyear");
	}

	if(!empty($obj->shtomonth)  or empty($obj->action)){
		array_push($sColumns, 'tomonth');
		array_push($aColumns, "hrm_employeesurchages.tomonth");
	}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "hrm_employeesurchages.remarks");
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hrm_employeesurchages.createdon");
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "hrm_employeesurchages.createdby");
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "hrm_employeesurchages.ipaddress");
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->surchageid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.surchageid='$obj->surchageid'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.employeeid='$obj->employeeid'";
	$track++;
}

if(!empty($obj->surchagetypeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.surchagetypeid='$obj->surchagetypeid'";
	$track++;
}

if(!empty($obj->fromamount)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.amount>='$obj->fromamount'";
	$track++;
}

if(!empty($obj->toamount)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.amount<='$obj->toamount'";
	$track++;
}

if(!empty($obj->amount)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.amount='$obj->amount'";
	$track++;
}

if(!empty($obj->fromchargedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.chargedon>='$obj->fromchargedon'";
	$track++;
}

if(!empty($obj->tochargedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.chargedon<='$obj->tochargedon'";
	$track++;
}

if(!empty($obj->frommonth)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.frommonth='$obj->frommonth'";
	$track++;
}

if(!empty($obj->fromyear)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.fromyear='$obj->fromyear'";
	$track++;
}

if(!empty($obj->toyear)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.toyear='$obj->toyear'";
	$track++;
}

if(!empty($obj->tomonth)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.tomonth='$obj->tomonth'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hrm_employeesurchages.createdby='$obj->createdby'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grsurchageid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" surchageid ";
	$obj->shsurchageid=1;
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

if(!empty($obj->grsurchagetypeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" surchagetypeid ";
	$obj->shsurchagetypeid=1;
	$track++;
}

if(!empty($obj->grchangedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" changedon ";
	$obj->shchangedon=1;
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
 <?php $_SESSION['sTable']="hrm_employeesurchages";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hrm_employeesurchages",
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
<form  action="employeesurchages.php" method="post" name="employeesurchages" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Surcharge</td>
				<td>
				<select name='surchageid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$surchages=new Surchages();
				$where="  ";
				$fields="hrm_surchages.id, hrm_surchages.name, hrm_surchages.amount, hrm_surchages.remarks, hrm_surchages.surchagetypeid, hrm_surchages.frommonth, hrm_surchages.fromyear, hrm_surchages.tomonth, hrm_surchages.toyear, hrm_surchages.overall, hrm_surchages.status, hrm_surchages.createdby, hrm_surchages.createdon, hrm_surchages.lasteditedby, hrm_surchages.lasteditedon, hrm_surchages.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$surchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($surchages->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->surchageid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td>Surcharge Type</td>
				<td>
				<select name='surchagetypeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$surchagetypes=new Surchagetypes();
				$where="  ";
				$fields="hrm_surchagetypes.id, hrm_surchagetypes.name, hrm_surchagetypes.repeatafter, hrm_surchagetypes.remarks, hrm_surchagetypes.createdby, hrm_surchagetypes.createdon, hrm_surchagetypes.lasteditedby, hrm_surchagetypes.lasteditedon, hrm_surchagetypes.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$surchagetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($surchagetypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->surchagetypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td>Charged On</td>
				<td><strong>From:</strong><input type='text' id='fromchargedon' size='12' name='fromchargedon' readonly class="date_input" value='<?php echo $obj->fromchargedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tochargedon' size='12' name='tochargedon' readonly class="date_input" value='<?php echo $obj->tochargedon;?>'/></td>
			</tr>
			<tr>
				<td>Month From </td>
				<td><input type='text' id='frommonth' size='20' name='frommonth' value='<?php echo $obj->frommonth;?>'></td>
			</tr>
			<tr>
				<td>Year From</td>
				<td><input type='text' id='fromyear' size='20' name='fromyear' value='<?php echo $obj->fromyear;?>'></td>
			</tr>
			<tr>
				<td>Year To</td>
				<td><input type='text' id='toyear' size='20' name='toyear' value='<?php echo $obj->toyear;?>'></td>
			</tr>
			<tr>
				<td>Month To </td>
				<td><input type='text' id='tomonth' size='20' name='tomonth' value='<?php echo $obj->tomonth;?>'></td>
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
				<td><input type='checkbox' name='grsurchageid' value='1' <?php if(isset($_POST['grsurchageid']) ){echo"checked";}?>>&nbsp;Surcharge</td>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='grsurchagetypeid' value='1' <?php if(isset($_POST['grsurchagetypeid']) ){echo"checked";}?>>&nbsp;Surcharge Type</td>
				<td><input type='checkbox' name='grchangedon' value='1' <?php if(isset($_POST['grchangedon']) ){echo"checked";}?>>&nbsp;Charged On</td>
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
				<td><input type='checkbox' name='shsurchageid' value='1' <?php if(isset($_POST['shsurchageid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Surcharge</td>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='shsurchagetypeid' value='1' <?php if(isset($_POST['shsurchagetypeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Surcharge Type</td>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shchangedon' value='1' <?php if(isset($_POST['shchangedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Charged On</td>
				<td><input type='checkbox' name='shfrommonth' value='1' <?php if(isset($_POST['shfrommonth'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Month From </td>
			<tr>
				<td><input type='checkbox' name='shfromyear' value='1' <?php if(isset($_POST['shfromyear'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Year From</td>
				<td><input type='checkbox' name='shtoyear' value='1' <?php if(isset($_POST['shtoyear'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Year To</td>
			<tr>
				<td><input type='checkbox' name='shtomonth' value='1' <?php if(isset($_POST['shtomonth'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Month To </td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ip Address</td>
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
			<?php if($obj->shsurchageid==1  or empty($obj->action)){ ?>
				<th>Surcharge </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shsurchagetypeid==1  or empty($obj->action)){ ?>
				<th>Surchage Type </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shchangedon==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shfrommonth==1  or empty($obj->action)){ ?>
				<th>From </th>
			<?php } ?>
			<?php if($obj->shfromyear==1  or empty($obj->action)){ ?>
				<th>From </th>
			<?php } ?>
			<?php if($obj->shtoyear==1  or empty($obj->action)){ ?>
				<th>To </th>
			<?php } ?>
			<?php if($obj->shtomonth==1  or empty($obj->action)){ ?>
				<th>To </th>
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
		</tr>
	</thead>
	<tbody>
	</tbody>
</div>
</div>
</div>
</div>
</div>
