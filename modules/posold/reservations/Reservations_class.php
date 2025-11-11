<?php 
require_once("ReservationsDBO.php");
class Reservations
{				
	var $id;			
	var $itemid;			
	var $customerid;			
	var $reservedon;			
	var $duration;			
	var $quantity;			
	var $parcelno;			
	var $groundno;			
	var $salestatusid;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $reservationsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		$this->reservedon=str_replace("'","\'",$obj->reservedon);
		$this->duration=str_replace("'","\'",$obj->duration);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->parcelno=str_replace("'","\'",$obj->parcelno);
		$this->groundno=str_replace("'","\'",$obj->groundno);
		if(empty($obj->salestatusid))
			$obj->salestatusid='NULL';
		$this->salestatusid=$obj->salestatusid;
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get reservedon
	function getReservedon(){
		return $this->reservedon;
	}
	//set reservedon
	function setReservedon($reservedon){
		$this->reservedon=$reservedon;
	}

	//get duration
	function getDuration(){
		return $this->duration;
	}
	//set duration
	function setDuration($duration){
		$this->duration=$duration;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get parcelno
	function getParcelno(){
		return $this->parcelno;
	}
	//set parcelno
	function setParcelno($parcelno){
		$this->parcelno=$parcelno;
	}

	//get groundno
	function getGroundno(){
		return $this->groundno;
	}
	//set groundno
	function setGroundno($groundno){
		$this->groundno=$groundno;
	}

	//get salestatusid
	function getSalestatusid(){
		return $this->salestatusid;
	}
	//set salestatusid
	function setSalestatusid($salestatusid){
		$this->salestatusid=$salestatusid;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$reservationsDBO = new ReservationsDBO();
		if($reservationsDBO->persist($obj)){
			$this->id=$reservationsDBO->id;
			$this->sql=$reservationsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$reservationsDBO = new ReservationsDBO();
		if($reservationsDBO->update($obj,$where)){
			$this->sql=$reservationsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$reservationsDBO = new ReservationsDBO();
		if($reservationsDBO->delete($obj,$where=""))		
			$this->sql=$reservationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$reservationsDBO = new ReservationsDBO();
		$this->table=$reservationsDBO->table;
		$reservationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$reservationsDBO->sql;
		$this->result=$reservationsDBO->result;
		$this->fetchObject=$reservationsDBO->fetchObject;
		$this->affectedRows=$reservationsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->salestatusid)){
			$error="Status should be provided";
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
