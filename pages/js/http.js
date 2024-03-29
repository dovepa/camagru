//////////////////////////////////////////////////////////////
//                    GET AJAX
//////////////////////////////////////////////////////////////

var getHttpRequest = function () {
	var httpRequest = false;

	if (window.XMLHttpRequest) { // Mozilla, Safari,...
	  httpRequest = new XMLHttpRequest();
	  if (httpRequest.overrideMimeType) {
		httpRequest.overrideMimeType('html');
	  }
	}
	else if (window.ActiveXObject) { // IE
	  try {
		httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
	  }
	  catch (e) {
		try {
		  httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch (e) {}
	  }
	}

	if (!httpRequest) {
	  alert('XMLHTTP impossible');
	  return false;
	}

	return httpRequest
  }
