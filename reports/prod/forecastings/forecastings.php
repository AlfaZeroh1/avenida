<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/prod/forecastings/Forecastings_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/prod/varietys/Varietys_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Forecastings";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include "../../../head.php";

if(empty($obj->action)){
	$obj->fromforecastdate=date('Y-m-d');
	$obj->toforecastdate=date('Y-m-d');
}


$rptwhere='';
$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$aColumns=array('1');
$sColumns=array('1');
//processing columns to show
	if(!empty($obj->shvarietyid)  or empty($obj->action)){
		array_push($sColumns, 'varietyid');
		array_push($aColumns, "prod_varietys.name as varietyid");
		$rptjoin.=" left join prod_varietys on prod_varietys.id=prod_forecastings.varietyid ";
		$k++;
	}

	if(!empty($obj->shforecastdate)  or empty($obj->action)){
		array_push($sColumns, 'forecastdate');
		array_push($aColumns, "prod_forecastings.forecastdate");
		$k++;
	}

	if(!empty($obj->shquantity)  or empty($obj->action)){
		array_push($sColumns, 'quantity');
		array_push($aColumns, "sum(prod_forecastings.quantity) quantity");
		

		$k++;
		
		$mnt=$k;
	}

	if(!empty($obj->shremarks)  or empty($obj->action)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "prod_forecastings.remarks");
		$k++;
	}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=prod_forecastings.createdby";
		$k++;
	}

	if(!empty($obj->shcreatedon)  or empty($obj->action)){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "prod_forecastings.createdon");
		$k++;
	}

	if(!empty($obj->shyear)  or empty($obj->action)){
		array_push($sColumns, 'year');
		array_push($aColumns, "prod_forecastings.year");
		$k++;
	}

	if(!empty($obj->shweek)  or empty($obj->action)){
		array_push($sColumns, 'week');
		array_push($aColumns, "auth_users.username as week");
		$k++;
	}

	if(!empty($obj->shipaddress)  or empty($obj->action)){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "prod_forecastings.ipaddress");
		$k++;
	}

//processing filters
if(!empty($obj->varietyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.varietyid='$obj->varietyid'";
	$track++;
}

if(!empty($obj->fromforecastdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.forecastdate>='$obj->fromforecastdate'";
	$track++;
}

if(!empty($obj->toforecastdate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.forecastdate<='$obj->toforecastdate'";
	$track++;
}

if(!empty($obj->fromquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.quantity>='$obj->fromquantity'";
	$track++;
}

if(!empty($obj->toquantity)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.quantity<='$obj->toquantity'";
	$track++;
}

if(!empty($obj->quantity)){
	if($track>0)
		//$rptwhere.="and"; TableToolsInit.sSwfPath = "../../../media/swf/ZeroClipboard.swf";
		$rptwhere.=" prod_forecastings.quantity='$obj->quantity'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.createdon<='$obj->tocreatedon'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->year)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.year<='$obj->year'";
	$track++;
}

if(!empty($obj->week)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.week>='$obj->week'";
	$track++;
}

if(!empty($obj->ipaddress)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" prod_forecastings.ipaddress<='$obj->ipaddress'";
	$track++;
}
//Processing Groupings
$rptgroup='';
$track=0;
$obj->grvarietyid='1';
if(!empty($obj->grvarietyid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" varietyid ";
	$obj->shvarietyid=1;
	$track++;
}

if(!empty($obj->grforecastdate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" forecastdate ";
	$obj->shforecastdate=1;
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

//Processing Joins
;$track=0;
//Default shows
?>
<title><?php echo $page_title; ?></title>
<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="prod_forecastings";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=prod_forecastings",
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
<form  action="forecastings.php" method="post" name="forecastings" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Variety</td>
				<td>
				<select name='varietyid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$varietys=new Varietys();
				$where="  ";
				$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.quantity, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
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
				<td>Forecast date</td>
				<td><strong>From:</strong><input type='text' id='fromforecastdate' size='12' name='fromforecastdate' readonly class="date_input" value='<?php echo $obj->fromforecastdate;?>'/>
							<br/><strong>To:</strong><input type='text' id='toforecastdate' size='12' name='toforecastdate' readonly class="date_input" value='<?php echo $obj->toforecastdate;?>'/></td>
			</tr>
			<tr>
				<td>Quantity</td>
				<td><strong>From:</strong><input type='text' id='fromquantity' size='from20' name='fromquantity' value='<?php echo $obj->fromquantity;?>'/>
								<br/><strong>To:</strong><input type='text' id='toquantity' size='to20' name='toquantity' value='<?php echo $obj->toquantity;?>'></td>
			</tr>
			<tr>
				<td>Created By</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from prod_forecastings) ";
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
		</table>
		</td>
		<td>
		<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
			<th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='grvarietyid' value='1' <?php if(isset($_POST['grvarietyid']) or empty($obj->action)){echo"checked";}?>>&nbsp;Variety</td>
				<td><input type='checkbox' name='grforecastdate' value='1' <?php if(isset($_POST['grforecastdate']) ){echo"checked";}?>>&nbsp;Forecast date</td>
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
				<td><input type='checkbox' name='shvarietyid' value='1' <?php if(isset($_POST['shvarietyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Variety</td>
				<td><input type='checkbox' name='shforecastdate' value='1' <?php if(isset($_POST['shforecastdate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Forecast date</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created By</td>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created On</td>
			<tr>
				<td><input type='checkbox' name='shweek' value='1' <?php if(isset($_POST['shweek'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Week</td>
				<td><input type='checkbox' name='shyear' value='1' <?php if(isset($_POST['shyear'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Year</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Ip Address</td>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" align='center'><input type="submit" name="action" id="action" value="Filter" /></td>
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
				<th>Variety</th>
			<?php } ?>
			<?php if($obj->shforecastdate==1  or empty($obj->action)){ ?>
				<th>Fore Cast For </th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>Quantity </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Created By </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>Created On </th>
			<?php } ?>
			<?php if($obj->shweek==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shyear==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shipaddress==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
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
			<?php if($obj->shforecastdate==1  or empty($obj->action)){ ?>
				<th>&nbsp;</th>
			<?php } ?>
			<?php if($obj->shquantity==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shremarks==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shcreatedon==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shweek==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shyear==1  or empty($obj->action)){ ?>
				<th> &nbsp;</th>
			<?php } ?>
			<?php if($obj->shipaddress==1  or empty($obj->action)){ ?>
				<th>&nbsp; </th>
			<?php } ?>
	</tr>
	<tfoot>
	</tbody>
</div>
</div>
</div>
</div>
</div>
