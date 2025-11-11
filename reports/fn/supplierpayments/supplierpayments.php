<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/supplierpayments/Supplierpayments_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");
require_once("../../../modules/sys/paymentmodes/Paymentmodes_class.php");
require_once("../../../modules/fn/banks/Banks_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Supplierpayments";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8753";//Report View
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
if(!empty($obj->grsupplierid) or !empty($obj->grdocumentno) or !empty($obj->grpaidon) or !empty($obj->grpaymentmodeid) or !empty($obj->grbankid) or !empty($obj->shchequeno) or !empty($obj->grcreatedon) or !empty($obj->grcreatedby) ){
	$obj->shsupplierid='';
	$obj->shdocumentno='';
	$obj->shpaidon='';
	$obj->shamount='';
	$obj->shpaymentmodeid='';
	$obj->shbankid='';
	$obj->shcreatedon='';
	$obj->shcreatedby='';
	$obj->shipaddress='';
}


	$obj->shsupplierid=1;
	$obj->shdocumentno=1;
	$obj->shpaidon=1;
	$obj->shamount=1;
	$obj->shpaymentmodeid=1;
	$obj->shbankid=1;
	$obj->shcreatedon=1;
	$obj->shcreatedby=1;
	$obj->shipaddress='';


if(!empty($obj->grsupplierid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" supplierid ";
	$obj->shsupplierid=1;
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

if(!empty($obj->grpaidon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" paidon ";
	$obj->shpaidon=1;
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

if(!empty($obj->shchequeno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" chequeno ";
	$obj->shchequeno=1;
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

if(!empty($obj->grcreatedby)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" createdby ";
	$obj->shcreatedby=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shsupplierid)  or empty($obj->action)){
		array_push($sColumns, 'supplierid');
		array_push($aColumns, "proc_suppliers.name as supplierid");
		$rptjoin.=" left join proc_suppliers on proc_suppliers.id=fn_supplierpayments.supplierid ";
		$k++;
		}

	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "fn_supplierpayments.documentno");
		$k++;
		}

	if(!empty($obj->shpaidon)  or empty($obj->action)){
		array_push($sColumns, 'paidon');
		array_push($aColumns, "fn_supplierpayments.paidon");
		$k++;
		}

	if(!empty($obj->shamount)  or empty($obj->action)){
		array_push($sColumns, 'amount');
		if(!empty($rptgroup)){
		        if($obj->currencyid==5)
			array_push($aColumns, "round(sum(fn_supplierpayments.amount*exchangerate),2) amount");
			elseif($obj->currencyid==1)
			array_push($aColumns, "round(sum(fn_supplierpayments.amount*exchangerate2),2) amount");
			else
			array_push($aColumns, "round((fn_supplierpayments.amount),2)  amount");
		}else{
		if($obj->currencyid==5)
		array_push($aColumns, "round((fn_supplierpayments.amount*exchangerate),2)  amount");
		elseif($obj->currencyid==1)
		array_push($aColumns, "round((fn_supplierpayments.amount*exchangerate2),2)  amount");
		else
		array_push($aColumns, "round((fn_supplierpayments.amount),2)  amount");
		}

		$k++;
		}

	if(!empty($obj->shpaymentmodeid)  or empty($obj->action)){
		array_push($sColumns, 'paymentmodeid');
		array_push($aColumns, "sys_paymentmodes.name as paymentmodeid");
		$rptjoin.=" left join sys_paymentmodes on sys_paymentmodes.id=fn_supplierpayments.paymentmodeid ";
		$k++;
		}

	if(!empty($obj->shbankid)  or empty($obj->action)){
		array_push($sColumns, 'bankid');
		array_push($aColumns, "fn_banks.name as bankid");
		$rptjoin.=" left join fn_banks on fn_banks.id=fn_supplierpayments.bankid ";
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "fn_supplierpayments.createdon");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=fn_supplierpayments.createdby ";
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "fn_supplierpayments.ipaddress");
		$k++;
		}
		
	if(!empty($obj->shchequeno)){
		array_push($sColumns, 'chequeno');
		array_push($aColumns, "fn_supplierpayments.chequeno");
		$k++;
		}


$track=0;

//processing filters
if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.supplierid='$obj->supplierid'";
		$join=" left join proc_suppliers on fn_supplierpayments.id=proc_suppliers.supplierpaymentid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->frompaidon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.paidon>='$obj->frompaidon'";
	$track++;
}

if(!empty($obj->topaidon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.paidon<='$obj->topaidon'";
	$track++;
}

if(!empty($obj->fromamount)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.amount>='$obj->fromamount'";
	$track++;
}

if(!empty($obj->toamount)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.amount<='$obj->toamount'";
	$track++;
}

if(!empty($obj->paymentmodeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.paymentmodeid='$obj->paymentmodeid'";
		$join=" left join sys_paymentmodes on fn_supplierpayments.id=sys_paymentmodes.supplierpaymentid ";
		$track++;
}

if(!empty($obj->bankid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.bankid='$obj->bankid'";
		$join=" left join fn_banks on fn_supplierpayments.id=fn_banks.supplierpaymentid ";
		$track++;
}

if(!empty($obj->chequeno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.chequeno='$obj->chequeno'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_supplierpayments.createdby='$obj->createdby'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
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
 <?php $_SESSION['sTable']="fn_supplierpayments";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_supplierpayments",
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
<form  action="supplierpayments.php" method="post" name="supplierpayments" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
		        <tr>
		
			      Currency: <select name="currencyid" class="selectbox">
				<option value="">Select...</option>  
				<?php
				$currencys = new Currencys();
				$fields="* ";
				$join=" ";
				$having="";
				$groupby="";
				$orderby=" order by id desc ";
				$where=" where id in(1,5) ";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				while($row=mysql_fetch_object($currencys->result)){
				  ?>
				  <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->currencyid){echo"selected";}?>><?php echo $row->name; ?></option>
				  <?php
				}
				?>
			      </select>&nbsp;
		        </tr>		
			<tr>
				<td>Supplier</td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Paid on</td>
				<td><strong>From:</strong><input type='text' id='frompaidon' size='12' name='frompaidon' readonly class="date_input" value='<?php echo $obj->frompaidon;?>'/>
							<br/><strong>To:</strong><input type='text' id='topaidon' size='12' name='topaidon' readonly class="date_input" value='<?php echo $obj->topaidon;?>'/></td>
			</tr>
			<tr>
				<td>Amount</td>
				<td><strong>From:</strong><input type='text' id='fromamount' size='from20' name='fromamount' value='<?php echo $obj->fromamount;?>'/>
								<br/><strong>To:</strong><input type='text' id='toamount' size='to20' name='toamount' value='<?php echo $obj->toamount;?>'></td>
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
				<td>Cheque no</td>
				<td><input type='text' id='chequeno' size='20' name='chequeno' value='<?php echo $obj->chequeno;?>'></td>
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
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from fn_supplierpayments) ";
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grsupplierid' value='1' <?php if(isset($_POST['grsupplierid']) ){echo"checked";}?>>&nbsp;Supplier</td>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='grpaidon' value='1' <?php if(isset($_POST['grpaidon']) ){echo"checked";}?>>&nbsp;Paid on</td>
				<td><input type='checkbox' name='grpaymentmodeid' value='1' <?php if(isset($_POST['grpaymentmodeid']) ){echo"checked";}?>>&nbsp;Payment mode</td>
			<tr>
				<td><input type='checkbox' name='grbankid' value='1' <?php if(isset($_POST['grbankid']) ){echo"checked";}?>>&nbsp;Bank</td>
				<td><input type='checkbox' name='shchequeno' value='1' <?php if(isset($_POST['shchequeno']) ){echo"checked";}?>>&nbsp;Cheque no</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
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
				<td><input type='checkbox' name='shsupplierid' value='1' <?php if(isset($_POST['shsupplierid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Supplier</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
			<tr>
				<td><input type='checkbox' name='shpaidon' value='1' <?php if(isset($_POST['shpaidon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Paid on</td>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shpaymentmodeid' value='1' <?php if(isset($_POST['shpaymentmodeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Payment mode</td>
				<td><input type='checkbox' name='shbankid' value='1' <?php if(isset($_POST['shbankid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Bank</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
				<td><input type='checkbox' name='shchequeno' value='1' <?php if(isset($_POST['shchequeno']) ){echo"checked";}?>>&nbsp;chequeno</td>
			<tr>
				
				
				
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
			<?php if($obj->shsupplierid==1  or empty($obj->action)){ ?>
				<th>Supplier </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Voucher No </th>
			<?php } ?>
			<?php if($obj->shpaidon==1  or empty($obj->action)){ ?>
				<th>Payment Date </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shpaymentmodeid==1  or empty($obj->action)){ ?>
				<th>Payment Mode </th>
			<?php } ?>
			<?php if($obj->shbankid==1  or empty($obj->action)){ ?>
				<th>Bank </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th> </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<th>cheque No</th>
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
