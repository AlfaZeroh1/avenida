<?php
session_start();
require_once("../../../lib.php");
$page_title="Sales";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("pos","departments")){?>
	<li><a class="button icon chat" href="../../pos/departments/departments.php">Product Depts</a></li>
	<?php }if(checkSubModule("pos","categorys")){?>
	<li><a class="button icon chat" href="../../pos/categorys/categorys.php">Product Categories</a></li>
	<?php }if(checkSubModule("pos","sizes")){?>
	<li><a class="button icon chat" href="../../pos/sizes/sizes.php">Product Sizes</a></li>
	<?php }if(checkSubModule("pos","colours")){?>
	<li><a class="button icon chat" href="../../pos/colours/colours.php">Product Colours</a></li>
	<?php }if(checkSubModule("pos","items")){?>
	<li><a class="button icon chat" href="../../pos/items/items.php">Products</a></li>
	
	
	<?php } ?>
</ul>
<?php
include"../../../foot.php";
?>