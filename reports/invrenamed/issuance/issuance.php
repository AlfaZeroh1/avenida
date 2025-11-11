<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/issuance/Issuance_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/hrm/departments/Departments_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/prod/blocks/Blocks_class.php");
require_once("../../../modules/prod/sections/Sections_class.php");
require_once("../../../modules/prod/greenhouses/Greenhouses_class.php");
require_once("../../../modules/assets/fleets/Fleets_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/inv/categorys/Categorys_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Issuance";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8814";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
    $obj->fromissuedon=date('y-m-d');
    $obj->toissuedon=date('y-m-d');
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
if(!empty($obj->gritemid) or !empty($obj->grdepartmentid) or !empty($obj->grcategoryid) or !empty($obj->gremployeeid) or !empty($obj->grissuedon) or !empty($obj->grdocumentno) or !empty($obj->grcreatedon) or !empty($obj->grcreatedby) or !empty($obj->grrequisitionno) or !empty($obj->grreceived) or !empty($obj->grreceivedon) or !empty($obj->grblockid) or !empty($obj->grsectionid) or !empty($obj->grgreenhouseid) or !empty($obj->grfleetid) ){
	$obj->shitemid='';
	$obj->shdepartmentid='';
	$obj->shcategoryid='';
	$obj->shemployeeid='';
	$obj->shquantity='';
	$obj->shissuedon='';
	$obj->shdocumentno='';
	$obj->shremarks='';
	$obj->shmemo='';
	$obj->shcreatedon='';
	$obj->shcreatedby='';
	$obj->shipaddress='';
	$obj->shrequisitionno='';
	$obj->shreceived='';
	$obj->shreceivedon='';
	$obj->shpurpose='';
	$obj->shblockid='';
	$obj->shsectionid='';
	$obj->shgreenhouseid='';
	$obj->shfleetid='';
}


	$obj->shquantity=1;
	$obj->shtotal=1;


if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
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

if(!empty($obj->grcategoryid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" categoryid ";
	$obj->shcategoryid=1;
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

if(!empty($obj->grissuedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" issuedon ";
	$obj->shissuedon=1;
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

if(!empty($obj->grrequisitionno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" requisitionno ";
	$obj->shrequisitionno=1;
	$track++;
}

if(!empty($obj->grreceived)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" received ";
	$obj->shreceived=1;
	$track++;
}

if(!empty($obj->grreceivedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" receivedon ";
	$obj->shreceivedon=1;
	$track++;
}

if(!empty($obj->grblockid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" blockid ";
	$obj->shblockid=1;
	$track++;
}

if(!empty($obj->grsectionid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" sectionid ";
	$obj->shsectionid=1;
	$track++;
}

if(!empty($obj->grgreenhouseid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" greenhouseid ";
	$obj->shgreenhouseid=1;
	$track++;
}

if(!empty($obj->grfleetid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" fleetid ";
	$obj->shfleetid=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name as itemid");
		$k++;
		$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=inv_issuancedetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shdepartmentid)  or empty($obj->action)){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "hrm_departments.name as departmentid");
		$rptjoin.=" left join hrm_departments on hrm_departments.id=inv_issuance.departmentid ";
		$k++;
		}
		
            if(!empty($obj->shcategoryid)  or empty($obj->action)){
		array_push($sColumns, 'categoryid');
		array_push($aColumns, "inv_categorys.name as categoryid");
		$k++;
		$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=inv_issuancedetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=inv_issuance.employeeid ";
		$k++;
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		if(empty($rptgroup))
		  array_push($aColumns, "inv_issuancedetails.quantity");
		else
		  array_push($aColumns, "sum(inv_issuancedetails.quantity) quantity");
		  
		  
		$k++;
		$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		
		}
		
	if(!empty($obj->shunitofmeasureid)  or empty($obj->action)){
		array_push($sColumns, 'unitofmeasureid');
		
		array_push($aColumns, "inv_unitofmeasures.name unitofmeasureid");
		
		$k++;
		$join=" left join inv_items on inv_items.id=inv_issuancedetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	
		$join=" left join inv_unitofmeasures on inv_items.unitofmeasureid=inv_unitofmeasures.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}
		
	if(!empty($obj->shtotal)  or empty($obj->action)){
		array_push($sColumns, 'total');
		if(empty($rptgroup))
		  array_push($aColumns, "inv_issuancedetails.total");
		else
		  array_push($aColumns, "sum(inv_issuancedetails.total) total");
		$k++;
		$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	
		$mnt=$k;
		}

	if(!empty($obj->shissuedon)  or empty($obj->action)){
		array_push($sColumns, 'issuedon');
		array_push($aColumns, "inv_issuance.issuedon");
		$k++;
		}

	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "inv_issuance.documentno");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "inv_issuance.remarks");
		$k++;
		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "inv_issuance.memo");
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "inv_issuance.createdon");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=inv_issuance.createdby ";
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "inv_issuance.ipaddress");
		$k++;
		}

	if(!empty($obj->shrequisitionno)  or empty($obj->action)){
		array_push($sColumns, 'requisitionno');
		array_push($aColumns, "inv_issuance.requisitionno");
		$k++;
		}

	if(!empty($obj->shreceived)  or empty($obj->action)){
		array_push($sColumns, 'received');
		array_push($aColumns, "inv_issuance.received");
		$k++;
		}

	if(!empty($obj->shreceivedon)  or empty($obj->action)){
		array_push($sColumns, 'receivedon');
		array_push($aColumns, "inv_issuance.receivedon");
		$k++;
		
		
		}

	if(!empty($obj->shpurpose)  or empty($obj->action)){
		array_push($sColumns, 'purpose');
		array_push($aColumns, "inv_issuancedetails.purpose");
		$k++;
		$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		
		}

	if(!empty($obj->shblockid)  or empty($obj->action)){
		array_push($sColumns, 'blockid');
		array_push($aColumns, "prod_blocks.name blockid");
		$k++;
		
		$join=" left join prod_blocks on prod_blocks.id=inv_issuancedetails.blockid ";
		
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
		
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		
		}

	if(!empty($obj->shsectionid) ){
		array_push($sColumns, 'sectionid');
		array_push($aColumns, "prod_sections.name sectionid");
		$k++;
		
		$join=" left join prod_sections on prod_sections.id=inv_issuancedetails.sectionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		
		}

	if(!empty($obj->shgreenhouseid) ){
		array_push($sColumns, 'greenhouseid');
		array_push($aColumns, "prod_greenhouses.name greenhouseid");
		$k++;
		
		$join=" left join prod_greenhouses on prod_greenhouses.id=inv_issuancedetails.greenhouseid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		
		}

	if(!empty($obj->shfleetid) ){
		array_push($sColumns, 'fleetid');
		array_push($aColumns, "assets_fleets.assetid fleetid");
		$k++;
		
		$join=" left join assets_fleets on assets_fleets.id=inv_issuancedetails.fleetid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		
		}



$track=0;

//processing filters
if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.id='$obj->itemid' ";
	$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=inv_issuancedetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.departmentid='$obj->departmentid'";
		
	$track++;
}

if(!empty($obj->categoryid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_categorys.id='$obj->categoryid' ";
	$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=inv_issuancedetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.employeeid='$obj->employeeid'";
		
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_issuancedetails.quantity='$obj->quantity' ";
	$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}



if(!empty($obj->itemdepartmentid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.departmentid='$obj->itemdepartmentid' ";
	$join=" left join inv_issuancedetails on inv_issuance.id=inv_issuancedetails.issuanceid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$join=" left join inv_items on inv_items.id=inv_issuancedetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}


if(!empty($obj->fromissuedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.issuedon>='$obj->fromissuedon'";
	$track++;
}

if(!empty($obj->toissuedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.issuedon<='$obj->toissuedon'";
	$track++;
}

if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->requisitionno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.requisitionno='$obj->requisitionno'";
	$track++;
}

if(!empty($obj->received)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.received='$obj->received'";
	$track++;
}

if(!empty($obj->fromreceivedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.receivedon>='$obj->fromreceivedon'";
	$track++;
}

if(!empty($obj->toreceivedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_issuance.receivedon<='$obj->toreceivedon'";
	$track++;
}

if(!empty($obj->blockid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_blocks.id='$obj->blockid' ";
	$join=" left join inv_issuancedetails on inv_issuancedetails.id=inv_issuancedetails.issuancedetailid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_blocks on prod_blocks.id=inv_issuancedetails.blockid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
	
	$track++;
}

if(!empty($obj->sectionid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_sections.id='$obj->sectionid' ";
	$join=" left join inv_issuancedetails on inv_issuancedetails.id=inv_issuancedetails.issuancedetailid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_sections on prod_sections.id=inv_issuancedetails.sectionid ";
	
	$track++;
}

if(!empty($obj->greenhouseid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_greenhouses.id='$obj->greenhouseid' ";
	$join=" left join inv_issuancedetails on inv_issuancedetails.id=inv_issuancedetails.issuancedetailid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_greenhouses on prod_greenhouses.id=inv_issuancedetails.greenhouseid ";
	
	$track++;
}

if(!empty($obj->fleetid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" assets_fleets.id='$obj->fleetid' ";
	$join=" left join inv_issuancedetails on inv_issuancedetails.id=inv_issuancedetails.issuancedetailid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join assets_fleets on assets_fleets.id=inv_issuancedetails.fleetid ";
	
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
  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=name",
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
	}
  });

  $("#employeename").autocomplete({
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
 <?php $_SESSION['sTable']="inv_issuance";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
$(document).ready(function() {
// 	 TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
	 
	 
	
				
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=inv_issuance",
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
<form  action="issuance.php" method="post" name="issuance" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Item</td>
				<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Department</td>
				<td>
				<select name='departmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$departments=new Departments();
				$where="  ";
				$fields="hrm_departments.id, hrm_departments.name, hrm_departments.code, hrm_departments.leavemembers, hrm_departments.description, hrm_departments.createdby, hrm_departments.createdon, hrm_departments.lasteditedby, hrm_departments.lasteditedon, hrm_departments.ipaddress";
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
				<td>Product Department</td>
				<td>
				<select name='itemdepartmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$rs=mysql_query("select * from inv_departments");

				while($rw=mysql_fetch_object($rs)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->itemdepartmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			
			<tr>
				<td>Product Category</td>
				<td>
				<select name='categoryid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$category=new Categorys();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$category->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($category->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->categoryid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><input type='text' id='quantity' size='20' name='quantity' value='<?php echo $obj->quantity;?>'></td>
			</tr>
			<tr>
				<td>Issued On	</td>
				<td><strong>From:</strong><input type='text' id='fromissuedon' size='12' name='fromissuedon' readonly class="date_input" value='<?php echo $obj->fromissuedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toissuedon' size='12' name='toissuedon' readonly class="date_input" value='<?php echo $obj->toissuedon;?>'/></td>
			</tr>
			<tr>
				<td>Issue No	</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
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
				$where=" where auth_users.id in(select createdby from inv_issuance) ";
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
				<td>Requisition no</td>
				<td><input type='text' id='requisitionno' size='20' name='requisitionno' value='<?php echo $obj->requisitionno;?>'></td>
			</tr>
			<tr>
				<td>Received</td>
			</tr>
			<tr>
				<td>Received on</td>
				<td><strong>From:</strong><input type='text' id='fromreceivedon' size='12' name='fromreceivedon' readonly class="date_input" value='<?php echo $obj->fromreceivedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toreceivedon' size='12' name='toreceivedon' readonly class="date_input" value='<?php echo $obj->toreceivedon;?>'/></td>
			</tr>
			<!--<tr>
				<td>Block</td>
				<td>
				<select name='blockid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$blocks=new Blocks();
				$where="  ";
				$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($blocks->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->blockid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>-->
			<!--<tr>
				<td>Section</td>
				<td>
				<select name='sectionid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$sections=new Sections();
				$where="  ";
				$fields="prod_sections.id, prod_sections.name, prod_sections.blockid, prod_sections.employeeid, prod_sections.remarks, prod_sections.ipaddress, prod_sections.createdby, prod_sections.createdon, prod_sections.lasteditedby, prod_sections.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($sections->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->sectionid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>-->
			<!--<tr>
				<td>Green house</td>
				<td>
				<select name='greenhouseid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$greenhouses=new Greenhouses();
				$where="  ";
				$fields="prod_greenhouses.id, prod_greenhouses.name, prod_greenhouses.sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($greenhouses->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->greenhouseid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>-->
			<!--<tr>
				<td>Fleet</td>
				<td>
				<select name='fleetid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$fleets=new Fleets();
				$where="  ";
				$fields="assets_fleets.id, assets_fleets.assetid, assets_fleets.fleetmodelid, assets_fleets.year, assets_fleets.fleetcolorid, assets_fleets.vin, assets_fleets.fleettypeid, assets_fleets.plateno, assets_fleets.engine, assets_fleets.fleetfueltypeid, assets_fleets.fleetodometertypeid, assets_fleets.mileage, assets_fleets.lastservicemileage, assets_fleets.employeeid, assets_fleets.departmentid, assets_fleets.ipaddress, assets_fleets.createdby, assets_fleets.createdon, assets_fleets.lasteditedby, assets_fleets.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$fleets->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($fleets->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->fleetid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>-->
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='grdepartmentid' value='1' <?php if(isset($_POST['grdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='grissuedon' value='1' <?php if(isset($_POST['grissuedon']) ){echo"checked";}?>>&nbsp;Issued On	</td>
			<tr>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Issued On	</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Issued By</td>
				<td><input type='checkbox' name='grrequisitionno' value='1' <?php if(isset($_POST['grrequisitionno']) ){echo"checked";}?>>&nbsp;Requisition no</td>
			<tr>
				<td><input type='checkbox' name='grreceived' value='1' <?php if(isset($_POST['grreceived']) ){echo"checked";}?>>&nbsp;Received</td>
				<td><input type='checkbox' name='grreceivedon' value='1' <?php if(isset($_POST['grreceivedon']) ){echo"checked";}?>>&nbsp;Received on</td>
			<tr>
				<td><input type='checkbox' name='grblockid' value='1' <?php if(isset($_POST['grblockid']) ){echo"checked";}?>>&nbsp;Block</td>
				<td><input type='checkbox' name='grsectionid' value='1' <?php if(isset($_POST['grsectionid']) ){echo"checked";}?>>&nbsp;Section</td>
			<tr>
				<td><input type='checkbox' name='grgreenhouseid' value='1' <?php if(isset($_POST['grgreenhouseid']) ){echo"checked";}?>>&nbsp;Green house</td>
				<td><input type='checkbox' name='grfleetid' value='1' <?php if(isset($_POST['grfleetid']) ){echo"checked";}?>>&nbsp;Fleet</td>
                        <tr>
                                 <td><input type='checkbox' name='grcategoryid' value='1' <?php if(isset($_POST['grcategoryid']) ){echo"checked";}?>>&nbsp;Category</td>
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
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item</td>
				<td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shunitofmeasureid' value='1' <?php if(isset($_POST['shunitofmeasureid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;UoM</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shtotal' value='1' <?php if(isset($_POST['shtotal'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shissuedon' value='1' <?php if(isset($_POST['shissuedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Issued On	</td>
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Issued On	</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Issued By</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;IP Address</td>
				<td><input type='checkbox' name='shrequisitionno' value='1' <?php if(isset($_POST['shrequisitionno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Requisition no</td>
			<tr>
				<td><input type='checkbox' name='shreceived' value='1' <?php if(isset($_POST['shreceived'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Received</td>
				<td><input type='checkbox' name='shreceivedon' value='1' <?php if(isset($_POST['shreceivedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Received on</td>
			<tr>
				<td><input type='checkbox' name='shpurpose' value='1' <?php if(isset($_POST['shpurpose'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Purpose</td>
				<td><input type='checkbox' name='shblockid' value='1' <?php if(isset($_POST['shblockid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Block</td>
			<tr>
				<td><input type='checkbox' name='shsectionid' value='1' <?php if(isset($_POST['shsectionid']) ){echo"checked";}?>>&nbsp;Section</td>
				<td><input type='checkbox' name='shgreenhouseid' value='1' <?php if(isset($_POST['shgreenhouseid']) ){echo"checked";}?>>&nbsp;Green house</td>
			<tr>
				<td><input type='checkbox' name='shfleetid' value='1' <?php if(isset($_POST['shfleetid']) ){echo"checked";}?>>&nbsp;Fleet</td>
				<td><input type='checkbox' name='shcategoryid' value='1' <?php if(isset($_POST['shcategoryid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Category</td>
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
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Item </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th>Department </th>
			<?php } ?>
			<?php if($obj->shcategoryid==1  or empty($obj->action)){ ?>
				<th>Category </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th> Quantity</th>
			<?php } ?>
			
			<?php if($obj->shunitofmeasureid==1  or empty($obj->action)){ ?>
				<th> UoM</th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th> Amount</th>
			<?php } ?>
			<?php if($obj->shissuedon==1  or empty($obj->action)){ ?>
				<th>Issued on </th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Document No </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created By </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>Ip address </th>
			<?php } ?>
			<?php if($obj->shrequisitionno==1  or empty($obj->action)){ ?>
				<th>RequisitionNo </th>
			<?php } ?>
			<?php if($obj->shreceived==1  or empty($obj->action)){ ?>
				<th>Recived </th>
			<?php } ?>
			<?php if($obj->shreceivedon==1  or empty($obj->action)){ ?>
				<th>Recieved on </th>
			<?php } ?>
			<?php if($obj->shpurpose==1  or empty($obj->action)){ ?>
				<th>Purpose </th>
			<?php } ?>
			<?php if($obj->shblockid==1  or empty($obj->action)){ ?>
				<th> Block</th>
			<?php } ?>
			<?php if($obj->shsectionid==1 ){ ?>
				<th>Section </th>
			<?php } ?>
			<?php if($obj->shgreenhouseid==1 ){ ?>
				<th>Green House </th>
			<?php } ?>
			<?php if($obj->shfleetid==1 ){ ?>
				<th>Fleet </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	
	</tbody>
	
	<tfoot>
	<tr>
			<th>#</th>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			
			<?php if($obj->shunitofmeasureid==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shtotal==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shissuedon==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shmemo==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shrequisitionno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shreceived==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shreceivedon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shpurpose==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shblockid==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shsectionid==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shgreenhouseid==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shfleetid==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
		</tr>
	</tfoot>
</div>
</div>
</div>
</div>
</div>
