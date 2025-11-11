<?php 
require_once("../../../DB.php");
class GreenhousevarietysDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prod_greenhousevarietys";

	function persist($obj){
		$sql="insert into prod_greenhousevarietys(id,greenhouseid,varietyid,headsize,employeeid,breederid,area,plants,plantedon,noofbeds,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->greenhouseid,$obj->varietyid,'$obj->headsize',$obj->employeeid,$obj->breederid,'$obj->area','$obj->plants','$obj->plantedon','$obj->noofbeds','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update prod_greenhousevarietys set greenhouseid=$obj->greenhouseid,varietyid=$obj->varietyid,headsize='$obj->headsize',employeeid=$obj->employeeid,breederid=$obj->breederid,area='$obj->area',plants='$obj->plants',plantedon='$obj->plantedon',noofbeds='$obj->noofbeds',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql; //echo $prod_greenhousevarietys->sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prod_greenhousevarietys $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prod_greenhousevarietys $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

