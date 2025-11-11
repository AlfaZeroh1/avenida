<?php 
require_once("../../../DB.php");
class FleetsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="assets_fleets";

	function persist($obj){
		$sql="insert into assets_fleets(id,assetid,fleetmodelid,year,fleetcolorid,vin,fleettypeid,plateno,engine,fleetfueltypeid,fleetodometertypeid,mileage,lastservicemileage,employeeid,departmentid,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->assetid',$obj->fleetmodelid,'$obj->year','$obj->fleetcolorid','$obj->vin',$obj->fleettypeid,'$obj->plateno','$obj->engine',$obj->fleetfueltypeid,$obj->fleetodometertypeid,'$obj->mileage','$obj->lastservicemileage',$obj->employeeid,$obj->departmentid,'$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update assets_fleets set assetid='$obj->assetid',fleetmodelid=$obj->fleetmodelid,year='$obj->year',fleetcolorid='$obj->fleetcolorid',vin='$obj->vin',fleettypeid=$obj->fleettypeid,plateno='$obj->plateno',engine='$obj->engine',fleetfueltypeid=$obj->fleetfueltypeid,fleetodometertypeid=$obj->fleetodometertypeid,mileage='$obj->mileage',lastservicemileage='$obj->lastservicemileage',employeeid=$obj->employeeid,departmentid=$obj->departmentid,ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from assets_fleets $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from assets_fleets $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

