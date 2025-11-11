<?php 
require_once("ProjectworkschedulesDBO.php");
class Projectworkschedules
{				
	var $id;			
	var $projectboqid;			
	var $employeeid;			
	var $projectweek;			
	var $week;			
	var $year;			
	var $priority;			
	var $tracktime;			
	var $reqduration;			
	var $reqdurationtype;			
	var $deadline;			
	var $startdate;			
	var $starttime;			
	var $enddate;			
	var $endtime;			
	var $duration;			
	var $durationtype;			
	var $remind;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectworkschedulesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->projectboqid))
			$obj->projectboqid='NULL';
		$this->projectboqid=$obj->projectboqid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->projectweek=str_replace("'","\'",$obj->projectweek);
		$this->week=str_replace("'","\'",$obj->week);
		$this->year=str_replace("'","\'",$obj->year);
		$this->priority=str_replace("'","\'",$obj->priority);
		$this->tracktime=str_replace("'","\'",$obj->tracktime);
		$this->reqduration=str_replace("'","\'",$obj->reqduration);
		$this->reqdurationtype=str_replace("'","\'",$obj->reqdurationtype);
		$this->deadline=str_replace("'","\'",$obj->deadline);
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->starttime=str_replace("'","\'",$obj->starttime);
		$this->enddate=str_replace("'","\'",$obj->enddate);
		$this->endtime=str_replace("'","\'",$obj->endtime);
		$this->duration=str_replace("'","\'",$obj->duration);
		$this->durationtype=str_replace("'","\'",$obj->durationtype);
		$this->remind=str_replace("'","\'",$obj->remind);
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

	//get projectboqid
	function getProjectboqid(){
		return $this->projectboqid;
	}
	//set projectboqid
	function setProjectboqid($projectboqid){
		$this->projectboqid=$projectboqid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get projectweek
	function getProjectweek(){
		return $this->projectweek;
	}
	//set projectweek
	function setProjectweek($projectweek){
		$this->projectweek=$projectweek;
	}

	//get week
	function getWeek(){
		return $this->week;
	}
	//set week
	function setWeek($week){
		$this->week=$week;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get priority
	function getPriority(){
		return $this->priority;
	}
	//set priority
	function setPriority($priority){
		$this->priority=$priority;
	}

	//get tracktime
	function getTracktime(){
		return $this->tracktime;
	}
	//set tracktime
	function setTracktime($tracktime){
		$this->tracktime=$tracktime;
	}

	//get reqduration
	function getReqduration(){
		return $this->reqduration;
	}
	//set reqduration
	function setReqduration($reqduration){
		$this->reqduration=$reqduration;
	}

	//get reqdurationtype
	function getReqdurationtype(){
		return $this->reqdurationtype;
	}
	//set reqdurationtype
	function setReqdurationtype($reqdurationtype){
		$this->reqdurationtype=$reqdurationtype;
	}

	//get deadline
	function getDeadline(){
		return $this->deadline;
	}
	//set deadline
	function setDeadline($deadline){
		$this->deadline=$deadline;
	}

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get starttime
	function getStarttime(){
		return $this->starttime;
	}
	//set starttime
	function setStarttime($starttime){
		$this->starttime=$starttime;
	}

	//get enddate
	function getEnddate(){
		return $this->enddate;
	}
	//set enddate
	function setEnddate($enddate){
		$this->enddate=$enddate;
	}

	//get endtime
	function getEndtime(){
		return $this->endtime;
	}
	//set endtime
	function setEndtime($endtime){
		$this->endtime=$endtime;
	}

	//get duration
	function getDuration(){
		return $this->duration;
	}
	//set duration
	function setDuration($duration){
		$this->duration=$duration;
	}

	//get durationtype
	function getDurationtype(){
		return $this->durationtype;
	}
	//set durationtype
	function setDurationtype($durationtype){
		$this->durationtype=$durationtype;
	}

	//get remind
	function getRemind(){
		return $this->remind;
	}
	//set remind
	function setRemind($remind){
		$this->remind=$remind;
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
		$projectworkschedulesDBO = new ProjectworkschedulesDBO();
		if($projectworkschedulesDBO->persist($obj)){
			//$this->id=$projectworkschedulesDBO->id;
			
			//add this dates to project quantities
			$projectquantities = new Projectquantities();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where projectboqdetailid in(select id from con_projectboqdetails where projectboqid='$obj->projectboqid')";
			$projectquantities->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$res=$projectquantities->result;
			while($row=mysql_fetch_object($res)){
			  $ob = $row;
			  $prj = new Projectquantities();
			  $ob->projectweek=$obj->projectweek;
			  $ob->week=$obj->week;
			  $ob->year=$obj->year;
			  $prj = $prj->setObject($ob);
			  $prj->edit($prj);
			}
			
			$this->sql=$projectworkschedulesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectworkschedulesDBO = new ProjectworkschedulesDBO();
		if($projectworkschedulesDBO->update($obj,$where)){
			$this->sql=$projectworkschedulesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectworkschedulesDBO = new ProjectworkschedulesDBO();
		if($projectworkschedulesDBO->delete($obj,$where=""))		
			$this->sql=$projectworkschedulesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectworkschedulesDBO = new ProjectworkschedulesDBO();
		$this->table=$projectworkschedulesDBO->table;
		$projectworkschedulesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectworkschedulesDBO->sql;
		$this->result=$projectworkschedulesDBO->result;
		$this->fetchObject=$projectworkschedulesDBO->fetchObject;
		$this->affectedRows=$projectworkschedulesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->projectboqid)){
			$error="BoQ Item should be provided";
		}
		else if(empty($obj->projectweek)){
			$error="Project Week should be provided";
		}
		else if(empty($obj->week)){
			$error="Calendar Week should be provided";
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
