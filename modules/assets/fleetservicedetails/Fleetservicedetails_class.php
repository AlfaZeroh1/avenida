<?php 
require_once("FleetservicedetailsDBO.php");
class Fleetservicedetails
{				
	var $id;			
	var $fleetserviceid;			
	var $fleetserviceitemid;			
	var $replaced;	
	var $serialnumber;
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $fleetservicedetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->fleetserviceid))
			$obj->fleetserviceid='NULL';
		$this->fleetserviceid=$obj->fleetserviceid;
		if(empty($obj->fleetserviceitemid))
			$obj->fleetserviceitemid='NULL';
		$this->fleetserviceitemid=$obj->fleetserviceitemid;
		$this->replaced=str_replace("'","\'",$obj->replaced);
		$this->serialnumber=str_replace("'","\'",$obj->serialnumber);
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

	//get fleetserviceid
	function getFleetserviceid(){
		return $this->fleetserviceid;
	}
	//set fleetserviceid
	function setFleetserviceid($fleetserviceid){
		$this->fleetserviceid=$fleetserviceid;
	}

	//get fleetserviceitemid
	function getFleetserviceitemid(){
		return $this->fleetserviceitemid;
	}
	//set fleetserviceitemid
	function setFleetserviceitemid($fleetserviceitemid){
		$this->fleetserviceitemid=$fleetserviceitemid;
	}

	//get replaced
	function getReplaced(){
		return $this->replaced;
	}
	//set replaced
	function setReplaced($replaced){
		$this->replaced=$replaced;
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
		$fleetservicedetailsDBO = new FleetservicedetailsDBO();
		if($fleetservicedetailsDBO->persist($obj)){
			$this->id=$fleetservicedetailsDBO->id;
			$this->sql=$fleetservicedetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$fleetservicedetailsDBO = new FleetservicedetailsDBO();
		if($fleetservicedetailsDBO->update($obj,$where)){
			$this->sql=$fleetservicedetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$fleetservicedetailsDBO = new FleetservicedetailsDBO();
		if($fleetservicedetailsDBO->delete($obj,$where=""))		
			$this->sql=$fleetservicedetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$fleetservicedetailsDBO = new FleetservicedetailsDBO();
		$this->table=$fleetservicedetailsDBO->table;
		$fleetservicedetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$fleetservicedetailsDBO->sql;
		$this->result=$fleetservicedetailsDBO->result;
		$this->fetchObject=$fleetservicedetailsDBO->fetchObject;
		$this->affectedRows=$fleetservicedetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->fleetserviceid)){
			$error="Fleet Service should be provided";
		}
		else if(empty($obj->fleetserviceitemid)){
			$error="Service Item should be provided";
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
