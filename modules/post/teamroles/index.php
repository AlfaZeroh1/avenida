<?php
session_start();
require_once("../../../lib.php");
$page_title="Barcodes";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("post","graded")){?>
	<li><a class="button icon chat" href="../../post/graded/barcodegen.php">Generate Employee Barcodes</a></li>
	<?php }if(checkSubModule("post","graded")){?>
	<li><a class="button icon chat" href="../../post/graded/rejbarcodegen.php">Generate Reject Barcodes</a></li>
	<?php }if(checkSubModule("post","graded")){?>
	<li><a class="button icon chat" href="../../post/graded/varbarcodegen.php">Generate Variety Barcodes</a></li>
	
	
	
	<?php } ?>
</ul>
<?php
include"../../../foot.php";
?>