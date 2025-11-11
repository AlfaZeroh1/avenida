<?php 
require_once("CategorysDBO.php");
class Categorys
{				
	var $id;			
	var $name;
	var $acctypeid;
	var $expensecategoryid;
	var $refid;
	var $remarks;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $categorysDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->acctypeid=str_replace("'","\'",$obj->acctypeid);
		$this->expensecategoryid=str_replace("'","\'",$obj->expensecategoryid);
		$this->refid=str_replace("'","\'",$obj->refid);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$categorysDBO = new CategorysDBO();
		if($categorysDBO->persist($obj)){
			
			if($obj->acctypeid==4){
			  $expenses = new Expenses();
			  $expenses->add($obj);
			  
			  mysql_query("update inv_categorys set refid='$expenses->id' where id='$categorysDBO->id'");
			  
			}else{			
			  //adding general journal account(s)
			  $name=$obj->name;
			  $obj->name=$name." Cost of Sales";
			  $generaljournalaccounts = new Generaljournalaccounts();
			  $obj->refid=$categorysDBO->id;
			  $obj->acctypeid=26;
			  $obj->currencyid=5;
			  $generaljournalaccounts->setObject($obj);
			  $generaljournalaccounts->add($generaljournalaccounts);
			}
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$categorysDBO->id;
			$obj->acctypeid=34;
			$obj->currencyid=5;
			$obj->categoryid="";
			$generaljournalaccounts->setObject($obj);
			$generaljournalaccounts->add($generaljournalaccounts);
			
			$this->id=$categorysDBO->id;
			$this->sql=$categorysDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$categorysDBO = new CategorysDBO();
		if($categorysDBO->update($obj,$where)){
			
			$id=$obj->id;
			$obj->id="";
			
			//get expense category
			$exps = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$obj->expensecategoryid' and acctypeid=6 ";
			$join="  ";
			$having="";
			$groupby="";
			$orderby="";
			$exps->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$exps = $exps->fetchObject;
			
			$obj->categoryid=$exps->id;
			
			if($obj->acctypeid==4){
			
			  $exp = new Expenses();
			  $fields="*";
			  $where=" where id='$obj->refid' ";
			  $join="  ";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $exp->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  $expenses = new Expenses();
			  if($exp->affectedRows>0){
			    $exp = $exp->fetchObject;
			    $obj->id=$exp->id;
			    $expenses->edit($obj);
			  }
			  else
			    $expenses->add($obj);
			  
			  mysql_query("update inv_categorys set refid='$expenses->id' where id='$categorysDBO->id'");
			  
			}else{			
			  //adding general journal account(s)
			  $name=$obj->name;
			  $obj->name=$name." Cost of Sales";
			  $generaljournalaccounts = new Generaljournalaccounts();
			  $obj->refid=$id;
			  $obj->acctypeid=26;
			  $obj->currencyid=5;
			  $generaljournalaccounts->setObject($obj);
			  
			  //get expense type account
			  $gn = new Generaljournalaccounts();
			  $fields="*";
			  $where=" where refid='$id' and acctypeid='26' ";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $gn->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			  if($gn->affectedRows>0){
			    $gn = $gn->fetchObject;
			    $generaljournalaccounts->id=$gn->id;
			    $generaljournalaccounts->edit($generaljournalaccounts);echo $generaljournalaccounts->sql;
			  }else
			    $generaljournalaccounts->add($generaljournalaccounts);
			}
			$name=$obj->name;
			$obj->name=$name;
			$generaljournalaccounts = new Generaljournalaccounts();
			$obj->refid=$id;
			$obj->acctypeid=34;
			$obj->currencyid=5;
			$obj->categoryid="";
			$generaljournalaccounts->setObject($obj);
			$gn = new Generaljournalaccounts();
			$fields="*";
			$where=" where refid='$id' and acctypeid='34' ";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$gn->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			if($gn->affectedRows>0){
			  $gn = $gn->fetchObject;
			  $generaljournalaccounts->id=$gn->id;
			  $generaljournalaccounts->edit($generaljournalaccounts);
			}else
			  $generaljournalaccounts->add($generaljournalaccounts);
			
			$this->sql=$categorysDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$categorysDBO = new CategorysDBO();
		if($categorysDBO->delete($obj,$where=""))		
			$this->sql=$categorysDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$categorysDBO = new CategorysDBO();
		$this->table=$categorysDBO->table;
		$categorysDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$categorysDBO->sql;
		$this->result=$categorysDBO->result;
		$this->fetchObject=$categorysDBO->fetchObject;
		$this->affectedRows=$categorysDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Category should be provided";
		}elseif(empty($obj->acctypeid)){
			$error="Account Type should be provided";
		}elseif($obj->acctypeid==4 and empty($obj->expensecategoryid)){
			$error="Expense Category should be provided";
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
