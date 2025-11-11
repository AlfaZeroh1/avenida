<?php
session_start();
require_once("../../../DB.php");

$db = new DB();

$name="stocktake.".date("jFY-g-ia");
$filename="/opt/mysql/backup/$name.sql";
exec("mysqldump -u $db->user --password=$db->pass $db->database pos_items pos_itemstocks>$filename");

exec("tar -zcf /opt/mysql/backup/$name.sql.tar.gz $filename");

unlink($filename);

include("truncate.php");

?>