<?php 
require_once("../../../DB.php");
class FleetmaintenancesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="assets_fleetmaintenances";

	function persist($obj){
		$sql="insert into assets_fleetmaintenances(id,assetid,maintenanceon,startmileage,endmileage,supplierid,purchasemodeid,oiladded,oilcost,fueladded,fuelcost,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->assetid,'$obj->maintenanceon','$obj->startmileage','$obj->endmileage',$obj->supplierid,$obj->purchasemodeid,'$obj->oiladded','$obj->oilcost','$obj->fueladded','$obj->fuelcost','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update assets_fleetmaintenances set assetid=$obj->assetid,maintenanceon='$obj->maintenanceon',startmileage='$obj->startmileage',endmileage='$obj->endmileage',supplierid=$obj->supplierid,purchasemodeid=$obj->purchasemodeid,oiladded='$obj->oiladded',oilcost='$obj->oilcost',fueladded='$obj->fueladded',fuelcost='$obj->fuelcost',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from assets_fleetmaintenances $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from assets_fleetmaintenances $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

