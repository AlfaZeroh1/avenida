<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/inctransactions/Inctransactions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/fn/incomes/Incomes_class.php");
//require_once("../../../modules/em/plots/Plots_class.php");
//require_once("../../../modules/em/paymentterms/Paymentterms_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");
require_once("../../../modules/sys/paymentmodes/Paymentmodes_class.php");
require_once("../../../modules/fn/banks/Banks_class.php");
require_once("../../../modules/fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Inctransactions";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8760";//Report View
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
if(!empty($obj->grincomeid) or !empty($obj->grplotid) or !empty($obj->grpaymenttermid) or !empty($obj->grcustomerid) or !empty($obj->grincomedate) or !empty($obj->grdocumentno) or !empty($obj->grpaymentmodeid) or !empty($obj->grbankid) or !empty($obj->grimprestaccountid) or !empty($obj->grchequeno) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shincomeid='';
	$obj->shplotid='';
	$obj->shpaymenttermid='';
	$obj->shcustomerid='';
	$obj->shquantity='';
	$obj->shtax='';
	$obj->shdiscount='';
	$obj->shamount='';
	$obj->shtotal='';
	$obj->shincomedate='';
	$obj->shmonth='';
	$obj->shyear='';
	$obj->shpaid='';
	$obj->shremarks='';
	$obj->shmemo='';
	$obj->shdocumentno='';
	$obj->shpaymentmodeid='';
	$obj->shbankid='';
	$obj->shimprestaccountid='';
	$obj->shchequeno='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
}


	$obj->shquantity=1;


if(!empty($obj->grincomeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" incomeid ";
	$obj->shincomeid=1;
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

if(!empty($obj->grpaymenttermid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" paymenttermid ";
	$obj->shpaymenttermid=1;
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

if(!empty($obj->grincomedate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" incomedate ";
	$obj->shincomedate=1;
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

if(!empty($obj->grimprestaccountid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" imprestaccountid ";
	$obj->shimprestaccountid=1;
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
	if(!empty($obj->shincomeid)  or empty($obj->action)){
		array_push($sColumns, 'incomeid');
		array_push($aColumns, "fn_incomes.name as incomeid");
		$rptjoin.=" left join fn_incomes on fn_incomes.id=fn_inctransactions.incomeid ";
		$k++;
		}


		

	if(!empty($obj->shtax) ){
		array_push($sColumns, 'tax');
		array_push($aColumns, "fn_inctransactions.tax");
		$k++;
		}

	if(!empty($obj->shdiscount) ){
		array_push($sColumns, 'discount');
		array_push($aColumns, "fn_inctransactions.discount");
		$k++;
		}

	if(!empty($obj->shamount)  or empty($obj->action)){
		array_push($sColumns, 'amount');
		array_push($aColumns, "fn_inctransactions.amount");
		$k++;
		}


	if(!empty($obj->shincomedate)  or empty($obj->action)){
		array_push($sColumns, 'incomedate');
		array_push($aColumns, "fn_inctransactions.incomedate");
		$k++;
		}

	if(!empty($obj->shpaid) ){
		array_push($sColumns, 'paid');
		array_push($aColumns, "fn_inctransactions.paid");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "fn_inctransactions.remarks");
		$k++;
		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "fn_inctransactions.memo");
		$k++;
		}

	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "fn_inctransactions.documentno");
		$k++;
		}

	if(!empty($obj->shpaymentmodeid)  or empty($obj->action)){
		array_push($sColumns, 'paymentmodeid');
		array_push($aColumns, "sys_paymentmodes.name as paymentmodeid");
		$rptjoin.=" left join sys_paymentmodes on sys_paymentmodes.id=fn_inctransactions.paymentmodeid ";
		$k++;
		}

	if(!empty($obj->shimprestaccountid) ){
		array_push($sColumns, 'imprestaccountid');
		array_push($aColumns, "fn_imprestaccounts.name as imprestaccountid");
		$rptjoin.=" left join fn_imprestaccounts on fn_imprestaccounts.id=fn_inctransactions.imprestaccountid ";
		$k++;
		}

	if(!empty($obj->shchequeno) ){
		array_push($sColumns, 'chequeno');
		array_push($aColumns, "fn_inctransactions.chequeno");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "fn_inctransactions.createdby");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "fn_inctransactions.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "fn_inctransactions.ipaddress");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->incomeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_inctransactions.incomeid='$obj->incomeid'";
		$join=" left join fn_incomes on fn_inctransactions.id=fn_incomes.inctransactionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->fromincomedate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_inctransactions.incomedate>='$obj->fromincomedate'";
	$track++;
}

if(!empty($obj->toincomedate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_inctransactions.incomedate<='$obj->toincomedate'";
	$track++;
}



if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_inctransactions.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->paymentmodeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_inctransactions.paymentmodeid='$obj->paymentmodeid'";
		$join=" left join sys_paymentmodes on fn_inctransactions.id=sys_paymentmodes.inctransactionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->imprestaccountid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_inctransactions.imprestaccountid='$obj->imprestaccountid'";
		$join=" left join fn_imprestaccounts on fn_inctransactions.id=fn_imprestaccounts.inctransactionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->chequeno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_inctransactions.chequeno='$obj->chequeno'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_inctransactions.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_inctransactions.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_inctransactions.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#plotname").autocomplete({
	source:"../../../modules/server/server/search.php?main=em&module=plots&field=name",
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
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="fn_inctransactions";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_inctransactions",
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
<form  action="inctransactions.php" method="post" name="inctransactions" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Income</td>
				<td>
				<select name='incomeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$incomes=new Incomes();
				$where="  ";
				$fields="fn_incomes.id, fn_incomes.name, fn_incomes.code, fn_incomes.remarks, fn_incomes.ipaddress, fn_incomes.createdby, fn_incomes.createdon, fn_incomes.lasteditedby, fn_incomes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$incomes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($incomes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->incomeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Property</td>
				<td><input type='text' size='20' name='plotname' id='plotname' value='<?php echo $obj->plotname; ?>'>
					<input type="hidden" name='plotid' id='plotid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Payment term</td>
				<td>
				<select name='paymenttermid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$paymentterms=new Paymentterms();
				$where="  ";
				$fields="em_paymentterms.id, em_paymentterms.name, em_paymentterms.type, em_paymentterms.payabletolandlord, em_paymentterms.generaljournalaccountid, em_paymentterms.chargemgtfee, em_paymentterms.remarks, em_paymentterms.ipaddress, em_paymentterms.createdby, em_paymentterms.createdon, em_paymentterms.lasteditedby, em_paymentterms.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$paymentterms->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentterms->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->paymenttermid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Customer</td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Income Date</td>
				<td><strong>From:</strong><input type='text' id='fromincomedate' size='12' name='fromincomedate' readonly class="date_input" value='<?php echo $obj->fromincomedate;?>'/>
							<br/><strong>To:</strong><input type='text' id='toincomedate' size='12' name='toincomedate' readonly class="date_input" value='<?php echo $obj->toincomedate;?>'/></td>
			</tr>
			<tr>
				<td>Month</td>
				<td><input type='text' id='month' size='20' name='month' value='<?php echo $obj->month;?>'></td>
			</tr>
			<tr>
				<td>Year</td>
				<td><input type='text' id='year' size='20' name='year' value='<?php echo $obj->year;?>'></td>
			</tr>
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Payment mode</td>
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
				<td>Imprest Account</td>
				<td>
				<select name='imprestaccountid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$imprestaccounts=new Imprestaccounts();
				$where="  ";
				$fields="fn_imprestaccounts.id, fn_imprestaccounts.name, fn_imprestaccounts.employeeid, fn_imprestaccounts.remarks, fn_imprestaccounts.ipaddress, fn_imprestaccounts.createdby, fn_imprestaccounts.createdon, fn_imprestaccounts.lasteditedby, fn_imprestaccounts.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($imprestaccounts->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->imprestaccountid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Cheque no</td>
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
				<td><input type='checkbox' name='grincomeid' value='1' <?php if(isset($_POST['grincomeid']) ){echo"checked";}?>>&nbsp;Income</td>
				<td><input type='checkbox' name='grplotid' value='1' <?php if(isset($_POST['grplotid']) ){echo"checked";}?>>&nbsp;Property</td>
			<tr>
				<td><input type='checkbox' name='grpaymenttermid' value='1' <?php if(isset($_POST['grpaymenttermid']) ){echo"checked";}?>>&nbsp;Payment term</td>
				<td><input type='checkbox' name='grcustomerid' value='1' <?php if(isset($_POST['grcustomerid']) ){echo"checked";}?>>&nbsp;Customer</td>
			<tr>
				<td><input type='checkbox' name='grincomedate' value='1' <?php if(isset($_POST['grincomedate']) ){echo"checked";}?>>&nbsp;Income Date</td>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='grpaymentmodeid' value='1' <?php if(isset($_POST['grpaymentmodeid']) ){echo"checked";}?>>&nbsp;Payment mode</td>
				<td><input type='checkbox' name='grbankid' value='1' <?php if(isset($_POST['grbankid']) ){echo"checked";}?>>&nbsp;Bank</td>
			<tr>
				<td><input type='checkbox' name='grimprestaccountid' value='1' <?php if(isset($_POST['grimprestaccountid']) ){echo"checked";}?>>&nbsp;Imprest Account</td>
				<td><input type='checkbox' name='grchequeno' value='1' <?php if(isset($_POST['grchequeno']) ){echo"checked";}?>>&nbsp;Cheque no</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
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
				<td><input type='checkbox' name='shincomeid' value='1' <?php if(isset($_POST['shincomeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Income</td>
				<td><input type='checkbox' name='shplotid' value='1' <?php if(isset($_POST['shplotid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Property</td>
			<tr>
				<td><input type='checkbox' name='shpaymenttermid' value='1' <?php if(isset($_POST['shpaymenttermid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Payment term</td>
				<td><input type='checkbox' name='shcustomerid' value='1' <?php if(isset($_POST['shcustomerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Customer</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shtax' value='1' <?php if(isset($_POST['shtax']) ){echo"checked";}?>>&nbsp;Tax</td>
			<tr>
				<td><input type='checkbox' name='shdiscount' value='1' <?php if(isset($_POST['shdiscount']) ){echo"checked";}?>>&nbsp;Discount</td>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total</td>
				<td><input type='checkbox' name='shincomedate' value='1' <?php if(isset($_POST['shincomedate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Income Date</td>
			<tr>
				<td><input type='checkbox' name='shmonth' value='1' <?php if(isset($_POST['shmonth'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Month</td>
				<td><input type='checkbox' name='shyear' value='1' <?php if(isset($_POST['shyear'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Year</td>
			<tr>
				<td><input type='checkbox' name='shpaid' value='1' <?php if(isset($_POST['shpaid']) ){echo"checked";}?>>&nbsp;Paid</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='shpaymentmodeid' value='1' <?php if(isset($_POST['shpaymentmodeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Payment mode</td>
				<td><input type='checkbox' name='shbankid' value='1' <?php if(isset($_POST['shbankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank</td>
			<tr>
				<td><input type='checkbox' name='shimprestaccountid' value='1' <?php if(isset($_POST['shimprestaccountid']) ){echo"checked";}?>>&nbsp;Imprest Account</td>
				<td><input type='checkbox' name='shchequeno' value='1' <?php if(isset($_POST['shchequeno']) ){echo"checked";}?>>&nbsp;Cheque no</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created on</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
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
			<?php if($obj->shincomeid==1  or empty($obj->action)){ ?>
				<th>Income </th>
			<?php } ?>
			<?php if($obj->shplotid==1  or empty($obj->action)){ ?>
				<th>Property </th>
			<?php } ?>
			<?php if($obj->shpaymenttermid==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>Customer </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shtax==1 ){ ?>
				<th>Tax </th>
			<?php } ?>
			<?php if($obj->shdiscount==1 ){ ?>
				<th>Discount </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>Total </th>
			<?php } ?>
			<?php if($obj->shincomedate==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shmonth==1  or empty($obj->action)){ ?>
				<th>Month </th>
			<?php } ?>
			<?php if($obj->shyear==1  or empty($obj->action)){ ?>
				<th>Year </th>
			<?php } ?>
			<?php if($obj->shpaid==1 ){ ?>
				<th>Paid </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
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
			<?php if($obj->shimprestaccountid==1 ){ ?>
				<th> </th>
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
</div>
</div>
</div>
</div>
</div>
