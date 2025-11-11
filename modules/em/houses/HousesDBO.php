<?php 
require_once("../../../DB.php");
class HousesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_houses";

	function persist($obj){
		$sql="insert into em_houses(id,hseno,hsecode,plotid,amount,size,bedrms,floor,elecaccno,wateraccno,hsedescriptionid,deposit,depositmgtfee,depositmgtfeevatable,depositmgtfeevatclasseid,depositmgtfeeperc,vatable,housestatusid,rentalstatusid,chargeable,penalty,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->hseno','$obj->hsecode','$obj->plotid','$obj->amount','$obj->size','$obj->bedrms','$obj->floor','$obj->elecaccno','$obj->wateraccno','$obj->hsedescriptionid','$obj->deposit','$obj->depositmgtfee','$obj->depositmgtfeevatable','$obj->depositmgtfeevatclasseid','$obj->depositmgtfeeperc','$obj->vatable','$obj->housestatusid','$obj->rentalstatusid','$obj->chargeable','$obj->penalty','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_houses set hseno='$obj->hseno',hsecode='$obj->hsecode',plotid='$obj->plotid',amount='$obj->amount',size='$obj->size',bedrms='$obj->bedrms',floor='$obj->floor',elecaccno='$obj->elecaccno',wateraccno='$obj->wateraccno',hsedescriptionid='$obj->hsedescriptionid',deposit='$obj->deposit',depositmgtfee='$obj->depositmgtfee',depositmgtfeevatable='$obj->depositmgtfeevatable',depositmgtfeevatclasseid='$obj->depositmgtfeevatclasseid',depositmgtfeeperc='$obj->depositmgtfeeperc',vatable='$obj->vatable',housestatusid='$obj->housestatusid',rentalstatusid='$obj->rentalstatusid',chargeable='$obj->chargeable',penalty='$obj->penalty',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_houses $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_houses $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

