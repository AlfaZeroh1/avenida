<?php 
require_once("ExpensecategorysDBO.php");
class Expensecategorys
{				
	var $id;			
	var $name;
	var $expensetypeid;
	var $remarks;			
	var $expensecategorysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->expensetypeid=str_replace("'","\'",$obj->expensetypeid);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	function add($obj){
		$expensecategorysDBO = new ExpensecategorysDBO();
		if($expensecategorysDBO->persist($obj)){
			
			//get expense type account
			$expensetypes = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->expensetypeid' and acctypeid='5' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$expensetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$expensetypes = $expensetypes->fetchObject;
			
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$expensecategorysDBO->id;
			if($expensetypes->acctypeid=26)
			  $obj->acctypeid=26;
			else	
			  $obj->acctypeid=6;
			$obj->currencyid=5;
			$obj->categoryid=$expensetypes->id;
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			$this->id=$expensecategorysDBO->id;
			$this->sql=$expensecategorysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$expensecategorysDBO = new ExpensecategorysDBO();
		if($expensecategorysDBO->update($obj,$where)){
			
			$id = $obj->id;
			$obj->id="";
			
			$expensetype = new Expensetypes();
			$fields="*";
			$where=" where id='$obj->expensetypeid' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$expensetype->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$expensetype = $expensetype->fetchObject;
			
			if($expensetype->acctypeid=="26"){
			  $type="cos";
			  $acctypeid=$expensetype->acctypeid;
			}
			else{	
			  $type="expensetype";
			  $acctypeid=5;
			}
			  
			//get expense type account
			$expensetypes = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$expensetype->id' and acctypeid='$acctypeid' and type='$type' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$expensetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $expensetypes->sql;
			$expensetypes = $expensetypes->fetchObject;
			
			//adding general journal account(s)
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$id;
			$obj->acctypeid=6;
			$obj->currencyid=5;
			$obj->type=$type;
			$obj->categoryid=$expensetypes->id;
			$generaljournalaccounts = $generaljournalaccounts->setObject($obj);
			
			
			//get expense type account
			$expensecategorys = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$id' and acctypeid='6' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$expensecategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			if($expensecategorys->affectedRows>0){
			  $expensecategorys = $expensecategorys->fetchObject;
			  $generaljournalaccounts->id=$expensecategorys->id;
			  $generaljournalaccounts->edit($generaljournalaccounts);
			}else{
			  $generaljournalaccounts->add($generaljournalaccounts);
			}
			
			$this->sql=$expensecategorysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$expensecategorysDBO = new ExpensecategorysDBO();
		if($expensecategorysDBO->delete($obj,$where=""))		
			$this->sql=$expensecategorysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$expensecategorysDBO = new ExpensecategorysDBO();
		$this->table=$expensecategorysDBO->table;
		$expensecategorysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$expensecategorysDBO->sql;
		$this->result=$expensecategorysDBO->result;
		$this->fetchObject=$expensecategorysDBO->fetchObject;
		$this->affectedRows=$expensecategorysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Expense Category should be provided";
		}elseif(empty($obj->expensetypeid)){
			$error="Expense Type should be provided";
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
