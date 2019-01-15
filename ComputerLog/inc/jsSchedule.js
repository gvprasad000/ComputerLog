

app.controller('LogScheduleController', function($scope,$http,$rootScope,$compile) {
	
	var LogScheduleSaveArrayList=new Object ;
	var LogScheduleDaysArrayList=new Object ;
	var LogScheduleWeekArrayList=new Object ;
	var LogScheduleMonthsArrayList=new Object ;
	
	$scope.ShowSchedule=1;
	$scope.ScheduleSaveType=1;
	setTimeout(function(){ 
		$scope.logScheduleGetItemTable();
		$scope.logScheduleProblemType();
		$scope.logScheduleAllUser();
	}, 300);
	
	$scope.logScheduleGetItemTable=function(){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
		    data: {  
		    	 mode:"logGetItemTable"	
		    },
	
		});
		request.success(function (data) {
			
			data[0]['str_item_type_name']="Component";
			data[1]['str_item_type_name']="Hardware";
			data[2]['str_item_type_name']="Hardware Component";
			data[3]['str_item_type_name']="Hardware Peripheral";
			data[4]['str_item_type_name']="Hardware Software";
			data[5]['str_item_type_name']="Hardware Type";
			data[6]['str_item_type_name']="History Type";
			data[7]['str_item_type_name']="Ip Address";
			data[8]['str_item_type_name']="Map Drive";
			data[9]['str_item_type_name']="Problem";
			data[10]['str_item_type_name']="Software";
			data[11]['str_item_type_name']="Software Record";
			data[12]['str_item_type_name']="User";
			data[13]['str_item_type_name']="User Hardware";
			data[14]['str_item_type_name']="User Map Drive";
			data[15]['str_item_type_name']="Vpn";
			$scope.logScheduleGetItemTables=data;
		});
	}
	
	$scope.logScheduleItemTypeselected=function($intpk_item_type_id){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
		    data: {  
		    	 intpk_item_type_id:$intpk_item_type_id,
		    	 mode:"LogItemTypeselected"	
		    },
	
		});
		request.success(function (data) {
			$scope.SelectedScheduleItemTable=$intpk_item_type_id;
			$scope.ScheduleAllItems=data;
		});
	}
	
	$scope.logScheduleProblemType=function(){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
		    data: {  
		    	 mode:"LogProblemType"	
		    },
	
		});
		request.success(function (data) {
			$scope.logScheduleProblemTypes=data;
		});
	}
	
	$scope.logScheduleAllUser=function(){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
		    data: {  
		    	 mode:"LogAllUser"	
		    },
	
		});
		request.success(function (data) {
			$scope.LogScheduleAllUsers=data;
		});
	}
	
	$scope.logScheduleType=function($int_schedule_type){
		$scope.int_schedule_type=$int_schedule_type;
		var days={};
		var week={};
		var month={};
		var TotalWeekArray=['Monday','Tuesday','Wednesday','Thursday','Friday','saturday','Sunday']
		days={'int_value':'1','str_desc':'All Days'};
		var TotaldaysOfMonth=['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']
		for($count=0;$count<7;$count++){
			week={'int_week_value':$count+1,'str_week_desc':TotalWeekArray[$count]};
			LogScheduleWeekArrayList[$count]=week;
		}
		for($count=0;$count<31;$count++){
			month={'int_month_value':$count+1,'str_month_desc':TotaldaysOfMonth[$count]};
			LogScheduleMonthsArrayList[$count]=month;
		}
		
		if($int_schedule_type==1){
			LogScheduleDaysArrayList[0]=days;
			$scope.SchedulePickDays=LogScheduleDaysArrayList;
		}else if($int_schedule_type==2){
			$scope.SchedulePickDays=LogScheduleWeekArrayList;
		}else if($int_schedule_type==3){
			$scope.SchedulePickDays=LogScheduleMonthsArrayList;
		}
	}
	
	$scope.saveLogSchedule=function(){
		var ScheduleSaveArray={};
		var intpk_schedule_id=$('#intpk_schedule_id').attr('name');
		ScheduleSaveArray={'intpk_schedule_id':intpk_schedule_id,'intfk_schedule_for_id':$scope.logschedulefor,
				'intfk_schedule_item_id':$scope.logScheduleItem,'intfk_schedule_histry_type':$scope.logScheduleHistoryType,
				'intfk_schedule_user_id':$scope.logScheduleUser,'intfk_schedule_type':$scope.logscheduleType,'int_pick_day':$scope.logscheduleday,
				'str_schedule_desc':$scope.LogScheduleDesc};
		LogScheduleSaveArrayList['Schedule']=ScheduleSaveArray;
		var JsonSoftwareListArray=JSON.stringify(LogScheduleSaveArrayList);
		
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogSchedule.php",
		    data: {  
		    	 mode:"SaveLogSchedule",
		    	 logArrayList:JsonSoftwareListArray
		    },
	
		});
		request.success(function (data) {
			$scope.logschedulefor='';
			$scope.logScheduleItem='';
			$scope.logScheduleHistoryType='';
			$scope.logScheduleUser='';
			$scope.logscheduleType='';
			$scope.logscheduleday='';
			$scope.LogScheduleDesc='';
		});
		
	}
	
	$scope.logScheduleDialogsearch=function(){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogSchedule.php",
		    data: {  
		    	 mode:"LogScheduleSearch",
		    	 intfk_item_id:$scope.logschedulesearchfor
		    	 
		    },
	
		});
		request.success(function (data) {
			$scope.searchScheduleId=$scope.logschedulesearchfor;
			$scope.logScheduleSearchItmes=data;
		});
	}
	
	$scope.logScheduleSelectedItem=function($intpk_schedule_id){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogSchedule.php",
		    data: {  
		    	 mode:"LogScheduleSearchSelectedItem",
		    	 intpk_schedule_id:$intpk_schedule_id
		    	 
		    },
	
		});
		request.success(function (data) {
			$('#intpk_schedule_id').attr('name',$intpk_schedule_id);
			$scope.logschedulefor=data[0]['intfk_item_id'];
			$scope.logScheduleItemTypeselected($scope.logschedulefor);
			$scope.logScheduleItem=data[0]['intfk_item_type_id'];
			$scope.logScheduleHistoryType=data[0]['intfk_history_type_id'];
			$scope.logScheduleUser=data[0]['intfk_user_id'];
			
			if(data[0]['int_day']!=null){
				$scope.logscheduleType='1';
				$scope.logScheduleType(1);
				$scope.logscheduleday=data[0]['int_day'];
			}else if(data[0]['int_week']!=null){
				$scope.logscheduleType='2';
				$scope.logScheduleType(2);
				$scope.logscheduleday=data[0]['int_week'];
			}else if(data[0]['int_month']!=null){
				$scope.logscheduleType='3';
				$scope.logScheduleType(3);
				$scope.logscheduleday=data[0]['int_month'];
			}
			$scope.LogScheduleDesc=data[0]['str_schedule_desc'];
		});
	}
	
 
});

