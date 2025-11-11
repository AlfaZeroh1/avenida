<?php 
require_once("CardsDBO.php");
class Cards
{				
	var $id;			
	var $cardno;			
	var $cardtypeid;			
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $cardsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->cardno=str_replace("'","\'",$obj->cardno);
		if(empty($obj->cardtypeid))
			$obj->cardtypeid='NULL';
		$this->cardtypeid=$obj->cardtypeid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get cardno
	function getCardno(){
		return $this->cardno;
	}
	//set cardno
	function setCardno($cardno){
		$this->cardno=$cardno;
	}

	//get cardtypeid
	function getCardtypeid(){
		return $this->cardtypeid;
	}
	//set cardtypeid
	function setCardtypeid($cardtypeid){
		$this->cardtypeid=$cardtypeid;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$cardsDBO = new CardsDBO();
		if($cardsDBO->persist($obj)){
			$this->id=$cardsDBO->id;
			$this->sql=$cardsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$cardsDBO = new CardsDBO();
		if($cardsDBO->update($obj,$where)){
			$this->sql=$cardsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$cardsDBO = new CardsDBO();
		if($cardsDBO->delete($obj,$where=""))		
			$this->sql=$cardsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$cardsDBO = new CardsDBO();
		$this->table=$cardsDBO->table;
		$cardsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$cardsDBO->sql;
		$this->result=$cardsDBO->result;
		$this->fetchObject=$cardsDBO->fetchObject;
		$this->affectedRows=$cardsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->cardno)){
			$error="Card No. should be provided";
		}
		else if(empty($obj->cardtypeid)){
			$error="Card Type should be provided";
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
