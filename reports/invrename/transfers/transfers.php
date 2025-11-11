<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/transfers/Transfers_class.php");
require_once("../../../modules/inv/transferdetails/Transferdetails_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/sys/branches/Branches_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Transfers";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9357";//Report View
$auth->levelid=$_SESSION['level'];

//auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromtransferedon=date('Y-m-d');
	$obj->totransferedon=date('Y-m-d');
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
if(!empty($obj->grdocumentno) or !empty($obj->gritemid) or !empty($obj->grquantity) or !empty($obj->grmemo) or !empty($obj->grtransferedon)  or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->grbrancheid) or !empty($obj->grtobrancheid) ){
	$obj->shdocumentno='';
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shremarks='';
	$obj->shtransferedon='';
	$obj->shmemo='';
	$obj->shstatus='';
	$obj->shnote='';
	$obj->shipaddress='';
	$obj->shcreatedon='';
	$obj->shcreatedby='';
	$obj->shbrancheid='';
	$obj->shtobrancheid='';
	$obj->shstatus='';
	$obj->shcode='';
	
}


	$obj->sh=1;
	$obj->shquantity=1;
	$obj->shitemid=1;


if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
	$track++;
}

if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
	
	$track++;
}


if(!empty($obj->grquantity)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" quantity ";
	$obj->shquantity=1;
	$track++;
}

if(!empty($obj->grmemo)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" memo ";
	$obj->shmemo=1;
	$track++;
}


if(!empty($obj->grtransferedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" transferedon ";
	$obj->shtransferedon=1;
	$track++;
}

if(!empty($obj->grstatus)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" status ";
	$obj->shstatus=1;
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

if(!empty($obj->grbrancheid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" brancheid ";
	$obj->shbrancheid=1;
	$track++;
}

if(!empty($obj->grtobrancheid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" tobrancheid ";
	$obj->shtobrancheid=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "inv_transfers.documentno");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name as itemid");
		$k++;
		$join=" left join inv_transferdetails on inv_transfers.id=inv_transferdetails.transferid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=inv_transferdetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
				
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "inv_transferdetails.quantity");
		$k++;
		$join=" left join inv_transferdetails on inv_transfers.id=inv_transferdetails.transferid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shremarks)  or empty($obj->action)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "inv_transfers.remarks");
		$k++;
		}

	if(!empty($obj->shtransferedon)  or empty($obj->action)){
		array_push($sColumns, 'transferedon');
		array_push($aColumns, "inv_transfers.transferedon");
		$k++;
		}

	if(!empty($obj->shmemo)  or empty($obj->action)){
		array_push($sColumns, 'memo');
		array_push($aColumns, "inv_transferdetails.memo");
		$k++;
		$join=" left join inv_transferdetails on inv_transfers.id=inv_transferdetails.transferid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shrequisitionno) or empty($obj->action)){
		array_push($sColumns, 'requisitionno');
		array_push($aColumns, "inv_transfers.requisitionno");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "inv_transfers.ipaddress");
		$k++;
		}

	if(!empty($obj->shcreatedon) ){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "inv_transfers.createdon");
		$k++;
		}

      if(!empty($obj->shcreatedby) ){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=inv_transfers.createdby ";
	}

	if(!empty($obj->shbrancheid) or empty($obj->action)){
		array_push($sColumns, 'brancheid');
		array_push($aColumns, "sys_branches.name brancheid");
		$join=" left join sys_branches on sys_branches.id=inv_transfers.brancheid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		}

	if(!empty($obj->shtobrancheid) or empty($obj->action)){
		array_push($sColumns, 'tobrancheid');
		array_push($aColumns, "branches2.name tobrancheid");
		$join=" left join sys_branches branches2 on branches2.id=inv_transfers.tobrancheid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
		
		}
		
		



	

	



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_transfers.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.id='$obj->itemid' ";
	$join=" left join inv_transferdetails on inv_transfers.id=inv_transferdetails.transferid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}

if(!empty($obj->fromtransferedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_transfers.transferedon>='$obj->fromtransferedon'";
	$track++;
}

if(!empty($obj->totransferedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_transfers.transferedon<='$obj->totransferedon'";
	$track++;
}



if(!empty($obj->fromgrcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_transfers.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->togrcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_transfers.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->grcreatedby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_transfers.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->brancheid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_transfers.brancheid='$obj->brancheid'";
		
	$track++;
}

if(!empty($obj->tobrancheid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_transfers.tobrancheid='$obj->tobrancheid'";
		
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
	appendTo: "#myModal",focus: function(event, ui) {
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
 <?php $_SESSION['sTable']="inv_transfers";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=inv_transfers",
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
<form  action="transfers.php" method="post" name="transfers" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>documentno</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Itemid</td>
				<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Transfered on</td>
				<td><strong>From:</strong><input type='text' id='fromtransferedon' size='12' name='fromtransferedon' readonly class="date_input" value='<?php echo $obj->fromtransferedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='totransferedon' size='12' name='totransferedon' readonly class="date_input" value='<?php echo $obj->totransferedon;?>'/></td>
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
				$fields="*";
				$where="";
				$join="";
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
			<tr>
				<td>From Branch</td>
				<td>
				<select name='brancheid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$branches=new Branches();
				$where="  ";
				$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($branches->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->brancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>To Branch</td>
				<td>
				<select name='tobrancheid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$branches2=new Branches();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$branches2->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($branches2->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->tobrancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) or empty($obj->action)){echo"checked";}?>>&nbsp;documentno</td>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) or empty($obj->action)){echo"checked";}?>>&nbsp;Itemid</td>
			<tr>
				<td><input type='checkbox' name='grquantity' value='1' <?php if(isset($_POST['grquantity']) or empty($obj->action) ){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='grmemo' value='1' <?php if(isset($_POST['grmemo']) or empty($obj->action)){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='grtransferedon' value='1' <?php if(isset($_POST['grtransferedon']) ){echo"checked";}?>>&nbsp;Transfered on</td>
			
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
			<tr>
				<td><input type='checkbox' name='grbrancheid' value='1' <?php if(isset($_POST['grbrancheid']) or empty($obj->action)){echo"checked";}?>>&nbsp;Branch</td>
				<td><input type='checkbox' name='grtobrancheid' value='1' <?php if(isset($_POST['grtobrancheid']) or empty($obj->action)){echo"checked";}?>>&nbsp;To Branch</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;documentno</td>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Itemid</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) or empty($obj->action)){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shtransferedon' value='1' <?php if(isset($_POST['shtransferedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Transfered on</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) or empty($obj->action)){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				
				<td><input type='checkbox' name='shrequisitionno' value='1' <?php if(isset($_POST['shrequisitionno']) or empty($obj->action)){echo"checked";}?>>&nbsp;Requisition No</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
				<td><input type='checkbox' name='shbrancheid' value='1' <?php if(isset($_POST['shbrancheid']) or empty($obj->action) ){echo"checked";}?>>&nbsp;Branch</td>
			<tr>
				<td><input type='checkbox' name='shtobrancheid' value='1' <?php if(isset($_POST['shtobrancheid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;To Branch</td>
			
				
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
<table style="clear:both;"  class="table" id="tbl" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Transfer No </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Product </th>	
				
			<?php } ?>
			<?php if($obj->shquantity==1 or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shremarks==1 or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shtransferedon==1 or empty($obj->action)){ ?>
				<th>Transfered On </th>
			<?php } ?>
			<?php if($obj->shmemo==1 or empty($obj->action)){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shrequisitionno==1 or empty($obj->action)){ ?>
				<th>Requisition No </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
				<th>Created On </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  ){ ?>
				<th>Created By </th>
			<?php } ?>
			<?php if($obj->shbrancheid==1 or empty($obj->action)){ ?>
				<th>From Branch </th>
			<?php } ?>
			<?php if($obj->shtobrancheid==1  or empty($obj->action)){ ?>
				<th>To Branch </th>
			<?php } ?>
			
			
			
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<?php
include"../../../foot.php";
?>