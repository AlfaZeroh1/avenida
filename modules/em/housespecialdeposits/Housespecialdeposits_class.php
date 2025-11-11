<?php 
require_once("HousespecialdepositsDBO.php");
class Housespecialdeposits
{				
	var $id;			
	var $houseid;			
	var $paymenttermid;			
	var $amount;			
	var $remarks;								
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;	
	var $housespecialdepositsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->houseid=str_replace("'","\'",$obj->houseid);
		$this->paymenttermid=str_replace("'","\'",$obj->paymenttermid);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get houseid
	function getHouseid(){
		return $this->houseid;
	}
	//set houseid
	function setHouseid($houseid){
		$this->houseid=$houseid;
	}

	//get paymenttermid
	function getPaymenttermid(){
		return $this->paymenttermid;
	}
	//set paymenttermid
	function setPaymenttermid($paymenttermid){
		$this->paymenttermid=$paymenttermid;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$housespecialdepositsDBO = new HousespecialdepositsDBO();
		if($housespecialdepositsDBO->persist($obj)){
			$this->id=$housespecialdepositsDBO->id;
			$this->sql=$housespecialdepositsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$housespecialdepositsDBO = new HousespecialdepositsDBO();
		if($housespecialdepositsDBO->update($obj,$where)){
			$this->sql=$housespecialdepositsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$housespecialdepositsDBO = new HousespecialdepositsDBO();
		if($housespecialdepositsDBO->delete($obj,$where=""))		
			$this->sql=$housespecialdepositsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$housespecialdepositsDBO = new HousespecialdepositsDBO();
		$this->table=$housespecialdepositsDBO->table;
		$housespecialdepositsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$housespecialdepositsDBO->sql;
		$this->result=$housespecialdepositsDBO->result;
		$this->fetchObject=$housespecialdepositsDBO->fetchObject;
		$this->affectedRows=$housespecialdepositsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
