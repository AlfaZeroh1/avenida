<?php 
require_once("PotentialcustomersDBO.php");
class Potentialcustomers
{				
	var $id;			
	var $name;			
	var $agentid;			
	var $departmentid;			
	var $categorydepartmentid;			
	var $categoryid;			
	var $employeeid;			
	var $idno;			
	var $pinno;			
	var $address;			
	var $tel;			
	var $fax;			
	var $email;			
	var $contactname;			
	var $contactphone;			
	var $remarks;			
	var $status;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $potentialcustomersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->agentid))
			$obj->agentid='NULL';
		$this->agentid=$obj->agentid;
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		if(empty($obj->categorydepartmentid))
			$obj->categorydepartmentid='NULL';
		$this->categorydepartmentid=$obj->categorydepartmentid;
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->idno=str_replace("'","\'",$obj->idno);
		$this->pinno=str_replace("'","\'",$obj->pinno);
		$this->address=str_replace("'","\'",$obj->address);
		$this->tel=str_replace("'","\'",$obj->tel);
		$this->fax=str_replace("'","\'",$obj->fax);
		$this->email=str_replace("'","\'",$obj->email);
		$this->contactname=str_replace("'","\'",$obj->contactname);
		$this->contactphone=str_replace("'","\'",$obj->contactphone);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get agentid
	function getAgentid(){
		return $this->agentid;
	}
	//set agentid
	function setAgentid($agentid){
		$this->agentid=$agentid;
	}

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
	}

	//get categorydepartmentid
	function getCategorydepartmentid(){
		return $this->categorydepartmentid;
	}
	//set categorydepartmentid
	function setCategorydepartmentid($categorydepartmentid){
		$this->categorydepartmentid=$categorydepartmentid;
	}

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get idno
	function getIdno(){
		return $this->idno;
	}
	//set idno
	function setIdno($idno){
		$this->idno=$idno;
	}

	//get pinno
	function getPinno(){
		return $this->pinno;
	}
	//set pinno
	function setPinno($pinno){
		$this->pinno=$pinno;
	}

	//get address
	function getAddress(){
		return $this->address;
	}
	//set address
	function setAddress($address){
		$this->address=$address;
	}

	//get tel
	function getTel(){
		return $this->tel;
	}
	//set tel
	function setTel($tel){
		$this->tel=$tel;
	}

	//get fax
	function getFax(){
		return $this->fax;
	}
	//set fax
	function setFax($fax){
		$this->fax=$fax;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
	}

	//get contactname
	function getContactname(){
		return $this->contactname;
	}
	//set contactname
	function setContactname($contactname){
		$this->contactname=$contactname;
	}

	//get contactphone
	function getContactphone(){
		return $this->contactphone;
	}
	//set contactphone
	function setContactphone($contactphone){
		$this->contactphone=$contactphone;
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
		$potentialcustomersDBO = new PotentialcustomersDBO();
		if($potentialcustomersDBO->persist($obj)){
			$this->id=$potentialcustomersDBO->id;
			$this->sql=$potentialcustomersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$potentialcustomersDBO = new PotentialcustomersDBO();
		if($potentialcustomersDBO->update($obj,$where)){
			$this->sql=$potentialcustomersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$potentialcustomersDBO = new PotentialcustomersDBO();
		if($potentialcustomersDBO->delete($obj,$where=""))		
			$this->sql=$potentialcustomersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$potentialcustomersDBO = new PotentialcustomersDBO();
		$this->table=$potentialcustomersDBO->table;
		$potentialcustomersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$potentialcustomersDBO->sql;
		$this->result=$potentialcustomersDBO->result;
		$this->fetchObject=$potentialcustomersDBO->fetchObject;
		$this->affectedRows=$potentialcustomersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Customer Name should be provided";
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
