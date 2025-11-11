<?php
require_once("lib.php");

$arr = 'a:6:{i:0;a:8:{s:2:"id";s:0:"";s:6:"itemid";s:3:"501";s:6:"sizeid";s:0:"";s:8:"sizename";s:0:"";s:8:"itemname";s:8:"BUFFET 5";s:8:"quantity";s:1:"1";s:5:"price";s:3:"800";s:4:"memo";s:0:"";}i:1;a:8:{s:2:"id";s:0:"";s:6:"itemid";s:3:"493";s:6:"sizeid";s:0:"";s:8:"sizename";s:0:"";s:8:"itemname";s:12:"BEEF FRY 1KG";s:8:"quantity";s:1:"1";s:5:"price";s:3:"850";s:4:"memo";s:0:"";}i:2;a:8:{s:2:"id";s:0:"";s:6:"itemid";s:3:"501";s:6:"sizeid";s:0:"";s:8:"sizename";s:0:"";s:8:"itemname";s:8:"BUFFET 5";s:8:"quantity";s:1:"1";s:5:"price";s:3:"800";s:4:"memo";s:0:"";}i:3;a:8:{s:2:"id";s:0:"";s:6:"itemid";s:3:"506";s:6:"sizeid";s:0:"";s:8:"sizename";s:0:"";s:8:"itemname";s:14:"CHEESSE ONIONS";s:8:"quantity";i:2;s:5:"price";s:3:"150";s:4:"memo";s:0:"";}i:4;a:8:{s:2:"id";s:0:"";s:6:"itemid";s:3:"502";s:6:"sizeid";s:0:"";s:8:"sizename";s:0:"";s:8:"itemname";s:8:"BUFFET 6";s:8:"quantity";i:2;s:5:"price";s:3:"900";s:4:"memo";s:0:"";}i:5;a:8:{s:2:"id";s:0:"";s:6:"itemid";s:3:"501";s:6:"sizeid";s:0:"";s:8:"sizename";s:0:"";s:8:"itemname";s:8:"BUFFET 5";s:8:"quantity";s:1:"1";s:5:"price";s:3:"800";s:4:"memo";s:0:"";}}';

$arrs = (unserialize($arr));

echo $x = searchForId(501,$arrs,"itemid");
?>