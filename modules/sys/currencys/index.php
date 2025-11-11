<?php
session_start();
require_once("../../../lib.php");

$page_title="Generaljournals";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("sys","acctypes")){?>
	<!--<li><a class="button icon chat" href="../../sys/acctypes/acctypes.php">Account Types</a></li>-->
	<li><a class="button icon chat" href="../../fn/expenses/expenses.php">Expense List</a></li>
	<li><a class="button icon chat" href="../../fn/liabilitys/liabilitys.php">Liability List</a></li>
	<?php }if(checkSubModule("fn","incomes")){?>
	<li><a class="button icon chat" href="../../fn/incomes/incomes.php">Income List</a></li>
	<?php }if(checkSubModule("fn","expensetypes")){?>
	<li><a class="button icon chat" href="../../fn/expensetypes/expensetypes.php">Expense Types</a></li>
	<?php }if(checkSubModule("fn","expenses")){?>
	<li><a class="button icon chat" href="../../inv/categorys/categorys.php">Categories List</a></li>
	<?php }if(checkSubModule("fn","banks")){?>
	<li><a class="button icon chat" href="../../fn/banks/banks.php">Banks</a></li>
	<?php }if(checkSubModule("sys","currencys")){?>
	<li><a class="button icon chat" href="../../sys/currencys/currencys.php">Currencies</a></li>
	<?php }if(checkSubModule("sys","currencyrates")){?>
	<li><a class="button icon chat" href="../../sys/currencyrates/currencyrates.php">Currency Rates</a></li><?php }if(checkSubModule("fn","imprestaccounts")){?>
	<li><a class="button icon chat" href="../../fn/imprestaccounts/imprestaccounts.php">Imprest Accounts</a></li>
	
	<?php }?>
</ul>
<?php
include"../../../foot.php";
?>