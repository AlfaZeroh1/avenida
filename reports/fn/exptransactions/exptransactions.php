<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/exptransactions/Exptransactions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/fn/expenses/Expenses_class.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/sys/purchasemodes/Purchasemodes_class.php");
require_once("../../../modules/sys/paymentmodes/Paymentmodes_class.php");
require_once("../../../modules/fn/banks/Banks_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Exptransactions";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8756";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromexpensedate=date('Y-m-d');
	$obj->toexpensedate=date('Y-m-d');
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
if(!empty($obj->grexpenseid) or !empty($obj->grprojectid) or !empty($obj->grsupplierid) or !empty($obj->grpurchasemodeid) or !empty($obj->grexpensedate) or !empty($obj->grdocumentno) or !empty($obj->grreceiptno) or !empty($obj->grpaymentmodeid) or !empty($obj->grbankid) or !empty($obj->grchequeno) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shexpenseid='';
	$obj->shprojectid='';
	$obj->shsupplierid='';
	$obj->shpurchasemodeid='';
	$obj->shquantity='';
	$obj->shtax='';
	$obj->shdiscount='';
	$obj->shamount='';
	$obj->shexpensedate='';
	$obj->shpaid='';
	$obj->shremarks='';
	$obj->shmemo='';
	$obj->shdocumentno='';
	$obj->shreceiptno='';
	$obj->shpaymentmodeid='';
	$obj->shbankid='';
	$obj->shchequeno='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
}


	$obj->shamount=1;


if(!empty($obj->grexpenseid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" expenseid ";
	$obj->shexpenseid=1;
	$track++;
}

if(!empty($obj->grprojectid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" projectid ";
	$obj->shprojectid=1;
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
if(!empty($obj->grreceiptno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" receiptno ";
	$obj->shreceiptno=1;
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

//processing columns to show
	if(!empty($obj->shexpenseid)  or empty($obj->action)){
		array_push($sColumns, 'expenseid');
		array_push($aColumns, " CASE WHEN fn_exptransactions.expenseid is not null THEN fn_expenses.name WHEN fn_exptransactions.assetid THEN assets_assets.name WHEN fn_exptransactions.liabilityid THEN fn_liabilitys.name END as expenseid");
		$rptjoin.=" left join fn_expenses on fn_expenses.id=fn_exptransactions.expenseid left join assets_assets on assets_assets.id=fn_exptransactions.assetid left join fn_liabilitys on fn_liabilitys.id=fn_exptransactions.liabilityid ";
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
		if(empty($rptgroup))
		  array_push($aColumns, "fn_exptransactions.amount");
		else
		  array_push($aColumns, "sum(fn_exptransactions.amount) amount");
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
	if(!empty($obj->shreceiptno)  or empty($obj->action)){
		array_push($sColumns, 'receiptno');
		array_push($aColumns, "fn_exptransactions.receiptno");
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
		

	if(!empty($obj->shexchangerate) ){
		array_push($sColumns, 'exchangerate');
		array_push($aColumns, "fn_exptransactions.exchangerate");
		$k++;
		}

	if(!empty($obj->shexchangerate2) ){
		array_push($sColumns, 'exchangerate2');
		array_push($aColumns, "fn_exptransactions.exchangerate2");
		$k++;
		}
		
		
	if(!empty($obj->shtotal) ){
		array_push($sColumns, 'total');
		if(empty($rptgroup))
		  array_push($aColumns, "fn_exptransactions.total");
		else
		  array_push($aColumns, "sum(fn_exptransactions.total) total");
		$k++;
		}


$track=0;

//processing filters
if(!empty($obj->expenseid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.expenseid='$obj->expenseid'";
		$join=" left join fn_expenses on fn_exptransactions.id=fn_expenses.exptransactionid ";
		
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
		$join=" left join sys_purchasemodes on fn_exptransactions.id=sys_purchasemodes.exptransactionid ";
		
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
if(!empty($obj->receiptno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.receiptno='$obj->receiptno'";
	$track++;
}


if(!empty($obj->paymentmodeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.paymentmodeid='$obj->paymentmodeid'";
		$join=" left join sys_paymentmodes on fn_exptransactions.id=sys_paymentmodes.exptransactionid ";
		
	$track++;
}

if(!empty($obj->bankid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_exptransactions.bankid='$obj->bankid'";
		$join=" left join fn_banks on fn_exptransactions.id=fn_banks.exptransactionid ";
		
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

//Processing Joins
;$track=0;
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

  $("#projectname").autocomplete({
	source:"../../../modules/server/server/search.php?main=con&module=projects&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#projectid").val(ui.item.id);
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
			for(var i=1; i<num; i++){
				$('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
 	"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("");
			$('th:eq(1)', nRow).html("TOTAL");
			var total=0;
			for(var i=0; i<aaData.length; i++){
			  for(var j=2; j<aaData[i].length; j++){
				if(j=="<?php echo $mnt;?>"){
				  total+=parseInt(aaData[i][j]);
				  $('th:eq('+j+')', nRow).html(total);
				}
				else{
				  $('th:eq('+j+')', nRow).html("");
				}
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
<form  action="exptransactions.php" method="post" name="exptransactions" >
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
				<td>Receiptno no</td>
				<td><input type='text' id='receiptno' size='20' name='receiptno' value='<?php echo $obj->receiptno;?>'></td>
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
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from fn_exptransactions) ";
				$join=" left join hrm_employees on hrm_employees.id=auth_users.employeeid ";
				$having="";
				$groupby="";
				$orderby=" order by employeename ";
				$users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($rw=mysql_fetch_object($users->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->createdby==$rw->id){echo "selected";}?>><?php echo $rw->employeeid;?></option>
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
				<td><input type='checkbox' name='grreceiptno' value='1' <?php if(isset($_POST['grreceiptno']) ){echo"checked";}?>>&nbsp;Receiptno no</td>
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
				<td><input type='checkbox' name='shsupplierid' value='1' <?php if(isset($_POST['shsupplierid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Supplier</td>
			<tr>	
				<td><input type='checkbox' name='shpurchasemodeid' value='1' <?php if(isset($_POST['shpurchasemodeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Purchase Mode</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>	
				<td><input type='checkbox' name='shtax' value='1' <?php if(isset($_POST['shtax'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Tax</td>
				<td><input type='checkbox' name='shdiscount' value='1' <?php if(isset($_POST['shdiscount']) ){echo"checked";}?>>&nbsp;Discount</td>
			<tr>	
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
				<td><input type='checkbox' name='shexpensedate' value='1' <?php if(isset($_POST['shexpensedate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Expense Date</td>
			<tr>	
				<td><input type='checkbox' name='shpaid' value='1' <?php if(isset($_POST['shpaid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Paid</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>	
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Memo</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document no</td>
			<tr>	
				<td><input type='checkbox' name='shpaymentmodeid' value='1' <?php if(isset($_POST['shpaymentmodeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Payment Mode</td>
				<td><input type='checkbox' name='shbankid' value='1' <?php if(isset($_POST['shbankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank</td>
			<tr>	
				<td><input type='checkbox' name='shchequeno' value='1' <?php if(isset($_POST['shchequeno']) ){echo"checked";}?>>&nbsp;Cheque No</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>	
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;created On</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
			
			<tr>	
				<td><input type='checkbox' name='shexchangerate' value='1' <?php if(isset($_POST['shexchangerate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Exchange Rate</td>
				<td><input type='checkbox' name='shexchangerate2' value='1' <?php if(isset($_POST['shexchangerate2']) ){echo"checked";}?>>&nbsp;Exchange Rate 2</td>
			<tr>	
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total</td>
				<td><input type='checkbox' name='shreceiptno' value='1' <?php if(isset($_POST['shreceiptno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Receiptno</td>
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
			<?php if($obj->shexpenseid==1  or empty($obj->action)){ ?>
				<th>Expense </th>
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
			<?php if($obj->shreceiptno==1  or empty($obj->action)){ ?>
				<th>Reciept No. </th>
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
			<?php if($obj->shexchangerate==1 ){ ?>
				<th>Ksh;</th>
			<?php } ?>
			<?php if($obj->shexchangerate2==1 ){ ?>
				<th>Euro;</th>
			<?php } ?>
			<?php if($obj->shtotal==1 ){ ?>
				<th>Total;</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	<tfoot>
	<tr>
	
	<th>#</th>
			<?php if($obj->shexpenseid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shpurchasemodeid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shtax==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdiscount==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shexpensedate==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shpaid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shmemo==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shreceiptno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shpaymentmodeid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shbankid==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp; </th>
			
			<?php } ?>
			<?php if($obj->shexchangerate==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shexchangerate2==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shtotal==1 ){ ?>
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
