<?php 
require_once("LoansDBO.php");
class Loans
{				
	var $id;			
	var $name;			
	var $method;			
	var $type;			
	var $incomeid;			
	var $description;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $loansDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->method=str_replace("'","\'",$obj->method);
		$this->type=str_replace("'","\'",$obj->type);
		if(empty($obj->incomeid))
			$obj->incomeid='NULL';
		$this->incomeid=$obj->incomeid;
		$this->description=str_replace("'","\'",$obj->description);
		$this->liabilityid=str_replace("'","\'",$obj->liabilityid);
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

	//get method
	function getMethod(){
		return $this->method;
	}
	//set method
	function setMethod($method){
		$this->method=$method;
	}

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}

	//get incomeid
	function getIncomeid(){
		return $this->incomeid;
	}
	//set incomeid
	function setIncomeid($incomeid){
		$this->incomeid=$incomeid;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
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
		$loansDBO = new LoansDBO();
		if($loansDBO->persist($obj)){
		
			
			//when its office loan, an account is created in employee name at the point of giving loans and an income account created for interest
			if($obj->type=="Office"){
			  $incomes= new Incomes();
			  $incomes->name=$obj->name." Interest ";
			  $incomes = $incomes->setObject($incomes);
			  $incomes->add($incomes);
			  
			  $loans = new Loans();
			  $fields = "*";
			  $fields="*";
			  $where=" where id='$loansDBO->id'";
			  $groupby="";
			  $orderby="";
			  $having="";
			  $join="";
			  $loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  $loans = $loans->fetchObject;
			  
			  $ln = new Loans();
			  $loans->incomeid=$incomes->id;
			  $ln = $ln->setObject($loans);
			  $ln->edit($ln);
			}
			else{
			  //Add a liability account
			    $liabilitys= new Incomes();
			    $liabilitys->name=$obj->name;
			    $liabilitys = $liabilitys->setObject($incomes);
			    $liabilitys->add($liabilitys);
			    
			    $loans = new Loans();
			    $fields = "*";
			    $fields="*";
			    $where=" where id='$loansDBO->id'";
			    $groupby="";
			    $orderby="";
			    $having="";
			    $join="";
			    $loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    $loans = $loans->fetchObject;
			    
			    $ln = new Loans();
			    $ln->liabilityid=$liabilitys->id;
			    $ln->acctypeid=2;
			    $ln = $ln->setObject($loans);
			    $ln->edit($ln);
			}
			
			$this->id=$loansDBO->id;
			$this->sql=$loansDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$loansDBO = new LoansDBO();
		if($loansDBO->update($obj,$where)){
			$this->sql=$loansDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$loansDBO = new LoansDBO();
		if($loansDBO->delete($obj,$where=""))		
			$this->sql=$loansDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$loansDBO = new LoansDBO();
		$this->table=$loansDBO->table;
		$loansDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$loansDBO->sql;
		$this->result=$loansDBO->result;
		$this->fetchObject=$loansDBO->fetchObject;
		$this->affectedRows=$loansDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
		}
		else if(empty($obj->method)){
			$error="Method should be provided";
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
