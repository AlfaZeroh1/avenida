<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../../modules/pos/purchasepayments/Purchasepayments_class.php");
require_once("../../../modules/auth/users/Users_class.php");
require_once("../../../modules/pos/suppliers/Suppliers_class.php");
require_once("../../../modules/sys/paymentmodes/Paymentmodes_class.php");
require_once("../../../modules/fn/banks/Banks_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../../modules/auth/users/login.php");
}

$page_title="Purchasepayments";
//connect to db
$db=new DB();

$obj=(object)$_POST;

include "../../../head.php";

//processing filters
$rptwhere='';
$track=0;
$fds='';
$fd='';
if(!empty($obj->supplierid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" pos_purchasepayments.supplierid='$obj->supplierid'";
	$track++;
}

if(!empty($obj->paymentmodeid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" pos_purchasepayments.paymentmodeid='$obj->paymentmodeid'";
	$track++;
}

if(!empty($obj->bankid)){
	if($track>0)
		$rptwhere.="and";
	else
		$rptwhere.="where";

		$rptwhere.=" pos_purchasepayments.bankid='$obj->bankid'";
	$track++;
}

//Processing Groupings
;$rptgroup='';
$track=0;
if(!empty($obj->grinvoiceno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" invoiceno ";
	$obj->shinvoiceno=1;
	$track++;
}

if(!empty($obj->grinvoceno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" invoceno ";
	$obj->shinvoceno=1;
	$track++;
}

if(!empty($obj->grsupplierid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" supplierid ";
	$obj->shsupplierid=1;
	$track++;
}

if(!empty($obj->gramount)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" amount ";
	$obj->shamount=1;
	$track++;
}

if(!empty($obj->grpaymentmodeid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" paymentmodeid ";
	$obj->shpaymentmodeid=1;
	$track++;
}

if(!empty($obj->grbankid)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" bankid ";
	$obj->shbankid=1;
	$track++;
}

if(!empty($obj->grchequeno)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" chequeno ";
	$obj->shchequeno=1;
	$track++;
}

if(!empty($obj->grpaidon)){
	if($track>0)
		$rptgroup.=", ";
	else
		$rptgroup.=" group by ";

	$rptgroup.=" paidon ";
	$obj->shpaidon=1;
	$track++;
}

//Default shows
?>
<title><?php echo $page_title; ?></title>
<div id="main">
<div id="main-inner">
<div id="content">
<div id="content-inner">
<div id="content-header">
	<div class="page-title"><?php echo $page_title; ?></div>
	<div class="clearb"></div>
</div>
<div id="content-flex">
<div class="buttons"><a class="positive" href="javascript: expandCollapse('boxB','over');" style="vertical-align:text-top;">Open Popup To Filter</a></div>
<div id="boxB" class="sh" style="left: 10px; top: 63px; display: none; z-index: 500;">
<div id="box2"><div class="bar2" onmousedown="dragStart(event, 'boxB')"><span><strong>Choose Criteria</strong></span>
<a href="#" onclick="expandCollapse('boxB','over')">Close</a></div>
<form  action="purchasepayments.php" method="post" name="purchasepayments">
<table width="100%" border="0" align="center">
	<tr>
		<td width="50%" rowspan="2">
		<table class="tgrid gridd" border="0" align="right">
			<tr>
				<td>Supplier Id</td>
				<td>
				<select name='supplierid'>
				<option value="">Select...</option>
				<?php
				$suppliers=new Suppliers();
				$where="  ";
				$fields="pos_suppliers.id, pos_suppliers.code, pos_suppliers.name, pos_suppliers.contact, pos_suppliers.address, pos_suppliers.telephone, pos_suppliers.fax, pos_suppliers.email, pos_suppliers.mobile, pos_suppliers.status, pos_suppliers.createdby, pos_suppliers.createdon, pos_suppliers.lasteditedby, pos_suppliers.lasteditedon, pos_suppliers.ipaddress";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($suppliers->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->supplierid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Paymentmode Id</td>
				<td>
				<select name='paymentmodeid'>
				<option value="">Select...</option>
				<?php
				$paymentmodes=new Paymentmodes();
				$where="  ";
				$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.remarks";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($paymentmodes->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->paymentmodeid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
				<?php
				}
				?>
				</select>
</td>
			</tr>
			<tr>
				<td>Bank Id</td>
				<td>
				<select name='bankid'>
				<option value="">Select...</option>
				<?php
				$banks=new Banks();
				$where="  ";
				$fields="fn_banks.id, fn_banks.name, fn_banks.bankacc, fn_banks.bankbranch, fn_banks.remarks, fn_banks.createdby, fn_banks.createdon, fn_banks.lasteditedby, fn_banks.lasteditedon";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$banks->retrieve($fields,$join,$where,$having,$groupby,$orderby);

				while($rw=mysql_fetch_object($banks->result)){
				?>
					<option value="<?php echo $rw->id; ?>" <?php if($obj->bankid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
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
				<td><input type='checkbox' name='grinvoiceno' value='1' <?php if(isset($_POST['grinvoiceno']) ){echo"checked";}?>>&nbsp;Invoice No</td>
				<td><input type='checkbox' name='grinvoceno' value='1' <?php if(isset($_POST['grinvoceno']) ){echo"checked";}?>>&nbsp;Invoice No</td>
			<tr>
				<td><input type='checkbox' name='grsupplierid' value='1' <?php if(isset($_POST['grsupplierid']) ){echo"checked";}?>>&nbsp;Supplier Id</td>
				<td><input type='checkbox' name='gramount' value='1' <?php if(isset($_POST['gramount']) ){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='grpaymentmodeid' value='1' <?php if(isset($_POST['grpaymentmodeid']) ){echo"checked";}?>>&nbsp;Paymentmode Id</td>
				<td><input type='checkbox' name='grbankid' value='1' <?php if(isset($_POST['grbankid']) ){echo"checked";}?>>&nbsp;Bankid</td>
			<tr>
				<td><input type='checkbox' name='grchequeno' value='1' <?php if(isset($_POST['grchequeno']) ){echo"checked";}?>>&nbsp;Cheque No</td>
				<td><input type='checkbox' name='grpaidon' value='1' <?php if(isset($_POST['grpaidon']) ){echo"checked";}?>>&nbsp;Paid On</td>
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
				<td><input type='checkbox' name='shdocumentno' value='1' <?php if(isset($_POST['shdocumentno']) ){echo"checked";}?>>&nbsp;Document No</td>
				<td><input type='checkbox' name='shinvoiceno' value='1' <?php if(isset($_POST['shinvoiceno']) ){echo"checked";}?>>&nbsp;Invoice No</td>
			<tr>
				<td><input type='checkbox' name='shsupplierid' value='1' <?php if(isset($_POST['shsupplierid']) ){echo"checked";}?>>&nbsp;Supplier Id</td>
				<td><input type='checkbox' name='shamount' value='1' <?php if(isset($_POST['shamount']) ){echo"checked";}?>>&nbsp;Amount</td>
			<tr>
				<td><input type='checkbox' name='shpaymentmodeid' value='1' <?php if(isset($_POST['shpaymentmodeid']) ){echo"checked";}?>>&nbsp;Paymentmode Id</td>
				<td><input type='checkbox' name='shbankid' value='1' <?php if(isset($_POST['shbankid']) ){echo"checked";}?>>&nbsp;Bank Id</td>
			<tr>
				<td><input type='checkbox' name='shchequeno' value='1' <?php if(isset($_POST['shchequeno']) ){echo"checked";}?>>&nbsp;Cheque No</td>
				<td><input type='checkbox' name='shpaidon' value='1' <?php if(isset($_POST['shpaidon']) ){echo"checked";}?>>&nbsp;Paid On</td>
			<tr>
				<td><input type='checkbox' name='shcustomerid' value='1' <?php if(isset($_POST['shcustomerid']) ){echo"checked";}?>>&nbsp;Customer Id</td>
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
<table style="clear:both;"  class="tgrid display" id="example" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<?php if($obj->shdocumentno==1 ){ ?>
				<th>Document No. </th>
			<?php } ?>
			<?php if($obj->shinvoiceno==1 ){ ?>
				<th>Invoive No. </th>
			<?php } ?>
			<?php if($obj->shsupplierid==1 ){ ?>
				<th>Supplier </th>
			<?php } ?>
			<?php if($obj->shamount==1 ){ ?>
				<th>Amount </th>
			<?php } ?>
			<?php if($obj->shpaymentmodeid==1 ){ ?>
				<th>Payment Mode </th>
			<?php } ?>
			<?php if($obj->shbankid==1 ){ ?>
				<th>Bank </th>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<th>Cheque No. </th>
			<?php } ?>
			<?php if($obj->shpaidon==1 ){ ?>
				<th>Paid On </th>
			<?php } ?>
			<?php if($obj->shcustomerid==1 ){ ?>
				<th> </th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php
		$i=0;
		$purchasepayments=new Purchasepayments();
		$fields="pos_purchasepayments.id, pos_purchasepayments.documentno, pos_purchasepayments.invoiceno, pos_suppliers.name as supplierid, pos_purchasepayments.amount, sys_paymentmodes.name as paymentmodeid, fn_banks.name as bankid, pos_purchasepayments.chequeno, pos_purchasepayments.paidon, pos_purchasepayments.offsetid, pos_purchasepayments.createdby, pos_purchasepayments.createdon, pos_purchasepayments.lasteditedby, pos_purchasepayments.lasteditedon, pos_purchasepayments.ipaddress".$fds.$fd;
		$join=" left join pos_suppliers on pos_purchasepayments.supplierid=pos_suppliers.id  left join sys_paymentmodes on pos_purchasepayments.paymentmodeid=sys_paymentmodes.id  left join fn_banks on pos_purchasepayments.bankid=fn_banks.id ";
		$having="";
		$where= " $rptwhere";
		$groupby= " $rptgroup";
		$orderby="";
		$purchasepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$purchasepayments->result;
		while($row=mysql_fetch_object($res)){
		$i++;
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<?php if($obj->shdocumentno==1 ){ ?>
				<td><?php echo $row->documentno; ?></td>
			<?php } ?>
			<?php if($obj->shinvoiceno==1 ){ ?>
				<td><?php echo $row->invoiceno; ?></td>
			<?php } ?>
			<?php if($obj->shsupplierid==1 ){ ?>
				<td><?php echo $row->supplierid; ?></td>
			<?php } ?>
			<?php if($obj->shamount==1 ){ ?>
				<td><?php echo $row->amount; ?></td>
			<?php } ?>
			<?php if($obj->shpaymentmodeid==1 ){ ?>
				<td><?php echo $row->paymentmodeid; ?></td>
			<?php } ?>
			<?php if($obj->shbankid==1 ){ ?>
				<td><?php echo $row->bankid; ?></td>
			<?php } ?>
			<?php if($obj->shchequeno==1 ){ ?>
				<td><?php echo $row->chequeno; ?></td>
			<?php } ?>
			<?php if($obj->shpaidon==1 ){ ?>
				<td><?php echo $row->paidon; ?></td>
			<?php } ?>
			<?php if($obj->shcustomerid==1 ){ ?>
				<td><?php echo $row->customerid; ?></td>
			<?php } ?>
		</tr>
	<?php 
	}
	?>
	</tbody>
</div>
</div>
</div>
</div>
</div>
