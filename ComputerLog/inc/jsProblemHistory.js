

app.controller('LogHistoryProblemController', function($scope,$http,$rootScope,$compile) {
	
	var LogHistoryProblemArrayList=new Object ;
	$scope.ShowProblem=0;
	$scope.ShowHistory=1;
	$scope.HistoryProblemSaveType=1;

	$scope.logProblemHistoryTab=function($data){
		$scope.ShowHistory=0;
		if($data=='History'){
			$scope.ShowHistory=1;
			$scope.ShowProblem=0;
			$scope.HistoryProblemSaveType=1;
		}else if($data=='Problem'){
			
			$scope.ShowHistory=0;
			$scope.ShowProblem=1;
			$scope.HistoryProblemSaveType=2;
		}
	}
	
	$scope.saveLogHistoryProblem=function(){
		if($scope.HistoryProblemSaveType==undefined || $scope.HistoryProblemSaveType==null || $scope.HistoryProblemSaveType=='')
			$scope.HistoryProblemSaveType=1;
		
		if($scope.HistoryProblemSaveType==1){
			var HistoryTypeList={};
			$intpk_history_type=$('#intpk_history_type').attr('name');
			
			HistoryTypeList={'intpk_history_type':$intpk_history_type,'str_history_desc':$scope.log_history_type};
			LogHistoryProblemArrayList['History']=HistoryTypeList;
			  var JsonSoftwareListArray=JSON.stringify(LogHistoryProblemArrayList);
			 
			  var request = $http({
				    method: "post",
				    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
				    data: {  
				    	 logArrayList:JsonSoftwareListArray,
				    	 mode:"saveLogHistory"	
				    },
				
				});
				request.success(function (data) {
					$('#intpk_history_type').attr('name','');
					$("#log_save_history").notify("saved Sucessful","success");
					$scope.log_history_type='';
					
			});
		}else if($scope.HistoryProblemSaveType==2){
			if($scope.logItemTypeId!='' && $scope.logItemTypeId!=undefined && $scope.logItemTypeId!=null &&
					$scope.logProblemItemId!='' && $scope.logProblemItemId!=undefined && $scope.logProblemItemId!=null &&
					$scope.logProblemTypeId!='' && $scope.logProblemTypeId!=undefined && $scope.logProblemTypeId!=null &&
					$scope.LogProblemDteOccured!='' && $scope.LogProblemDteOccured!=undefined && $scope.LogProblemDteOccured!=null &&
					$scope.logProblemActive!='' && $scope.logProblemActive!=undefined && $scope.logProblemActive!=null){
				var ProblemList={};
				$intpk_problem_id=$('#intpk_problem_id').attr('name');
				  var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
					    data: {  
					    	intpk_problem_id:$scope.logItemTypeId,
					    	intfk_problem_item_id:$scope.logProblemItemId,
					    	mode:"LogGetAllItemId"	
					    },
					
					});
					request.success(function (data) {
						$scope.LogSelectedAllItemId=data[0]['intpk_all_item_id'];
						ProblemList={'intpk_problem_id':$intpk_problem_id,'intfk_all_item_id':$scope.LogSelectedAllItemId,'intfk_history_type_id':$scope.logProblemTypeId,
								'str_pblm_desc':$scope.LogProblemDesc,'dte_problem_occured':$scope.LogProblemDteOccured,'bln_pblm':$scope.logProblemActive,'int_fixed_user_id':$scope.logProblemUserFixed,
								'dte_resolution':$scope.LogProblemDteResolution,'str_resolution_desc':$scope.LogProblemResolutionDesc};
						
						LogHistoryProblemArrayList['Problem']=ProblemList;
						var JsonSoftwareListArray=JSON.stringify(LogHistoryProblemArrayList);
						
						  var request = $http({
							    method: "post",
							    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
							    data: {  
							    	 logArrayList:JsonSoftwareListArray,
							    	 mode:"saveLogProblems"	
							    },
							
							});
							request.success(function (data) {
								$('#intpk_problem_id').attr('name','');
								$("#log_save_history").notify("saved Sucessful","success");
								$scope.logItemTypeId='';
								$scope.logProblemItemId='';
								$scope.logProblemTypeId='';
								$scope.LogProblemDesc='';
								$scope.LogProblemDteOccured='';
								$scope.logProblemActive='';
								$scope.logProblemUserFixed='';
								$scope.LogProblemDteResolution='';
								$scope.LogProblemResolutionDesc='';
								$rootScope.$broadcast('logDashBoardRefresh', { message: 'Refresh' });
								
						});
						
				});
		   }else{
			   
			   if($scope.logItemTypeId=='' || $scope.logItemTypeId==undefined || $scope.logItemTypeId==null) 
				   $("#logItemTypeId").notify("Please select the problem","error");
			   else if($scope.logProblemItemId=='' || $scope.logProblemItemId==undefined || $scope.logProblemItemId==null)
				   $("#logProblemItemId").notify("Please select the Item","error");
			   else if($scope.logProblemTypeId=='' || $scope.logProblemTypeId==undefined || $scope.logProblemTypeId==null)
				   $("#logProblemTypeId").notify("Please select the History Type","error");
			   else if($scope.LogProblemDteOccured=='' || $scope.LogProblemDteOccured==undefined || $scope.LogProblemDteOccured==null)
				   $("#LogProblemDteOccured").notify("Please Enter Date occured","error");
			   else if($scope.logProblemActive=='' || $scope.logProblemActive==undefined || $scope.logProblemActive==null)
				   $("#logProblemActive").notify("Please choose Active Type","error");
		   }
		}
	}
	
	$scope.logHistoryTypeSearch=function(){
		  var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
			    data: {  
			    	 log_histroy_type:$scope.log_history_type_search_dialogue,
			    	 mode:"LogHistroyTypeSearch"	
			    },
			
			});
			request.success(function (data) {
				$scope.logHistoryTypes=data;
				
				
		});
	}
	
	$scope.logHistoryTypeSelectedItem=function($intpk_history_type,str_history_desc){
		$('#intpk_history_type').attr('name',$intpk_history_type);
		$scope.log_history_type=str_history_desc;
	}
	
	$scope.logHistoryTypeRecordDelete=function($intpk_history_type){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
		    data: {  
		    	intpk_history_type:$intpk_history_type,
		    	 mode:"LogDeleteSelectedHistroyType"	
		    },
	
		});
		request.success(function (data) {
			$scope.logHistoryTypeSearch();
		});
	}
	
	$scope.logGetItemTable=function(){
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
			$scope.logGetItemTables=data;
		});
	}
	
	$scope.logItemTypeselected=function($intpk_item_type_id){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
		    data: {  
		    	 intpk_item_type_id:$intpk_item_type_id,
		    	 mode:"LogItemTypeselected"	
		    },
	
		});
		request.success(function (data) {
			$scope.SelectedItemTable=$intpk_item_type_id;
			$scope.AllItems=data;
		});
	}
	
	$scope.logProblemType=function(){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
		    data: {  
		    	 mode:"LogProblemType"	
		    },
	
		});
		request.success(function (data) {
			$scope.logProblemTypes=data;
		});
	}
	
	$scope.logAllUser=function(){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
		    data: {  
		    	 mode:"LogAllUser"	
		    },
	
		});
		request.success(function (data) {
			$scope.LogAllUsers=data;
		});
	}
	
	$scope.logproblemSearch=function(){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
		    data: {  
		    	 intfk_item_id:$scope.logProblemSearchItemTypeId,
		    	 dte_start:$scope.LogProblemSearchStartDte,
		    	 dte_end:$scope.LogProblemSearchEndDte,
		    	 intfk_fixed_user:$scope.logProblemSearchUserFixed,
		    	 mode:"LogGetAllProblemsSearch"	
		    },
	
		});
		request.success(function (data) {
			$("#LogProblemSearchTable tr").detach();
			$scope.searchId=$scope.logProblemSearchItemTypeId;
			$scope.LogProblemSearchDatas=data;
			
		});
	}
	
	$scope.logProblemSelectedItem=function($intpk_problem_history_id){
		
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
		    data: {
		    	 intpk_problem_history_id:$intpk_problem_history_id,
		    	 mode:"LogProblemSelectedItem"	
		    },
	
		});
		request.success(function (data) {
			
			$('#intpk_history_type').attr('name',data['0']['intpk_problem_history_id']);
			$scope.LogSelectedProblem=data;
			$scope.logItemTypeId=data['0']['intfk_item_id'];
			var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogHistoryProblem.php",
			    data: {  
			    	 intpk_item_type_id:$scope.logItemTypeId,
			    	 mode:"LogItemTypeselected"	
			    },
		
			});
			request.success(function (data) {
				$('#intpk_problem_id').attr('name',$intpk_problem_history_id);
				$scope.SelectedItemTable=$scope.logItemTypeId;
				$scope.AllItems=data;
				console.log(data);
				$scope.logProblemItemId=$scope.LogSelectedProblem['0']['intfk_item_type_id'];
				$scope.logProblemTypeId=$scope.LogSelectedProblem['0']['intfk_history_type_id'];
				$scope.LogProblemDesc=$scope.LogSelectedProblem['0']['str_pblm_desc'];
				var date = new Date($scope.LogSelectedProblem['0']['dte_problem_occured']);
				date=(date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear() + ' '+ date.getHours()+ ':' + date.getMinutes();
				$scope.LogProblemDteOccured=date;
				$scope.logProblemActive=$scope.LogSelectedProblem['0']['bln_pblm'];
				$scope.logProblemUserFixed=$scope.LogSelectedProblem['0']['int_fixed_user_id'];
				if($scope.LogSelectedProblem['0']['dte_resolution']!=null){
					var date2 = new Date($scope.LogSelectedProblem['0']['dte_resolution']);
					date2=(date2.getMonth() + 1) + '/' + date2.getDate() + '/' +  date2.getFullYear()+ ' '+ date2.getHours()+ ':' + date2.getMinutes();
					if(date2=='1/1/1900 0:0')
						$scope.LogProblemDteResolution='';
					else
						$scope.LogProblemDteResolution=date2;
				}else
					$scope.LogProblemDteResolution='';
				$scope.LogProblemResolutionDesc=$scope.LogSelectedProblem['0']['str_ressolution'];
			});	
		});
	}
	
	 $scope.$on('logProblemSelectedItem', function (event, args) {
		
		 $scope.HistoryProblemSaveType=2;
		 $scope.Message = args.message;
		 $scope.logGetItemTable();
		 $scope.logAllUser();
		 $scope.logProblemType();
         $scope.logProblemSelectedItem($scope.Message) ;
        
     })
 
});

