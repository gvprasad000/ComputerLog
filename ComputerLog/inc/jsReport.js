
app.controller('LogReportController', function($scope,$http,$compile,$uibModal,$rootScope) {
	$scope.ReportScreen=1;
	
	    	setTimeout(function(){
	    		$scope.selectScreen(1);
	    	},100);
	  
	    
	    $scope.selectScreen=function($value){
	    	if($value==1){
	    		$scope.ShowReportUser=1;
	    		$('#log_report_user').empty();
	    		 var request = $http({
	    			    method: "post",
	    			    url: "./inc/ajaxIncludes/ajxReport.php",
	    			    data: {
	    			    	 mode:"GetUserButton"	
	    			    },
	    		    	   
	    		    	});

	    		    	request.success(function (data) {
	    		    		console.log(data);
	    		    		$size=data.length;
	    		    		var dataHtml=' <div class="form-group">'+
	    		    						'<div class="form-row">';
	    		    		for($count=0;$count<$size;$count++){
	    		    			 dataHtml+='<div class="col-md-4">'+
						            		'<button id="log_save_history" type="button" ng-click="'+data[$count]['str_file_name']+'" class="btn btn-primary btn-block" ><i class="fa fa-fw fa-file"></i>'+data[$count]['str_item_name']+'</button>'+
						            	'</div>';
	    		    		}
	    		    		dataHtml+='</div></div>';
	    		    		 var element=$compile(dataHtml)($scope);
	    						$("#log_report_user").append(element);
	    						
	    		    	});
	    	}else if($value==2){
	    		$scope.ShowReportUser=0;
	    	}else if($value==3){
	    		$scope.ShowReportUser=0;
	    	}
	    		
	    }
	    
	    $scope.getUserIp=function(){
	    	var location = "inc/ajaxIncludes/ajxReport.php?";
	    	var postVars = "mode=getUserIp";
	    	window.open(location+postVars, "DbLogPage");
	    /*	var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxReport.php",
			    data: {  
			    	
			    	 mode:"test"	
			    },
			
			});
			request.success(function (data) {
				
			});*/
	    }

});



