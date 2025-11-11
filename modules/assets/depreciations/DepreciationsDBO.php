<?php 
require_once("../../../DB.php");
class DepreciationsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="assets_depreciations";

	function persist($obj){
		$sql="insert into assets_depreciations(id,assetid,depreciatedon,amount,perc,month,year,createdon,createdby,lasteditedon,lasteditedby)
						values('$obj->id',$obj->assetid,'$obj->depreciatedon','$obj->amount','$obj->perc','$obj->month','$obj->year','$obj->createdon','$obj->createdby','$obj->lasteditedon','$obj->lasteditedby')";		
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
		$sql="update assets_depreciations set assetid=$obj->assetid,depreciatedon='$obj->depreciatedon',amount='$obj->amount',perc='$obj->perc',month='$obj->month',year='$obj->year',lasteditedon='$obj->lasteditedon',lasteditedby='$obj->lasteditedby' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from assets_depreciations $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from assets_depreciations $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

