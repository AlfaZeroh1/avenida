<?php 
require_once("../../../DB.php");
class HouserentingsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_houserentings";

	function persist($obj){
		$sql="insert into em_houserentings(id,houseid,tenantid,rentaltypeid,occupiedon,vacatedon,leasestarts,renewevery,leaseends,increasetype,increaseby,increaseevery,rentduedate,ipaddress,createdby,createdon,lasteditedby,lasteditedon,status)
						values('$obj->id',$obj->houseid,$obj->tenantid,$obj->rentaltypeid,'$obj->occupiedon','$obj->vacatedon','$obj->leasestarts','$obj->renewevery','$obj->leaseends','$obj->increasetype','$obj->increaseby','$obj->increaseevery','$obj->rentduedate','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->status')";		
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
		$sql="update em_houserentings set houseid=$obj->houseid,tenantid=$obj->tenantid,rentaltypeid=$obj->rentaltypeid,occupiedon='$obj->occupiedon',vacatedon='$obj->vacatedon',leasestarts='$obj->leasestarts',renewevery='$obj->renewevery',leaseends='$obj->leaseends',increasetype='$obj->increasetype',increaseby='$obj->increaseby',increaseevery='$obj->increaseevery',rentduedate='$obj->rentduedate',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',status='$obj->status' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_houserentings $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_houserentings $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

