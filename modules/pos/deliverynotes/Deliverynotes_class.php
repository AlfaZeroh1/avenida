<?php 
require_once("DeliverynotesDBO.php");
class Deliverynotes
{				
	var $id;			
	var $documentno;			
	var $lpono;			
	var $customerid;			
	var $deliveredon;			
	var $itemid;			
	var $quantity;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $deliverynotesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->lpono=str_replace("'","\'",$obj->lpono);
		$this->customerid=str_replace("'","\'",$obj->customerid);
		$this->deliveredon=str_replace("'","\'",$obj->deliveredon);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get lpono
	function getLpono(){
		return $this->lpono;
	}
	//set lpono
	function setLpono($lpono){
		$this->lpono=$lpono;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get deliveredon
	function getDeliveredon(){
		return $this->deliveredon;
	}
	//set deliveredon
	function setDeliveredon($deliveredon){
		$this->deliveredon=$deliveredon;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
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
		$deliverynotesDBO = new DeliverynotesDBO();
		if($deliverynotesDBO->persist($obj)){
			$this->id=$deliverynotesDBO->id;
			$this->sql=$deliverynotesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$deliverynotesDBO = new DeliverynotesDBO();
		if($deliverynotesDBO->update($obj,$where)){
			$this->sql=$deliverynotesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$deliverynotesDBO = new DeliverynotesDBO();
		if($deliverynotesDBO->delete($obj,$where=""))		
			$this->sql=$deliverynotesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$deliverynotesDBO = new DeliverynotesDBO();
		$this->table=$deliverynotesDBO->table;
		$deliverynotesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$deliverynotesDBO->sql;
		$this->result=$deliverynotesDBO->result;
		$this->fetchObject=$deliverynotesDBO->fetchObject;
		$this->affectedRows=$deliverynotesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Delivery Note should be provided";
		}
		else if(empty($obj->deliveredon)){
			$error="Delivery Date should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Item should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Delivery Note should be provided";
		}
		else if(empty($obj->deliveredon)){
			$error="Delivery Date should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
