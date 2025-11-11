<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/sys/currencyrates/Currencyrates_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/sys/currencys/Currencys_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Currencyrates";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="9396";//Add
$auth->levelid=$_SESSION['level'];

//auth($auth);
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
if(!empty($obj->grcurrencyid) or !empty($obj->grfromcurrencydate) or !empty($obj->grtocurrencydate) or !empty($obj->grcreatedby) or !empty($obj->grcreatedon) ){
	$obj->shcurrencyid='';
	$obj->shfromcurrencydate='';
	$obj->shtocurrencydate='';
	$obj->shrate='';
	$obj->sheurorate='';
	$obj->shremarks='';
	$obj->shipaddress='';
	$obj->shcreatedby='';
	$obj->shcreatedon='';
}


	$obj->sh=1;


if(!empty($obj->grcurrencyid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" currencyid ";
	$obj->shcurrencyid=1;
	$track++;
}

if(!empty($obj->grfromcurrencydate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" fromcurrencydate ";
	$obj->shfromcurrencydate=1;
	$track++;
}

if(!empty($obj->grtocurrencydate)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" tocurrencydate ";
	$obj->shtocurrencydate=1;
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
	if(!empty($obj->shcurrencyid)  or empty($obj->action)){
		array_push($sColumns, 'currencyid');
		array_push($aColumns, "sys_currencys.name as currencyid");
		$rptjoin.=" left join sys_currencys on sys_currencys.id=sys_currencyrates.currencyid ";
		$k++;
		}

	if(!empty($obj->shfromcurrencydate)  or empty($obj->action)){
		array_push($sColumns, 'fromcurrencydate');
		array_push($aColumns, "sys_currencyrates.fromcurrencydate");
		$k++;
		}

	if(!empty($obj->shtocurrencydate)  or empty($obj->action)){
		array_push($sColumns, 'tocurrencydate');
		array_push($aColumns, "sys_currencyrates.tocurrencydate");
		$k++;
		}

	if(!empty($obj->shrate)  or empty($obj->action)){
		array_push($sColumns, 'rate');
		array_push($aColumns, "sys_currencyrates.rate");
		$k++;
		}

	if(!empty($obj->sheurorate)  or empty($obj->action)){
		array_push($sColumns, 'eurorate');
		array_push($aColumns, "sys_currencyrates.eurorate");
		$k++;
		}

	if(!empty($obj->shremarks) ){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "sys_currencyrates.remarks");
		$k++;
		}

	if(!empty($obj->shipaddress) ){
		array_push($sColumns, 'ipaddress');
		array_push($aColumns, "sys_currencyrates.ipaddress");
		$k++;
		}

	if(!empty($obj->shcreatedby)  or empty($obj->action)){
		array_push($sColumns, 'createdby');
		array_push($aColumns, "auth_users.username as createdby");
		$rptjoin.=" left join auth_users on auth_users.id=sys_currencyrates.createdby";
		$k++;
		}

	if(!empty($obj->shcreatedon) ){
		array_push($sColumns, 'createdon');
		array_push($aColumns, "sys_currencyrates.createdon");
		$k++;
		}



$track=0;

//processing filters
if(!empty($obj->currencyid)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" sys_currencyrates.currencyid='$obj->currencyid'";
// 		$join=" left join sys_currencys on sys_currencyrates.id=sys_currencys.currencyrateid ";
// 		if(!strpos($rptjoin,trim($join))){
// 			$rptjoin.=$join;
// 		}
	$track++;
}

if(!empty($obj->fromfromcurrencydate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" sys_currencyrates.fromcurrencydate>='$obj->fromfromcurrencydate'";
	$track++;
}

if(!empty($obj->tofromcurrencydate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" sys_currencyrates.fromcurrencydate<='$obj->tofromcurrencydate'";
	$track++;
}

if(!empty($obj->fromtocurrencydate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" sys_currencyrates.tocurrencydate>='$obj->fromtocurrencydate'";
	$track++;
}

if(!empty($obj->totocurrencydate)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" sys_currencyrates.tocurrencydate<='$obj->totocurrencydate'";
	$track++;
}

if(!empty($obj->createdby)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" sys_currencyrates.createdby='$obj->createdby'";
	$track++;
}

if(!empty($obj->fromcreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" sys_currencyrates.createdon>='$obj->fromcreatedon'";
	$track++;
}

if(!empty($obj->tocreatedon)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" sys_currencyrates.createdon<='$obj->tocreatedon'";
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
 <?php $_SESSION['sTable']="sys_currencyrates";?>
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=sys_currencyrates",
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
<form  action="currencyrates.php" method="post" name="currencyrates" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
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
			<tr>
				<td>From currencyd ate</td>
				<td><strong>From:</strong><input type='text' id='fromfromcurrencydate' size='12' name='fromfromcurrencydate' readonly class="date_input" value='<?php echo $obj->fromfromcurrencydate;?>'/>
							<br/><strong>To:</strong><input type='text' id='tofromcurrencydate' size='12' name='tofromcurrencydate' readonly class="date_input" value='<?php echo $obj->tofromcurrencydate;?>'/></td>
			</tr>
			<tr>
				<td>To currency date</td>
				<td><strong>From:</strong><input type='text' id='fromtocurrencydate' size='12' name='fromtocurrencydate' readonly class="date_input" value='<?php echo $obj->fromtocurrencydate;?>'/>
							<br/><strong>To:</strong><input type='text' id='totocurrencydate' size='12' name='totocurrencydate' readonly class="date_input" value='<?php echo $obj->totocurrencydate;?>'/></td>
			</tr>
			<tr>
				<td>Created by</td>
			<td>
			<select name='createdby' class='selectbox'>
				<option value=''>Select...</option>
				<?php
				$users = new Users();
				$fields="auth_users.id, concat(hrm_employees.pfnum,' ',concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname))) employeeid, concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) employeename";
				$where=" where auth_users.id in(select createdby from fn_currencyrates) ";
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
				<td><input type='checkbox' name='grcurrencyid' value='1' <?php if(isset($_POST['grcurrencyid']) ){echo"checked";}?>>&nbsp;Currency</td>
				<td><input type='checkbox' name='grfromcurrencydate' value='1' <?php if(isset($_POST['grfromcurrencydate']) ){echo"checked";}?>>&nbsp;From currencyd ate</td>
			<tr>
				<td><input type='checkbox' name='grtocurrencydate' value='1' <?php if(isset($_POST['grtocurrencydate']) ){echo"checked";}?>>&nbsp;To currency date</td>
				<td><input type='checkbox' name='grcreatedby' value='1' <?php if(isset($_POST['grcreatedby']) ){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
				<td><input type='checkbox' name='grcreatedon' value='1' <?php if(isset($_POST['grcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
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
				<td><input type='checkbox' name='shcurrencyid' value='1' <?php if(isset($_POST['shcurrencyid'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Currency</td>
				<td><input type='checkbox' name='shfromcurrencydate' value='1' <?php if(isset($_POST['shfromcurrencydate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;From currencyd ate</td>
			<tr>
				<td><input type='checkbox' name='shtocurrencydate' value='1' <?php if(isset($_POST['shtocurrencydate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;To currency date</td>
				<td><input type='checkbox' name='shrate' value='1' <?php if(isset($_POST['shrate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Rate</td>
			<tr>
				<td><input type='checkbox' name='sheurorate' value='1' <?php if(isset($_POST['sheurorate'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Euro rate</td>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks']) ){echo"checked";}?>>&nbsp;Remarks</td>
			<tr>
				<td><input type='checkbox' name='shipaddress' value='1' <?php if(isset($_POST['shipaddress']) ){echo"checked";}?>>&nbsp;Ipaddress</td>
				<td><input type='checkbox' name='shcreatedby' value='1' <?php if(isset($_POST['shcreatedby'])  or empty($obj->action)){echo"checked";}?>>&nbsp;Created by</td>
			<tr>
				<td><input type='checkbox' name='shcreatedon' value='1' <?php if(isset($_POST['shcreatedon']) ){echo"checked";}?>>&nbsp;Created on</td>
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
			<?php if($obj->shcurrencyid==1  or empty($obj->action)){ ?>
				<th>Currency </th>
			<?php } ?>
			<?php if($obj->shfromcurrencydate==1  or empty($obj->action)){ ?>
				<th>Currency Date From </th>
			<?php } ?>
			<?php if($obj->shtocurrencydate==1  or empty($obj->action)){ ?>
				<th>Currency Date To </th>
			<?php } ?>
			<?php if($obj->shrate==1  or empty($obj->action)){ ?>
				<th>Kshs. Rate </th>
			<?php } ?>
			<?php if($obj->sheurorate==1  or empty($obj->action)){ ?>
				<th>Euro Rate </th>
			<?php } ?>
			<?php if($obj->shremarks==1 ){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shipaddress==1 ){ ?>
				<th>IP Address </th>
			<?php } ?>
			<?php if($obj->shcreatedby==1  or empty($obj->action)){ ?>
				<th>Create By </th>
			<?php } ?>
			<?php if($obj->shcreatedon==1 ){ ?>
				<th>Created on </th>
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
