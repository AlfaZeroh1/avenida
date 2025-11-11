<?php
session_start();
require_once("../../../lib.php");
$page_title="Graded";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("post","harvestrejects")){?>
	<li><a class="button icon chat" href="../../post/harvestrejects/harvestrejects.php?reduce=reduce">Cold Store 
	Rejects</a></li>
	<?php }if(checkSubModule("post","graded")){?>
	<li><a class="button icon chat" href="../../post/graded/graded.php?status=stocktake">Cold Store StockTake</a></li>
	<?php }if(checkSubModule("post","graded")){?>
	<li><a class="button icon chat" href="../../post/graded/graded.php?status=checkedout">Cold Store Returns</a></li>
	<?php }if(checkSubModule("pos","itemstocks")){?>
	<li><a class="button icon chat" href="../../pos/itemstocks/itemstocks.php">Cold Store Stocks</a></li>
	<?php } ?>
</ul>
<?php
include"../../../foot.php";
?>