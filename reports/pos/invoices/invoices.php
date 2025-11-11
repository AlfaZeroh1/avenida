<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/invoices/Invoices_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");
require_once("../../../modules/crm/agents/Agents_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Invoices";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8728";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromsoldon=date('Y-m-d');
	$obj->tosoldon=date('Y-m-d');
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
if(!empty($obj->grdocumentno) or !empty($obj->grpackingno) or !empty($obj->grcustomerid) or !empty($obj->gragentid) or !empty($obj->grsoldon) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->gritemid) ){
	$obj->shdocumentno='';
	$obj->shpackingno='';
	$obj->shcustomerid='';
	$obj->shagentid='';
	$obj->shremarks='';
	$obj->shsoldon='';
	$obj->shmemo='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shprice='';
	$obj->shtax='';
	$obj->shbonus='';
	$obj->shprofit='';
	$obj->shtotal='';
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

if(!empty($obj->grpackingno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" packingno ";
	$obj->shpackingno=1;
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

if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "pos_invoices.documentno");
		$k++;
		}

	if(!empty($obj->shpackingno)  or empty($obj->action)){
		array_push($sColumns, 'packingno');
		array_push($aColumns, "pos_invoices.packingno");
		$k++;
		}

	if(!empty($obj->shcustomerid)  or empty($obj->action)){
		array_push($sColumns, 'customerid');
		array_push($aColumns, "crm_customers.name as customerid");
		$rptjoin.=" left join crm_customers on crm_customers.id=pos_invoices.customerid ";
		$k++;
		}

	if(!empty($obj->shagentid)  or empty($obj->action)){
		array_push($sColumns, 'agentid');
		array_push($aColumns, "crm_agents.name as agentid");
		$rptjoin.=" left join crm_agents on crm_agents.id=pos_invoices.agentid ";
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "pos_invoices.remarks");
		$k++;
		}

	if(!empty($obj->shsoldon)  or empty($obj->action)){
		array_push($sColumns, 'soldon');
		array_push($aColumns, "pos_invoices.soldon");
		$k++;
		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "pos_invoices.memo");
		$k++;
		}

	if(!empty($obj->shcreatedby) ){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "pos_invoices.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "pos_invoices.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "pos_invoices.ipaddress");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
 		array_push($aColumns, "pos_invoicedetails.itemid");
		$k++;
		
		$mnt = ($k+1);
		
		$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
 		
 		
		}

// 	if(!empty($obj->shquantity)  or empty($obj->action)){
// 		array_push($sColumns, 'quantity');
// 		array_push($aColumns, "pos_invoicedetails.quantity");
// 		$k++;
// 		$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
// 		
// 		}

	if(!empty($obj->shprice) ){
		array_push($sColumns, 'price');
		array_push($aColumns, "pos_invoicedetails.price");
		$k++;
		$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
		
		
		}

	if(!empty($obj->shtax) ){
		array_push($sColumns, 'tax');
		array_push($aColumns, "pos_invoicedetails.tax");
		$k++;
		$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
		
		
		}

	if(!empty($obj->shbonus) ){
		array_push($sColumns, 'bonus');
		array_push($aColumns, "pos_invoicedetails.bonus");
		$k++;
		$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_invoicedetails.bonus ";
		
		}

	if(!empty($obj->shprofit) ){
		array_push($sColumns, 'profit');
		array_push($aColumns, "pos_invoicedetails.profit");
		$k++;
		$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_invoicedetails.profit ";
		
		}

	if(!empty($obj->shtotal)  or empty($obj->action)){
		array_push($sColumns, 'total');
		array_push($aColumns, "pos_invoicedetails.total");
		$k++;
		
		
		
		$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
		
		//$join=" left join  pos_invoicedetails on pos_invoices.id=pos_invoicedetails.total ";
		
		
		}



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->packingno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.packingno='$obj->packingno'";
	$track++;
}

if(!empty($obj->customerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.customerid='$obj->customerid'";
		$join=" left join crm_customers on pos_invoices.id=crm_customers.invoiceid ";
		
	$track++;
}

if(!empty($obj->agentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.agentid='$obj->agentid'";
		$join=" left join crm_agents on pos_invoices.id=crm_agents.invoiceid ";
		
	$track++;
}

if(!empty($obj->fromsoldon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.soldon>='$obj->fromsoldon'";
	$track++;
}

if(!empty($obj->tosoldon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.soldon<='$obj->tosoldon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_invoices.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" pos_items.id='$obj->itemid' ";
	$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join pos_items on pos_items.id=pos_invoicedetails.itemid ";
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
    $cols=" sum(case when pos_invoicedetails.sizeid=$rw->id then pos_invoicedetails.quantity end) '$rw->name'";
    array_push($aColumns, $cols);
    array_push($sColumns, $rw->name);
    
    $k++;
  }
$join=" left join pos_invoicedetails on pos_invoices.id=pos_invoicedetails.invoiceid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
if(!empty($obj->shquantity)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(pos_invoicedetails.quantity) quantity");
		}else{
		array_push($aColumns, "pos_invoicedetails.quantity");
		}

		$k++;
		
		}
?>

 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_invoices";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_invoices",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			$('th:eq(1)', nRow).html("TOTAL");
			var total=[];
			//var k=0;
			for(var i=0; i<aaData.length; i++){
			  //var k = aaData[i].length;
			  
			  for(var j=<?php echo $mnt; ?>; j<aaData[i].length; j++){
			    if(aaData[i][j]=='')
			      aaData[i][j]=0;			      
			      
			      if(i==0)
				total[j]=0;
				
				total[j] = parseFloat(total[j])+parseFloat(aaData[i][j]);	//alert(parseFloat(aaData[i][j]));	
			  }
			  
			}
			
			for(var i=<?php echo $mnt; ?>; i<total.length;i++){
			  $('th:eq('+i+')', nRow).html(total[i]);
			}
		}
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
<form  action="invoices.php" method="post" name="invoices" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Packing No</td>
				<td><input type='text' id='packingno' size='20' name='packingno' value='<?php echo $obj->packingno;?>'></td>
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
				<td>Product</td>
				<td>
				<select name='itemid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$items=new Items();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($items->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->itemid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='grpackingno' value='1' <?php if(isset($_POST['grpackingno']) ){echo"checked";}?>>&nbsp;Packing No</td>
			<tr>
				<td><input type='checkbox' name='grcustomerid' value='1' <?php if(isset($_POST['grcustomerid']) ){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='gragentid' value='1' <?php if(isset($_POST['gragentid']) ){echo"checked";}?>>&nbsp;Agent</td>
			<tr>
				<td><input type='checkbox' name='grsoldon' value='1' <?php if(isset($_POST['grsoldon']) ){echo"checked";}?>>&nbsp;Sold On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Product</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='shpackingno' value='1' <?php if(isset($_POST['shpackingno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Packing No</td>
			<tr>
				<td><input type='checkbox' name='shcustomerid' value='1' <?php if(isset($_POST['shcustomerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='shagentid' value='1' <?php if(isset($_POST['shagentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Agent</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shsoldon' value='1' <?php if(isset($_POST['shsoldon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Sold On</td>
			<tr>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
			<tr>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Product</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shprice' value='1' <?php if(isset($_POST['shprice']) ){echo"checked";}?>>&nbsp;Price</td>
				<td><input type='checkbox' name='shtax' value='1' <?php if(isset($_POST['shtax']) ){echo"checked";}?>>&nbsp;Tax</td>
			<tr>
				<td><input type='checkbox' name='shbonus' value='1' <?php if(isset($_POST['shbonus']) ){echo"checked";}?>>&nbsp;Tax</td>
				<td><input type='checkbox' name='shprofit' value='1' <?php if(isset($_POST['shprofit']) ){echo"checked";}?>>&nbsp;Profit</td>
			<tr>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total</td>
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
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Document No </th>
			<?php } ?>
			<?php if($obj->shpackingno==1  or empty($obj->action)){ ?>
				<th>Packing No </th>
			<?php } ?>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>Customer </th>
			<?php } ?>
			<?php if($obj->shagentid==1  or empty($obj->action)){ ?>
				<th>Agent </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shsoldon==1  or empty($obj->action)){ ?>
				<th>Sold On </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>ipaddress </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Items </th>
			<?php } ?>
			
			<?php if($obj->shprice==1 ){ ?>
				<th>Price </th>
			<?php } ?>
			<?php if($obj->shtax==1 ){ ?>
				<th>Tax </th>
			<?php } ?>
			<?php if($obj->shbonus==1 ){ ?>
				<th>Bonus </th>
			<?php } ?>
			<?php if($obj->shprofit==1 ){ ?>
				<th>Profit </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>Total </th>
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
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	<tfoot>
	<tr>
	<th>#</th>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shpackingno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shagentid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shsoldon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			
			<?php if($obj->shprice==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtax==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shbonus==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shprofit==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
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
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
	</tr>
	</tfoot>
	</tbody>
</div>
</div>
</div>
</div>
</div>
