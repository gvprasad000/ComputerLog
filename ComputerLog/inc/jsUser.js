
app.controller('LogUserController', function($scope,$http,$compile,$uibModal,$rootScope) {
	var LogUserArrayList=new Object ;
	$scope.userTab=1;
	$scope.vpnTab=0;
	$scope.mapdriveTab=0;
	//$scope.log_mapdrive_name=0;

	
//------------------$scope.saveType=1 its user's save $scope.saveType=2 its mapdrive $scope.saveType=3 its vpn-------------
	
	$scope.logUserTab=function($data){
		
		$scope.userTab=0;
		if($data=="vpn"){
			$scope.vpnTab=1;
			$scope.saveType=3;
		}
		else if($data=="drive"){
			$scope.mapdriveTab=1;
			$scope.saveType=2;
		}
		else if($data=="user"){
			$scope.userTab=1;
			$scope.vpnTab=0;
			$scope.mapdriveTab=0;
			$scope.saveType=1;
		}
	}
	$scope.userMapDriverLetters=function($userid){
		
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  
			    	 userId:$userid,
			    	 mode:"userMapDriverLetters"	
			    },
			
			});
			request.success(function (data) {
				$scope.LogAllLetters='';
				console.log("data");
				
				if(data!='null')
					$scope.LogAllLetters=data;
				console.log($scope.LogAllLetters);
			});
	}
	$scope.logMapDriveTab=function(){
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
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
				    url: "./inc/ajaxIncludes/ajxLogUser.php",
				    data: {  	
				    	 mode:"getAllMapDrives"	
				    },
				
				});
				request.success(function (data) {
					if(data!='null')
						$scope.LogAllMapDrives=data
				});
				
			var request = $http({
				    method: "post",
				    url: "./inc/ajaxIncludes/ajxLogUser.php",
				    data: {  	
				    	 mode:"getAllLetters"	
				    },
				
				});
				request.success(function (data) {
					if(data!='null')
						$scope.LogAllLetters=data
				});
			
	}
		
	$scope.saveLogUser=function(){
		if($scope.saveType==undefined || $scope.saveType==null || $scope.saveType=='')
			$scope.saveType=1;
		
		var UserList={};
		if($scope.saveType==1){
			if($scope.log_user_firstname!='' && $scope.log_user_firstname!=undefined &&
					$scope.log_user_domain!='' && $scope.log_user_domain!=undefined ){
					
				if($scope.log_user_id=='' || $scope.log_user_id==undefined || $scope.log_user_id==0)
					$scope.user_id=0;
				else
					$scope.user_id=$scope.log_user_id;
				
				if($scope.log_user_internet=='' || $scope.log_user_internet==undefined )
					$scope.log_user_internet=0;

				UserList={'log_user_id':$scope.user_id,'LogFirstName':$scope.log_user_firstname,'LogLastName':$scope.log_user_lastname,
						'Email_id':$scope.log_user_email,'username':$scope.log_user_username,'Domain':$scope.log_user_domain,
						'location':$scope.log_user_location,'saveType':$scope.saveType,'log_user_phone':$scope.log_user_phone,
						'log_user_extension':$scope.log_user_extension,'log_user_internet':$scope.log_user_internet}
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
						$scope.log_user_phone='';
						$scope.log_user_internet=0;
						$scope.log_user_extension='';
						
					});
				}else{
					if($scope.log_user_firstname=='' || $scope.log_user_firstname==undefined)
						$("#log_save_user").notify("Please Enter First name","error");
					else if($scope.log_user_domain=='' || $scope.log_user_domain==undefined )
						$("#log_save_user").notify("Please Enter Domain","error");
				
				}
		  }else if($scope.saveType==2){
			  if($scope.log_map_drive_user!='' && $scope.log_map_drive_user!=undefined &&
					  $scope.log_map_drive_letter!='' && $scope.log_map_drive_letter!=undefined &&
					  (($scope.log_mapdrive_name!='' && $scope.log_mapdrive_name!=undefined) || 
							  ($scope.log_mapdrive_new_name!='' && $scope.log_mapdrive_new_name!=undefined ))){
				  
					$intpk_user_map_drive_id=$('#UserMapDriveHeader').attr('name');
					
				  if($intpk_user_map_drive_id=='' || $intpk_user_map_drive_id==undefined || $intpk_user_map_drive_id==0)
						$scope.intpk_user_map_drive_id=0;
					else
						$scope.intpk_user_map_drive_id=$intpk_user_map_drive_id; 
			  var MapDriveUserList={};
			  MapDriveUserList={'log_intpk_user_map_drive_id':$scope.intpk_user_map_drive_id,'log_mapdrive_user_id':$scope.log_map_drive_user,'log_mapdrive_name_id':$scope.log_mapdrive_name,
					  'log_mapdrive_new_name':$scope.log_mapdrive_new_name,'log_map_drive_letter_id':$scope.log_map_drive_letter					  
			  }
			  LogUserArrayList['MapDriveUser']=MapDriveUserList;
			  var JsonQuoteListArray=JSON.stringify(LogUserArrayList);
			  var request = $http({
				    method: "post",
				    url: "./inc/ajaxIncludes/ajxLogUser.php",
				    data: {  
				    	 logArrayList:JsonQuoteListArray,
				    	 mode:"saveLogMapDriveUser"	
				    },
				
				});
				request.success(function (data) {
					$('#UserMapDriveHeader').attr('name','');
					$("#log_save_user_map_drive").notify("saved Sucessful","success");
					$scope.log_map_drive_user='';
					$scope.log_mapdrive_new_name='';
					$scope.log_mapdrive_name='';
					$scope.log_map_drive_letter='';
					$('#UserMapDriveHeader').attr('name',0);
					
				});
		  	}else{
		  		console.log("Error");
		  		if($scope.log_map_drive_user=='' || $scope.log_map_drive_user==undefined)
		  			$("#log_save_user_map_drive").notify("Please select User","error");
		  		else if($scope.log_map_drive_letter=='' || $scope.log_map_drive_letter==undefined )
		  			$("#log_save_user_map_drive").notify("Please select Driver Letter","error");
		  		else if(($scope.log_mapdrive_name=='' || $scope.log_mapdrive_name==undefined) && 
						  ($scope.log_mapdrive_new_name=='' || $scope.log_mapdrive_new_name==undefined )){
		  			$("#log_save_user_map_drive").notify("Please select or enter new Map drive","error");
		  		}
		  	}
		  }else if($scope.saveType==3){
			  if(($scope.log_user_vpn!='' && $scope.log_user_vpn!=undefined) &&
					  $scope.log_user_vpn_desc!='' && $scope.log_user_vpn_desc!=undefined){
				  $intpk_vpn_id=$('#UserVpnHeader').attr('name');
				  if($intpk_vpn_id=='' || $intpk_vpn_id==undefined || $intpk_vpn_id==0)
						$scope.intpk_vpn_id=0;
					else
						$scope.intpk_vpn_id=$intpk_vpn_id; 
				  var VpnUserList={};
				  VpnUserList={'log_intpk_vpn_id':$scope.intpk_vpn_id,'log_vpn_user_id':$scope.log_user_vpn,
						  'log_user_vpn_desc':$scope.log_user_vpn_desc			  
				  }
				  LogUserArrayList['VpnUser']=VpnUserList;
				  var JsonQuoteListArray=JSON.stringify(LogUserArrayList);
				  var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogUser.php",
					    data: {  
					    	 logArrayList:JsonQuoteListArray,
					    	 mode:"saveLogVpnUser"	
					    },
					
					});
					request.success(function (data) {
						$('#UserVpnHeader').attr('name',0);
						
					});
				  
			  }else{
				
				  if($scope.log_user_vpn=='' || $scope.log_user_vpn==undefined){
					  $("#log_save_user_vpn").notify("Please select User","error");
				  }else if($scope.log_user_vpn_desc=='' || $scope.log_user_vpn_desc==undefined){
					  $("#log_save_user_vpn").notify("Please enter vpn desc","error");
				  }
			  }
		   }
		}
	
	$scope.logUserDialogsearch=function(){
		
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  
			    	 username:$scope.log_user_dialog_firstname,
			    	 mode:"getLogUsers"	
			    },
			
			});
			request.success(function (data) {
				$scope.LogUserDialogSearchDatas=data;
			});
	}
	
	$scope.logMapdriveDialogsearch=function(){
		
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  
			    	 username:$scope.log_map_drive_dialog_firstname,
			    	 mode:"getLogMapDrive"	
			    },
			
			});
			request.success(function (data) {
				$scope.LogMapDriveDialogSearchDatas=data;
			});
	}
	
	$scope.logMapdriveNameChange=function($log_mapdrive_name){
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  
			    	 mapdriveId:$log_mapdrive_name,
			    	 mode:"getSelectedlogMapdrive"	
			    },
			
			});
			request.success(function (data) {
				$scope.log_mapdrive_new_name=data[0]['str_link_desc'];
			});
	}
	$scope.logVpnDialogsearch=function(){
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  
			    	username:$scope.log_vpn_dialog_firstname,
			    	 mode:"getVpnSearchDialoge"	
			    },
			
			});
			request.success(function (data) {
				console.log(data);
				$scope.LogVpnDialogSearchDatas=data;
			});
	}
	$scope.getLogDialogSelectedUser=function($intpk_user_id){
		$scope.log_user_id=$intpk_user_id;
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  
			    	 userId:$intpk_user_id,
			    	 mode:"getLogSelectedUser"	
			    },
			
			});
			request.success(function (data) {
				$scope.log_user_firstname=data[0]['str_firstname'];
				$scope.log_user_lastname=data[0]['str_lastname'];
				$scope.log_user_email=data[0]['str_email'];
				$scope.log_user_username=data[0]['str_username'];
				$scope.log_user_domain=data[0]['str_domain'];
				$scope.log_user_location=data[0]['str_location'];
				$scope.log_user_phone=data[0]['str_phone'];;
				$scope.log_user_internet=data[0]['str_extension'];;
				$scope.log_user_extension=data[0]['int_internet_access'];;
			});
	}
	
	$scope.getLogDialogSelectedUserMapDrive=function($intpk_user_map_drive_id){
		$scope.log_user_map_driveid=$intpk_user_map_drive_id;
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  
			    	 userMapDriveId:$intpk_user_map_drive_id,
			    	 mode:"getLogSelectedUserMapDrive"	
			    },
			
			});
			request.success(function (data) {
				$('#UserMapDriveHeader').attr('name',data[0]['intpk_user_map_drive_id']);
				$scope.log_map_drive_user=data[0]['intfk_user_id'];
				$scope.log_mapdrive_name=data[0]['intfk_mapdrive_id'];
				$scope.log_map_drive_letter=data[0]['infk_drive_letter'];
				$scope.logMapDriveTab();
				//$scope.userMapDriverLetters(data[0]['intfk_user_id']);
			});
	}
	$scope.getLogDialogSelectedUserVpn=function($intpk_vpn_id){
		$scope.intpk_vpn_id=$intpk_vpn_id;
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  
			    	 vpnId:$intpk_vpn_id,
			    	 mode:"getLogSelectedVpn"	
			    },
			
			});
			request.success(function (data) {
				$('#UserVpnHeader').attr('name',data[0]['intpk_vpn_id']);
				$scope.log_user_vpn=data[0]['intfk_user_id'];
				$scope.log_user_vpn_desc=data[0]['str_vpn_id'];
			
			});
	}

	$scope.logUserDelete=function($intpk_user_id){
		
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  
			    	 userId:$intpk_user_id,
			    	 mode:"deleteLogSelectedUser"	
			    },
			
			});
			request.success(function (data) {
				$scope.logUserDialogsearch();
			});
	}
	$scope.logUserMapDriveDelete=function($intpk_user_map_drive_id){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogUser.php",
		    data: {  
		    	 intpk_user_Mapped_drive_id:$intpk_user_map_drive_id,
		    	 mode:"deleteLogSelectedUserMappedDrive"	
		    },
		
		});
		request.success(function (data) {
			$scope.logMapdriveDialogsearch();
		});
	}
	$scope.logUserVpnDelete=function($intpk_vpn_id){
		console.log($intpk_vpn_id);
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogUser.php",
		    data: {  
		    	 vpn_id:$intpk_vpn_id,
		    	 mode:"deleteLogSelectedUserVpn"	
		    },
		
		});
		request.success(function (data) {
			$scope.logVpnDialogsearch();
		});
	}
	
	$scope.test=function(){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogUser.php",
		    data: {  
		    	
		    	 mode:"test"	
		    },
		
		});
		request.success(function (data) {
			
		});
	}
});



