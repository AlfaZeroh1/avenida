<?php
session_start();

$page_title="Config";
require_once("../../../lib.php");
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<!--<li><a class="button icon chat" href="../../em/clientbanks/clientbanks.php">Client Banks</a></li>
	<li><a class="button icon chat" href="../../em/rentaltypes/rentaltypes.php">Rental Types</a></li>
	<li><a class="button icon chat" href="../../em/housestatuss/housestatuss.php">Unit Status</a></li>
	<li><a class="button icon chat" href="../../em/actions/actions.php">Actions</a></li>
	<li><a class="button icon chat" href="../../em/types/types.php">Property Types</a></li>
	<li><a class="button icon chat" href="../../em/regions/regions.php">Regions</a></li>
	<li><a class="button icon chat" href="../../em/hsedescriptions/hsedescriptions.php">Unit Descriptions</a></li>
	<li><a class="button icon chat" href="../../em/rentalstatuss/rentalstatuss.php">Rental Status</a></li>
	<li><a class="button icon chat" href="../../em/paymentterms/paymentterms.php">Payment Terms</a></li>-->
	<?php if(checkSubModule("sys","vatclasses")){?>
	<li><a class="button icon chat" href="../../sys/vatclasses/vatclasses.php">VAT Classes</a></li>
	<?php } if(checkSubModule("sys","config")){?>
	<li><a class="button icon chat" href="../../sys/config/config.php">Configurations</a></li>
	<?php } if(checkSubModule("sys","ipaddress")){?>
	<li><a class="button icon chat" href="../../sys/ipaddress/ipaddress.php">IP Configurations</a></li>
	<?php } if(checkSubModule("sys","currencys")){?>
	<li><a class="button icon chat" href="../../sys/currencys/currencys.php">Currencies</a></li>
	<?php } if(checkSubModule("sys","currencyrates")){?>
	<li><a class="button icon chat" href="../../sys/currencyrates/currencyrates.php">Currency Rates</a></li>
	<?php } if(checkSubModule("sys","margins")){?>
	<li><a class="button icon chat" href="../../sys/currencies/banks.php"> banks</a></li>
 	<?php } if(checkSubModule("pm","tasks")){?>
	<li><a class="button icon chat" href="../../pm/tasks/tasks.php">Tasks</a></li>
	<?php } if(checkSubModule("sys","branches")){?>
	<li><a class="button icon chat" href="../../sys/branches/branches.php">Selling Points</a></li>
	<li><a class="button icon chat" href="../../sys/branchcategorys/branchcategorys.php">Branch Categorys</a></li>
	<?php }?>
	<!--<li><a class="button icon chat" href="../../sys/genders/genders.php">Genders</a></li>
	<li><a class="button icon chat" href="../../sys/nationalitys/nationalitys.php">Nationalities</a></li>
	<li><a class="button icon chat" href="../../sys/notifications/notifications.php">Notifications</a></li>
	<li><a class="button icon chat" href="../../sys/paymentmodes/paymentmodes.php">Payment Modes</a></li>
	<li><a class="button icon chat" href="../../sys/purchasemodes/purchasemodes.php">Purchase Modes</a></li>
	<li><a class="button icon chat" href="../../sys/subregions/subregions.php">Sub-Regions</a></li>
	<li><a class="button icon chat" href="../../sys/salemodes/salemodes.php">Sale Modes</a></li>-->
	
</ul>
<?php
include"../../../foot.php";
?>
