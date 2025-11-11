<?php 
require_once("ItemdetailsDBO.php");
class Itemdetails
{				
	var $id;			
	var $itemid;			
	var $schemeid;			
	var $parcelno;			
	var $groundno;			
	var $status;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $itemdetailsDBO;
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
		if(empty($obj->schemeid))
			$obj->schemeid='NULL';
		$this->schemeid=$obj->schemeid;
		$this->parcelno=str_replace("'","\'",$obj->parcelno);
		$this->groundno=str_replace("'","\'",$obj->groundno);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get schemeid
	function getSchemeid(){
		return $this->schemeid;
	}
	//set schemeid
	function setSchemeid($schemeid){
		$this->schemeid=$schemeid;
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

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$itemdetailsDBO = new ItemdetailsDBO();
		if($itemdetailsDBO->persist($obj)){
			$this->id=$itemdetailsDBO->id;
			$this->sql=$itemdetailsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$itemdetailsDBO = new ItemdetailsDBO();
		if($itemdetailsDBO->update($obj,$where)){
			$this->sql=$itemdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$itemdetailsDBO = new ItemdetailsDBO();
		if($itemdetailsDBO->delete($obj,$where=""))		
			$this->sql=$itemdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$itemdetailsDBO = new ItemdetailsDBO();
		$this->table=$itemdetailsDBO->table;
		$itemdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$itemdetailsDBO->sql;
		$this->result=$itemdetailsDBO->result;
		$this->fetchObject=$itemdetailsDBO->fetchObject;
		$this->affectedRows=$itemdetailsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
