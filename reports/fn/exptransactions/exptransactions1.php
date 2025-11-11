<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/exptransactions/Exptransactions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/expenses/Expenses_class.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/sys/purchasemodes/Purchasemodes_class.php");
require_once("../../../modules/sys/paymentmodes/Paymentmodes_class.php");
require_once("../../../modules/fn/banks/Banks_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Exptransactions";
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

	if(!empty($obj->shvoucherno)  or empty($obj->action)){
		array_push($sColumns, 'voucherno');
		array_push($aColumns, "fn_exptransactions.voucherno");
		$k++;
	}
	if(!empty($obj->shexpenseid)  or empty($obj->action)){
		array_push($sColumns, 'expenseid');
		array_push($aColumns, "fn_expenses.name as expenseid");
		$rptjoin.=" left join fn_expenses on fn_expenses.id=fn_exptransactions.expenseid ";
		
		$k++;
	}

	if(!empty($obj->shplotid)  or empty($obj->action)){
		array_push($sColumns, 'plotid');
		array_push($aColumns, "concat(em_plots.code,' ',em_plots.name) as plotid");
		$rptjoin.=" left join em_plots on em_plots.id=fn_exptransactions.plotid ";
		$k++;
	}

	if(!empty($obj->shsupplierid)  or empty($obj->action)){
		array_push($sColumns, 'supplierid');
		array_push($aColumns, "proc_suppliers.name as supplierid");
		$rptjoin.=" left join proc_suppliers on proc_suppliers.id=fn_exptransactions.supplierid ";
		$k++;
	}

	if(!empty($obj->shpurchasemodeid)  or empty($obj->action)){
		array_push($sColumns, 'purchasemodeid');
		array_push($aColumns, "sys_purchasemodes.name as purchasemodeid");
		$rptjoin.=" left join sys_purchasemodes on sys_purchasemodes.id=fn_exptransactions.purchasemodeid ";
		$k++;
	}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "fn_exptransactions.quantity");
		$k++;
	}

	if(!empty($obj->shtax)  or empty($obj->action)){
		array_push($sColumns, 'tax');
		array_push($aColumns, "fn_exptransactions.tax");
		$k++;
	}

	if(!empty($obj->shdiscount) ){
		array_push($sColumns, 'discount');
		array_push($aColumns, "fn_exptransactions.discount");
		$k++;
	}

	if(!empty($obj->shamount)  or empty($obj->action)){
		array_push($sColumns, 'amount');
		array_push($aColumns, "fn_exptransactions.amount");
		$k++;
		
		array_push($sColumns, 'total');
		array_push($aColumns, "fn_exptransactions.total");
		$k++;
		
		$mnt=$k;
	}

	if(!empty($obj->shexpensedate)  or empty($obj->action)){
		array_push($sColumns, 'expensedate');
		array_push($aColumns, "fn_exptransactions.expensedate");
		$k++;
	}

	if(!empty($obj->shpaid)  or empty($obj->action)){
		array_push($sColumns, 'paid');
		array_push($aColumns, "fn_exptransactions.paid");
		$k++;
	}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "fn_exptransactions.remarks");
		$k++;
	}

	if(!empty($obj->shmemo)  or empty($obj->action)){
		array_push($sColumns, 'memo');
		array_push($aColumns, "fn_exptransactions.memo");
		$k++;
	}

	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "fn_exptransactions.documentno");
		$k++;
	}
	

	if(!empty($obj->shpaymentmodeid)  or empty($obj->action)){
		array_push($sColumns, 'paymentmodeid');
		array_push($aColumns, "sys_paymentmodes.name as paymentmodeid");
		$rptjoin.=" left join sys_paymentmodes on sys_paymentmodes.id=fn_exptransactions.paymentmodeid ";
		$k++;
	}

	if(!empty($obj->shbankid)  or empty($obj->action)){
		array_push($sColumns, 'bankid');
		array_push($aColumns, "fn_banks.name as bankid");
		$rptjoin.=" left join fn_banks on fn_banks.id=fn_exptransactions.bankid ";
		$k++;
	}

	if(!empty($obj->shchequeno) ){
		array_push($sColumns, 'chequeno');
		array_push($aColumns, "fn_exptransactions.chequeno");
		$k++;
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=fn_exptransactions.createdby ";
		$k++;
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "fn_exptransactions.createdon");
		$k++;
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "fn_exptransactions.ipaddress");
		$k++;
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->expenseid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.expenseid='$obj->expenseid'";
	$track++;
}

if(!empty($obj->plotid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.plotid='$obj->plotid'";
	$track++;
}

if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.supplierid='$obj->supplierid'";
	$track++;
}

if(!empty($obj->purchasemodeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.purchasemodeid='$obj->purchasemodeid'";
	$track++;
}

if(!empty($obj->fromquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.quantity>='$obj->fromquantity'";
	$track++;
}

if(!empty($obj->toquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.quantity<='$obj->toquantity'";
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.quantity='$obj->quantity'";
	$track++;
}

if(!empty($obj->fromshtotal)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.shtotal>='$obj->fromshtotal'";
	$track++;
}

if(!empty($obj->toshtotal)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.shtotal<='$obj->toshtotal'";
	$track++;
}

if(!empty($obj->shtotal)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.shtotal='$obj->shtotal'";
	$track++;
}

if(!empty($obj->fromexpensedate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.expensedate>='$obj->fromexpensedate'";
	$track++;
}

if(!empty($obj->toexpensedate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.expensedate<='$obj->toexpensedate'";
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->voucherno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.voucherno='$obj->voucherno'";
	$track++;
}

if(!empty($obj->paymentmodeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.paymentmodeid='$obj->paymentmodeid'";
	$track++;
}

if(!empty($obj->bankid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.bankid='$obj->bankid'";
	$track++;
}

if(!empty($obj->chequeno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.chequeno='$obj->chequeno'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grexpenseid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" expenseid ";
	$obj->shexpenseid=1;
	$track++;
}

if(!empty($obj->grplotid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" plotid ";
	$obj->shplotid=1;
	$track++;
}

if(!empty($obj->grsupplierid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" supplierid ";
	$obj->shsupplierid=1;
	$track++;
}

if(!empty($obj->grpurchasemodeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" purchasemodeid ";
	$obj->shpurchasemodeid=1;
	$track++;
}

if(!empty($obj->grexpensedate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" expensedate ";
	$obj->shexpensedate=1;
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

if(!empty($obj->grpaymentmodeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" paymentmodeid ";
	$obj->shpaymentmodeid=1;
	$track++;
}

if(!empty($obj->grbankid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" bankid ";
	$obj->shbankid=1;
	$track++;
}

if(!empty($obj->grchequeno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" chequeno ";
	$obj->shchequeno=1;
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

//Processing Joins
;$rptgroup='';
$track=0;
}
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#expensename").autocomplete({
	source:"../../../modules/server/server/search.php?main=fn&module=expenses&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#expenseid").val(ui.item.id);
	}
  });

  $("#plotname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=plots&field=concat(code,' ',name)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#plotid").val(ui.item.id);
	}
  });

  $("#suppliername").autocomplete({
	source:"../../../modules/server/server/search.php?main=proc&module=suppliers&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#supplierid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="fn_exptransactions";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
 var total=0;
 var j=0;
	
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_exptransactions",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			j=num;
			for(var i=1; i<num; i++){
				if(i=="<?php echo $mnt;?>"){
				  total+=(aaData[i]*1);
				  $('td:eq('+i+')', nRow).html(aaData[i]).formatCurrency().attr('align','right');;
				}
				else if(i=="<?php echo ($mnt-1);?>"){
				  $('td:eq('+i+')', nRow).html(aaData[i]).formatCurrency().attr('align','right');;
				}
				else{
				  $('td:eq('+i+')', nRow).html(aaData[i]);
				}
			}
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			for(var i=1; i<j; i++){
				if(i=="<?php echo $mnt;?>"){
				  $('th:eq('+i+')', nRow).html(total).formatCurrency().attr('align','right');;
				}
				else{
				  $('th:eq('+i+')', nRow).html("");
				}
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
<form  action="exptransactions.php" method="post" name="exptransactions" class=''>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Expense</td>
				<td><input type='text' size='20' name='expensename' id='expensename' value='<?php echo $obj->expensename; ?>'>
					<input type="hidden" name='expenseid' id='expenseid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Property</td>
				<td><input type='text' size='20' name='plotname' id='plotname' value='<?php echo $obj->plotname; ?>'>
					<input type="hidden" name='plotid' id='plotid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Supplier</td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Purchase Mode</td>
				<td>
				<select name='purchasemodeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$purchasemodes=new Purchasemodes();
				$where="  ";
				$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($purchasemodes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->purchasemodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><strong>From:</strong><input type='text' id='fromquantity' size='from20' name='fromquantity' value='<?php echo $obj->fromquantity;?>'/>
								<br/><strong>To:</strong><input type='text' id='toquantity' size='to20' name='toquantity' value='<?php echo $obj->toquantity;?>'></td>
			</tr>
			<tr>
				<td>Total</td>
			</tr>
			<tr>
				<td>Expense Date</td>
				<td><strong>From:</strong><input type='text' id='fromexpensedate' size='12' name='fromexpensedate' readonly class="date_input" value='<?php echo $obj->fromexpensedate;?>'/>
							<br/><strong>To:</strong><input type='text' id='toexpensedate' size='12' name='toexpensedate' readonly class="date_input" value='<?php echo $obj->toexpensedate;?>'/></td>
			</tr>
			<tr>
				<td>Document no</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Voucher no</td>
				<td><input type='text' id='voucherno' size='20' name='voucherno' value='<?php echo $obj->voucherno;?>'></td>
			</tr>
			<tr>
				<td>Payment Mode</td>
				<td>
				<select name='paymentmodeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$paymentmodes=new Paymentmodes();
				$where="  ";
				$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.remarks";
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
			<tr>
				<td>Bank</td>
				<td>
				<select name='bankid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$banks=new Banks();
				$where="  ";
				$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon, fn_banks.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($banks->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->bankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Cheque No</td>
				<td><input type='text' id='chequeno' size='20' name='chequeno' value='<?php echo $obj->chequeno;?>'></td>
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
				<td>created On</td>
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
				<td><input type='checkbox' name='grexpenseid' value='1' <?php if(isset($_POST['grexpenseid']) ){echo"checked";}?>>&nbsp;Expense</td>
				<td><input type='checkbox' name='grplotid' value='1' <?php if(isset($_POST['grplotid']) ){echo"checked";}?>>&nbsp;Project</td>
			<tr>
				<td><input type='checkbox' name='grsupplierid' value='1' <?php if(isset($_POST['grsupplierid']) ){echo"checked";}?>>&nbsp;Supplier</td>
				<td><input type='checkbox' name='grpurchasemodeid' value='1' <?php if(isset($_POST['grpurchasemodeid']) ){echo"checked";}?>>&nbsp;Purchase Mode</td>
			<tr>
				<td><input type='checkbox' name='grexpensedate' value='1' <?php if(isset($_POST['grexpensedate']) ){echo"checked";}?>>&nbsp;Expense Date</td>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document no</td>
			<tr>
				<td><input type='checkbox' name='grpaymentmodeid' value='1' <?php if(isset($_POST['grpaymentmodeid']) ){echo"checked";}?>>&nbsp;Payment Mode</td>
				<td><input type='checkbox' name='grbankid' value='1' <?php if(isset($_POST['grbankid']) ){echo"checked";}?>>&nbsp;Bank</td>
			<tr>
				<td><input type='checkbox' name='grchequeno' value='1' <?php if(isset($_POST['grchequeno']) ){echo"checked";}?>>&nbsp;Cheque No</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;created On</td>
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
				<td><input type='checkbox' name='shexpenseid' value='1' <?php if(isset($_POST['shexpenseid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Expense</td>
				<td><input type='checkbox' name='shplotid' value='1' <?php if(isset($_POST['shplotid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Project</td>
			<tr>
				<td><input type='checkbox' name='shsupplierid' value='1' <?php if(isset($_POST['shsupplierid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Supplier</td>
				<td><input type='checkbox' name='shpurchasemodeid' value='1' <?php if(isset($_POST['shpurchasemodeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Purchase Mode</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shtax' value='1' <?php if(isset($_POST['shtax'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Tax</td>
			<tr>
				<td><input type='checkbox' name='shdiscount' value='1' <?php if(isset($_POST['shdiscount']) ){echo"checked";}?>>&nbsp;Discount</td>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shexpensedate' value='1' <?php if(isset($_POST['shexpensedate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Expense Date</td>
				<td><input type='checkbox' name='shpaid' value='1' <?php if(isset($_POST['shpaid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Paid</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document no</td>
				<td><input type='checkbox' name='shpaymentmodeid' value='1' <?php if(isset($_POST['shpaymentmodeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Payment Mode</td>
			<tr>
				<td><input type='checkbox' name='shbankid' value='1' <?php if(isset($_POST['shbankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank</td>
				<td><input type='checkbox' name='shchequeno' value='1' <?php if(isset($_POST['shchequeno']) ){echo"checked";}?>>&nbsp;Cheque No</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
				<td><input type='checkbox' name='shvoucherno' value='1' <?php if(isset($_POST['shvoucherno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Voucher no</td>
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
			<?php if($obj->shvoucherno==1  or empty($obj->action)){ ?>
				<th>Voucher No. </th>
			<?php } ?>
			<?php if($obj->shexpenseid==1  or empty($obj->action)){ ?>
				<th>Expense </th>
			<?php } ?>
			<?php if($obj->shplotid==1  or empty($obj->action)){ ?>
				<th>Project </th>
			<?php } ?>
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>Supplier </th>
			<?php } ?>
			<?php if($obj->shpurchasemodeid==1  or empty($obj->action)){ ?>
				<th>Purchase Mode </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shtax==1  or empty($obj->action)){ ?>
				<th>Tax </th>
			<?php } ?>
			<?php if($obj->shdiscount==1 ){ ?>
				<th>Discount </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount </th>
				<th>Total </th>
			<?php } ?>
			<?php if($obj->shexpensedate==1  or empty($obj->action)){ ?>
				<th>Expense Date </th>
			<?php } ?>
			<?php if($obj->shpaid==1  or empty($obj->action)){ ?>
				<th>Paid </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shmemo==1  or empty($obj->action)){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Document No. </th>
			<?php } ?>
			<?php if($obj->shpaymentmodeid==1  or empty($obj->action)){ ?>
				<th>Payment Mode </th>
			<?php } ?>
			<?php if($obj->shbankid==1  or empty($obj->action)){ ?>
				<th>Bank </th>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<th>Cheque No </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>CreatedBy </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>CreatedOn </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
	<tr>
			<th>&nbsp;</th>
			<?php if($obj->shvoucherno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shexpenseid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shplotid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shpurchasemodeid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtax==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdiscount==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shexpensedate==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shpaid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shmemo==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shpaymentmodeid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shbankid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
		</tr>
	</tfoot>
</div>
</div>
</div>
</div>
</div>
