<?php 
require_once("../../../DB.php");
class SprayprogrammesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prod_sprayprogrammes";

	function persist($obj){
		$sql="insert into prod_sprayprogrammes(id,areaid,varietyid,chemicalid,ingredients,quantity,watervol,blockid,greenhouseid,nozzleid,target,spraymethodid,spraydate,time,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->areaid,$obj->varietyid,$obj->chemicalid,'$obj->ingredients','$obj->quantity','$obj->watervol',$obj->blockid,'$obj->greenhouseid',$obj->nozzleid,'$obj->target',$obj->spraymethodid,'$obj->spraydate','$obj->time','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";	//echo $sql;	
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
		$sql="update prod_sprayprogrammes set areaid=$obj->areaid,varietyid=$obj->varietyid,chemicalid=$obj->chemicalid,ingredients='$obj->ingredients',quantity='$obj->quantity',watervol='$obj->watervol',blockid=$obj->blockid,greenhouseid=$obj->greenhouseid,nozzleid=$obj->nozzleid,target='$obj->target',spraymethodid=$obj->spraymethodid,spraydate='$obj->spraydate',time='$obj->time',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prod_sprayprogrammes $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prod_sprayprogrammes $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

