<?php
session_start();
require_once("../../../lib.php");
$page_title="Graded";
include"../../../head.php";
?>
<ul id="cmd-buttons">
	<?php if(checkSubModule("post","teams")){?>
	<li><a class="button icon chat" href="../../post/teams/teams.php">Teams</a></li>
	<?php }if(checkSubModule("post","teamroles")){?>
	<li><a class="button icon chat" href="../../post/teamroles/teamroles.php">Team Roles</a></li>
	<?php }if(checkSubModule("post","teammembers")){?>
	<li><a class="button icon chat" href="../../post/teammembers/teammembers.php">Team Members</a></li>

	
	
	
	<?php } ?>
</ul>
<?php
include"../../../foot.php";
?>