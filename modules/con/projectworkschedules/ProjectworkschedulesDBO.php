<?php 
require_once("../../../DB.php");
class ProjectworkschedulesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="con_projectworkschedules";

	function persist($obj){
		$sql="insert into con_projectworkschedules(id,projectboqid,employeeid,projectweek,week,year,priority,tracktime,reqduration,reqdurationtype,deadline,startdate,starttime,enddate,endtime,duration,durationtype,remind,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->projectboqid,$obj->employeeid,'$obj->projectweek','$obj->week','$obj->year','$obj->priority','$obj->tracktime','$obj->reqduration','$obj->reqdurationtype','$obj->deadline','$obj->startdate','$obj->starttime','$obj->enddate','$obj->endtime','$obj->duration','$obj->durationtype','$obj->remind','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update con_projectworkschedules set projectboqid=$obj->projectboqid,employeeid=$obj->employeeid,projectweek='$obj->projectweek',week='$obj->week',year='$obj->year',priority='$obj->priority',tracktime='$obj->tracktime',reqduration='$obj->reqduration',reqdurationtype='$obj->reqdurationtype',deadline='$obj->deadline',startdate='$obj->startdate',starttime='$obj->starttime',enddate='$obj->enddate',endtime='$obj->endtime',duration='$obj->duration',durationtype='$obj->durationtype',remind='$obj->remind',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from con_projectworkschedules $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from con_projectworkschedules $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

