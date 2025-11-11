<?php
session_start();
require_once "../../../lib.php";
require_once '../../../DB.php';

$db = new DB();

if(empty($_SESSION['userid'])){;
redirect("../../../modules/auth/users/login.php");
}

$page_title="Reports";

include"../../../head.php";
?>
<div class="container" style="margin-top:;">
<div class="panel with-nav-tabs panel-default">
 <div class="panel-heading">
  <ul class="nav nav-tabs">
                
		 <?php if(modularAuthR(2,$_SESSION['level'])){?>
		<li><a href="#tabs-4" data-toggle="tab">HRM</a></li>
		<?php }?>
		<?php if(modularAuthR(11,$_SESSION['level'])){?>
		<li><a href="#tabs-3" data-toggle="tab">SALES</a></li>
		<?php }?>
		 <?php if(modularAuthR(25,$_SESSION['level'])){?>
		<li><a href="#tabs-6" data-toggle="tab">PROCUREMENT</a></li>
		<?php }?>
		 <?php if(modularAuthR(6,$_SESSION['level'])){?>
		<li><a href="#tabs-7" data-toggle="tab">INVENTORY</a></li>
		<?php }?>
		 <?php if(modularAuthR(5,$_SESSION['level'])){?>
		<li><a href="#tabs-8" data-toggle="tab">FINANCE</a></li>
		<?php }?>
		 <?php if(modularAuthR(1,$_SESSION['level'])){?>
		 <li><a href="#tabs-9" data-toggle="tab">PAYROLL</a></li>
		 <?php }?>
		 <?php if(modularAuthR(4,$_SESSION['level'])){?>
		  <li><a href="#tabs-10" data-toggle="tab">ADMINISTRATOR</a></li>
                <?php }?>
	  </ul>
	 </div>
    
    <div class="panel-body">
<div class="tab-content">
    
    <?php if(modularAuthR(11,$_SESSION['level'])){?>
    <div class="tab-pane" id="tabs-3" style="min-height:420px;">
    <ul>
				<?php if(checkSubModule("pos","orders")){?>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/orders/orders.php',700,1020);">Orders</a></li>
				<?php } if(checkSubModule("pos","returninwards")){?>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/returninwards/returninwards.php',700,1020);">Credit Notes</a></li>
				<?php } if(checkSubModule("pos","confirmedorders")){?>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/confirmedorders/confirmedorders.php',700,1020);">Confirmed Orders</a></li>
				<?php } if(checkSubModule("pos","confirmedorders")){?>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/confirmedorders/confirmedorderss.php',700,1020);">Confirmed Order Formatted</a></li>
				<?php } if(checkSubModule("pos","packinglists")){?>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/packinglists/packinglists.php',700,1020);">Packing Lists</a></li>
				<?php } if(checkSubModule("pos","confirmedorders")){?>
				<li><a class="button icon chat" href="javascript:poptastic('../../../modules/pos/confirmedorders/confirmedorders.php?report=1',700,1020);">Packing Lists Summary</a></li>
				<?php } if(checkSubModule("pos","itemstocks")){?>
<!-- 				<li><a class="button icon chat" href="javascript:poptastic('../../pos/itemstocks/itemstocks.php',700,1020);">Cold store  Report</a></li> -->
				<!--<li><a class="button icon chat" href="javascript:poptastic('../../pos/invoices/invoices.php',700,1020);">Invoices</a></li>-->
				<?php } if(checkSubModule("pos","invoices")){?>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/invoices/invoices.php',700,1020);">Invoice Details</a></li>
				<li><a class="button icon chat" href="javascript:poptastic('../../pos/returns/returns.php',700,1020);">Returns Reports</a></li>
				<?php } ?>
			</ul>
				
			
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
     <?php }?>
    
     <div class="tab-pane active" id="tabs-4" style="min-height:420px;">
    <ul>
			<?php if(checkSubModule("hrm","employees")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employees/employees.php',700,1020);">Employees</a></li>
    			<?php } if(checkSubModule("hrm","employeedocuments")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeedocuments/employeedocuments.php',700,1020);">Documents</a></li>
    			<?php } if(checkSubModule("hrm","employeequalifications")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeequalifications/employeequalifications.php',700,1020);">Qualifications</a></li>
    			<?php } if(checkSubModule("hrm","employeecontracts")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeecontracts/employeecontracts.php',700,1020);">Contracts</a></li>
    			<!--<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeeinsurances/employeeinsurances.php',700,1020);">Insurances</a></li>-->
    			<?php } if(checkSubModule("hrm","employeedisplinarys")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeedisplinarys/employeedisplinarys.php',700,1020);">Discplinaries</a></li>
    			<?php } if(checkSubModule("hrm","employeeclockings")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeeclockings/employeeclockings.php',700,1020);">Clockings</a></li>
			<?php } ?>
			</ul>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
      
    <div class="tab-pane" id="tabs-6" style="min-height:420px;">
    			<ul>
    			<?php if(checkSubModule("proc","requisitions")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../proc/requisitions/requisitions.php',700,1020);">Requisitions</a></li>
    			<?php }if(checkSubModule("proc","requisitions")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../proc/requisitions/requisitionss.php',700,1020);">Requisitions Formatted</a></li>
    			<?php } if(checkSubModule("proc","purchaseorders")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../proc/purchaseorders/purchaseorders.php',700,1020);">L.P.O</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../proc/purchaseorders/summarisedpurchaseorders.php',700,1020);">Summarised Proc Report</a></li>
    			<?php } if(checkSubModule("proc","empdeliverynotesloyeeclockings")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../proc/deliverynotes/deliverynotes.php',700,1020);">Delivery notes</a></li>
    			<?php } if(checkSubModule("proc","supplieritems")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../proc/supplieritems/supplieritems.php',700,1020);">Supplier Items</a></li>
    			<?php } if(checkSubModule("proc","suppliers")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../proc/suppliers/suppliers.php',700,1020);">Supplier Accounts</a></li>
    			<?php } ?>

			</ul>
    		<div style="clear:both;"></div>
    		
    		</div><!-- TEnd -->
    		   
    		<div class="tab-pane" id="tabs-7" style="min-height:420px;">
    			<ul>
    			<?php if(checkSubModule("proc","purchaseorders")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../proc/purchaseorders/purchaseorders.php',700,1020);">L.P.O</a></li>
    			
    			<?php } if(checkSubModule("inv","items")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/items/items.php',700,1020);">Items Report </a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/branchstocks/branchstocks.php',700,1020);">Stocks</a></li>  
    			<?php } if(checkSubModule("inv","reorderlevel")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/reorderlevel/items.php',700,1020);">Reorder Level Report </a></li>
    			<?php } if(checkSubModule("inv","items")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/outofstock/items.php',700,1020);">Out of Stock Report </a></li>
    			<?php } if(checkSubModule("proc","inwards")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../proc/inwards/inwards.php',700,1020);">GRN</a></li>
    			<?php } if(checkSubModule("inv","issuance")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/issuance/issuance.php',700,1020);">Issuance</a></li>    		
    			<?php } if(checkSubModule("inv","purchaseorders")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/purchaseorders/purchaseorders.php',700,1020);">Purchase Orders Report </a></li>	
			<?php } if(checkSubModule("inv","purchases")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../inv/purchases/purchases.php',700,1020);">Purchases Report </a></li>
			<?php } if(checkSubModule("inv","requisitions")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../inv/requisitions/requisitions.php',700,1020);">Requisition Report 
			</a></li>
			<?php } if(checkSubModule("fn","suppliers")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/suppliers/suppliers.php',700,1020);">Suppliers Report </a></li>
			<?php } if(checkSubModule("inv","returnoutwards")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../inv/returnoutwards/returnoutwards.php',700,1020);">Returns Report </a></li>
			<?php } if(checkSubModule("inv","returnnotes")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../inv/returnnotes/returnnotes.php',700,1020);">Return Notes Report </a></li>
			<?php } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals.php?acctype=30&filter=true&balance=true',700,1020);">Supplier Accounts</a></li>
			<?php } ?>
			</ul>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
       
    
     <div class="tab-pane" id="tabs-8" style="min-height:420px;">
    			<ul>
    			<?php if(checkSubModule("fn","inctransactions")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/inctransactions/inctransactions.php',700,1020);">Incomes</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../inv/purchasevat/vats.php',700,1020);">Vat Report</a></li>
    			<li><a class="button icon chat" href="javascript:poptastic('../../pos/sales/sales.php',700,1020);">Local Sales</a></li>
    			<?php  } if(checkSubModule("fn","exptransactions")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/exptransactions/exptransactions.php',700,1020);">Expenses</a></li>
    			<?php  } if(checkSubModule("fn","supplierpayments")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/supplierpayments/supplierpayments.php',700,1020);">Supplier 
    			Payments</a></li>
    			<?php  } if(checkSubModule("fn","customerpayments")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/customerpayments/customerpayments.php',700,1020);">Customer Payments</a></li>
    			<?php  } if(checkSubModule("fn","cashrequisitions")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/cashrequisitions/cashrequisitions.php',700,1020);">Cash Requisitions</a></li>
    			<?php  } if(checkSubModule("fn","imprests")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/imprests/imprests.php',700,1020);">Imprests</a></li>
    			<?php  } if(checkSubModule("fn","currencyrates")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/currencyrates/currencyrates.php',700,1020);">Currency Rates</a></li>
    			<?php  } if(checkSubModule("fn","impresttransactions")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/impresttransactions/impresttransactions.php',700,1020);">Imprest Transactions</a></li>
    			<!--<?php  } if(checkSubModule("fn","generaljournalaccounts")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournalaccounts/generaljournalaccounts.php',700,1020);">Journal Accounts</a></li>-->
    			<?php  } if(checkSubModule("fn","generaljournals")){?>
    			<?php if($_SESSION['SEPARATE_FINANCES']=="true"){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals.php?grp=1&class=A',700,1020);">Chart of Accounts</a></li>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<!--<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals.php?grp=1&class=B',700,1020);">Property Chart of Accounts</a></li>-->
			<?php }else{?>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals.php?grp=1&tb=true',700,1020);">Chart of Accounts</a></li>
			<?php }?>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/tb.php?grp=true',700,1020);">Trial Balance</a></li>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/tb.php?tb=true',700,1020);">Detailed Trial Balance</a></li>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals.php?acctypeid=8&balance=true',700,1020);">Banks</a></li>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals2.php?acctype=29&filter=true&balance=true',700,1020);">Customer Accounts</a></li>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals2.php?acctype=30&filter=true&balance=true',700,1020);">Supplier Accounts</a></li>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournalss2.php?acctype=30&filter=true&balance=true',700,1020);">Summarized Supplier Accounts</a></li>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals4.php?acctype=30&filter=true&balance=true',700,1020);">Supplier Summary</a></li>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals3.php?acctype=29&filter=true&balance=true',700,1020);">Customer Payments</a></li>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../fn/generaljournals/generaljournals3.php?acctype=30&filter=true&balance=true',700,1020);">Supplier Payments</a></li>
			<li><a class="button icon chat" href="../../inv/purchasevat/purchasevats.php">Purchases Vat</a></li>
			<li><a class="button icon chat" href="../../pos/salesvat/salesvats.php">Sales Vat</a></li>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="../../fn/generaljournals/income.php">Income Statement</a></li>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="../../fn/generaljournals/dtincome.php">Detailed Income Statement</a></li>
			<?php  } if(checkSubModule("fn","generaljournals")){?>
			<li><a class="button icon chat" href="../../fn/generaljournals/financial.php">Financial Statement</a></li>
			<?php } ?>
			</ul>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
    
    
     <div class="tab-pane" id="tabs-9" style="min-height:420px;">
    			<ul>
    			<?php if(checkSubModule("hrm","employeepayments")){?>
    			<li><a class="button icon chat" 
    			href="javascript:poptastic('../../hrm/employeepayments/employeepayments.php',700,1020);">Employee Payments</a></li>
    			<?php  } if(checkSubModule("hrm","employeeallowances")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeeallowances/employeeallowances.php',700,1020);">Employee Allowances</a></li>
    			<?php  } if(checkSubModule("hrm","employeedeductions")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeedeductions/employeedeductions.php',700,1020);">Employee Deductions</a></li>
    			<?php  } if(checkSubModule("hrm","employeesurchages")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeesurchages/employeesurchages.php',700,1020);">Employee Surchages</a></li>
    			<?php  } if(checkSubModule("hrm","employeeloans")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeeloans/employeeloans.php',700,1020);">Employee Loans</a></li>
    			<?php  } if(checkSubModule("hrm","employeepaiddeductions")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeepaiddeductions/employeepaiddeductions.php',700,1020);">Employee Paid Deductions</a></li>
    			<?php  } if(checkSubModule("hrm","employeeovertimes")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeeovertimes/employeeovertimes.php',700,1020);">Employee overtimes</a></li>
    			<?php  } if(checkSubModule("hrm","employeepaidallowances")){?>
    			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeepaidallowances/employeepaidallowances.php',700,1020);">Employee Paid Allowances</a></li>
			<?php  } if(checkSubModule("hrm","employeepaidsurchages")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/employeepaidsurchages/employeepaidsurchages.php',700,1020);">Employee Paid Surchages</a></li>
			<li><a class="button icon chat" href="javascript:poptastic('../../hrm/payrolcontrolaccount/payrolcontrolaccount.php',700,1020);">Payrol Control Account</a></li>
			<?php } ?>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
    
       
    
     <div class="tab-pane" id="tabs-10" style="min-height:420px;">
    			<ul>
    			
			<?php if(checkSubModule("pm","tasks")){?>
			<li><a class="button icon chat" href="javascript:poptastic('../../pm/tasks/tasks.php',700,1020);">Tasks</a></li>
			<?php } ?>
    		<div style="clear:both;"></div>
    </div><!-- TEnd -->
    
       
    
 
     		<div style="clear:both;"></div>
<?php
include"../../../foot.php";
?>
