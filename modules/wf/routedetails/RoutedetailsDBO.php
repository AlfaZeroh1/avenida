<?php 
require_once("../../../DB.php");
class RoutedetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="wf_routedetails";

	function persist($obj){
		$sql="insert into wf_routedetails(id,routeid,levelid,assignmentid,query,squery,systemtaskid,follows,expectedduration,durationtype,approval,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->routeid,$obj->levelid,$obj->assignmentid,'$obj->query','$obj->squery',$obj->systemtaskid,'$obj->follows','$obj->expectedduration','$obj->durationtype','$obj->approval','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update wf_routedetails set routeid=$obj->routeid,levelid=$obj->levelid,assignmentid=$obj->assignmentid,query='$obj->query', squery='$obj->squery',systemtaskid=$obj->systemtaskid,follows='$obj->follows',expectedduration='$obj->expectedduration', approval='$obj->approval', squery='$obj->squery',durationtype='$obj->durationtype',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from wf_routedetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from wf_routedetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

