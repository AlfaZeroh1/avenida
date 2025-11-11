<?php
//function drawLineGraph(){


	$sql="select training_date,count(*) total,training_topic from traininghead group by training_topic,training_date";
	$res=mysql_query($sql);
	$num=mysql_affected_rows();
	
	$arr="[name:'wisedigits',data:[";
	$i=0;
	while($row=mysql_fetch_object($res)){
		$i++;
		if($row->total=='')
			$row->total=0;
			
		$arr.=$row->total;
		if($i<$num)
			$arr.=", ";
		
	}
	$arr.="]]";

	
	$x="[";
	$ql="select distinct training_date from traininghead";
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
	//return $arr;
//}
?>