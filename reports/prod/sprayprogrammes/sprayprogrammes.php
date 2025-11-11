<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/sprayprogrammes/Sprayprogrammes_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/greenhouses/Greenhouses_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/prod/chemicals/Chemicals_class.php");
require_once("../../../modules/prod/blocks/Blocks_class.php");
require_once("../../../modules/prod/nozzles/Nozzles_class.php");
require_once("../../../modules/prod/spraymethods/Spraymethods_class.php");
require_once("../../../modules/prod/greenhouses/Greenhouses_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Sprayprogrammes";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8799";//Report View
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
if(!empty($obj->grgreenhouseid) or !empty($obj->grvarietyid) or !empty($obj->grchemicalid) or !empty($obj->grnozzleid) or !empty($obj->grspraymethodid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->grspraydate) or !empty($obj->grgreenhouseid) ){
	$obj->shgreenhouseid='';
	$obj->shvarietyid='';
	$obj->shchemicalid='';
	$obj->shingredients='';
	$obj->shquantity='';
	$obj->shwatervol='';
	$obj->shnozzleid='';
	$obj->shtarget='';
	$obj->shpraymethodid='';
	$obj->shremarks='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shspraydate='';
	$obj->shtime='';
	$obj->shgreenhouseid='';
	$obj->sharea='';
	$obj->shblock='';
	$obj->shipaddress=''
}


	$obj->sh=1;
	$obj->shvarietyid=1;
	$obj->shquantity=1;
	$obj->shpraymethodid=1;
	




if(!empty($obj->grvarietyid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" varietyid ";
	$obj->shvarietyid=1;
	$track++;
}

if(!empty($obj->grchemicalid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" chemicalid ";
	$obj->shchemicalid=1;
	$track++;
}

if(!empty($obj->grnozzleid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" nozzleid ";
	$obj->shnozzleid=1;
	$track++;
}

if(!empty($obj->grspraymethodid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" spraymethodid ";
	$obj->shspraymethodid=1;
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

if(!empty($obj->grspraydate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" spraydate ";
	$obj->shspraydate=1;
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
		$rptjoin.=" left join prod_varietys on prod_varietys.id=prod_sprayprogrammes.varietyid ";
		$k++;
		}

	if(!empty($obj->shchemicalid)  or empty($obj->action)){
		array_push($sColumns, 'chemicalid');
		array_push($aColumns, "prod_chemicals.name as chemicalid");
		$rptjoin.=" left join prod_chemicals on prod_chemicals.id=prod_sprayprogrammes.chemicalid ";
		$k++;
		}

	if(!empty($obj->shingredients) ){
		array_push($sColumns, 'ingredients');
		array_push($aColumns, "prod_sprayprogrammes.ingredients");
		$k++;
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "prod_sprayprogrammes.quantity");
		$k++;
		}

	if(!empty($obj->shwatervol)  or empty($obj->action)){
		array_push($sColumns, 'watervol');
		array_push($aColumns, "prod_sprayprogrammes.watervol");
		$k++;
		}

	if(!empty($obj->shnozzleid)  or empty($obj->action)){
		array_push($sColumns, 'nozzleid');
		array_push($aColumns, "prod_nozzles.name as nozzleid");
		$rptjoin.=" left join prod_nozzles on prod_nozzles.id=prod_sprayprogrammes.nozzleid ";
		$k++;
		}

	if(!empty($obj->shtarget)  or empty($obj->action)){
		array_push($sColumns, 'target');
		array_push($aColumns, "prod_sprayprogrammes.target");
		$k++;
		}

	if(!empty($obj->shpraymethodid)  or empty($obj->action)){
		array_push($sColumns, 'spraymethodid');
		array_push($aColumns, "prod_sprayprogrammes.spraymethodid");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_sprayprogrammes.remarks");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=prod_sprayprogrammes.createdby";
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "prod_sprayprogrammes.createdon");
		$k++;
		}

	if(!empty($obj->shspraydate)  or empty($obj->action)){
		array_push($sColumns, 'spraydate');
		array_push($aColumns, "prod_sprayprogrammes.spraydate");
		$k++;
		}

	if(!empty($obj->shtime) ){
		array_push($sColumns, 'time');
		array_push($aColumns, "prod_sprayprogrammes.time");
		$k++;
		}

	if(!empty($obj->shgreenhouseid)  or empty($obj->action)){
		array_push($sColumns, 'greenhouseid');
		array_push($aColumns, "prod_sprayprogrammes.greenhouseid");
		$k++;
		}



$track=0;

//processing filters


if(!empty($obj->varietyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.varietyid='$obj->varietyid'";
		$join=" left join prod_varietys on prod_sprayprogrammes.id=prod_varietys.sprayprogrammeid ";
		
	$track++;
}

if(!empty($obj->chemicalid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.chemicalid='$obj->chemicalid'";
		$join=" left join prod_chemicals on prod_sprayprogrammes.id=prod_chemicals.sprayprogrammeid ";
		
	$track++;
}

if(!empty($obj->fromquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.quantity>='$obj->fromquantity'";
	$track++;
}

if(!empty($obj->toquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.quantity<='$obj->toquantity'";
	$track++;
}

if(!empty($obj->fromwatervol)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.watervol>='$obj->fromwatervol'";
	$track++;
}

if(!empty($obj->towatervol)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.watervol<='$obj->towatervol'";
	$track++;
}

if(!empty($obj->blockid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.blockid='$obj->blockid'";
		
	$track++;
}

if(!empty($obj->nozzleid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.nozzleid='$obj->nozzleid'";
		
	$track++;
}

if(!empty($obj->spraymethodid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.spraymethodid='$obj->spraymethodid'";
		
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->fromspraydate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.spraydate>='$obj->fromspraydate'";
	$track++;
}

if(!empty($obj->tospraydate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.spraydate<='$obj->tospraydate'";
	$track++;
}

if(!empty($obj->time)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.time='$obj->time'";
	$track++;
}

if(!empty($obj->greenhouseid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_sprayprogrammes.greenhouseid='$obj->greenhouseid'";
		$join=" left join prod_greenhouses on prod_sprayprogrammes.id=prod_greenhouses.sprayprogrammeid ";
		
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
 <?php $_SESSION['sTable']="prod_sprayprogrammes";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_sprayprogrammes",
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
<form  action="sprayprogrammes.php" method="post" name="sprayprogrammes" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			
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
				<td>Chemical</td>
				<td>
				<select name='chemicalid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$chemicals=new Chemicals();
				$where="  ";
				$fields="prod_chemicals.id, prod_chemicals.name, prod_chemicals.remarks, prod_chemicals.ipaddress, prod_chemicals.createdby, prod_chemicals.createdon, prod_chemicals.lasteditedby, prod_chemicals.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$chemicals->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($chemicals->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->chemicalid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><strong>From:</strong><input type='text' id='fromquantity' size='from20' name='fromquantity' value='<?php echo $obj->fromquantity;?>'/>
								<br/><strong>To:</strong><input type='text' id='toquantity' size='to20' name='toquantity' value='<?php echo $obj->toquantity;?>'></td>
			</tr>
			<tr>
				<td>Watervol</td>
				<td><strong>From:</strong><input type='text' id='fromwatervol' size='from20' name='fromwatervol' value='<?php echo $obj->fromwatervol;?>'/>
								<br/><strong>To:</strong><input type='text' id='towatervol' size='to20' name='towatervol' value='<?php echo $obj->towatervol;?>'></td>
			</tr>
			<tr>
				<td>Block</td>
				<td>
				<select name='blockid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$blocks=new Blocks();
				$where="  ";
				$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($blocks->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->blockid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Nozzle</td>
				<td>
				<select name='nozzleid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$nozzles=new Nozzles();
				$where="  ";
				$fields="prod_nozzles.id, prod_nozzles.name, prod_nozzles.remarks, prod_nozzles.ipaddress, prod_nozzles.createdby, prod_nozzles.createdon, prod_nozzles.lasteditedby, prod_nozzles.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$nozzles->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($nozzles->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->nozzleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Spray Method</td>
				<td>
				<select name='spraymethodid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$spraymethods=new Spraymethods();
				$where="  ";
				$fields="prod_spraymethods.id, prod_spraymethods.name, prod_spraymethods.remarks, prod_spraymethods.ipaddress, prod_spraymethods.createdby, prod_spraymethods.createdon, prod_spraymethods.lasteditedby, prod_spraymethods.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$spraymethods->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($spraymethods->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->spraymethodid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Created by</td>
			
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from prod_sprayprogrammes) ";
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
			<tr>
				<td>Spray Date</td>
				<td><strong>From:</strong><input type='text' id='fromspraydate' size='12' name='fromspraydate' readonly class="date_input" value='<?php echo $obj->fromspraydate;?>'/>
							<br/><strong>To:</strong><input type='text' id='tospraydate' size='12' name='tospraydate' readonly class="date_input" value='<?php echo $obj->tospraydate;?>'/></td>
			</tr>
			<tr>
				<td>Time</td>
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				
				<td><input type='checkbox' name='grvarietyid' value='1' <?php if(isset($_POST['grvarietyid']) ){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='grchemicalid' value='1' <?php if(isset($_POST['grchemicalid']) ){echo"checked";}?>>&nbsp;Chemical</td>
				<td><input type='checkbox' name='grnozzleid' value='1' <?php if(isset($_POST['grnozzleid']) ){echo"checked";}?>>&nbsp;Nozzles</td>
			<tr>
				<td><input type='checkbox' name='grspraymethodid' value='1' <?php if(isset($_POST['grspraymethodid']) ){echo"checked";}?>>&nbsp;Spray Methods</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
				<td><input type='checkbox' name='grspraydate' value='1' <?php if(isset($_POST['grspraydate']) ){echo"checked";}?>>&nbsp;Spray Date</td>
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
				
				<td><input type='checkbox' name='shvarietyid' value='1' <?php if(isset($_POST['shvarietyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='shchemicalid' value='1' <?php if(isset($_POST['shchemicalid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Chemical</td>
				<td><input type='checkbox' name='shingredients' value='1' <?php if(isset($_POST['shingredients']) ){echo"checked";}?>>&nbsp;Ingredients</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shwatervol' value='1' <?php if(isset($_POST['shwatervol'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Watervol</td>
			<tr>
				<td><input type='checkbox' name='shnozzleid' value='1' <?php if(isset($_POST['shnozzleid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Nozzle</td>
				<td><input type='checkbox' name='shtarget' value='1' <?php if(isset($_POST['shtarget'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Target</td>
			<tr>
				<td><input type='checkbox' name='shpraymethodid' value='1' <?php if(isset($_POST['shpraymethodid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Spray method</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shspraydate' value='1' <?php if(isset($_POST['shspraydate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Spray Date</td>
				<td><input type='checkbox' name='shtime' value='1' <?php if(isset($_POST['shtime']) ){echo"checked";}?>>&nbsp;Time</td>
			<tr>
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
			<?php if($obj->shchemicalid==1  or empty($obj->action)){ ?>
				<th>Chemical </th>
			<?php } ?>
			<?php if($obj->shingredients==1 ){ ?>
				<th>Ingredients </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Chemical Quantity </th>
			<?php } ?>
			<?php if($obj->shwatervol==1  or empty($obj->action)){ ?>
				<th>Volume Of Water Used </th>
			<?php } ?>
			<?php if($obj->shnozzleid==1  or empty($obj->action)){ ?>
				<th>Nozzle Used </th>
			<?php } ?>
			<?php if($obj->shtarget==1  or empty($obj->action)){ ?>
				<th>Target Pests & Diseases </th>
			<?php } ?>
			<?php if($obj->shpraymethodid==1  or empty($obj->action)){ ?>
				<th>Spraymethod </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created By </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On </th>
			<?php } ?>
			<?php if($obj->shspraydate==1  or empty($obj->action)){ ?>
				<th>Spray Date </th>
			<?php } ?>
			<?php if($obj->shtime==1 ){ ?>
				<th>Spray Time </th>
			<?php } ?>
			<?php if($obj->shgreenhouseid==1  or empty($obj->action)){ ?>
				<th>Green house </th>
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
