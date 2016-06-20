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
function clear_descript(){
  //document.getElementById("descript").innerHTML = '';
}
