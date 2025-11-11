<?php 
require_once("FleetfuelingDBO.php");
class Fleetfueling
{				
	var $id;			
	var $fleetid;			
	var $quantity;			
	var $cost;			
	var $fueledon;			
	var $employeeid;			
	var $documentno;			
	var $startodometer;			
	var $endodometer;			
	var $destination;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $fleetfuelingDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->fleetid))
			$obj->fleetid='NULL';
		$this->fleetid=$obj->fleetid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->cost=str_replace("'","\'",$obj->cost);
		$this->fueledon=str_replace("'","\'",$obj->fueledon);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->startodometer=str_replace("'","\'",$obj->startodometer);
		$this->endodometer=str_replace("'","\'",$obj->endodometer);
		$this->destination=str_replace("'","\'",$obj->destination);
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

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get cost
	function getCost(){
		return $this->cost;
	}
	//set cost
	function setCost($cost){
		$this->cost=$cost;
	}

	//get fueledon
	function getFueledon(){
		return $this->fueledon;
	}
	//set fueledon
	function setFueledon($fueledon){
		$this->fueledon=$fueledon;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get startodometer
	function getStartodometer(){
		return $this->startodometer;
	}
	//set startodometer
	function setStartodometer($startodometer){
		$this->startodometer=$startodometer;
	}

	//get endodometer
	function getEndodometer(){
		return $this->endodometer;
	}
	//set endodometer
	function setEndodometer($endodometer){
		$this->endodometer=$endodometer;
	}

	//get destination
	function getDestination(){
		return $this->destination;
	}
	//set destination
	function setDestination($destination){
		$this->destination=$destination;
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
		$fleetfuelingDBO = new FleetfuelingDBO();
		if($fleetfuelingDBO->persist($obj)){
			$this->id=$fleetfuelingDBO->id;
			$this->sql=$fleetfuelingDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$fleetfuelingDBO = new FleetfuelingDBO();
		if($fleetfuelingDBO->update($obj,$where)){
			$this->sql=$fleetfuelingDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$fleetfuelingDBO = new FleetfuelingDBO();
		if($fleetfuelingDBO->delete($obj,$where=""))		
			$this->sql=$fleetfuelingDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$fleetfuelingDBO = new FleetfuelingDBO();
		$this->table=$fleetfuelingDBO->table;
		$fleetfuelingDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$fleetfuelingDBO->sql;
		$this->result=$fleetfuelingDBO->result;
		$this->fetchObject=$fleetfuelingDBO->fetchObject;
		$this->affectedRows=$fleetfuelingDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->fleetid)){
			$error="Vehicle should be provided";
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
