<?php
session_start();
require_once("../../../lib.php");
$page_title="Plantings";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("prod","sizes")){?>
	<li><a class="button icon chat" href="../../prod/sizes/sizes.php">Sizes</a></li>
	<?php } if(checkSubModule("prod","colours")){?>
	<li><a class="button icon chat" href="../../prod/colours/colours.php">Colours</a></li>
	<?php } if(checkSubModule("prod","blocks")){?>
	<li><a class="button icon chat" href="../../prod/blocks/blocks.php">Blocks</a></li>
	<?php } if(checkSubModule("prod","types")){?>
	<li><a class="button icon chat" href="../../prod/types/types.php">Genetics</a></li>
	<?php } if(checkSubModule("prod","sections")){?>
	<li><a class="button icon chat" href="../../prod/sections/sections.php">Sections</a></li>
	<?php } if(checkSubModule("prod","varietys")){?>
	<li><a class="button icon chat" href="../../prod/varietys/varietys.php">Varieties</a></li>
	<li><a class="button icon chat" href="../../prod/varietys/varietys1.php">Trials</a></li>
	<?php } if(checkSubModule("prod","greenhouses")){?>
	<li><a class="button icon chat" href="../../prod/greenhouses/greenhouses.php">Green Houses</a></li>
	<?php } if(checkSubModule("prod","greenhousevarietys")){?>
	<li><a class="button icon chat" href="../../prod/areas/areas.php">Areas</a></li>
	<?php } if(checkSubModule("prod","breeders")){?>
	<li><a class="button icon chat" href="../../prod/breeders/index.php">Breeders</a></li>
	<?php } if(checkSubModule("prod","chemicals")){?>
	<li><a class="button icon chat" href="../../prod/chemicals/chemicals.php">Chemicals</a></li>
	<?php } if(checkSubModule("prod","nozzles")){?>
	<li><a class="button icon chat" href="../../prod/nozzles/nozzles.php">Nozzles</a></li>
	<?php } if(checkSubModule("prod","spraymethods")){?>
	<li><a class="button icon chat" href="../../prod/spraymethods/spraymethods.php">Spray Methods</a></li>
	<?php } if(checkSubModule("prod","qualitychecks")){?>
	<li><a class="button icon chat" href="../../prod/qualitychecks/qualitychecks.php">Quality Checks</a></li>
	<?php } if(checkSubModule("prod","rejecttypes")){?>
	<li><a class="button icon chat" href="../../prod/rejecttypes/rejecttypes.php">Reject Types</a></li>	
	<?php } if(checkSubModule("prod","rejects")){?>
	<li><a class="button icon chat" href="../../prod/rejects/rejects.php">Production Rejects</a></li>
	<?php } if(checkSubModule("prod","checkitems")){?>
	<li><a class="button icon chat" href="../../prod/checkitems/checkitems.php">Quality Check Items</a></li>
	<?php } if(checkSubModule("prod","plantings")){?>
	<li><a class="button icon chat" href="../../prod/plantings/plantings.php">Plantings</a></li>
	
	<?php } if(checkSubModule("prod","uproots")){?>
	<li><a class="button icon chat" href="../../prod/uproots/uproots.php">Uproots</a></li>
	<?php } if(checkSubModule("prod","forecastings")){?>
	<li><a class="button icon chat" href="../../prod/forecastings/forecastings.php">Forecastings</a></li>
	<?php } if(checkSubModule("prod","harvests")){?>
	<li><a class="button icon chat" href="../../prod/harvests/barcodegen.php">Generate Barcodes</a></li>
	<?php } if(checkSubModule("prod","fetilizers")){?>
	<li><a class="button icon chat" href="../../prod/fetilizers/fetilizers.php">Fetilizers</a></li>
	<?php } if(checkSubModule("prod","irrigations")){?>
	<li><a class="button icon chat" href="../../prod/irrigations/index.php">Irrigations</a></li>
	<?php } if(checkSubModule("prod","sprayprogrammes")){?>
	<li><a class="button icon chat" href="../../prod/sprayprogrammes/sprayprogrammes.php">Spray Programmes</a></li>
	
	<?php }?>
</ul>
<?php
include"../../../foot.php";
?>
