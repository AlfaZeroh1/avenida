<?php 
require_once("TenantdepositsDBO.php");
class Tenantdeposits
{				
	var $id;			
	var $tenantid;			
	var $houseid;			
	var $houserentingid;			
	var $tenantpaymentid;			
	var $paymenttermid;			
	var $amount;			
	var $paidon;			
	var $remarks;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $tenantdepositsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->tenantid))
			$obj->tenantid='NULL';
		$this->tenantid=$obj->tenantid;
		if(empty($obj->houseid))
			$obj->houseid='NULL';
		$this->houseid=$obj->houseid;
		$this->houserentingid=str_replace("'","\'",$obj->houserentingid);
		$this->tenantpaymentid=str_replace("'","\'",$obj->tenantpaymentid);
		if(empty($obj->paymenttermid))
			$obj->paymenttermid='NULL';
		$this->paymenttermid=$obj->paymenttermid;
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->paidon=str_replace("'","\'",$obj->paidon);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get tenantid
	function getTenantid(){
		return $this->tenantid;
	}
	//set tenantid
	function setTenantid($tenantid){
		$this->tenantid=$tenantid;
	}

	//get houseid
	function getHouseid(){
		return $this->houseid;
	}
	//set houseid
	function setHouseid($houseid){
		$this->houseid=$houseid;
	}

	//get houserentingid
	function getHouserentingid(){
		return $this->houserentingid;
	}
	//set houserentingid
	function setHouserentingid($houserentingid){
		$this->houserentingid=$houserentingid;
	}

	//get tenantpaymentid
	function getTenantpaymentid(){
		return $this->tenantpaymentid;
	}
	//set tenantpaymentid
	function setTenantpaymentid($tenantpaymentid){
		$this->tenantpaymentid=$tenantpaymentid;
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

	//get paidon
	function getPaidon(){
		return $this->paidon;
	}
	//set paidon
	function setPaidon($paidon){
		$this->paidon=$paidon;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$tenantdepositsDBO = new TenantdepositsDBO();
		if($tenantdepositsDBO->persist($obj)){
			$this->id=$tenantdepositsDBO->id;
			$this->sql=$tenantdepositsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$tenantdepositsDBO = new TenantdepositsDBO();
		if($tenantdepositsDBO->update($obj,$where)){
			$this->sql=$tenantdepositsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$tenantdepositsDBO = new TenantdepositsDBO();
		if($tenantdepositsDBO->delete($obj,$where=""))		
			$this->sql=$tenantdepositsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tenantdepositsDBO = new TenantdepositsDBO();
		$this->table=$tenantdepositsDBO->table;
		$tenantdepositsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tenantdepositsDBO->sql;
		$this->result=$tenantdepositsDBO->result;
		$this->fetchObject=$tenantdepositsDBO->fetchObject;
		$this->affectedRows=$tenantdepositsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->tenantid)){
			$error="Tenant should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->tenantid)){
			$error="Tenant should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
