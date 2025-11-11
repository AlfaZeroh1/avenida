<?php
session_start();
require_once("../../../lib.php");
$page_title="Users";
include"../../../head.php";
?>
<ul id="cmd-buttons">
        <?php if(checkSubModule("auth","users")){?>
	<li><a class="button icon chat" href="../../auth/users/users.php">Users</a></li>
	<?php }if(checkSubModule("auth","rules")){?>
	<li><a class="button icon chat" href="../../auth/rules/rules.php">Rules</a></li>
	<?php }if(checkSubModule("auth","roles")){?>
	<li><a class="button icon chat" href="../../auth/roles/roles.php">Roles</a></li>
	<?php }if(checkSubModule("auth","levels")){?>
	<li><a class="button icon chat" href="../../auth/levels/levels.php">Levels</a></li>
	<?php } ?>
</ul>
<?php
include"../../../foot.php";
?>
