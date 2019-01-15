

app.controller('LogSoftwareController', function($scope,$http,$rootScope,$compile) {
	
	var LogSoftwareArrayList=new Object ;
	var LogSoftwareMappingArrayList=new Object ;
	$scope.ShowHwSw=0;
	$scope.ShowSoftware=1;
	$scope.SoftwareSaveType=1;

	$scope.logHardwareTab=function($data){
		$scope.ShowSoftware=0;
		if($data=='software'){
			$scope.ShowSoftware=1;
			$scope.ShowHwSw=0;
			$scope.SoftwareSaveType=1;
		}else if($data=='MapHwSw'){
			$scope.ShowSoftware=0;
			$scope.ShowHwSw=1;
			$scope.SoftwareSaveType=2;
		}
	}
	
	$scope.saveLogSoftware=function(){
		if($scope.SoftwareSaveType==undefined || $scope.SoftwareSaveType==null || $scope.SoftwareSaveType=='')
			$scope.SoftwareSaveType=1;
		
		if($scope.SoftwareSaveType==1){
			var SoftwareTypeList={};
			$intpk_software_id=$('#log_software_id').attr('name');
			$intpk_software_record_id=$('#log_software_record_id').attr('name');
			SoftwareTypeList={'intpk_software_id':$intpk_software_id,'intpk_software_record_id':$intpk_software_record_id,'log_software_name':$scope.log_software_name,
					'log_software_desc':$scope.log_software_desc,'log_software_licence':$scope.log_software_licence};
			LogSoftwareArrayList['Software']=SoftwareTypeList;
			  var JsonSoftwareListArray=JSON.stringify(LogSoftwareArrayList);
			
			  var request = $http({
				    method: "post",
				    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
				    data: {  
				    	 logArrayList:JsonSoftwareListArray,
				    	 mode:"saveLogSoftware"	
				    },
				
				});
				request.success(function (data) {
					$('#log_software_id').attr('name','');
					$('#log_software_record_id').attr('name','');
					$("#log_save_software").notify("saved Sucessful","success");
					
					$scope.log_software_name='';
					$scope.log_software_desc='';
					$scope.log_software_licence='';
					
					
			});
		}else if($scope.SoftwareSaveType==2){
			if($scope.log_map_hw_sw_hw!=undefined){
			
				var SoftwareMappingList={};
				$intpk_hardware_software_id=$('#log_map_hw_sw_id').attr('name');
				$size=Object.keys($scope.log_map_hw_sw_software).length;
				for($cnt=0;$cnt<$size;$cnt++){
					if($scope['logMapHwSwAdd'+$scope.log_map_hw_sw_software[$cnt]]==undefined)
						var str_licence_no='null';
					else
						var str_licence_no=$scope['logMapHwSwAdd'+$scope.log_map_hw_sw_software[$cnt]];
	
					SoftwareMappingList={'intpk_hardware_software_id':$intpk_hardware_software_id,'intfk_hardware_id':$scope.log_map_hw_sw_hw,
							'intfk_software_record_id':$scope.log_map_hw_sw_software[$cnt],
							'str_licence_no':str_licence_no}
					LogSoftwareMappingArrayList[$cnt]=SoftwareMappingList;
				}
				LogSoftwareArrayList['SoftwareMapping']=LogSoftwareMappingArrayList;
				console.log(LogSoftwareArrayList);
				  var JsonSoftwareListArray=JSON.stringify(LogSoftwareArrayList);
					
				  var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
					    data: {  
					    	 logArrayList:JsonSoftwareListArray,
					    	 mode:"saveLogHarwareSoftwareMapping"	
					    },
					
					});
					request.success(function (data) {
						$('#log_map_hw_sw_id').attr('name','');
						$("#log_save_software_mapping").notify("saved Sucessful","success");
						$scope.log_map_hw_sw_hw='';
						$scope.log_map_hw_sw_software='';
						for($cnt=0;$cnt<$size;$cnt++){
							$scope['logMapHwSwAdd'+$scope.log_map_hw_sw_software[$cnt]]='';
						}
						
						
				});
		   }else{
			   $("#log_save_software_mapping").notify("Please choose Hardware","error");
		   }
		}
	}
	
	$scope.logSoftwareDialogsearch=function(){
		  var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
			    data: {  
			    	 log_software_name:$scope.log_software_search,
			    	 mode:"LogSoftwarefind"	
			    },
			
			});
			request.success(function (data) {
				$scope.logSoftwareDialogselectedItems=data;
				
				
		});
	}
	
	
	$scope.getLogDialogSelectedSoftware=function($intpk_software_id,$intpk_software_record_id,$str_software_name,$str_software_desc,$str_licence_no){
		$('#log_software_id').attr('name',$intpk_software_id);
		$('#log_software_record_id').attr('name',$intpk_software_record_id);
		$scope.log_software_name=$str_software_name;
		$scope.log_software_desc=$str_software_desc;
		$scope.log_software_licence=$str_licence_no;
		
	}
	
	$scope.logSoftwareRecordDelete=function($intpk_software_record_id){
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
			    data: {  
			    	intpk_software_record_id:$intpk_software_record_id,
			    	 mode:"LogSoftwareRecordDeleteItem"	
			    },
			
			});
			request.success(function (data) {
				$scope.logSoftwareDialogsearch();
		
		});
	}
	
	$scope.logfindSoftware=function(){
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
			    data: {  
			    	
			    	 mode:"LogSoftwareAll"	
			    },
			
			});
			request.success(function (data) {
				$scope.logAllSoftwares=data;
		});
	}
	
	$scope.logAllSoftwareSelect=function($intpk_software_id,$str_software_name){
		$('#log_software_id').attr('name',$intpk_software_id);
		$scope.log_software_name=$str_software_name;
	}
	
	
	//--------------------------------Map Hardware/Software---------------------------------
	
	$scope.logGetAllSoftwareRecord=function(){
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
			    data: {  
			    	
			    	 mode:"LogGetAllSoftwareRecord"	
			    },
			
			});
			request.success(function (data) {
				$scope.LogGetAllSoftwareRecords=data;
					
		});
	}
	
	$scope.getAllHardware=function(){
		
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
			    data: {  
			    	
			    	 mode:"LogGetAllHardware"	
			    },
			
			});
			request.success(function (data) {
				$scope.logAllHardwares=data;
		
		});
	}
	
	$scope.logMapHwSwSoftwareAdd=function(){
		var LogMapHwSwSoftwareCompArrayList=new Object ;
		$size1=($scope.LogGetAllSoftwareRecords).length;
		$size2=($scope.log_map_hw_sw_software).length;

		for($count1=0;$count1<$size2;$count1++){
			for($count2=0;$count2<$size1;$count2++){
				if($scope.LogGetAllSoftwareRecords[$count2]['intpk_software_record_id']==$scope.log_map_hw_sw_software[$count1])
					LogMapHwSwSoftwareCompArrayList[$count1]=$scope.LogGetAllSoftwareRecords[$count2];
			}
		}
		console.log(LogMapHwSwSoftwareCompArrayList);
		$scope.LogMapHwSwSoftwareCompArrayList=LogMapHwSwSoftwareCompArrayList;
		$append='';
		$('#AppendSwTableComponent').empty();
		$size=Object.keys($scope.LogMapHwSwSoftwareCompArrayList).length;
		for($cnt=0;$cnt<$size;$cnt++){
		$append+='<tr>'+
		            '<td id='+$scope.LogMapHwSwSoftwareCompArrayList[$cnt]['str_software_desc']+'>'+$scope.LogMapHwSwSoftwareCompArrayList[$cnt]['str_software_desc']+'</td>'+
					'<td><input style="width: 475px" class="form-control"  ng-model="logMapHwSwAdd'+$scope.LogMapHwSwSoftwareCompArrayList[$cnt]['intpk_software_record_id']+'" id="" type="text" aria-describedby="nameHelp" placeholder="Enter Licence No"></td>'+
				'</tr>';
		}		
		 var element=$compile($append)($scope);
			$("#AppendSwTableComponent").append(element);
	}
	
	$scope.logMapHwSwSoftwareSearch =function(){
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
			    data: {  
			    	 str_Hardware_system_id:$scope.log_hw_sw_software_search_dialogue,
			    	 mode:"logMapHwSwSoftwareSearch"	
			    },
			
			});
			request.success(function (data) {
				$scope.logHwSwSoftwareMappedOnes=data;
		
		});
		
	}
	
	$scope.logMapHwSwSoftwareSearchSelect=function($intfk_hardware_id,$intpk_hardware_software_id){
		$('#log_map_hw_sw_id').attr('name',$intpk_hardware_software_id);
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
			    data: {  
			    	 intfk_hardware_id:$intfk_hardware_id,
			    	 mode:"logMapHwSwSoftwareSelectedItem"	
			    },
			
			});
			request.success(function (data) {
				$scope.log_map_hw_sw_hw=$intfk_hardware_id;
				$size=Object.keys(data).length;
				console.log(data);
				$scope.log_map_hw_sw_software = [];
				for($cnt=0;$cnt<$size;$cnt++){
					$scope.log_map_hw_sw_software.push(data[$cnt]['intfk_software_record_id']);
					$scope['logMapHwSwAdd'+data[$cnt]['intfk_software_record_id']]=data[$cnt]['licence_no'];
				}
				
		
		});
	}
	
	$scope.logHwSwSoftwareRecordDelete=function($intpk_hardware_software_id){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
		    data: {  
		    	 intpk_hardware_software_id:$intpk_hardware_software_id,
		    	 mode:"logMapHwSwSoftwareRecordDelete"	
		    },
		
		});
		request.success(function (data) {
			$scope.logHwSwSoftwareMappedOnes=data;
			$scope.logMapHwSwSoftwareSearch();
		});
	}

 
});

/*app.run(function ($rootScope) {

	console.log("Running");
});*/
