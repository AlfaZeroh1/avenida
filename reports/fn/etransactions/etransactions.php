<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/etransactions/Etransactions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/sys/paymentmodes/Paymentmodes_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Etransactions";
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
	if(!empty($obj->shTxnid)  or empty($obj->action)){
		array_push($sColumns, 'Txnid');
		array_push($aColumns, ".name as Txnid");
		$rptjoin.=" left join  on .id=fn_etransactions.Txnid ";
	}

	if(!empty($obj->shorig)  or empty($obj->action)){
		array_push($sColumns, 'orig');
		array_push($aColumns, "fn_etransactions.orig");
	}

	if(!empty($obj->shdest)  or empty($obj->action)){
		array_push($sColumns, 'dest');
		array_push($aColumns, "fn_etransactions.dest");
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->Txnid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_etransactions.Txnid='$obj->Txnid'";
	$track++;
}

if(!empty($obj->orig)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_etransactions.orig='$obj->orig'";
	$track++;
}

if(!empty($obj->dest)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_etransactions.dest='$obj->dest'";
	$track++;
}

if(!empty($obj->paymentmodeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_etransactions.paymentmodeid='$obj->paymentmodeid'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grorig)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" orig ";
	$obj->shorig=1;
	$track++;
}

if(!empty($obj->grdest)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" dest ";
	$obj->shdest=1;
	$track++;
}

//Processing Joins
;$rptgroup='';
$track=0;
}
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="fn_etransactions";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_etransactions",
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
<form  action="etransactions.php" method="post" name="etransactions" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Transaction ID</td>
				<td><input type='text' id='Txnid' size='4' name='Txnid' value='<?php echo $obj->Txnid;?>'></td>
			</tr>
			<tr>
				<td>Orig</td>
				<td><input type='text' id='orig' size='5' name='orig' value='<?php echo $obj->orig;?>'></td>
			</tr>
			<tr>
				<td>Destination</td>
				<td><input type='text' id='dest' size='6' name='dest' value='<?php echo $obj->dest;?>'></td>
			</tr>
			<tr>
				<td>Payment Mode</td>
				<td>
				<select name='paymentmodeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$paymentmodes=new Paymentmodes();
				$where="  ";
				$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.acctypeid, sys_paymentmodes.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentmodes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->paymentmodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='grorig' value='1' <?php if(isset($_POST['grorig']) ){echo"checked";}?>>&nbsp;Orig</td>
				<td><input type='checkbox' name='grdest' value='1' <?php if(isset($_POST['grdest']) ){echo"checked";}?>>&nbsp;Destination</td>
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
				<td><input type='checkbox' name='shTxnid' value='1' <?php if(isset($_POST['shTxnid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Transaction ID</td>
				<td><input type='checkbox' name='shorig' value='1' <?php if(isset($_POST['shorig'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Orig</td>
			<tr>
				<td><input type='checkbox' name='shdest' value='1' <?php if(isset($_POST['shdest'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Destination</td>
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
			<?php if($obj->shTxnid==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shorig==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shdest==1  or empty($obj->action)){ ?>
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
