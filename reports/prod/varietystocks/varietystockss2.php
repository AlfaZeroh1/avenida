<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/varietystocks/Varietystocks_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/prod/areas/Areas_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Varietystocks";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8805";//Report View
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
if(!empty($obj->grdocumentno) or !empty($obj->grvarietyid) or !empty($obj->grareaid) or !empty($obj->grrecordedon) or !empty($obj->gractedon) or !empty($obj->grcreatedon) or !empty($obj->grcreatedby) ){
	$obj->shdocumentno='';
	$obj->shvarietyid=1;
	$obj->shareaid='';
	$obj->shtransaction='';
	$obj->shquantity='';
	$obj->shremain='';
	$obj->shrecordedon='';
	$obj->shactedon='';
	$obj->shcreatedon='';
	$obj->shcreatedby='';
}


	$obj->shquantity=1;
	$obj->shsizeid=1;
	$obj->grvarietyid=1;
	


if(!empty($obj->grdocumentno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" documentno ";
	$obj->shdocumentno=1;
	$track++;
}

if(!empty($obj->grvarietyid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" varietyid ";
	$obj->shvarietyid=1;
	$track++;
}

if(!empty($obj->grareaid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" areaid ";
	$obj->shareaid=1;
	$track++;
}

if(!empty($obj->grrecordedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" recordedon ";
	$obj->shrecordedon=1;
	$track++;
}

if(!empty($obj->gractedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" actedon ";
	$obj->shactedon=1;
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
// 	if(!empty($obj->shdocumentno)  or empty($obj->action)){
// 		array_push($sColumns, 'documentno');
// 		array_push($aColumns, "prod_varietystocks.documentno");
// 		$k++;
// 		}

	if(!empty($obj->shvarietyid)  or empty($obj->action)){
		array_push($sColumns, 'varietyid');
		array_push($aColumns, "prod_varietys.name as varietyid");
 		$rptjoin.=" left join prod_varietys on prod_varietys.id=prod_varietystocks.varietyid ";
		$k++;
		}

// 	if(!empty($obj->shareaid)  or empty($obj->action)){
// 		array_push($sColumns, 'areaid');
// 		array_push($aColumns, "prod_areas.name as areaid");
// 		$rptjoin.=" left join prod_areas on prod_areas.id=prod_varietystocks.areaid ";
// 		$k++;
// 		}
// 
// 	if(!empty($obj->shtransaction)  or empty($obj->action)){
// 		array_push($sColumns, 'transaction');
// 		array_push($aColumns, "prod_varietystocks.transaction");
// 		$k++;
// 		}

// 	if(!empty($obj->shquantity)  or empty($obj->action)){
// 		array_push($sColumns, 'quantity');
// 		if(!empty($rptgroup)){
// 			array_push($aColumns, "sum(prod_varietystocks.quantity) quantity");
// 		}else{
// 		array_push($aColumns, "prod_varietystocks.quantity");
// 		}
// 
// 		$k++;
// 		}

// 	if(!empty($obj->shremain)  or empty($obj->action)){
// 		array_push($sColumns, 'remain');
// 		array_push($aColumns, "prod_varietystocks.remain");
// 		$k++;
// 		}
// 
	if(!empty($obj->shrecordedon)  or empty($obj->action)){
		array_push($sColumns, 'recordedon');
		array_push($aColumns, "prod_varietystocks.recordedon");
		$k++;
		}

	if(!empty($obj->shactedon)  or empty($obj->action)){
		array_push($sColumns, 'actedon');
		array_push($aColumns, "prod_varietystocks.actedon");
		$k++;
		}

// 	if(!empty($obj->shcreatedon) ){
// 		array_push($sColumns, 'createdon');
// 		array_push($aColumns, "prod_varietystocks.createdon");
// 		$k++;
// 		}
// 
// 	if(!empty($obj->shcreatedby)  or empty($obj->action)){
// 		array_push($sColumns, 'createdby');
// 		array_push($aColumns, "prod_varietystocks.createdby");
// 		$k++;
// 		}



$track=0;

//processing filters
if(!empty($obj->documentno)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.documentno='$obj->documentno'";
	$track++;
}

if(!empty($obj->varietyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.varietyid='$obj->varietyid'";
		$join=" left join prod_varietys on prod_varietystocks.id=prod_varietys.varietystockid ";
		
	$track++;
}

if(!empty($obj->areaid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.areaid='$obj->areaid'";
		$join=" left join prod_areas on prod_varietystocks.id=prod_areas.varietystockid ";
		
	$track++;
}

if(!empty($obj->transaction)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.transaction='$obj->transaction'";
	$track++;
}

if(!empty($obj->fromrecordedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.recordedon>='$obj->fromrecordedon'";
	$track++;
}

if(!empty($obj->torecordedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.recordedon<='$obj->torecordedon'";
	$track++;
}

if(!empty($obj->fromactedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.actedon>='$obj->fromactedon'";
	$track++;
}

if(!empty($obj->toactedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.actedon<='$obj->toactedon'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_varietystocks.createdby='$obj->createdby'";
	$track++;
}

//Processing Joins
$mnt = ($k+1);
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
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
    $cols=" sum(case when sizeid=$rw->id then prod_varietystocks.quantity end) '$rw->name'";
    array_push($aColumns, $cols);
    array_push($sColumns, $rw->name);
    
    $k++;
  }
  
  if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "sum(prod_varietystocks.quantity) quantity");
		$k++;
		}
?>

 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="prod_varietystocks";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_varietystocks",
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
<form  action="varietystockss.php" method="post" name="varietystocks" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Document no</td>
				<td><input type='text' id='documentno' size='20' name='documentno' value='<?php echo $obj->documentno;?>'></td>
			</tr>
			<tr>
				<td>Variety</td>
				<td>
				<select name='varietyid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$varietys=new Varietys();
				$where="  ";
				$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.stems, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($varietys->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->varietyid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Area</td>
				<td>
				<select name='areaid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$areas=new Areas();
				$where="  ";
				$fields="prod_areas.id, prod_areas.name, prod_areas.size, prod_areas.noofplants, prod_areas.blockid, prod_areas.status, prod_areas.remarks, prod_areas.ipaddress, prod_areas.createdby, prod_areas.createdon, prod_areas.lasteditedby, prod_areas.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$areas->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($areas->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->areaid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Transaction</td>
				<td><input type='text' id='transaction' size='20' name='transaction' value='<?php echo $obj->transaction;?>'></td>
			</tr>
			<tr>
				<td>recordedon</td>
				<td><strong>From:</strong><input type='text' id='fromrecordedon' size='12' name='fromrecordedon' readonly class="date_input" value='<?php echo $obj->fromrecordedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='torecordedon' size='12' name='torecordedon' readonly class="date_input" value='<?php echo $obj->torecordedon;?>'/></td>
			</tr>
			<tr>
				<td>Acted on</td>
				<td><strong>From:</strong><input type='text' id='fromactedon' size='12' name='fromactedon' readonly class="date_input" value='<?php echo $obj->fromactedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='toactedon' size='12' name='toactedon' readonly class="date_input" value='<?php echo $obj->toactedon;?>'/></td>
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grdocumentno' value='1' <?php if(isset($_POST['grdocumentno']) ){echo"checked";}?>>&nbsp;Document no</td>
				<td><input type='checkbox' name='grvarietyid' value='1' <?php if(isset($_POST['grvarietyid']) or empty($obj->action) ){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='grareaid' value='1' <?php if(isset($_POST['grareaid']) ){echo"checked";}?>>&nbsp;Area</td>
				<td><input type='checkbox' name='grrecordedon' value='1' <?php if(isset($_POST['grrecordedon']) ){echo"checked";}?>>&nbsp;recordedon</td>
			<tr>
				<td><input type='checkbox' name='gractedon' value='1' <?php if(isset($_POST['gractedon']) ){echo"checked";}?>>&nbsp;Acted on</td>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Document no</td>
				<td><input type='checkbox' name='shvarietyid' value='1' <?php if(isset($_POST['shvarietyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='shareaid' value='1' <?php if(isset($_POST['shareaid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Area</td>
				<td><input type='checkbox' name='shtransaction' value='1' <?php if(isset($_POST['shtransaction'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Transaction</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shremain' value='1' <?php if(isset($_POST['shremain'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remain</td>
			<tr>
				<td><input type='checkbox' name='shrecordedon' value='1' <?php if(isset($_POST['shrecordedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;recordedon</td>
				<td><input type='checkbox' name='shactedon' value='1' <?php if(isset($_POST['shactedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Acted on</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon']) ){echo"checked";}?>>&nbsp;Created On</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
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
			<?php if($obj->shvarietyid==1  or empty($obj->action)){ ?>
				<th>Variety </th>
			<?php } ?>
			<?php if($obj->shrecordedon==1  or empty($obj->action)){ ?>
				<th>Recordedon </th>
			<?php } ?>
			<?php if($obj->shactedon==1  or empty($obj->action)){ ?>
				<th>Actedon </th>
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
			<?php if($obj->shquantity==1){ ?>
				<th>Total </th>
			<?php } ?>
			
		</tr>
	</thead>
	<tbody>
	<tfoot>
	<tr>
	
	<th>#</th>
			<?php if($obj->shvarietyid==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
				
			<?php } ?>
			<?php if($obj->shrecordedon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shactedon==1  or empty($obj->action)){ ?>
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
			<?php if($obj->shquantity==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
	</tr>
	</tfoot>
	</tbody>
</div>
</div>
</div>
</div>
</div>
