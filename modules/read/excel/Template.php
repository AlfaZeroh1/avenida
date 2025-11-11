<?php
require_once("../../../DB.php");
require_once("../../../lib.php");

require_once 'PHPWord.php';

$PHPWord = new PHPWord();
$db = new DB();

$document = $PHPWord->loadTemplate('today.docx');

$document->setValue('test','Gatheru');

//get income statements by categorys
$query="select c.id, sum(s.value) value, s.periodid from harvest_statements s left join harvest_descriptions d on s.descriptionid=d.id left join harvest_categorys c on c.id=d.categoryid where c.documenttypeid=1 group by c.id, s.periodid";
$res=mysql_query($query);
while($row=mysql_fetch_object($res)){
  $variable = "inccat".$row->id."".$row->periodid;
  $document->setValue($variable, $row->value);
}

$query="select c.id, sum(s.value) value, s.periodid from harvest_statements s left join harvest_descriptions d on s.descriptionid=d.id left join harvest_categorys c on c.id=d.categoryid where c.documenttypeid=2 group by c.id, s.periodid";
$res=mysql_query($query);
while($row=mysql_fetch_object($res)){
  $variable = "fncat".$row->id."".$row->periodid;
  $document->setValue($variable, $row->value);
}

$query="select d.id, sum(s.value) value, s.periodid from harvest_statements s left join harvest_descriptions d on s.descriptionid=d.id left join harvest_categorys c on c.id=d.categoryid where c.documenttypeid=1 group by d.id";
$res=mysql_query($query);
while($row=mysql_fetch_object($res)){
  $variable = "incdesc".$row->id."".$row->periodid;
  $document->setValue($variable, $row->value);
}

$query="select d.id, sum(s.value) value, s.periodid from harvest_statements s left join harvest_descriptions d on s.descriptionid=d.id left join harvest_categorys c on c.id=d.categoryid where c.documenttypeid=2 group by d.id";
$res=mysql_query($query);
while($row=mysql_fetch_object($res)){
  $variable = "fndesc".$row->id."".$row->periodid;
  $document->setValue($variable, $row->value);
}

//get top ten entities by assets
$query="select sg.id, sg.name, sum(s.value) value from harvest_statements s left join harvest_sagas sg on s.sagaid=sg.id left join harvest_descriptions d on s.descriptionid=d.id left join harvest_categorys c on c.id=d.categoryid where c.documenttypeid=2 and d.categoryid in(5,6) and s.periodid=2 group by sg.id order by value desc limit 10";
$res=mysql_query($query);
$i=0;
while($row=mysql_fetch_object($res)){$i++;
  $variable = "entity".$i;
  $document->setValue($variable, $row->name);
  
  $variable = "entityamount".$i;
  $document->setValue($variable, $row->value);
}

$name=date("Y-m-d H:i:s");

$document->save($name.'.docx');

?>