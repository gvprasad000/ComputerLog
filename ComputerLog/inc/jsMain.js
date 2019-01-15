


app.controller('MainController', function($scope,$http,$rootScope) {


		var request = $http({
	    method: "post",
	    url: "./inc/ajaxIncludes/ajxMain.php",
	    data: {

	    	 mode:"LogGetAllProblems"	
	    },
    	   
    	});

    	request.success(function (data) {
    		$scope.startCount=0;
    		$size=data.length;
    		
    		for($cnt=0;$cnt<$size;$cnt++){
    			
    			if(data[$cnt]['intfk_item_id']==6)
    				data[$cnt]['str_item_type_name']='Component';
    			else if(data[$cnt]['intfk_item_id']==7)
    				data[$cnt]['str_item_type_name']='Hardware';
    			else if(data[$cnt]['intfk_item_id']==8)
    				data[$cnt]['str_item_type_name']='Hardware Component';
    			else if(data[$cnt]['intfk_item_id']==10)
    				data[$cnt]['str_item_type_name']='Hardware Peripheral';
    			else if(data[$cnt]['intfk_item_id']==14)
    				data[$cnt]['str_item_type_name']='Hardware Software';
    			else if(data[$cnt]['intfk_item_id']==5)
    				data[$cnt]['str_item_type_name']='Hardware Type';
    			else if(data[$cnt]['intfk_item_id']==15)
    				data[$cnt]['str_item_type_name']='History Type';
    			else if(data[$cnt]['intfk_item_id']==9)
    				data[$cnt]['str_item_type_name']='IP Address';
    			else if(data[$cnt]['intfk_item_id']==2)
    				data[$cnt]['str_item_type_name']='Map Drive';
    			else if(data[$cnt]['intfk_item_id']==16)
    				data[$cnt]['str_item_type_name']='Problem History';
    			else if(data[$cnt]['intfk_item_id']==12)
    				data[$cnt]['str_item_type_name']='Software';
    			else if(data[$cnt]['intfk_item_id']==13)
    				data[$cnt]['str_item_type_name']='Software Record';
    			else if(data[$cnt]['intfk_item_id']==1)
    				data[$cnt]['str_item_type_name']='User';
    			else if(data[$cnt]['intfk_item_id']==11)
    				data[$cnt]['str_item_type_name']='User Hardware';
    			else if(data[$cnt]['intfk_item_id']==3)
    				data[$cnt]['str_item_type_name']='User Map Drive';
    			else if(data[$cnt]['intfk_item_id']==4)
    				data[$cnt]['str_item_type_name']='VPN';
    			
    			
    		}
    		$scope.LogGetAllProblems=data;
    	});	
	
    //---------------Schedule Alert for days----------------------------------
    	
    	var request = $http({
    	    method: "post",
    	    url: "./inc/ajaxIncludes/ajxMain.php",
    	    data: {

    	    	 mode:"LogGetScheduleDays"	
    	    },
        	   
        	});

        	request.success(function (data) {
        		$size=data.length;
        		for($cnt=0;$cnt<$size;$cnt++){
        			
        			if(data[$cnt]['intfk_item_id']==6)
        				data[$cnt]['str_item_type_name']='Component';
        			else if(data[$cnt]['intfk_item_id']==7)
        				data[$cnt]['str_item_type_name']='Hardware';
        			else if(data[$cnt]['intfk_item_id']==8)
        				data[$cnt]['str_item_type_name']='Hardware Component';
        			else if(data[$cnt]['intfk_item_id']==10)
        				data[$cnt]['str_item_type_name']='Hardware Peripheral';
        			else if(data[$cnt]['intfk_item_id']==14)
        				data[$cnt]['str_item_type_name']='Hardware Software';
        			else if(data[$cnt]['intfk_item_id']==5)
        				data[$cnt]['str_item_type_name']='Hardware Type';
        			else if(data[$cnt]['intfk_item_id']==15)
        				data[$cnt]['str_item_type_name']='History Type';
        			else if(data[$cnt]['intfk_item_id']==9)
        				data[$cnt]['str_item_type_name']='IP Address';
        			else if(data[$cnt]['intfk_item_id']==2)
        				data[$cnt]['str_item_type_name']='Map Drive';
        			else if(data[$cnt]['intfk_item_id']==16)
        				data[$cnt]['str_item_type_name']='Problem History';
        			else if(data[$cnt]['intfk_item_id']==12)
        				data[$cnt]['str_item_type_name']='Software';
        			else if(data[$cnt]['intfk_item_id']==13)
        				data[$cnt]['str_item_type_name']='Software Record';
        			else if(data[$cnt]['intfk_item_id']==1)
        				data[$cnt]['str_item_type_name']='User';
        			else if(data[$cnt]['intfk_item_id']==11)
        				data[$cnt]['str_item_type_name']='User Hardware';
        			else if(data[$cnt]['intfk_item_id']==3)
        				data[$cnt]['str_item_type_name']='User Map Drive';
        			else if(data[$cnt]['intfk_item_id']==4)
        				data[$cnt]['str_item_type_name']='VPN';
	
        		}
        		$scope.LogscheduleDays=data;
        	});	 
      
    //---------------Schedule Alert for Weeks----------------------------------
        	
        	var request = $http({
        	    method: "post",
        	    url: "./inc/ajaxIncludes/ajxMain.php",
        	    data: {

        	    	 mode:"LogGetScheduleWeeks"	
        	    },
            	   
            	});

            	request.success(function (data) {
            		$size=data.length;
            		for($cnt=0;$cnt<$size;$cnt++){
            			
            			if(data[$cnt]['intfk_item_id']==6)
            				data[$cnt]['str_item_type_name']='Component';
            			else if(data[$cnt]['intfk_item_id']==7)
            				data[$cnt]['str_item_type_name']='Hardware';
            			else if(data[$cnt]['intfk_item_id']==8)
            				data[$cnt]['str_item_type_name']='Hardware Component';
            			else if(data[$cnt]['intfk_item_id']==10)
            				data[$cnt]['str_item_type_name']='Hardware Peripheral';
            			else if(data[$cnt]['intfk_item_id']==14)
            				data[$cnt]['str_item_type_name']='Hardware Software';
            			else if(data[$cnt]['intfk_item_id']==5)
            				data[$cnt]['str_item_type_name']='Hardware Type';
            			else if(data[$cnt]['intfk_item_id']==15)
            				data[$cnt]['str_item_type_name']='History Type';
            			else if(data[$cnt]['intfk_item_id']==9)
            				data[$cnt]['str_item_type_name']='IP Address';
            			else if(data[$cnt]['intfk_item_id']==2)
            				data[$cnt]['str_item_type_name']='Map Drive';
            			else if(data[$cnt]['intfk_item_id']==16)
            				data[$cnt]['str_item_type_name']='Problem History';
            			else if(data[$cnt]['intfk_item_id']==12)
            				data[$cnt]['str_item_type_name']='Software';
            			else if(data[$cnt]['intfk_item_id']==13)
            				data[$cnt]['str_item_type_name']='Software Record';
            			else if(data[$cnt]['intfk_item_id']==1)
            				data[$cnt]['str_item_type_name']='User';
            			else if(data[$cnt]['intfk_item_id']==11)
            				data[$cnt]['str_item_type_name']='User Hardware';
            			else if(data[$cnt]['intfk_item_id']==3)
            				data[$cnt]['str_item_type_name']='User Map Drive';
            			else if(data[$cnt]['intfk_item_id']==4)
            				data[$cnt]['str_item_type_name']='VPN';
    	
            		}
            		$scope.LogscheduleWeeks=data;
            	});	
    //---------------Schedule Alert for Months----------------------------------
            	
            	var request = $http({
            	    method: "post",
            	    url: "./inc/ajaxIncludes/ajxMain.php",
            	    data: {

            	    	 mode:"LogGetScheduleMonths"	
            	    },
                	   
                	});

                	request.success(function (data) {
                		$size=data.length;
                		for($cnt=0;$cnt<$size;$cnt++){
                			
                			if(data[$cnt]['intfk_item_id']==6)
                				data[$cnt]['str_item_type_name']='Component';
                			else if(data[$cnt]['intfk_item_id']==7)
                				data[$cnt]['str_item_type_name']='Hardware';
                			else if(data[$cnt]['intfk_item_id']==8)
                				data[$cnt]['str_item_type_name']='Hardware Component';
                			else if(data[$cnt]['intfk_item_id']==10)
                				data[$cnt]['str_item_type_name']='Hardware Peripheral';
                			else if(data[$cnt]['intfk_item_id']==14)
                				data[$cnt]['str_item_type_name']='Hardware Software';
                			else if(data[$cnt]['intfk_item_id']==5)
                				data[$cnt]['str_item_type_name']='Hardware Type';
                			else if(data[$cnt]['intfk_item_id']==15)
                				data[$cnt]['str_item_type_name']='History Type';
                			else if(data[$cnt]['intfk_item_id']==9)
                				data[$cnt]['str_item_type_name']='IP Address';
                			else if(data[$cnt]['intfk_item_id']==2)
                				data[$cnt]['str_item_type_name']='Map Drive';
                			else if(data[$cnt]['intfk_item_id']==16)
                				data[$cnt]['str_item_type_name']='Problem History';
                			else if(data[$cnt]['intfk_item_id']==12)
                				data[$cnt]['str_item_type_name']='Software';
                			else if(data[$cnt]['intfk_item_id']==13)
                				data[$cnt]['str_item_type_name']='Software Record';
                			else if(data[$cnt]['intfk_item_id']==1)
                				data[$cnt]['str_item_type_name']='User';
                			else if(data[$cnt]['intfk_item_id']==11)
                				data[$cnt]['str_item_type_name']='User Hardware';
                			else if(data[$cnt]['intfk_item_id']==3)
                				data[$cnt]['str_item_type_name']='User Map Drive';
                			else if(data[$cnt]['intfk_item_id']==4)
                				data[$cnt]['str_item_type_name']='VPN';
        	
                		}
                		$scope.LogscheduleMonths=data;
                	});	
    	
	$scope.openProblemDialogue=function($intpk_problem_history_id){
		$rootScope.$broadcast('logProblemSelectedItem', { message: $intpk_problem_history_id });
	}
	$scope.recordProblem=function($intpk_problem_history_id,$bln_active_status){
		$scope.LogRecordSelectedProblemId=$intpk_problem_history_id;
		$scope.LogRecordSelectedProblemStaus=$bln_active_status;
		
	}
	$scope.logChangeActiveStatus=function(){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxMain.php",
		    data: {
		    	 intpk_problem_history_id:$scope.LogRecordSelectedProblemId,
		    	 bln_active_status:$scope.LogRecordSelectedProblemStaus,
		    	 mode:"LogChangeActiveStatus"	
		    },
	    	   
	    	});

	    	request.success(function (data) {
	    		$scope.$broadcast('logDashBoardRefresh', { message: 'Refresh' });
	    	});
	}
    	
	 $scope.$on('logDashBoardRefresh', function (event, args) {
		 
			var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxMain.php",
			    data: {

			    	 mode:"LogGetAllProblems"	
			    },
		    	   
		    	});

		    	request.success(function (data) {
		    		$scope.startCount=0;
		    		$size=data.length;
		    		
		    		for($cnt=0;$cnt<$size;$cnt++){
		    			
		    			if(data[$cnt]['intfk_item_id']==6)
		    				data[$cnt]['str_item_type_name']='Component';
		    			else if(data[$cnt]['intfk_item_id']==7)
		    				data[$cnt]['str_item_type_name']='Hardware';
		    			else if(data[$cnt]['intfk_item_id']==8)
		    				data[$cnt]['str_item_type_name']='Hardware Component';
		    			else if(data[$cnt]['intfk_item_id']==10)
		    				data[$cnt]['str_item_type_name']='Hardware Peripheral';
		    			else if(data[$cnt]['intfk_item_id']==14)
		    				data[$cnt]['str_item_type_name']='Hardware Software';
		    			else if(data[$cnt]['intfk_item_id']==5)
		    				data[$cnt]['str_item_type_name']='Hardware Type';
		    			else if(data[$cnt]['intfk_item_id']==15)
		    				data[$cnt]['str_item_type_name']='History Type';
		    			else if(data[$cnt]['intfk_item_id']==9)
		    				data[$cnt]['str_item_type_name']='IP Address';
		    			else if(data[$cnt]['intfk_item_id']==2)
		    				data[$cnt]['str_item_type_name']='Map Drive';
		    			else if(data[$cnt]['intfk_item_id']==16)
		    				data[$cnt]['str_item_type_name']='Problem History';
		    			else if(data[$cnt]['intfk_item_id']==12)
		    				data[$cnt]['str_item_type_name']='Software';
		    			else if(data[$cnt]['intfk_item_id']==13)
		    				data[$cnt]['str_item_type_name']='Software Record';
		    			else if(data[$cnt]['intfk_item_id']==1)
		    				data[$cnt]['str_item_type_name']='User';
		    			else if(data[$cnt]['intfk_item_id']==11)
		    				data[$cnt]['str_item_type_name']='User Hardware';
		    			else if(data[$cnt]['intfk_item_id']==3)
		    				data[$cnt]['str_item_type_name']='User Map Drive';
		    			else if(data[$cnt]['intfk_item_id']==4)
		    				data[$cnt]['str_item_type_name']='VPN';
		    			
		    			
		    		}
		    		$scope.LogGetAllProblems=data;
		    	});	
     })
    
});




