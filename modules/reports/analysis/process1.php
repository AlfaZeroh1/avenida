<?php
//function drawLineGraph(){
require_once '../config.php';
require_once '../connection.php';

$sql="select * from analysis where type='1' and tableid='$id'";
$gr=mysql_fetch_object(mysql_query($sql));

//$l="select distinct training_topic seriesid from traininghead";
$l=$gr->sql1;
$s=mysql_query($l);
$n=mysql_affected_rows();
$j=0;
$arr="series:[";
while($r=mysql_fetch_object($s)){$j++;
	//$user=mysql_fetch_object(mysql_query("select * from users where id='$r->createdby'"));
	//$sql="select training_date,count(*) amount,training_topic from traininghead where training_topic='$r->seriesid' group by training_topic,training_date";
	$sql=$gr->sql2;
	$sql = str_replace('$r->seriesid',$r->seriesid,$gr->sql2);
	$res=mysql_query($sql);echo mysql_error();
	$num=mysql_affected_rows();
	$arr.="{name:'".$r->seriesid."',data:[";
	$i=0;
	while($row=mysql_fetch_object($res)){
		$i++;
		if($row->amount=='')
			$row->amount=0;
			
		$arr.=$row->amount;
		if($i<$num)
			$arr.=", ";
		
	}
	$arr.="]}";
	if($j==$n)
		$arr.="]";
	else 
		$arr.=",";
}	
	
	$x="[";
	//$ql="select distinct training_date from traininghead";
	$ql=$gr->sql3;
	$rs=mysql_query($ql);
	$nm=mysql_affected_rows();
	$i=0;
	while($rw=mysql_fetch_object($rs)){
		$i++;
		$x.="'".$rw->training_date."'";
		if($i<$nm)
			$x.=", ";
	}
	$x.="]";
	$fd=fopen("data.log","w");
	fwrite($fd,$arr);
	fclose($fd);
	//return $arr;
//}

?>