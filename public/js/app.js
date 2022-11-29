
//webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var rec; 							//Recorder.js object
var input; 							//MediaStreamAudioSourceNode we'll be recording

// shim for AudioContext when it's not avb.
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext //audio context to help us record

var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");
// var pauseButton = document.getElementById("pauseButton");

var cancelButton = document.getElementById("cancelButton");
var playButton = document.getElementById("playButton");



//add events to those 2 buttons
recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);
// pauseButton.addEventListener("click", pauseRecording);

cancelButton.addEventListener("click", cancelRecording);
playButton.addEventListener("click", playRecording);



function cancelRecording(){
	if (confirm("삭제 하시겠습니까?")){
		$("#start_div").removeClass('none');
		$("#stop_div").addClass('none');
		$("#upload_div").addClass('none');
		$("#send_div").addClass('none');


	}

}

function playRecording(){
	document.getElementById('debate_wav').play();
}



function startRecording() {

	$("#start_div").addClass('none');
	$("#stop_div").removeClass('none');
	/*
		Simple constraints object, for more advanced audio features see
		https://addpipe.com/blog/audio-constraints-getusermedia/
	*/

    var constraints = { audio: true, video:false }

 	/*
    	Disable the record button until we get a success or fail from getUserMedia()
	*/

	// recordButton.disabled = true;
	// stopButton.disabled = false;
	// pauseButton.disabled = false

	/*
    	We're using the standard promise based getUserMedia()
    	https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
	*/

	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		console.log("getUserMedia() success, stream created, initializing Recorder.js ...");

		/*
			create an audio context after getUserMedia is called
			sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
			the sampleRate defaults to the one set in your OS for your playback device

		*/
		audioContext = new AudioContext();

		//update the format
		document.getElementById("formats").innerHTML="Format: 1 channel pcm @ "+audioContext.sampleRate/1000+"kHz"

		/*  assign to gumStream for later use  */
		gumStream = stream;

		/* use the stream */
		input = audioContext.createMediaStreamSource(stream);

		/*
			Create the Recorder object and configure to record mono sound (1 channel)
			Recording 2 channels  will double the file size
		*/
		rec = new Recorder(input,{numChannels:1})

		//start the recording process
		rec.record()

		console.log("Recording started");

	}).catch(function(err) {
		alert("마이크 권한을 허용해 주세요.");
		$("#stop_div").addClass('none');
		$("#start_div").removeClass('none');
		$("#send_div").addClass('none');

	  	//enable the record button if getUserMedia() fails
    	// recordButton.disabled = false;
    	// stopButton.disabled = true;
    	// pauseButton.disabled = true
	});
}

// function pauseRecording(){
// 	console.log("pauseButton clicked rec.recording=",rec.recording );
// 	if (rec.recording){
// 		//pause
// 		rec.stop();
// 		pauseButton.innerHTML="Resume";
// 	}else{
// 		//resume
// 		rec.record()
// 		pauseButton.innerHTML="Pause";
//
// 	}
// }

function stopRecording() {

	//disable the stop button, enable the record too allow for new recordings
	// stopButton.disabled = true;
	// recordButton.disabled = false;
	// pauseButton.disabled = true;

	$("#send_div").removeClass('none');
	$("#start_div").addClass('none');
	$("#stop_div").addClass('none');
	$("#upload_div").removeClass('none');

	//reset button just in case the recording is stopped while paused
	// pauseButton.innerHTML="Pause";

	//tell the recorder to stop the recording
	rec.stop();

	//stop microphone access
	gumStream.getAudioTracks()[0].stop();

	//create the wav blob and pass it on to createDownloadLink
	rec.exportWAV(createDownloadLink);

}

function getTimeStringSeconds(seconds){

	var hour, min, sec
	hour = Math.round(parseInt(seconds / 3600));
	min = Math.round(parseInt(seconds % 3600) / 60);
	sec = Math.round(seconds % 60);
	if (hour.toString().length == 1) hour = "0" + hour;
	if (min.toString().length == 1) min = "0" + min;
	if (sec.toString().length == 1) sec = "0" + sec;

	if(isNaN(min)) {
		min = '00';
	}
	if(isNaN(sec)) {
		sec = '00';
	}
	return min + ":" + sec;
}
function formatBytes(bytes, decimals = 2) {
	if (bytes === 0) return '0 Bytes';

	const k = 1024;
	const dm = decimals < 0 ? 0 : decimals;
	const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

	const i = Math.floor(Math.log(bytes) / Math.log(k));

	return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}


function createDownloadLink(blob) {
	var room_idx = $("#room_idx").val();
	if (blob.size > 10000000){
		alert('파일 사이즈가 10MB를 초과 할수 없습니다.');
		return;
	}

	var url = URL.createObjectURL(blob);
	var au = document.createElement('audio');
	var li = document.createElement('li');
	var link = document.createElement('a');

	//name of .wav file to use during upload and download (without extendion)
	var filename = new Date().toISOString();

	//add controls to the <audio> element
	au.controls = true;
	au.src = url;
	au.id = 'debate_wav';
	au.file_name = filename+".wav";


	//save to disk link
	link.href = url;
	link.download = filename+".wav"; //download forces the browser to donwload the file using the  filename
	link.innerHTML = "Save to disk";

	//add the new audio element to li
	li.appendChild(au);



	//add the filename to the li
	li.appendChild(document.createTextNode(filename+".wav "))

	//add the save to disk link to li
	li.appendChild(link);

	//upload link
	var upload = document.createElement('a');
	upload.href = "#";
	upload.innerHTML = "Upload";
	upload.addEventListener("click", function(event){
		  // var xhr=new XMLHttpRequest();
		  // xhr.onload=function(e) {
		  //     if(this.readyState === 4) {
		  //         console.log("Server returned: ",e.target.responseText);
		  //     }
		  // };
		  // var fd=new FormData();
		  // fd.append("audio_data",blob, filename+".wav");
		  // fd.append("room_idx", 1);
		  // xhr.open("POST","/upload/debate",true);
		  // xhr.send(fd);
	})

	li.appendChild(document.createTextNode (" "))//add a space in between
	li.appendChild(upload)//add the upload link to li

	//add the li element to the ol
	// recordingsList.appendChild(li);
	//하나만 생성하게 처리
	$("#recordingsList").html(li)


	//업로드 처리
	var uploadButton = document.createElement("button");
	uploadButton.classList.add('btn-voice-send');

	uploadButton.addEventListener("click",function(event){
		var audio 		 = document.getElementById('debate_wav');
		var duration     = getTimeStringSeconds(audio.duration);

		var xhr=new XMLHttpRequest();
		xhr.onload=function(e) {

			if (xhr.status == 200) {
				let result = xhr.response;
				result = JSON.parse(result); // JSON 타입으로 파싱해준다

				if (result.status == 'success'){
					sendMessage(duration, result.file_src);

				}else if (result.status == 'logout'){
					alert('로그인 후 이용바랍니다.');
				}else{
					alert('오류가 발생되었습니다.\n잠시 후 이용 바랍니다.');
				}
				$("#start_div").removeClass('none');
				$("#send_div").addClass('none');
				$("#stop_div").addClass('none');
				$("#upload_div").addClass('none');
			} else {
				//this.status
				alert("오류가 발생 되었습니다.\n잠시후 이용바랍니다.");
			}
		};

		var fd=new FormData();
		fd.append("audio_data",blob, filename+".wav");
		fd.append("room_idx", room_idx);
		fd.append("duration", duration);
		xhr.open("POST","/upload/debate",true);
		xhr.send(fd);
	})

	$('#upload_div').html(uploadButton)
}