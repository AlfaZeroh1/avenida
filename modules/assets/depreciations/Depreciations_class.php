<?php 
require_once("DepreciationsDBO.php");
class Depreciations
{				
	var $id;			
	var $assetid;			
	var $depreciatedon;			
	var $amount;			
	var $perc;			
	var $month;			
	var $year;			
	var $createdon;			
	var $createdby;			
	var $lasteditedon;			
	var $lasteditedby;			
	var $depreciationsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->assetid))
			$obj->assetid='NULL';
		$this->assetid=$obj->assetid;
		$this->depreciatedon=str_replace("'","\'",$obj->depreciatedon);
		$this->amount=str_replace("'","\'",$obj->amount);
		$this->perc=str_replace("'","\'",$obj->perc);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
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

	//get assetid
	function getAssetid(){
		return $this->assetid;
	}
	//set assetid
	function setAssetid($assetid){
		$this->assetid=$assetid;
	}

	//get depreciatedon
	function getDepreciatedon(){
		return $this->depreciatedon;
	}
	//set depreciatedon
	function setDepreciatedon($depreciatedon){
		$this->depreciatedon=$depreciatedon;
	}

	//get amount
	function getAmount(){
		return $this->amount;
	}
	//set amount
	function setAmount($amount){
		$this->amount=$amount;
	}

	//get perc
	function getPerc(){
		return $this->perc;
	}
	//set perc
	function setPerc($perc){
		$this->perc=$perc;
	}

	//get month
	function getMonth(){
		return $this->month;
	}
	//set month
	function setMonth($month){
		$this->month=$month;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}

	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	function add($obj){
		$depreciationsDBO = new DepreciationsDBO();
		if($depreciationsDBO->persist($obj)){
			
			//check that depreciation and accumulated depreciation accounts exist
			$query="select * from fn_generaljournalaccounts where refid='$obj->assetid' and acctypeid=21";
			$res = mysql_query($query);
			if(mysql_affected_rows()==0){
			  //get asset account
			  $query2="select * from fn_generaljournalaccounts where refid='$obj->assetid' and acctypeid=7";
			  $asset = mysql_fetch_object(mysql_query($query2));
			  
			  //create account
			  $gn = new Generaljournalaccounts();
			  $gn->createdby=$_SESSION['userid'];
			  $gn->createdon=date("Y-m-d H:i:s");
			  $gn->lasteditedby=$_SESSION['userid'];
			  $gn->lasteditedon=date("Y-m-d H:i:s");
			  $gn->ipaddress=$_SERVER['REMOTE_ADDR'];
			  $gn->name = $asset->name." Depreciation";
			  $gn->categoryid=$asset->id;
			  $gn->acctypeid=21;
			  $gn->refid=$obj->assetid;
			  
			  $gn = $gn->setObject($gn);
			  $gn->add($gn);
			  
			  $accountid = $gn->id;
			}else{
			  $row = mysql_fetch_object($res);
			  $accountid=$row->id;
			}
			
			$query1="select * from fn_generaljournalaccounts where refid='$obj->assetid' and acctypeid=22";
			$res1 = mysql_query($query1);
			if(mysql_affected_rows()==0){
			  //get asset account
			  $query2="select * from fn_generaljournalaccounts where refid='$obj->assetid' and acctypeid=7";
			  $asset = mysql_fetch_object(mysql_query($query2));
			  
			  //create account
			  $gn = new Generaljournalaccounts();
			  $gn->createdby=$_SESSION['userid'];
			  $gn->createdon=date("Y-m-d H:i:s");
			  $gn->lasteditedby=$_SESSION['userid'];
			  $gn->lasteditedon=date("Y-m-d H:i:s");
			  $gn->ipaddress=$_SERVER['REMOTE_ADDR'];
			  $gn->name = $asset->name." Acc Depreciation";
			  $gn->categoryid=$asset->id;
			  $gn->acctypeid=22;
			  $gn->refid=$obj->assetid;
			  
			  $gn = $gn->setObject($gn);
			  $gn->add($gn);
			  
			  $daccountid = $gn->id;
			}else{
			  $row = mysql_fetch_object($res1);
			  $daccountid=$row->id;
			}
			
			//effect journals
			$shpgeneraljournals = array();
			$it=0;
			
			//make debit entry
			$generaljournal = new Generaljournals();
			$ob->tid=$depreciationsDBO->id;
			$ob->documentno="$obj->documentno";
			$ob->memo=$obj->memo;
			$ob->remarks = "Depreciation ".getMonth($obj->month)." ".$obj->year;
			$ob->accountid=$accountid;
			$ob->daccountid=$daccountid;
			$ob->transactionid=$transaction->id;
			$ob->mode=$obj->paymentmodeid;
			$ob->credit=0;
			$ob->debit=$obj->amount;
			
			$ob->class="B";
			$generaljournal = $generaljournal->setObject($ob);
			
			$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'documentno'=>"$generaljournal->documentno", 'remarks'=>"$generaljournal->remarks", 'class'=>"B", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->depreciatedon",'class'=>"$generaljournal->class",'transactionid'=>"$generaljournal->transactionid");
			
			$it++;
			
			$generaljournal = new Generaljournals();
			$ob->tid=$depreciationsDBO->id;
			$ob->documentno="$obj->documentno";
			$ob->memo=$obj->memo;
			$ob->remarks = "Depreciation ".getMonth($obj->month)." ".$obj->year;
			$ob->accountid=$daccountid;
			$ob->daccountid=$accountid;
			$ob->transactionid=$transaction->id;
			$ob->mode=$obj->paymentmodeid;
			$ob->debit=0;
			$ob->credit=$obj->amount;
			
			$ob->class="B";
			$generaljournal = $generaljournal->setObject($ob);
			
			$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'documentno'=>"$generaljournal->documentno", 'remarks'=>"$generaljournal->remarks", 'class'=>"B", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$obj->depreciatedon",'class'=>"$generaljournal->class",'transactionid'=>"$generaljournal->transactionid");
			
			$gn = new Generaljournals();
			$gn->add($obj, $shpgeneraljournals);
			
			$this->id=$depreciationsDBO->id;
			$this->sql=$depreciationsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$depreciationsDBO = new DepreciationsDBO();
		if($depreciationsDBO->update($obj,$where)){
			$this->sql=$depreciationsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$depreciationsDBO = new DepreciationsDBO();
		if($depreciationsDBO->delete($obj,$where=""))		
			$this->sql=$depreciationsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$depreciationsDBO = new DepreciationsDBO();
		$this->table=$depreciationsDBO->table;
		$depreciationsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$depreciationsDBO->sql;
		$this->result=$depreciationsDBO->result;
		$this->fetchObject=$depreciationsDBO->fetchObject;
		$this->affectedRows=$depreciationsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
