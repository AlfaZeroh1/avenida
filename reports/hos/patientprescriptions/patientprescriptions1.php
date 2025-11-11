<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hos/patientprescriptions/Patientprescriptions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Patientprescriptions";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8733";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromcreatedon=date('Y-m-d');
	$obj->tocreatedon=date('Y-m-d');
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
if(!empty($obj->gritemid) or !empty($obj->grprice) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shitemid='';
	$obj->shpatienttreatmentid='';
	$obj->shquantity='';
	$obj->shprice='';
	$obj->shfrequency='';
	$obj->shTotals='';
	$obj->shduration='';
	$obj->shissued='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
}


	$obj->sh=1;


if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
	$track++;
}

if(!empty($obj->grprice)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" price ";
	$obj->shprice=1;
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
	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name as itemid");
		$rptjoin.=" left join inv_items on inv_items.id=hos_patientprescriptions.itemid ";
		$k++;
		}
		
		

	if(!empty($obj->shpatienttreatmentid)  or empty($obj->action)){
		array_push($sColumns, 'patienttreatmentid');
		array_push($aColumns, "hos_patienttreatments.id as patienttreatmentid");
		$rptjoin.=" left join hos_patienttreatments on hos_patienttreatments.id=hos_patientprescriptions.patienttreatmentid ";
		$k++;
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "hos_patientprescriptions.quantity");
		$k++;
		}

	if(!empty($obj->shprice)  or empty($obj->action)){
		array_push($sColumns, 'price');
		array_push($aColumns, "hos_patientprescriptions.price");
		$k++;
		}

	if(!empty($obj->shfrequency)  or empty($obj->action)){
		array_push($sColumns, 'frequency');
		array_push($aColumns, "hos_patientprescriptions.frequency");
		$k++;
		}

	if(!empty($obj->shTotals)  or empty($obj->action)){
		array_push($sColumns, 'Totals');
		array_push($aColumns, "hos_patientprescriptions.Totals");
		$k++;
		}

	if(!empty($obj->shduration) ){
		array_push($sColumns, 'duration');
		array_push($aColumns, "hos_patientprescriptions.duration");
		$k++;
		}

	if(!empty($obj->shissued) ){
		array_push($sColumns, 'issued');
		array_push($aColumns, "hos_patientprescriptions.issued");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=hos_patientprescriptions.createdby ";
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "hos_patientprescriptions.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientprescriptions.itemid='$obj->itemid'";
		
	$track++;
}

if(!empty($obj->patienttreatmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientprescriptions.patienttreatmentid='$obj->patienttreatmentid'";
	$track++;
}

if(!empty($obj->issued)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientprescriptions.issued='$obj->issued'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientprescriptions.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientprescriptions.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_patientprescriptions.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="hos_patientprescriptions";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hos_patientprescriptions",
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
<form  action="patientprescriptions.php" method="post" name="patientprescriptions" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Item Name</td>
				<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Patient Treatment</td>
				<td><input type='text' id='patienttreatmentid' size='20' name='patienttreatmentid' value='<?php echo $obj->patienttreatmentid;?>'></td>
			</tr>
			<tr>
				<td>Issued</td>
				<td><input type='text' id='issued' size='20' name='issued' value='<?php echo $obj->issued;?>'></td>
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
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item Name</td>
				<td><input type='checkbox' name='grprice' value='1' <?php if(isset($_POST['grprice']) ){echo"checked";}?>>&nbsp;Price</td>
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
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item Name</td>
				<td><input type='checkbox' name='shpatienttreatmentid' value='1' <?php if(isset($_POST['shpatienttreatmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Patient Treatment</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shprice' value='1' <?php if(isset($_POST['shprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Price</td>
			<tr>
				<td><input type='checkbox' name='shfrequency' value='1' <?php if(isset($_POST['shfrequency'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Frequency</td>
				<td><input type='checkbox' name='shTotals' value='1' <?php if(isset($_POST['shTotals'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Totals</td>
			<tr>
				<td><input type='checkbox' name='shduration' value='1' <?php if(isset($_POST['shduration']) ){echo"checked";}?>>&nbsp;Duration</td>
				<td><input type='checkbox' name='shissued' value='1' <?php if(isset($_POST['shissued']) ){echo"checked";}?>>&nbsp;Issued</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
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
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Item Name </th>
			<?php } ?>
			<?php if($obj->shpatienttreatmentid==1  or empty($obj->action)){ ?>
				<th>Treatment </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shprice==1  or empty($obj->action)){ ?>
				<th>Price </th>
			<?php } ?>
			<?php if($obj->shfrequency==1  or empty($obj->action)){ ?>
				<th>Frequency </th>
			<?php } ?>
			<?php if($obj->shTotals==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shduration==1 ){ ?>
				<th>Duration </th>
			<?php } ?>
			<?php if($obj->shissued==1 ){ ?>
				<th>Issue Status </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
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
