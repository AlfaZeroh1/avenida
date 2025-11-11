<?php 
require_once("HousebreakagesDBO.php");
class Housebreakages
{				
	var $id;			
	var $houseid;			
	var $tenantid;			
	var $breakage;			
	var $fixed;			
	var $cost;			
	var $paidbytenant;			
	var $remarks;		
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;
	var $housebreakagesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->houseid=str_replace("'","\'",$obj->houseid);
		$this->tenantid=str_replace("'","\'",$obj->tenantid);
		$this->breakage=str_replace("'","\'",$obj->breakage);
		$this->fixed=str_replace("'","\'",$obj->fixed);
		$this->cost=str_replace("'","\'",$obj->cost);
		$this->paidbytenant=str_replace("'","\'",$obj->paidbytenant);
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

	//get tenantid
	function getTenantid(){
		return $this->tenantid;
	}
	//set tenantid
	function setTenantid($tenantid){
		$this->tenantid=$tenantid;
	}

	//get breakage
	function getBreakage(){
		return $this->breakage;
	}
	//set breakage
	function setBreakage($breakage){
		$this->breakage=$breakage;
	}

	//get fixed
	function getFixed(){
		return $this->fixed;
	}
	//set fixed
	function setFixed($fixed){
		$this->fixed=$fixed;
	}

	//get cost
	function getCost(){
		return $this->cost;
	}
	//set cost
	function setCost($cost){
		$this->cost=$cost;
	}

	//get paidbytenant
	function getPaidbytenant(){
		return $this->paidbytenant;
	}
	//set paidbytenant
	function setPaidbytenant($paidbytenant){
		$this->paidbytenant=$paidbytenant;
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
		$housebreakagesDBO = new HousebreakagesDBO();
		if($housebreakagesDBO->persist($obj)){
			$this->id=$housebreakagesDBO->id;
			$this->sql=$housebreakagesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$housebreakagesDBO = new HousebreakagesDBO();
		if($housebreakagesDBO->update($obj,$where)){
			$this->sql=$housebreakagesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$housebreakagesDBO = new HousebreakagesDBO();
		if($housebreakagesDBO->delete($obj,$where=""))		
			$this->sql=$housebreakagesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$housebreakagesDBO = new HousebreakagesDBO();
		$this->table=$housebreakagesDBO->table;
		$housebreakagesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$housebreakagesDBO->sql;
		$this->result=$housebreakagesDBO->result;
		$this->fetchObject=$housebreakagesDBO->fetchObject;
		$this->affectedRows=$housebreakagesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->houseid)){
			$error="House should be provided";
		}
		else if(empty($obj->tenantid)){
			$error="Tenant should be provided";
		}
		else if(empty($obj->breakage)){
			$error="Breakage should be provided";
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
