<?php 
require_once("ParkingslotsDBO.php");
class Parkingslots
{				
	var $SlotID;			
	var $Street_Name;			
	var $X;			
	var $Y;			
	var $Agent_ID;			
	var $parkingslotsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->SlotID=str_replace("'","\'",$obj->SlotID);
		$this->Street_Name=str_replace("'","\'",$obj->Street_Name);
		$this->X=str_replace("'","\'",$obj->X);
		$this->Y=str_replace("'","\'",$obj->Y);
		$this->Agent_ID=str_replace("'","\'",$obj->Agent_ID);
		return $this;
	
	}
	//get SlotID
	function getSlotID(){
		return $this->SlotID;
	}
	//set SlotID
	function setSlotID($SlotID){
		$this->SlotID=$SlotID;
	}

	//get Street_Name
	function getStreet_Name(){
		return $this->Street_Name;
	}
	//set Street_Name
	function setStreet_Name($Street_Name){
		$this->Street_Name=$Street_Name;
	}

	//get X
	function getX(){
		return $this->X;
	}
	//set X
	function setX($X){
		$this->X=$X;
	}

	//get Y
	function getY(){
		return $this->Y;
	}
	//set Y
	function setY($Y){
		$this->Y=$Y;
	}

	//get Agent_ID
	function getAgent_ID(){
		return $this->Agent_ID;
	}
	//set Agent_ID
	function setAgent_ID($Agent_ID){
		$this->Agent_ID=$Agent_ID;
	}

	function add($obj){
		$parkingslotsDBO = new ParkingslotsDBO();
		if($parkingslotsDBO->persist($obj)){
			$this->id=$parkingslotsDBO->id;
			$this->sql=$parkingslotsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$parkingslotsDBO = new ParkingslotsDBO();
		if($parkingslotsDBO->update($obj,$where)){
			$this->sql=$parkingslotsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$parkingslotsDBO = new ParkingslotsDBO();
		if($parkingslotsDBO->delete($obj,$where=""))		
			$this->sql=$parkingslotsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$parkingslotsDBO = new ParkingslotsDBO();
		$this->table=$parkingslotsDBO->table;
		$parkingslotsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$parkingslotsDBO->sql;
		$this->result=$parkingslotsDBO->result;
		$this->fetchObject=$parkingslotsDBO->fetchObject;
		$this->affectedRows=$parkingslotsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->SlotID)){
			$error=" should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
