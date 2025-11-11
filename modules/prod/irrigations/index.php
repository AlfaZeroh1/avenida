<?php
session_start();
require_once("../../../lib.php");
$page_title="Irrigation";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("prod","valves")){?>
	<li><a class="button icon chat" href="../../prod/valves/valves.php">Irrigation Valves</a></li>
	<?php } if(checkSubModule("prod","irrigationtanks")){?>
	<li><a class="button icon chat" href="../../prod/irrigationtanks/irrigationtanks.php">Irrigation Tanks</a></li>	
	<?php } if(checkSubModule("prod","irrigationsystems")){?>
	<li><a class="button icon chat" href="../../prod/irrigationsystems/irrigationsystems.php">Irrigation Systems</a></li>
	<?php } if(checkSubModule("prod","irrigations")){?>
	<li><a class="button icon chat" href="../../prod/irrigations/irrigations.php">Irrigations</a></li>
	<?php }?>
</ul>
<?php
include"../../../foot.php";
?>