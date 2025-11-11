<?php 
require_once("../../../DB.php");
class ProjectsubcontractorsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="con_projectsubcontractors";

	function persist($obj){
		$sql="insert into con_projectsubcontractors(id,supplierid,projectid,contractno,physicaladdress,scope,value,dateawarded,acceptanceletterdate,contractsignedon,orderdatetocommence,startdate,expectedenddate,actualenddate,liabilityperiodtype,liabilityperiod,remarks,statusid,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->supplierid,$obj->projectid,'$obj->contractno','$obj->physicaladdress','$obj->scope','$obj->value','$obj->dateawarded','$obj->acceptanceletterdate','$obj->contractsignedon','$obj->orderdatetocommence','$obj->startdate','$obj->expectedenddate','$obj->actualenddate','$obj->liabilityperiodtype','$obj->liabilityperiod','$obj->remarks','$obj->statusid','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update con_projectsubcontractors set supplierid=$obj->supplierid,projectid=$obj->projectid,contractno='$obj->contractno',physicaladdress='$obj->physicaladdress',scope='$obj->scope',value='$obj->value',dateawarded='$obj->dateawarded',acceptanceletterdate='$obj->acceptanceletterdate',contractsignedon='$obj->contractsignedon',orderdatetocommence='$obj->orderdatetocommence',startdate='$obj->startdate',expectedenddate='$obj->expectedenddate',actualenddate='$obj->actualenddate',liabilityperiodtype='$obj->liabilityperiodtype',liabilityperiod='$obj->liabilityperiod',remarks='$obj->remarks',statusid='$obj->statusid',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from con_projectsubcontractors $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from con_projectsubcontractors $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

