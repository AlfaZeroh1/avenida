<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/irrigationmixtures/Irrigationmixtures_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/irrigations/Irrigations_class.php");
require_once("../../../modules/prod/irrigationtanks/Irrigationtanks_class.php");
require_once("../../../modules/prod/irrigationsystems/Irrigationsystems_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Irrigationmixtures";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9261";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if (empty ($obj->action)){
  $obj->fromirrigationdate=date('y-m-d');
  $obj->toirrigationdate=date('y-m-d');
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
if(!empty($obj->grirrigationid) or !empty($obj->grtankid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->grirrigationsystemid) or !empty($obj->grirrigationdate) ){
	$obj->shirrigationid='';
	$obj->shtankid='';
	$obj->shwater='';
	$obj->shec='';
	$obj->shph='';
	$obj->shremarks='';
	$obj->shipaddress='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shirrigationsystemid='';
	$obj->shirrigationdate='';
}


	$obj->sh=1;


if(!empty($obj->grirrigationid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" irrigationid ";
	$obj->shirrigationid=1;
	$track++;
}

if(!empty($obj->grtankid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" tankid ";
	$obj->shtankid=1;
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

if(!empty($obj->grirrigationsystemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" irrigationsystemid ";
	$obj->shirrigationsystemid=1;
	$track++;
}

if(!empty($obj->grirrigationdate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" irrigationdate ";
	$obj->shirrigationdate=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shirrigationid)  or empty($obj->action)){
		array_push($sColumns, 'irrigationid');
		array_push($aColumns, "prod_irrigations.id");
		$join=" left join prod_irrigations on prod_irrigationmixtures.irrigationid=prod_irrigations.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}

	if(!empty($obj->shtankid)  or empty($obj->action)){
		array_push($sColumns, 'tankid');
		array_push($aColumns, "prod_irrigationtanks.name as tankid");
		$join=" left join prod_irrigationtanks on prod_irrigationtanks.id=prod_irrigationmixtures.tankid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}

	if(!empty($obj->shwater)  or empty($obj->action)){
		array_push($sColumns, 'water');
		array_push($aColumns, "prod_irrigationmixtures.water");
		$k++;
		}

	if(!empty($obj->shec)  or empty($obj->action)){
		array_push($sColumns, 'ec');
		array_push($aColumns, "prod_irrigationmixtures.ec");
		$k++;
		}

	if(!empty($obj->shph)  or empty($obj->action)){
		array_push($sColumns, 'ph');
		array_push($aColumns, "prod_irrigationmixtures.ph");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_irrigationmixtures.remarks");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "prod_irrigationmixtures.ipaddress");
		$k++;
		}

	if(!empty($obj->shirrigationsystemid)  or empty($obj->action)){
		array_push($sColumns, 'irrigationsystemid');
		array_push($aColumns, "prod_irrigationsystems.name irrigationsystemid");
		$k++;
		$join=" left join prod_irrigations on prod_irrigationmixtures.irrigationid=prod_irrigations.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join prod_irrigationsystems on prod_irrigations.irrigationsystemid=prod_irrigationsystems.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shirrigationdate) ){
		array_push($sColumns, 'irrigationdate');
		array_push($aColumns, "prod_irrigations.irrigationdate");
		$k++;
		$join=" left join prod_irrigations on prod_irrigationmixtures.irrigationid=prod_irrigations.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	
		
		}


	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=prod_irrigationmixtures.createdby ";
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "prod_irrigationmixtures.createdon");
		$k++;
		}

$track=0;

//processing filters
if(!empty($obj->irrigationid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_irrigationmixtures.irrigationid='$obj->irrigationid'";
// 		$join=" left join prod_irrigations on prod_irrigationmixtures.id=prod_irrigations.irrigationmixtureid ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
		
	$track++;
}

if(!empty($obj->tankid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_irrigationmixtures.tankid='$obj->tankid'";
		$join=" left join prod_irrigationtanks on prod_irrigationmixtures.id=prod_irrigationtanks.irrigationmixtureid ";
		
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_irrigationmixtures.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_irrigationmixtures.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_irrigationmixtures.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->irrigationsystemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_irrigations.irrigationsystemid='$obj->irrigationsystemid' ";
	$join=" left join prod_irrigations on prod_irrigationmixtures.irrigationid=prod_irrigations.id ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->fromirrigationdate)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_irrigations.irrigationdate>='$obj->fromirrigationdate' ";
	$join=" left join prod_irrigations on prod_irrigationmixtures.irrigationid=prod_irrigations.id ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}

if(!empty($obj->toirrigationdate)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_irrigations.irrigationdate<='$obj->toirrigationdate' ";
	$join=" left join prod_irrigations on prod_irrigationmixtures.irrigationid=prod_irrigations.id ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#tankname").autocomplete({
	source:"../../../modules/server/server/search.php?main=prod&module=tanks&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#tankid").val(ui.item.id);
	}
  });

  $("#irrigationsystemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=prod&module=irrigationsystems&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#irrigationsystemid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="prod_irrigationmixtures";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_irrigationmixtures",
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
<form  action="irrigationmixtures.php" method="post" name="irrigationmixtures" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Irrigation name</td>
				<td>
				<select name='irrigationid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$irrigations=new Irrigations();
				$where="  ";
				$fields="prod_irrigations.id, prod_irrigations.irrigationsystemid, prod_irrigations.irrigationdate, prod_irrigations.remarks, prod_irrigations.ipaddress, prod_irrigations.createdby, prod_irrigations.createdon, prod_irrigations.lasteditedby, prod_irrigations.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$irrigations->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($irrigations->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->irrigationid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Tank</td>
				<td><input type='text' size='20' name='irrigationtanks' id='irrigationtanks' value='<?php echo $obj->irrigationtanks; ?>'>
					<input type="hidden" name='irrigationtanks' id='irrigationtanks' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from prod_rejects) ";
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
			<tr>
				<td>Irrigation system</td>
				<td><input type='text' size='20' name='irrigationsystemname' id='irrigationsystemname' value='<?php echo $obj->irrigationsystemname; ?>'>
					<input type="hidden" name='irrigationsystemid' id='irrigationsystemid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Irrigationdate</td>
				<td><strong>From:</strong><input type='text' id='fromirrigationdate' size='12' name='fromirrigationdate' readonly class="date_input" value='<?php echo $obj->fromirrigationdate;?>'/>
							<br/><strong>To:</strong><input type='text' id='toirrigationdate' size='12' name='toirrigationdate' readonly class="date_input" value='<?php echo $obj->toirrigationdate;?>'/></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grirrigationid' value='1' <?php if(isset($_POST['grirrigationid']) ){echo"checked";}?>>&nbsp;Irrigation name</td>
				<td><input type='checkbox' name='grtankid' value='1' <?php if(isset($_POST['grtankid']) ){echo"checked";}?>>&nbsp;Tank</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='grirrigationsystemid' value='1' <?php if(isset($_POST['grirrigationsystemid']) ){echo"checked";}?>>&nbsp;Irrigation system</td>
				<td><input type='checkbox' name='grirrigationdate' value='1' <?php if(isset($_POST['grirrigationdate']) ){echo"checked";}?>>&nbsp;Irrigationdate</td>
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
				<td><input type='checkbox' name='shirrigationid' value='1' <?php if(isset($_POST['shirrigationid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Irrigation name</td>
				<td><input type='checkbox' name='shtankid' value='1' <?php if(isset($_POST['shtankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Tank</td>
			<tr>
				<td><input type='checkbox' name='shwater' value='1' <?php if(isset($_POST['shwater'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Water</td>
				<td><input type='checkbox' name='shec' value='1' <?php if(isset($_POST['shec'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Ec</td>
			<tr>
				<td><input type='checkbox' name='shph' value='1' <?php if(isset($_POST['shph'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Ph</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shirrigationsystemid' value='1' <?php if(isset($_POST['shirrigationsystemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Irrigation system</td>
			<tr>
				<td><input type='checkbox' name='shirrigationdate' value='1' <?php if(isset($_POST['shirrigationdate']) ){echo"checked";}?>>&nbsp;Irrigationdate</td>
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
			<?php if($obj->shirrigationid==1  or empty($obj->action)){ ?>
				<th>Irrigation Name </th>
			<?php } ?>
			<?php if($obj->shtankid==1  or empty($obj->action)){ ?>
				<th>Tank </th>
			<?php } ?>
			<?php if($obj->shwater==1  or empty($obj->action)){ ?>
				<th>Water Volume </th>
			<?php } ?>
			<?php if($obj->shec==1  or empty($obj->action)){ ?>
				<th>EC Level </th>
			<?php } ?>
			<?php if($obj->shph==1  or empty($obj->action)){ ?>
				<th>PH </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
			<?php } ?>
			<?php if($obj->shirrigationsystemid==1  or empty($obj->action)){ ?>
				<th>Irrigation System </th>
			<?php } ?>
			<?php if($obj->shirrigationdate==1 ){ ?>
				<th>Irrigation date </th>
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
