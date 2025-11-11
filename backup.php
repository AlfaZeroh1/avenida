<?php
session_start();
require_once("DB.php");

$db = new DB();

$name=date("jFY-g-ia");
$filename="/opt/backup/$name.sql";
exec("mysqldump -u $db->user --password=$db->pass $db->database --ignore-table=$db->database.sys_audittrail>$filename");

exec("tar -zcf /opt/backup/$name.sql.tar.gz $filename");

unlink($filename);

?>
