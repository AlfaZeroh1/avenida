<?php 
require_once("FleetaccidentsDBO.php");
class Fleetaccidents
{				
	var $id;			
	var $fleetid;			
	var $description;			
	var $accidentdate;
	var $image;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $fleetaccidentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->fleetid=str_replace("'","\'",$obj->fleetid);
		$this->description=str_replace("'","\'",$obj->description);
		$this->accidentdate=str_replace("'","\'",$obj->accidentdate);
		$this->image=str_replace("'","\'",$obj->image);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get fleetid
	function getFleetid(){
		return $this->fleetid;
	}
	//set fleetid
	function setFleetid($fleetid){
		$this->fleetid=$fleetid;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get accidentdate
	function getAccidentdate(){
		return $this->accidentdate;
	}
	
	//set image
	function setImage($image){
		$this->image=$image;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}

	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	function add($obj){
		$fleetaccidentsDBO = new FleetaccidentsDBO();
		if($fleetaccidentsDBO->persist($obj)){
			$this->id=$fleetaccidentsDBO->id;
			$this->sql=$fleetaccidentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$fleetaccidentsDBO = new FleetaccidentsDBO();
		if($fleetaccidentsDBO->update($obj,$where)){
			$this->sql=$fleetaccidentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$fleetaccidentsDBO = new FleetaccidentsDBO();
		if($fleetaccidentsDBO->delete($obj,$where=""))		
			$this->sql=$fleetaccidentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$fleetaccidentsDBO = new FleetaccidentsDBO();
		$this->table=$fleetaccidentsDBO->table;
		$fleetaccidentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$fleetaccidentsDBO->sql;
		$this->result=$fleetaccidentsDBO->result;
		$this->fetchObject=$fleetaccidentsDBO->fetchObject;
		$this->affectedRows=$fleetaccidentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->fleetid)){
			$error="Vehicle should be provided";
		}
		else if(empty($obj->description)){
			$error="Description should be provided";
		}
		else if(empty($obj->accidentdate)){
			$error="Accident Date should be provided";
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
