<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Items";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8811";//Report View
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
if(!empty($obj->grname) ){
	$obj->shcode='';
	$obj->shname='';
	$obj->shreorderlevel='';
	$obj->shquantity='';
	//$obj->shreorderquantity='';
}


	$obj->sh=1;


if(!empty($obj->grname)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" name ";
	$obj->shname=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shcode)  or empty($obj->action)){
		array_push($sColumns, 'code');
		array_push($aColumns, "inv_items.code");
		$k++;
		}

	if(!empty($obj->shname)  or empty($obj->action)){
		array_push($sColumns, 'name');
		array_push($aColumns, "inv_items.name");
		$k++;
		}

	if(!empty($obj->shreorderlevel)  or empty($obj->action)){
		array_push($sColumns, 'reorderlevel');
		array_push($aColumns, "inv_items.reorderlevel");
		$k++;
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "inv_items.quantity");
		$k++;
		
		array_push($sColumns, 'balance');
		array_push($aColumns, "(inv_items.quantity-inv_items.reorderlevel) balance");
		$k++;
		
		}

// 	if(!empty($obj->shreorderquantity)  or empty($obj->action)){
// 		array_push($sColumns, 'reorderquantity');
// 		array_push($aColumns, "inv_items.reorderquantity");
// 		$k++;
// 		}



$track=0;
$rptwhere=" inv_items.quantity<=inv_items.reorderlevel and inv_items.status='Active' and inv_items.reorderlevel>0 ";
$track++;
//processing filters
if(!empty($obj->code)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.code='$obj->code'";
	$track++;
}

if(!empty($obj->name)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_items.name='$obj->name'";
		$join=" left join inv_items on inv_items.id=inv_items.itemid ";
		
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#naname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#name").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="inv_items";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=inv_items",
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
<form  action="items.php" method="post" name="items" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Code</td>
				<td><input type='text' id='code' size='20' name='code' value='<?php echo $obj->code;?>'></td>
			</tr>
			<tr>
				<td>Name</td>
				<td><input type='text' size='20' name='naname' id='naname' value='<?php echo $obj->naname; ?>'>
					<input type="hidden" name='name' id='name' value='<?php echo $obj->field; ?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grname' value='1' <?php if(isset($_POST['grname']) ){echo"checked";}?>>&nbsp;Name</td>
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
				<td><input type='checkbox' name='shcode' value='1' <?php if(isset($_POST['shcode'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Code</td>
				<td><input type='checkbox' name='shname' value='1' <?php if(isset($_POST['shname'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Name</td>
			<tr>
				<td><input type='checkbox' name='shreorderlevel' value='1' <?php if(isset($_POST['shreorderlevel'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Reorder level</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			
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
			<?php if($obj->shcode==1  or empty($obj->action)){ ?>
				<th>Code </th>
			<?php } ?>
			<?php if($obj->shname==1  or empty($obj->action)){ ?>
				<th>Name </th>
			<?php } ?>
			<?php if($obj->shreorderlevel==1  or empty($obj->action)){ ?>
				<th>Reorder Level </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
				<th>Balance </th>
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
