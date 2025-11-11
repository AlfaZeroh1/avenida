<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/sales/Sales_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");
require_once("../../../modules/crm/agents/Agents_class.php");
require_once("../../../modules/pos/sales/Sales_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Sales";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8723";//Report View
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
if(!empty($obj->gritemid) or !empty($obj->grdocumentno) or !empty($obj->grcustomerid) or !empty($obj->gragentid) or !empty($obj->grsoldon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->grmode) or !empty($obj->grsaleid) ){
	$obj->shitemid='';
	$obj->shdocumentno='';
	$obj->shcustomerid='';
	$obj->shagentid='';
	$obj->shremarks='';
	$obj->shquantity='';
	$obj->shcostprice='';
	$obj->shtradeprice='';
	$obj->shretailprice='';
	$obj->shdiscount='';
	$obj->shtax='';
	$obj->shnus='';
	$obj->shtotal='';
	$obj->shmode='';
	$obj->shsoldon='';
	$obj->shexpirydate='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shsaleid='';
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

if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
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

if(!empty($obj->gragentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" agentid ";
	$obj->shagentid=1;
	$track++;
}

if(!empty($obj->grsoldon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" soldon ";
	$obj->shsoldon=1;
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

if(!empty($obj->grmode)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" mode ";
	$obj->shmode=1;
	$track++;
}

if(!empty($obj->grsaleid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" saleid ";
	$obj->shsaleid=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_sales.itemid");
		$k++;
		$join=" left join pos_saledetails on pos_sales.id=pos_saledetails.saleid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_saledetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "pos_sales.documentno");
		$k++;
		}

	if(!empty($obj->shcustomerid)  or empty($obj->action)){
		array_push($sColumns, 'customerid');
		array_push($aColumns, "crm_customers.name as customerid");
		$rptjoin.=" left join crm_customers on crm_customers.id=pos_sales.customerid ";
		$k++;
		}

	if(!empty($obj->shagentid) ){
		array_push($sColumns, 'agentid');
		array_push($aColumns, "crm_agents.name as agentid");
		$rptjoin.=" left join crm_agents on crm_agents.id=pos_sales.agentid ";
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "pos_sales.remarks");
		$k++;
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "pos_sales.quantity");
		$k++;
		$join=" left join pos_saledetails on pos_sales.id=pos_saledetails.saleid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_saledetails.quantity ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shcostprice)  or empty($obj->action)){
		array_push($sColumns, 'costprice');
		array_push($aColumns, "pos_sales.costprice");
		$k++;
		$join=" left join pos_saledetails on pos_sales.id=pos_saledetails.saleid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_saledetails.costprice ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shtradeprice)  or empty($obj->action)){
		array_push($sColumns, 'tradeprice');
		array_push($aColumns, "pos_sales.tradeprice");
		$k++;
		$join=" left join pos_saledetails on pos_sales.id=pos_saledetails.saleid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_saledetails.tradeprice ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shretailprice)  or empty($obj->action)){
		array_push($sColumns, 'retailprice');
		array_push($aColumns, "pos_sales.retailprice");
		$k++;
		$join=" left join pos_saledetails on pos_sales.id=pos_saledetails.saleid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_saledetails.retailprice ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shdiscount) ){
		array_push($sColumns, 'discount');
		array_push($aColumns, "pos_sales.discount");
		$k++;
		}

	if(!empty($obj->shtax) ){
		array_push($sColumns, 'tax');
		array_push($aColumns, "pos_sales.tax");
		$k++;
		$join=" left join pos_saledetails on pos_sales.id=pos_saledetails.saleid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_saledetails.tax ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->bonus) ){
		array_push($sColumns, 'nus');
		array_push($aColumns, "pos_sales.nus");
		$k++;
		$join=" left join pos_saledetails on pos_sales.id=pos_saledetails.saleid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_saledetails.nus ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shtotal)  or empty($obj->action)){
		array_push($sColumns, 'total');
		array_push($aColumns, "pos_sales.total");
		$k++;
		$join=" left join pos_saledetails on pos_sales.id=pos_saledetails.saleid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_saledetails.total ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shmode) ){
		array_push($sColumns, 'mode');
		array_push($aColumns, "pos_sales.mode");
		$k++;
		}

	if(!empty($obj->shsoldon)  or empty($obj->action)){
		array_push($sColumns, 'soldon');
		array_push($aColumns, "pos_sales.soldon");
		$k++;
		}

	if(!empty($obj->shexpirydate) ){
		array_push($sColumns, 'expirydate');
		array_push($aColumns, "pos_sales.expirydate");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "pos_sales.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "pos_sales.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "pos_sales.ipaddress");
		$k++;
		}

	if(!empty($obj->shsaleid) ){
		array_push($sColumns, 'saleid');
		array_push($aColumns, "pos_sales.saleid");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" pos_items.id='$obj->itemid' ";
	$join=" left join pos_saledetails on pos_sales.id=pos_saledetails.saleid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join pos_items on pos_items.id=pos_saledetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->customerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.customerid='$obj->customerid'";
		$join=" left join crm_customers on pos_sales.id=crm_customers.saleid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->agentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.agentid='$obj->agentid'";
		$join=" left join crm_agents on pos_sales.id=crm_agents.saleid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->fromsoldon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.soldon>='$obj->fromsoldon'";
	$track++;
}

if(!empty($obj->tosoldon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.soldon<='$obj->tosoldon'";
	$track++;
}

if(!empty($obj->fromexpirydate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.expirydate>='$obj->fromexpirydate'";
	$track++;
}

if(!empty($obj->toexpirydate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.expirydate<='$obj->toexpirydate'";
	$track++;
}

if(!empty($obj->memo)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.memo='$obj->memo'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->saleid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_sales.saleid='$obj->saleid'";
		$join=" left join pos_sales on pos_sales.id=pos_sales.saleid ";
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

  $("#agentname").autocomplete({
	source:"../../../modules/server/server/search.php?main=crm&module=agents&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#agentid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_sales";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_sales",
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
<form  action="sales.php" method="post" name="sales" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Item</td>
				<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Customer</td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Agent</td>
				<td><input type='text' size='20' name='agentname' id='agentname' value='<?php echo $obj->agentname; ?>'>
					<input type="hidden" name='agentid' id='agentid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Sold On</td>
				<td><strong>From:</strong><input type='text' id='fromsoldon' size='12' name='fromsoldon' readonly class="date_input" value='<?php echo $obj->fromsoldon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tosoldon' size='12' name='tosoldon' readonly class="date_input" value='<?php echo $obj->tosoldon;?>'/></td>
			</tr>
			<tr>
				<td>Expiry Date</td>
				<td><strong>From:</strong><input type='text' id='fromexpirydate' size='12' name='fromexpirydate' readonly class="date_input" value='<?php echo $obj->fromexpirydate;?>'/>
							<br/><strong>To:</strong><input type='text' id='toexpirydate' size='12' name='toexpirydate' readonly class="date_input" value='<?php echo $obj->toexpirydate;?>'/></td>
			</tr>
			<tr>
				<td>Memo</td>
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
				<td>Sale</td>
				<td>
				<select name='saleid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$sales=new Sales();
				$where="  ";
				$fields="pos_sales.id, pos_sales.documentno, pos_sales.projectid, pos_sales.fleetscheduleid, pos_sales.customerid, pos_sales.customerconsigneeid, pos_sales.agentid, pos_sales.employeeid, pos_sales.remarks, pos_sales.mode, pos_sales.soldon, pos_sales.expirydate, pos_sales.memo, pos_sales.createdby, pos_sales.createdon, pos_sales.lasteditedby, pos_sales.lasteditedon, pos_sales.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$sales->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($sales->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->saleid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='grcustomerid' value='1' <?php if(isset($_POST['grcustomerid']) ){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='gragentid' value='1' <?php if(isset($_POST['gragentid']) ){echo"checked";}?>>&nbsp;Agent</td>
			<tr>
				<td><input type='checkbox' name='grsoldon' value='1' <?php if(isset($_POST['grsoldon']) ){echo"checked";}?>>&nbsp;Sold On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grmode' value='1' <?php if(isset($_POST['grmode']) ){echo"checked";}?>>&nbsp;Mode</td>
			<tr>
				<td><input type='checkbox' name='grsaleid' value='1' <?php if(isset($_POST['grsaleid']) ){echo"checked";}?>>&nbsp;Sale</td>
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
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='shcustomerid' value='1' <?php if(isset($_POST['shcustomerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='shagentid' value='1' <?php if(isset($_POST['shagentid']) ){echo"checked";}?>>&nbsp;Agent</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shcostprice' value='1' <?php if(isset($_POST['shcostprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Cost Price</td>
				<td><input type='checkbox' name='shtradeprice' value='1' <?php if(isset($_POST['shtradeprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Trade Price</td>
			<tr>
				<td><input type='checkbox' name='shretailprice' value='1' <?php if(isset($_POST['shretailprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Retail Price</td>
				<td><input type='checkbox' name='shdiscount' value='1' <?php if(isset($_POST['shdiscount']) ){echo"checked";}?>>&nbsp;Discount</td>
			<tr>
				<td><input type='checkbox' name='shtax' value='1' <?php if(isset($_POST['shtax']) ){echo"checked";}?>>&nbsp;Tax</td>
				<td><input type='checkbox' name='bonus' value='1' <?php if(isset($_POST['bonus']) ){echo"checked";}?>>&nbsp;Bonus</td>
			<tr>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total</td>
				<td><input type='checkbox' name='shmode' value='1' <?php if(isset($_POST['shmode']) ){echo"checked";}?>>&nbsp;Mode</td>
			<tr>
				<td><input type='checkbox' name='shsoldon' value='1' <?php if(isset($_POST['shsoldon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Sold On</td>
				<td><input type='checkbox' name='shexpirydate' value='1' <?php if(isset($_POST['shexpirydate']) ){echo"checked";}?>>&nbsp;Expiry Date</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
				<td><input type='checkbox' name='shsaleid' value='1' <?php if(isset($_POST['shsaleid']) ){echo"checked";}?>>&nbsp;Sale</td>
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
				<th> </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Document No </th>
			<?php } ?>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shagentid==1 ){ ?>
				<th>Agent </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcostprice==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shtradeprice==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shretailprice==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shdiscount==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shtax==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->bonus==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shmode==1 ){ ?>
				<th>Mode </th>
			<?php } ?>
			<?php if($obj->shsoldon==1  or empty($obj->action)){ ?>
				<th>Sold On </th>
			<?php } ?>
			<?php if($obj->shexpirydate==1 ){ ?>
				<th>Expiry Date </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shsaleid==1 ){ ?>
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
