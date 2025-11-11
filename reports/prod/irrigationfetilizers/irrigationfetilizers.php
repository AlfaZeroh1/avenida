<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/irrigationfetilizers/Irrigationfetilizers_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/irrigations/Irrigations_class.php");
require_once("../../../modules/prod/irrigationfetilizers/Irrigationfetilizers_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Irrigationfetilizers";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9271";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
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
if(!empty($obj->grirrigationid) or !empty($obj->grfertilizerid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shirrigationid='';
	$obj->shfertilizerid='';
	$obj->shamount='';
	$obj->shremarks='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
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

if(!empty($obj->grfertilizerid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" fertilizerid ";
	$obj->shfertilizerid=1;
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
	if(!empty($obj->shirrigationid)  or empty($obj->action)){
		array_push($sColumns, 'irrigationid');
		array_push($aColumns, "prod_irrigations.name as irrigationid");
		$rptjoin.=" left join prod_irrigations on prod_irrigations.id=prod_irrigationfetilizers.irrigationid ";
		$k++;
		}

	if(!empty($obj->shfertilizerid)  or empty($obj->action)){
		array_push($sColumns, 'fertilizerid');
		array_push($aColumns, "prod_irrigationfetiliz.name as fertilizerid");
		//$rptjoin.=" left join prod_irrigationfetilizers on prod_irrigationfetilizers.id=prod_irrigationfetilizers.fertilizerid ";
		$k++;
		}

	if(!empty($obj->shamount)  or empty($obj->action)){
		array_push($sColumns, 'amount');
		array_push($aColumns, "prod_irrigationfetilizers.amount");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_irrigationfetilizers.remarks");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "prod_irrigationfetilizers.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "prod_irrigationfetilizers.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->irrigationid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_irrigationfetilizers.irrigationid='$obj->irrigationid'";
		$join=" left join prod_irrigations on prod_irrigationfetilizers.id=prod_irrigations.irrigationfetilizerid ";
		
	$track++;
}

if(!empty($obj->fertilizerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_irrigationfetilizers.fertilizerid='$obj->fertilizerid'";
		$join=" left join prod_irrigationfetilizers on prod_irrigationfetilizers.id=prod_irrigationfetilizers.irrigationfetilizerid ";
		
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_irrigationfetilizers.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_irrigationfetilizers.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_irrigationfetilizers.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="prod_irrigationfetilizers";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_irrigationfetilizers",
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
<form  action="irrigationfetilizers.php" method="post" name="irrigationfetilizers" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Irrigation</td>
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
				<td>Fertilizer</td>
				<td>
				<select name='fertilizerid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$irrigationfetilizers=new Irrigationfetilizers();
				$where="  ";
				$fields="prod_irrigationfetilizers.id, prod_irrigationfetilizers.irrigationid, prod_irrigationfetilizers.fertilizerid, prod_irrigationfetilizers.amount, prod_irrigationfetilizers.remarks, prod_irrigationfetilizers.ipaddress, prod_irrigationfetilizers.createdby, prod_irrigationfetilizers.createdon, prod_irrigationfetilizers.lasteditedby, prod_irrigationfetilizers.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$irrigationfetilizers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($irrigationfetilizers->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->fertilizerid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='grirrigationid' value='1' <?php if(isset($_POST['grirrigationid']) ){echo"checked";}?>>&nbsp;Irrigation</td>
				<td><input type='checkbox' name='grfertilizerid' value='1' <?php if(isset($_POST['grfertilizerid']) ){echo"checked";}?>>&nbsp;Fertilizer</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
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
				<td><input type='checkbox' name='shirrigationid' value='1' <?php if(isset($_POST['shirrigationid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Irrigation</td>
				<td><input type='checkbox' name='shfertilizerid' value='1' <?php if(isset($_POST['shfertilizerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Fertilizer</td>
			<tr>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
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
				<th>Irrigation </th>
			<?php } ?>
			<?php if($obj->shfertilizerid==1  or empty($obj->action)){ ?>
				<th>Fertilizer </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount (Kgs) </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
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
