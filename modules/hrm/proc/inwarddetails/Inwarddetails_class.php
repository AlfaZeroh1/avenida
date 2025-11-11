<?php 
require_once("InwarddetailsDBO.php");
// require_once("../../../modules/inv/assets/Assets_class.php");
class Inwarddetails
{				
	var $id;			
	var $inwardid;			
	var $itemid;
	var $categoryid;
	var $discount;
	var $discountamount;
	var $rate;
	var $eurorate;
	var $currencyid;
	var $transactdate;
	var $quantity;			
	var $costprice;	
	var $vatclasseid;
	var $tax;
	var $total;			
	var $memo;
	var $status;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $inwarddetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->inwardid))
			$obj->inwardid='NULL';
		$this->inwardid=$obj->inwardid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
		
		if(empty($obj->vatclasseid))
			$obj->vatclasseid='NULL';
		$this->vatclasseid=$obj->vatclasseid;
		
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->discountamount=str_replace("'","\'",$obj->discountamount);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->total=str_replace("'","\'",$obj->total);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->rate=str_replace("'","\'",$obj->rate);
		$this->eurorate=str_replace("'","\'",$obj->eurorate);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
		$this->transactdate=str_replace("'","\'",$obj->transactdate);
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

	//get inwardid
	function getInwardid(){
		return $this->inwardid;
	}
	//set inwardid
	function setInwardid($inwardid){
		$this->inwardid=$inwardid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get costprice
	function getCostprice(){
		return $this->costprice;
	}
	//set costprice
	function setCostprice($costprice){
		$this->costprice=$costprice;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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

	function add($obj,$shop,$bool){
		$inwarddetailsDBO = new InwarddetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		$it=0;
		
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='inward'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$obj->exchangerate=$obj->rate;
		$obj->exchangerate2=$obj->eurorate;
		$obj->currencyid=$obj->currencyid;
		$obj->transactdate=$obj->inwarddate;
		
		$vats = array();
		$total=0;
		
		while($i<$num){
			if($shop[$i]['id']=='true' or $bool=='true'){
			  $obj->remarks=$shop[$i]['remarks'];
			  $obj->itemid=$shop[$i]['itemid'];
			  $obj->id=$shop[$i]['inwarddetailid'];
			  $obj->itemname=$shop[$i]['itemname'];
			  $obj->categoryid=$shop[$i]['assetid'];
			  $obj->assetname=$shop[$i]['assetname'];
			  $obj->costprice=$shop[$i]['costprice'];
			  $obj->discount=$shop[$i]['discount'];
			  $obj->discountamount=$shop[$i]['discountamount'];
			  $obj->tradeprice=$shop[$i]['tradeprice'];
			  $obj->quantity=$shop[$i]['quantity'];
			  $obj->vatclasseid=$shop[$i]['vatclasseid'];
			  $obj->tax=$shop[$i]['tax'];		  
			  $obj->memo=$shop[$i]['memo'];
			  
			  //this goes to current asset account
			  $obj->total=(($obj->quantity*$obj->costprice)-($obj->quantity*$obj->costprice*$obj->discount/100))*(100+$obj->tax)/100;
			  //this goes Vat control account
			  $vats[$obj->vatclasseid]['amount']+=(($obj->quantity*$obj->costprice)-($obj->quantity*$obj->costprice*$obj->discount/100))*($obj->tax/100);
			  //this goes to Stock control account
			  $total+=(($obj->quantity*$obj->costprice)-($obj->quantity*$obj->costprice*$obj->discount/100))*(100+$obj->tax)/100;
			  
			  $ob = $this->setObject($obj);
			  
			  $ob->effectjournals=$obj->effectjournals;
			  
			  if($inwarddetailsDBO->persist($ob)){		  
				  
				  
				  if($obj->itemid!='NULL' and !empty($obj->itemid)){
				  
				      if(empty($ob->effectjournals)){
					$its = new Items();
					
					$stocktrack = new Stocktrack();
					$obj->recorddate=$obj->inwarddate;
					
					$its->getItemValue($obj->itemid,$obj->quantity,($obj->costprice*$obj->rate));
					if($obj->type=="in"){
					  $obj->transaction="GRN";
					  $stocktrack->addStock($obj);
					}
					else{
					  $obj->transaction="RETURN NOTE";
					  $stocktrack->reduceStock($obj);
					}
				      }
				  
				  $items = new Items();
				  $fields="*";
				  $where=" where id = '$obj->itemid' ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $items=$items->fetchObject;
				  
				  //debit inventory account
				  $generaljournalaccounts2 = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid = '$items->categoryid' and acctypeid='34' ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
				  }else{
				 
				  //push to assets
				  $assets = new Assets();
				  $assets->name=$obj->assetname." GRN:".$obj->documentno." #".($i+1);
				  $assets->categoryid=$obj->categoryid;
				  $assets->purchasedon=$obj->inwarddate;
				  $assets->deliveryno=$obj->documentno;
				  $assets->lpono=$obj->lpono;
				  $assets->supplierid=$obj->supplierid;
				  $assets->value=$obj->costprice;
				  $assets->serialno=$obj->memo;
				  $assets = $assets->setObject($assets);
				  $assets->add($assets);
				  				  
				  $generaljournalaccounts2 = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid = '$assets->id' and acctypeid='7' ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;				  
				  }
				  
				  //make debit entry
				  $generaljournal = new Generaljournals();
				  $ob->tid=$inwarddetailsDBO->id;
				  $ob->documentno="$obj->documentno";
				  $ob->remarks="GRN $obj->documentno: ".$obj->suppliername;
				  $ob->memo=$inwarddetailsDBO->remarks;
				  $ob->accountid=$generaljournalaccounts2->id;
				  $ob->daccountid=$generaljournalaccounts->id;
				  $ob->transactionid=$transaction->id;
				  $ob->mode="credit";
				  if($obj->type=='in'){
				    $ob->debit=$obj->total;
				    $ob->credit=0;
				  }else{
				    $ob->credit=$obj->total;
				    $ob->debit=0;
				  }
				  $ob->class=$obj->projectid;
				  $ob->currencyid=$obj->currencyid;
				  
				  $generaljournal = $generaljournal->setObject($ob);

				  if($generaljournal->debit!=0 or $generaljournal->credit!=0){
				    $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
				    $it++;
				  }
				  
				  $this->id=$inwarddetailsDBO->id;
				  $this->sql=$inwarddetailsDBO->sql;
			 }
			}
			$i++;
		}
		
		//get stock control account from configuration
		$config = new Config();
		$fields=" * ";
		$join="  ";
		$where=" where id='3' ";
		$config->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$config = $config->fetchObject;

		//debit inventory account
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid = '$config->value' and acctypeid='35' ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		
		//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$inwarddetailsDBO->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="GRN $obj->documentno: ".$obj->suppliername;
		$ob->memo=$inwarddetailsDBO->remarks;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		if($obj->type=='in'){
		  $ob->debit=0;
		  $ob->credit=$total;
		}else{
		  $ob->credit=0;
		  $ob->debit=$total;
		}
		$ob->class=$obj->projectid;
		$generaljournal = $generaljournal->setObject($ob);
		
		if($generaljournal->debit!=0 or $generaljournal->credit!=0){
		  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		  $it++;
		}
		
		//make credit entries to VAT liability accounts
		/*foreach ($vats as $key => $value) {
		  if($value>0){
				    
		      $vatclasses = new Vatclasses();
		      $fields="*";
		      $where=" where id='$key'";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $vatclasses->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $vatclasses->sql;
		      $vatclasses=$vatclasses->fetchObject;
		      
		      //debit Vat account
		      $generaljournalaccounts2 = new Generaljournalaccounts();
		      $fields="*";
		      $where=" where refid = '$vatclasses->liabilityid' and acctypeid=35 ";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		      $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
		      
		      //make debit entry
		      $generaljournal = new Generaljournals();
		      $ob->tid=$purchasedetails->id;
		      $ob->documentno="$obj->documentno";
		      $ob->remarks="GRN $obj->documentno: ".$obj->suppliername;
		      $ob->memo=$purchasedetails->remarks;
		      $ob->accountid=$generaljournalaccounts2->id;
		      $ob->daccountid=$generaljournalaccounts->id;
		      $ob->transactionid=$transaction->id;
		      $ob->mode="credit";
		      $ob->rate=$obj->rate;
		      $ob->eurorate=$obj->eurorate;
		      if($obj->type=="in"){
			$ob->debit=$value['amount'];
			$ob->credit=0;
		      }else{
			$ob->credit=$value['amount'];
			$ob->debit=0;
		      }
		      $ob->class=$obj->projectid;
		      $generaljournal = $generaljournal->setObject($ob);

		      $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		      $it++;			  
		      
		    }
		}*/
// 		print_r($shpgeneraljournals);
		$gn= new Generaljournals();
		if($obj->effectjournals==1)
		  $gn->add($obj,$shpgeneraljournals);
				
		return true;	
	}			
	function edit($obj,$where=""){
		$inwarddetailsDBO = new InwarddetailsDBO();
		if($inwarddetailsDBO->update($obj,$where)){
			$this->sql=$inwarddetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$inwarddetailsDBO = new InwarddetailsDBO();
		if($inwarddetailsDBO->delete($obj,$where))		
			$this->sql=$inwarddetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$inwarddetailsDBO = new InwarddetailsDBO();
		$this->table=$inwarddetailsDBO->table;
		$inwarddetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$inwarddetailsDBO->sql;
		$this->result=$inwarddetailsDBO->result;
		$this->fetchObject=$inwarddetailsDBO->fetchObject;
		$this->affectedRows=$inwarddetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->inwardid)){
			$error="Inward should be provided";
		}
		else if(empty($obj->itemid)){
			$error="Item should be provided";
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
