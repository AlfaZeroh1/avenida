<?php
session_start();

$page_title="Actions";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<li><a class="button icon chat" href="../../em/clientbanks/clientbanks.php">Client Banks</a></li>
	<li><a class="button icon chat" href="../../em/rentaltypes/rentaltypes.php">Rental Types</a></li>
	<li><a class="button icon chat" href="../../em/housestatuss/housestatuss.php">Unit Status</a></li>
	<li><a class="button icon chat" href="../../em/actions/actions.php">Actions</a></li>
	<li><a class="button icon chat" href="../../em/types/types.php">Property Types</a></li>
	<li><a class="button icon chat" href="../../em/regions/regions.php">Regions</a></li>
	<li><a class="button icon chat" href="../../em/hsedescriptions/hsedescriptions.php">Unit Descriptions</a></li>
	<li><a class="button icon chat" href="../../em/rentalstatuss/rentalstatuss.php">Rental Status</a></li>
	<li><a class="button icon chat" href="../../em/paymentterms/paymentterms.php">Payment Terms</a></li>
	<li><a class="button icon chat" href="../../sys/vatclasses/vatclasses.php">VAT Classes</a></li>
	<li><a class="button icon chat" href="../../sys/config/config.php">Configuration</a></li>
	<li><a class="button icon chat" href="../../sys/paymentmodes/paymentmodes.php">Payment Modes</a></li>
</ul>
<?php
include"../../../foot.php";
?>
