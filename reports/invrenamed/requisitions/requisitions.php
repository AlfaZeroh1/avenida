<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/requisitions/Requisitions_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/hrm/departments/Departments_class.php");
require_once("../../../modules/inv/categorys/Categorys_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/prod/blocks/Blocks_class.php");
require_once("../../../modules/prod/sections/Sections_class.php");
require_once("../../../modules/prod/greenhouses/Greenhouses_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Requisitions";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9433";//Report View
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
if(!empty($obj->grdocumentno) or !empty($obj->grdepartmentid) or !empty($obj->grcategoryid) or  !empty($obj->gremployeeid) or !empty($obj->grrequisitiondate) or !empty($obj->gritemid) or !empty($obj->grblockid) or !empty($obj->grsectionid) or !empty($obj->grgreenhouseid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shdocumentno='';
	$obj->shdepartmentid='';
	$obj->shcategoryid='';
	$obj->shemployeeid='';
	$obj->shrequisitiondate='';
	$obj->shremarks='';
	$obj->shstatus='';
	$obj->shapprovedby='';
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shaquantity='';
	$obj->shpurpose='';
	$obj->shmemo='';
	$obj->shblockid='';
	$obj->shsectionid='';
	$obj->shgreenhouseid='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
}

	$obj->shitemid=1;
	$obj->shquantity=1;
	
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

if(!empty($obj->grrequisitiondate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" requisitiondate ";
	$obj->shrequisitiondate=1;
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
		array_push($aColumns, "inv_requisitions.documentno");
		$k++;
		}

	if(!empty($obj->shdepartmentid)  or empty($obj->action)){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "hrm_departments.name as departmentid");
		$rptjoin.=" left join hrm_departments on hrm_departments.id=inv_requisitions.departmentid ";
		$k++;
		}
		
       if(!empty($obj->shcategoryid)  or empty($obj->action)){
		array_push($sColumns, 'categoryid');
		array_push($aColumns, "inv_categorys.name as categoryid");
		$k++;
		$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=inv_requisitiondetails.itemid ";
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
		$rptjoin.=" left join hrm_employees on hrm_employees.id=inv_requisitions.employeeid ";
		$k++;
		}

	if(!empty($obj->shrequisitiondate)  or empty($obj->action)){
		array_push($sColumns, 'requisitiondate');
		array_push($aColumns, "inv_requisitions.requisitiondate");
		$k++;
		}

	if(!empty($obj->shremarks)  or empty($obj->action)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "inv_requisitions.remarks");
		$k++;
		}

	if(!empty($obj->shstatus)  or empty($obj->action)){
		array_push($sColumns, 'status');
		array_push($aColumns, "inv_requisitions.status");
		$k++;
		}

	if(!empty($obj->shapprovedby)  or empty($obj->action)){
		array_push($sColumns, 'approvedby');
		array_push($aColumns, "inv_requisitions.approvedby");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name as itemid");
		$k++;
		$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=inv_requisitiondetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "inv_requisitiondetails.quantity");
		$k++;
		$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shaquantity)  or empty($obj->action)){
		array_push($sColumns, 'aquantity');
		array_push($aColumns, "inv_requisitiondetails.aquantity");
		$k++;
		$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shpurpose)  or empty($obj->action)){
		array_push($sColumns, 'purpose');
		array_push($aColumns, "inv_requisitiondetails.purpose");
		$k++;
		$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shmemo)  or empty($obj->action)){
		array_push($sColumns, 'memo');
		array_push($aColumns, "inv_requisitiondetails.memo");
		$k++;
		$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shblockid)  or empty($obj->action)){
		array_push($sColumns, 'blockid');
		array_push($aColumns, "inv_requisitiondetails.blockid");
		$k++;
		$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		}

	if(!empty($obj->shsectionid)  or empty($obj->action)){
		array_push($sColumns, 'sectionid');
		array_push($aColumns, "inv_requisitiondetails.sectionid");
		$k++;
		$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

	if(!empty($obj->shgreenhouseid)  or empty($obj->action)){
		array_push($sColumns, 'greenhouseid');
		array_push($aColumns, "inv_requisitiondetails.greenhouseid");
		$k++;
		$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
        if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=inv_requisitions.createdby ";
		$k++;
		}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "inv_requisitions.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_requisitions.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_requisitions.departmentid='$obj->departmentid'";
		
	$track++;
}
if(!empty($obj->categoryid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_categorys.id='$obj->categoryid' ";
	$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=inv_requisitiondetails.itemid ";
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
		$rptwhere.=" inv_requisitions.employeeid='$obj->employeeid'";
		
	$track++;
}

if(!empty($obj->fromrequisitiondate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_requisitions.requisitiondate>='$obj->fromrequisitiondate'";
	$track++;
}

if(!empty($obj->torequisitiondate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_requisitions.requisitiondate<='$obj->torequisitiondate'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.id='$obj->itemid' ";
	$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=inv_requisitiondetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->blockid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_blocks.id='$obj->blockid' ";
	$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_blocks on prod_blocks.id=inv_requisitiondetails.blockid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->sectionid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_sections.id='$obj->sectionid' ";
	$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_sections on prod_sections.id=inv_requisitiondetails.sectionid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->greenhouseid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" prod_greenhouses.id='$obj->greenhouseid' ";
	$join=" left join inv_requisitiondetails on inv_requisitions.id=inv_requisitiondetails.requisitionid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_greenhouses on prod_greenhouses.id=inv_requisitiondetails.greenhouseid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_requisitions.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_requisitions.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_requisitions.createdon<='$obj->tocreatedon'";
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

});
</script>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="inv_requisitions";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=inv_requisitions",
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
<form  action="requisitions.php" method="post" name="requisitions" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='6' name='documentno' value='<?php echo $obj->documentno;?>'></td>
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
				<td>Category</td>
				<td>
				<select name='categoryid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$categorys=new Categorys();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($categorys->result)){
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
				<td>Requisition date</td>
				<td><strong>From:</strong><input type='text' id='fromrequisitiondate' size='12' name='fromrequisitiondate' readonly class="date_input" value='<?php echo $obj->fromrequisitiondate;?>'/>
							<br/><strong>To:</strong><input type='text' id='torequisitiondate' size='12' name='torequisitiondate' readonly class="date_input" value='<?php echo $obj->torequisitiondate;?>'/></td>
			</tr>
			<tr>
				<td>Item Name</td>
				<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
					<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
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
			</tr>
			<tr>
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
			</tr>
			<tr>
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
			</tr>
			<tr>
				<td>Created by</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from inv_requisitions) ";
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
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='grdepartmentid' value='1' <?php if(isset($_POST['grdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='grrequisitiondate' value='1' <?php if(isset($_POST['grrequisitiondate']) ){echo"checked";}?>>&nbsp;Requisition date</td>
			<tr>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Item Name</td>
				<td><input type='checkbox' name='grblockid' value='1' <?php if(isset($_POST['grblockid']) ){echo"checked";}?>>&nbsp;Block</td>
			<tr>
				<td><input type='checkbox' name='grsectionid' value='1' <?php if(isset($_POST['grsectionid']) ){echo"checked";}?>>&nbsp;Section</td>
				<td><input type='checkbox' name='grgreenhouseid' value='1' <?php if(isset($_POST['grgreenhouseid']) ){echo"checked";}?>>&nbsp;Green house</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Department</td>
			<tr>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shrequisitiondate' value='1' <?php if(isset($_POST['shrequisitiondate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Requisition date</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shstatus' value='1' <?php if(isset($_POST['shstatus'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Status</td>
			<tr>
				<td><input type='checkbox' name='shapprovedby' value='1' <?php if(isset($_POST['shapprovedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Approvedby</td>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Item Name</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shaquantity' value='1' <?php if(isset($_POST['shaquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Confirmed Quantity</td>
			<tr>
				<td><input type='checkbox' name='shpurpose' value='1' <?php if(isset($_POST['shpurpose'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Purpose</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Memo</td>
			<tr>
				<td><input type='checkbox' name='shblockid' value='1' <?php if(isset($_POST['shblockid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Block</td>
				<td><input type='checkbox' name='shsectionid' value='1' <?php if(isset($_POST['shsectionid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Section</td>
			<tr>
				<td><input type='checkbox' name='shgreenhouseid' value='1' <?php if(isset($_POST['shgreenhouseid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Green house</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created on</td>
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
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>Requisition No </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th>Department </th>
			<?php } ?>
			<?php if($obj->shcategoryid==1  or empty($obj->action)){ ?>
				<th>Category </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Requested By </th>
			<?php } ?>
			<?php if($obj->shrequisitiondate==1  or empty($obj->action)){ ?>
				<th>Requisition Date </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shstatus==1  or empty($obj->action)){ ?>
				<th>Statu </th>
			<?php } ?>
			<?php if($obj->shapprovedby==1  or empty($obj->action)){ ?>
				<th>Approved By </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Item </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Approved Quantity </th>
			<?php } ?>
			<?php if($obj->shaquantity==1  or empty($obj->action)){ ?>
				<th>quantity </th>
			<?php } ?>
			<?php if($obj->shpurpose==1  or empty($obj->action)){ ?>
				<th>Purpose </th>
			<?php } ?>
			<?php if($obj->shmemo==1  or empty($obj->action)){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shblockid==1  or empty($obj->action)){ ?>
				<th>Block </th>
			<?php } ?>
			<?php if($obj->shsectionid==1  or empty($obj->action)){ ?>
				<th>Section </th>
			<?php } ?>
			<?php if($obj->shgreenhouseid==1  or empty($obj->action)){ ?>
				<th>Green House </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created by </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On </th>
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
