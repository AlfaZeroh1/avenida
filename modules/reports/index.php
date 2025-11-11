<?php
session_start();

$page_title="Reports";
include"../../header.php";
?>
<div id="TabbedPanels1" class="TabbedPanels">
	<ul class="TabbedPanelsTabGroup">
		<li class="TabbedPanelsTab" tabindex="0">Reports</li>
	</ul>
<div class="TabbedPanelsContentGroup">
	<div class="TabbedPanelsContent">
		<div class="rptBox"><h4>  Reports</h4>
			<ul class="rptList" style="float:left;">
				<li><a href="javascript:poptastic('results/results.php',700,1020);">Results</a></li>
			</ul>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>
</div>
<?php
include"../../footer.php";
?>
