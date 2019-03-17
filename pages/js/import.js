var f1rs = document.getElementById("f1rs");
var f2rs = document.getElementById("f2rs");
var f3rs = document.getElementById("f3rs");
var f1rs2 = document.getElementById("f1rs2");
var f2rs2 = document.getElementById("f2rs2");
var f3rs2 = document.getElementById("f3rs2");
var submit = document.getElementById("sub");

function box(box){
  if (box === 'f1box')
  {
	f1rs2.style.display = "block";
	f2rs2.style.display = "none";
	f3rs2.style.display = "none";
	submit.style.display = "block";
  }else if (box === 'f2box')
  {
	f2rs2.style.display = "block";
	f1rs2.style.display = "none";
	f3rs2.style.display = "none";
	submit.style.display = "block";
  }else
  {
	f3rs2.style.display = "block";
	f2rs2.style.display = "none";
	f1rs2.style.display = "none";
	submit.style.display = "block";
  }
}