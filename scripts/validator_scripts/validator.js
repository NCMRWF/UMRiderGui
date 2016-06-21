function descriptor(obj){
  var getter = obj.innerHTML;

  var ID = (getter);

  var ele = document.getElementById(ID);
  document.getElementById("descript").innerHTML = ele.value;
}
/*
function descriptor_vars(obj){
  var getter = obj.innerHTML;
  var str_arr = getter.split(" ");
  getter = str_arr[0]
  var ID = (getter).trim();

  var ele = document.getElementById(ID);
  document.getElementById("descript").innerHTML = ele.value;
}
*/

function check_all(){
  var inputs = document.getElementsByTagName('input');

  for(var i = 0; i < inputs.length; i++) {
      if(inputs[i].type.toLowerCase() == 'checkbox') {
          inputs[i].checked = true;
      }
  }
}

function clear_descript(){
  //document.getElementById("descript").innerHTML = '';
}

function datechecker(obj){
	var entered = (obj.value);
	var today = document.getElementById("checkdate").value;

  //alert ("entered: "+entered+ "  today: "+today);
	if(obj.name == 'Start_date'){
		if(entered > today){
			alert('please enter a valid start date that is on or before today');
			obj.focus();
		}
	}
	else if(obj.name == 'End_date'){
		var startdate = document.getElementsByName('Start_date')[0].value;
    //alert(startdate + "  " + obj.value);
		if(startdate == null || startdate == ""){
			alert('please enter start date first');
			document.getElementsByName('Start_date')[0].focus();
		}
		else if(entered > today){
			alert('please enter a valid end date that is on or before today');
			obj.focus();
		}
		else if(startdate > entered){
			alert('please enter a valid end date that is on or after start date');
			obj.focus();
		}
	}
}
