<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/greenhousevarietys/Greenhousevarietys_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/greenhouses/Greenhouses_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Greenhousevarietys";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9061";//Add
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
if(!empty($obj->grgreenhouseid) or !empty($obj->grvarietyid) or !empty($obj->gremployeeid) or !empty($obj->grplantedon) or !empty($obj->grcreatedon) or !empty($obj->grcreatedby) ){
	$obj->shgreenhouseid='';
	$obj->shvarietyid='';
	$obj->shheadsize='';
	$obj->shemployeeid='';
	$obj->sharea='';
	$obj->shplantedon='';
	$obj->shofbeds='';
	$obj->shremarks='';
	$obj->shipaddress='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
}


	$obj->sh=1;


if(!empty($obj->grgreenhouseid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" greenhouseid ";
	$obj->shgreenhouseid=1;
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

if(!empty($obj->gremployeeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employeeid ";
	$obj->shemployeeid=1;
	$track++;
}

if(!empty($obj->grplantedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" plantedon ";
	$obj->shplantedon=1;
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

//processing columns to show
	if(!empty($obj->shgreenhouseid)  or empty($obj->action)){
		array_push($sColumns, 'greenhouseid');
		array_push($aColumns, "prod_greenhousevarietys.greenhouseid");
		$k++;
		}

	if(!empty($obj->shvarietyid)  or empty($obj->action)){
		array_push($sColumns, 'varietyid');
		array_push($aColumns, "prod_greenhousevarietys.varietyid");
		$k++;
		}

	if(!empty($obj->shheadsize)  or empty($obj->action)){
		array_push($sColumns, 'headsize');
		array_push($aColumns, "prod_greenhousevarietys.headsize");
		$k++;
		}

	if(!empty($obj->shemployeeid) ){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=prod_greenhousevarietys.employeeid ";
		$k++;
		}

	if(!empty($obj->sharea)  or empty($obj->action)){
		array_push($sColumns, 'area');
		array_push($aColumns, "prod_greenhousevarietys.area");
		$k++;
		}

	if(!empty($obj->shplantedon)  or empty($obj->action)){
		array_push($sColumns, 'plantedon');
		array_push($aColumns, "prod_greenhousevarietys.plantedon");
		$k++;
		}

	if(!empty($obj->noofbeds)  or empty($obj->action)){
		array_push($sColumns, 'ofbeds');
		array_push($aColumns, "prod_greenhousevarietys.noofbeds");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_greenhousevarietys.remarks");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "prod_greenhousevarietys.ipaddress");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "prod_greenhousevarietys.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon) ){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "prod_greenhousevarietys.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->fromgreenhouseid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.greenhouseid>='$obj->fromgreenhouseid'";
	$track++;
}

if(!empty($obj->togreenhouseid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.greenhouseid<='$obj->togreenhouseid'";
		$join=" left join prod_greenhouses on prod_greenhouses.greenhousevarietyid=prod_greenhousevarietys.id ";
		
	$track++;
}

if(!empty($obj->fromvarietyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.varietyid>='$obj->fromvarietyid'";
	$track++;
}

if(!empty($obj->tovarietyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.varietyid<='$obj->tovarietyid'";
		$join=" left join prod_varietys on prod_varietys.greenhousevarietyid=prod_greenhousevarietys.id ";
		
	$track++;
}

if(!empty($obj->fromemployeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.employeeid>='$obj->fromemployeeid'";
	$track++;
}

if(!empty($obj->toemployeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.employeeid<='$obj->toemployeeid'";
		$join=" left join hrm_employees on hrm_employees.greenhousevarietyid=prod_greenhousevarietys.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->fromplantedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.plantedon>='$obj->fromplantedon'";
	$track++;
}

if(!empty($obj->toplantedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.plantedon<='$obj->toplantedon'";
	$track++;
}

if(!empty($obj->fromcreatedby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.createdby>='$obj->fromcreatedby'";
	$track++;
}

if(!empty($obj->tocreatedby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.createdby<='$obj->tocreatedby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_greenhousevarietys.createdon<='$obj->tocreatedon'";
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
  $("#varietyname").autocomplete({
	source:"../../../modules/server/server/search.php?main=prod&module=varietys&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#varietyid").val(ui.item.id);
	}
  });

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
 <?php $_SESSION['sTable']="prod_greenhousevarietys";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_greenhousevarietys",
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
<form  action="greenhousevarietys.php" method="post" name="greenhousevarietys" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
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
				<td>Variety</td>
				<td><input type='text' size='20' name='varietyname' id='varietyname' value='<?php echo $obj->varietyname; ?>'>
					<input type="hidden" name='varietyid' id='varietyid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Planted On</td>
				<td><strong>From:</strong><input type='text' id='fromplantedon' size='12' name='fromplantedon' readonly class="date_input" value='<?php echo $obj->fromplantedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toplantedon' size='12' name='toplantedon' readonly class="date_input" value='<?php echo $obj->toplantedon;?>'/></td>
			</tr>
			<tr>
				<td>Created by</td>
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
				<td><input type='checkbox' name='grgreenhouseid' value='1' <?php if(isset($_POST['grgreenhouseid']) ){echo"checked";}?>>&nbsp;Green House</td>
				<td><input type='checkbox' name='grvarietyid' value='1' <?php if(isset($_POST['grvarietyid']) ){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='grplantedon' value='1' <?php if(isset($_POST['grplantedon']) ){echo"checked";}?>>&nbsp;Planted On</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
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
				<td><input type='checkbox' name='shgreenhouseid' value='1' <?php if(isset($_POST['shgreenhouseid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Green House</td>
				<td><input type='checkbox' name='shvarietyid' value='1' <?php if(isset($_POST['shvarietyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='shheadsize' value='1' <?php if(isset($_POST['shheadsize'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Head Size</td>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='sharea' value='1' <?php if(isset($_POST['sharea'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Area</td>
				<td><input type='checkbox' name='shplantedon' value='1' <?php if(isset($_POST['shplantedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Planted On</td>
			<tr>
				<td><input type='checkbox' name='noofbeds' value='1' <?php if(isset($_POST['noofbeds'])  or empty($obj->action)){echo"checked";}?>>&nbsp;No of beds</td>
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
			<?php if($obj->shgreenhouseid==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shvarietyid==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shheadsize==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->sharea==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shplantedon==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->noofbeds==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
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
