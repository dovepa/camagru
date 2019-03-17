	var tp = document.getElementById("startbutton");
	var f1rs = document.getElementById("f1rs");
	var f2rs = document.getElementById("f2rs");
	var f3rs = document.getElementById("f3rs");
	var f1rs2 = document.getElementById("f1rs2");
	var f2rs2 = document.getElementById("f2rs2");
	var f3rs2 = document.getElementById("f3rs2");
	var filter = document.getElementById("filter");

	function box(ch)
	{
		if (ch.id == "f1box")
		{
			f1rs.style.display = 'block';
			f2rs.style.display = 'none';
			f3rs.style.display = 'none';
			f1rs2.style.display = 'block';
			f2rs2.style.display = 'none';
			f3rs2.style.display = 'none';
			filter.value = ch.value;
		} else if (ch.id == "f2box") {
			f1rs.style.display = 'none';
			f2rs.style.display = 'block';
			f3rs.style.display = 'none';
			f1rs2.style.display = 'none';
			f2rs2.style.display = 'block';
			f3rs2.style.display = 'none';
			filter.value = ch.value;
		} else if (ch.id == "f3box")
		{
			f1rs.style.display = 'none';
			f2rs.style.display = 'none';
			f3rs.style.display = 'block';
			f1rs2.style.display = 'none';
			f2rs2.style.display = 'none';
			f3rs2.style.display = 'block';
			filter.value = ch.value;
		}
		tp.style.display = 'block';
	}

(function() {

	var notcam = document.getElementById("notcam");
	var yescam = document.getElementById("yescam");
	var sub = document.getElementById("Submit");

	var imagetake = document.getElementById("imagetake");

	var streaming = false,
		video        = document.querySelector('#video'),
		cover        = document.querySelector('#cover'),
		canvas       = document.querySelector('#canvas'),
		photo        = document.querySelector('#photo'),
		startbutton  = document.querySelector('#startbutton'),
		width = 1920,
		height = 1080;


	navigator.getMedia = ( navigator.getUserMedia ||
			navigator.webkitGetUserMedia ||
			navigator.mozGetUserMedia ||
			navigator.msGetUserMedia ||
			navigator.oGetUserMedia);




	navigator.mediaDevices.getUserMedia(
	  {
		video: true,
		audio: false
	  })
	  .then(function(stream) {
		if (navigator.mozGetUserMedia) {
		  video.mozSrcObject = stream;
		} else {
		  var vendorURL = window.URL || window.webkitURL;
		  video.src = vendorURL.createObjectURL(stream);
		}
		video.play();
		if (stream)
		{
			yescam.style.display = 'block';
			notcam.style.display = 'none';
		}else{
			yescam.style.display = 'none';
			notcam.style.display = 'block';
		}
	  });

	video.addEventListener('canplay', function(ev){
	  if (!streaming) {
		height = video.videoHeight / (video.videoWidth/width);
		video.setAttribute('width', width);
		video.setAttribute('height', height);
		canvas.setAttribute('width', width);
		canvas.setAttribute('height', height);
		streaming = true;
	  }
	}, false);

	function takepicture() {
	  canvas.width = width;
	  canvas.height = height;
	  canvas.getContext('2d').drawImage(video, 0, 0, width, height);
	  var data = canvas.toDataURL('image/jpg');
	  imagetake.value = data;
	  sub.style.display = 'block';
	  photo.setAttribute('src', data);
	}

	startbutton.addEventListener('click', function(ev){
		takepicture();
	  ev.preventDefault();
	}, false);

  })();
