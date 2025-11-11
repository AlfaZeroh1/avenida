<?php
session_start();

$obj = (object)$_GET;
$expected = date('Y-m-d',strtotime($obj->start. '+'.$obj->id.' days'));
echo $expected;
?>