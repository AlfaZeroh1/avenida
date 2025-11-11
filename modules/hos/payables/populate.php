<?php
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/transactions/Transactions_class.php");

$id = $_GET['id'];
$transactions=new Transactions();
$where=" where id=$id ";
$fields="sys_transactions.id, sys_transactions.name, sys_transactions.amount";
$join="";
$having="";
$groupby="";
$orderby="";
$transactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
$transactions = $transactions->fetchObject;
echo $transactions->amount;
?>