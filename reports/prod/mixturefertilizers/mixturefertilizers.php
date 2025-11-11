<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/mixturefertilizers/Mixturefertilizers_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/mixturefertilizers/Mixturefertilizers_class.php");
require_once("../../../modules/prod/irrigationfetilizers/Irrigationfetilizers_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Mixturefertilizers";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9270";//Report View
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
if(!empty($obj->grmixtureid) or !empty($obj->grfertilizerid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shmixtureid='';
	$obj->shfertilizerid='';
	$obj->shquantity='';
	$obj->shremarks='';
	$obj->shipaddress='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
}


	$obj->sh=1;


if(!empty($obj->grmixtureid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" mixtureid ";
	$obj->shmixtureid=1;
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
	if(!empty($obj->shmixtureid)  or empty($obj->action)){
		array_push($sColumns, 'mixtureid');
		array_push($aColumns, "prod_irrigationmixtures.name as mixtureid");
		$rptjoin.=" left join prod_irrigationmixtures on prod_irrigationmixtures.id=prod_mixturefertilizers.mixtureid ";
		$k++;
		}

	if(!empty($obj->shfertilizerid)  or empty($obj->action)){
		array_push($sColumns, 'fertilizerid');
		array_push($aColumns, "prod_fertilizers.name as fertilizerid");
		$rptjoin.=" left join prod_fertilizers on prod_fertilizers.id=prod_mixturefertilizers.fertilizerid ";
		$k++;
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "prod_mixturefertilizers.quantity");
		$k++;
		}

	if(!empty($obj->shremarks)  or empty($obj->action)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_mixturefertilizers.remarks");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "prod_mixturefertilizers.ipaddress");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "prod_mixturefertilizers.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "prod_mixturefertilizers.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->mixtureid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_mixturefertilizers.mixtureid='$obj->mixtureid'";
		$join=" left join prod_mixturefertilizers on prod_mixturefertilizers.id=prod_mixturefertilizers.mixturefertilizerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->fertilizerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_mixturefertilizers.fertilizerid='$obj->fertilizerid'";
		$join=" left join prod_irrigationfetilizers on prod_mixturefertilizers.id=prod_irrigationfetilizers.mixturefertilizerid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_mixturefertilizers.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_mixturefertilizers.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_mixturefertilizers.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#fertilizername").autocomplete({
	source:"../../../modules/server/server/search.php?main=prod&module=irrigationfetilizers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#fertilizerid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="prod_mixturefertilizers";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_mixturefertilizers",
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
<form  action="mixturefertilizers.php" method="post" name="mixturefertilizers" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Mixture</td>
				<td>
				<select name='mixtureid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$mixturefertilizers=new Mixturefertilizers();
				$where="  ";
				$fields="prod_mixturefertilizers.id, prod_mixturefertilizers.mixtureid, prod_mixturefertilizers.fertilizerid, prod_mixturefertilizers.quantity, prod_mixturefertilizers.remarks, prod_mixturefertilizers.ipaddress, prod_mixturefertilizers.createdby, prod_mixturefertilizers.createdon, prod_mixturefertilizers.lasteditedby, prod_mixturefertilizers.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$mixturefertilizers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($mixturefertilizers->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->mixtureid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Fertilizers</td>
				<td><input type='text' size='20' name='fertilizername' id='fertilizername' value='<?php echo $obj->fertilizername; ?>'>
					<input type="hidden" name='fertilizerid' id='fertilizerid' value='<?php echo $obj->field; ?>'></td>
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
				<td><input type='checkbox' name='grmixtureid' value='1' <?php if(isset($_POST['grmixtureid']) ){echo"checked";}?>>&nbsp;Mixture</td>
				<td><input type='checkbox' name='grfertilizerid' value='1' <?php if(isset($_POST['grfertilizerid']) ){echo"checked";}?>>&nbsp;Fertilizers</td>
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
				<td><input type='checkbox' name='shmixtureid' value='1' <?php if(isset($_POST['shmixtureid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Mixture</td>
				<td><input type='checkbox' name='shfertilizerid' value='1' <?php if(isset($_POST['shfertilizerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Fertilizers</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created on</td>
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
			<?php if($obj->shmixtureid==1  or empty($obj->action)){ ?>
				<th>Mixture </th>
			<?php } ?>
			<?php if($obj->shfertilizerid==1  or empty($obj->action)){ ?>
				<th>Fertilizer </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
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
