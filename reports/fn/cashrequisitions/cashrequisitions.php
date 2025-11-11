<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/fn/cashrequisitions/Cashrequisitions_class.php");
require_once("../../../modules/fn/cashrequisitiondetails/Cashrequisitiondetails_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/fn/expenses/Expenses_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/fn/expenses/Expenses_class.php");
require_once("../../../modules/fn/cashrequisitiondetails/Cashrequisitiondetails_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Cashrequisitions";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8756";//Add
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
if(!empty($obj->grdocumentno) or !empty($obj->gremployeeid) or !empty($obj->grstatus) or !empty($obj->grexpenseid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shdocumentno='';
	$obj->shemployeeid='';
	$obj->shdescription='';
	$obj->shstatus='';
	$obj->shremarks='';
	$obj->shexpenseid='';
	$obj->shquantity='';
	$obj->shamount='';
	$obj->shtotal='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
}


	$obj->sh=1;


if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
	$track++;
}

if(!empty($obj->gremployeeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employeeid ";
	$obj->shemployeeid=1;
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

//processing columns to show
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "fn_cashrequisitions.documentno");
		$k++;
		}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=fn_cashrequisitions.employeeid ";
		$k++;
		}

	if(!empty($obj->shdescription)  or empty($obj->action)){
		array_push($sColumns, 'description');
		array_push($aColumns, "fn_cashrequisitions.description");
		$k++;
		}

	if(!empty($obj->shstatus)  or empty($obj->action)){
		array_push($sColumns, 'status');
		array_push($aColumns, "fn_cashrequisitions.status");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "fn_cashrequisitions.remarks");
		$k++;
		}

	if(!empty($obj->shexpenseid)  or empty($obj->action)){
		array_push($sColumns, 'expenseid');
		array_push($aColumns, "fn_expenses.name as expenseid");
		$k++;
		$join=" left join fn_cashrequisitiondetails on fn_cashrequisitions.id=fn_cashrequisitiondetails.cashrequisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join fn_expenses on fn_expenses.id=fn_cashrequisitiondetails.expenseid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
	

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "fn_cashrequisitiondetails.quantity");
		$k++;
		$join=" left join fn_cashrequisitiondetails on fn_cashrequisitions.id=fn_cashrequisitiondetails.cashrequisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		
		}

	if(!empty($obj->shamount)  or empty($obj->action)){
		array_push($sColumns, 'amount');
		array_push($aColumns, "fn_cashrequisitiondetails.amount");
		$k++;
		$join=" left join fn_cashrequisitiondetails on fn_cashrequisitions.id=fn_cashrequisitiondetails.cashrequisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shtotal)  or empty($obj->action)){
		array_push($sColumns, 'total');
		array_push($aColumns, "fn_cashrequisitiondetails.total");
		$k++;
		$join=" left join fn_cashrequisitiondetails on fn_cashrequisitions.id=fn_cashrequisitiondetails.cashrequisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=fn_cashrequisitions.createdby ";
		$k++;
		}

	if(!empty($obj->shcreatedon) ){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "fn_cashrequisitions.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_cashrequisitions.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_cashrequisitions.employeeid='$obj->employeeid'";
		$join=" left join hrm_employees on fn_cashrequisitions.id=hrm_employees.cashrequisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->status)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_cashrequisitions.status='$obj->status'";
	$track++;
}

if(!empty($obj->expenseid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" fn_expenses.id='$obj->expenseid' ";
	$join=" left join fn_cashrequisitiondetails on fn_cashrequisitions.id=fn_cashrequisitiondetails.cashrequisitionid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join fn_expenses on fn_expenses.id=fn_cashrequisitiondetails.expenseid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_cashrequisitions.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_cashrequisitions.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" fn_cashrequisitions.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
if(!empty($obj->shemployeeid)){
	$fd.=" ,concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) ";
}
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
  $("#employeeiname").autocomplete({
	source:"../../../modules/server/server/search.php?main=hrm&module=employees&field=concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#employeeid").val(ui.item.id);
	}
  });

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="fn_cashrequisitions";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=fn_cashrequisitions",
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
<form  action="cashrequisitions.php" method="post" name="cashrequisitions" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document no</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeeiname' id='employeeiname' value='<?php echo $obj->employeeiname; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Status</td>
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
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='20' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='20' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
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
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='grstatus' value='1' <?php if(isset($_POST['grstatus']) ){echo"checked";}?>>&nbsp;Status</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document no</td>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='shdescription' value='1' <?php if(isset($_POST['shdescription'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Description</td>
				<td><input type='checkbox' name='shstatus' value='1' <?php if(isset($_POST['shstatus'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Status</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shexpenseid' value='1' <?php if(isset($_POST['shexpenseid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Expense</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
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
				<th>Requisition No </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shdescription==1  or empty($obj->action)){ ?>
				<th>Description </th>
			<?php } ?>
			<?php if($obj->shstatus==1  or empty($obj->action)){ ?>
				<th>Status </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shexpenseid==1  or empty($obj->action)){ ?>
				<th>Expense </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shamount==1  or empty($obj->action)){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>Total </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>createdby </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
				<th>createdon </th>
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
