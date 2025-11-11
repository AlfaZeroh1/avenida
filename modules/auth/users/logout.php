<?
session_start();
include"../../../lib.php";

session_destroy();

redirect("login.php");

?>