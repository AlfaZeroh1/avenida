<?php 
require_once("TasksDBO.php");
require_once("../../../modules/auth/roles/Roles_class.php");
require_once("../../../modules/hrm/employees/Employees_class.php");
require_once("../../../modules/pm/notifications/Notifications_class.php");
require_once("../../../modules/pm/notificationrecipients/Notificationrecipients_class.php");

class Tasks
{				
	var $id;			
	var $name;			
	var $description;			
	var $projectid;			
	var $routedetailid;			
	var $routeid;			
	var $projecttype;			
	var $employeeid;			
	var $ownerid;			
	var $assignmentid;			
	var $documenttype;			
	var $documentno;			
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
	var $taskid;	
	var $origtask;
	var $statusid;	
	var $remarks;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $tasksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->description=str_replace("'","\'",$obj->description);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->projectid=str_replace("'","\'",$obj->projectid);
		if(empty($obj->routeid))
			$obj->routeid='NULL';
		$this->routeid=$obj->routeid;
		$this->routedetailid=str_replace("'","\'",$obj->routedetailid);
		$this->projecttype=str_replace("'","\'",$obj->projecttype);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->ownerid=str_replace("'","\'",$obj->ownerid);
		if(empty($obj->assignmentid))
			$obj->assignmentid='NULL';
		$this->assignmentid=$obj->assignmentid;
		$this->documenttype=str_replace("'","\'",$obj->documenttype);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->priority=str_replace("'","\'",$obj->priority);
		$this->tracktime=str_replace("'","\'",$obj->tracktime);
		$this->reqduration=str_replace("'","\'",$obj->reqduration);
		$this->reqdurationtype=str_replace("'","\'",$obj->reqdurationtype);
		$this->deadline=str_replace("'","\'",$obj->deadline);
		if(empty($obj->startdate)){
		  $obj->startdate=date("Y-m-d");
		}
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->starttime=str_replace("'","\'",$obj->starttime);
		$this->enddate=str_replace("'","\'",$obj->enddate);
		$this->endtime=str_replace("'","\'",$obj->endtime);
		$this->duration=str_replace("'","\'",$obj->duration);
		$this->durationtype=str_replace("'","\'",$obj->durationtype);
		$this->remind=str_replace("'","\'",$obj->remind);
		$this->taskid=str_replace("'","\'",$obj->taskid);
		$this->origtask=str_replace("'","\'",$obj->origtask);
		if(empty($obj->statusid))
			$obj->statusid='NULL';
		$this->statusid=$obj->statusid;
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

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get routeid
	function getRouteid(){
		return $this->routeid;
	}
	//set routeid
	function setRouteid($routeid){
		$this->routeid=$routeid;
	}

	//get projecttype
	function getProjecttype(){
		return $this->projecttype;
	}
	//set projecttype
	function setProjecttype($projecttype){
		$this->projecttype=$projecttype;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get ownerid
	function getOwnerid(){
		return $this->ownerid;
	}
	//set ownerid
	function setOwnerid($ownerid){
		$this->ownerid=$ownerid;
	}

	//get assignmentid
	function getAssignmentid(){
		return $this->assignmentid;
	}
	//set assignmentid
	function setAssignmentid($assignmentid){
		$this->assignmentid=$assignmentid;
	}

	//get documenttype
	function getDocumenttype(){
		return $this->documenttype;
	}
	//set documenttype
	function setDocumenttype($documenttype){
		$this->documenttype=$documenttype;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
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

	//get taskid
	function getTaskid(){
		return $this->taskid;
	}
	//set taskid
	function setTaskid($taskid){
		$this->taskid=$taskid;
	}

	//get origtask
	function getOrigtask(){
		return $this->origtask;
	}
	//set origtask
	function setOrigtask($origtask){
		$this->origtask=$origtask;
	}
	
	//get statusid
	function getStatusid(){
		return $this->statusid;
	}
	//set statusid
	function setStatusid($statusid){
		$this->statusid=$statusid;
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
		$tasksDBO = new TasksDBO();
		
		require_once("../../../modules/auth/users/Users_class.php");
		
		if(empty($obj->ownerid)){
		  $users = new Users();
		  $fields="*";
		  $where=" where id='".$_SESSION['userid']."'";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $users = $users->fetchObject;
		  
		  $obj->ownerid=$users->employeeid;
		}
		
		if(!empty($obj->employeeid) or !empty($obj->employee)){
		  if($tasksDBO->persist($obj)){
		  
			  
			  if(!empty($obj->employeeid) or !empty($obj->employee)){
			    //add notification
			    $notifications = new Notifications();
			    $notifications->subject=$obj->subject;//"Requisition Approval #".$obj->documentno;
			    $notifications->body=$obj->body;//"A Requisition has been raised tht requires your attention";
			    $notifications->taskid=$tasksDBO->id;
			    $notifications->createdby=$_SESSION['userid'];
			    $notifications->createdon=date("Y-m-d H:i:s");
			    $notifications->lasteditedby=$_SESSION['userid'];
			    $notifications->lasteditedon=date("Y-m-d H:i:s");
			    $notifications->ipaddress=$_SERVER['REMOTE_ADDR'];
			    $notifications->setObject($notifications);
			    $notifications->add($notifications);
			    
			    //add notification recipient
			    $notificationrecipients = new Notificationrecipients();
			    $nitificationrecipients->id="";
			    $notificationrecipients->notificationid=$notifications->id;		    
			    
			    $users = new Users();
			    $fields="auth_users.employeeid, hrm_employees.phoneno";
			    $where=" where auth_users.id='".$_SESSION['userid']."'";
			    $having="";
			    $groupby="";
			    $orderby="";
			    $join=" left join hrm_employees on hrm_employees.id=auth_users.employeeid ";
			    $users->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			    $users = $users->fetchObject;
			    
			    $notificationrecipients->fromemployeeid=$users->employeeid;
			    $notificationrecipients->email=$obj->email;
			    $notificationrecipients->tel=$users->phoneno;
			    $notificationrecipients->notifiedon=date("Y-m-d H:i:s");
			    $notificationrecipients->status="unread";
			    $notificationrecipients->body=$obj->body;
			    $notificationrecipients->createdby=$_SESSION['userid'];
			    $notificationrecipients->createdon=date("Y-m-d H:i:s");
			    $notificationrecipients->lasteditedby=$_SESSION['userid'];
			    $notificationrecipients->lasteditedon=date("Y-m-d H:i:s");
			    $notificationrecipients->ipaddress=$_SERVER['REMOTE_ADDR'];
			    
			    if(empty($obj->employee)){
			      $notificationrecipients->employeeid=$obj->employeeid;
			      
			      $nt = new Notificationrecipients();
			      $nt = $nt->setObject($notificationrecipients);
			      $nt->add($nt);
			    }else{
			      $employee = explode(",",$obj->employee);
			      $i=0;
			      while($i<count($employee)){
				$notificationrecipients->employeeid=$employee[$i];
			      
				$nt = new Notificationrecipients();
				$nt = $nt->setObject($notificationrecipients);
				$nt->add($nt);
				
				$i++;
				
			      }
			    }
			  }
			  
			  $this->id=$tasksDBO->id;
			  $this->sql=$tasksDBO->sql;
			  return true;	
		  }
		}
	}			
	function edit($obj,$where=""){
		$tasksDBO = new TasksDBO();
		if($tasksDBO->update($obj,$where)){
			$this->sql=$tasksDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$tasksDBO = new TasksDBO();
		if($tasksDBO->delete($obj,$where=""))		
			$this->sql=$tasksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tasksDBO = new TasksDBO();
		$this->table=$tasksDBO->table;
		$tasksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tasksDBO->sql;
		$this->result=$tasksDBO->result;
		$this->fetchObject=$tasksDBO->fetchObject;
		$this->affectedRows=$tasksDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Task Name should be provided";
		}
		else if(empty($obj->statusid)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
	
	function workFlow($obj, $wher=""){
		require_once("../../../modules/wf/routes/Routes_class.php");
		require_once("../../../modules/wf/routedetails/Routedetails_class.php");
		
		$routes = new Routes();
		$fields="wf_routes.*";
		$where=" where auth_roles.name='add $obj->module $obj->role' ";
		$join=" left join auth_roles on auth_roles.id=wf_routes.roleid ";
		$having="";
		$groupby="";
		$orderby="";
		$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$routes = $routes->fetchObject;
		
		$obj->routeid=$routes->id;		
		//get routedetailid
		$routedetails = new Routedetails();
		$fields="*";
		$join="";
		$where=" where routeid='$obj->routeid' and follows=0";
		$having="";
		$groupby="";
		$orderby="";
		$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$routedetails = $routedetails->fetchObject;
		
		$obj->workflow=1;	
		$obj->routedetailid=0;
		
		$obj->ownerid=$_SESSION['userid'];
		$obj->name=initialCap($obj->role);
		
		if(!empty($obj->documentno)){
		  $obj->name.="# ".$obj->documentno;
		}
		
		if(!empty($routedetails->assignmentid)){
		  $employees = new Employees();
		  $fields="*";
		  $join="";
		  $where=" where assignmentid='$routedetails->assignmentid' and hrm_employees.projectid='".$_SESSION['projectid']."'";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $employees = $employees->fetchObject;
		}
		elseif(!empty($routedetails->levelid) and (empty($routedetails->assignmentid) or $routedetails->assignmentid=='' or $routedetails->assignmentid=='NULL')){
		  
		  $employee = new Employees();
		  $fields=" hrm_assignments.departmentid ";
// 		  $join=" left join auth_users on auth_users.employeeid=hrm_employees.id left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		  $join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		  $where=" where hrm_employees.id='$obj->employeeid' ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $employee->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $employee = $employee->fetchObject;
		  
		  $employees = new Employees();
		  $fields=" hrm_employees.id ";
		  $join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid left join hrm_departments on hrm_departments.id=hrm_assignments.departmentid left join hrm_levels on hrm_levels.id=hrm_assignments.levelid  ";
		  $where=" where hrm_levels.id='$routedetails->levelid' and hrm_assignments.departmentid='$employee->departmentid'";
		  //$where=" where hrm_levels.id='$routedetails->levelid' and hrm_employees.projectid='".$_SESSION['projectid']."'";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $employees = $employees->fetchObject;
		}
		else{
		  $query = $routedetails->query." ".$wher;
		  $employees = mysql_fetch_object(mysql_query($query));
		}
		$obj->projectid-$obj->projectid;
		$obj->projecttype=initialCap($obj->role);
		$obj->assignmentid=$routedetails->assignmentid;
		$obj->employeeid=$employees->id;
		$obj->documenttype=initialCap($obj->role);
		$obj->documentno=$obj->documentno;
		$obj->tracktime="Yes";
		$obj->startdate=date("Y-m-d");
		$obj->starttime=date("H:i:s");
		$obj->reqduration=$routedetails->expectedduration;
		$obj->reqdurationtype=$routedetails->durationtype;
		$obj->createdby=$_SESSION['userid'];
		$obj->createdon=date("Y-m-d H:i:s");
		$obj->lasteditedby=$_SESSION['userid'];
		$obj->lasteditedon=date("Y-m-d H:i:s");
		$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
		if(empty($obj->statusid))
		  $obj->statusid=1;
		$obj->subject=$obj->name;
		$obj->body="A ".initialCap($obj->role)." has been raised that requires your attention. <br/>".$obj->remarks;
	
		$tasks = new Tasks();
		$tasks->processTask($obj,$wher);
			      
	}
	
	function processTask($obj,$wher=""){
	  $routedetailid = $obj->routedetailid;
	  //get next assignment after current one in workflow
	  if($obj->workflow==1 and $obj->statusid!=7){
	      $routedetails = new Routedetails();
	      $fields="wf_routedetails.*, hrm_employees.id employeeid, hrm_employees.officemail";
	      if(empty($obj->assignmentid))
		$where=" where wf_routedetails.routeid='$obj->routeid' and wf_routedetails.follows=0 ";
	      else
		$where=" where wf_routedetails.routeid='$obj->routeid' and wf_routedetails.follows='$obj->routedetailid' ";
	      $join=" left join hrm_assignments on hrm_assignments.id=wf_routedetails.assignmentid left join hrm_employees on hrm_employees.assignmentid=hrm_assignments.id ";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	      $routedetails = $routedetails->fetchObject;
	      if(!empty($routedetails->assignmentid)){
		$obj->employeeid=$routedetails->employeeid;
		$obj->assignmentid=$routedetails->assignmentid;
	      }
	      elseif(!empty($routedetails->levelid) and (empty($routedetails->assignmentid) or $routedetails->assignmentid=='' or $routedetails->assignmentid=='NULL')){
		  
		  $employee = new Employees();
		  $fields=" hrm_assignments.departmentid ";
// 		  $join=" left join auth_users on auth_users.employeeid=hrm_employees.id left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		  $join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid ";
		  $where=" where hrm_employees.id='$obj->employeeid' ";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $employee->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $employee = $employee->fetchObject;
		  
		  $employees = new Employees();
		  $fields=" hrm_employees.id, hrm_employees.assignmentid ";
		  $join=" left join hrm_assignments on hrm_assignments.id=hrm_employees.assignmentid left join hrm_departments on hrm_departments.id=hrm_assignments.departmentid left join hrm_levels on hrm_levels.id=hrm_assignments.levelid  ";
		  $where=" where hrm_levels.id='$routedetails->levelid' and hrm_assignments.departmentid='$employee->departmentid'";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $employees = $employees->fetchObject;
		  
		  $obj->employeeid=$employees->id;
		  $obj->assignmentid=$employees->assignmentid;
		}
	      else{
		$query = $routedetails->query." ".$wher;
		$employees = mysql_fetch_object(mysql_query($query));
		$obj->employeeid=$employees->id;
		$obj->assignmentid=$employees->assignmentid;
	      }
	      $obj->expectedduration=$routedetails->expectedduration;
	      $obj->durationtype=$routedetails->durationtype;
	      $obj->routedetailid = $routedetails->id;
	      $obj->squery=$routedetails->squery;
	      }
	      else{
		$employees = new Employees();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='$obj->employeeid'";
		$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$employees = $employees->fetchObject;
		$obj->employeeid=$employees->id;
		$obj->assignmentid=$employees->assignmentid;
	      }
	      
	      //create next task of requisition flow
	      $tasks = new Tasks();
	      $tasks->routeid=$obj->routeid;
	      $tasks->routedetailid=$obj->routedetailid;
	      $tasks->ownerid=$obj->ownerid;
	      $tasks->name=$obj->name;
	      $tasks->description=$obj->body;
	      $tasks->projectid=$obj->projectid;
	      $tasks->projecttype=$obj->projecttype;
	      $tasks->assignmentid=$obj->assignmentid;
	      $tasks->employeeid=$obj->employeeid;
	      $tasks->documenttype=$obj->documenttype;
	      $tasks->documentno=$obj->documentno;
	      $tasks->tracktime=$obj->tracktime;
	      $tasks->reqduration=$obj->expectedduration;
	      $tasks->reqdurationtype=$obj->durationtype;
	      $obj->statusid=1;
	      if(!empty($obj->startdate))
		$tasks->startdate=$obj->startdate;
	      else
		$tasks->startdate=date("Y-m-d");
	      if(!empty($obj->starttime))
		$tasks->starttime=$obj->starttime;
	      else
	      $tasks->starttime=date("H:i:s");
	      $tasks->createdby=$_SESSION['userid'];
	      $tasks->createdon=date("Y-m-d H:i:s");
	      $tasks->lasteditedby=$_SESSION['userid'];
	      $tasks->lasteditedon=date("Y-m-d H:i:s");
	      $tasks->ipaddress=$_SERVER['REMOTE_ADDR'];
	      $tasks->statusid=$obj->statusid;
	      $tasks->taskid=$obj->id;
	      $tasks->origtask=$obj->origtask;
	      
	      $tasks=$tasks->setObject($tasks);
	      $tasks->email=$routedetails->officemail;
	      $tasks->subject=$obj->subject;
	      $tasks->body=$obj->body;
	      $tasks->subject=$obj->name;
	      $tasks->employee=$routedetails->employee;
	      $tasks->add($tasks);
	      
	      
	      $routes = new Routedetails();
	      $fields="*";
	      $join="";
	      $having="";
	      $groupby="";
	      $orderby="";
	      $where=" where id='$routedetailid'";
	      $routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $routes->sql;
	      $routes = $routes->fetchObject;
	      
	      $employees = new Employees();
	      $fields=" * ";
	      $join="  ";
	      $where=" where id='".$_SESSION['employeeid']."'";
	      $employees->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $employees->sql;
	      $employees=$employees->fetchObject;
	      $idx=$employees->assignmentid;
	      	    	      
	      //effect squery
	      if(!empty($routes->squery) and ($obj->action=="Approve") and ($routes->assignmentid==$idx)){
		$query=strip_tags($routes->squery).$obj->documentno;//echo $query;
		if(!mysql_query($query)){
		  $err="Could not change status of ".$tasks->name;
		}
	      }
	      
	      return $tasks->id;
	      
	}
	
	function addTaskTrack($obj){
	  //add task tracktime
	  $tasktracks = new Tasktracks();
	  $tasktracks->taskid=$obj->id;
	  $tasktracks->origtask=$obj->origtask;
	  $tasktracks->statusid=$obj->statusid;
	  $tasktracks->remarks=$obj->remarks;
	  $tasktracks->changedon=date("Y-m-d H:i:s");
	  $tasktracks->createdby=$_SESSION['userid'];
	  $tasktracks->createdon=date("Y-m-d H:i:s");
	  $tasktracks->lasteditedby=$_SESSION['userid'];
	  $tasktracks->lasteditedon=date("Y-m-d H:i:s");
	  $tasktracks->ipaddress=$_SERVER['REMOTE_ADDR'];
	  $tasktracks->add($tasktracks);
	}
}				
?>
