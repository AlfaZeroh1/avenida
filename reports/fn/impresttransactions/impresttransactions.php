<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/impresttransactions/Impresttransactions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/imprestaccounts/Imprestaccounts_class.php");
require_once("../../../modules/fn/imprests/Imprests_class.php");
require_once("../../../modules/fn/expenses/Expenses_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Impresttransactions";
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
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "fn_impresttransactions.documentno");
	}

	if(!empty($obj->shimprestaccountid)  or empty($obj->action)){
		array_push($sColumns, 'imprestaccountid');
		array_push($aColumns, "fn_imprestaccounts.name as imprestaccountid");
		$rptjoin.=" left join fn_imprestaccounts on fn_imprestaccounts.id=fn_impresttransactions.imprestaccountid ";
	}

	if(!empty($obj->shimprestid)  or empty($obj->action)){
		array_push($sColumns, 'imprestid');
		array_push($aColumns, "concat('Imprest #',' ',fn_imprests.documentno) as imprestid");
		$rptjoin.=" left join fn_imprests on fn_imprests.id=fn_impresttransactions.imprestid ";
	}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "fn_impresttransactions.memo");
	}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "fn_impresttransactions.quantity");
	}

	if(!empty($obj->shamount)  or empty($obj->action)){
		array_push($sColumns, 'amount');
		array_push($aColumns, "fn_impresttransactions.amount");
	}

	if(!empty($obj->shincurredon)  or empty($obj->action)){
		array_push($sColumns, 'incurredon');
		array_push($aColumns, "fn_impresttransactions.incurredon");
	}

	if(!empty($obj->shenteredon) ){
		array_push($sColumns, 'enteredon');
		array_push($aColumns, "fn_impresttransactions.enteredon");
	}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "fn_impresttransactions.remarks");
	}

	if(!empty($obj->shstatus) ){
		array_push($sColumns, 'status');
		array_push($aColumns, "fn_impresttransactions.status");
	}

	if(!empty($obj->shexpenseid)  or empty($obj->action)){
		array_push($sColumns, 'expenseid');
		array_push($aColumns, "fn_expenses.name as expenseid");
		$rptjoin.=" left join fn_expenses on fn_expenses.id=fn_impresttransactions.expenseid ";
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "fn_impresttransactions.createdby");
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "fn_impresttransactions.createdon");
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "fn_impresttransactions.ipaddress");
	}



if($obj->action=='Filter'){
//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->imprestaccountid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.imprestaccountid='$obj->imprestaccountid'";
	$track++;
}

if(!empty($obj->imprestid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.imprestid='$obj->imprestid'";
	$track++;
}

if(!empty($obj->fromquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.quantity>='$obj->fromquantity'";
	$track++;
}

if(!empty($obj->toquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.quantity<='$obj->toquantity'";
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.quantity='$obj->quantity'";
	$track++;
}

if(!empty($obj->fromamount)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.amount>='$obj->fromamount'";
	$track++;
}

if(!empty($obj->toamount)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.amount<='$obj->toamount'";
	$track++;
}

if(!empty($obj->amount)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.amount='$obj->amount'";
	$track++;
}

if(!empty($obj->fromincurredon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.incurredon>='$obj->fromincurredon'";
	$track++;
}

if(!empty($obj->toincurredon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.incurredon<='$obj->toincurredon'";
	$track++;
}

if(!empty($obj->fromenteredon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.enteredon>='$obj->fromenteredon'";
	$track++;
}

if(!empty($obj->toenteredon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.enteredon<='$obj->toenteredon'";
	$track++;
}

if(!empty($obj->expenseid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.expenseid='$obj->expenseid'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_impresttransactions.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
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

if(!empty($obj->grimprestid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" imprestid ";
	$obj->shimprestid=1;
	$track++;
}

if(!empty($obj->grincurredon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" incurredon ";
	$obj->shincurredon=1;
	$track++;
}

if(!empty($obj->grenteredon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" enteredon ";
	$obj->shenteredon=1;
	$track++;
}

if(!empty($obj->grexpenseid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" expenseid ";
	$obj->shexpenseid=1;
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
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="fn_impresttransactions";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_impresttransactions",
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
<form  action="impresttransactions.php" method="post" name="impresttransactions" class='forms'>
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Imprest No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
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
				<td>Imprest</td>
				<td>
				<select name='imprestid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$imprests=new Imprests();
				$where="  ";
				$fields="fn_imprests.id, fn_imprests.documentno, fn_imprests.paymentvoucherno, fn_imprests.imprestaccountid, fn_imprests.employeeid, fn_imprests.issuedon, fn_imprests.paymentmodeid, fn_imprests.bankid, fn_imprests.chequeno, fn_imprests.amount, fn_imprests.memo, fn_imprests.remarks, fn_imprests.ipaddress, fn_imprests.createdby, fn_imprests.createdon, fn_imprests.lasteditedby, fn_imprests.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$imprests->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($imprests->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->imprestid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td>Amount</td>
				<td><strong>From:</strong><input type='text' id='fromamount' size='from20' name='fromamount' value='<?php echo $obj->fromamount;?>'/>
								<br/><strong>To:</strong><input type='text' id='toamount' size='to20' name='toamount' value='<?php echo $obj->toamount;?>'></td>
			</tr>
			<tr>
				<td>Transaction Date</td>
				<td><strong>From:</strong><input type='text' id='fromincurredon' size='12' name='fromincurredon' readonly class="date_input" value='<?php echo $obj->fromincurredon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toincurredon' size='12' name='toincurredon' readonly class="date_input" value='<?php echo $obj->toincurredon;?>'/></td>
			</tr>
			<tr>
				<td>Entered On </td>
				<td><strong>From:</strong><input type='text' id='fromenteredon' size='12' name='fromenteredon' readonly class="date_input" value='<?php echo $obj->fromenteredon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toenteredon' size='12' name='toenteredon' readonly class="date_input" value='<?php echo $obj->toenteredon;?>'/></td>
			</tr>
			<tr>
				<td>Expense</td>
				<td>
				<select name='expenseid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$expenses=new Expenses();
				$where="  ";
				$fields="fn_expenses.id, fn_expenses.name, fn_expenses.code, fn_expenses.expensetypeid, fn_expenses.expensecategoryid, fn_expenses.description, fn_expenses.ipaddress, fn_expenses.createdby, fn_expenses.createdon, fn_expenses.lasteditedby, fn_expenses.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($expenses->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->expenseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Imprest No</td>
				<td><input type='checkbox' name='grimprestaccountid' value='1' <?php if(isset($_POST['grimprestaccountid']) ){echo"checked";}?>>&nbsp;Imprest Account</td>
			<tr>
				<td><input type='checkbox' name='grimprestid' value='1' <?php if(isset($_POST['grimprestid']) ){echo"checked";}?>>&nbsp;Imprest</td>
				<td><input type='checkbox' name='grincurredon' value='1' <?php if(isset($_POST['grincurredon']) ){echo"checked";}?>>&nbsp;Transaction Date</td>
			<tr>
				<td><input type='checkbox' name='grenteredon' value='1' <?php if(isset($_POST['grenteredon']) ){echo"checked";}?>>&nbsp;Entered On </td>
				<td><input type='checkbox' name='grexpenseid' value='1' <?php if(isset($_POST['grexpenseid']) ){echo"checked";}?>>&nbsp;Expense</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Imprest No</td>
				<td><input type='checkbox' name='shimprestaccountid' value='1' <?php if(isset($_POST['shimprestaccountid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Imprest Account</td>
			<tr>
				<td><input type='checkbox' name='shimprestid' value='1' <?php if(isset($_POST['shimprestid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Imprest</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shincurredon' value='1' <?php if(isset($_POST['shincurredon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Transaction Date</td>
				<td><input type='checkbox' name='shenteredon' value='1' <?php if(isset($_POST['shenteredon']) ){echo"checked";}?>>&nbsp;Entered On </td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shstatus' value='1' <?php if(isset($_POST['shstatus']) ){echo"checked";}?>>&nbsp;Status</td>
			<tr>
				<td><input type='checkbox' name='shexpenseid' value='1' <?php if(isset($_POST['shexpenseid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Expense</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
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
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Imprest No </th>
			<?php } ?>
			<?php if($obj->shimprestaccountid==1  or empty($obj->action)){ ?>
				<th>Imprest Account </th>
			<?php } ?>
			<?php if($obj->shimprestid==1  or empty($obj->action)){ ?>
				<th>Imprest </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shincurredon==1  or empty($obj->action)){ ?>
				<th>Transaction Date </th>
			<?php } ?>
			<?php if($obj->shenteredon==1 ){ ?>
				<th>Entered On </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shstatus==1 ){ ?>
				<th>Status </th>
			<?php } ?>
			<?php if($obj->shexpenseid==1  or empty($obj->action)){ ?>
				<th>Expense </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created By</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On </th>
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
