<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/rejects/Rejects_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/rejecttypes/Rejecttypes_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/prod/plantingdetails/Plantingdetails_class.php");
require_once("../../../modules/prod/areas/Areas_class.php");
require_once("../../../modules/prod/sizes/Sizes_class.php");
require_once("../../../modules/prod/greenhouses/Greenhouses_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Rejects";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8795";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromreportedon=date('Y-m-d');
	$obj->toreportedon=date('Y-m-d');
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
if(!empty($obj->grrejecttypeid) or !empty($obj->grvarietyid) or !empty($obj->grplantingdetailid) or  !empty($obj->grreportedon) or !empty($obj->grcreatedon) or !empty($obj->grcreatedby) or !empty($obj->grsizeid) or !empty($obj->grgreenhouseid) ){
	//$obj->shrejecttypeid='';
	$obj->shvarietyid='';
	$obj->shplantingdetailid='';
// 	$obj->shareaid='';
	$obj->shquantity='';
	$obj->shreportedon='';
	$obj->shremarks='';
	$obj->shcreatedon='';
	$obj->shcreatedby='';
	$obj->shipaddress='';
	$obj->shsizeid='';
	$obj->shgreenhouseid='';
}


	$obj->shquantity=1;
	//$obj->shsizeid=1;
	$obj->grgreenhouseid=1;


if(!empty($obj->grrejecttypeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" rejecttypeid ";
	$obj->shrejecttypeid=1;
	$track++;
}

if(!empty($obj->grvarietyid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" varietyid ";
	$obj->shvarietyid=1;
	$track++;
}

if(!empty($obj->grplantingdetailid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" plantingdetailid ";
	$obj->shplantingdetailid=1;
	$track++;
}



if(!empty($obj->grreportedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" reportedon ";
	$obj->shreportedon=1;
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

if(!empty($obj->grsizeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" sizeid ";
	$obj->shsizeid=1;
	$track++;
}

if(!empty($obj->grgreenhouseid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" greenhouseid ";
	$obj->shgreenhouseid=1;
	$track++;
}

//processing columns to show
	

	if(!empty($obj->shvarietyid)  or empty($obj->action)){
		array_push($sColumns, 'varietyid');
		array_push($aColumns, "prod_varietys.name as varietyid");
		$rptjoin.=" left join prod_varietys on prod_varietys.id=prod_rejects.varietyid ";
		$k++;
		}

	if(!empty($obj->shplantingdetailid)  or empty($obj->action)){
		array_push($sColumns, 'plantingdetailid');
		array_push($aColumns, "prod_plantingdetails.id as plantingdetailid");
		$rptjoin.=" left join prod_plantingdetails on prod_plantingdetails.id=prod_rejects.plantingdetailid ";
		$k++;
		}

// 	if(!empty($obj->shareaid)  or empty($obj->action)){
// 		array_push($sColumns, 'areaid');
// 		//array_push($aColumns, "prod_rejects.areaid");
// 		$k++;
// 		}

	

	if(!empty($obj->shreportedon)  or empty($obj->action)){
		array_push($sColumns, 'reportedon');
		array_push($aColumns, "prod_rejects.reportedon");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_rejects.remarks");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "prod_rejects.createdon");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=prod_rejects.createdby ";
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "prod_rejects.ipaddress");
		$k++;
		}

// 	if(!empty($obj->shsizeid)  or empty($obj->action)){
// 		array_push($sColumns, 'sizeid');
// 		array_push($aColumns, "prod_sizes.name as sizeid");
// 		$rptjoin.=" left join prod_sizes on prod_sizes.id=prod_rejects.sizeid ";
// 		$k++;
// 		}

	if(!empty($obj->shgreenhouseid)  or empty($obj->action)){
		array_push($sColumns, 'greenhouseid');
		array_push($aColumns, "prod_greenhouses.name as greenhouseid");
		$rptjoin.=" left join prod_greenhouses on prod_greenhouses.id=prod_rejects.greenhouseid ";
		$k++;
		}


$mnt=$k+1;
$track=0;

//processing filters
if(!empty($obj->rejecttypeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.rejecttypeid='$obj->rejecttypeid'";
		
	$track++;
}

if(!empty($obj->reduce)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.reduce='$obj->reduce'";
		
	$track++;
}

if(!empty($obj->varietyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.varietyid='$obj->varietyid'";
		
	$track++;
}

if(!empty($obj->plantingdetailid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.plantingdetailid='$obj->plantingdetailid'";
		
		
	$track++;
}

// if(!empty($obj->areaid)){
// 	if($track>0)
// 		$rptwhere.="and";
// 		$rptwhere.=" prod_rejects.areaid='$obj->areaid'";
// 		
// 	$track++;
// }

if(!empty($obj->fromquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.quantity>='$obj->fromquantity'";
	$track++;
}

if(!empty($obj->toquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.quantity<='$obj->toquantity'";
	$track++;
}

if(!empty($obj->fromreportedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.reportedon>='$obj->fromreportedon'";
	$track++;
}

if(!empty($obj->toreportedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.reportedon<='$obj->toreportedon'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->sizeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.sizeid='$obj->sizeid'";
		
	$track++;
}

if(!empty($obj->greenhouseid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_rejects.greenhouseid='$obj->greenhouseid'";
		
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#areaname").autocomplete({
	source:"../../../modules/server/server/search.php?main=prod&module=areas&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#areaid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
<?php

if($obj->shrejecttypeid){
$rejecttypes=new Rejecttypes();
  $where="  ";
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

  
  $cols="";
  while($rw=mysql_fetch_object($rejecttypes->result)){
    $cols=" case when sum(case when rejecttypeid=$rw->id then prod_rejects.quantity end) is null then '' else sum(case when rejecttypeid=$rw->id then prod_rejects.quantity end) end '$rw->name'";
    array_push($aColumns, $cols);
    array_push($sColumns, $rw->name);
    
    $k++;
  }
}
if($obj->shsizeid){
$sizes=new Sizes();
  $where="  ";
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

  
  $cols="";
  while($rw=mysql_fetch_object($sizes->result)){
    $cols=" sum(case when sizeid=$rw->id then prod_rejects.quantity end) '$rw->name'";
    array_push($aColumns, $cols);
    array_push($sColumns, $rw->name);
    
    $k++;
  }
}
  if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "sum(prod_rejects.quantity) quantity");
		$k++;
		}
?>
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="prod_rejects";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php 
 
 if(!empty($obj->grgreenhouseid)){
//   $rptgroup.=" with rollup ";
 }
 
 $_SESSION['sGroup']="$rptgroup ";?>
 
 $(document).ready(function() {
	 
	 
 	var tbl = $('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollX" : "100%", //Scroll
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_rejects",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			$('th:eq(1)', nRow).html("TOTAL Rejects");
			var total=[];
			//var k=0;
			for(var i=0; i<aaData.length; i++){
			  //var k = aaData[i].length;
			  
			  for(var j=<?php echo $mnt; ?>; j<aaData[i].length; j++){
			  
			    if(aaData[i][j]=='')
			      aaData[i][j]=0;			      
			      
			      if(i==0)
				total[j]=0;
				//if((aaData[i][1]!='' && aaData[i][2]!='' && aaData[i][3]!='' && aaData[i][4]!='') )
				  total[j] = parseFloat(total[j])+parseFloat(aaData[i][j]);	//alert(parseFloat(aaData[i][j]));	
			  }
			  
			}
			
			for(var i=<?php echo $mnt; ?>; i<total.length;i++){
			  $('th:eq('+i+')', nRow).html(total[i]);
			}
		}
 	} );
 	new $.fn.dataTable.FixedColumns(tbl,{"iLeftColumns": 2});
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
<form  action="rejectss.php" method="post" name="rejects" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>RejectType</td>
				<td>
				<select name='rejecttypeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$rejecttypes=new Rejecttypes();
				$where="  ";
				$fields="prod_rejecttypes.id, prod_rejecttypes.name, prod_rejecttypes.remarks, prod_rejecttypes.ipaddress, prod_rejecttypes.createdby, prod_rejecttypes.createdon, prod_rejecttypes.lasteditedby, prod_rejecttypes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($rejecttypes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->rejecttypeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Variety</td>
				<td>
				<select name='varietyid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$varietys=new Varietys();
				$where="  ";
				$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.stems, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($varietys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->varietyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Planting Detail</td>
				<td>
				<select name='plantingdetailid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$plantingdetails=new Plantingdetails();
				$where="  ";
				$fields="prod_plantingdetails.id, prod_plantingdetails.plantingid, prod_plantingdetails.varietyid, prod_plantingdetails.areaid, prod_plantingdetails.quantity, prod_plantingdetails.memo, prod_plantingdetails.ipaddress, prod_plantingdetails.createdby, prod_plantingdetails.createdon, prod_plantingdetails.lasteditedby, prod_plantingdetails.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$plantingdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($plantingdetails->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->plantingdetailid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Area</td>
				<td><input type='text' size='20' name='areaname' id='areaname' value='<?php echo $obj->areaname; ?>'>
					<input type="hidden" name='areaid' id='areaid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><strong>From:</strong><input type='text' id='fromquantity' size='from20' name='fromquantity' value='<?php echo $obj->fromquantity;?>'/>
								<br/><strong>To:</strong><input type='text' id='toquantity' size='to20' name='toquantity' value='<?php echo $obj->toquantity;?>'></td>
			</tr>
			<tr>
				<td>Reported On</td>
				<td><strong>From:</strong><input type='text' id='fromreportedon' size='12' name='fromreportedon' readonly class="date_input" value='<?php echo $obj->fromreportedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toreportedon' size='12' name='toreportedon' readonly class="date_input" value='<?php echo $obj->toreportedon;?>'/></td>
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
				$where=" where auth_users.id in(select createdby from prod_rejectss) ";
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
				<td>Size </td>
				<td>
				<select name='sizeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$sizes=new Sizes();
				$where="  ";
				$fields="prod_sizes.id, prod_sizes.name, prod_sizes.remarks, prod_sizes.ipaddress, prod_sizes.createdby, prod_sizes.createdon, prod_sizes.lasteditedby, prod_sizes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($sizes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->sizeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Green House</td>
				<td>
				<select name='greenhouseid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$greenhouses=new Greenhouses();
				$where="  ";
				$fields="prod_greenhouses.id, prod_greenhouses.name, prod_greenhouses.sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($greenhouses->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->greenhouseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
			  <td>Reject Position</td>
			  <td>
			  <select name="reduce" class="selectbox">
			    <option value="">Production</option>
			    <option value="reduce" <?php if($obj->reduce=="reduce"){echo "selected";}?>>Pre-cool Store</option>
			  </select>
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
				<td><input type='checkbox' name='grrejecttypeid' value='1' <?php if(isset($_POST['grrejecttypeid']) ){echo"checked";}?>>&nbsp;Reject Type</td>
				<td><input type='checkbox' name='grvarietyid' value='1' <?php if(isset($_POST['grvarietyid'])   or empty($obj->action)){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='grplantingdetailid' value='1' <?php if(isset($_POST['grplantingdetailid']) ){echo"checked";}?>>&nbsp;Planting Detail</td>
				<td><input type='checkbox' name='grareaid' value='1' <?php if(isset($_POST['grareaid']) ){echo"checked";}?>>&nbsp;Area</td>
			<tr>
				<td><input type='checkbox' name='grreportedon' value='1' <?php if(isset($_POST['grreportedon']) ){echo"checked";}?>>&nbsp;Reported On</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='grsizeid' value='1' <?php if(isset($_POST['grsizeid']) ){echo"checked";}?>>&nbsp;Size </td>
			<tr>
				<td><input type='checkbox' name='grgreenhouseid' value='1' <?php if(isset($_POST['grgreenhouseid']) ){echo"checked";}?>>&nbsp;Green House</td>
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
				<td><input type='checkbox' name='shrejecttypeid' value='1' <?php if(isset($_POST['shrejecttypeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Reject Type</td>
				<td><input type='checkbox' name='shvarietyid' value='1' <?php if(isset($_POST['shvarietyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='shplantingdetailid' value='1' <?php if(isset($_POST['shplantingdetailid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Planting Detail</td>
				<td><input type='checkbox' name='shareaid' value='1' <?php if(isset($_POST['shareaid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Area</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shreportedon' value='1' <?php if(isset($_POST['shreportedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Reported On</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
			<tr>
				<td><input type='checkbox' name='shsizeid' value='1' <?php if(isset($_POST['shsizeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Size </td>
				<td><input type='checkbox' name='shgreenhouseid' value='1' <?php if(isset($_POST['shgreenhouseid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Green House</td>
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
			<?php if($obj->shvarietyid==1  or empty($obj->action)){ ?>
				<th>Variety </th>
			<?php } ?>
			<?php if($obj->shplantingdetailid==1  or empty($obj->action)){ ?>
				<th>Planting Detail </th>
			<?php } ?>
			<?php if($obj->shreportedon==1  or empty($obj->action)){ ?>
				<th>Date Reported </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On</th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created By </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
			<?php } ?>
			<?php if($obj->shgreenhouseid==1  or empty($obj->action)){ ?>
				<th>Green House </th>
			<?php } ?>
			<?php if($obj->shrejecttypeid==1){ 
			      $rejecttypes=new Rejecttypes();
			      $where="  ";
			      $fields="*";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			      while($rw=mysql_fetch_object($rejecttypes->result)){
			      
			?>
				<th><?php echo $rw->name; ?></th>
			<?php }} ?>
			<?php if($obj->shsizeid==1){ 
			      $sizes=new Sizes();
			      $where="  ";
			      $fields="*";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			      while($rw=mysql_fetch_object($sizes->result)){
			      
			?>
				<th><?php echo $rw->name; ?></th>
			<?php }} ?>
			<?php if($obj->shquantity==1){ ?>
				<th>Total </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
	
	<tfoot>
	  <tr>
			<th>#</th>
			<?php if($obj->shvarietyid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shplantingdetailid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shreportedon==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shgreenhouseid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			
			<?php if($obj->shrejecttypeid==1){ 
			      $rejecttypes=new Rejecttypes();
			      $where="  ";
			      $fields="*";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			      while($rw=mysql_fetch_object($rejecttypes->result)){
			      
			?>
				<th>&nbsp;</th>
			<?php }} ?>
			<?php if($obj->shsizeid==1){ 
			      $sizes=new Sizes();
			      $where="  ";
			      $fields="*";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			      while($rw=mysql_fetch_object($sizes->result)){
			      
			?>
				<th>&nbsp;</th>
			<?php }} ?>
			<?php if($obj->shquantity==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
		</tr>
	</tfoot>
</div>
</div>
</div>
</div>
</div>
