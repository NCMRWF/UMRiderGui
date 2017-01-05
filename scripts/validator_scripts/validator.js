// project: xml2web
// author : SOMJEET DASGUPTA .  3/6/2016

//=========================================================================//
function descriptor(obj){
  var getter = obj.innerHTML;

  var ID = (getter);

  var ele = document.getElementById(ID);
  document.getElementById("descript").innerHTML = ele.value;
}

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
      obj.value = null;
			obj.focus();
		}
	}
	else if(obj.name == 'End_date'){
		var startdate = document.getElementsByName('Start_date')[0].value;
    //alert(startdate + "  " + obj.value);
		if(startdate == null || startdate == ""){
			alert('please enter start date first');
      obj.value = null;
			document.getElementsByName('Start_date')[0].focus();
		}
		else if(entered > today){
			alert('please enter a valid end date that is on or before today');
      obj.value = null;
			obj.focus();
		}
		else if(startdate > entered){
			alert('please enter a valid end date that is on or after start date');
      obj.value = null;
			obj.focus();
		}
	}
}

function toggle_date(){
  //alert('called');
}

function editorpop(obj){
//alert(document.getElementsByClassName(obj.id)[0].style.display);
  var editor_divs = document.getElementsByClassName("editor");
  for(var i=0; i<editor_divs.length; i++){
    if(editor_divs[i] == document.getElementsByClassName(obj.id)[0]){

      if(editor_divs[i].style.display == "none"){
        editor_divs[i].style.display = "block";
        //alert("setting to none");
      }
      else{
        //alert("setting to none");
        editor_divs[i].style.display = "none";
      }
      continue;
    }
    editor_divs[i].style.display = "none"
  
}
}


function editorsave(obj){
  //alert(obj.className);
  //var editor = obj.childNodes[0];
  //var divclass = obj.className;
  //var input_name = (divclass.split(" "))[0];
//  var currentVal = obj.value;
  //  if(currentVal == oldVal) {
    //    return; //check to prevent multiple simultaneous triggers
   // }

   // oldVal = currentVal;
    //action to be performed on textarea changed
    //    alert("changed!");  

  document.getElementsByName(obj.name)[0].value = obj.value;

//alert(document.getElementsByName(obj.name)[0].value);
}
