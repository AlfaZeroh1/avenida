<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");

include "../../../head.php";

$page_title="MPESA TRANSACTIONS";

//connect to db
$db=new DB();

$obj = (object)$_POST;

if(empty($obj->action)){
  $obj->fromdate=date("Y-m-d");
  $obj->todate=date("Y-m-d");
}

?>

<script type="text/javascript" charset="utf-8">
 <?php $_SESSION['aColumns']=array('account_number', 'transaction_reference', 'amount', 'first_name','middle_name', 'last_name',  'sender_phone', 'createdon');?>
 <?php $_SESSION['sColumns']=array('account_number', 'transaction_reference', 'amount', 'first_name','middle_name', 'last_name',  'sender_phone', 'createdon');?>
 <?php $_SESSION['join']="  ";?>
 <?php $_SESSION['sTable']="mpesa_paymentss";?>
 <?php $_SESSION['sOrder']=" ";?>
 <?php $_SESSION['sWhere']="";?>
 <?php $_SESSION['sGroup']="";?>
 $(document).ready(function() {
	
 	$('#tbl').dataTable( {
		"sDom": 'T<"H"lfr>t<"F"ip>',
		"oTableTools": {
			"sSwfPath": "../../../media/swf/copy_cvs_xls_pdf.swf"
		},
 		"bJQueryUI": true,
 		"bSort":true,
 		"sScrollY": 500,
 		"iDisplayLength":2000,
		"bJQueryUI": true,
		"bRetrieve":true
 	} );
 } );
 </script>
 
<form action="transactions.php" method="post" name="recon">
 <div>           
                  <strong>Date From:
                  <input class="date_input" name="fromdate" type="text" id="fromdate" value="<?php echo $obj->fromdate; ?>" size="12" readonly="readonly" />
                   &nbsp;&nbsp;To:
                   <input class="date_input" readonly="readonly" name="todate" type="text" id="todate" value="<?php echo $obj->todate; ?>" size="18" />
              
                   &nbsp; <input type="submit" class="btn" name="action" id="action" value="Submit" />
               		&nbsp;&nbsp;&nbsp;                  </strong><?php showError($error); ?></div>
 <div>
 
<table style="clear:both;"  class="table" id="tbl" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>Account</th>
			<th>Ref </th>
			<th>Amount </th>
			<th>Receipted</th>
			<th>Balance</th>
			<th>First Name </th>
			<th>Middle Name</th>
			<th>Last Name </th>
			<th>Tel </th>
			<th>Created On</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	  $query="select * from mpesa_paymentss where date(createdon)>='$obj->fromdate' and date(createdon)<='$obj->todate'";
	  $rs = mysql_query($query);
	  $i=0;
	  while($row=mysql_fetch_object($rs)){$i++;
	    $balance=0;
	    $balance = $row->amount-$row->receipted;
	    
	    $color="";
	    if($balance<=0)
	      $color="green";
	    ?>
	    <tr style="color:<?php echo $color; ?>">
		    <td><?php echo $i; ?></td>
		    <td><?php echo $row->short_code; ?></td>
		    <td><?php echo $row->transaction_reference; ?></td>
		    <td align="right"><?php echo formatNumber($row->amount); ?></td>
		    <td align="right"><?php echo formatNumber($row->receipted); ?></td>
		    <td align="right"><?php echo formatNumber($balance); ?></td>
		    <td><?php echo $row->first_name; ?></td>
		    <td><?php echo $row->middle_name; ?></td>
		    <td><?php echo $row->last_name; ?></td>
		    <td><?php echo $row->sender_phone; ?></td>
		    <td><?php echo $row->createdon; ?></td>
		    <td>
		    <?php if($balance>0){ ?>
		      <a href="../../em/tenantpayments/addtenantpayments_proc.php?receipt=1&transaction=<?php echo $row->transaction_reference; ?>&amount=<?php echo $balance; ?>">Receipt</a>
		    <?php } ?>
		    </td>
	    </tr>
	    <?
	  }
	?>
	
	</tbody>
</table>
<?php
include"../../../foot.php";
?>
