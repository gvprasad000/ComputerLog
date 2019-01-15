var app = angular.module('myHeader', ['ui.bootstrap'], function () {
	
   // $interpolateProvider.startSymbol('%%');
   // $interpolateProvider.endSymbol('%%');
});

app.controller('HeaderController', function($scope,$http,$rootScope) {
	/*$plant_id=$('#company_id').val();
	$first_name=$('#first_name').val();
	$last_name=$('#last_name').val();
	$user_email=$('#user_email').val();
	$rootScope.firstname=$first_name;
	$rootScope.lastname=$last_name;
	$rootScope.email=$user_email;
	$scope.quote_fob=$('#company_id').val();*/
	setInterval(function(){
		 $scope.logDashBoardAlerts();
		 $rootScope.$broadcast('logDashBoardRefresh', { message: 'Refresh' });
	}, 6000);
	
	
	
	var request = $http({
	    method: "post",
	    url: "./inc/ajaxIncludes/ajxLoginValidate.php",
	    data: {
	    	 email:$rootScope.email,
	    	 mode:"UserDataByEmail"	
	    },
	   
	});

 	request.success(function (data) {
 		 $scope.logDashBoardAlerts();
	})
	
	var request = $http({
	    method: "post",
	    url: "./inc/ajaxIncludes/ajxLoginValidate.php",
	    data: {
	    	 mode:"getDatabase"	
	    },
	   
	});

 	request.success(function (data) {
    	if(JSON.parse(data)=="[ComputerLog].[dbo]")
    		$scope.dbName="test";
    	else if(JSON.parse(data)=="[ComputerLog].[dbo]")	
    		$scope.dbName="Live";
	})
	
	/*if($plant_id==2 || $plant_id==3 || $plant_id==4){

		$comp_id=2;
		$scope.compName="Curtis Metal Finishing";
		$rootScope.compId=$comp_id;
	
		$scope.comp_address="6645 Sims Dr, Sterling Heights, MI 48313";
		 $("#comp_logo").attr('src', '/Quote_System/images/curtis_logo.png');
	}else if($plant_id==1){

		$comp_id=1;
		$rootScope.compId=$comp_id;
		$scope.compName="Commercial Steel Treating";
		$scope.comp_address="31440 Stephenson Hwy, Madison Heights, MI 48071";
		 $("#comp_logo").attr('src', '/Quote_System/images/company_logo.png');
	}else if($plant_id==6){
		$comp_id=4;
		$scope.compName="Curtis Thermal Processing";
		$rootScope.compId=$comp_id;
	
		$scope.comp_address="10911 N 2nd St, Machesney Park, IL 61115";
		 $("#comp_logo").attr('src', '/Quote_System/images/curtis_thermal_logo.png');
	}*/
/*
	 $scope.viewCustomer=function(){
		 window.location.href = 'user.php'+ '?button=1';
	}
	 $scope.user=function(){
		 console.log("In User");
		 window.location.href = 'user.php';
	}
	 
	$scope.viewFixtures=function(){
		 window.location.href = 'fixture.php';
	}
		
   $scope.main=function(){
    	window.location.href = 'main.php';
    	
    }
   $scope.quote=function(){
   	window.location.href = 'quote.php';
   	
   }
   $scope.filter=function(){
	
	   	window.location.href = 'filter.php';
	   	
	   }*/
   $scope.main=function(){
 		window.location.href = 'main.php';
 	}
   $scope.user=function(){
	   	window.location.href = 'user.php';	   	
   }
 	
  $scope.hardware=function(){
		window.location.href = 'hardware.php';	  
  }	
 	
   $scope.userMapDrive=function(){
 	   	window.location.href = 'usermapdrive.php';
 	   	
    }
   $scope.software=function(){
	   window.location.href = 'software.php';
   }
   
   $scope.problemHistory=function(){
	   window.location.href = 'problemHistory.php';
   }
   $scope.schedule=function(){
	   window.location.href = 'schedule.php';
   }
   $scope.report=function(){
	   window.location.href = 'report.php';
   }
   $scope.logOut=function(){
	   window.location.href = 'index.php';
	   var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLoginValidate.php",
		    data: {
		    	 mode:"LogOut"	
		    },
		   
		});
	   
   }
   $scope.logDashBoardAlerts=function(){
	   var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLoginValidate.php",
		    data: {
		    	
		    	 mode:"logDashBoardAlertsService"	
		    },
	    	   
	    	});

	    	request.success(function (data) {
	    		 $scope.TotalAlerts=data;
	    		 console.log($scope.TotalAlerts);
	    		 $scope.TotalAlertCount=data.length;
	    	});
   }
 /*  $scope.$on('logDashBoardAlertsService', function (event, args) {
	   $scope.logDashBoardAlerts();
   });*/

 /*  $scope.changePlant=function($plant_id){
		if($plant_id==2 || $plant_id==3 || $plant_id==4){

			$comp_id=2;
			$('#company_id').val(2);
			$scope.compName="Curtis Metal Finishing";
			$rootScope.compId=$comp_id;
		
			$scope.comp_address="6645 Sims Dr, Sterling Heights, MI 48313";
			 $("#comp_logo").attr('src', '/Quote_System/images/curtis_logo.png');
		}else if($plant_id==1){
			$('#company_id').val(1);
			$comp_id=1;
			$rootScope.compId=$comp_id;
			$scope.compName="Commercial Steel Treating";
			$scope.comp_address="31440 Stephenson Hwy, Madison Heights, MI 48071";
			 $("#comp_logo").attr('src', '/Quote_System/images/company_logo.png');
		}else if($plant_id==6){
			$('#company_id').val(4);
			$comp_id=4;
			$scope.compName="Curtis Thermal Processing";
			$rootScope.compId=$comp_id;
		
			$scope.comp_address="10911 N 2nd St, Machesney Park, IL 61115";
			 $("#comp_logo").attr('src', '/Quote_System/images/curtis_thermal_logo.png');
		}
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLoginValidate.php",
		    data: {
		    	plant_id:$plant_id,
		    	user_id:$scope.User[0]['user_id'],
		    	mode:"UpdateUserPlant"	
		    },
		   
		});

	 	request.success(function (data) {
		})
		
   }
   /* $scope.viewCommercial=function($ComName){ 
    	$scope.compName=$ComName;
    	$rootScope.compName=1;  
    	 $("#comp_logo").attr('src', '/Quote_System/images/company_logo.png');
    }
 
    $scope.viewCurtis=function($ComName){
    	$scope.compName=$ComName;
    	$rootScope.compName=2;   
    	  $("#comp_logo").attr('src', '/Quote_System/images/curtis_logo.png');
    }
    $scope.viewParts=function(){
    	window.location.href = 'part.php';
    }
    $scope.viewDimension=function(){
    	window.location.href = 'dimension.php'
    }
    $scope.viewDisclamier=function(){
    	window.location.href = 'disclamier.php'
    }*/
});

app.run(function ($rootScope) {


	console.log("Running");
});