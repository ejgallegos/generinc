  var t=false;
  function contar(){
  if(t)clearTimeout(t);
  s=arguments[0] || 0;
  if(s>10)location.reload();
  s++;
  t=setTimeout("contar("+s+")",3000);
  }
  window.onload=document.onmousemove=contar;
