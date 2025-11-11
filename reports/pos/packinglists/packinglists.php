<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/packinglists/Packinglists_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/crm/customers/Customers_class.php");
require_once("../../../modules/assets/fleets/Fleets_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Packinglists";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8727";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";


if(empty($obj->action)){
	$obj->frompackedon=date('Y-m-d');
	$obj->topackedon=date('Y-m-d');
	
	$obj->grpackingno=1;
	$obj->grcustomerid=1;
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
if(!empty($obj->grdocumentno) or !empty($obj->grorderno) or !empty($obj->grcustomerid) or !empty($obj->grpackedon) or !empty($obj->grfleetid) or !empty($obj->gremployeeid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->gritemid) or !empty($obj->grsizeid) or !empty($obj->grboxno) ){
	$obj->shdocumentno='';
	$obj->shorderno='';
	$obj->shcustomerid='';
	$obj->shpackedon='';
	$obj->shfleetid='';
	$obj->shemployeeid='';
	$obj->shremarks='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shitemid='';
	$obj->shsizeid='';
	$obj->shquantity='';
	$obj->shmemo='';
	$obj->shboxno='';
}else{
  $obj->gritemid=1;
}


	$obj->shquantity=1;
	$obj->shsizeid=1;


if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
	$track++;
}

if(!empty($obj->grorderno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" orderno ";
	$obj->shorderno=1;
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

if(!empty($obj->grpackedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" packedon ";
	$obj->shpackedon=1;
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

if(!empty($obj->gremployeeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employeeid ";
	$obj->shemployeeid=1;
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

if(!empty($obj->gritemid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" itemid ";
	$obj->shitemid=1;
	$track++;
}

if(!empty($obj->grboxno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" boxno ";
	$obj->shboxno=1;
	$track++;
}

if(!empty($obj->grsizeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" sizeid ";
	$obj->shsizeid=1;
	$track++;
}

//processing columns to show
	if(!empty($obj->shdocumentno)  or empty($obj->action)){
		array_push($sColumns, 'documentno');
		array_push($aColumns, "pos_packinglists.documentno");
		$k++;
		}

	if(!empty($obj->shorderno)  or empty($obj->action)){
		array_push($sColumns, 'orderno');
		array_push($aColumns, "pos_packinglists.orderno");
		$k++;
		}

	if(!empty($obj->shcustomerid)  or empty($obj->action)){
		array_push($sColumns, 'customerid');
		array_push($aColumns, "crm_customers.name as customerid");
		$rptjoin.=" left join crm_customers on crm_customers.id=pos_packinglists.customerid ";
		$k++;
		}

	if(!empty($obj->shpackedon)  or empty($obj->action)){
		array_push($sColumns, 'packedon');
		array_push($aColumns, "pos_packinglists.packedon");
		$k++;
		}

	if(!empty($obj->shfleetid)  or empty($obj->action)){
		array_push($sColumns, 'fleetid');
		array_push($aColumns, "assets_fleets.id");
		$rptjoin.=" left join assets_fleets on assets_fleets.id=pos_packinglists.fleetid ";
		$k++;
		}

	if(!empty($obj->shemployeeid)  or empty($obj->action)){
		array_push($sColumns, 'employeeid');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employeeid");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=pos_packinglists.employeeid ";
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "pos_packinglists.remarks");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=pos_packinglists.createdby";
		$k++;
		}
		
		

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "pos_packinglists.createdon");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "pos_packinglists.ipaddress");
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_items.name itemid");
		$k++;
		$join=" left join pos_packinglistdetails on pos_packinglists.id=pos_packinglistdetails.packinglistid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  pos_items on pos_items.id=pos_packinglistdetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
	if(!empty($obj->shboxno)  or empty($obj->action)){
		array_push($sColumns, 'boxno');
		array_push($aColumns, "pos_packinglists.boxno");
		$k++;
		}

// 	if(!empty($obj->shsizeid)  or empty($obj->action)){
// 		array_push($sColumns, 'sizeid');
// 		array_push($aColumns, "pos_packinglistdetails.sizeid");
// 		$k++;
// 		$join=" left join pos_packinglistdetails on pos_packinglists.id=pos_packinglistdetails.packinglistid ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
// 		$join=" left join  on .id=pos_packinglistdetails.sizeid ";
// 		
// 		}

// 	if(!empty($obj->shquantity)  or empty($obj->action)){
// 		array_push($sColumns, 'quantity');
// 		array_push($aColumns, "pos_packinglistdetails.quantity");
// 		$k++;
// 		$join=" left join pos_packinglistdetails on pos_packinglists.id=pos_packinglistdetails.packinglistid ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
// 		$join=" left join  on .id=pos_packinglistdetails.quantity ";
// 		
// 		}

	if(!empty($obj->shmemo) ){
		array_push($sColumns, 'memo');
		array_push($aColumns, "pos_packinglistdetails.memo");
		$k++;
		$join=" left join pos_packinglistdetails on pos_packinglists.id=pos_packinglistdetails.packinglistid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join  on .id=pos_packinglistdetails.memo ";
		
		}


$mnt = ($k+1);
$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_packinglists.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->orderno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_packinglists.orderno='$obj->orderno'";
	$track++;
}

if(!empty($obj->customerid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_packinglists.customerid='$obj->customerid'";
		$join=" left join crm_customers on pos_packinglists.id=crm_customers.packinglistid ";
		
	$track++;
}

if(!empty($obj->frompackedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_packinglists.packedon>='$obj->frompackedon'";
	$track++;
}

if(!empty($obj->topackedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_packinglists.packedon<='$obj->topackedon'";
	$track++;
}

if(!empty($obj->fleetid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" assets_fleets.id='$obj->fleetid' ";
	$join=" left join assets_fleets on assets_fleets.id=assets_fleets.fleetid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join assets_fleets on assets_fleets.id=assets_fleets.fleetid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_packinglists.employeeid='$obj->employeeid'";
		$join=" left join hrm_employees on pos_packinglists.id=hrm_employees.packinglistid ";
		
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_packinglists.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_packinglists.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_packinglists.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" pos_items.id='$obj->itemid' ";
	$join=" left join pos_packinglistdetails on pos_packinglists.id=pos_packinglistdetails.packinglistid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join pos_items on pos_items.id=pos_packinglistdetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->boxno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_packinglists.boxno='$obj->boxno'";
	$track++;
}


if(!empty($obj->sizeid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" pos_sizes.id='$obj->sizeid' ";
	$join=" left join pos_packinglistdetails on pos_packinglistdetails.id=pos_packinglistdetails.packinglistdetailid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join pos_sizes on pos_sizes.id=pos_packinglistdetails.sizeid ";
	
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
<?php
 $sizes=new Sizes();
  $where="  ";
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

  
  $cols="";
  while($rw=mysql_fetch_object($sizes->result)){
     $cols=" case when sum(case when pos_packinglistdetails.sizeid=$rw->id then pos_packinglistdetails.quantity end) is null then '' else sum(case when pos_packinglistdetails.sizeid=$rw->id then pos_packinglistdetails.quantity end) end '$rw->name'";
    array_push($aColumns, $cols);
    array_push($sColumns, $rw->name);
    
    $k++;
  }
$join=" left join pos_packinglistdetails on pos_packinglists.id=pos_packinglistdetails.packinglistid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
if(!empty($obj->shquantity)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(pos_packinglistdetails.quantity) quantity");
		}else{
		array_push($aColumns, "pos_packinglistdetails.quantity");
		}

		$k++;
		
		}
?>

 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_packinglists";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_packinglists",
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
			var total=[];
			//var k=0;
			for(var i=0; i<aaData.length; i++){
			  //var k = aaData[i].length;
			  
			  for(var j=<?php echo $mnt; ?>; j<aaData[i].length; j++){
			    if(aaData[i][j]=='')
			      aaData[i][j]=0;			      
			      
			      if(i==0)
				total[j]=0;
				
				total[j] = parseFloat(total[j])+parseFloat(aaData[i][j]);	//alert(parseFloat(aaData[i][j]));	
			  }
			  
			}
			
			for(var i=<?php echo $mnt; ?>; i<total.length;i++){
			  $('th:eq('+i+')', nRow).html(total[i]);
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
<form  action="packinglists.php" method="post" name="packinglists" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document No</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Order No</td>
				<td><input type='text' id='orderno' size='20' name='orderno' value='<?php echo $obj->orderno;?>'></td>
			</tr>
			<tr>
				<td>Customer</td>
				<td><input type='text' size='20' name='customername' id='customername' value='<?php echo $obj->customername; ?>'>
					<input type="hidden" name='customerid' id='customerid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Packed On</td>
				<td><strong>From:</strong><input type='text' id='frompackedon' size='12' name='frompackedon' readonly class="date_input" value='<?php echo $obj->frompackedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='topackedon' size='12' name='topackedon' readonly class="date_input" value='<?php echo $obj->topackedon;?>'/></td>
			</tr>
			<tr>
				<td>Fleet</td>
				<td>
				<select name='fleetid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$fleets=new Fleets();
				$where="  ";
				$fields="*";
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
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="*";
				$where="where id in(select createdby from pos_packinglists)";
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
			<tr>
				<td>Product</td>
				<td>
				<select name='itemid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$items=new Items();
				$where="  ";
				$fields="*";
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
				<td>Box no</td>
				<td><input type='text' id='boxno' size='20' name='boxno' value='<?php echo $obj->boxno;?>'></td>
			</tr>
			<tr>
				<td>Length</td>
				<td>
				<select name='sizeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$sizes=new Sizes();
				$where="  ";
				$fields="pos_sizes.id, pos_sizes.name, pos_sizes.remarks, pos_sizes.ipaddress, pos_sizes.createdby, pos_sizes.createdon, pos_sizes.lasteditedby, pos_sizes.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($sizes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->sizeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno'])or empty($obj->action) ){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='grorderno' value='1' <?php if(isset($_POST['grorderno']) ){echo"checked";}?>>&nbsp;Order No</td>
			<tr>
				<td><input type='checkbox' name='grcustomerid' value='1' <?php if(isset($_POST['grcustomerid'])or empty($obj->action) ){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='grpackedon' value='1' <?php if(isset($_POST['grpackedon']) ){echo"checked";}?>>&nbsp;Packed On</td>
			<tr>
				<td><input type='checkbox' name='grfleetid' value='1' <?php if(isset($_POST['grfleetid']) ){echo"checked";}?>>&nbsp;Fleet</td>
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) ){echo"checked";}?>>&nbsp;Product</td>
				<td><input type='checkbox' name='grboxno' value='1' <?php if(isset($_POST['grboxno']) ){echo"checked";}?>>&nbsp;Box no</td>
				<td><input type='checkbox' name='grsizeid' value='1' <?php if(isset($_POST['grsizeid']) ){echo"checked";}?>>&nbsp;Length</td>
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
				<td><input type='checkbox' name='shorderno' value='1' <?php if(isset($_POST['shorderno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Order No</td>
			<tr>
				<td><input type='checkbox' name='shcustomerid' value='1' <?php if(isset($_POST['shcustomerid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Customer</td>
				<td><input type='checkbox' name='shpackedon' value='1' <?php if(isset($_POST['shpackedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Packed On</td>
			<tr>
				<td><input type='checkbox' name='shfleetid' value='1' <?php if(isset($_POST['shfleetid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Fleet</td>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Employee</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
			<tr>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Product</td>
				<td><input type='checkbox' name='shboxno' value='1' <?php if(isset($_POST['shboxno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Box no</td>
				<td><input type='checkbox' name='shsizeid' value='1' <?php if(isset($_POST['shsizeid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Length</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shmemo' value='1' <?php if(isset($_POST['shmemo']) ){echo"checked";}?>>&nbsp;Memo</td>
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
				<th>Packing No </th>
			<?php } ?>
			<?php if($obj->shorderno==1  or empty($obj->action)){ ?>
				<th>Order No </th>
			<?php } ?>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>Customer </th>
			<?php } ?>
			<?php if($obj->shpackedon==1  or empty($obj->action)){ ?>
				<th>Date Of Packing </th>
			<?php } ?>
			<?php if($obj->shfleetid==1  or empty($obj->action)){ ?>
				<th>Vehicle </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>Driver </th>
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
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Item </th>
			<?php } ?>
			
			<?php if($obj->shboxno==1  or empty($obj->action)){ ?>
				<th>Box No </th>
			<?php } ?>
			
			<?php if($obj->shmemo==1 ){ ?>
				<th>Memo </th>
			<?php } ?>
			<?php if($obj->shsizeid==1){ 
			      $sizes=new Sizes();
			      $where="  ";
			      $fields="*";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			      while($rw=mysql_fetch_object($sizes->result)){
			      
			?>
				<th><?php echo $rw->name; ?></th>
			<?php }} ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Sub Total</th>
			<?php } ?>
		</tr>
		</tr>
	</thead>
	<tbody>
	<tfoot>
	<tr>
	
	<th>#</th>
			<?php if($obj->shdocumentno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shorderno==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcustomerid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shpackedon==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shfleetid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shboxno==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			
			<?php if($obj->shmemo==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shsizeid==1){ 
			      $sizes=new Sizes();
			      $where="  ";
			      $fields="*";
			      $join="";
			      $having="";
			      $groupby="";
			      $orderby="";
			      $sizes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

			      while($rw=mysql_fetch_object($sizes->result)){
			      
			?>
				<th><?php echo $rw->name; ?></th>
			<?php }} ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
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
