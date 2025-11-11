<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/proc/purchaseorders/Purchaseorders_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/inv/departments/Departments_class.php");
require_once("../../../modules/proc/suppliers/Suppliers_class.php");
require_once("../../../modules/proc/purchaseorders/Purchaseorders_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Purchaseorders";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8775";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../rptheader.php";

if(empty($obj->action)){
	$obj->fromorderedon=date('Y-m-d');
	$obj->toorderedon=date('Y-m-d');
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
	
$obj->shquantity=1;
$obj->shtotal=1;

$obj->shitemid=1;
$obj->shrequisitionno=1;
$obj->shlpono=1;
$obj->shlpodate=1;
$obj->shbal=1;
$obj->shqtyrec=1;	
$obj->shqtyord=1;
$obj->shapproved=1;
$obj->shqtyreq=1;
$obj->shsupplier=1;

//processing columns to show{
	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemids');
		array_push($aColumns, " case when proc_requisitiondetails.itemid is not null then inv_items.name else fn_expenses.name end as itemids");
		$k++;
		$join=" left join proc_requisitiondetails on proc_requisitiondetails.requisitionid=proc_requisitions.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=proc_requisitiondetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join fn_expenses on fn_expenses.id=proc_requisitiondetails.expenseid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
	if(!empty($obj->shrequisitionno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "proc_requisitions.documentno as documentno");
		$k++;
		}

	if(!empty($obj->shapproved)  or empty($obj->action)){
			array_push($sColumns, 'approved');		
			array_push($aColumns, "(select case when createdon is null then '' else createdon end from pm_tasks where pm_tasks.documentno=proc_requisitions.documentno and assignmentid=(select assignmentid from wf_routedetails where routeid=1 and id=(select (id+1) from wf_routedetails where routeid=1 and squery like '%update%')) and pm_tasks.routeid=1 and name like 'Requisition Approval%') as approved");
// array_push($aColumns, " 1 as approved");
			$k++;
		}

        if(!empty($obj->shlpono)  or empty($obj->action)){
		array_push($sColumns, 'lpono');		
		array_push($aColumns, "(select case when group_concat(distinct proc_purchaseorders.documentno) is null then '' else group_concat(distinct proc_purchaseorders.documentno) end lpono from proc_purchaseorders where proc_purchaseorders.requisitionno=proc_requisitions.documentno and id in(select purchaseorderid from proc_purchaseorderdetails where proc_purchaseorderdetails.itemid=proc_requisitiondetails.itemid)) as lpono");
		$k++;
	}
	
	 if(!empty($obj->shlpodate)  or empty($obj->action)){
		array_push($sColumns, 'lpodate');		
		array_push($aColumns, "(select case when group_concat(distinct proc_purchaseorders.orderedon) is null then '' else group_concat(distinct proc_purchaseorders.orderedon) end lpodate from proc_purchaseorders where proc_purchaseorders.requisitionno=proc_requisitions.documentno and id in(select purchaseorderid from proc_purchaseorderdetails where proc_purchaseorderdetails.itemid=proc_requisitiondetails.itemid)) as lpodate");
		$k++;
	}
	
	if(!empty($obj->shsupplier)  or empty($obj->action)){
		array_push($sColumns, 'supplier');		
		array_push($aColumns, "(select case when group_concat(distinct proc_purchaseorders.supplierid) is null then '' else group_concat(distinct proc_suppliers.name) end supplier from proc_purchaseorders left join proc_suppliers on proc_suppliers.id=proc_purchaseorders.supplierid where proc_purchaseorders.requisitionno=proc_requisitions.documentno and proc_purchaseorders.id in(select purchaseorderid from proc_purchaseorderdetails where proc_purchaseorderdetails.itemid=proc_requisitiondetails.itemid)) as supplier");
// 		array_push($aColumns,"proc_suppliers.name supplier");
		
		$join=" left join proc_purchaseorders on proc_purchaseorders.requisitionno=proc_requisitions.documentno ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join proc_suppliers on proc_suppliers.id=proc_purchaseorders.supplierid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$k++;
	}
	
	
	if(!empty($obj->shqtyreq)  or empty($obj->action)){
		array_push($sColumns, 'qtyreq');
		array_push($aColumns, "sum(proc_requisitiondetails.quantity) as qtyreq");
		$k++;
		$join=" left join proc_requisitiondetails on proc_requisitiondetails.requisitionid=proc_requisitions.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

        if(!empty($obj->shqtyord)  or empty($obj->action)){
		array_push($sColumns, 'qtyord');
		array_push($aColumns, "(select case when sum(proc_purchaseorderdetails.quantity) is null then 0 else sum(proc_purchaseorderdetails.quantity) end qtyord from proc_purchaseorderdetails where proc_purchaseorderdetails.purchaseorderid in(select id from proc_purchaseorders where proc_purchaseorders.requisitionno=proc_requisitions.documentno) and proc_purchaseorderdetails.itemid=proc_requisitiondetails.itemid) as qtyord");
		$k++;
		
	}
	
	if(!empty($obj->shqtyrec)  or empty($obj->action)){
		array_push($sColumns, 'qtyrec');
		array_push($aColumns, "(select case when sum(proc_inwarddetails.quantity) is null then 0 else sum(proc_inwarddetails.quantity) end qtyrec from proc_inwarddetails where proc_inwarddetails.inwardid in(select id from proc_inwards where proc_inwards.lpono in(select proc_purchaseorders.documentno from proc_purchaseorders where proc_purchaseorders.requisitionno=proc_requisitions.documentno)) and proc_inwarddetails.itemid=proc_requisitiondetails.itemid) as qtyrec");
		$k++;
		
	} 
	
	if(!empty($obj->shbal)  or empty($obj->action)){
		array_push($sColumns, 'bal');
		array_push($aColumns, "((select case when sum(proc_purchaseorderdetails.quantity) is null then 0 else sum(proc_purchaseorderdetails.quantity) end qtyord from proc_purchaseorderdetails where proc_purchaseorderdetails.purchaseorderid in(select id from proc_purchaseorders where proc_purchaseorders.requisitionno=proc_requisitions.documentno) and proc_purchaseorderdetails.itemid=proc_requisitiondetails.itemid)-(select case when sum(proc_inwarddetails.quantity) is null then 0 else sum(proc_inwarddetails.quantity) end qtyrec from proc_inwarddetails where proc_inwarddetails.inwardid in(select id from proc_inwards where proc_inwards.lpono in(select proc_purchaseorders.documentno from proc_purchaseorders where proc_purchaseorders.requisitionno=proc_requisitions.documentno)) and proc_inwarddetails.itemid=proc_requisitiondetails.itemid)) as bal");
		$k++;
		
	}

array_push($sColumns, '10');
array_push($aColumns, "1");

array_push($sColumns, '11');
array_push($aColumns, "1");
	




//processing filters
if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.=" and ";
	$rptwhere.=" proc_requisitions.departmentid='$obj->departmentid' ";
	
	$track++;
}
// 
if(!empty($obj->fromrequesteddate)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" proc_requisitions.requisitiondate>='$obj->fromrequesteddate'";
	$track++;
}

if(!empty($obj->torequesteddate)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" proc_requisitions.requisitiondate<='$obj->torequesteddate'";
	$track++;
}

if(!empty($obj->fromorderedon)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" proc_purchaseorders.orderedon>='$obj->fromorderedon'";
		$join=" left join proc_purchaseorders on proc_purchaseorders.requisitionno=proc_requisitions.documentno ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->toorderedon)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" proc_purchaseorders.orderedon<='$obj->toorderedon'";
		$join=" left join proc_purchaseorders on proc_purchaseorders.requisitionno=proc_requisitions.documentno ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->requisitionno)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" proc_requisitions.documentno='$obj->requisitionno'";
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" proc_purchaseorders.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" proc_requisitiondetails.itemid='$obj->itemid'";
	$track++;
}

if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" proc_purchaseorders.supplierid='$obj->supplierid'";
		$join=" left join proc_purchaseorders on proc_purchaseorders.requisitionno=proc_requisitions.documentno ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	$track++;
}

if(!empty($obj->currencyid)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" proc_suppliers.currencyid='$obj->currencyid'";
	$track++;
}

$having=""; 
if(!empty($obj->ordered)){
  if(empty($having))
    $having.=" having ";
  else
    $having.=" and ";
    
  if($obj->ordered==1)
    $having.=" qtyord=0 ";
  if($obj->ordered==2)
    $having.=" qtyord>0 and qtyord<qtyreq ";
  if($obj->ordered==3)
    $having.=" qtyreq=qtyord ";
}

if(!empty($obj->delivered)){
  if(empty($having))
    $having.=" having ";
  else
    $having.=" and ";
    
  if($obj->delivered==1)
    $having.=" qtyrec=0 ";
  if($obj->delivered==2)
    $having.=" qtyrec>0 and qtyrec<qtyord ";
  if($obj->delivered==3)
    $having.=" qtyrec=qtyord ";
}
                
$rptgroup=" group by proc_requisitions.id,proc_requisitiondetails.itemid ";
//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript">
$().ready(function() {
 $("#suppliername").autocomplete("../../../modules/server/server/search.php?main=proc&module=suppliers&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#suppliername").result(function(event, data, formatted) {
   if (data)
   
   {
     document.getElementById("suppliername").value=data[0];
     document.getElementById("supplierid").value=data[1];
   }
 });
 $("#purchaseordername").autocomplete("../../../modules/server/server/search.php?main=proc&module=purchaseorders&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#purchaseordername").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("purchaseordername").value=data[0];
     document.getElementById("purchaseorderid").value=data[1];
   }
 });
 $("#itemname").autocomplete("../../../modules/server/server/search.php?main=inv&module=items&field=name", {
 	width: 260,
 	selectFirst: false
 });
 $("#itemname").result(function(event, data, formatted) {
   if (data)
   {
     document.getElementById("itemname").value=data[0];
     document.getElementById("itemid").value=data[1];
   }
 });
});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="proc_requisitions";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup $having";?>
 
 $(document).ready(function() {
	TableTools.DEFAULTS.aButtons = [ "copy", "csv", "xls","pdf" ];
				
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
//  		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=proc_requisitions",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
			        if(i<11){
				$('td:eq('+i+')', nRow).html(aaData[i]);
				}else{
				$('td:eq('+i+')', nRow).html("");
				}
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
<button id="create-user">Filter</button>
<div id="toPopup" >
<div class="close"></div>
<span class="ecs_tooltip">Press Esc to close <span class="arrow"></span>
<div id="dialog-modal" title="Filter" style="font:tahoma;font-size:10px;">
<form  action="summarisedpurchaseorders.php" method="post" name="summarisedpurchaseorders" >
<table width="100%" border="0" align="center">
	<tr>
				<td>Item</td>
				<td>
				<input type='text' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
				<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'>
                                </td>
			</tr>
			<tr>
				<td>LPO No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Requisition No</td>
				<td><input type='text' id='requisitionno' size='20' name='requisitionno' value='<?php echo $obj->requisitionno;?>'></td>
			</tr>
			<tr>
				<td>Supplier</td>
				<td><input type='text' size='20' name='suppliername' id='suppliername' value='<?php echo $obj->suppliername; ?>'>
					<input type="hidden" name='supplierid' id='supplierid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
			        <td>Requested:</td><td>From:<input type="text" size="12" class="date_input" name="fromrequesteddate" value="<?php echo $obj->fromrequesteddate; ?>"/><br/>
			        To: <input type="text" size="12" class="date_input" name="torequesteddate" value="<?php echo $obj->torequesteddate; ?>"/></td>
			</tr>
			<tr>
			        <td>Department</td>
			        <td><select name="departmentid" class="selectbox">
				    <option value="">Select...</option>  
				    <?php
				    $departments = new Departments();
				    $fields="* ";
				    $join=" ";
				    $having="";
				    $groupby="";
				    $orderby="";
				    $where="";
				    $departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
				    while($row=mysql_fetch_object($departments->result)){
				      ?>
				      <option value="<?php echo $row->id; ?>" <?php if($row->id==$obj->departmentid){echo"selected";}?>><?php echo $row->name; ?></option>
				      <?php
				    }
				    ?>
				    </select>
				 </td>
		         </tr>				
			<tr>
				<td>Order On</td>
				<td><strong>From:</strong><input type='text' id='fromorderedon' size='12' name='fromorderedon' readonly class="date_input" value='<?php echo $obj->fromorderedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toorderedon' size='12' name='toorderedon' readonly class="date_input" value='<?php echo $obj->toorderedon;?>'/></td>
			</tr>
			<tr>
			  <td>Ordered:</td>
			  <td>
			    <input type="radio" name="ordered" value="1" <?php if($obj->ordered==1){echo "checked";}?>/>Not Ordered
			    <input type="radio" name="ordered" value="2" <?php if($obj->ordered==2){echo "checked";}?>/>Partially Ordered
			    <input type="radio" name="ordered" value="3" <?php if($obj->ordered==3){echo "checked";}?>/>Fully Ordered
			  </td>
			</tr>
			
			<tr>
			  <td>Delivered:</td>
			  <td>
			    <input type="radio" name="delivered" value="1" <?php if($obj->delivered==1){echo "checked";}?>/>Not Delivered
			    <input type="radio" name="delivered" value="2" <?php if($obj->delivered==2){echo "checked";}?>/>Partially Delivered
			    <input type="radio" name="delivered" value="3" <?php if($obj->delivered==3){echo "checked";}?>/>Fully Delivered
			  </td>
			</tr>
			
			<tr>
				<td>Currency</td>
				<td>
				<select name='currencyid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$currencys=new Currencys();
				$where="  ";
				$fields="sys_currencys.id, sys_currencys.name, sys_currencys.rate, sys_currencys.eurorate, sys_currencys.remarks, sys_currencys.ipaddress, sys_currencys.createdby, sys_currencys.createdon, sys_currencys.lasteditedby, sys_currencys.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$currencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($currencys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->currencyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
		</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" class="btn" name="action" id="action" value="Filter" /></td>
	</tr>
</table>
</form>
</div>
</div>
<table style="clear:both;"  class="tgrid display" id="tbl" width="98%" height="200px" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>            
		      <th>#</th>
		      <th>Item</th>
		      <th>Requisition No</th>
		      <th>Requisition Appro. On</th>
		      <th>LPO No</th>
		      <th>LPO Date</th>
		      <th>Supplier</th>
		      <th>Qty Requested</th>
		      <th>Qty Ordered</th>
		      <th>Qty Received</th>
		      <th>Balance</th>
		      <th>Expected date</th>
		      <th>Remarks</th>
		</tr>
	</thead>
	<tbody>
	<tfoot>
		<tr>	
		      <th>#</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>
		      <th>&nbsp;</th>				
		</tr>
	</tfoot>
	</tbody>
</div>
</div>
</div>
</div>
</div>
