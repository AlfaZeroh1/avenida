<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/post/graded/Graded_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/auth/rules/Rules_class.php");
require_once("../../../modules/pos/sizes/Sizes_class.php");
require_once("../../../modules/pos/items/Items_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/prod/colours/Colours_class.php");
require_once("../../../modules/prod/colours/Colours_class.php");
require_once("../../../modules/prod/colours/Colours_class.php");
require_once("../../../modules/post/teams/Teams_class.php");
require_once("../../../modules/auth/users/Users_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Graded";
//connect to db
$db=new DB();

$obj=(object)$_POST;

//Authorization.
$auth->roleid="8791";//Report View
$auth->levelid=$_SESSION['level'];

auth($auth);
include "../../../head.php";

if(empty($obj->action)){
	$obj->fromgradedon=date('Y-m-d');
	$obj->togradedon=date('Y-m-d');
	
	$obj->gritemid=1;
	$obj->grgradedon=1;
	$obj->grdatecode=1;
	$obj->status="checkedin";
}

if(!empty($obj->status))
  $rptwhere=" post_graded.status='$obj->status' ";

$rptjoin='';
$track=0;
$k=0;
$fds='';
$fd='';
$mnt=0;
$aColumns=array('1');
$sColumns=array('1');
//Processing Groupings
$rptgroup='';
$track=0;
$obj->shdatecode=1;
if(!empty($obj->gremployeeid) or !empty($obj->gritemid) or !empty($obj->grgradedon) or !empty($obj->grsizeid) or !empty($obj->grcolourid) or !empty($obj->grteamid) ){
	$obj->shsizeid='';
	$obj->shitemid='';
	$obj->shquantity='';
	$obj->shgradedon='';
	$obj->shemployeeid='';
// 	$obj->shbarcode='';
	$obj->shremarks='';
	$obj->shstatus='';
	$obj->shcolourid='';
	$obj->shteamid='';
}


	$obj->shquantity=1;
	$obj->shsizeid=1;


if(!empty($obj->gremployeeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" employee ";
	$obj->shemployeeid=1;
	$track++;
}


if(!empty($obj->grteamid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" team ";
	$obj->shteamid=1;
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

if(!empty($obj->grgreenhouseid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" greenhouseid ";
	$obj->shgreenhouseid=1;
	$track++;
}

if(!empty($obj->grgradedon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" gradedon ";
	$obj->shgradedon=1;
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

if(!empty($obj->grcolourid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" colourid ";
	$obj->shcolourid=1;
	$track++;
}

if(!empty($obj->grdatecode)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" datecode ";
	$obj->shdatecode=1;
	$track++;
}


if(!empty($obj->grteamid) and !empty($obj->gremployeeid)){
	
	$rptgroup=" group by team,employee with rollup ";
}
$obj->shgreenhouseid=1;
//processing columns to show
	if(!empty($obj->shsizeid)){
// 		array_push($sColumns, 'sizeid');
// 		array_push($aColumns, "prod_sizes.name as sizeid");
// 		$rptjoin.=" left join prod_sizes on prod_sizes.id=post_graded.sizeid ";
// 		$k++;
		}

	if(!empty($obj->shitemid)){
		array_push($sColumns, 'itemid');
		array_push($aColumns, "pos_items.name as itemid");
		$rptjoin.=" left join pos_items on post_graded.itemid=pos_items.id ";
		$k++;
		}
		
	if(!empty($obj->shdatecode)){
		array_push($sColumns, 'datecode');
		array_push($aColumns, "post_graded.datecode as datecode");
		$k++;
		}
		
	if(!empty($obj->shgreenhouseid)){
		array_push($sColumns, 'greenhouseid');
		array_push($aColumns, "prod_greenhouses.name as greenhouseid");
		$rptjoin.=" left join prod_greenhouses on post_graded.greenhouseid=prod_greenhouses.id ";
		$k++;
		}
		
	if(!empty($obj->shgradedon)){
		array_push($sColumns, 'gradedon');
		array_push($aColumns, "post_graded.gradedon");
		$k++;
		}

	if(!empty($obj->shteamid) ){
		array_push($sColumns, 'team');
		array_push($aColumns, "post_teams.name as team");
		$k++;
		$join=" left join post_teammembers on post_graded.employeeid=post_teammembers.employeeid and post_teammembers.teamedon='$obj->fromgradedon' ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join post_teams on post_teams.id=post_teammembers.teamid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}
		
	if(!empty($obj->shemployeeid)){
		array_push($sColumns, 'employee');
		array_push($aColumns, "concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) as employee");
		$rptjoin.=" left join hrm_employees on hrm_employees.id=post_graded.employeeid ";
		$k++;
		}

// 	if(!empty($obj->shbarcode)){
// 		array_push($sColumns, 'barcode');
// 		array_push($aColumns, "post_graded.barcode");
// 		$k++;
// 		}

	if(!empty($obj->shremarks)){
		array_push($sColumns, 'remarks');
		array_push($aColumns, "post_graded.remarks");
		$k++;
		}

	if(!empty($obj->shstatus)){
		array_push($sColumns, 'status');
		array_push($aColumns, "post_graded.status");
		$k++;
		}

	if(!empty($obj->shcolourid)){
		array_push($sColumns, 'colourid');
		array_push($aColumns, "prod_colours.name as colourid");
		$k++;
		$join=" left join pos_items on post_graded.itemid=pos_items.id ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		$join=" left join prod_colours on prod_colours.id=pos_items.colourid ";
		if(!strpos($rptjoin,trim($join))){
			$rptjoin.=$join;
		}
		}

		
    $mnt=($k+1);
$track=1;

//processing filters
if(!empty($obj->sizeid)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" post_graded.sizeid='$obj->sizeid' ";
		
	$track++;
}

if(!empty($obj->itemid)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" post_graded.itemid='$obj->itemid' ";
		
	$track++;
}

if(!empty($obj->fromquantity)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" post_graded.quantity>='$obj->fromquantity' ";
	$track++;
}

if(!empty($obj->toquantity)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" post_graded.quantity<='$obj->toquantity'";
	$track++;
}

if(!empty($obj->fromgradedon)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" post_graded.gradedon>='$obj->fromgradedon'";
	$track++;
}

if(!empty($obj->togradedon)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" post_graded.gradedon<='$obj->togradedon'";
	$track++;
}

if(!empty($obj->employeeid)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" post_graded.employeeid='$obj->employeeid'";
// 		$join=" left join hrm_employees on post_graded.id=hrm_employees.gradeid ";
		
	$track++;
}

if(!empty($obj->barcode)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" post_graded.barcode='$obj->barcode'";
	$track++;
}

if(!empty($obj->datecode)){
	if($track>0)
		$rptwhere.="and";
		$rptwhere.=" post_graded.datecode='$obj->datecode'";
	$track++;
}

if(!empty($obj->status)){
	if($track>0)
		$rptwhere.=" and ";
		$rptwhere.=" post_graded.status='$obj->status'";
	$track++;
}

if(!empty($obj->colourid)){
	if($track>0)
		$rptwhere.=" and ";
	$rptwhere.=" prod_colours.id='$obj->colourid' ";
	$join=" left join pos_items on pos_items.id=pos_items.itemid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join prod_colours on prod_colours.id=pos_items.colourid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

if(!empty($obj->teamid)){
	if($track>0)
		$rptwhere.=" and ";
	$rptwhere.=" post_teams.id='$obj->teamid' ";
	//$join=" left join post_teammembers on post_teammembers.id=post_teammembers.teammemberid ";
	$join=" left join post_teammembers on post_graded.employeeid=post_teammembers.employeeid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$join=" left join post_teams on post_teams.id=post_teammembers.teamid ";
	if(!strpos($rptjoin,trim($join))){
		$rptjoin.=$join;
	}
	$track++;
}

// if(true){
// 	if($track>0)
// 		$rptwhere.=" and ";
// 		if(empty($obj->downsize))
// 		  $obj->downsize="0";
// 		$rptwhere.=" post_graded.downsize='$obj->downsize'";
// 	$track++;
// }

//Processing Joins
;$track=0;
//Default shows
if(!empty($obj->shemployeeid)){
	$fd.=" ,concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) ";
}
if(!empty($obj->shcolourid)){
	$fd.=" ,prod_colours.name ";
}
if(!empty($obj->shteamid)){
	$fd.=" ,post_team.name ";
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
     $cols=" case when sum(case when sizeid=$rw->id then case when status='checkedin' or status='stocktake' or status='regradedin' or status='rebunchingin' then quantity else quantity*-1 end end) is null then '' else sum(case when sizeid=$rw->id then case when status='checkedin' or status='stocktake' or status='regradedin' or status='rebunchingin' then quantity else quantity*-1 end end) end '$rw->name'";
    array_push($aColumns, $cols);
    array_push($sColumns, $rw->name);
    
    $k++;
  }
  //$cols=substr($cols,-1);
  
  	
	if(!empty($obj->shquantity)){
		array_push($sColumns, 'quantity');
		if(!empty($rptgroup)){
			array_push($aColumns, "sum(case when status='checkedin' or status='stocktake' or status='regradedin' or status='rebunchingin' then post_graded.quantity else post_graded.quantity*-1 end) quantity");
		}else{
		array_push($aColumns, "case when status='checkedin' or status='stocktake' or status='regradedin' or status='rebunchingin' then post_graded.quantity else post_graded.quantity*-1 end");
		}

		$k++;
		}


 ?>
 <?php $_SESSION['aColumns']=$aColumns;?>
 <?php $_SESSION['sColumns']=$sColumns;?>
 <?php $_SESSION['join']="$rptjoin";?>
 <?php $_SESSION['sTable']="post_graded";?>
 <?php $_SESSION['sOrder']="";?>
 <?php $_SESSION['sWhere']="$rptwhere";?>
 <?php $_SESSION['sGroup']="$rptgroup";?>
 
 
  $(document).ready(function() {
	 
 	var tbl = $('#tbl').dataTable( {
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
		"sAjaxSource": "../../../modules/server/server/processing.php?sTable=post_graded",
		"fnRowCallback": function( nRow, aaData, iDisplayIndex ) {
			
			$('td:eq(0)', nRow).html(iDisplayIndex+1);
			var num = aaData.length;
			for(var i=1; i<num; i++){
			      if(aaData[2]==''){
				$('td:eq('+i+')', nRow).html('<strong>'+aaData[i]+'</strong>').addClass("group");
			      }
			      else
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
				if(aaData[i][2]!='')
				  total[j] = parseFloat(total[j])+parseFloat(aaData[i][j]);	//alert(parseFloat(aaData[i][j]));	
			  }
			  
			}
			
			for(var i=<?php echo $mnt; ?>; i<total.length;i++){
			  $('th:eq('+i+')', nRow).html(total[i]);
			}
		}
 	} );
 	<?php if(!empty($obj->grteamid) and !empty($obj->gremployeeid)){?>
//  	tbl.rowGrouping({
// 	  iGroupingColumnIndex: 1
//  	}); 
 	<?php }?>
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
<form  action="gradeds.php" method="post" name="graded" >
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Size</td>
				<td>
				<select name='sizeid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$sizes=new Sizes();
				$where="  ";
				$fields="prod_sizes.id, prod_sizes.name, prod_sizes.remarks, prod_sizes.ipaddress, prod_sizes.createdby, prod_sizes.createdon, prod_sizes.lasteditedby, prod_sizes.lasteditedon";
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
				$orderby=" order by name ";
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
				<td><strong>From:</strong><input type='text' id='fromquantity' size='from16' name='fromquantity' value='<?php echo $obj->fromquantity;?>'/>
								<br/><strong>To:</strong><input type='text' id='toquantity' size='to16' name='toquantity' value='<?php echo $obj->toquantity;?>'></td>
			</tr>
			<tr>
				<td>Date Graded</td>
				<td><strong>From:</strong><input type='text' id='fromgradedon' size='16' name='fromgradedon' readonly class="date_input" value='<?php echo $obj->fromgradedon;?>'/>
							<br/><strong>To:</strong><input type='text' id='togradedon' size='16' name='togradedon' readonly class="date_input" value='<?php echo $obj->togradedon;?>'/></td>
			</tr>
			<tr>
				<td>Date Code</td>
				<td><input type='text' size='20' name='datecode' id='datecode' value='<?php echo $obj->datecode; ?>'>
			</tr>
			<tr>
				<td>Employee</td>
				<td><input type='text' size='20' name='employeename' id='employeename' value='<?php echo $obj->employeename; ?>'>
					<input type="hidden" name='employeeid' id='employeeid' value='<?php echo $obj->field; ?>'></td>
			</tr>
			<tr>
				<td>Downsize</td>
				<td><input type='radio' id='downsize' name='downsize' value='0' <?php if($obj->downsize==0){echo "checked";}?>/> No
				    <input type='radio' id='downsize' name='downsize' value='1' <?php if($obj->downsize==1){echo "checked";}?>/> Yes</td>
			</tr>
			<tr>
			  <td>Status</td>
			  <td><select name="status">
				<option value="">Select...</option>
	
				<option value="checkedin" <?php if($obj->status=="checkedin"){echo"selected";}?>>Newly Graded</option>
				<option value="checkedout" <?php if($obj->status=="checkedout"){echo"selected";}?>>Scanning Out</option>
				<option value="stocktake" <?php if($obj->status=="stocktake"){echo"selected";}?>>Stock Take</option>
				<option value="regradedin" <?php if($obj->status=="regradedin"){echo"selected";}?>>Downsizing Back</option>
				<option value="regradedout" <?php if($obj->status=="regradedout"){echo"selected";}?>>Downsizing Out</option>
				<option value="rebunchingin" <?php if($obj->status=="rebunchingin"){echo"selected";}?>>Rebunched In</option>
				<option value="rebunchinout" <?php if($obj->status=="rebunchinout"){echo"selected";}?>>Rebunched Out</option>
				<option value="discarded returns" <?php if($obj->status=="discarded returns"){echo"selected";}?>>Discarded returns</option>
			      </select>
			</tr>
			<tr>
				<td>Variety Colour</td>
				<td>
				<select name='colourid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$colours=new Colours();
				$where="  ";
				$fields="prod_colours.id, prod_colours.name, prod_colours.remarks, prod_colours.ipaddress, prod_colours.createdby, prod_colours.createdon, prod_colours.lasteditedby, prod_colours.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$colours->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($colours->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->colourid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Team</td>
				<td>
				<select name='teamid' class='selectbox'>
				<option value="">Select...</option>
				<?php
				$teams=new Teams();
				$where="  ";
				$fields="post_teams.id, post_teams.name, post_teams.remarks, post_teams.ipaddress, post_teams.createdby, post_teams.createdon, post_teams.lasteditedby, post_teams.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$teams->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($teams->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->teamid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='gremployeeid' value='1' <?php if(isset($_POST['gremployeeid']) ){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='gritemid' value='1' <?php if(isset($_POST['gritemid']) or empty($obj->action)){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='grgradedon' value='1' <?php if(isset($_POST['grgradedon']) or empty($obj->action)){echo"checked";}?>>&nbsp;Graded On</td>
				<td><input type='checkbox' name='grsizeid' value='1' <?php if(isset($_POST['grsizeid']) ){echo"checked";}?>>&nbsp;Size</td>
			<tr>
				<td><input type='checkbox' name='grcolourid' value='1' <?php if(isset($_POST['grcolourid']) ){echo"checked";}?>>&nbsp;Variety Colour</td>
				<td><input type='checkbox' name='grteamid' value='1' <?php if(isset($_POST['grteamid']) ){echo"checked";}?>>&nbsp;Team</td>
		        <tr> 
		                <td><input type='checkbox' name='grgreenhouseid' value='1' <?php if(isset($_POST['grgreenhouseid'])){echo"checked";}?>>&nbsp;Green House</td>
		                <td><input type='checkbox' name='grdatecode' value='1' <?php if(isset($_POST['grdatecode']) or empty($obj->action)){echo"checked";}?>>&nbsp;Date Code</td>
		</table>
		</td>
		</tr>
		<tr>
		<td>&nbsp;
		<!--<table class="tgrid gridd" width="100%" border="0" align="left">
			<tr>
				<th colspan="3"><div align="left"><strong>Fields to Show (For Detailed Reports)</strong>: </div></th>
			</tr>
			<tr>
				<td><input type='checkbox' name='shsizeid' value='1' <?php if(isset($_POST['shsizeid'])){echo"checked";}?>>&nbsp;Size</td>
				<td><input type='checkbox' name='shitemid' value='1' <?php if(isset($_POST['shitemid'])){echo"checked";}?>>&nbsp;Variety</td>
			<tr>
				<td><input type='checkbox' name='shquantity' value='1' <?php if(isset($_POST['shquantity'])){echo"checked";}?>>&nbsp;Quantity</td>
				<td><input type='checkbox' name='shgradedon' value='1' <?php if(isset($_POST['shgradedon'])){echo"checked";}?>>&nbsp;Date Graded</td>
			<tr>
				<td><input type='checkbox' name='shemployeeid' value='1' <?php if(isset($_POST['shemployeeid'])){echo"checked";}?>>&nbsp;Employee</td>
				<td><input type='checkbox' name='shbarcode' value='1' <?php if(isset($_POST['shbarcode'])){echo"checked";}?>>&nbsp;Barcode</td>
			<tr>
				<td><input type='checkbox' name='shremarks' value='1' <?php if(isset($_POST['shremarks'])){echo"checked";}?>>&nbsp;Remarks</td>
				<td><input type='checkbox' name='shstatus' value='1' <?php if(isset($_POST['shstatus'])){echo"checked";}?>>&nbsp;Status</td>
			<tr>
				<td><input type='checkbox' name='shcolourid' value='1' <?php if(isset($_POST['shcolourid'])){echo"checked";}?>>&nbsp;Variety Colour</td>
				<td><input type='checkbox' name='shteamid' value='1' <?php if(isset($_POST['shteamid']) ){echo"checked";}?>>&nbsp;Team</td>
		</table>-->
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
			<?php if($obj->shitemid==1){ ?>
				<th>Product </th>
			<?php } ?>
			<?php if($obj->shdatecode==1){ ?>
				<th>Date Code</th>
			<?php } ?>
			<?php if($obj->shgreenhouseid==1){ ?>
				<th>Green House </th>
			<?php } ?>
			<?php if($obj->shgradedon==1){ ?>
				<th>Date Graded </th>
			<?php } ?>
			<?php if($obj->shteamid==1 ){ ?>
				<th> Team </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1){ ?>
				<th>Employee </th>
			<?php } ?>
			<?php if($obj->shbarcode==1){ ?>
<!-- 				<th>BarCode </th> -->
			<?php } ?>
			<?php if($obj->shremarks==1){ ?>
				<th>Remarks </th>
			<?php } ?>
			<?php if($obj->shstatus==1){ ?>
				<th>Status </th>
			<?php } ?>
			<?php if($obj->shcolourid==1){ ?>
				<th>Colour</th>
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
				<th>Sub Total </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
	<tr>
			<th>#</th>			
			<?php if($obj->shitemid==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shdatecode==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shgreenhouseid==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shgradedon==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shteamid==1 ){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shemployeeid==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shbarcode==1){ ?>
			      <th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shremarks==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shstatus==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
			<?php if($obj->shcolourid==1){ ?>
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
				<th>&nbsp; </th>
			<?php }} ?>
			<?php if($obj->shquantity==1){ ?>
				<th>&nbsp; </th>
			<?php } ?>
		</tr>
	</tfoot>
</div>
</div>
</div>
</div>
</div>
