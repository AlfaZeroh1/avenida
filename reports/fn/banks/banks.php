<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/banks/Banks_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Banks";
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
	if(!empty($obj->shbanks)  or empty($obj->action)){
		array_push($sColumns, 'banks');
		array_push($aColumns, "fn_banks.banks");
	}

	if(!empty($obj->shbankacc) ){
		array_push($sColumns, 'bankacc');
		array_push($aColumns, "fn_banks.bankacc");
	}

	if(!empty($obj->shbankbranch)  or empty($obj->action)){
		array_push($sColumns, 'bankbranch');
		array_push($aColumns, "fn_banks.bankbranch");
	}

	if(!empty($obj->shcreatedby) ){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "fn_banks.createdby");
	}

	if(!empty($obj->shcreatedon) ){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "fn_banks.createdon");
	}

	if(!empty($obj->shlasteditedby) ){
		array_push($sColumns, 'lasteditedby');
		array_push($aColumns, "fn_banks.lasteditedby");
	}

	if(!empty($obj->shlasteditedon) ){
		array_push($sColumns, 'lasteditedon');
		array_push($aColumns, "fn_banks.lasteditedon");
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "fn_banks.ipaddress");
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->name)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_banks.name='$obj->name'";
	$track++;
}

if(!empty($obj->bankacc)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_banks.bankacc='$obj->bankacc'";
	$track++;
}

if(!empty($obj->bankbranch)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_banks.bankbranch='$obj->bankbranch'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_banks.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_banks.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_banks.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->lasteditedby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_banks.lasteditedby='$obj->lasteditedby'";
	$track++;
}

if(!empty($obj->lasteditedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_banks.lasteditedon='$obj->lasteditedon'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grbanks)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" banks ";
	$obj->shbanks=1;
	$track++;
}

if(!empty($obj->grbankbranch)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" bankbranch ";
	$obj->shbankbranch=1;
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

if(!empty($obj->grlasteditedby)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" lasteditedby ";
	$obj->shlasteditedby=1;
	$track++;
}

if(!empty($obj->grlasteditedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" lasteditedon ";
	$obj->shlasteditedon=1;
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
 <?php $_SESSION['sTable']="fn_banks";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_banks",
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
<form  action="banks.php" method="post" name="banks" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Name</td>
				<td><input type='text' id='name' size='20' name='name' value='<?php echo $obj->name;?>'></td>
			</tr>
			<tr>
				<td>Bank Account	</td>
				<td><input type='text' id='bankacc' size='20' name='bankacc' value='<?php echo $obj->bankacc;?>'></td>
			</tr>
			<tr>
				<td>Bank Branch</td>
				<td><input type='text' id='bankbranch' size='20' name='bankbranch' value='<?php echo $obj->bankbranch;?>'></td>
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
				$join=" left join  ";
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
			<tr>
				<td>Last EditedBy</td>
				<td><input type='text' id='lasteditedby' size='20' name='lasteditedby' value='<?php echo $obj->lasteditedby;?>'></td>
			</tr>
			<tr>
				<td>Last EditedOn</td>
				<td><input type='text' id='lasteditedon' size='20' name='lasteditedon' value='<?php echo $obj->lasteditedon;?>'></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grbanks' value='1' <?php if(isset($_POST['grbanks']) ){echo"checked";}?>>&nbsp;Banks</td>
				<td><input type='checkbox' name='grbankbranch' value='1' <?php if(isset($_POST['grbankbranch']) ){echo"checked";}?>>&nbsp;Bank Branch</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='grlasteditedby' value='1' <?php if(isset($_POST['grlasteditedby']) ){echo"checked";}?>>&nbsp;Last EditedBy</td>
				<td><input type='checkbox' name='grlasteditedon' value='1' <?php if(isset($_POST['grlasteditedon']) ){echo"checked";}?>>&nbsp;Last EditedOn</td>
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
				<td><input type='checkbox' name='shbanks' value='1' <?php if(isset($_POST['shbanks'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Banks</td>
				<td><input type='checkbox' name='shbankacc' value='1' <?php if(isset($_POST['shbankacc']) ){echo"checked";}?>>&nbsp;Bank Account	</td>
			<tr>
				<td><input type='checkbox' name='shbankbranch' value='1' <?php if(isset($_POST['shbankbranch'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank Branch</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shlasteditedby' value='1' <?php if(isset($_POST['shlasteditedby']) ){echo"checked";}?>>&nbsp;Last EditedBy</td>
			<tr>
				<td><input type='checkbox' name='shlasteditedon' value='1' <?php if(isset($_POST['shlasteditedon']) ){echo"checked";}?>>&nbsp;Last EditedOn</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
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
			<?php if($obj->shbanks==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shbankacc==1 ){ ?>
				<th>Bank Account </th>
			<?php } ?>
			<?php if($obj->shbankbranch==1  or empty($obj->action)){ ?>
				<th>Bank Branch </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shlasteditedby==1 ){ ?>
				<th>LastEditedBy </th>
			<?php } ?>
			<?php if($obj->shlasteditedon==1 ){ ?>
				<th>LastEditedOn </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
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
