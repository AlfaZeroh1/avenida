<?php
session_start();
require_once("../../../lib.php");
$page_title="Plantings";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("prod","breeders")){?>
	<li><a class="button icon chat" href="../../prod/breeders/breeders.php">Breeders</a></li>
	<?php } if(checkSubModule("prod","breederdeliverys")){?>
	<li><a class="button icon chat" href="../../prod/breederdeliverys/breederdeliverys.php">Breeder Deliveries</a></li>



<?php }?>
</ul>
<?php
include"../../../foot.php";
?>