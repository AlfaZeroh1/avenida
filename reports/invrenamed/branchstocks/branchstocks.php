<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/inv/branchstocks/Branchstocks_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/sys/branches/Branches_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Branchstocks";
//connect to db
$db=new DB();

$obj=(object)$_POST;

if(empty($obj->action)){
  $obj->brancheid=$_SESSION['brancheid'];
}

//Authorization.
$auth->roleid="9497";//Report View
$auth->levelid=$_SESSION['level'];

//auth($auth);
include "../../../head.php";

//$rptwhere=" inv_branchstocks.status='Available' ";
$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$aColumns=array();
$sColumns=array();
//Processing Groupings
$rptgroup='';
$track=0;
if(!empty($obj->grbrancheid) or !empty($obj->gritemid) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shbrancheid='';
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
	$obj->shipaddress='';
	$obj->shcostprice='';
}


	
	$obj->shbrancheid=1;
	$obj->shitemid=1;
	$obj->shcostprice=1;
	$obj->shtcostprice=1;
	$obj->shquantity=1;
	


if(!empty($obj->grbrancheid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" brancheid ";
	$obj->shbrancheid=1;
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
	
	array_push($sColumns, 'item');
	array_push($aColumns, "inv_items.id as item");
// 	$k++;
		
	if(!empty($obj->shbrancheid)  or empty($obj->action)){
		array_push($sColumns, 'brancheid');
		array_push($aColumns, "sys_branches.name as brancheid");
		$rptjoin.=" left join sys_branches on sys_branches.id=inv_branchstocks.brancheid ";
		$k++;
		}

	if(!empty($obj->shitemid)  or empty($obj->action)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "inv_items.name as itemid");
		$rptjoin.=" left join inv_items on inv_items.id=inv_branchstocks.itemid ";
		$k++;
		
		$itm=$k;
		}
	
	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		if(empty($rptgroup))
		  array_push($aColumns, "inv_branchstocks.quantity");
		else
		  array_push($aColumns, "sum(inv_branchstocks.quantity) quantity");
		$k++;
		
		$y=$k;
		
		}
		
	if(!empty($obj->shtcostprice) ){
		array_push($sColumns, 'tcostprice');
		array_push($aColumns, "case when inv_items.costprice is null then 0 else inv_items.costprice end as tcostprice");
		$k++;
		$join=" left join inv_items on inv_items.id=inv_branchstocks.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
			
			
		}
		
		$x=$k;
		
		}
		
	  if(!empty($obj->shcostprice) ){
		array_push($sColumns, 'costprice');
		if(empty($rptgroup))
		  array_push($aColumns, "round((inv_branchstocks.quantity) * (case when inv_items.costprice is null then 0 else inv_items.costprice end),2) as costprice");
		else	
		  array_push($aColumns, "round(sum(inv_branchstocks.quantity) * (case when inv_items.costprice is null then 0 else inv_items.costprice end),2) as costprice");
		$k++;
		$join=" left join inv_items on inv_items.id=inv_branchstocks.itemid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;		
		}
		$mnt=$k;
		
		array_push($sColumns, 'branch');
		array_push($aColumns, "inv_branchstocks.brancheid branch");
		$k++;
		
		}

	
		//processing columns to show




$track=0;

//processing filters


$rptwhere=" 1=1 ";
$track++;

if(!empty($obj->brancheid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_branchstocks.brancheid='$obj->brancheid'";
		
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_branchstocks.itemid='$obj->itemid'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_branchstocks.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_branchstocks.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" inv_branchstocks.createdon<='$obj->tocreatedon'";
	$track++;
}

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="inv_branchstocks";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 
 $().ready(function() {
  $("#itemname").autocomplete({
	source:"../../../modules/server/server/search.php?main=inv&module=items&field=inv_items.name",
	appendTo: "#myModal",focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
      	},
      	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#itemid").val(ui.item.id);
	}
  });

 })
 
 $(document).ready(function() {
	
				
 	$('#tbl').dataTable( {
		"scrollX": true,
	      dom: 'lBfrtip',
		"buttons": [
		 'copy', 'csv', 'excel', 'print',{
		    extend: 'pdfHtml5',
		    orientation: 'landscape',
		    pageSize: 'LEGAL'
		}],
		"aLengthMenu": [[10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000], [10, 25, 50, 100, 250, 500, 1000, 5000, 10000, 50000, 100000]],
 		"bJQueryUI": true,
 		"bSort":true,
 		"sPaginationType": "full_numbers",
 		"sScrollY": 400,
 		"iDisplayLength":50,
		"bJQueryUI": true,
		"bRetrieve":true,
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=inv_branchstocks",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);console.log(aaData);
			var num = aaData.length;
			for(var i=1; i<num; i++){
				if(i==1)
				  continue;
				if(i=="<?php echo ($itm);?>"){
				  $('td:eq('+i+')', nRow).html("<a href='javascript:;' onclick='showPopWin(&quot;../../../modules/inv/stocktrack/stocktrack.php?itemid="+aaData[0]+"&brancheid="+aaData[6]+"&branche=1&quot;, 1000, 600);' >"+aaData[i]+"</a>");
				}else if(i=="<?php echo $mnt;?>" || i=="<?php echo $x; ?>" || i=="<?php echo $y; ?>"){
				  $('td:eq('+i+')', nRow).html(aaData[i]).formatCurrency().attr('align','right');
				}
				else
				  $('td:eq('+i+')', nRow).html(aaData[i]);
			}
			return nRow;
		},
		"fnFooterCallback": function ( nRow, aaData, iStart, iEnd, aiDisplay ) {
			$('th:eq(0)', nRow).html("1");
			$('th:eq(1)', nRow).html("TOTAL");
			var total=0;
			var total1=0;
			var total2=0;
			for(var i=0; i<aaData.length; i++){
			  for(var j=2; j<aaData[i].length; j++){
				if(j=="<?php echo $mnt;?>"){
				  
				  total+=parseFloat(aaData[i][j]);
				  $('th:eq('+j+')', nRow).html(total).formatCurrency();
				}
				else if(j=="<?php echo $x; ?>"){
				  
				  total1+=parseFloat(aaData[i][j]);
				  $('th:eq('+j+')', nRow).html(total1).formatCurrency();
				}
				else if(j=="<?php echo $y; ?>"){
				  
				  total2+=parseFloat(aaData[i][j]);
				  $('th:eq('+j+')', nRow).html(total2).formatCurrency();
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
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Filter</button>&nbsp;<a class="btn btn-warning" target="_blank" href="../../graphs/graphs/bars.php">Bar Graph</a>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter</h4>
      </div>
      <div class="modal-body">
<form  action="branchstocks.php" method="post" name="branchstocks" >
<table width="100%" border="0" align="center" class="table">
	
	<tr>
		<td>Branch</td>
		<td>
		<select name='brancheid' class='selectbox'>
		<?php
		$branches=new Branches();
		$where="  ";
		if($_SESSION['levelid']==1){ ?>
		    <option value="">ALL...</option>
		    <?php
		    $where="";
		}else{
		    $where=" where id='".$_SESSION['brancheid']."' ";
		}
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

		while($rw=mysql_fetch_object($branches->result)){
		?>
			<option value="<?php echo $rw->id; ?>" <?php if($obj->brancheid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
		<?php
		}
		?>
		</select>
</td>
	</tr>
	<tr>
		<td>Itemid</td>
		<td><input type='text' size='20' name='itemname' id='itemname' value='<?php echo $obj->itemname; ?>'>
			<input type="hidden" name='itemid' id='itemid' value='<?php echo $obj->field; ?>'></td>
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
<!-- 			<th>Branch </th> -->
			<?php if($obj->shbrancheid==1  or empty($obj->action)){ ?>
				<th>Branch </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>Product </th>
			<?php } ?>
			
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shtcostprice==1 ){ ?>
				<th>Cost Price </th>
			<?php } ?>
			<?php if($obj->shcostprice==1 ){ ?>
				<th>Total Cost Price </th>
				<th>&nbsp;</th>
			<?php } ?>
			
			
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
	<tr>
	<th>#</th>
			<?php if($obj->shbrancheid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shitemid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shtcostprice==1 ){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shcostprice==1 ){ ?>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			<?php } ?>
			
			
	</tr>
	</tfoot>
</table>
</div>
</div>
</div>
</div>
</div>
<?php
include"../../../foot.php";
?>