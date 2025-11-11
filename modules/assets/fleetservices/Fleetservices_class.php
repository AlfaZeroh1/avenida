<?php 
require_once("FleetservicesDBO.php");
class Fleetservices
{				
	var $id;			
	var $fleetid;			
	var $description;			
	var $supplierid;			
	var $cost;			
	var $odometer;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $fleetservicesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->fleetid=str_replace("'","\'",$obj->fleetid);
		$this->description=str_replace("'","\'",$obj->description);
		$this->supplierid=str_replace("'","\'",$obj->supplierid);
		$this->cost=str_replace("'","\'",$obj->cost);
		$this->odometer=str_replace("'","\'",$obj->odometer);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get cost
	function getCost(){
		return $this->cost;
	}
	//set cost
	function setCost($cost){
		$this->cost=$cost;
	}

	//get odometer
	function getOdometer(){
		return $this->odometer;
	}
	//set odometer
	function setOdometer($odometer){
		$this->odometer=$odometer;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$fleetservicesDBO = new FleetservicesDBO();
		if($fleetservicesDBO->persist($obj)){
			$this->id=$fleetservicesDBO->id;
			$this->sql=$fleetservicesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$fleetservicesDBO = new FleetservicesDBO();
		if($fleetservicesDBO->update($obj,$where)){
			$this->sql=$fleetservicesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$fleetservicesDBO = new FleetservicesDBO();
		if($fleetservicesDBO->delete($obj,$where=""))		
			$this->sql=$fleetservicesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$fleetservicesDBO = new FleetservicesDBO();
		$this->table=$fleetservicesDBO->table;
		$fleetservicesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$fleetservicesDBO->sql;
		$this->result=$fleetservicesDBO->result;
		$this->fetchObject=$fleetservicesDBO->fetchObject;
		$this->affectedRows=$fleetservicesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->fleetid)){
			$error="Vehicle should be provided";
		}
		else if(empty($obj->description)){
			$error="Description should be provided";
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
