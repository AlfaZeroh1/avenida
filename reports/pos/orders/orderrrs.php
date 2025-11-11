<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/orders/Orders_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/inv/items/Items_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/inv/categorys/Categorys_class.php");
require_once("../../../modules/inv/departments/Departments_class.php");
require_once("../../../modules/sys/branches/Branches_class.php");

if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Orders";
//connect to db
$db=new DB();

$ob = (object)$_GET;
$obj=(object)$_POST;

if(!empty($ob->type))
  $obj->type=$ob->type;

//Authorization.
$auth->roleid="8729";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include"../../../head.php";

if(empty($obj->action)){
	$obj->fromorderedon=date('Y-m-d');
	$obj->toorderedon=date('Y-m-d');
	}



if($obj->shconfirmed==1){
  $obj->grorderno=1;
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
if(!empty($obj->grorderno)  or !empty($obj->grorderedon) or !empty($obj->grcategoryid) or !empty($obj->grdepartmentid)or  !empty($obj->grcreatedby) or !empty($obj->grcreatedon) or !empty($obj->gritemid) ){
	$obj->shorderno='';
	$obj->shorderedon='';
	$obj->shremarks='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shquantity='';
	$obj->shitemid='';
	
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


if(!empty($obj->grcategoryid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" categoryid ";
	$obj->shcategoryid=1;
	$track++;
}

if(!empty($obj->grdepartmentid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" deparmentid ";
	$obj->shdepartmentid=1;
	$track++;
}



if(!empty($obj->grorderedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" orderedon ";
	$obj->shorderedon=1;
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

if(!empty($obj->grshiftid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" shiftid ";
	$obj->shshiftid=1;

	$track++;
}

if(!empty($rptgroup)){
  $obj->shquantity=1;
}

//processing columns to show

	if(!empty($obj->shorderno)  or empty($obj->action)){
		array_push($sColumns, 'orderno');
		array_push($aColumns, "pos_orders.orderno");
		$k++;
	}
		
	if(!empty($obj->shshiftid)  or empty($obj->action)){
		array_push($sColumns, 'shiftid');
		array_push($aColumns, "pos_shifts.name shiftid");
		$join=" left join pos_teams on pos_teams.id=pos_orders.shiftid ";
		
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		
		$join=" left join pos_shifts on pos_shifts.id=pos_teams.shiftid ";
		
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$k++;
	}
		
	  if(!empty($obj->shcategoryid)  or empty($obj->action)){
		array_push($sColumns, 'categoryid');
		array_push($aColumns, "inv_categorys.name as categoryid");
		$k++;
		$join=" left join pos_orderdetails on pos_orders.id=pos_orderdetails.orderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=pos_orderdetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
	  if(!empty($obj->shdepartmentid)  or empty($obj->action)){
		array_push($sColumns, 'departmentid');
		array_push($aColumns, "inv_departments.name as departmentid");
		$k++;
		$join=" left join pos_orderdetails on pos_orders.id=pos_orderdetails.orderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=pos_orderdetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_departments on inv_departments.id=inv_items.departmentid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
	if(!empty($obj->shitemid)   or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name itemid");
		$k++;
		$join=" left join pos_orderdetails on pos_orders.id=pos_orderdetails.orderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join inv_items on inv_items.id=pos_orderdetails.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}


	if(!empty($obj->shorderedon)  or empty($obj->action)){
		array_push($sColumns, 'orderedon');
		array_push($aColumns, "pos_orders.orderedon");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "pos_orders.remarks");
		$k++;
		}

	if(!empty($obj->shconsigneeid)){
		array_push($sColumns, 'consigneeid');
		array_push($aColumns, "pos_orders.consigneeid");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "pos_orders.ipaddress");
		$k++;
		}
	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username createdby");
		$rptjoin.=" left join auth_users on auth_users.id=pos_orders.createdby ";
		$k++;
		
		if(!empty($obj->type)){
		  array_push($sColumns, 'lasteditedby');
		  array_push($aColumns, "auth_userss.username lasteditedby");
		  $rptjoin.=" left join auth_users auth_userss on auth_userss.id=pos_orders.lasteditedby ";
		}
		
		$k++;
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "pos_orders.createdon");
		$k++;
		
		if(!empty($obj->type)){
		  array_push($sColumns, 'lasteditedon');
		  array_push($aColumns, "pos_orders.lasteditedon");
		  $k++;
		}
	}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "pos_orders.ipaddress");
		$k++;
		}




$mnt=$k+1;

$track=1;
if(empty($obj->type))
  $rptwhere=" pos_orders.status!=0 and  pos_orders.status!=3 ";
else
  $rptwhere=" pos_orders.status=3 ";
//processing filters
if(!empty($obj->orderno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_orders.orderno='$obj->orderno'";
	$track++;
}

if(!empty($obj->categoryid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_categorys.id='$obj->categoryid' ";
	$join=" left join pos_orderdetails on pos_orders.id=pos_orderdetails.orderid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=pos_orderdetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}
if(!empty($obj->departmentid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_departments.id='$obj->departmentid' ";
	$join=" left join pos_orderdetails on pos_orders.id=pos_orderdetails.orderid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=pos_orderdetails.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_departments on inv_departments.id=inv_items.departmentid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->fromorderedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_teams.teamedon>='$obj->fromorderedon'";
		
	$join=" left join pos_teams on pos_teams.id=pos_orders.shiftid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}

if(!empty($obj->brancheid2)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_orders.brancheid2='$obj->brancheid2'";
	$track++;
}

if(!empty($obj->toorderedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_teams.teamedon<='$obj->toorderedon'";
		
	$join=" left join pos_teams on pos_teams.id=pos_orders.shiftid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_orders.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_orders.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" pos_orders.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
	$rptwhere.=" inv_items.id='$obj->itemid' ";
	$join=" left join pos_orderdetails on pos_orders.id=pos_orderdetails.orderid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join inv_items on inv_items.id=pos_orderdetails.itemid ";
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
<script type="text/javascript">
$().ready(function() {
//  $("#customername").autocomplete("../../../modules/server/server/search.php?main=crm&module=customers&field=name", {
//  	width: 260,
//  	selectFirst: false
//  });
//  $("#customername").result(function(event, data, formatted) {
//    if (data)
//    {
//      document.getElementById("customername").value=data[0];
//      document.getElementById("customerid").value=data[1];
//    }
//  });
});
</script>
<style media="all" type="text/css">
.confirmed{
  	background-color: green;
    color: white;
}
.danger{
  	background-color: green;
    color: red;
}
</style>
<script type="text/javascript" charset="utf-8">
<?php

$join=" left join pos_orderdetails on pos_orders.id=pos_orderdetails.orderid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}

	
if(!empty($obj->shquantity)   or empty($obj->action) ){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
		    array_push($aColumns, "sum(pos_orderdetails.quantity) as quantity");
		}else{
		array_push($aColumns, "pos_orderdetails.quantity");
		}
		$k++;
		
}
if(!empty($obj->shprices)   or empty($obj->action) ){
		array_push($sColumns, 'prices');
		 array_push($aColumns, "pos_orderdetails.price as prices");
		$k++;
		$join=" left join pos_orderdetails on pos_orders.id=pos_orderdetails.orderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
}
if(!empty($obj->shprice)  or empty($obj->action) ){
		array_push($sColumns, 'price');
		if(!empty($rptgroup)){
		  array_push($aColumns, "sum(pos_orderdetails.quantity*pos_orderdetails.price) as price");
		}else{
		  array_push($aColumns, "pos_orderdetails.quantity*pos_orderdetails.price as price");
		}
		 
		$k++;
		$join=" left join pos_orderdetails on pos_orders.id=pos_orderdetails.orderid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
}


?>

 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="pos_orders";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 $(document).ready(function() {
	;
 	$('#tbl').dataTable( {
		dom: 'lBfrtip',
		"buttons": [
		 'copy', 'csv', 'excel', 'print',{
		    extend: 'pdfHtml5',
		    orientation: 'landscape',
		    pageSize: 'LEGAL'
		}],
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=pos_orders",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				<?php if($obj->shconfirmed==1){?>
				if(i%2==1 && i>2){
				 if(aaData[i-1]<aaData[i])
				  $('td:eq('+i+')', nRow).html(aaData[i]).addClass("danger");
				 else
				  $('td:eq('+i+')', nRow).html(aaData[i]).addClass("confirmed");
				}
				else
				  $('td:eq('+i+')', nRow).html(aaData[i]);
				<?php }else{?>
				 $('td:eq('+i+')', nRow).html(aaData[i]);
				<?php }?>
				
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
			  
			    if(aaData[i][j]=='' || aaData[i][j]==null)
			      aaData[i][j]=0;			      
			      
			      if(i==0)
				total[j]=0;
				//if((aaData[i][1]!='' && aaData[i][2]!='' && aaData[i][3]!='' && aaData[i][4]!='') )
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
<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<a style="color:red;" href="#" onclick="Clickheretoprint();">Print</a>
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
<form  action="orders.php" method="post" name="orders" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%"<?php echo $str; ?>>
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Order No<input type="hidden" name="type" value="<?php echo $obj->type; ?>"/></td>
				<td><input type='text' id='orderno' size='20' name='orderno' value='<?php echo $obj->orderno;?>'></td>
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
				<td>Product Department</td>
				<td>
				<select name='departmentid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$department=new Departments();
				$where="  ";
				$fields="*";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$department->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($department->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->departmentid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			
			<tr>
			  <td>Location: </td>
			  <td><select name="brancheid2" id="brancheid2">
      <option value="">Select...</option>
    <?php
	  $branches = new Branches();
	  $fields=" * ";
	  $join="";
	  $groupby="";
	  $having="";
	  $where="" ;
	  $branches->retrieve($fields, $join, $where, $having, $groupby, $orderby);
	  while($rw=mysql_fetch_object($branches->result)){
	  ?>
	    <option value="<?php echo $rw->id; ?>" <?php if($rw->id==$obj->brancheid2)echo "selected";?>><?php echo $rw->name; ?></option>
	  <?php
	  }
	  ?>
      </select></td>
			</tr>
			
			<tr>
				<td>Ordered On</td>
				<td><strong>From:</strong><input type='text' id='fromorderedon' size='20' name='fromorderedon' readonly class="date_input" value='<?php echo $obj->fromorderedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toorderedon' size='20' name='toorderedon' readonly class="date_input" value='<?php echo $obj->toorderedon;?>'/></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from pos_orders) ";
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grorderno' value='1' <?php if(isset($_POST['grorderno']) ){echo"checked";}?>>&nbsp;Order No</td>
				
			<tr>
				<td><input type='checkbox' name='grorderedon' value='1' <?php if(isset($_POST['grorderedon']) ){echo"checked";}?>>&nbsp;Ordered On</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created By</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid'])  ){echo"checked";}?>>&nbsp;Product</td>
			<tr>
				<td><input type='checkbox' name='shconfirmed' value='1' <?php if(isset($_POST['shconfirmed']) ){echo"checked";}?>>&nbsp;Compare to Confirmed Orders</td>
				<td><input type='checkbox' name='shpacked' value='1' <?php if(isset($_POST['shpacked']) ){echo"checked";}?>>&nbsp;Compare to Packed</td>
			<tr>	
			       <td><input type='checkbox' name='grcategoryid' value='1' <?php if(isset($_POST['grcategoryid']) ){echo"checked";}?>>&nbsp;Category</td>
			       <td><input type='checkbox' name='grdepartmentid' value='1' <?php if(isset($_POST['grdepartmentid']) ){echo"checked";}?>>&nbsp;Department</td>
			       
			<tr>	
			       <td><input type='checkbox' name='grshiftid' value='1' <?php if(isset($_POST['grshiftid']) ){echo"checked";}?>>&nbsp;Shift</td>
			       <td>&nbsp;</td>
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
				<td><input type='checkbox' name='shorderno' value='1' <?php if(isset($_POST['shorderno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Order No</td>
				
			<tr>
				<td><input type='checkbox' name='shorderedon' value='1' <?php if(isset($_POST['shorderedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Ordered On</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])or empty($obj->action) ){echo"checked";}?>>&nbsp;Quantity</td>
			<tr>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])or empty($obj->action) ){echo"checked";}?>>&nbsp;Product</td>
				<td><input type='checkbox' name='shprice' value='1' <?php if(isset($_POST['shprice']) or empty($obj->action) ){echo"checked";}?>>&nbsp;Price</td>
			<tr>
			    <td><input type='checkbox' name='shprices' value='1' <?php if(isset($_POST['shprices'])or empty($obj->action) ) {echo"checked";}?>>&nbsp;Unit Price</td>
			    <td><input type='checkbox' name='shcategoryid' value='1' <?php if(isset($_POST['shcategoryid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Category</td>
			  <tr>
			  <td><input type='checkbox' name='shdepartmentid' value='1' <?php if(isset($_POST['shdepartmentid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Department</td>
				
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
<table style="clear:both;"  class="table" id="tbl" width="98%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
		      
			<th<?php echo $str; ?>>#</th>
			<?php if($obj->shorderno==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>Order No </th>
			<?php } ?>
			<?php if($obj->shshiftid==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>Shift
			<?php }if($obj->shcategoryid==1  or empty($obj->action)){ ?>
				<th>Category </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th>Department </th>
			<?php } ?>
			<?php if($obj->shitemid==1 or empty($obj->action) ){ ?>
				<th<?php echo $str; ?>> Product</th>
			<?php } ?>
			
			<?php if($obj->shorderedon==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>Date Ordered </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th<?php echo $str; ?>>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>Created By </th>
				<?php if(!empty($obj->type)){?>
				  <th<?php echo $str; ?>>Edited By </th>
				<?php } ?>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>> Created On</th>
				<?php if(!empty($obj->type)){?>
				  <th<?php echo $str; ?>>Edited On </th>
				<?php } ?>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th<?php echo $str; ?>>IP Address </th>
			<?php } ?>
			
			
			
			
			
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th<?php echo $str1; ?>>Qty</th>
				<?php if($obj->shconfirmed==1){ ?>
				  <th>Confirmed</th>
				  <?php if($obj->shpacked==1){ ?>
				    <th>Packed</th>
				  <?php } ?>
			<?php
			}
			?>
			<?php } ?>
			<?php if($obj->shprices==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>Unit Price </th>
			<?php } ?>
			<?php if($obj->shprice==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>Total </th>
			<?php } ?>
		</tr>
		
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
	  <tr>
		      <?php
		      $str="";
		      $str1="";
		      ?>
			<th<?php echo $str; ?>>#</th>
			<?php if($obj->shorderno==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shshiftid==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcategoryid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdepartmentid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shitemid==1 or empty($obj->action) ){ ?>
				<th<?php echo $str; ?>> &nbsp;</th>
			<?php } ?>
			
			<?php if($obj->shorderedon==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th<?php echo $str; ?>>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>&nbsp; </th>
				<?php if(!empty($obj->type)){?>
				<th<?php echo $str; ?>>&nbsp;</th>
				<?php } ?>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>> &nbsp;</th>
				<?php if(!empty($obj->type)){?>
				<th<?php echo $str; ?>>&nbsp;</th>
				<?php } ?>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th<?php echo $str; ?>>&nbsp; </th>
			<?php } ?>
			
			
			
			
			
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th<?php echo $str1; ?>>&nbsp;</th>
				<?php if($obj->shconfirmed==1){ ?>
				<th>&nbsp;</th>
				<?php if($obj->shpacked==1){ ?>
				    <th>&nbsp;</th>
				  <?php } ?>
				<?php }?>
			<?php } ?>
			<?php if($obj->shprices==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shprice==1  or empty($obj->action)){ ?>
				<th<?php echo $str; ?>>&nbsp; </th>
			<?php } ?>
			
		</tr>
		
	</tfoot>
</div>
</div>
</div>
</div>
</div>
