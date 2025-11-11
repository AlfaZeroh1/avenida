<?php 
require_once("ProjectboqsDBO.php");
class Projectboqs
{				
	var $id;			
	var $billofquantitieid;			
	var $name;			
	var $quantity;			
	var $unitofmeasureid;			
	var $bqrate;			
	var $total;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectboqsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->billofquantitieid))
			$obj->billofquantitieid='NULL';
		$this->billofquantitieid=$obj->billofquantitieid;
		$this->name=str_replace("'","\'",$obj->name);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		if(empty($obj->unitofmeasureid))
			$obj->unitofmeasureid='NULL';
		$this->unitofmeasureid=$obj->unitofmeasureid;
		$this->bqrate=str_replace("'","\'",$obj->bqrate);
		$this->total=str_replace("'","\'",$obj->total);
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

	//get billofquantitieid
	function getBillofquantitieid(){
		return $this->billofquantitieid;
	}
	//set billofquantitieid
	function setBillofquantitieid($billofquantitieid){
		$this->billofquantitieid=$billofquantitieid;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get unitofmeasureid
	function getUnitofmeasureid(){
		return $this->unitofmeasureid;
	}
	//set unitofmeasureid
	function setUnitofmeasureid($unitofmeasureid){
		$this->unitofmeasureid=$unitofmeasureid;
	}

	//get bqrate
	function getBqrate(){
		return $this->bqrate;
	}
	//set bqrate
	function setBqrate($bqrate){
		$this->bqrate=$bqrate;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
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
		$projectboqsDBO = new ProjectboqsDBO();
		if($projectboqsDBO->persist($obj)){
			$this->id=$projectboqsDBO->id;
			$this->sql=$projectboqsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectboqsDBO = new ProjectboqsDBO();
		if($projectboqsDBO->update($obj,$where)){
			$this->sql=$projectboqsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectboqsDBO = new ProjectboqsDBO();
		if($projectboqsDBO->delete($obj,$where=""))		
			$this->sql=$projectboqsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectboqsDBO = new ProjectboqsDBO();
		$this->table=$projectboqsDBO->table;
		$projectboqsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectboqsDBO->sql;
		$this->result=$projectboqsDBO->result;
		$this->fetchObject=$projectboqsDBO->fetchObject;
		$this->affectedRows=$projectboqsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->billofquantitieid)){
			$error="Bill of Quantity should be provided";
		}
		else if(empty($obj->name)){
			$error="BoQ Detail should be provided";
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
