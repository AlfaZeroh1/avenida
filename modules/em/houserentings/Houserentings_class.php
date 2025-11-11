<?php 
require_once("HouserentingsDBO.php");
class Houserentings
{				
	var $id;			
	var $houseid;			
	var $tenantid;			
	var $rentaltypeid;			
	var $occupiedon;			
	var $vacatedon;			
	var $leasestarts;			
	var $renewevery;			
	var $leaseends;			
	var $increasetype;			
	var $increaseby;			
	var $increaseevery;			
	var $rentduedate;
	var $status;
	var $createdby;
	var $createdon;
	var $lasteditedby;
	var $lasteditedon;
	var $houserentingsDBO;
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
		if(empty($obj->tenantid))
			$obj->tenantid='NULL';
		$this->tenantid=$obj->tenantid;
		if(empty($obj->rentaltypeid))
			$obj->rentaltypeid='NULL';
		$this->rentaltypeid=$obj->rentaltypeid;
		$this->occupiedon=str_replace("'","\'",$obj->occupiedon);
		$this->vacatedon=str_replace("'","\'",$obj->vacatedon);
		$this->leasestarts=str_replace("'","\'",$obj->leasestarts);
		$this->renewevery=str_replace("'","\'",$obj->renewevery);
		$this->leaseends=str_replace("'","\'",$obj->leaseends);
		$this->increasetype=str_replace("'","\'",$obj->increasetype);
		$this->increaseby=str_replace("'","\'",$obj->increaseby);
		$this->increaseevery=str_replace("'","\'",$obj->increaseevery);
		$this->rentduedate=str_replace("'","\'",$obj->rentduedate);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get rentaltypeid
	function getRentaltypeid(){
		return $this->rentaltypeid;
	}
	//set rentaltypeid
	function setRentaltypeid($rentaltypeid){
		$this->rentaltypeid=$rentaltypeid;
	}

	//get occupiedon
	function getOccupiedon(){
		return $this->occupiedon;
	}
	//set occupiedon
	function setOccupiedon($occupiedon){
		$this->occupiedon=$occupiedon;
	}

	//get vacatedon
	function getVacatedon(){
		return $this->vacatedon;
	}
	//set vacatedon
	function setVacatedon($vacatedon){
		$this->vacatedon=$vacatedon;
	}

	//get leasestarts
	function getLeasestarts(){
		return $this->leasestarts;
	}
	//set leasestarts
	function setLeasestarts($leasestarts){
		$this->leasestarts=$leasestarts;
	}

	//get renewevery
	function getRenewevery(){
		return $this->renewevery;
	}
	//set renewevery
	function setRenewevery($renewevery){
		$this->renewevery=$renewevery;
	}

	//get leaseends
	function getLeaseends(){
		return $this->leaseends;
	}
	//set leaseends
	function setLeaseends($leaseends){
		$this->leaseends=$leaseends;
	}

	//get increasetype
	function getIncreasetype(){
		return $this->increasetype;
	}
	//set increasetype
	function setIncreasetype($increasetype){
		$this->increasetype=$increasetype;
	}

	//get increaseby
	function getIncreaseby(){
		return $this->increaseby;
	}
	//set increaseby
	function setIncreaseby($increaseby){
		$this->increaseby=$increaseby;
	}

	//get increaseevery
	function getIncreaseevery(){
		return $this->increaseevery;
	}
	//set increaseevery
	function setIncreaseevery($increaseevery){
		$this->increaseevery=$increaseevery;
	}

	//get rentduedate
	function getRentduedate(){
		return $this->rentduedate;
	}
	//set rentduedate
	function setRentduedate($rentduedate){
		$this->rentduedate=$rentduedate;
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

	
	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}
	
	function add($obj){
		$houserentingsDBO = new HouserentingsDBO();
		if($houserentingsDBO->persist($obj)){
			$this->id=$houserentingsDBO->id;
			$this->sql=$houserentingsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$houserentingsDBO = new HouserentingsDBO();
		if($houserentingsDBO->update($obj,$where)){
			$this->sql=$houserentingsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$houserentingsDBO = new HouserentingsDBO();
		if($houserentingsDBO->delete($obj,$where=""))		
			$this->sql=$houserentingsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$houserentingsDBO = new HouserentingsDBO();
		$this->table=$houserentingsDBO->table;
		$houserentingsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$houserentingsDBO->sql;
		$this->result=$houserentingsDBO->result;
		$this->fetchObject=$houserentingsDBO->fetchObject;
		$this->affectedRows=$houserentingsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->houseid)){
			$error="House should be provided";
		}
		else if(empty($obj->tenantid)){
			$error="Tenant should be provided";
		}
		else if(empty($obj->occupiedon)){
			$error="Date Occupied should be provided";
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
