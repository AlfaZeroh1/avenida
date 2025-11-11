<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/hos/payables/Payables_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hos/patients/Patients_class.php");
require_once("../../../modules/sys/transactions/Transactions_class.php");
require_once("../../../modules/hos/departments/Departments_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Payables";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8732";//Report View
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
//processing columns to show
	if(!empty($obj->shdocumentno) ){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "hos_payables.documentno");
		$k++;
	}

	if(!empty($obj->shpatientid)  or empty($obj->action)){
		array_push($sColumns, 'patientid');
		array_push($aColumns, "concat(hos_patients.surname,' ',hos_patients.othernames) as patientid");
		$rptjoin.=" left join hos_patients on hos_patients.id=hos_payables.patientid ";
		$k++;
	}

	if(!empty($obj->shtransactionid)  or empty($obj->action)){
		array_push($sColumns, 'transactionid');
		array_push($aColumns, "sys_transactions.name as transactionid");
		$rptjoin.=" left join sys_transactions on sys_transactions.id=hos_payables.transactionid ";
		$k++;
	}

	if(!empty($obj->shtreatmentno) ){
		array_push($sColumns, 'treatmentno');
		array_push($aColumns, "hos_payables.treatmentno");
		$k++;
	}

	if(!empty($obj->shamount)  or empty($obj->action)){
		array_push($sColumns, 'amount');
		array_push($aColumns, "hos_payables.amount");
		$k++;
	}

	if(!empty($obj->shremarks)  or empty($obj->action)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "hos_payables.remarks");
		$k++;
	}

	if(!empty($obj->shinvoicedon)  or empty($obj->action)){
		array_push($sColumns, 'invoicedon');
		array_push($aColumns, "hos_payables.invoicedon");
		$k++;
	}

	if(!empty($obj->shpaid)  or empty($obj->action)){
		array_push($sColumns, 'paid');
		array_push($aColumns, "hos_payables.paid");
		$k++;
	}

	if(!empty($obj->shdepartmentid)  or empty($obj->action)){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "hos_departments.name as departmentid");
		$rptjoin.=" left join hos_departments on hos_departments.id=hos_payables.departmentid ";
		$k++;
	}



//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_payables.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->patientid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_payables.patientid='$obj->patientid'";
	$track++;
}

if(!empty($obj->transactionid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_payables.transactionid='$obj->transactionid'";
	$track++;
}

if(!empty($obj->treatmentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_payables.treatmentno='$obj->treatmentno'";
	$track++;
}

if(!empty($obj->frominvoicedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_payables.invoicedon>='$obj->frominvoicedon'";
	$track++;
}

if(!empty($obj->toinvoicedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_payables.invoicedon<='$obj->toinvoicedon'";
	$track++;
}

if(!empty($obj->paid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_payables.paid='$obj->paid'";
	$track++;
}

if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" hos_payables.departmentid='$obj->departmentid'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grdepartmentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" departmentid ";
	$obj->shdepartmentid=1;
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
if(!empty($obj->shpatientid)){
	$fd.=" ,concat(hos_patients.surname,' ',hos_patients.othernames) ";
}
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#patientname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hos&module=patients&field=concat(hos_patients.surname,' ',hos_patients.othernames)",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#patientid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="hos_payables";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=hos_payables",
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
<form  action="payables.php" method="post" name="payables" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Patient</td>
				<td><input type='text' size='20' name='patientname' id='patientname' value='<?php echo $obj->patientname; ?>'>
					<input type="hidden" name='patientid' id='patientid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Transaction</td>
				<td>
				<select name='transactionid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$transactions=new Transactions();
				$where="  ";
				$fields="sys_transactions.id, sys_transactions.name, sys_transactions.moduleid";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$transactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($transactions->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->transactionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Treatment No</td>
				<td><input type='text' id='treatmentno' size='4' name='treatmentno' value='<?php echo $obj->treatmentno;?>'></td>
			</tr>
			<tr>
				<td>Date Invoiced</td>
				<td><strong>From:</strong><input type='text' id='frominvoicedon' size='8' name='frominvoicedon' readonly class="date_input" value='<?php echo $obj->frominvoicedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toinvoicedon' size='8' name='toinvoicedon' readonly class="date_input" value='<?php echo $obj->toinvoicedon;?>'/></td>
			</tr>
			<tr>
				<td>Pay Status</td>
			</tr>
			<tr>
				<td>Department</td>
				<td>
				<select name='departmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$departments=new Departments();
				$where="  ";
				$fields="hos_departments.id, hos_departments.name, hos_departments.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($departments->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='grdepartmentid' value='1' <?php if(isset($_POST['grdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno']) ){echo"checked";}?>>&nbsp;Documentno</td>
				<td><input type='checkbox' name='shpatientid' value='1' <?php if(isset($_POST['shpatientid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Patient</td>
			<tr>
				<td><input type='checkbox' name='shtransactionid' value='1' <?php if(isset($_POST['shtransactionid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Transaction</td>
				<td><input type='checkbox' name='shtreatmentno' value='1' <?php if(isset($_POST['shtreatmentno']) ){echo"checked";}?>>&nbsp;Treatment No</td>
			<tr>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shinvoicedon' value='1' <?php if(isset($_POST['shinvoicedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Date Invoiced</td>
				<td><input type='checkbox' name='shpaid' value='1' <?php if(isset($_POST['shpaid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Pay Status</td>
			<tr>
				<td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Department</td>
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
			<?php if($obj->shdocumentno==1 ){ ?>
				<th>Receipt No </th>
			<?php } ?>
			<?php if($obj->shpatientid==1  or empty($obj->action)){ ?>
				<th>Patient </th>
			<?php } ?>
			<?php if($obj->shtransactionid==1  or empty($obj->action)){ ?>
				<th>Bill Term </th>
			<?php } ?>
			<?php if($obj->shtreatmentno==1 ){ ?>
				<th>Treatment No </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shinvoicedon==1  or empty($obj->action)){ ?>
				<th>Date Invoiced </th>
			<?php } ?>
			<?php if($obj->shpaid==1  or empty($obj->action)){ ?>
				<th>Pay Status </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
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
