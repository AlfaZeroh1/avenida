<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/assets/fleetservices/Fleetservices_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/assets/fleetservices/Fleetservices_class.php");
require_once("../../../modules/fn/suppliers/Suppliers_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Fleetservices";
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
	if(!empty($obj->shfleetid)  or empty($obj->action)){
		array_push($sColumns, 'fleetid');
		array_push($aColumns, "assets_fleetservices.fleetid");
	}

	if(!empty($obj->shdescription)  or empty($obj->action)){
		array_push($sColumns, 'description');
		array_push($aColumns, "assets_fleetservices.description");
	}

	if(!empty($obj->shsupplierid)  or empty($obj->action)){
		array_push($sColumns, 'supplierid');
		array_push($aColumns, "assets_fleetservices.supplierid");
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->fleetid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_fleetservices.fleetid='$obj->fleetid'";
	$track++;
}

if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" assets_fleetservices.supplierid='$obj->supplierid'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grfleetid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" fleetid ";
	$obj->shfleetid=1;
	$track++;
}

if(!empty($obj->grsupplierid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" supplierid ";
	$obj->shsupplierid=1;
	$track++;
}

//Processing Joins
;$rptgroup='';
$track=0;
}
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#suppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=suppliers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#supplierid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="assets_fleetservices";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	 TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
 	$('#tbl').dataTable( {
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=assets_fleetservices",
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
<form  action="fleetservices.php" method="post" name="fleetservices" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Vehicle</td>
				<td>
				<select name='fleetid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$fleetservices=new Fleetservices();
				$where="  ";
				$fields="assets_fleetservices.id, assets_fleetservices.fleetid, assets_fleetservices.description, assets_fleetservices.supplierid, assets_fleetservices.cost, assets_fleetservices.odometer, assets_fleetservices.remarks, assets_fleetservices.ipaddress, assets_fleetservices.createdby, assets_fleetservices.createdon, assets_fleetservices.lasteditedby, assets_fleetservices.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$fleetservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($fleetservices->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->fleetid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Supplier</td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->field; ?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grfleetid' value='1' <?php if(isset($_POST['grfleetid']) ){echo"checked";}?>>&nbsp;Vehicle</td>
				<td><input type='checkbox' name='grsupplierid' value='1' <?php if(isset($_POST['grsupplierid']) ){echo"checked";}?>>&nbsp;Supplier</td>
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
				<td><input type='checkbox' name='shfleetid' value='1' <?php if(isset($_POST['shfleetid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Vehicle</td>
				<td><input type='checkbox' name='shdescription' value='1' <?php if(isset($_POST['shdescription'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Description</td>
			<tr>
				<td><input type='checkbox' name='shsupplierid' value='1' <?php if(isset($_POST['shsupplierid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Supplier</td>
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
			<?php if($obj->shfleetid==1  or empty($obj->action)){ ?>
				<th>Vehicle </th>
			<?php } ?>
			<?php if($obj->shdescription==1  or empty($obj->action)){ ?>
				<th>Description </th>
			<?php } ?>
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>Supplier </th>
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
