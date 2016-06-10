function descriptor(obj){
  var getter = obj.innerHTML;
  var ID = (getter.slice(0, -2)).trim();

  var ele = document.getElementById(ID);
  document.getElementById("descript").innerHTML = ele.value;
}

function clear_descript(){
  document.getElementById("descript").innerHTML = '';
}
