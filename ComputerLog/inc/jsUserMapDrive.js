
app.controller('UserMapDriveController', function($scope,$http,$compile,$uibModal,$rootScope) {
	var LogUserArrayList=new Object ;
	
	$scope.userTab=1;
//----------------------Get All Users----------------------------------
	
	 var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogUserMapDrive.php",
		    data: {  	
		    	 mode:"getAllUsers"	
		    },
		
		});
		request.success(function (data) {
			$scope.LogAllUsers=data
		});

//-------------------Get All Map Drives--------------------------------
		
		var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUserMapDrive.php",
			    data: {  	
			    	 mode:"getAllMapDrives"	
			    },
			
			});
			request.success(function (data) {
				$scope.LogAllUsers=data
			});
		
			
			$scope.logUserTab=function(){
				console.log("1");
				$scope.userTab=1;
				$scope.vpnTab=0;
				$scope.mapdriveTab=0;
			}
			
			$scope.logUserOtherTab=function($data){
				console.log($data);
				$scope.userTab=0;
				if($data=="vpn")
					$scope.vpnTab=1;
				else if($data=="drive")
					$scope.mapdriveTab=1;
			}
			
			
			
	$scope.saveDisclimar=function(){
		
		var UserList={};
		if($scope.log_user_id=='' || $scope.log_user_id==undefined || $scope.log_user_id==0)
			$scope.user_id=0;
		else
			$scope.user_id=$scope.log_user_id;
		
		UserList={'log_user_id':$scope.user_id,'LogFirstName':$scope.log_user_firstname,'LogLastName':$scope.log_user_lastname,
				'Email_id':$scope.log_user_email,'username':$scope.log_user_username,'Domain':$scope.log_user_domain,
				'location':$scope.log_user_location}
		LogUserArrayList['User']=UserList;
		
		 var JsonQuoteListArray=JSON.stringify(LogUserArrayList);
		 
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  
			    	 logArrayList:JsonQuoteListArray,
			    	 mode:"saveLogUser"	
			    },
			
			});
			request.success(function (data) {
				$("#log_save_user").notify("saved Sucessful","success");
				$scope.log_user_id=0;
				$scope.log_user_firstname='';
				$scope.log_user_lastname='';
				$scope.log_user_email='';
				$scope.log_user_username='';
				$scope.log_user_domain='';
				$scope.log_user_location='';
			});
		}

	
	
});



