
app.controller('HardwareController', function($scope,$http,$compile,$uibModal,$rootScope) {
	
	var LogHardwareArrayList=new Object ;
	var LogSoftwareArrayList=new Object ;
	var LogSoftwareMappingArrayList=new Object ;
	var LogSoftwareArrayList=new Object;
	$scope.type=0;
	$scope.one=0;
	$scope.component=0;
	$scope.hardware=1;
	$scope.peripheral=0;
	$scope.saveType=3;
	$scope.HardwareUser=0;
	$scope.showSearch=1;
	
	
	//-------------Multi select Box select without hitting control------------------------
	
	/*$("#log_hardware_component_copy").mousedown(function(e){
	    e.preventDefault();
	    
			var select = this;
	    var scroll = select.scrollTop;
	    
	    e.target.selected = !e.target.selected;
	    
	    setTimeout(function(){select.scrollTop = scroll;}, 0);
	    
	    $(select).focus();
	}).mousemove(function(e){e.preventDefault()});
	
			//-----------------XXXXXXXX-------------------------
	
	$("#log_map_hw_sw_software_multiselect").mousedown(function(e){
	    e.preventDefault();
	    
			var select = this;
	    var scroll = select.scrollTop;
	    
	    e.target.selected = !e.target.selected;
	    
	    setTimeout(function(){select.scrollTop = scroll;}, 0);
	    
	    $(select).focus();
	}).mousemove(function(e){e.preventDefault()});
	
			//-----------------XXXXXXXX-------------------------
	
	$("#log_select_software_copy_multiselect").mousedown(function(e){
	    e.preventDefault();
	    
			var select = this;
	    var scroll = select.scrollTop;
	    
	    e.target.selected = !e.target.selected;
	    
	    setTimeout(function(){select.scrollTop = scroll;}, 0);
	    
	    $(select).focus();
	}).mousemove(function(e){e.preventDefault()});

	//-----------------XXXXXXXX-------------------------
	
	$("#log_hardware_select_component_copy_multiselect").mousedown(function(e){
	    e.preventDefault();
	    
		var select = this;
	    var scroll = select.scrollTop;
	    
	    e.target.selected = !e.target.selected;
	    
	    setTimeout(function(){select.scrollTop = scroll;}, 0);
	    
	    $(select).focus();
	}).mousemove(function(e){e.preventDefault()});

	//-----------------XXXXXXXX-------------------------
	
	$("#log_all_user_multiselect").mousedown(function(e){
	    e.preventDefault();
	    
			var select = this;
	    var scroll = select.scrollTop;
	    
	    e.target.selected = !e.target.selected;
	    
	    setTimeout(function(){select.scrollTop = scroll;}, 0);
	    
	    $(select).focus();
	}).mousemove(function(e){e.preventDefault()});

	//-----------------XXXXXXXX-------------------------
	
	*/

	
	setTimeout(function(){
		$scope.logHardwareTab('hardware');
		$scope.getHardwareType();
		$scope.getAllHardwareComponents();
		$scope.logGetAllSoftwareRecord();
	}, 1000);

	  var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 mode:"getAllPlants"	
		    },
		
		});
		request.success(function (data) {
			$scope.plants=data;
		});

	$scope.closeModel=function(){
	
		 $('#LogHardwareSearch').dialog('close');
		 $('#LogHardwareSearch2').modal('hide')
		$scope.one=0;
		
		
	}
	$scope.modelShow=function(){
		$scope.one=1;
	}
	$scope.logHardwareTab=function($data){
		$scope.type=3;
		if($data=="component"){
			$scope.showSearch=0;
			$scope.component=1;
			$scope.type=0;
			$scope.hardware=0;
			$scope.saveType=2;
			$scope.peripheral=0;
			$scope.HardwareUser=0;
		}
		else if($data=="hardware"){
			$scope.showSearch=1;
			$scope.hardware=1;
			$scope.type=0;
			$scope.component=0;
			$scope.saveType=3;
			$scope.peripheral=0;
			$scope.HardwareUser=0;
		}
		else if($data=="type"){
			$scope.showSearch=0;
			$scope.type=1;
			$scope.component=0;
			$scope.hardware=0;
			$scope.saveType=1;
			$scope.peripheral=0;
			$scope.HardwareUser=0;
		}
		else if($data=="peripheral"){
			$scope.showSearch=0;
			$scope.peripheral=1;
			$scope.type=0;
			$scope.component=0;
			$scope.hardware=0;
			$scope.saveType=4;
			$scope.HardwareUser=0;
		}
		else if($data=="user_hardware"){
			$scope.showSearch=0;
			$scope.peripheral=0;
			$scope.type=0;
			$scope.component=0;
			$scope.hardware=0;
			$scope.saveType=5;
			$scope.HardwareUser=1;
		}
	}
	
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
	
	$scope.selectAllListedSoftwaresInpopUp=function(){
		if($scope.log_map_hw_sw_software!=undefined){
			$size1=$scope.log_map_hw_sw_software.length;
			$size2=$scope.LogGetAllSoftwareRecords.length;
			$scope.log_select_software_copy=[];
			for($count1=0;$count1<$size1;$count1++){
				for($count2=0;$count2<$size2;$count2++){
					if(parseInt($scope.LogGetAllSoftwareRecords[$count2]['intpk_software_record_id'])==parseInt($scope.log_map_hw_sw_software[$count1]))
						$scope.log_select_software_copy.push($scope.log_map_hw_sw_software[$count1]);
				}
			}
		
		}
		
	}
	
	$scope.allSoftwareSelectItem=function(){
		var ArrayListObject2=new Object ;
		var elementCount=0;
		var ary = [];
		var arraylist={};
		$scope.log_map_hw_sw_software = [];
		$('#log_hardware_component_copy').children().each(function () {    
		    ary.push($(this).val()); //put them in array
		});
		
		
			$size1=$scope.log_select_software_copy.length;
			$size2=$scope.LogGetAllSoftwareRecords.length;
			
		
			for($count=0;$count<$size1;$count++){
				for($count2=0;$count2<$size2;$count2++){
					if(parseInt($scope.LogGetAllSoftwareRecords[$count2]['intpk_software_record_id'])==parseInt($scope.log_select_software_copy[$count])){
						ArrayListObject2[elementCount]=$scope.LogGetAllSoftwareRecords[$count2];
						elementCount++;
					}
				}
			}
			
			$scope.LogGetSelectedSoftwareRecords=ArrayListObject2;
			
			$size=Object.keys($scope.LogGetSelectedSoftwareRecords).length;
				for($cnt=0;$cnt<$size;$cnt++){
					$scope.log_map_hw_sw_software.push($scope.LogGetSelectedSoftwareRecords[$cnt]['intpk_software_record_id']);
				}	
	}
	
	$scope.deleteSoftwareRecordItems=function(){
		if($scope.log_map_hw_sw_software!=undefined){
			$size=$scope.log_map_hw_sw_software.length;
			if($size!=1)
				$("#log_delete_map_hw_sw_software").notify("Please choose one at a time","error");
			else{
				if($scope.SelectedHardwareId!=undefined){
					var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogHardware.php",
					    data: {  
					    	 intfk_hardware_id:$scope.SelectedHardwareId,
					    	 intfk_software_record_id:$scope.log_map_hw_sw_software[0],
					    	 mode:"deleteHardwareSoftwareItem"	
					    },
					
					});
					request.success(function (data) {
						$scope.getLogDialogSelectedHardware($scope.SelectedHardwareSyatemId);
					});
				}
				else{
					$("#log_delete_map_hw_sw_software").notify("Item not saved cannot be deleted","error");
				}
			}
		}else{
			$("#log_delete_map_hw_sw_software").notify("Item not found","error");
		}
	}
	
	$scope.logMapHwSwSoftwareAdd=function(){
		var LogMapHwSwSoftwareCompArrayList=new Object ;
		$size1=($scope.LogGetSelectedSoftwareRecords).length;
		$size2=($scope.log_map_hw_sw_software).length;
		if($size1==undefined)
			$size1=Object.keys($scope.LogGetSelectedSoftwareRecords).length;

		for($count1=0;$count1<$size2;$count1++){
			for($count2=0;$count2<$size1;$count2++){
				if(parseInt($scope.LogGetSelectedSoftwareRecords[$count2]['intpk_software_record_id'])==parseInt($scope.log_map_hw_sw_software[$count1]))
					LogMapHwSwSoftwareCompArrayList[$count1]=$scope.LogGetSelectedSoftwareRecords[$count2];
			}
		}
		
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
	
	$scope.saveComponent=function(){
		$scope.saveType=2;
		$scope.saveLogHardware();
		$scope.getHardwareComponents();
	}
	
	$scope.saveSoftware=function(){
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
				
				$scope.logGetAllSoftwareRecord();
		});
	}
	
	$scope.saveLogHardware=function($data){
		if($scope.saveType==undefined || $scope.saveType==null || $scope.saveType=='')
			$scope.saveType=1;
		
		if($scope.saveType==1){
			if($scope.log_hardware_type_name!='' && $scope.log_hardware_type_name!=undefined){
				var HardwareTypeList={};
				$intpk_hardware_type_id=$('#log_Hardware_type_id').attr('name');
				if($intpk_hardware_type_id=='' || $intpk_hardware_type_id==undefined || $intpk_hardware_type_id==0)
					$scope.intpk_hardware_type_id=0;
				else
					$scope.intpk_hardware_type_id=$intpk_hardware_type_id; 
				HardwareTypeList={'intpk_hardware_type_id':$scope.intpk_hardware_type_id,'log_hardware_type_name':$scope.log_hardware_type_name};
				LogHardwareArrayList['HardwareType']=HardwareTypeList;
				  var JsonHardwareListArray=JSON.stringify(LogHardwareArrayList);
				  var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogHardware.php",
					    data: {  
					    	 logArrayList:JsonHardwareListArray,
					    	 mode:"saveLogHardwareType"	
					    },
					
					});
					request.success(function (data) {
						$('#log_Hardware_type_name').attr('name','');
						$("#log_save_hardware").notify("saved Sucessful","success");
						$('#log_Hardware_type_id').attr('name',0);
						$scope.log_hardware_type_name='';
						
						
					});
			}else{
				$("#log_save_hardware").notify("Please enter hardware type","error");
			}
		}else if($scope.saveType==2){
			if($scope.log_hardware_component_name!='' && $scope.log_hardware_component_name!=undefined){
				var HardwareComponentList={};
				$intpk_hardware_component_id=$('#log_Hardware_component_id').attr('name');
				if($intpk_hardware_component_id=='' || $intpk_hardware_component_id==undefined || $intpk_hardware_component_id==0)
					$scope.intpk_hardware_component_id=0;
				else
					$scope.intpk_hardware_component_id=$intpk_hardware_component_id; 
				
				HardwareComponentList={'intpk_component_id':$scope.intpk_hardware_component_id,'log_hardware_component_name':$scope.log_hardware_component_name};
				LogHardwareArrayList['HardwareComponentList']=HardwareComponentList;
				
				 var JsonHardwareListArray=JSON.stringify(LogHardwareArrayList);
				  var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogHardware.php",
					    data: {  
					    	 logArrayList:JsonHardwareListArray,
					    	 mode:"saveLogHardwareComponent"	
					    },
					
					});
					request.success(function (data) {
						$('#log_Hardware_component_id').attr('name',0);
						$("#log_save_hardware").notify("saved Sucessful","success");
						$scope.log_hardware_component_name='';
						
						
					});
				
				
			}else{
				$("#log_save_hardware_component").notify("Please enter hardware Component","error");
			}
		}else if($scope.saveType==3){
			
		
			if($scope.log_hardware_type_copy!='' && $scope.log_hardware_type_copy!=undefined &&
			   $scope.log_hardware_plant!='' && $scope.log_hardware_plant!=undefined){
				
	//----------------------Hardware-Software ----------------------------------------

				var SoftwareMappingList={};
				$intpk_hardware_software_id=$('#log_map_hw_sw_id').attr('name');
				
				if($scope.log_map_hw_sw_software!=undefined){
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
				}
				LogHardwareArrayList['SoftwareMapping']=LogSoftwareMappingArrayList;
				
	//----------------------Hardware  adding to array list----------------------------- 
				
				var HardwareComponent={};
				$intpk_hardware_id=$('#log_Hardware').attr('name');
				if($intpk_hardware_id=='' || $intpk_hardware_id==undefined || $intpk_hardware_id==0)
					$scope.intpk_hardware_id=0;
				else
					$scope.intpk_hardware_id=$intpk_hardware_id; 
				var HardwareList={};
				HardwareList={'intpk_hardware_id':$scope.intpk_hardware_id,'log_hardware_type':$scope.log_hardware_type_copy,
						'log_hardware_plant_id':$scope.log_hardware_plant,'log_hardware_service_tag':$scope.log_hardware_service_tag,
						'log_hardware_system_id':$scope.log_hardware_system_id,'log_hardware_active':$scope.log_hardware_active,
						'log_hardware_serial_no':$scope.log_hardware_serial_no,'log_hardware_rdp':$scope.log_hardware_rdp,
						'log_hardware_tcmp':$scope.log_hardware_tcmp,'log_system_name':$scope.log_hardware_system_name,
						'log_admin_pswd':$scope.log_hardware_admin_pswd};
				
				LogHardwareArrayList['HardwareList']=HardwareList;
				
	//----------------------Hardware Components adding to array list-----------------------------
				
				var LogHardwareArrayList2=new Object ;
				$size1=$scope.log_hardware_component_copy.length;
				$size2=$scope.HardwareComponents.length;
				$scope.componentArray=[];
				for($count=0;$count<$size1;$count++){
					for($i=0;$i<$size2;$i++){
						var addcomplist={};
						if( (parseInt($scope.HardwareComponents[$i]['intpk_component_id']))== (parseInt($scope.log_hardware_component_copy[$count]))){
							LogHardwareArrayList2[$count]=$scope.HardwareComponents[$i];
						}
					}
				}
				LogHardwareArrayList['HardwareComp']=LogHardwareArrayList2;
				
	//----------------------Hardware Add component adding to array list----------------------------- 
	
				$size=Object.keys(LogHardwareArrayList2).length;
				var LogHardwareCompAddArrayList=new Object ;
				
				var HardwareCompAdd={};
				for($cnt=0;$cnt<$size1;$cnt++){
					$scopvalue='HardwareAddComponent'+$scope.log_hardware_component_copy[$cnt];
					HardwareCompAdd={'intfk_comp_id':$scope.log_hardware_component_copy[$cnt],
							'str_comp_desc':$scope[$scopvalue]};
					LogHardwareCompAddArrayList[$cnt]=HardwareCompAdd
				}
				
				LogHardwareArrayList['HardwareCompAdd']=LogHardwareCompAddArrayList;
				
	//----------------------Hardware Ip Address adding to array list----------------------------- 		
				
				$size=parseInt($("#HardwareIpTable").attr('name'));
				var LogHardwareIpAddressArrayList=new Object ;
				var HardwareIpAddress={};
				for($cnt=1;$cnt<=$size;$cnt++){
					$Ip_desc=$scope["hardware_ip_desc_"+$cnt];
					$Ip_address=$scope["hardware_ip_address_"+$cnt];
					$intpk_ipaddress=$('#hardware_ip_desc_'+$cnt).attr('name');
					if($intpk_ipaddress=='' || $intpk_ipaddress==null || $intpk_ipaddress==undefined || $intpk_ipaddress=='null')
						$intpk_ipaddress=0;
					HardwareIpAddress={'intpk_ip_address':$intpk_ipaddress,'log_HW_Ip_desc':$Ip_desc,'log_HW_Ip_address':$Ip_address};
					LogHardwareIpAddressArrayList[$cnt]=HardwareIpAddress;
				
				}
				LogHardwareArrayList['HardwareIpAddress']=LogHardwareIpAddressArrayList;
			
				 var JsonHardwareListArray=JSON.stringify(LogHardwareArrayList);
				
				 var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogHardware.php",
					    data: {  
					    	 logArrayList:JsonHardwareListArray,
					    	 mode:"saveLogHardware"	
					    },
					
					});
					request.success(function (data) {
						$('#log_Hardware').attr('name',0);
						$("#log_save_hardware").notify("saved Sucessful","success");
						$scope.LogGetSelectedSoftwareRecords='';
						$scope.HardwareComponents='';
						$scope.log_hardware_type_copy='';
						$scope.log_hardware_plant='';
						$scope.log_hardware_service_tag='';
						$scope.log_hardware_system_id='';
						$scope.log_hardware_active='';
						$scope.log_hardware_serial_no='';
						$scope.log_hardware_rdp='';
						$scope.log_hardware_tcmp='';
						$scope.log_hardware_component_copy=[];
						$scope.log_map_hw_sw_software=[];
						$scope.log_hardware_system_name='';
						$scope.log_hardware_admin_pswd='';
						$scope.SelectedHardwareId='';
						$scope.SelectedHardwareSyatemId='';
						
					});
				
				
			
			//$scope.log_hardware_component_copy = [];
			
		}else{
			
			if($scope.log_hardware_type_copy=='' || $scope.log_hardware_type_copy==undefined ){
				$("#log_save_hardware_copy").notify("Please choose Type","error");
			
			}
			else if($scope.log_hardware_service_tag=='' || $scope.log_hardware_service_tag==undefined)	
				$("#log_save_hardware_copy").notify("Please enter service tag","error");
			else if($scope.log_hardware_plant=='' || $scope.log_hardware_plant==undefined)	
				$("#log_save_hardware_copy").notify("Please choose plant","error");
			}
		}else if($scope.saveType==4){

			if(($scope.log_peripheral_main_hw!='' && $scope.log_peripheral_main_hw!=undefined)&& 
					$scope.log_peripheral_connect_hw!='' && $scope.log_peripheral_connect_hw!=undefined){
				var LogHardwarePeripheral={};
				var LogHardwarePeripheralArrayList=new Object ;
				$size1=$scope.log_peripheral_connect_hw.length;
				$size2=$scope.AllHardwares.length;
				$scope.HardwarePeripheralConnectArray=[];
				for($count=0;$count<$size1;$count++){
					for($i=0;$i<$size2;$i++){
						var addcomplist={};
						if( (parseInt($scope.AllHardwares[$i]['intpk_hardware_id']))== (parseInt($scope.log_peripheral_connect_hw[$count]))){
							LogHardwarePeripheralArrayList[$count]=$scope.AllHardwares[$i];
						}
					}
				}
				LogHardwareArrayList['HardwarePeripheralConnectHW']=LogHardwarePeripheralArrayList;
				$intpk_peripheral_id=$('#log_Hardware_peripheral_id').attr('name');
				if($intpk_peripheral_id=='' || $intpk_peripheral_id==0 || $intpk_peripheral_id=='0' || $intpk_peripheral_id==undefined)
					$intpk_peripheral_id=0;
				LogHardwarePeripheral={'intfk_hardware_main_id':$scope.log_peripheral_main_hw};
				LogHardwareArrayList['HardwarePeripheral']=LogHardwarePeripheral;
				
				 var JsonHardwareListArray=JSON.stringify(LogHardwareArrayList);
				 console.log(LogHardwareArrayList);
				 var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogHardware.php",
					    data: {  
					    	 logArrayList:JsonHardwareListArray,
					    	 mode:"saveLogHardwarePeripheral"	
					    },
					
					});
					request.success(function (data) {
						
						$("#log_save_hardware_peripheral").notify("saved Sucessful","success");
						
					});
				
				
			}else{
				if($scope.log_peripheral_main_hw=='' || $scope.log_peripheral_main_hw==undefined)
					$("#log_save_hardware_peripheral").notify("Please choose Hardware Main","error");
				else if($scope.log_peripheral_connect_hw=='' || $scope.log_peripheral_connect_hw==undefined)
					$("#log_save_hardware_peripheral").notify("Please choose Hardware Connect","error");
					
			} 
		}else if($scope.saveType==5){
			if($scope.log_hardware_user_user!='' && $scope.log_hardware_user_user!=undefined &&
					$scope.log_hardware_user_hardware!='' && $scope.log_hardware_user_hardware!=undefined	){
				
				$intpk_hardware_user=$("#log_hardware_user").attr('name');
				var LogHardwareUser={};
				if($intpk_hardware_user=='' || $intpk_hardware_user==undefined || $intpk_hardware_user==0)
					$scope.intpk_hardware_user=0;
				else
					$scope.intpk_hardware_user=$intpk_hardware_user;
				LogHardwareUser={'intpk_hardware_user':$scope.intpk_hardware_user,
						'log_hardware_user_hardware':$scope.log_hardware_user_hardware,
						'log_hardware_user_user':$scope.log_hardware_user_user[0],
						'log_hardware_user_password':$scope.log_hardware_user_password,
						'log_user_hardware_printer':$scope.log_hardware_user_printer};
				LogHardwareArrayList['HardwareUser']=LogHardwareUser;	
				if($scope.HardwareSelectedUsers!=undefined)
					LogHardwareArrayList['HardwareUserAll']=$scope.HardwareSelectedUsers;
				var JsonHardwareListArray=JSON.stringify(LogHardwareArrayList);
				
				var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogHardware.php",
					    data: {  
					    	 logArrayList:JsonHardwareListArray,
					    	 mode:"saveLogHardwareUser"	
					    },
					
					});
					request.success(function (data) {						
						$("#log_save_hardware_user").notify("saved Sucessful","success");
					});
				
			}else{
				if($scope.log_hardware_user_hardware=='' || $scope.log_hardware_user_hardware==undefined )	
					$("#log_save_hardware_user").notify("Please choose Hardware","error");
				else if($scope.log_hardware_user_user=='' || $scope.log_hardware_user_user==undefined )
					$("#log_save_hardware_user").notify("Please choose User","error");
				
			}
		}
		
	}
//----------------------------------------Hardware Type-----------------------------------------------------
	
	$scope.logHardwareTypeDialogsearch=function(){
		
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 HardwareTypeDesc:$scope.log_hardware_type_search,
		    	 mode:"getHardwareTypes"	
		    },
		
		});
		request.success(function (data) {
			$scope.HardwareTypes=data;
		});
	}
	$scope.getLogDialogSelectedHardwareType=function($HardwareTypeId){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 HardwareTypeId:$HardwareTypeId,
		    	 mode:"getSelectedHardwareTypes"	
		    },
		
		});
		request.success(function (data) {
			$('#log_Hardware_type_id').attr('name',$HardwareTypeId);
			$scope.log_hardware_type_name=data[0]['str_hardware_desc'];
		});
		
		
	}
	$scope.logHardwareTypeDelete=function($HardwareTypeId){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 HardwareTypeId:$HardwareTypeId,
		    	 mode:"deleteSelectedHardwareType"	
		    },
		
		});
		request.success(function (data) {
			$scope.logHardwareTypeDialogsearch();
		});
	}
	
//-------------------------------------------Hardware Components-----------------------------------------------------------
	
	$scope.logHardwareComponentDialogsearch=function($HardwareTypeId){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 HardwareComponentDesc:$scope.log_hardware_component_search,
		    	 mode:"getHardwareComponents"	
		    },
		
		});
		request.success(function (data) {
			$scope.HardwareComponents=data;
		});
	}
	
	$scope.getLogDialogSelectedHardwareComponent=function($HardwareComponentId){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 HardwareComponentId:$HardwareComponentId,
		    	 mode:"getSelectedHardwareComponent"	
		    },
		
		});
		request.success(function (data) {
			$('#log_Hardware_component_id').attr('name',$HardwareComponentId);
			$scope.log_hardware_component_name=data[0]['str_component_name'];
		});
	}
	
	$scope.logHardwareComponentDelete=function($HardwareComponentId){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 HardwareComponentId:$HardwareComponentId,
		    	 mode:"deleteSelectedHardwareComponent"	
		    },
		
		});
		request.success(function (data) {
			$scope.logHardwareComponentDialogsearch();
		});
	}
	
//-------------------------------------------------Hardware--------------------------------------------------------
	
	
	
	$scope.getAllHardwareComponents=function(){
		$value='';
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 mode:"getAllHardwareComponents"	
		    },
		
		});
		request.success(function (data) {
			$scope.SelectAllHardwareComponents=data;
		});
	}
	
	$scope.selectAllListedComponentInpopUp=function(){
		if($scope.log_hardware_component_copy!=undefined){
			$size1=$scope.log_hardware_component_copy.length;
			$size2=$scope.SelectAllHardwareComponents.length;
			$scope.log_hardware_select_component_copy=[];
			for($count1=0;$count1<$size1;$count1++){
				for($count2=0;$count2<$size2;$count2++){
					if(parseInt($scope.SelectAllHardwareComponents[$count2]['intpk_component_id'])==parseInt($scope.log_hardware_component_copy[$count1]))
						$scope.log_hardware_select_component_copy.push($scope.log_hardware_component_copy[$count1]);
				}
			}
		}
	}
	
	
	$scope.allComponentSelectItem=function(){
		var ArrayListObject=new Object ;
		var elementCount=0;
		var ary = [];
		var set_flag=0;
		var arraylist={};
		$scope.log_hardware_component_copy = [];
		$('#log_hardware_component_copy').children().each(function () {    
		    ary.push($(this).val()); //put them in array
		});
		
		/*for($count=0;$count<ary.length;$count++){
			if($scope.log_hardware_select_component_copy[0]==ary[$count])
				set_flag=1;
		}*/
		//if(set_flag==0){
		
			$size1=$scope.log_hardware_select_component_copy.length;
			$size2=$scope.SelectAllHardwareComponents.length;
			for($count=0;$count<$size1;$count++){
				for($count2=0;$count2<$size2;$count2++){
					if(parseInt($scope.SelectAllHardwareComponents[$count2]['intpk_component_id'])==parseInt($scope.log_hardware_select_component_copy[$count])){
						ArrayListObject[elementCount]=$scope.SelectAllHardwareComponents[$count2];
						elementCount++;
					}
				}
			}
			
			$scope.HardwareComponents=ArrayListObject;
			
			$size=Object.keys($scope.HardwareComponents).length;
				for($cnt=0;$cnt<$size;$cnt++){
					
					$scope.log_hardware_component_copy.push($scope.HardwareComponents[$cnt]['intpk_component_id']);
					
				}
			
			//$('#log_hardware_component_copy').append('<option value='+$scope.log_hardware_select_component_copy[0]+' selected="selected">Foo</option>');
		//}
			
	}
	
	$scope.getHardwareType=function(){
		$value='';
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 HardwareTypeDesc:$value,
		    	 mode:"getHardwareTypes"	
		    },
		
		});
		request.success(function (data) {
			$scope.HardwareTypes=data;
		});
	}
	
	$scope.deleteHardwareComponent=function(){
		if($scope.log_hardware_component_copy!=undefined){
			$size=$scope.log_hardware_component_copy.length;
			if($size!=1)
				$("#log_delete_hardware_component").notify("Please choose one at a time","error");
			else{
				if($scope.SelectedHardwareId!=undefined){
					var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogHardware.php",
					    data: {  
					    	 intfk_hardware_id:$scope.SelectedHardwareId,
					    	 intfk_component_id:$scope.log_hardware_component_copy[0],
					    	 mode:"deleteHardwareComponent"	
					    },
					
					});
					request.success(function (data) {
						$scope.getLogDialogSelectedHardware($scope.SelectedHardwareSyatemId);
					});
				}
				else{
					$("#log_delete_hardware_component").notify("Item not saved cannot be deleted","error");
				}
			}
		}else{
			$("#log_delete_hardware_component").notify("Item not found","error");
		}
	}
	
	$scope.getHardwareComponents=function($HardwareTypeId){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 HardwareComponentDesc:$scope.log_hardware_component_search,
		    	 mode:"getHardwareComponents"	
		    },
		
		});
		request.success(function (data) {
			$scope.HardwareComponents=data;
		});
	}
	
	$scope.logHardwareComponentAdd=function(){
		var LogHardwareCompArrayList=new Object ;
		$size1=$scope.log_hardware_component_copy.length;
		$size2=$scope.HardwareComponents.length;
		if($size2==undefined)
			$size2=Object.keys($scope.HardwareComponents).length;
		$scope.componentArray=[];

	
		for($count=0;$count<$size1;$count++){
			for($i=0;$i<$size2;$i++){
				var addcomplist={};
				//console.log($scope.HardwareComponents[$i]['intpk_component_id']+"="+$scope.log_hardware_component_copy[$count]);
				if( (parseInt($scope.HardwareComponents[$i]['intpk_component_id']))== (parseInt($scope.log_hardware_component_copy[$count]))){
					LogHardwareCompArrayList[$count]=$scope.HardwareComponents[$i];
				}
			}
		}
	
		$scope.HardwareAddComponents=LogHardwareCompArrayList;
		$append='';
		$('#AppendTableComponent').empty();
		$size=Object.keys($scope.HardwareAddComponents).length;
		for($cnt=0;$cnt<$size;$cnt++){
		$append+='<tr>'+
		            '<td id='+LogHardwareCompArrayList[$cnt]['str_component_name']+'>'+LogHardwareCompArrayList[$cnt]['str_component_name']+'</td>'+
					'<td><input style="width: 475px" class="form-control"  ng-model="HardwareAddComponent'+LogHardwareCompArrayList[$cnt]['intpk_component_id']+'" id="" type="text" aria-describedby="nameHelp" placeholder="Enter Description"></td>'+
			   	 '</tr>';
		}		
		 var element=$compile($append)($scope);
			$("#AppendTableComponent").append(element);
		
	}
	
	$scope.logHardwareDialogsearch=function(){
		
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 str_system_id:$scope.log_hardware_search_dialogue,
		    	 intfk_hardware_type_id:$scope.log_hardware_type_search,
		    	 intfk_hardware_comp_id:$scope.log_hardware_component_search,
		    	 intfk_hardware_software_id:$scope.log_hardware_software_search,
		    	 str_system_name:$scope.log_hardware_systemname_search,
		    	 mode:"getHardwareSearch"	
		    },
		
		});
		request.success(function (data) {
		
			$scope.Hardwares=data;
		});
	}
	$scope.getLogDialogSelectedHardware=function($str_syatem_id){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	str_system_id:$str_syatem_id,
		    	 mode:"getHardware"	
		    },
		
		});
		request.success(function (data) {
			$scope.SelectedHardwareId=data[0]['intpk_hardware_id'];
			$scope.SelectedHardwareSyatemId=data[0]['str_system_id'];
			$scope.LogGetSelectedSoftwareRecords='';
			$scope.HardwareComponents='';
			$intpk_hardware_id=$('#log_Hardware').attr('name',data[0]['intpk_hardware_id']);
			$scope.log_hardware_type_copy=data[0]['intpk_hardware_type_id'];
			$scope.log_hardware_plant=data[0]['intpk_plant_id'];
			$scope.log_hardware_service_tag=data[0]['str_service_tag'];
			$scope.log_hardware_system_id=data[0]['str_system_id'];
			$scope.log_hardware_active=data[0]['bln_active'];
			$scope.log_hardware_serial_no=data[0]['str_hw_serial_no'];
			$scope.log_hardware_rdp=data[0]['bln_rdp'];
			$scope.log_hardware_tcmp=data[0]['bln_tcmp'];
			$scope.log_hardware_system_name=data[0]['str_system_name'];
			$scope.log_hardware_admin_pswd=data[0]['str_admin_pswd'];
			
			$size=data.length;
			$scope.log_hardware_component_copy = [];
			
			$scope.HardwareComponents=data;
			for($cnt=0;$cnt<$size;$cnt++){
				$scope.log_hardware_component_copy.push(data[$cnt]['infk_component_id']);
				$addCompTxtBox=data[$cnt]['infk_component_id'];
				$scope['HardwareAddComponent'+$addCompTxtBox]=data[$cnt]['str_serial_no'];
			}
			
			var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogHardware.php",
			    data: {  
			    	 intpk_hardware_id:data[0]['intpk_hardware_id'],
			    	 mode:"getSelectedHardwareIpAddress"	
			    },
			
			});
			request.success(function (data) {
				$('#HardwareIpTable').empty();
				$("#HardwareIpTable").attr('name',"0");
				if(data!=null && data!='null'){
					$size=$size=Object.keys(data).length;
					for($cnt=1;$cnt<=$size;$cnt++){
						$scope.addIpRow();
						$("#hardware_ip_desc_"+$cnt).attr("name",data[$cnt-1]['intpk_ip_address_id'])
						$scope["hardware_ip_desc_"+$cnt]=data[$cnt-1]['str_ip_desc'];
						$scope["hardware_ip_address_"+$cnt]=data[$cnt-1]['str_ip_address'];
					}
				}
				
			
				
			});
			

				 var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogSoftware.php",
					    data: {  
					    	 intfk_hardware_id:data[0]['intpk_hardware_id'],
					    	 mode:"logMapHwSwSoftwareSelectedItem"	
					    },
					
					});
					request.success(function (data) {
						if(data!='null'){
							$scope.LogGetSelectedSoftwareRecords=data;
							$size=Object.keys(data).length;
							
							$scope.log_map_hw_sw_software = [];
							for($cnt=0;$cnt<$size;$cnt++){
								$scope.log_map_hw_sw_software.push(data[$cnt]['intfk_software_record_id']);
								$scope['logMapHwSwAdd'+data[$cnt]['intfk_software_record_id']]=data[$cnt]['licence_no'];
							}
							
						}
				});
					$scope.log_hardware_user_hardware=data[0]['intpk_hardware_id'];
					$scope.log_peripheral_main_hw=data[0]['intpk_hardware_id'];
					
					//----------------------For Hardware Users load-------------------------------------
					
						var request = $http({
						    method: "post",
						    url: "./inc/ajaxIncludes/ajxLogHardware.php",
						    data: {  
						    	 intpk_hardware_id:$scope.log_hardware_user_hardware,
						    	 mode:"getSelectedHardwareUsers"	
						    },
						
						});
						request.success(function (data) {
							
							$scope.HardwareSelectedUsers=data;
							$("#log_hardware_user").attr('name',$scope.log_hardware_user_hardware);
						});
						
					//---------------------For Hardware Peripheral load---------------------------------
						
						var request = $http({
						    method: "post",
						    url: "./inc/ajaxIncludes/ajxLogHardware.php",
						    data: {  
						    	 intfk_hardware_id:$scope.log_peripheral_main_hw,
						    	 mode:"getSelectedHardwarePeripheral"	
						    },
						
						});
						request.success(function (data) {	
							$scope.ForMainselectedHardwares==data;
						});
					
			
			
		});
	}
	
	$scope.addIpRow=function(){
	
			$scope.counter=parseInt($("#HardwareIpTable").attr('name'))+1;
			
			 // var newRow = $("<tr id='hw_ip_row_"+$scope.counter+"'>");
			$append='';
			$append += '<tr class="dynamic_row" id="hw_ip_row_'+$scope.counter+'">';
			$append += '<td><input id="hardware_ip_desc_'+$scope.counter+'" name="" ng-model="hardware_ip_desc_'+$scope.counter+'"  type="text" style="width: 250px" class="form-control"  name="hardware_ip_desc_' + $scope.counter + '"/></td>';
			$append += '<td><input id="hardware_ip_address'+$scope.counter+'" name="" ng-model="hardware_ip_address_'+$scope.counter+'" type="text" style="width: 190px" class="form-control"  name="hardware_ip_address_' + $scope.counter + '"/></td>';

			$append += '<td><button id="remove_hardware_ip_id_'+$scope.counter+'" ng-click="remRow($event)" class="ibtnDel fa fa-trash-o btn btn-md btn-danger" type="button"></button></td></tr>';
		        var element2=$compile($append)($scope);
		        $("#HardwareIpTable").append(element2);
		        $("#HardwareIpTable").attr('name',$scope.counter);

	}
	
	$scope.remRow=function(input){
		$id=input.target.id;
		$removed_id=parseInt($id.substring(22,$id.length));
		$totalrow= parseInt($("#HardwareIpTable").attr('name'));
	    $scope.counter=parseInt($("#HardwareIpTable").attr('name'))-1;
	    $("#HardwareIpTable").attr('name',$scope.counter);
	    $('#hw_ip_row_'+$removed_id).remove();
	    var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 intpk_ip_address:$removed_id,
		    	 mode:"deleteHardwareIp"	
		    },
		
		});
		request.success(function (data) {
			
		});

	}

	$scope.logHardwareIp=function(){
		
	}
	
//---------------------------Hardware Peripheral------------------------------------------
	
	$scope.getAllHardware=function(){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {   
		    	 mode:"getAllHardware"	
		    },
		
		});
		request.success(function (data) {
			
			$scope.AllHardwares=data;
		});
	}
	
	$scope.getSelectedHardwarePeripheral=function($peripheral_main_hw){
		
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 intpk_hardware_id:$peripheral_main_hw,
		    	 mode:"getSelectedHardwarePeripheral"	
		    },
		
		});
		request.success(function (data) {
			$scope.log_peripheral_connect_hw=[];
			if(data!='null'){
				$scope.ForMainselectedHardwares=data;
				$size=$scope.ForMainselectedHardwares.length;
				for($cnt=0;$cnt<$size;$cnt++){
					$scope.log_peripheral_connect_hw.push(data[$cnt]['intpk_hardware_id']);
				}
				
			}else
				$scope.ForMainselectedHardwares='';	
		});
	}
	$scope.logHardwarePeripheralDialogsearch=function($peripheral_main_hw){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 intpk_hardware_id:$scope.log_peripheral_search_hw,
		    	 mode:"getlogHardwarePeripheralDialogsearch"	
		    },
		
		});
		request.success(function (data) {
			
			$("#PeripheralHardwareList tr").detach();
			//$("#PeripheralHardwareList").empty();
			if(data!="null")
				$scope.PeripheralHardwares=data;
		});
	}
	$scope.getLogDialogSelectedHardwarePeripheral=function($peripheral_main_hw){
		$scope.log_peripheral_main_hw=$peripheral_main_hw;
		$scope.getSelectedHardwarePeripheral($peripheral_main_hw);
	}
	
	$scope.logHardwarePeripheralDelete=function($intpk_peripheral_id){
		var request = $http({
		    method: "post",
		    url: "./inc/ajaxIncludes/ajxLogHardware.php",
		    data: {  
		    	 intpk_peripheral_id:$intpk_peripheral_id,
		    	 mode:"logHardwarePeripheralDelete"	
		    },
		
		});
		request.success(function (data) {
			$scope.getLogDialogSelectedHardwarePeripheral($scope.log_peripheral_search_hw);
			$scope.logHardwarePeripheralDialogsearch($scope.log_peripheral_search_hw);
		});
	}
	
	$scope.allConnectHWSelectItem=function(){
		var LogHardwareConnectArrayList=new Object;
		$addcnt=0;
		$size1=$scope.log_Hardware_connect_add_all_item.length;
		$size2=$scope.AllHardwares.length;
		for($cnt1=0;$cnt1<$size1;$cnt1++){
			for($cnt2=0;$cnt2<$size2;$cnt2++){
				if($scope.AllHardwares[$cnt2]['intpk_hardware_id']==$scope.log_Hardware_connect_add_all_item[$cnt1]){
					LogHardwareConnectArrayList[$addcnt]=$scope.AllHardwares[$cnt2];
					$addcnt++;
				}
			}
		}
		
		$scope.ForMainselectedHardwares=LogHardwareConnectArrayList;
		$size=Object.keys($scope.ForMainselectedHardwares).length;
		$scope.log_peripheral_connect_hw=[];
		for($cnt=0;$cnt<$size;$cnt++){
			
			$scope.log_peripheral_connect_hw.push($scope.ForMainselectedHardwares[$cnt]['intpk_hardware_id']);
			
		}
		
		/* setTimeout(function(){
			 $('#log_peripheral_connect_hw_multiselect option').prop('selected', true);
			 console.log($scope.log_peripheral_connect_hw);
		 }, 200);*/
		
		    
	}
	
	$scope.openPopUpToSelectHardwareConnect=function(){
		if($scope.log_peripheral_connect_hw!=undefined){
			$size1=$scope.log_peripheral_connect_hw.length;
			$size2=$scope.AllHardwares.length;
			$scope.log_Hardware_connect_add_all_item=[];
			for($count1=0;$count1<$size1;$count1++){
				for($count2=0;$count2<$size2;$count2++){
					if(parseInt($scope.AllHardwares[$count2]['intpk_hardware_id'])==parseInt($scope.log_peripheral_connect_hw[$count1]))
						$scope.log_Hardware_connect_add_all_item.push($scope.log_peripheral_connect_hw[$count1]);
				}
			}
		}
	}
	
	$scope.deleteHardwarePeripheralConnect=function(){
		if($scope.log_peripheral_main_hw!=undefined){
			$size=$scope.log_peripheral_connect_hw.length;
			if($size!=1)
				$("#log_delete_hardware_peripheral_connect").notify("Please choose one at a time","error");
			else{
				if($scope.log_peripheral_main_hw!=undefined){
					var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogHardware.php",
					    data: {  
					    	 intfk_hardware_main_id:$scope.log_peripheral_main_hw,
					    	 intfk_hardware_connect_id:$scope.log_peripheral_connect_hw[0],
					    	 mode:"deleteHardwarePeripheralConnect"	
					    },
					
					});
					request.success(function (data) {
						$scope.getSelectedHardwarePeripheral($scope.log_peripheral_main_hw);
					});
				}
				else{
					$("#log_delete_hardware_peripheral_connect").notify("Item not saved cannot be deleted","error");
				}
			}
		}else{
			$("#log_delete_hardware_peripheral_connect").notify("Item not found","error");
		}
	}
//----------------------------------------Hardware User-----------------------------------------------
	
	$scope.logHardwareAllUsers=function(){
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogUser.php",
			    data: {  	
			    	 mode:"getAllUsers"	
			    },
			
			});
			request.success(function (data) {
				
				$scope.HardwareAllUsers=data
			});
	}
	
	$scope.logHardwareUserDialogsearch=function(){

		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogHardware.php",
			    data: {  
			    	 str_first_name:$scope.log_hardware_user_firstname_search,
			    	 str_system_name:$scope.log_hardware_system_name_search,
			    	 mode:"getSelectedUserHardware"	
			    },
			
			});
			request.success(function (data) {
				$scope.SelectedHardwareUsers=data;
			
			});
	}
	
	$scope.getSelectedHardwareUser=function(intpk_hardware_id){
		$("#log_hardware_user").attr('name',intpk_hardware_id);
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogHardware.php",
			    data: {  
			    	 intpk_hardware_id:intpk_hardware_id,
			    	 mode:"getSelectedHardwareUsers"	
			    },
			
			});
			request.success(function (data) {
				
				$scope.HardwareSelectedUsers=data;
				$scope.log_hardware_user_user=[];
				$scope.log_hardware_user_user.push(data[0]['intpk_user_id']);
				$scope.log_hardware_user_password=data[0]['str_password'];
				$scope.log_hardware_user_printer=data[0]['str_local_printer_rights'];
			});
	}
	
	$scope.allUsersSelectItem=function(){
		var LogHardwareUserArrayList=new Object ;
		$addcnt=0;
		$size1=$scope.log_all_user.length;
		$size2=$scope.HardwareAllUsers.length;
		for($cnt1=0;$cnt1<$size1;$cnt1++){
			for($cnt2=0;$cnt2<$size2;$cnt2++){
				if($scope.HardwareAllUsers[$cnt2]['intpk_user_id']==$scope.log_all_user[$cnt1]){
					LogHardwareUserArrayList[$addcnt]=$scope.HardwareAllUsers[$cnt2];
					$addcnt++;
				}
			}
		}
		
		$scope.HardwareSelectedUsers=LogHardwareUserArrayList;
	}
	
	$scope.mapAllUsers=function(){
		if($scope.HardwareSelectedUsers!=undefined){
			$size1=$scope.HardwareSelectedUsers.length;			
			$scope.log_all_user=[];
			for($cnt1=0;$cnt1<$size1;$cnt1++){
				$scope.log_all_user.push($scope.HardwareSelectedUsers[$cnt1]['intfk_user_id']);
			}
		}
		
	}
	$scope.getLogDialogSelectedHardwareUser=function($intpk_user_hardware_id){
		
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogHardware.php",
			    data: {  
			    	 intpk_user_hardware_id:$intpk_user_hardware_id,
			    	 mode:"getLogDialogSelectedHardwareUser"	
			    },
			
			});
			request.success(function (data) {
		
				$scope.HardwareSelectedUsers=data;
				$("#log_hardware_user").attr('name',data[0]['intpk_user_hardware_id']);
				$scope.log_hardware_user_hardware=data[0]['intfk_hardware_id'];
				$scope.log_hardware_user_user=[];
				$scope.log_hardware_user_user.push=data[0]['intpk_user_id'];
				$scope.log_hardware_user_password=data[0]['str_password'];
				$scope.log_hardware_user_printer=data[0]['str_local_printer_rights'];
			});
	}
	
	$scope.getUserHardwareData=function(){
	
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogHardware.php",
			    data: {  
			    	 intpk_hardware_id:$scope.log_hardware_user_hardware,
			    	 intpk_user_hardware_id:$scope.log_hardware_user_user[0],
			    	 mode:"getUserHardwareData"	
			    },
			
			});
			request.success(function (data) {
				$scope.log_hardware_user_password=data[0]['str_password'];
				$scope.log_hardware_user_printer=data[0]['str_local_printer_rights'];
			});
	}
	
	$scope.logHardwareUserDelete=function($intpk_user_hardware){
		 var request = $http({
			    method: "post",
			    url: "./inc/ajaxIncludes/ajxLogHardware.php",
			    data: {  
			    	 intpk_user_hardware_id:$intpk_user_hardware,
			    	 mode:"DeleteHardwareUser"	
			    },
			
			});
			request.success(function (data) {
				$('#hardware_user_find').empty();
				$scope.logHardwareUserDialogsearch();
			});
	}
	
	$scope.deleteHardwareUserSelectedItem=function(){
		if($scope.log_hardware_user_user!=undefined){
			$size=$scope.log_hardware_user_user.length;
			if($size!=1)
				$("#log_delete_hardware_user_selected_item").notify("Please choose one at a time","error");
			else{
				if($scope.log_hardware_user_hardware!=undefined){
					var request = $http({
					    method: "post",
					    url: "./inc/ajaxIncludes/ajxLogHardware.php",
					    data: {  
					    	 intfk_hardware_id:$scope.log_hardware_user_hardware,
					    	 intfk_user_id:$scope.log_hardware_user_user[0],
					    	 mode:"deleteHardwareSelectedUser"	
					    },
					
					});
					request.success(function (data) {
						$scope.getSelectedHardwareUser($scope.log_hardware_user_hardware)
					});
				}
				else{
					$("#log_delete_hardware_user_selected_item").notify("Item not saved cannot be deleted","error");
				}
			}
		}else{
			$("#log_delete_hardware_user_selected_item").notify("Item not found","error");
		}
	}
	
});



