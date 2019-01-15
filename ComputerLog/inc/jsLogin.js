
var app = angular.module('myApp', ['ui.bootstrap'], function () {
	
   // $interpolateProvider.startSymbol('%%');
   // $interpolateProvider.endSymbol('%%');
});

app.controller('LoginValidate', function($scope,$http,$rootScope) {

	
    $scope.validateLogin=function(){
    	console.log("Inside Login");
    		var request = $http({
    	    method: "post",
    	    url: "./inc/ajaxIncludes/ajxLoginValidate.php",
    	    data: {
    	    	 user_name:$scope.user_name,
    	    	 password:$scope.password,
    	    	 mode:"ValidateLogin"	
    	    },
    	   
    	});

    	request.success(function (data) {
    		
    		if(data=='True'){
    			
    			var request = $http({
    	    	    method: "post",
    	    	    url: "./inc/ajaxIncludes/ajxLoginValidate.php",
    	    	    data: {
    	    	    	 user_name:$scope.user_name, 	    	    	 
    	    	    	 mode:"UserData"	
    	    	    },  
    	    	})
    	    	
    	    	request.success(function (data) {
    	    		console.log("Its true");
    	    		window.location.href = 'main.php';
    	    		})
    	    	
    			
    		}else{
    			console.log("Its false");
    			//window.location.href = 'index.php';
    		}
    	//	alert('ggggg');
    		
    	})	
    }
});

/*app.run(function ($rootScope) {

	console.log("Running");
});*/
