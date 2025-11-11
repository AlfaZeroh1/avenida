<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/itemstocks/Itemstocks_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Itemstocks";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9125";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromrecordedon=date('Y-m-d');
	$obj->torecordedon=date('Y-m-d');
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
if(!empty($obj->grdocumentno) or !empty($obj->gritemid) or !empty($obj->grcustomerid) or !empty($obj->grrecordedon) or !empty($obj->gractedon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->grsizeid) ){
	$obj->shdocumentno='';
	$obj->shitemid='';
 	$obj->shcustomerid='';
	$obj->shtransaction='';
	$obj->shquantity='';
	$obj->shremain='';
 	$obj->shrecordedon='';
 	$obj->shactedon='';
 	$obj->shcreatedby='';
 	$obj->shcreatedon='';
 	$obj->shsizeid='';
}


	$obj->shquantity=1;
	$obj->shsizeid=1;


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

if(!empty($obj->grcustomerid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" customerid ";
	$obj->shcustomerid=1;
	$track++;
}

if(!empty($obj->grrecordedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" recordedon ";
	$obj->shrecordedon=1;
	$track++;
}

if(!empty($obj->gractedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" actedon ";
	$obj->shactedon=1;
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

if(!empty($obj->grsizeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" sizeid ";
	$obj->shsizeid=1;
	$track++;
}

//processing columns to show
// 	if(!empty($obj->shdocumentno)  or empty($obj->action)){
// 		array_push($sColumns, 'documentno');
// 		array_push($aColumns, "pos_itemstocks.documentno");
// 		$k++;
// 		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_items.name as itemid");
		$rptjoin.=" left join pos_items on pos_items.id=pos_itemstocks.itemid ";
		$k++;
		}

// 	if(!empty($obj->shcustomerid)  or empty($obj->action)){
// 		array_push($sColumns, 'customerid');
// 		array_push($aColumns, "crm_customers.name as customerid");
// 		$rptjoin.=" left join crm_customers on crm_customers.id=pos_itemstocks.customerid ";
// 		$k++;
// 		}

// 	if(!empty($obj->shtransaction)  or empty($obj->action)){
// 		array_push($sColumns, 'transaction');
// 		array_push($aColumns, "pos_itemstocks.transaction");
// 		$k++;
// 		}

// 	if(!empty($obj->shquantity)  or empty($obj->action)){
// 		array_push($sColumns, 'quantity');
// 		if(!empty($rptgroup)){
// 			array_push($aColumns, "sum(pos_itemstocks.quantity) quantity");
// 		}else{
// 		array_push($aColumns, "pos_itemstocks.quantity");
// 		}
// 
// 		$k++;
// 		}

// 	if(!empty($obj->shremain)  or empty($obj->action)){
// 		array_push($sColumns, 'remain');
// 		array_push($aColumns, "pos_itemstocks.remain");
// 		$k++;
// 		}

// 	if(!empty($obj->shrecordedon)  or empty($obj->action)){
// 		array_push($sColumns, 'recordedon');
// 		array_push($aColumns, "pos_itemstocks.recordedon");
// 		$k++;
// 		}

// 	if(!empty($obj->shactedon)  or empty($obj->action)){
// 		array_push($sColumns, 'actedon');
// 		array_push($aColumns, "pos_itemstocks.actedon");
// 		$k++;
// 		}

// 	if(!empty($obj->shcreatedby)  or empty($obj->action)){
// 		array_push($sColumns, 'createdby');
// 		array_push($aColumns, "pos_itemstocks.createdby");
// 		$k++;
// 		}

// 	if(!empty($obj->shcreatedon)  or empty($obj->action)){
// 		array_push($sColumns, 'createdon');
// 		array_push($aColumns, "pos_itemstocks.createdon");
// 		$k++;
// 		}

// 	if(!empty($obj->shsizeid)  or empty($obj->action)){
// 		array_push($sColumns, 'sizeid');
// 		array_push($aColumns, "pos_itemstocks.sizeid");
// 		$k++;
// 		}



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.itemid='$obj->itemid'";
		$join=" left join pos_items on pos_itemstocks.id=pos_items.itemstockid ";
		
	$track++;
}

if(!empty($obj->customerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.customerid='$obj->customerid'";
		$join=" left join crm_customers on pos_itemstocks.id=crm_customers.itemstockid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->transaction)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.transaction='$obj->transaction'";
	$track++;
}

if(!empty($obj->fromrecordedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.recordedon>='$obj->fromrecordedon'";
	$track++;
}

if(!empty($obj->torecordedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.recordedon<='$obj->torecordedon'";
	$track++;
}

if(!empty($obj->fromactedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.actedon>='$obj->fromactedon'";
	$track++;
}

if(!empty($obj->toactedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.actedon<='$obj->toactedon'";
	$track++;
}

if(!empty($obj->fromcreatedby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.createdby>='$obj->fromcreatedby'";
	$track++;
}

if(!empty($obj->tocreatedby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.createdby<='$obj->tocreatedby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->sizeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_itemstocks.sizeid='$obj->sizeid'";
		$join=" left join pos_sizes on pos_itemstocks.id=pos_sizes.itemstockid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
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
	source:"../../../modules/server/server/search.php?main=pos&module=items&field=name",
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

  $("#customername").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=customers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#customerid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
<?php
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
    $cols=" sum(case when sizeid=$rw->id then pos_itemstocks.quantity end) '$rw->name'";
    array_push($aColumns, $cols);
    array_push($sColumns, $rw->name);
    
    $k++;
  }
  
  if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "sum(pos_itemstocks.quantity) quantity");
		$k++;
		}
?>

 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_itemstocks";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_itemstocks",
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
<form  action="itemstocks.php" method="post" name="itemstocks" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document no</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Product</td>
				<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Customer</td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Transaction</td>
				<td><input type='text' id='transaction' size='20' name='transaction' value='<?php echo $obj->transaction;?>'></td>
			</tr>
			<tr>
				<td>Recorded on </td>
				<td><strong>From:</strong><input type='text' id='fromrecordedon' size='12' name='fromrecordedon' readonly class="date_input" value='<?php echo $obj->fromrecordedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='torecordedon' size='12' name='torecordedon' readonly class="date_input" value='<?php echo $obj->torecordedon;?>'/></td>
			</tr>
			<tr>
				<td>Acted on</td>
				<td><strong>From:</strong><input type='text' id='fromactedon' size='12' name='fromactedon' readonly class="date_input" value='<?php echo $obj->fromactedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toactedon' size='12' name='toactedon' readonly class="date_input" value='<?php echo $obj->toactedon;?>'/></td>
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
				<td>Created On</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
			</tr>
			<tr>
				<td>Size </td>
				<td>
				<select name='sizeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$sizes=new Sizes();
				$where="  ";
				$fields="pos_sizes.id, pos_sizes.name, pos_sizes.remarks, pos_sizes.ipaddress, pos_sizes.createdby, pos_sizes.createdon, pos_sizes.lasteditedby, pos_sizes.lasteditedon";
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document no</td>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Product</td>
			<tr>
				<td><input type='checkbox' name='grcustomerid' value='1' <?php if(isset($_POST['grcustomerid']) ){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='grrecordedon' value='1' <?php if(isset($_POST['grrecordedon']) ){echo"checked";}?>>&nbsp;Recorded on </td>
			<tr>
				<td><input type='checkbox' name='gractedon' value='1' <?php if(isset($_POST['gractedon']) ){echo"checked";}?>>&nbsp;Acted on</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grsizeid' value='1' <?php if(isset($_POST['grsizeid']) ){echo"checked";}?>>&nbsp;Size </td>
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
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Product</td>
			<tr>
				<td><input type='checkbox' name='shremain' value='1' <?php if(isset($_POST['shremain'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remain</td>
			
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
				<th>Product </th>
			<?php } ?>
			
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
</div>
</div>
</div>
</div>
</div>
