<?php 
require_once("HousespecialdepositexemptionsDBO.php");
class Housespecialdepositexemptions
{				
	var $id;			
	var $houseid;			
	var $paymenttermid;			
	var $remarks;			
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;
	var $housespecialdepositexemptionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->houseid=str_replace("'","\'",$obj->houseid);
		$this->paymenttermid=str_replace("'","\'",$obj->paymenttermid);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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
		$housespecialdepositexemptionsDBO = new HousespecialdepositexemptionsDBO();
		if($housespecialdepositexemptionsDBO->persist($obj)){
			$this->id=$housespecialdepositexemptionsDBO->id;
			$this->sql=$housespecialdepositexemptionsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$housespecialdepositexemptionsDBO = new HousespecialdepositexemptionsDBO();
		if($housespecialdepositexemptionsDBO->update($obj,$where)){
			$this->sql=$housespecialdepositexemptionsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$housespecialdepositexemptionsDBO = new HousespecialdepositexemptionsDBO();
		if($housespecialdepositexemptionsDBO->delete($obj,$where=""))		
			$this->sql=$housespecialdepositexemptionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$housespecialdepositexemptionsDBO = new HousespecialdepositexemptionsDBO();
		$this->table=$housespecialdepositexemptionsDBO->table;
		$housespecialdepositexemptionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$housespecialdepositexemptionsDBO->sql;
		$this->result=$housespecialdepositexemptionsDBO->result;
		$this->fetchObject=$housespecialdepositexemptionsDBO->fetchObject;
		$this->affectedRows=$housespecialdepositexemptionsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
