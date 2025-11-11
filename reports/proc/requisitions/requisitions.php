<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/proc/requisitions/Requisitions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/inv/unitofmeasures/Unitofmeasures_class.php");
require_once("../../../modules/inv/departments/Departments_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Requisitions";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8776";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromrequisitiondate=date('Y-m-d');
	$obj->torequisitiondate=date('Y-m-d');
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
if(!empty($obj->grdocumentno) or !empty($obj->gritemid) or !empty($obj->grrequisitiondate) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->grdepartmentid) or !empty($obj->grrequiredon) ){
	$obj->shdocumentno='';
	$obj->shitemid='';
	$obj->shunitofmeasureid='';
	$obj->shquantity='';
	$obj->shcostprice='';
	$obj->shtotal='';
	$obj->shrequisitiondate='';
	$obj->shstatus='';
	$obj->shmemo='';
	$obj->shremarks='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shdepartmentid='';
	$obj->shrequiredon='';
	$obj->shfile='';
}


	$obj->shquantity=1;
	$obj->shtotal=1;


if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
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

if(!empty($obj->grrequisitiondate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" requisitiondate ";
	$obj->shrequisitiondate=1;
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

if(!empty($obj->grdepartmentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" departmentid ";
	$obj->shdepartmentid=1;
	$track++;
}

if(!empty($obj->grrequiredon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" requiredon ";
	$obj->shrequiredon=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "proc_requisitions.documentno");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name as itemid");
		$k++;
		$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=proc_requisitiondetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
		
	if(!empty($obj->shunitofmeasureid)  or empty($obj->action)){
		array_push($sColumns, 'unitofmeasureid');
		array_push($aColumns, "inv_unitofmeasures.name as unitofmeasureid");
		$k++;
		$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_unitofmeasures on inv_unitofmeasures.id=proc_requisitiondetails.unitofmeasureid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(proc_requisitiondetails.quantity) quantity");
		}else{
		array_push($aColumns, "proc_requisitiondetails.quantity");
		}

		$k++;
		$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.quantity ";
		
		
		
		}

	if(!empty($obj->shcostprice)  or empty($obj->action)){
		array_push($sColumns, 'costprice');
		array_push($aColumns, "proc_requisitiondetails.costprice");
		$k++;
		$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.costprice ";
		
		$mnt=$k;
		}

	if(!empty($obj->shtotal)  or empty($obj->action)){
		array_push($sColumns, 'total');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(proc_requisitiondetails.total) total");
		}else{
		array_push($aColumns, "proc_requisitiondetails.total");
		}

		$k++;
		$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.total ";
		
		}

	if(!empty($obj->shrequisitiondate) ){
		array_push($sColumns, 'requisitiondate');
		array_push($aColumns, "proc_requisitions.requisitiondate");
		$k++;
		}

	if(!empty($obj->shstatus)  or empty($obj->action)){
		array_push($sColumns, 'status');
		array_push($aColumns, "case when proc_requisitions.status = 1 then 'Approved' else 'Not Approved' end as status");
		$k++;
		
		$x=$k;
		
		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "proc_requisitiondetails.memo");
		$k++;
		$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=proc_requisitiondetails.memo ";
		
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "proc_requisitions.remarks");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=proc_requisitions.lasteditedby ";
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "proc_requisitions.lasteditedon createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "proc_requisitions.ipaddress");
		$k++;
		}

	if(!empty($obj->shdepartmentid)  or empty($obj->action)){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "inv_departments.name as departmentid");
		$rptjoin.=" left join inv_departments on inv_departments.id=proc_requisitions.departmentid ";
		$k++;
		}

	if(!empty($obj->shrequiredon) ){
		array_push($sColumns, 'requiredon');
		array_push($aColumns, "proc_requisitiondetails.requiredon");
		$k++;
		}

	if(!empty($obj->shfile) ){
		array_push($sColumns, 'file');
		array_push($aColumns, "proc_requisitions.file");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_requisitions.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.id='$obj->itemid' ";
	$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.requisitionid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=proc_requisitiondetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" .id='$obj->quantity' ";
	$join=" left join proc_requisitiondetails on proc_requisitions.id=proc_requisitiondetails.requisitionid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join  on .id=proc_requisitiondetails.quantity ";
	
	$track++;
}

if(!empty($obj->fromrequisitiondate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_requisitions.requisitiondate>='$obj->fromrequisitiondate'";
	$track++;
}

if(!empty($obj->torequisitiondate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_requisitions.requisitiondate<='$obj->torequisitiondate'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_requisitions.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_requisitions.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_requisitions.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" proc_requisitions.departmentid='$obj->departmentid'";
		$join=" left join inv_departments on proc_requisitions.id=inv_departments.requisitionid ";
		
	$track++;
}

if(!empty($obj->fromrequiredon)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" .id='$obj->requiredon' ";
	$join=" left join proc_requisitiondetails on proc_requisitiondetails.id=proc_requisitiondetails.requisitiondetailid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join  on .id=proc_requisitiondetails.requiredon ";
	
	$track++;
}

if(!empty($obj->torequiredon)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" .id='$obj->requiredon' ";
	$join=" left join proc_requisitiondetails on proc_requisitiondetails.id=proc_requisitiondetails.requisitiondetailid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join  on .id=proc_requisitiondetails.requiredon ";
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
<style media="all" type="text/css">
.green{
    color:#88b645 !important;
}
.red{
    color:red !important;
}
</style>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="proc_requisitions";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=proc_requisitions",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
                            
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			var color="";
			if(aaData['<?php echo $x; ?>']=="Not Approved")
                                color='red';
			for(var i=1; i<num; i++){
                            
                            $('td:eq('+i+')', nRow).html(aaData[i]).addClass(color);
				
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
<form  action="requisitions.php" method="post" name="requisitions" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Requisition No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Item</td>
				<td>
				<select name='itemid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$items=new Items();
				$where="  ";
				$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
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
			<tr>
				<td>Quantity</td>
				<td><input type='text' id='quantity' size='20' name='quantity' value='<?php echo $obj->quantity;?>'></td>
			</tr>
			<tr>
				<td>Requisition Date</td>
				<td><strong>From:</strong><input type='text' id='fromrequisitiondate' size='12' name='fromrequisitiondate' readonly class="date_input" value='<?php echo $obj->fromrequisitiondate;?>'/>
							<br/><strong>To:</strong><input type='text' id='torequisitiondate' size='12' name='torequisitiondate' readonly class="date_input" value='<?php echo $obj->torequisitiondate;?>'/></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from proc_requisitions) ";
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
				<td>Created On</td>
				<td><strong>From:</strong><input type='text' id='fromcreatedon' size='12' name='fromcreatedon' readonly class="date_input" value='<?php echo $obj->fromcreatedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='tocreatedon' size='12' name='tocreatedon' readonly class="date_input" value='<?php echo $obj->tocreatedon;?>'/></td>
			</tr>
			<tr>
				<td>Department</td>
				<td>
				<select name='departmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$departments=new Departments();
				$where="  ";
				$fields="inv_departments.id, inv_departments.name, inv_departments.code, inv_departments.remarks, inv_departments.createdby, inv_departments.createdon, inv_departments.lasteditedby, inv_departments.lasteditedon, inv_departments.ipaddress";
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
			<tr>
				<td>Required on</td>
				<td><strong>From:</strong><input type='text' id='fromrequiredon' size='12' name='fromrequiredon' readonly class="date_input" value='<?php echo $obj->fromrequiredon;?>'/>
							<br/><strong>To:</strong><input type='text' id='torequiredon' size='12' name='torequiredon' readonly class="date_input" value='<?php echo $obj->torequiredon;?>'/></td>
			</tr>
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Requisition No</td>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item</td>
			<tr>
				<td><input type='checkbox' name='grrequisitiondate' value='1' <?php if(isset($_POST['grrequisitiondate']) ){echo"checked";}?>>&nbsp;Requisition Date</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='grdepartmentid' value='1' <?php if(isset($_POST['grdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='grrequiredon' value='1' <?php if(isset($_POST['grrequiredon']) ){echo"checked";}?>>&nbsp;Required on</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Requisition No</td>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shcostprice' value='1' <?php if(isset($_POST['shcostprice'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Rate</td>
			<tr>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Total</td>
				<td><input type='checkbox' name='shrequisitiondate' value='1' <?php if(isset($_POST['shrequisitiondate']) ){echo"checked";}?>>&nbsp;Requisition Date</td>
			<tr>
				<td><input type='checkbox' name='shstatus' value='1' <?php if(isset($_POST['shstatus'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Status</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ip Address</td>
			<tr>
				<td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Department</td>
				<td><input type='checkbox' name='shrequiredon' value='1' <?php if(isset($_POST['shrequiredon']) ){echo"checked";}?>>&nbsp;Required on</td>
			<tr>
				<td><input type='checkbox' name='shfile' value='1' <?php if(isset($_POST['shfile']) ){echo"checked";}?>>&nbsp;File</td>
				<td><input type='checkbox' name='shunitofmeasureid' value='1' <?php if(isset($_POST['shunitofmeasureid']) ){echo"checked";}?>>&nbsp;Unit Of Measure</td>
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
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Item </th>
			<?php } ?>
			<?php if($obj->shunitofmeasureid==1  or empty($obj->action)){ ?>
				<th>Unit of Measure </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shcostprice==1  or empty($obj->action)){ ?>
				<th>Costprice </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>Total </th>
			<?php } ?>
			<?php if($obj->shrequisitiondate==1 ){ ?>
				<th>Requisition Date </th>
			<?php } ?>
			<?php if($obj->shstatus==1  or empty($obj->action)){ ?>
				<th>Status </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created by </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created on </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th>Department </th>
			<?php } ?>
			<?php if($obj->shrequiredon==1 ){ ?>
				<th> Require on</th>
			<?php } ?>
			<?php if($obj->shfile==1 ){ ?>
				<th>File</th>
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
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcostprice==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shrequisitiondate==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shstatus==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shrequiredon==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shfile==1 ){ ?>
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
