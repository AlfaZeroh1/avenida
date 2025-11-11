<?php 
require_once("InsurancesDBO.php");
class Insurances
{				
	var $id;			
	var $assetid;			
	var $insurerid;			
	var $insurcompany;			
	var $refno;			
	var $insuredon;			
	var $file;			
	var $expireson;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $insurancesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->assetid=str_replace("'","\'",$obj->assetid);
		$this->insurerid=str_replace("'","\'",$obj->insurerid);
		$this->insurcompany=str_replace("'","\'",$obj->insurcompany);
		$this->refno=str_replace("'","\'",$obj->refno);
		$this->insuredon=str_replace("'","\'",$obj->insuredon);
		$this->file=str_replace("'","\'",$obj->file);
		$this->expireson=str_replace("'","\'",$obj->expireson);
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

	//get insurerid
	function getInsurerid(){
		return $this->insurerid;
	}
	//set insurerid
	function setInsurerid($insurerid){
		$this->insurerid=$insurerid;
	}

	//get insurcompany
	function getInsurcompany(){
		return $this->insurcompany;
	}
	//set insurcompany
	function setInsurcompany($insurcompany){
		$this->insurcompany=$insurcompany;
	}

	//get refno
	function getRefno(){
		return $this->refno;
	}
	//set refno
	function setRefno($refno){
		$this->refno=$refno;
	}

	//get insuredon
	function getInsuredon(){
		return $this->insuredon;
	}
	//set insuredon
	function setInsuredon($insuredon){
		$this->insuredon=$insuredon;
	}

	//get file
	function getFile(){
		return $this->file;
	}
	//set file
	function setFile($file){
		$this->file=$file;
	}

	//get expireson
	function getExpireson(){
		return $this->expireson;
	}
	//set expireson
	function setExpireson($expireson){
		$this->expireson=$expireson;
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
		$insurancesDBO = new InsurancesDBO();
		if($insurancesDBO->persist($obj)){
			$this->id=$insurancesDBO->id;
			$this->sql=$insurancesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$insurancesDBO = new InsurancesDBO();
		if($insurancesDBO->update($obj,$where)){
			$this->sql=$insurancesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$insurancesDBO = new InsurancesDBO();
		if($insurancesDBO->delete($obj,$where=""))		
			$this->sql=$insurancesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$insurancesDBO = new InsurancesDBO();
		$this->table=$insurancesDBO->table;
		$insurancesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$insurancesDBO->sql;
		$this->result=$insurancesDBO->result;
		$this->fetchObject=$insurancesDBO->fetchObject;
		$this->affectedRows=$insurancesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
