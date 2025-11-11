<?php 
require_once("ExpensesDBO.php");
class Expenses
{				
	var $id;			
	var $name;			
	var $code;			
	var $expensetypeid;			
	var $expensecategoryid;			
	var $description;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $expensesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->code=str_replace("'","\'",$obj->code);
		if(empty($obj->expensetypeid))
			$obj->expensetypeid='NULL';
		$this->expensetypeid=$obj->expensetypeid;
		if(empty($obj->expensecategoryid))
			$obj->expensecategoryid='NULL';
		$this->expensecategoryid=$obj->expensecategoryid;
		$this->description=str_replace("'","\'",$obj->description);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
	}

	//get expensetypeid
	function getExpensetypeid(){
		return $this->expensetypeid;
	}
	//set expensetypeid
	function setExpensetypeid($expensetypeid){
		$this->expensetypeid=$expensetypeid;
	}

	//get expensecategoryid
	function getExpensecategoryid(){
		return $this->expensecategoryid;
	}
	//set expensecategoryid
	function setExpensecategoryid($expensecategoryid){
		$this->expensecategoryid=$expensecategoryid;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
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
		$expensesDBO = new ExpensesDBO();
		if($expensesDBO->persist($obj)){
			
			//get expense type account
			$categorys = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->expensecategoryid' and acctypeid='6' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$categorys = $categorys->fetchObject;
			
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$expensesDBO->id;
			$obj->acctypeid=4;
			$obj->currencyid=5;
			$obj->categoryid=$categorys->id;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);			
			
			$this->id=$expensesDBO->id;
			$this->sql=$expensesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$expensesDBO = new ExpensesDBO();
		if($expensesDBO->update($obj,$where)){
			
			$id = $obj->id;
			$obj->id="";
			
			//get expense type account
			$categorys = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->expensecategoryid' and acctypeid='6' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$categorys = $categorys->fetchObject;
			
			//adding general journal account(s)
			$name=$obj->name;
			$obj->id="";
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$id;
			$obj->acctypeid=4;
			$obj->currencyid=5;
			$obj->categoryid=$categorys->id;
			$generaljournalaccounts->setObject($obj);
			
			//get expense type account
			$expenses = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$id' and acctypeid='4' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$expenses->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo $expenses->sql;
			if($expenses->affectedRows>0){
			  $expenses = $expenses->fetchObject;
			  $generaljournalaccounts->id=$expenses->id;
			  $generaljournalaccounts->edit($generaljournalaccounts);
			}else{
			  $generaljournalaccounts->add($generaljournalaccounts);
			}
			
			$this->sql=$expensesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$expensesDBO = new ExpensesDBO();
		if($expensesDBO->delete($obj,$where=""))		
			$this->sql=$expensesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$expensesDBO = new ExpensesDBO();
		$this->table=$expensesDBO->table;
		$expensesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$expensesDBO->sql;
		$this->result=$expensesDBO->result;
		$this->fetchObject=$expensesDBO->fetchObject;
		$this->affectedRows=$expensesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
