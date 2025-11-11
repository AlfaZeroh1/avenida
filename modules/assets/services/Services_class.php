<?php 
require_once("ServicesDBO.php");
class Services
{				
	var $id;			
	var $assetid;			
	var $servicescheduleid;			
	var $supplierid;			
	var $documentno;			
	var $servicedon;			
	var $servicetype;			
	var $description;			
	var $recommendations;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $servicesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->assetid))
			$obj->assetid='NULL';
		$this->assetid=$obj->assetid;
		if(empty($obj->servicescheduleid))
			$obj->servicescheduleid='NULL';
		$this->servicescheduleid=$obj->servicescheduleid;
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->servicedon=str_replace("'","\'",$obj->servicedon);
		$this->servicetype=str_replace("'","\'",$obj->servicetype);
		$this->description=str_replace("'","\'",$obj->description);
		$this->recommendations=str_replace("'","\'",$obj->recommendations);
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

	//get assetid
	function getAssetid(){
		return $this->assetid;
	}
	//set assetid
	function setAssetid($assetid){
		$this->assetid=$assetid;
	}

	//get servicescheduleid
	function getServicescheduleid(){
		return $this->servicescheduleid;
	}
	//set servicescheduleid
	function setServicescheduleid($servicescheduleid){
		$this->servicescheduleid=$servicescheduleid;
	}

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get servicedon
	function getServicedon(){
		return $this->servicedon;
	}
	//set servicedon
	function setServicedon($servicedon){
		$this->servicedon=$servicedon;
	}

	//get servicetype
	function getServicetype(){
		return $this->servicetype;
	}
	//set servicetype
	function setServicetype($servicetype){
		$this->servicetype=$servicetype;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get recommendations
	function getRecommendations(){
		return $this->recommendations;
	}
	//set recommendations
	function setRecommendations($recommendations){
		$this->recommendations=$recommendations;
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
		$servicesDBO = new ServicesDBO();
		if($servicesDBO->persist($obj)){
			$this->id=$servicesDBO->id;
			$this->sql=$servicesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$servicesDBO = new ServicesDBO();
		if($servicesDBO->update($obj,$where)){
			$this->sql=$servicesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$servicesDBO = new ServicesDBO();
		if($servicesDBO->delete($obj,$where=""))		
			$this->sql=$servicesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$servicesDBO = new ServicesDBO();
		$this->table=$servicesDBO->table;
		$servicesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$servicesDBO->sql;
		$this->result=$servicesDBO->result;
		$this->fetchObject=$servicesDBO->fetchObject;
		$this->affectedRows=$servicesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->assetid)){
			$error="Asset should be provided";
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
