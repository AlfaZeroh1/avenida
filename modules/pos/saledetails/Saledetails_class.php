<?php 
require_once("SaledetailsDBO.php");
class Saledetails
{				
	var $id;			
	var $saleid;			
	var $itemid;			
	var $quantity;			
	var $costprice;			
	var $tradeprice;			
	var $retailprice;			
	var $discount;			
	var $tax;
	var $exchangerate;
	var $currencyid;
	var $exchangerate2;
	var $bonus;			
	var $profit;			
	var $total;	
	var $memo;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $saledetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->saleid))
			$obj->saleid='NULL';
		$this->saleid=$obj->saleid;
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->exchangerate=str_replace("'","\'",$obj->exchangerate);
		$this->exchangerate2=str_replace("'","\'",$obj->exchangerate2);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->retailprice=str_replace("'","\'",$obj->retailprice);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->bonus=str_replace("'","\'",$obj->bonus);
		$this->profit=str_replace("'","\'",$obj->profit);
		$this->total=str_replace("'","\'",$obj->total);
		$this->memo=str_replace("'","\'",$obj->memo);
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

	//get saleid
	function getSaleid(){
		return $this->saleid;
	}
	//set saleid
	function setSaleid($saleid){
		$this->saleid=$saleid;
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

	//get tradeprice
	function getTradeprice(){
		return $this->tradeprice;
	}
	//set tradeprice
	function setTradeprice($tradeprice){
		$this->tradeprice=$tradeprice;
	}

	//get retailprice
	function getRetailprice(){
		return $this->retailprice;
	}
	//set retailprice
	function setRetailprice($retailprice){
		$this->retailprice=$retailprice;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get bonus
	function getBonus(){
		return $this->bonus;
	}
	//set bonus
	function setBonus($bonus){
		$this->bonus=$bonus;
	}

	//get profit
	function getProfit(){
		return $this->profit;
	}
	//set profit
	function setProfit($profit){
		$this->profit=$profit;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
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

	function add($obj,$shop){
		$saledetailsDBO = new SaledetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){

			

			$obj->quantity=$shop[$i]['quantity'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->code=$shop[$i]['code'];
			$obj->stock=$shop[$i]['stock'];
			$obj->tax=$shop[$i]['tax'];
			$obj->discount=$shop[$i]['discount'];
			$obj->retailprice=$shop[$i]['retailprice'];
			$obj->tradeprice=$shop[$i]['tradeprice'];
			$obj->total=$shop[$i]['total'];
			$obj->memo=$shop[$i]['memo'];
			
			$total+=$obj->total;
			$saledetails=new Saledetails();
			$saledetails=$saledetails->setObject($obj);
			
			if($saledetailsDBO->persist($obj)){		
				$this->id=$saledetailsDBO->id;
				$this->sql=$saledetailsDBO->sql;
			}
			$i++;
		}

				//Make a journal entry

				//retrieve account to debit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		if($obj->mode=="cashretail" or $obj->mode=="cashwholesale")
		  $where=" where refid='2' and acctypeid='24'";
		else
		  $where=" where refid='$obj->customerid' and acctypeid='29'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;

				//retrieve account to credit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='5' and acctypeid='25'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

				//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='sales'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;

		$it=0;

		$obj->transactdate=$obj->soldon;

				//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$saledetails->id;
		$ob->documentno="$obj->documentno";
		if($obj->mode=="cashretail" or $obj->mode=="cashwholesale")
		  $ob->remarks="Local Sales: $obj->documentno";
		else
	        $ob->remarks="Sale of Invoice $obj->documentno";
		$ob->memo=$obj->memo;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=$total;
		$ob->credit=0;
		$ob->class=$obj->projectid;
		$ob->transactdate=$obj->soldon;
		$generaljournal->setObject($ob);

		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
		$it++;


				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$saledetails->id;
		$ob->documentno=$obj->documentno;
		if($obj->mode=="cashretail" or $obj->mode=="cashwholesale")
		  $ob->remarks="Local Sales: $obj->documentno";
		else
		  $ob->remarks="Invoice $obj->documentno to $obj->customername";
		$ob->memo=$obj->memo;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=0;
		$ob->class=$obj->projectid;
		$ob->credit=$total;
		$ob->transactdate=$obj->soldon;
		$generaljournal2->setObject($ob);
		$shpgeneraljournals[$it]=array('tid'=>"$generaljournal2->tid",'documentno'=>"$generaljournal2->documentno",'remarks'=>"$generaljournal2->remarks",'memo'=>"$generaljournal2->memo",'accountid'=>"$generaljournal2->accountid",'transactionid'=>"$generaljournal2->transactionid",'mode'=>"$generaljournal2->mode",'debit'=>"$generaljournal2->debit",'credit'=>"$generaljournal2->credit",'transactdate'=>"$generaljournal2->transactdate",'class'=>"$generaljournal2->class");

		$gn= new Generaljournals();
		$gn->add($obj,$shpgeneraljournals);

		return true;	
	}			
	function edit($obj,$where=""){
		$saledetailsDBO = new SaledetailsDBO();
		if($saledetailsDBO->update($obj,$where)){
			$this->sql=$saledetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$saledetailsDBO = new SaledetailsDBO();
		if($saledetailsDBO->delete($obj,$where=""))		
			$this->sql=$saledetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$saledetailsDBO = new SaledetailsDBO();
		$this->table=$saledetailsDBO->table;
		$saledetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$saledetailsDBO->sql;
		$this->result=$saledetailsDBO->result;
		$this->fetchObject=$saledetailsDBO->fetchObject;
		$this->affectedRows=$saledetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->saleid)){
			$error="Sale should be provided";
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
