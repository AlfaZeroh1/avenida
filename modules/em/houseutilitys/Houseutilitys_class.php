<?php 
require_once("HouseutilitysDBO.php");
class Houseutilitys
{				
	var $id;			
	var $houseid;			
	var $paymenttermid;			
	var $amount;			
	var $showinst;			
	var $mgtfee;			
	var $mgtfeeperc;			
	var $vatable;			
	var $vatclasseid;			
	var $mgtfeevatable;			
	var $mgtfeevatclasseid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $houseutilitysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->houseid))
			$obj->houseid='NULL';
		$this->houseid=$obj->houseid;
		if(empty($obj->paymenttermid))
			$obj->paymenttermid='NULL';
		$this->paymenttermid=$obj->paymenttermid;
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->showinst=str_replace("'","\'",$obj->showinst);
		$this->mgtfee=str_replace("'","\'",$obj->mgtfee);
		$this->mgtfeeperc=str_replace("'","\'",$obj->mgtfeeperc);
		$this->vatable=str_replace("'","\'",$obj->vatable);
		if(empty($obj->vatclasseid))
			$obj->vatclasseid='NULL';
		$this->vatclasseid=$obj->vatclasseid;
		$this->mgtfeevatable=str_replace("'","\'",$obj->mgtfeevatable);
		$this->mgtfeevatclasseid=str_replace("'","\'",$obj->mgtfeevatclasseid);
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

	//get showinst
	function getShowinst(){
		return $this->showinst;
	}
	//set showinst
	function setShowinst($showinst){
		$this->showinst=$showinst;
	}

	//get mgtfee
	function getMgtfee(){
		return $this->mgtfee;
	}
	//set mgtfee
	function setMgtfee($mgtfee){
		$this->mgtfee=$mgtfee;
	}

	//get mgtfeeperc
	function getMgtfeeperc(){
		return $this->mgtfeeperc;
	}
	//set mgtfeeperc
	function setMgtfeeperc($mgtfeeperc){
		$this->mgtfeeperc=$mgtfeeperc;
	}

	//get vatable
	function getVatable(){
		return $this->vatable;
	}
	//set vatable
	function setVatable($vatable){
		$this->vatable=$vatable;
	}

	//get vatclasseid
	function getVatclasseid(){
		return $this->vatclasseid;
	}
	//set vatclasseid
	function setVatclasseid($vatclasseid){
		$this->vatclasseid=$vatclasseid;
	}

	//get mgtfeevatable
	function getMgtfeevatable(){
		return $this->mgtfeevatable;
	}
	//set mgtfeevatable
	function setMgtfeevatable($mgtfeevatable){
		$this->mgtfeevatable=$mgtfeevatable;
	}

	//get mgtfeevatclasseid
	function getMgtfeevatclasseid(){
		return $this->mgtfeevatclasseid;
	}
	//set mgtfeevatclasseid
	function setMgtfeevatclasseid($mgtfeevatclasseid){
		$this->mgtfeevatclasseid=$mgtfeevatclasseid;
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
		$houseutilitysDBO = new HouseutilitysDBO();
		if($houseutilitysDBO->persist($obj)){
			$this->id=$houseutilitysDBO->id;
			$this->sql=$houseutilitysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$houseutilitysDBO = new HouseutilitysDBO();
		if($houseutilitysDBO->update($obj,$where)){
			$this->sql=$houseutilitysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$houseutilitysDBO = new HouseutilitysDBO();
		if($houseutilitysDBO->delete($obj,$where=""))		
			$this->sql=$houseutilitysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$houseutilitysDBO = new HouseutilitysDBO();
		$this->table=$houseutilitysDBO->table;
		$houseutilitysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$houseutilitysDBO->sql;
		$this->result=$houseutilitysDBO->result;
		$this->fetchObject=$houseutilitysDBO->fetchObject;
		$this->affectedRows=$houseutilitysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->houseid)){
			$error="House should be provided";
		}
		else if(empty($obj->amount)){
			$error="Amount should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->houseid)){
			$error="House should be provided";
		}
		else if(empty($obj->amount)){
			$error="Amount should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
