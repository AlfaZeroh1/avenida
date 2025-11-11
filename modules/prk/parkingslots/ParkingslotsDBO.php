<?php 
require_once("../../../DB.php");
class ParkingslotsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prk_parkingslots";

	function persist($obj){
		$sql="insert into prk_parkingslots(SlotID,Street_Name,X,Y,Agent_ID)
						values('$obj->SlotID','$obj->Street_Name','$obj->X','$obj->Y','$obj->Agent_ID')";		
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
		$sql="update prk_parkingslots set SlotID='$obj->SlotID',Street_Name='$obj->Street_Name',X='$obj->X',Y='$obj->Y',Agent_ID='$obj->Agent_ID' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prk_parkingslots $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prk_parkingslots $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

